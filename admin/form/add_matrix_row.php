<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/
	require('includes/init.php');
	
	require('config.php');
	require('includes/db-core.php');
	require('includes/helper-functions.php');
	require('includes/check-session.php');

	require('includes/filter-functions.php');
	
	$dbh = mf_connect_db();
	

	$form_id				= (int) $_POST['form_id'];
	$row_position			= (int) $_POST['position']; //the position of the new row within matrix table
	$matrix_parent_id		= (int) $_POST['matrix_parent_id'];
	$allow_multiselect		= (int) $_POST['allow_multiselect'];
	$row_holder_id			= trim($_POST['row_holder_id']);
	$prop_holder_id			= trim($_POST['prop_holder_id']);
	$total_column			= (int) $_POST['total_column'];
	$rows_titles			= mf_sanitize($_POST['rows_titles']); //if this array exist, then bulk insert rows is happening
	$column_data			= mf_sanitize($_POST['column_data']);
	
	
	//adding a new matrix row is basically the same as adding a new checkbox/radio button field
	//the only difference is that the field type is 'matrix' and it has parent id
	
	if(!empty($rows_titles)){
		$is_multi_rows = true;
	}else{
		$is_multi_rows = false;
	}
	
	//get element id for this new element
	$query  = "select ifnull(max(`element_id`),0) + 1 as new_element_id from ".MF_TABLE_PREFIX."form_elements where form_id = ?";
	$params = array($form_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
	
	$element_id = $row['new_element_id'];
	
	//set default field properties
	$element_properties['matrix_parent_id'] = $matrix_parent_id;
	
	$element_properties['title'] 		= '';
	$element_properties['guidelines'] 	= '';
	$element_properties['size'] 		= 'medium';
	$element_properties['is_required'] 	= '0';
	$element_properties['is_unique'] 	= '0';
	$element_properties['is_private'] 	= '0';
	$element_properties['type'] 		= 'matrix';
	$element_properties['position'] 	= '0';
	$element_properties['default_value'] = '';
	$element_properties['constraint'] 	 = '';
	$element_properties['total_child'] 	 = '0';
	$element_properties['css_class'] 	 = '';
	$element_properties['range_min'] 	 = '0';
	$element_properties['range_max'] 	 = '0';
	$element_properties['range_limit_by'] 	= 'c'; //possible values: 'c' - characters ; 'w' - words
	$element_properties['status'] 	 		= '2'; //2 means 'draft' which is not active yet. 1 means live. 0 means deleted
	
	if($is_multi_rows){
		$total_row = count($rows_titles);
	}else{
		$total_row = 1;
	}
	
	for($i=1;$i<=$total_row;$i++){
		
		$field_list = '';
		$field_values = '';

		$element_properties['id'] = $element_id;
		$all_rows_element_id[] = $element_id;
		
		if($is_multi_rows){
			$element_id++;
			$element_properties['title'] = $rows_titles[$i-1];
		}
		
		//dynamically create the field list and field values, based on the input given
		$params = array();
		foreach ($element_properties as $key=>$value){
			$field_list    .= "`element_{$key}`,";
			$field_values  .= ":element_{$key},";
			$params[':element_'.$key] = $value;
		}
			
		$field_list   .= "`form_id`";
		$field_values .= ":form_id";
		$params[':form_id'] = $form_id;
		
		//insert into ap_form_elements  table
		$query = "INSERT INTO `".MF_TABLE_PREFIX."form_elements` ($field_list) VALUES ($field_values);"; 
		mf_do_query($query,$params,$dbh);
		
		//insert into ap_element_options table, depends on the number of columns
		$query = "INSERT INTO 
							`".MF_TABLE_PREFIX."element_options` 
								(`form_id`,
								 `element_id`,
								 `option_id`,
								 `position`,
								 `option`,
								 `option_is_default`,
								 `live`) 
					  VALUES (:form_id,
							  :element_id,
							  :option_id,
				   	  	      :position,
				    		  :option,
							  '0',
							  '2');"; 
		
		foreach ($column_data as $option_id=>$data){
			$params = array(':form_id' => $form_id,
							':element_id' => $element_properties['id'],
							':option_id' => $option_id ,
							':position' => $data['position'],							
							':option' => $data['column_title']);
			mf_do_query($query,$params,$dbh);
		}
		
		
	}
	
	
	//generate response data
	$response_data = new stdClass();
	
	$response_data->status    	= "ok";
	$response_data->element_id	= $element_id;
	$response_data->row_holder_id	= $row_holder_id;
	$response_data->prop_holder_id	= $prop_holder_id;
	
	if(!empty($allow_multiselect)){
		$input_type = 'checkbox';
	}else{
		$input_type = 'radio';
	}
	
	$row_markup = '';
	
	for($rownum=1;$rownum<=$total_row;$rownum++){
		
		if($is_multi_rows){
			$current_title = $rows_titles[$rownum-1];
		}else{
			$current_title = '&nbsp;';
		}
		
		//build row markup
		$row_markup .= "<tr id=\"mr_{$all_rows_element_id[$rownum-1]}\"><td class=\"first_col\">{$current_title}</td>";
		for($i=1;$i<=$total_column;$i++){
			$row_markup .= "<td><input type=\"{$input_type}\" value=\"{$i}\" name=\"element_{$all_rows_element_id[$rownum-1]}\" id=\"element_{$all_rows_element_id[$rownum-1]}_{$i}\"></td>";
		}
		$row_markup .= '</tr>';
	}
	
	$response_data->new_row_markup = $row_markup;
	
	//build the property markup
	$prop_markup = <<<EOT
<li>
	<input type="text" id="matrixrow_{$element_id}" class="text" autocomplete="off" value=""> 
	<img id="matrixrowadd_{$element_id}" style="vertical-align: middle;" src="images/icons/add.png" alt="Add" title="Add" class="add_choice"><img id="matrixrowdel_{$element_id}" style="vertical-align: middle;" src="images/icons/delete.png" alt="Delete" title="Delete" class="del_choice">
</li>
EOT;

	$response_data->new_prop_markup = $prop_markup;
	
	//build the dom data
	
	if(!$is_multi_rows){
		$row_data = new stdClass();
		$row_data->position = $row_position;
		$row_data->row_title = '';
		$row_data->is_db_live = 0;
		
		$response_data->new_row_data = $row_data;
	}else{
		$i=0;
		foreach ($all_rows_element_id as $el_id){
			$row_data = new stdClass();
			$row_data->position = $row_position;
			$row_data->row_title = $rows_titles[$i];
			$row_data->is_db_live = 0;
			
			$row_position++;
			$i++;
			
			$all_rows_data[$el_id] = $row_data;
		}

		$response_data->new_row_data = $all_rows_data;
	}
	
	
	echo json_encode($response_data);
	
	
?>