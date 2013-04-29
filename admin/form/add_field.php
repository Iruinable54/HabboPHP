<?php
	/********************************************************************************
	 MachForm
	  
	 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
	 permission from http://www.appnitro.com/
	 
	 More info at: http://www.appnitro.com/
	 ********************************************************************************/
	/***************************************************************************************************************/	
	/* 1. Get new field parameters 																	   			   */
	/***************************************************************************************************************/
	/* 2. Set the default title for the new field based on the type												   */
	/***************************************************************************************************************/
	/* 3. Get element id for this new element												   					   */
	/***************************************************************************************************************/
	/* 4. Set default field properties					 												   		   */
	/***************************************************************************************************************/
	/* 5. Insert field into ap_form_elements table															   	   */
	/***************************************************************************************************************/
	/* 6. Insert field options into ap_element_options table													   */
	/***************************************************************************************************************/
	/* 7. Generate the HTML markup for the new field														   	   */
	/***************************************************************************************************************/
	/* 8. Build the field's jQuery.data() properties															   */
	/***************************************************************************************************************/
	/* 9. Send the final field markup and data																   	   */
	/***************************************************************************************************************/

	require('includes/init.php');

	require('config.php');
	require('includes/db-core.php');
	require('includes/helper-functions.php');
	require('includes/check-session.php');

	require('includes/filter-functions.php');
	require('includes/language.php');
	require('includes/view-functions.php');

	$dbh = mf_connect_db();
	
	//sleep(5); //temporary for localhost testing
	
	
	/***************************************************************************************************************/	
	/* 1. Get new field parameters 																	   			   */
	/***************************************************************************************************************/
	$element_type  	 			= strtolower(trim($_POST['element_type']));
	$form_id					= (int) $_POST['form_id'];
	$element_position			= (int) $_POST['position']; //the position of the element within the preview page
	$element_properties_input 	= mf_sanitize($_POST['field_properties']);

	//when a field being created by dragging the button to the form preview page, a temporary id is being assigned to to field
	//the id being sent here need to be sent back, so that the javascript could replace it with the actual field markup
	$holder_id				= strtolower(trim($_POST['holder_id']));
	
	// A new field can be created from few actions
	// Dragging from the sidebar -- drag_new
	// Clicking the button -- click_new
	// Duplicate an existing field -- duplicate
	// Changing a field type -- change_type (NOT YET implemented)
	$action = strtolower(trim($_POST['action']));

	
	/***************************************************************************************************************/	
	/* 2. Set the default title for the new field based on the type												   */
	/***************************************************************************************************************/
	switch ($element_type) {
			case 'text' 		: $element_title = $lang['Text'];break;
			case 'textarea' 	: $element_title = $lang['Paragraph'];break;
			case 'select' 		: $element_title = $lang['Drop_Down'];break;
			case 'radio' 		: $element_title = $lang['Multiple_Choice'];break;
			case 'checkbox' 	: $element_title = $lang['Checkboxes'];break;
			case 'name' 		: $element_title = $lang['Name'];break;
			case 'simple_name' 	: $element_title = $lang['NameInput'];break;
			case 'date' 		: $element_title = $lang['Date'];break;
			case 'europe_date' 	: $element_title = $lang['Date'];break;
			case 'time' 		: $element_title = $lang['Time'];break;
			case 'phone' 		: $element_title = $lang['Phone'];break;
			case 'simple_phone' : $element_title = $lang['Phone'];break;
			case 'address' 		: $element_title = $lang['Address'];break;
			case 'money' 		: $element_title = $lang['Price'];break;
			case 'url' 			: $element_title = $lang['WebSite'];break;
			case 'email' 		: $element_title = $lang['Email'];break;
			case 'number' 		: $element_title = $lang['Number'];break;
			case 'file' 		: $element_title = $lang['UploadFile'];break;
			case 'section' 		: $element_title = $lang['SectionBreak'];break;
			case 'page_break' 	: $element_title = $lang['PageBreak'];break;
			case 'matrix' 		: $element_title = $lang['FirstQuestion'];break;
	}
	
	/***************************************************************************************************************/	
	/* 3. Get element id for this new element												   					   */
	/***************************************************************************************************************/
	$query = "select ifnull(max(`element_id`),0) + 1 as new_element_id from ".MF_TABLE_PREFIX."form_elements where form_id = ?";
	$params = array($form_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
	
	$element_id = $row['new_element_id'];
	
	
	/***************************************************************************************************************/	
	/* 4. Set default field properties					 												   		   */
	/***************************************************************************************************************/
	if(($action == 'click_new') || ($action == 'drag_new')){
		//if the field is completely new
		$element_properties['id'] 			= $element_id;
		$element_properties['title'] 		= $element_title;
		$element_properties['guidelines'] 	= '';
		$element_properties['size'] 		= 'medium';
		$element_properties['is_required'] 	= '0';
		$element_properties['is_unique'] 	= '0';
		$element_properties['is_private'] 	= '0';
		$element_properties['type'] 		= $element_type;
		$element_properties['position'] 	= $element_position;
		$element_properties['default_value'] = '';
		$element_properties['constraint'] 	 = '';
		$element_properties['total_child'] 	 = '0';
		$element_properties['css_class'] 	 = '';
		$element_properties['range_min'] 	 = 0;
		$element_properties['range_max'] 	 = 0;
		$element_properties['range_limit_by'] 	= 'c'; //possible values: 'c' - characters ; 'w' - words; 'v' - value; 'd' - digits
		$element_properties['status'] 	 		= '2'; //2 means 'draft' which is not active yet. 1 means live. 0 means deleted
		$element_properties['time_showsecond'] 	= 0; //don't display seconds field
		$element_properties['time_24hour'] 		= 0; //don't use 24 hours format
		$element_properties['address_hideline2'] = 0; //don't hide address line 2
		$element_properties['address_us_only'] 	 = 0; //don't display US states dropdown
		$element_properties['date_enable_range'] = 0;
		$element_properties['date_range_min'] 	 = '0000-00-00';
		$element_properties['date_range_max'] 	 = '0000-00-00';
		$element_properties['date_enable_selection_limit'] = 0;
		$element_properties['date_selection_max'] 	 = 1;
		$element_properties['date_past_future'] 	 = 'p'; //possible values: 'p' - past; 'f' - future
		$element_properties['date_disable_past_future'] = 0;
		$element_properties['date_disable_weekend'] = 0;
		$element_properties['date_disable_specific'] = 0;
		$element_properties['date_disabled_list'] = '';
		$element_properties['file_enable_type_limit'] = 1;
		$element_properties['file_block_or_allow'] = 'b'; //possible values: 'b' - block; 'a' - allow
		$element_properties['file_type_list'] = 'php,php3,php4,php5,phtml,exe,pl,cgi,html,htm,js'; //the default is to allow all file types except this list
		$element_properties['file_as_attachment'] = 0;
		$element_properties['file_enable_advance'] = 1;
		$element_properties['file_auto_upload'] = 1;
		$element_properties['file_enable_multi_upload'] = 1;
		$element_properties['file_max_selection'] = 5; //allow 10 files to be selected for each field
		$element_properties['file_enable_size_limit'] = 0;
		$element_properties['file_size_max'] = 2; //each file is limited to 2MB max
		$element_properties['submit_primary_text'] = $lang['Continue'];
		$element_properties['submit_secondary_text'] = $lang['Previous'];
		$element_properties['matrix_allow_multiselect'] = 0;
		$element_properties['matrix_parent_id'] = 0;
		
		if(in_array($element_type,array('select','radio','checkbox'))){
			$element_properties['last_option_id']	=	3; //the last option_id being used for checkboxes, multiple choice and dropdown
		}
		
		if($element_type == 'radio' || $element_type == 'checkbox'){
			$element_properties['choice_has_other'] 	= 0;
			$element_properties['choice_other_label']	= 'Other';
		}
		
		//default value for section break
		if($element_type == 'section'){
			$element_properties['guidelines'] 	= $lang['SectionBreakDescription'];
		}
		
		//default value for number
		if($element_type == 'number'){
			$element_properties['range_limit_by'] 	= 'v';
		}
		
		//default value for matrix field
		if($element_type == 'matrix'){
			$element_properties['guidelines'] 	= $lang['AnswerQuestions'];
			$element_properties['constraint']	= ($element_id + 1).','.($element_id + 2).','.($element_id + 3); //by default, three child rows for a new matrix, list element id here
			$element_properties['last_option_id'] =	4; //by default there are 4 columns
			$element_properties['position']		= 1; //first row of new matrix position is always 1
		}
		
		//default value for page break
		if($element_type == 'page_break'){
			$element_properties['page_title']  = $lang['UntitledPage'];
		}
		
	}elseif ($action == 'duplicate'){
		//copy the original element properties for the new field
		$element_properties = $element_properties_input;
		
		//copy the "options" property to another variable for checkbox, radio button, matrix and dropdown
		//and then remove it from element_properties array
		//so that it won't break the insert into ap_form_elememts
		
		if(in_array($element_type,array('select','radio','checkbox'))){
			$element_properties['last_option_id'] = (int) $element_properties['last_option_id']; //this is must be integer, needed by the javascript as integer
			$element_options_source = $element_properties['options'];
			$element_options = array();
			
			foreach($element_options_source as $option_id=>$option_data){
				$cur_pos = $option_data['position'];
				foreach($option_data as $key=>$value){
					if($key == 'position'){
						$element_options[$cur_pos]['id'] = $option_id;
					}else if($key == 'is_db_live'){
						$element_options[$cur_pos][$key] = '0'; //duplicated field is not dblive
					}else{
						$element_options[$cur_pos][$key] = $value;
					}
				}
				
			}
			
			//sort the array by index, which determines the position
			ksort($element_options);
		}
		
		if($element_type == 'matrix'){
			$element_properties['last_option_id'] = (int) $element_properties['last_option_id']; //this is must be integer, needed by the javascript as integer
			$element_options_source = $element_properties['options'];
			
			$total_matrix_rows = count($element_options_source);
			$matrix_constraint = '';
			for($i=1;$i<$total_matrix_rows;$i++){
				$matrix_constraint .= ($element_id + $i).',';
			}
			$element_properties['constraint'] = rtrim($matrix_constraint,',');
			$element_properties['position'] = 1; //set the first row of the matrix position to 1
		}
		
		unset($element_properties['options']);
		unset($element_properties['is_db_live']);
		unset($element_properties['page_total']);
		
		$element_properties['id'] = $element_id;	
		
	}
	
	
	/***************************************************************************************************************/	
	/* 5. Insert field into ap_form_elements table															   	   */
	/***************************************************************************************************************/
	
	$field_list = '';
	$field_values = '';
		
	//dynamically create the field list and field values, based on the input given
	$params = array();
	foreach ($element_properties as $key=>$value){
		if($key == 'last_option_id'){
			continue; //don't insert this property, only being used as helper for the form builder preview
		}
		
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
	
	//if this is matrix field and a new field being added, we need to insert the children rows as separate elements
	if($element_type == 'matrix'){
		if(($action == 'click_new') || ($action == 'drag_new')){
		
			$matrix_element_id_array[] = $element_id;
			
			$element_properties['constraint'] = '';
			$element_properties['guidelines'] = '';
			$element_properties['matrix_parent_id'] = $element_id;
			for($i=1;$i<=3;$i++){
				$element_properties['id'] 	= $element_id + $i;
				$element_properties['position'] = $i+1;
				
				if($i == 1){
					$element_properties['title'] = 'Second Question';
				}else if($i == 2){
					$element_properties['title'] = 'Third Question';
				}else if($i == 3){
					$element_properties['title'] = 'Fourth Question';
				}
				
				$field_list = '';
				$field_values = '';
				
				//dynamically create the field list and field values, based on the input given		
				$params = array();
				foreach ($element_properties as $key=>$value){
					if($key == 'last_option_id'){
						continue; //don't insert this property, only being used as helper for the form builder preview
					}
					
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
				
				$matrix_element_id_array[] = $element_properties['id'];
				
			}
		}else if($action == 'duplicate'){
			$original_element_id = $element_properties_input['id'];
			$i = 1;
			foreach ($element_options_source as $row_element_id=>$row_data){
				if($row_element_id == $original_element_id){
					$matrix_element_id_pair[$original_element_id] = $element_id;
					continue; //skip the insert if this is the first row of the matrix, since it's already inserted above
				}
				
				$element_properties['id'] 	 	  		= $element_id + $i;
				$element_properties['guidelines'] 		= '';
				$element_properties['matrix_parent_id'] = $element_id;
				$element_properties['constraint'] 		= '';
				$element_properties['title'] 	  		= $row_data['row_title'];
				$element_properties['position']			= $row_data['position'];
				
				$matrix_element_id_pair[$row_element_id] = $element_properties['id'];
				
				$field_list = '';
				$field_values = '';
				
				//dynamically create the field list and field values, based on the input given
				$params = array();
				foreach ($element_properties as $key=>$value){
					if($key == 'last_option_id'){
						continue; //don't insert this property, only being used as helper for the form builder preview
					}
					
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
				
				$i++;
			}
		}
	}//end of matrix field children rows type insertion
	
	
	/***************************************************************************************************************/
	/* 6. Insert field options into ap_element_options table													   */
	/***************************************************************************************************************/
	//some fields (multiple choice, checkboxes, dropdown, matrix) has child options which need to be stored into ap_element_options table
	$default_option_labels[1] = 'First option';
	$default_option_labels[2] = 'Second option';
	$default_option_labels[3] = 'Third option';
	$default_option_labels[4] = 'Fourth option'; //this one currently only being used by matrix field
	
	$default_matrix_labels[1] = 'Answer A';
	$default_matrix_labels[2] = 'Answer B';
	$default_matrix_labels[3] = 'Answer C';
	$default_matrix_labels[4] = 'Answer D';
	
	//the ap_element_options table has "live" column, which has 3 possible values:
	// 0 - the option is being deleted
	// 1 - the option is active
	// 2 - the option is currently being drafted, not being saved yet and will be deleted by edit_form.php if the form is being edited the next time
	
	if(in_array($element_type,array('radio','checkbox','select','matrix'))){
		if(($action == 'click_new') || ($action == 'drag_new')){ //if this is creating new field
			if(in_array($element_type,array('radio','checkbox','select'))){
				for($i=1;$i<=3;$i++){
					$query = "INSERT INTO 
										`".MF_TABLE_PREFIX."element_options` 
											(`form_id`,`element_id`,`option_id`,`position`,`option`,`option_is_default`,`live`) 
								   VALUES ( ? , ? , ? , ? , ? ,'0','2');"; 
					$params = array($form_id,$element_id,$i,$i,$default_option_labels[$i]);
					mf_do_query($query,$params,$dbh);
				}
			}else if($element_type == 'matrix'){
				//when a new matrix field is being created, it has 4 element_id
				//each is basically the same structure as multiple choice/checkbox
				//so we need to insert default labels for each of them into ap_element_options table
				//in total, one new matrix field inserts 16 (4x4) rows into the table

				$matrix_row = 1;
				foreach($matrix_element_id_array as $m_element_id){
					
					if($m_element_id == $element_id){ //if this is the first row of the matrix
						$matrix_row_labels = $default_matrix_labels;
					}else{
						$matrix_row_labels = $default_option_labels;
					}
					
					for($i=1;$i<=4;$i++){
						$query = "INSERT INTO 
										`".MF_TABLE_PREFIX."element_options` 
											(`form_id`,`element_id`,`option_id`,`position`,`option`,`option_is_default`,`live`) 
								   VALUES ( ? , ? , ? , ? , ? ,'0','2');"; 
						$params = array($form_id,$m_element_id,$i,$i,$matrix_row_labels[$i]);
						mf_do_query($query,$params,$dbh);
					}	
					$matrix_row++;
				}
			}
		}elseif ($action == 'duplicate'){ //if this is duplicating existing field
			$original_element_id = $element_properties_input['id'];
			
			//simpy duplicate the records from the original field and change the new element_id, also set the 'live' field to '2' (draft status)
			if(in_array($element_type,array('radio','checkbox','select'))){
				$query = "INSERT INTO 
									 ".MF_TABLE_PREFIX."element_options (`form_id`,`element_id`,`option_id`,`position`,`option`,`option_is_default`,`live`)
						  	   SELECT 
						  	   		 `form_id`, '{$element_id}' as new_element_id,`option_id`,`position`,`option`,`option_is_default`,'2' as `live` 
						  	   	 FROM 
						  	   	 	 ".MF_TABLE_PREFIX."element_options 
						  	   	WHERE 
						  	   		 form_id = ? AND element_id = ? AND (live=1 OR live=2);"; 
				$params = array($form_id,$original_element_id);
				mf_do_query($query,$params,$dbh);
				
			}else if($element_type == 'matrix'){
				foreach($matrix_element_id_pair as $source_element_id=>$dest_element_id){
					$query = "INSERT INTO 
										 ".MF_TABLE_PREFIX."element_options (`form_id`,`element_id`,`option_id`,`position`,`option`,`option_is_default`,`live`)
							  	   SELECT 
							  	   		 `form_id`, '{$dest_element_id}' as new_element_id,`option_id`,`position`,`option`,`option_is_default`,'2' as `live` 
							  	   	 FROM 
							  	   	 	 ".MF_TABLE_PREFIX."element_options 
							  	   	WHERE 
							  	   		 form_id = ? AND element_id = ? AND (live=1 OR live=2);"; 
					$params = array($form_id,$source_element_id);
					mf_do_query($query,$params,$dbh);
				}
			}
		}
	}
	
	
	
	/***************************************************************************************************************/	
	/* 7. Generate the HTML markup for the new field														   	   */
	/***************************************************************************************************************/
	
	$element_properties['is_db_live'] 	 	= '0';
	
	//set the default property for page break field for new field
	if(($action == 'click_new') || ($action == 'drag_new')){
		if($element_type == 'page_break'){
			$element_properties['page_number'] = 1;
			$element_properties['page_total']  = 2;
			$element_properties['page_title']  = 'Untitled Page';
		}
	}
	
	//generate the markup for each field type
	$element_properties_obj = new stdClass();
	foreach($element_properties as $key=>$value){
		$element_properties_obj->{$key} = $value;
	}
	
	
	
	//populate options for checkboxes, multiple choices, dropdown
	if(in_array($element_type,array('select','radio','checkbox'))){
		
		//if this is a new field being added, populate default choice options
		if(($action == 'click_new') || ($action == 'drag_new')){
			$el_options_json =<<<EOT
			{"options"		:	[{"option" : "First option", "is_default":0, "is_db_live":"0", "id": 1},
							 	 {"option" : "Second option", "is_default":0, "is_db_live":"0","id": 2},
							 	 {"option" : "Third option", "is_default":0, "is_db_live":"0", "id": 3}]
			}
EOT;
		
			$el_options_obj = json_decode($el_options_json);
			
		}elseif ($action == 'duplicate'){ //otherwise, if this is duplicate, copy the options from the source field
			$temp_prop = new stdClass();
			$temp_prop->options = $element_options;
			$el_options_obj = json_decode(json_encode($temp_prop));
		}

		$element_properties_obj->options = $el_options_obj->options;
		
	}
	
	//populate options for matrix field
	if($element_type == 'matrix'){
		//if this is a new field being added, populate default matrix rows options
		if(($action == 'click_new') || ($action == 'drag_new')){
			$el_options_json =<<<EOT
			{"options"		:	[{"option" : "Answer A", "is_default":0, "is_db_live":0, "id": 1},
							 	 {"option" : "Answer B", "is_default":0, "is_db_live":0, "id": 2},
							 	 {"option" : "Answer C", "is_default":0, "is_db_live":0, "id": 3},
							 	 {"option" : "Answer D", "is_default":0, "is_db_live":0, "id": 4}]
			}
EOT;
		
			$el_options_obj = json_decode($el_options_json);
			$element_properties_obj->options = $el_options_obj->options;
			
			
			$matrix_children[0]['title'] = 'Second Question';
			$matrix_children[0]['id'] = $element_id + 1;
			$matrix_children[0]['children_option_id'] = '1,2,3,4';
			
			$matrix_children[1]['title'] = 'Third Question';
			$matrix_children[1]['id'] = $element_id + 2;
			$matrix_children[1]['children_option_id'] = '1,2,3,4';
			
			$matrix_children[2]['title'] = 'Fourth Question';
			$matrix_children[2]['id'] = $element_id + 3;
			$matrix_children[2]['children_option_id'] = '1,2,3,4';
			
			$element_properties_obj->matrix_children = $matrix_children;
			
			//reset the first row properties
			$element_properties_obj->id = $element_id;
			$element_properties_obj->title = 'First Question';
			$element_properties_obj->guidelines = 'Please answer the following questions:';
		}else if($action == 'duplicate'){
			//build the options data for mf_display_matrix() function
			$el_options_array = array();
			$column_data = $element_options_source[$original_element_id]['column_data'];
			
			$i=0;
			foreach ($column_data as $option_id=>$column_value){
				$el_options_array[$i] = new stdClass();
				$el_options_array[$i]->option = $column_value['column_title'];
				$el_options_array[$i]->is_default = 0;
				$el_options_array[$i]->is_db_live = 0;
				$el_options_array[$i]->id = $option_id;
				$i++;
			}
		
			$element_properties_obj->options = $el_options_array;
			
			//build the matrix_children property for mf_display_matrix() function
			$i=1;
			$matrix_children = array();
			$children_option_id_array = array();
			$children_option_id_array = array_keys($element_options_source[$original_element_id]['column_data']);
			$children_option_id_joined = implode(',',$children_option_id_array);
				
			foreach ($element_options_source as $row_element_id=>$row_data){
				if($row_element_id == $original_element_id){
					continue;//don't put the first row into the array
				}
				
				$child_index = $row_data['position'];
				
				$matrix_children[$child_index]['title'] = $row_data['row_title'];
				$matrix_children[$child_index]['id'] 	  = $element_id + $i;
					
				$matrix_children[$child_index]['children_option_id'] = $children_option_id_joined;
				
				$i++;
			}
			ksort($matrix_children);
			$element_properties_obj->matrix_children = $matrix_children;
			
			//reset the first row properties
			$element_properties_obj->id = $element_id;
			$element_properties_obj->title = $element_options_source[$original_element_id]['row_title'];
			$element_properties_obj->guidelines = $element_properties_input['guidelines'];
		}
	}
	
	$element_properties_obj->is_design_mode = true;
	
	//the default value for the markup needs to be escaped from any HTML code
	$element_properties_obj->default_value = htmlspecialchars($element_properties['default_value']); 
	
	
	$display_func = 'mf_display_'.$element_type;
	$element_markup = $display_func($element_properties_obj);
	
	
	/***************************************************************************************************************/	
	/* 8. Build the field's jQuery.data() properties															   */
	/***************************************************************************************************************/
	
	//populate default options for checkboxes, multiple choices, dropdown
	//this is being sent for the DOM data(), the array index is the option_id
	//that's why we can't use $el_options_json above (for new field only)
	if(in_array($element_type,array('select','radio','checkbox'))){
		if(($action == 'click_new') || ($action == 'drag_new')){
			$element_properties['options'][1]['option'] = 'First option';
			$element_properties['options'][1]['is_default'] = '0';
			$element_properties['options'][1]['is_db_live'] = '0';
			$element_properties['options'][1]['position'] = 1;
			
			$element_properties['options'][2]['option'] = 'Second option';
			$element_properties['options'][2]['is_default'] = '0';
			$element_properties['options'][2]['is_db_live'] = '0';
			$element_properties['options'][2]['position'] = 2;
			
			$element_properties['options'][3]['option'] = 'Third option';
			$element_properties['options'][3]['is_default'] = '0';
			$element_properties['options'][3]['is_db_live'] = '0';
			$element_properties['options'][3]['position'] = 3;
			
			//populate the other choice label for the radio button/checkbox field
			if($element_type == 'radio' || $element_type == 'checkbox'){
				$element_properties['choice_has_other'] 	= 0;
				$element_properties['choice_other_label']	= 'Other';
			}
		}elseif ($action == 'duplicate'){ 
			//duplicated field is not dblive, set the is_db_live to 0
			$element_options_notdblive = array();
			foreach($element_options_source as $option_id=>$option_data){
				foreach($option_data as $key=>$value){
					if($key == 'is_db_live'){
						$value = '0';
					}
					
					if($key == 'position'){
						$value = (int) $value;
					}
					
					
					$element_options_notdblive[$option_id][$key] = $value;
				}
			}

			$element_properties['options'] = $element_options_notdblive;
		}
	}
	
	
	//populate options for matrix field
	//this is being sent for the DOM data()
	//that's why we can't use $el_options_json above 
	if($element_type == 'matrix'){
		//if this is a new field being added, populate default matrix rows options
		if(($action == 'click_new') || ($action == 'drag_new')){
			$element_properties['title'] = 'First Question';
			$element_properties['guidelines'] = 'Please answer the following questions:';
			$element_properties['matrix_parent_id'] = 0;
			$element_properties['matrix_allow_multiselect'] = 0;
			$element_properties['last_option_id'] = 4;
			$element_properties['id'] = $element_id;
			$element_properties['constraint'] = ($element_id + 1).','.($element_id + 2).','.($element_id + 3);
			
			$element_properties['options'][$element_id] = new stdClass();
			$element_properties['options'][$element_id]->is_db_live = 0;
			$element_properties['options'][$element_id]->position = 1;
			$element_properties['options'][$element_id]->row_title = 'First Question'; 
			$element_properties['options'][$element_id]->column_data = array(); //only the first row need to have column_data
			
			$element_properties['options'][$element_id]->column_data[1] = new stdClass();
			$element_properties['options'][$element_id]->column_data[1]->column_title = "Answer A";
			$element_properties['options'][$element_id]->column_data[1]->is_db_live   = 0;
			$element_properties['options'][$element_id]->column_data[1]->position 	  = 1;
			
			$element_properties['options'][$element_id]->column_data[2] = new stdClass();
			$element_properties['options'][$element_id]->column_data[2]->column_title = "Answer B";
			$element_properties['options'][$element_id]->column_data[2]->is_db_live   = 0;
			$element_properties['options'][$element_id]->column_data[2]->position 	  = 2;
			
			$element_properties['options'][$element_id]->column_data[3] = new stdClass();
			$element_properties['options'][$element_id]->column_data[3]->column_title = "Answer C";
			$element_properties['options'][$element_id]->column_data[3]->is_db_live   = 0;
			$element_properties['options'][$element_id]->column_data[3]->position 	  = 3;
			
			$element_properties['options'][$element_id]->column_data[4] = new stdClass();
			$element_properties['options'][$element_id]->column_data[4]->column_title = "Answer D";
			$element_properties['options'][$element_id]->column_data[4]->is_db_live   = 0;
			$element_properties['options'][$element_id]->column_data[4]->position 	  = 4;
			
			$element_properties['options'][$element_id + 1] = new stdClass();
			$element_properties['options'][$element_id + 1]->is_db_live = 0;
			$element_properties['options'][$element_id + 1]->position = 2;
			$element_properties['options'][$element_id + 1]->row_title = 'Second Question'; 
			
			$element_properties['options'][$element_id + 2] = new stdClass();
			$element_properties['options'][$element_id + 2]->is_db_live = 0;
			$element_properties['options'][$element_id + 2]->position = 3;
			$element_properties['options'][$element_id + 2]->row_title = 'Third Question';
			
			$element_properties['options'][$element_id + 3] = new stdClass();
			$element_properties['options'][$element_id + 3]->is_db_live = 0;
			$element_properties['options'][$element_id + 3]->position = 4;
			$element_properties['options'][$element_id + 3]->row_title = 'Fourth Question';
			
		}else if($action == 'duplicate'){
			
			$element_properties['title'] 		= $element_options_source[$original_element_id]['row_title'];
			$element_properties['guidelines'] 	= $element_properties_input['guidelines'];
			$element_properties['matrix_parent_id'] 		= 0;
			$element_properties['matrix_allow_multiselect'] = $element_properties_input['matrix_allow_multiselect'];
			$element_properties['id'] 						= $element_id;
			
			$total_matrix_row = count($element_options_source);
			$child_rows_id = array();
			for($i=1;$i<$total_matrix_row;$i++){
				$child_rows_id[] = $element_id + $i;
			}
			$element_properties['constraint'] = implode(',',$child_rows_id);
			
			$i=0;
			foreach($element_options_source as $row_element_id=>$row_data){
				$element_properties['options'][$element_id + $i] = new stdClass();
				$element_properties['options'][$element_id + $i]->is_db_live = 0;
				$element_properties['options'][$element_id + $i]->position  = $row_data['position'];
				$element_properties['options'][$element_id + $i]->row_title = $row_data['row_title']; 
				
				if($i==0){ //if this is first row, populate column data
					$column_data = array();
					$column_data = $row_data['column_data'];
					foreach ($column_data as $option_id=>$column_value){
						$element_properties['options'][$element_id]->column_data[$option_id] = new stdClass();
						$element_properties['options'][$element_id]->column_data[$option_id]->column_title = $column_value['column_title'];
						$element_properties['options'][$element_id]->column_data[$option_id]->is_db_live   = 0;
						$element_properties['options'][$element_id]->column_data[$option_id]->position 	   = $column_value['position'];
					}
				}
				
				$i++;
			}
		}
	}
	
	/***************************************************************************************************************/	
	/* 9. Send the final field markup and data																   	   */
	/***************************************************************************************************************/
	
	$response_data = new stdClass();
	
	$response_data->status    	= "ok";
	$response_data->markup    	= $element_markup;
	$response_data->holder_id 	= $holder_id; 
	$response_data->element_id 	= $element_id;
	$response_data->field_properties = $element_properties;
	
	
	$response_json = json_encode($response_data);
	
	echo $response_json;
?>