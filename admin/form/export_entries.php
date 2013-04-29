<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/
	require('includes/init.php');

	@ini_set("include_path", './lib/pear/'.PATH_SEPARATOR.ini_get("include_path"));
	@ini_set("max_execution_time",1800);
	
	require('config.php');
	require('includes/db-core.php');
	require('includes/helper-functions.php');
	require('includes/check-session.php');

	require('includes/entry-functions.php');
	
	
	$form_id 	 = (int) trim($_REQUEST['form_id']);
	$export_type = trim($_REQUEST['type']);
	$entries_id  = trim($_REQUEST['entries_id']);

	if(empty($form_id)){
		die("Invalid form ID.");
	}

	$dbh = mf_connect_db();
	$mf_settings = mf_get_settings($dbh);

	//prepare filename for the export
	$query 	= "select 
					 form_name,
					 entries_sort_by,
					 entries_filter_type,
					 entries_enable_filter
			     from 
			     	 ".MF_TABLE_PREFIX."forms 
			    where 
			    	 form_id = ?";
	$params = array($form_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
	
	if(!empty($row)){
		$form_name = $row['form_name'];
		$clean_form_name = preg_replace("/[^A-Za-z0-9_-]/","",$form_name);
		
		$filter_type   = $row['entries_filter_type'];
		$entries_enable_filter = $row['entries_enable_filter'];
		$sort_by = $row['entries_sort_by'];
	}
	
	$exploded = explode('-', $sort_by);
	$sort_element = $exploded[0]; //the element name, e.g. element_2
	$sort_order	  = $exploded[1]; //asc or desc

	if(!empty($entries_id)){ //if this is an export of few selected entries, prepare the where condition
		$entries_id_joined = str_replace(',', "','", $entries_id);
		$selected_where_clause = "WHERE `id` IN('{$entries_id_joined}')";
	}else{ //otherwise, this is full export
		//if there is filter enabled, get filter data
		if(!empty($entries_enable_filter)){
				//get filter keywords from ap_form_filters table
				$query = "select
								element_name,
								filter_condition,
								filter_keyword
							from 
								".MF_TABLE_PREFIX."form_filters
						   where
						   		form_id = ?
						order by 
						   		aff_id asc";
				$params = array($form_id);
				$sth = mf_do_query($query,$params,$dbh);
				$i = 0;
				while($row = mf_do_fetch_result($sth)){
					$filter_data[$i]['element_name'] 	 = $row['element_name'];
					$filter_data[$i]['filter_condition'] = $row['filter_condition'];
					$filter_data[$i]['filter_keyword'] 	 = $row['filter_keyword'];
					$i++;
				}
		}
	}

	
	//code below is pretty much the same as mf_display_entries_table function, with some adjustments
	
	/******************************************************************************************/
	//prepare column header names lookup

	//get form element options first (checkboxes, choices, dropdown)
	$query = "select 
					element_id,
					option_id,
					`option`
				from 
					".MF_TABLE_PREFIX."element_options 
			   where 
			   		form_id=? and live=1 
			order by 
					element_id,position asc";
	$params = array($form_id);
	$sth = mf_do_query($query,$params,$dbh);
		
	while($row = mf_do_fetch_result($sth)){
		$element_id = $row['element_id'];
		$option_id  = $row['option_id'];
			
		$element_option_lookup[$element_id][$option_id] = $row['option'];
	}

	//get element options for matrix fields
	$query = "select 
					A.element_id,
					A.option_id,
					(select if(B.element_matrix_parent_id=0,A.option,
						(select 
								C.`option` 
						   from 
						   		".MF_TABLE_PREFIX."element_options C 
						  where 
						  		C.element_id=B.element_matrix_parent_id and 
						  		C.form_id=A.form_id and 
						  		C.live=1 and 
						  		C.option_id=A.option_id))
					) 'option_label'
				from 
					".MF_TABLE_PREFIX."element_options A left join ".MF_TABLE_PREFIX."form_elements B on (A.element_id=B.element_id and A.form_id=B.form_id)
			   where 
			   		A.form_id=? and A.live=1 and B.element_type='matrix' and B.element_status=1
			order by 
					A.element_id,A.option_id asc";
	$params = array($form_id);
	$sth = mf_do_query($query,$params,$dbh);
		
	while($row = mf_do_fetch_result($sth)){
		$element_id = $row['element_id'];
		$option_id  = $row['option_id'];
			
		$matrix_element_option_lookup[$element_id][$option_id] = $row['option_label'];
	}

	//get 'multiselect' status of matrix fields
	$query = "select 
					  A.element_id,
					  A.element_matrix_parent_id,
					  A.element_matrix_allow_multiselect,
					  (select if(A.element_matrix_parent_id=0,A.element_matrix_allow_multiselect,
					  			 (select B.element_matrix_allow_multiselect from ".MF_TABLE_PREFIX."form_elements B where B.form_id=A.form_id and B.element_id=A.element_matrix_parent_id)
						  		)
					  ) 'multiselect' 
				  from 
				 	  ".MF_TABLE_PREFIX."form_elements A
				 where 
				 	  A.form_id=? and A.element_status=1 and A.element_type='matrix'";
	$params = array($form_id);
	$sth = mf_do_query($query,$params,$dbh);
		
	while($row = mf_do_fetch_result($sth)){
		$matrix_multiselect_status[$row['element_id']] = $row['multiselect'];
	}


	/******************************************************************************************/
	//set column properties for basic fields
	$column_name_lookup['date_created'] = 'Date Created';
	$column_name_lookup['date_updated'] = 'Date Updated';
	$column_name_lookup['ip_address'] 	= 'IP Address';
		
	$column_type_lookup['id'] 			= 'number';
	$column_type_lookup['row_num']		= 'number';
	$column_type_lookup['date_created'] = 'date';
	$column_type_lookup['date_updated'] = 'date';
	$column_type_lookup['ip_address'] 	= 'text';
		
		
	//get column properties for other fields
	$query  = "select 
					 element_id,
					 element_title,
					 element_type,
					 element_constraint,
					 element_choice_has_other,
					 element_choice_other_label,
					 element_time_showsecond,
					 element_time_24hour,
					 element_matrix_allow_multiselect  
			     from 
			         `".MF_TABLE_PREFIX."form_elements` 
			    where 
			    	 form_id=? and element_status=1 and element_type not in('section','page_break')
			 order by 
			 		 element_position asc";
	$params = array($form_id);
	$sth = mf_do_query($query,$params,$dbh);
	$element_radio_has_other = array();

	while($row = mf_do_fetch_result($sth)){

		$element_type 	    = $row['element_type'];
		$element_constraint = $row['element_constraint'];
			

		//get 'other' field label for checkboxes and radio button
		if($element_type == 'checkbox' || $element_type == 'radio'){
			if(!empty($row['element_choice_has_other'])){
				$element_option_lookup[$row['element_id']]['other'] = $row['element_choice_other_label'];
				
				if($element_type == 'radio'){
					$element_radio_has_other['element_'.$row['element_id']] = true;	
				}
			}
		}


		if('address' == $element_type){ //address has 6 fields
			$column_name_lookup['element_'.$row['element_id'].'_1'] = $row['element_title'].' - Street Address';
			$column_name_lookup['element_'.$row['element_id'].'_2'] = 'Address Line 2';
			$column_name_lookup['element_'.$row['element_id'].'_3'] = 'City';
			$column_name_lookup['element_'.$row['element_id'].'_4'] = 'State/Province/Region';
			$column_name_lookup['element_'.$row['element_id'].'_5'] = 'Zip/Postal Code';
			$column_name_lookup['element_'.$row['element_id'].'_6'] = 'Country';
				
			$column_type_lookup['element_'.$row['element_id'].'_1'] = $row['element_type'];
			$column_type_lookup['element_'.$row['element_id'].'_2'] = $row['element_type'];
			$column_type_lookup['element_'.$row['element_id'].'_3'] = $row['element_type'];
			$column_type_lookup['element_'.$row['element_id'].'_4'] = $row['element_type'];
			$column_type_lookup['element_'.$row['element_id'].'_5'] = $row['element_type'];
			$column_type_lookup['element_'.$row['element_id'].'_6'] = $row['element_type'];
				
		}elseif ('simple_name' == $element_type){ //simple name has 2 fields
			$column_name_lookup['element_'.$row['element_id'].'_1'] = $row['element_title'].' - First';
			$column_name_lookup['element_'.$row['element_id'].'_2'] = $row['element_title'].' - Last';
				
			$column_type_lookup['element_'.$row['element_id'].'_1'] = $row['element_type'];
			$column_type_lookup['element_'.$row['element_id'].'_2'] = $row['element_type'];
				
		}elseif ('simple_name_wmiddle' == $element_type){ //simple name with middle has 3 fields
			$column_name_lookup['element_'.$row['element_id'].'_1'] = $row['element_title'].' - First';
			$column_name_lookup['element_'.$row['element_id'].'_2'] = $row['element_title'].' - Middle';
			$column_name_lookup['element_'.$row['element_id'].'_3'] = $row['element_title'].' - Last';
				
			$column_type_lookup['element_'.$row['element_id'].'_1'] = $row['element_type'];
			$column_type_lookup['element_'.$row['element_id'].'_2'] = $row['element_type'];
			$column_type_lookup['element_'.$row['element_id'].'_3'] = $row['element_type'];
				
		}elseif ('name' == $element_type){ //name has 4 fields
			$column_name_lookup['element_'.$row['element_id'].'_1'] = $row['element_title'].' - Title';
			$column_name_lookup['element_'.$row['element_id'].'_2'] = $row['element_title'].' - First';
			$column_name_lookup['element_'.$row['element_id'].'_3'] = $row['element_title'].' - Last';
			$column_name_lookup['element_'.$row['element_id'].'_4'] = $row['element_title'].' - Suffix';
				
			$column_type_lookup['element_'.$row['element_id'].'_1'] = $row['element_type'];
			$column_type_lookup['element_'.$row['element_id'].'_2'] = $row['element_type'];
			$column_type_lookup['element_'.$row['element_id'].'_3'] = $row['element_type'];
			$column_type_lookup['element_'.$row['element_id'].'_4'] = $row['element_type'];
				
		}elseif ('name_wmiddle' == $element_type){ //name with middle has 5 fields
			$column_name_lookup['element_'.$row['element_id'].'_1'] = $row['element_title'].' - Title';
			$column_name_lookup['element_'.$row['element_id'].'_2'] = $row['element_title'].' - First';
			$column_name_lookup['element_'.$row['element_id'].'_3'] = $row['element_title'].' - Middle';
			$column_name_lookup['element_'.$row['element_id'].'_4'] = $row['element_title'].' - Last';
			$column_name_lookup['element_'.$row['element_id'].'_5'] = $row['element_title'].' - Suffix';
				
			$column_type_lookup['element_'.$row['element_id'].'_1'] = $row['element_type'];
			$column_type_lookup['element_'.$row['element_id'].'_2'] = $row['element_type'];
			$column_type_lookup['element_'.$row['element_id'].'_3'] = $row['element_type'];
			$column_type_lookup['element_'.$row['element_id'].'_4'] = $row['element_type'];
			$column_type_lookup['element_'.$row['element_id'].'_5'] = $row['element_type'];
				
		}elseif('money' == $element_type){//money format
			$column_name_lookup['element_'.$row['element_id']] = $row['element_title'];
			if(!empty($element_constraint)){
				$column_type_lookup['element_'.$row['element_id']] = 'money_'.$element_constraint; //euro, pound, yen,etc
			}else{
				$column_type_lookup['element_'.$row['element_id']] = 'money_dollar'; //default is dollar
			}
		}elseif('checkbox' == $element_type){ //checkboxes, get childs elements
							
			$this_checkbox_options = $element_option_lookup[$row['element_id']];
				
			foreach ($this_checkbox_options as $option_id=>$option){
				$column_name_lookup['element_'.$row['element_id'].'_'.$option_id] = $option;
				$column_type_lookup['element_'.$row['element_id'].'_'.$option_id] = $row['element_type'];
			}
		}elseif ('time' == $element_type){
				
			if(!empty($row['element_time_showsecond']) && !empty($row['element_time_24hour'])){
				$column_type_lookup['element_'.$row['element_id']] = 'time_24hour';
			}else if(!empty($row['element_time_showsecond'])){
				$column_type_lookup['element_'.$row['element_id']] = 'time';
			}else if(!empty($row['element_time_24hour'])){
				$column_type_lookup['element_'.$row['element_id']] = 'time_24hour_noseconds';
			}else{
				$column_type_lookup['element_'.$row['element_id']] = 'time_noseconds';
			}
				
			$column_name_lookup['element_'.$row['element_id']] = $row['element_title'];
		}else if('matrix' == $element_type){ 
				
			if(empty($matrix_multiselect_status[$row['element_id']])){
				$column_name_lookup['element_'.$row['element_id']] = $row['element_title'];
				$column_type_lookup['element_'.$row['element_id']] = 'matrix_radio';
			}else{
				$this_checkbox_options = $matrix_element_option_lookup[$row['element_id']];
					
				foreach ($this_checkbox_options as $option_id=>$option){
					$option = $option.' - '.$row['element_title'];
					$column_name_lookup['element_'.$row['element_id'].'_'.$option_id] = $option;
					$column_type_lookup['element_'.$row['element_id'].'_'.$option_id] = 'matrix_checkbox';
				}
			}
		}else{ //for other elements with only 1 field
			$column_name_lookup['element_'.$row['element_id']] = $row['element_title'];
			$column_type_lookup['element_'.$row['element_id']] = $row['element_type'];
		}
		
	}
	/******************************************************************************************/
			
	//display all columns
	$column_prefs = array_keys($column_name_lookup);

	//determine column labels
	$column_labels = array();

	$column_labels[] = 'Entry #';
		
	foreach($column_prefs as $column_name){
		$column_labels[] = $column_name_lookup[$column_name];
	}

	//get the entries from ap_form_x table and store it into array
	$column_prefs_joined = '`'.implode("`,`",$column_prefs).'`';

	//if there is any radio fields which has 'other', we need to query that field as well
	if(!empty($element_radio_has_other)){
		$radio_has_other_array = array();
		foreach($element_radio_has_other as $element_name=>$value){
			$radio_has_other_array[] = $element_name.'_other';
		}
		$radio_has_other_joined = '`'.implode("`,`",$radio_has_other_array).'`';
		$column_prefs_joined = $column_prefs_joined.','.$radio_has_other_joined;
	}
		
	//check for filter data and build the filter query
	if(!empty($filter_data)){

		if($filter_type == 'all'){
			$condition_type = ' AND ';
		}else{
			$condition_type = ' OR ';
		}

		$where_clause_array = array();

		foreach ($filter_data as $value) {
			$element_name 	  = $value['element_name'];
			$filter_condition = $value['filter_condition'];
			$filter_keyword   = $value['filter_keyword'];

			$filter_element_type = $column_type_lookup[$element_name];

			$temp = explode('_', $element_name);
			$element_id = $temp[1];
				
			if(in_array($filter_element_type, array('radio','select','matrix_radio'))){
				//these types need special steps to filter
				//we need to look into the ap_element_options first and do the filter there
				if($filter_condition == 'is'){
					$where_operand = '=';
					$where_keyword = "'{$filter_keyword}'";
				}else if($filter_condition == 'is_not'){
					$where_operand = '<>';
					$where_keyword = "'{$filter_keyword}'";
				}else if($filter_condition == 'begins_with'){
					$where_operand = 'LIKE';
					$where_keyword = "'{$filter_keyword}%'";
				}else if($filter_condition == 'ends_with'){
					$where_operand = 'LIKE';
					$where_keyword = "'%{$filter_keyword}'";
				}else if($filter_condition == 'contains'){
					$where_operand = 'LIKE';
					$where_keyword = "'%{$filter_keyword}%'";
				}else if($filter_condition == 'not_contain'){
					$where_operand = 'NOT LIKE';
					$where_keyword = "'%{$filter_keyword}%'";
				}

				//do a query to ap_element_options table
				$query = "select 
								option_id 
							from 
								".MF_TABLE_PREFIX."element_options 
						   where 
						   		form_id=? and
						   		element_id=? and 
						   		live=1 and 
						   		`option` {$where_operand} {$where_keyword}";
				$params = array($form_id,$element_id);
			
				$filtered_option_id_array = array();
				$sth = mf_do_query($query,$params,$dbh);
				while($row = mf_do_fetch_result($sth)){
					$filtered_option_id_array[] = $row['option_id'];
				}

				$filtered_option_id = implode("','", $filtered_option_id_array);

				if($filter_element_type == 'radio' && !empty($radio_has_other_array)){
					if(in_array($element_name.'_other', $radio_has_other_array)){
						$filter_radio_has_other = true;
					}else{
						$filter_radio_has_other = false;
					}
				}
					
				if($filter_radio_has_other){ //if the filter is radio button field with 'other'
					if(!empty($filtered_option_id_array)){
						$where_clause_array[] = "({$element_name}  IN('{$filtered_option_id}') OR {$element_name}_other {$where_operand} {$where_keyword})"; 
					}else{
						$where_clause_array[] = "{$element_name}_other {$where_operand} {$where_keyword}";
					}
				}else{//otherwise, for the rest of the field types
					if(!empty($filtered_option_id_array)){
						$where_clause_array[] = "{$element_name}  IN('{$filtered_option_id}')"; 
					}
				}

			}else if(in_array($filter_element_type, array('date','europe_date'))){

				$date_exploded = array();
				$date_exploded = explode('/', $filter_keyword); //the filter_keyword has format mm/dd/yyyy

				$filter_keyword = $date_exploded[2].'-'.$date_exploded[0].'-'.$date_exploded[1];

				if($filter_condition == 'is'){
					$where_operand = '=';
					$where_keyword = "'{$filter_keyword}'";
				}else if($filter_condition == 'is_before'){
					$where_operand = '<';
					$where_keyword = "'{$filter_keyword}'";
				}else if($filter_condition == 'is_after'){
					$where_operand = '>';
					$where_keyword = "'{$filter_keyword}'";
				}

				$where_clause_array[] = "date({$element_name}) {$where_operand} {$where_keyword}"; 
			}else{
				if($filter_condition == 'is'){
					$where_operand = '=';
					$where_keyword = "'{$filter_keyword}'";
				}else if($filter_condition == 'is_not'){
					$where_operand = '<>';
					$where_keyword = "'{$filter_keyword}'";
				}else if($filter_condition == 'begins_with'){
					$where_operand = 'LIKE';
					$where_keyword = "'{$filter_keyword}%'";
				}else if($filter_condition == 'ends_with'){
					$where_operand = 'LIKE';
					$where_keyword = "'%{$filter_keyword}'";
				}else if($filter_condition == 'contains'){
					$where_operand = 'LIKE';
					$where_keyword = "'%{$filter_keyword}%'";
				}else if($filter_condition == 'not_contain'){
					$where_operand = 'NOT LIKE';
					$where_keyword = "'%{$filter_keyword}%'";
				}else if($filter_condition == 'less_than' || $filter_condition == 'is_before'){
					$where_operand = '<';
					$where_keyword = "'{$filter_keyword}'";
				}else if($filter_condition == 'greater_than' || $filter_condition == 'is_after'){
					$where_operand = '>';
					$where_keyword = "'{$filter_keyword}'";
				}else if($filter_condition == 'is_one'){
					$where_operand = '=';
					$where_keyword = "'1'";
				}else if($filter_condition == 'is_zero'){
					$where_operand = '=';
					$where_keyword = "'0'";
				}
		 		
				$where_clause_array[] = "{$element_name} {$where_operand} {$where_keyword}"; 
			}
		}
			
		$where_clause = implode($condition_type, $where_clause_array);
			
		if(empty($where_clause)){
			$where_clause = "WHERE `status`=1";
		}else{
			$where_clause = "WHERE ({$where_clause}) AND `status`=1";
		}
			
						
	}else{
		$where_clause = "WHERE `status`=1";
	}

	//if there is $selected_where_clause (the user select few entries to be exported)
	//overwrite any existing where_clause
	if(!empty($selected_where_clause)){
		$where_clause = $selected_where_clause;
	}

	//check the sorting element
	//if the element type is radio, select or matrix_radio, we need to add a sub query to the main query
	//so that the fields can be sorted properly (the sub query need to get values from ap_element_options table)
	$sort_element_type = $column_type_lookup[$sort_element];
	if(in_array($sort_element_type, array('radio','select','matrix_radio'))){
		if($sort_element_type == 'radio' && !empty($radio_has_other_array)){
			if(in_array($sort_element.'_other', $radio_has_other_array)){
					$sort_radio_has_other = true;
			}
		}

		$temp = explode('_', $sort_element);
		$sort_element_id = $temp[1];

		if($sort_radio_has_other){ //if this is radio button field with 'other' enabled
			$sorting_query = ",(	
									select if(A.{$sort_element}=0,A.{$sort_element}_other,
												(select 
														`option` 
													from ".MF_TABLE_PREFIX."element_options 
												   where 
												   		form_id='{$form_id}' and 
												   		element_id='{$sort_element_id}' and 
												   		option_id=A.{$sort_element} and 
												   		live=1)
								   	)
							   ) {$sort_element}_key";
		}else{
			$sorting_query = ",(
								select 
										`option` 
									from ".MF_TABLE_PREFIX."element_options 
								   where 
								   		form_id='{$form_id}' and 
								   		element_id='{$sort_element_id}' and 
								   		option_id=A.{$sort_element} and 
								   		live=1
							 ) {$sort_element}_key";
		}

		//override the $sort_element
		$sort_element .= '_key';
	}


	//prepare the header response, based on the export type
	if($export_type == 'xls'){
		require('Spreadsheet/Excel/Writer.php');
		
		// Creating a workbook
		$workbook = new Spreadsheet_Excel_Writer();
		
		$workbook->setTempDir($mf_settings['upload_dir']);
		
		// sending HTTP headers
		$workbook->send("{$clean_form_name}.xls");
		
		if(function_exists('iconv')){
			$workbook->setVersion(8); 
		}
		
		// Creating a worksheet
		$clean_form_name = substr($clean_form_name,0,30); //must be less than 31 characters
		$worksheet =& $workbook->addWorksheet($clean_form_name);
		
		$format_bold =& $workbook->addFormat();
		$format_bold->setBold();
		$format_bold->setFgColor(22);
		$format_bold->setPattern(1);
		$format_bold->setBorder(1);
						
		if(function_exists('iconv')){
			$worksheet->setInputEncoding('UTF-8');
		}
		
		$format_wrap = $workbook->addFormat();
		$format_wrap->setTextWrap();

		$i=0;
		foreach ($column_labels as $label){
			$worksheet->write(0, $i, $label,$format_bold);
			$i++;
		}

	}else if ($export_type == 'csv') {
		header("Pragma: public");
	    header("Expires: 0");
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    header("Cache-Control: public", false);
	    header("Content-Description: File Transfer");
	    header("Content-Type: application/vnd.ms-excel");
	    header("Content-Disposition: attachment; filename=\"{$clean_form_name}.csv\"");
	        
	    $output_stream = fopen('php://output', 'w');
	    fputcsv($output_stream, $column_labels,',');
		
	}elseif ($export_type == 'txt') {
		header("Pragma: public");
	    header("Expires: 0");
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    header("Cache-Control: public", false);
	    header("Content-Description: File Transfer");
	    header("Content-Type: application/vnd.ms-excel");
	    header("Content-Disposition: attachment; filename=\"{$clean_form_name}.txt\"");
	        
	    $output_stream = fopen('php://output', 'w');
	    fputcsv($output_stream, $column_labels,"\t");
	}
		

	$query = "select 
					`id`,
					{$column_prefs_joined}
					{$sorting_query} 
			    from 
			    	".MF_TABLE_PREFIX."form_{$form_id} A 
			    	{$where_clause} 
			order by 
					{$sort_element} {$sort_order}";
		
	$params = array();
	$sth = mf_do_query($query,$params,$dbh);
	$i=0;
	$row_num = 1;
		
	//prepend "id" into the column preferences
	array_unshift($column_prefs,"id");
		
	while($row = mf_do_fetch_result($sth)){
		$j=0;
		foreach($column_prefs as $column_name){
			$form_data[$i][$j] = '';
		
			if($column_type_lookup[$column_name] == 'time'){
				if(!empty($row[$column_name])){
					$form_data[$i][$j] = date("h:i:s A",strtotime($row[$column_name]));
				}else {
					$form_data[$i][$j] = '';
				}
			}elseif($column_type_lookup[$column_name] == 'time_noseconds'){ 
				if(!empty($row[$column_name])){
					$form_data[$i][$j] = date("h:i A",strtotime($row[$column_name]));
				}else {
					$form_data[$i][$j] = '';
				}
			}elseif($column_type_lookup[$column_name] == 'time_24hour_noseconds'){ 
				if(!empty($row[$column_name])){
					$form_data[$i][$j] = date("H:i",strtotime($row[$column_name]));
				}else {
					$form_data[$i][$j] = '';
				}
			}elseif($column_type_lookup[$column_name] == 'time_24hour'){ 
				if(!empty($row[$column_name])){
					$form_data[$i][$j] = date("H:i:s",strtotime($row[$column_name]));
				}else {
					$form_data[$i][$j] = '';
				}
			}elseif(substr($column_type_lookup[$column_name],0,5) == 'money'){ //set column formatting for money fields
				
				if(!empty($row[$column_name])){
					$form_data[$i][$j] = $row[$column_name];
				}else{
					$form_data[$i][$j] = '';
				}
			}elseif($column_type_lookup[$column_name] == 'date'){ //date with format MM/DD/YYYY
				if(!empty($row[$column_name]) && ($row[$column_name] != '0000-00-00')){
					$form_data[$i][$j]  = date('M d, Y',strtotime($row[$column_name]));
				}

				if($column_name == 'date_created' || $column_name == 'date_updated'){
					$form_data[$i][$j] = $row[$column_name];
				}
			}elseif($column_type_lookup[$column_name] == 'europe_date'){ //date with format DD/MM/YYYY
					
				if(!empty($row[$column_name]) && ($row[$column_name] != '0000-00-00')){
					$form_data[$i][$j]  = date('d M Y',strtotime($row[$column_name]));
				}
			}elseif($column_type_lookup[$column_name] == 'number'){ 
				$form_data[$i][$j] = $row[$column_name];
			}elseif (in_array($column_type_lookup[$column_name],array('radio','select'))){ //multiple choice or dropdown
				$exploded = array();
				$exploded = explode('_',$column_name);
				$this_element_id = $exploded[1];
				$this_option_id  = $row[$column_name];
				
				$form_data[$i][$j] = $element_option_lookup[$this_element_id][$this_option_id];
				
				if($column_type_lookup[$column_name] == 'radio'){
					if($element_radio_has_other['element_'.$this_element_id] === true && empty($form_data[$i][$j])){
						$form_data[$i][$j] = $row['element_'.$this_element_id.'_other'];
					}
				}
			}elseif(substr($column_type_lookup[$column_name],0,6) == 'matrix'){
				$exploded = array();
				$exploded = explode('_',$column_type_lookup[$column_name]);
				$matrix_type = $exploded[1];

				if($matrix_type == 'radio'){
					$exploded = array();
					$exploded = explode('_',$column_name);
					$this_element_id = $exploded[1];
					$this_option_id  = $row[$column_name];
						
					$form_data[$i][$j] = $matrix_element_option_lookup[$this_element_id][$this_option_id];
				}else if($matrix_type == 'checkbox'){
					if(!empty($row[$column_name])){
						$form_data[$i][$j]  = 'Checked';
					}else{
						$form_data[$i][$j]  = '';
					}
				}
			}elseif($column_type_lookup[$column_name] == 'checkbox'){
					
				if(!empty($row[$column_name])){
					if(substr($column_name,-5) == "other"){ //if this is an 'other' field, display the actual value
						$form_data[$i][$j] = $row[$column_name];
					}else{
						$form_data[$i][$j] = 'Checked';
					}
				}else{
					$form_data[$i][$j]  = '';
				}
					
			}elseif(in_array($column_type_lookup[$column_name],array('phone','simple_phone'))){ 
				if(!empty($row[$column_name])){
					if($column_type_lookup[$column_name] == 'phone'){
						$form_data[$i][$j] = '('.substr($row[$column_name],0,3).') '.substr($row[$column_name],3,3).'-'.substr($row[$column_name],6,4);
					}else{
						$form_data[$i][$j] = $row[$column_name];
					}
				}
			}elseif($column_type_lookup[$column_name] == 'file'){
				if(!empty($row[$column_name])){
					$raw_files = array();
					$raw_files = explode('|',$row[$column_name]);
					$clean_filenames = array();

					foreach($raw_files as $hashed_filename){
						$file_1 	    =  substr($hashed_filename,strpos($hashed_filename,'-')+1);
						$filename_value = substr($file_1,strpos($file_1,'-')+1);
						$clean_filenames[] = $filename_value;
					}

					$clean_filenames_joined = implode(', ',$clean_filenames);
					$form_data[$i][$j]  = $clean_filenames_joined;
				}
			}else{
				$form_data[$i][$j] = $row[$column_name];
			}
			$j++;
		}

		$row_data = $form_data[$i];

		if($export_type == 'xls'){
			$col_num = 0;
			foreach ($row_data as $data){
				$data = str_replace("\r","",$data);
				if($col_num > 4){
					$worksheet->write($row_num, $col_num, $data,$format_wrap);
				}else{
					$worksheet->write($row_num, $col_num, $data);
				}
				$col_num++;	
			}
		}elseif ($export_type == 'csv') {
			fputcsv($output_stream, $row_data,',');
		}elseif ($export_type == 'txt') {
			fputcsv($output_stream, $row_data,"\t");
		}

		unset($form_data); //clear the memory
		$i++;
		$row_num++;
	}
		
	
	//close the stream
	if($export_type == 'xls'){
		$workbook->close();
	}else{
		fclose($output_stream);
	}


?>