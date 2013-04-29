<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/
	function mf_process_form($dbh,$input){
		
		global $mf_lang;
		
		$form_id 	 = (int) trim($input['form_id']);
		$edit_id	 = (int) trim($input['edit_id']);

		if(empty($input['page_number'])){
			$page_number = 1;
		}else{
			$page_number = (int) $input['page_number'];
		}
		
		
		
		$is_committed = false;
		
		$mf_settings = mf_get_settings($dbh);
		
		//this function handle password submission and general form submission
		//check for password requirement
		$query = "select form_password,form_language,form_review from `".MF_TABLE_PREFIX."forms` where form_id=?";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
		
		$form_review = $row['form_review'];
		
		if(!empty($row['form_password'])){
			$require_password = true;
		}else{
			$require_password = false;
		}

		if(!empty($row['form_language'])){
			mf_set_language($row['form_language']);
		}
		
		//if this form require password and no session has been set
		if($require_password && (empty($_SESSION['user_authenticated']) || $_SESSION['user_authenticated'] != $form_id)){ 
			
			$query = "select count(form_id) valid_password from `".MF_TABLE_PREFIX."forms` where form_id=? and form_password=?";
			$params = array($form_id,$input['password']);
		
			$sth = mf_do_query($query,$params,$dbh);
			$row = mf_do_fetch_result($sth);
			
			if(!empty($row['valid_password'])){
				$process_result['status'] = true;
				$_SESSION['user_authenticated'] = $form_id;
			}else{
				$process_result['status'] = false;
				$process_result['custom_error'] = $mf_lang['form_pass_invalid'];
			}
			
			return $process_result;
		}
		
		
		$element_child_lookup['address'] 	 = 5;
		$element_child_lookup['simple_name'] = 1;
		$element_child_lookup['simple_name_wmiddle'] = 2;
		$element_child_lookup['name'] 		 = 3;
		$element_child_lookup['name_wmiddle'] = 4;
		$element_child_lookup['phone'] 		 = 2;
		$element_child_lookup['date'] 		 = 2;
		$element_child_lookup['europe_date'] = 2;
		$element_child_lookup['time'] 		 = 3;
		$element_child_lookup['money'] 		 = 1; //this applies to dollar,euro and pound. yen don't have child
		$element_child_lookup['checkbox'] 	 = 1; //this is just a dumb value
		$element_child_lookup['matrix'] 	 = 1; //this is just a dumb value
		
		//never trust user input, get a list of input fields based on info stored on table
		//element has real child -> address, simple_name, name, simple_name_wmiddle, name_wmiddle
		//element has virtual child -> phone, date, europe_date, time, money
		
		if(!empty($edit_id) && $_SESSION['mf_logged_in'] === true){
			//if this is edit_entry page, process all elements on all pages at once
			$page_number_clause = '';
			$params = array($form_id);
		}else{
			$page_number_clause = 'and element_page_number =?';
			$params = array($form_id,$page_number);
		}

		$query = "SELECT 
						element_id,
       					element_title,
       					element_is_required,
       					element_is_unique,
       					element_type, 
       					element_constraint,
       					element_total_child,
       					element_file_enable_multi_upload,
       					element_file_max_selection,
       					element_file_enable_type_limit,
       					element_file_block_or_allow,
       					element_file_type_list,
       					element_range_max,
       					element_range_min,
       					element_range_limit_by,
       					element_choice_has_other,
       					element_time_showsecond,
       					element_time_24hour,
       					element_matrix_parent_id,
       					element_matrix_allow_multiselect,
       					element_date_enable_range,
       					element_date_range_min,
       					element_date_range_max,
       					element_date_past_future,
       					element_date_disable_past_future,
       					element_date_enable_selection_limit,
						element_date_selection_max,
						element_date_disable_weekend,
						element_date_disable_specific,
						element_date_disabled_list
					FROM 
						".MF_TABLE_PREFIX."form_elements 
				   WHERE 
				   		form_id=? and element_status = '1' {$page_number_clause} and element_type <> 'page_break' and element_type <> 'section'
				ORDER BY 
						element_id asc";
		
		$sth = mf_do_query($query,$params,$dbh);
		
		
		$element_to_get = array();
		$private_elements = array(); //admin-only fields
		$matrix_childs_array = array();
		
		
		while($row = mf_do_fetch_result($sth)){
			if($row['element_type'] == 'section'){
				continue;
			}

			//store element info
			$element_info[$row['element_id']]['title'] 			= $row['element_title'];
			$element_info[$row['element_id']]['type'] 			= $row['element_type'];
			$element_info[$row['element_id']]['is_required'] 	= $row['element_is_required'];
			$element_info[$row['element_id']]['is_unique'] 		= $row['element_is_unique'];
			$element_info[$row['element_id']]['is_private'] 	= $row['element_is_private'];
			$element_info[$row['element_id']]['constraint'] 	= $row['element_constraint'];
			$element_info[$row['element_id']]['file_enable_multi_upload'] 	= $row['element_file_enable_multi_upload'];
			$element_info[$row['element_id']]['file_max_selection'] 	= $row['element_file_max_selection'];
			$element_info[$row['element_id']]['file_enable_type_limit'] = $row['element_file_enable_type_limit'];
			$element_info[$row['element_id']]['file_block_or_allow'] 	= $row['element_file_block_or_allow'];
			$element_info[$row['element_id']]['file_type_list'] 		= $row['element_file_type_list'];
			$element_info[$row['element_id']]['range_min'] 		= $row['element_range_min'];
			$element_info[$row['element_id']]['range_max'] 		= $row['element_range_max'];
			$element_info[$row['element_id']]['range_limit_by'] = $row['element_range_limit_by'];
			$element_info[$row['element_id']]['choice_has_other'] = $row['element_choice_has_other'];
			$element_info[$row['element_id']]['time_showsecond']  = (int) $row['element_time_showsecond'];
			$element_info[$row['element_id']]['time_24hour']  	  = (int) $row['element_time_24hour'];
			$element_info[$row['element_id']]['matrix_parent_id'] = (int) $row['element_matrix_parent_id'];
			$element_info[$row['element_id']]['matrix_allow_multiselect'] = (int) $row['element_matrix_allow_multiselect'];
			$element_info[$row['element_id']]['date_enable_range'] = (int) $row['element_date_enable_range'];
			$element_info[$row['element_id']]['date_range_max']    = $row['element_date_range_max'];
			$element_info[$row['element_id']]['date_range_min']    = $row['element_date_range_min'];
			$element_info[$row['element_id']]['date_past_future']    = $row['element_date_past_future'];
			$element_info[$row['element_id']]['date_disable_past_future'] = (int) $row['element_date_disable_past_future'];
			$element_info[$row['element_id']]['date_enable_selection_limit'] = (int) $row['element_date_enable_selection_limit'];
			$element_info[$row['element_id']]['date_selection_max'] 		 = (int) $row['element_date_selection_max'];
			$element_info[$row['element_id']]['date_disable_weekend'] 		 = (int) $row['element_date_disable_weekend'];
			$element_info[$row['element_id']]['date_disable_specific'] 		 = (int) $row['element_date_disable_specific'];
			$element_info[$row['element_id']]['date_disabled_list'] 		 = $row['element_date_disabled_list'];
			
			//get element form name, complete with the childs
			if(empty($element_child_lookup[$row['element_type']]) || ($row['element_constraint'] == 'yen')){ //elements with no child
				$element_to_get[] = 'element_'.$row['element_id'];			
			}else{ //elements with child
				if($row['element_type'] == 'checkbox' || ($row['element_type'] == 'matrix' && !empty($row['element_matrix_allow_multiselect'])) ){
					
					//for checkbox, get childs elements from ap_element_options table 
					$sub_query = "select 
										option_id 
									from 
										".MF_TABLE_PREFIX."element_options 
								   where 
								   		form_id=? and element_id=? and live=1 
								order by 
										`position` asc";
					$params = array($form_id,$row['element_id']);
					
					$sub_sth = mf_do_query($sub_query,$params,$dbh);
					while($sub_row = mf_do_fetch_result($sub_sth)){
						$element_to_get[] = "element_{$row['element_id']}_{$sub_row['option_id']}";
						$checkbox_childs[$row['element_id']][] =  $sub_row['option_id']; //store the child into array for further reference
					}
					
					//if this is the parent of the matrix (checkbox matrix only), get the child as well
					if($row['element_type'] == 'matrix' && !empty($row['element_matrix_allow_multiselect'])){
						
						$temp_matrix_child_element_id_array = explode(',',trim($row['element_constraint']));
						
						foreach ($temp_matrix_child_element_id_array as $mc_element_id){
							$sub_query = "select 
											option_id 
										from 
											".MF_TABLE_PREFIX."element_options 
									   where 
									   		form_id=? and element_id=? and live=1 
									order by 
											`position` asc";
							$params = array($form_id,$mc_element_id);
							
							$sub_sth = mf_do_query($sub_query,$params,$dbh);
							while($sub_row = mf_do_fetch_result($sub_sth)){
								$element_to_get[] = "element_{$mc_element_id}_{$sub_row['option_id']}";
								$checkbox_childs[$mc_element_id][] =  $sub_row['option_id']; //store the child into array for further reference
							}
							
						}
					}
				}else if($row['element_type'] == 'matrix' && empty($row['element_matrix_allow_multiselect'])){ //radio button matrix, each row doesn't have childs
					$element_to_get[] = 'element_'.$row['element_id'];
				}else{
					$max = $element_child_lookup[$row['element_type']] + 1;
					
					for ($j=1;$j<=$max;$j++){
						$element_to_get[] = "element_{$row['element_id']}_{$j}";
					}
				}
			}
			
			
			//if the back button pressed after review page, we need to store the file info
			if(!empty($_SESSION['review_id']) && !empty($form_review)){
				if($row['element_type'] == 'file'){
					$existing_file_id[] = $row['element_id'];
				}
			}
			
			//if this is matrix field, particularly the child rows, we need to store the id into temporary array
			//we need to loop through it later, to set the "required" property based on the matrix parent value
			if($row['element_type'] == 'matrix' && !empty($row['element_matrix_parent_id'])){
				$matrix_childs_array[$row['element_id']] = $row['element_matrix_parent_id'];
			}
		}
		
		
		//loop through each matrix childs array
		//if the parent matrix has required=1, the child need to be set the same
		//if the parent matrix allow multi select, the child need to be set the same
		if(!empty($matrix_childs_array)){
			foreach ($matrix_childs_array as $matrix_child_element_id=>$matrix_parent_element_id){
				if(!empty($element_info[$matrix_parent_element_id]['is_required'] )){
					$element_info[$matrix_child_element_id]['is_required'] = 1; 
				}
				if(!empty($element_info[$matrix_parent_element_id]['matrix_allow_multiselect'] )){
					$element_info[$matrix_child_element_id]['matrix_allow_multiselect'] = 1; 
				}
			}
		}
		
		if(!empty($existing_file_id)){
			$existing_file_id_list = '';
			foreach ($existing_file_id as $value){
				$existing_file_id_list .= 'element_'.$value.',';
			}
			$existing_file_id_list = rtrim($existing_file_id_list,',');
			
			$query = "select {$existing_file_id_list} from ".MF_TABLE_PREFIX."form_{$form_id}_review where `id`=?";
			$params = array($_SESSION['review_id']);
			
			$sth = mf_do_query($query,$params,$dbh);
			$row = mf_do_fetch_result($sth);
			
			foreach ($existing_file_id as $value){
				if(!empty($row['element_'.$value])){
					$element_info[$value]['existing_file'] 	= $row['element_'.$value];
				}
			}
		}
			
		
		//pick user input
		$user_input = array();
		foreach ($element_to_get as $element_name){
			$user_input[$element_name] = @$input[$element_name];
		}
					
					
		$error_elements = array();
		$table_data = array();
		//validate input based on rules specified for each field
		foreach ($user_input as $element_name=>$element_data){
			
			//get element_id from element_name
			$exploded = array();
			$exploded = explode('_',$element_name);
			$element_id = $exploded[1];
			
			$rules = array();
			$target_input = array();
			
			$element_type = $element_info[$element_id]['type'];
			
			
			//if this is private fields and not logged-in as admin, bypass operation below, just supply the default value if any
			if(($element_info[$element_id]['is_private'] == 1) && empty($_SESSION['mf_logged_in'])){
				if(!empty($element_info[$element_id]['default_value'])){
					$table_data['element_'.$element_id] = $element_info[$element_id]['default_value'];
				}
				continue;
			}
			
			//if this is matrix field, we need to convert the field type into radio button or checkbox
			if('matrix' == $element_type){
				$is_matrix_field = true;
				if(!empty($element_info[$element_id]['matrix_allow_multiselect'])){
					$element_type = 'checkbox';
				}else{
					$element_type = 'radio';
				}
			}else{
				$is_matrix_field = false;
			}
			
			
			if('text' == $element_type){ //Single Line Text
											
				if($element_info[$element_id]['is_required']){
					$rules[$element_name]['required'] 	= true;
				}
				
				if($element_info[$element_id]['is_unique']){
					$rules[$element_name]['unique'] 	= $form_id.'#'.$element_name;
					$target_input['dbh'] = $dbh; //we need to pass the $dbh for this 'unique' rule
				}
				
				
				if(!empty($user_input[$element_name])){
					if(!empty($element_info[$element_id]['range_max']) && !empty($element_info[$element_id]['range_min'])){
						$rules[$element_name]['range_length'] = $element_info[$element_id]['range_limit_by'].'#'.$element_info[$element_id]['range_min'].'#'.$element_info[$element_id]['range_max'];
					}else if(!empty($element_info[$element_id]['range_max'])){
						$rules[$element_name]['max_length'] = $element_info[$element_id]['range_limit_by'].'#'.$element_info[$element_id]['range_max'];
					}else if(!empty($element_info[$element_id]['range_min'])){
						$rules[$element_name]['min_length'] = $element_info[$element_id]['range_limit_by'].'#'.$element_info[$element_id]['range_min'];
					}	
				}
				
				$target_input[$element_name] = $element_data;
				
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value'] = htmlspecialchars($element_data); 
				
				//prepare data for table column
				$table_data[$element_name] = $element_data; 
				
			}elseif ('textarea' == $element_type){ //Paragraph
				
				if($element_info[$element_id]['is_required']){
					$rules[$element_name]['required'] 	= true;
				}
				
				if($element_info[$element_id]['is_unique']){
					$rules[$element_name]['unique'] 	= $form_id.'#'.$element_name;
					$target_input['dbh'] = $dbh; //we need to pass the $dbh for this 'unique' rule
				}
				
				if(!empty($user_input[$element_name])){
					if(!empty($element_info[$element_id]['range_max']) && !empty($element_info[$element_id]['range_min'])){
						$rules[$element_name]['range_length'] = $element_info[$element_id]['range_limit_by'].'#'.$element_info[$element_id]['range_min'].'#'.$element_info[$element_id]['range_max'];
					}else if(!empty($element_info[$element_id]['range_max'])){
						$rules[$element_name]['max_length'] = $element_info[$element_id]['range_limit_by'].'#'.$element_info[$element_id]['range_max'];
					}else if(!empty($element_info[$element_id]['range_min'])){
						$rules[$element_name]['min_length'] = $element_info[$element_id]['range_limit_by'].'#'.$element_info[$element_id]['range_min'];
					}	
				}
												
				$target_input[$element_name] = $element_data;
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value'] = htmlspecialchars($element_data); 
				
				//prepare data for table column
				$table_data[$element_name] = $element_data; 
				
			}elseif ('radio' == $element_type){ //Multiple Choice
				
				if($element_info[$element_id]['is_required']){
					$rules[$element_name]['required'] 	= true;
				}
				
				//if this field has 'other' label
				if(!empty($element_info[$element_id]['choice_has_other'])){
					if(empty($element_data) && !empty($input[$element_name.'_other'])){
						$element_data = $input[$element_name.'_other'];
						
						//save old data into array, for form redisplay in case errors occured
						$form_data[$element_name.'_other']['default_value'] = $element_data; 
						$table_data[$element_name.'_other'] = $element_data;

						//make sure to set the main element value to 0
						$form_data[$element_name]['default_value'] = 0; 
						$table_data[$element_name] = 0;
					}
				}
																
				$target_input[$element_name] = $element_data;
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					if($is_matrix_field && !empty($matrix_childs_array[$element_id])){
						$error_elements[$matrix_childs_array[$element_id]] = $validation_result;
					}else{
						$error_elements[$element_id] = $validation_result;
					}
				}
				
				//save old data into array, for form redisplay in case errors occured
				if(empty($form_data[$element_name.'_other']['default_value'])){
					$form_data[$element_name]['default_value'] = $element_data; 
				}
				
				//prepare data for table column
				if(empty($table_data[$element_name.'_other'])){
					$table_data[$element_name] = $element_data; 
				}
				
			}elseif ('number' == $element_type){ //Number
				
				if($element_info[$element_id]['is_required']){
					$rules[$element_name]['required'] 	= true;
				}
				
				if($element_info[$element_id]['is_unique']){
					$rules[$element_name]['unique'] 	= $form_id.'#'.$element_name;
					$target_input['dbh'] = $dbh; //we need to pass the $dbh for this 'unique' rule
				}
				
				//check for numeric if not empty
				if(!empty($user_input[$element_name])){ 
					$rules[$element_name]['numeric'] = true;
				}
				
				
				if(!empty($user_input[$element_name]) && ($element_info[$element_id]['range_limit_by'] == 'd')){
					if(!empty($element_info[$element_id]['range_max']) && !empty($element_info[$element_id]['range_min'])){
						$rules[$element_name]['range_length'] = $element_info[$element_id]['range_limit_by'].'#'.$element_info[$element_id]['range_min'].'#'.$element_info[$element_id]['range_max'];
					}else if(!empty($element_info[$element_id]['range_max'])){
						$rules[$element_name]['max_length'] = $element_info[$element_id]['range_limit_by'].'#'.$element_info[$element_id]['range_max'];
					}else if(!empty($element_info[$element_id]['range_min'])){
						$rules[$element_name]['min_length'] = $element_info[$element_id]['range_limit_by'].'#'.$element_info[$element_id]['range_min'];
					}	
				}else if(!empty($user_input[$element_name]) && ($element_info[$element_id]['range_limit_by'] == 'v')){
					if(!empty($element_info[$element_id]['range_max']) && !empty($element_info[$element_id]['range_min'])){
						$rules[$element_name]['range_value'] = $element_info[$element_id]['range_min'].'#'.$element_info[$element_id]['range_max'];
					}else if(!empty($element_info[$element_id]['range_max'])){
						$rules[$element_name]['max_value'] = $element_info[$element_id]['range_max'];
					}else if(!empty($element_info[$element_id]['range_min'])){
						$rules[$element_name]['min_value'] = $element_info[$element_id]['range_min'];
					}	
				}
																
				$target_input[$element_name] = $element_data;
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}

				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value'] = htmlspecialchars($element_data); 
				
				//prepare data for table column
				$table_data[$element_name] = $element_data; 
				
				//if the user removed the number, set the value to null
				if($table_data[$element_name] == ""){
					$table_data[$element_name] = null;
				}

			}elseif ('url' == $element_type){ //Website
				
				if($element_info[$element_id]['is_required']){
					$rules[$element_name]['required'] 	= true;
				}
				
				if($element_info[$element_id]['is_unique']){
					$rules[$element_name]['unique'] 	= $form_id.'#'.$element_name;
					$target_input['dbh'] = $dbh; //we need to pass the $dbh for this 'unique' rule
				}
				
				$rules[$element_name]['website'] = true;
														
				if($element_data == 'http://'){
					$element_data = '';
				}
						
				$target_input[$element_name] = $element_data;
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value'] = htmlspecialchars($element_data); 
				
				//prepare data for table column
				$table_data[$element_name] = $element_data; 
				
			}elseif ('email' == $element_type){ //Email
				
				if($element_info[$element_id]['is_required']){
					$rules[$element_name]['required'] 	= true;
				}
				
				if($element_info[$element_id]['is_unique']){
					$rules[$element_name]['unique'] 	= $form_id.'#'.$element_name;
					$target_input['dbh'] = $dbh; //we need to pass the $dbh for this 'unique' rule
				}
				
				$rules[$element_name]['email'] = true;
														
										
				$target_input[$element_name] = $element_data;
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value'] = htmlspecialchars($element_data); 
				
				//prepare data for table column
				$table_data[$element_name] = $element_data; 
				
			}elseif ('simple_name' == $element_type){ //Simple Name
				
				if(!empty($processed_elements) && is_array($processed_elements) && in_array($element_name,$processed_elements)){
					continue;
				}
				
				//compound element, grab the other element, 2 elements total	
				$element_name_2 = substr($element_name,0,-1).'2';
				
				$processed_elements[] = $element_name_2; //put this element into array so that it won't be processed on next loop
				
				if($element_info[$element_id]['is_required']){
					$rules[$element_name]['required'] 	= true;
					$rules[$element_name_2]['required'] = true;
				}
																		
				$target_input[$element_name]   = $user_input[$element_name];
				$target_input[$element_name_2] = $user_input[$element_name_2];
				
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value']   = htmlspecialchars($user_input[$element_name]); 
				$form_data[$element_name_2]['default_value'] = htmlspecialchars($user_input[$element_name_2]);
				
				//prepare data for table column
				$table_data[$element_name] 	 = $user_input[$element_name]; 
				$table_data[$element_name_2] = $user_input[$element_name_2];
				
			}elseif ('simple_name_wmiddle' == $element_type){ //Simple Name with Middle
				
				if(!empty($processed_elements) && is_array($processed_elements) && in_array($element_name,$processed_elements)){
					continue;
				}
				
				//compound element, grab the other elements, 3 elements total	
				$element_name_2 = substr($element_name,0,-1).'2';
				$element_name_3 = substr($element_name,0,-1).'3';
				
				$processed_elements[] = $element_name_2; //put this element into array so that it won't be processed on next loop
				$processed_elements[] = $element_name_3;
				
				if($element_info[$element_id]['is_required']){
					$rules[$element_name]['required'] 	= true;
					$rules[$element_name_2]['required'] = true;
					$rules[$element_name_3]['required'] = true;
				}
																		
				$target_input[$element_name]   = $user_input[$element_name];
				$target_input[$element_name_2] = $user_input[$element_name_2];
				$target_input[$element_name_3] = $user_input[$element_name_3];
				
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value']   = htmlspecialchars($user_input[$element_name]); 
				$form_data[$element_name_2]['default_value'] = htmlspecialchars($user_input[$element_name_2]);
				$form_data[$element_name_3]['default_value'] = htmlspecialchars($user_input[$element_name_3]);
				
				//prepare data for table column
				$table_data[$element_name] 	 = $user_input[$element_name]; 
				$table_data[$element_name_2] = $user_input[$element_name_2];
				$table_data[$element_name_3] = $user_input[$element_name_3];
				
			}elseif ('name' == $element_type){ //Name -  Extended
				
				if(!empty($processed_elements) && is_array($processed_elements) && in_array($element_name,$processed_elements)){
					continue;
				}
				
				//compound element, grab the other element, 4 elements total	
				//only element no 2&3 matters (first and last name)
				$element_name_2 = substr($element_name,0,-1).'2';
				$element_name_3 = substr($element_name,0,-1).'3';
				$element_name_4 = substr($element_name,0,-1).'4';
				
				$processed_elements[] = $element_name_2; //put this element into array so that it won't be processed next
				$processed_elements[] = $element_name_3;
				$processed_elements[] = $element_name_4;
								
				if($element_info[$element_id]['is_required']){
					$rules[$element_name_2]['required'] = true;
					$rules[$element_name_3]['required'] = true;
				}
																		
				$target_input[$element_name_2] = $user_input[$element_name_2];
				$target_input[$element_name_3] = $user_input[$element_name_3];
				
				
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value']   = htmlspecialchars($user_input[$element_name]); 
				$form_data[$element_name_2]['default_value'] = htmlspecialchars($user_input[$element_name_2]);
				$form_data[$element_name_3]['default_value'] = htmlspecialchars($user_input[$element_name_3]);
				$form_data[$element_name_4]['default_value'] = htmlspecialchars($user_input[$element_name_4]);
				
				//prepare data for table column
				$table_data[$element_name] 	 = $user_input[$element_name]; 
				$table_data[$element_name_2] = $user_input[$element_name_2];
				$table_data[$element_name_3] = $user_input[$element_name_3];
				$table_data[$element_name_4] = $user_input[$element_name_4];
				
			}elseif ('name_wmiddle' == $element_type){ //Name -  Extended, with Middle
				
				if(!empty($processed_elements) && is_array($processed_elements) && in_array($element_name,$processed_elements)){
					continue;
				}
				
				//compound element, grab the other element, 5 elements total	
				//only element no 2,3,4 matters (first, middle, last name)
				$element_name_2 = substr($element_name,0,-1).'2';
				$element_name_3 = substr($element_name,0,-1).'3';
				$element_name_4 = substr($element_name,0,-1).'4';
				$element_name_5 = substr($element_name,0,-1).'5';
				
				$processed_elements[] = $element_name_2; //put this element into array so that it won't be processed next
				$processed_elements[] = $element_name_3;
				$processed_elements[] = $element_name_4;
				$processed_elements[] = $element_name_5;
								
				if($element_info[$element_id]['is_required']){
					$rules[$element_name_2]['required'] = true;
					$rules[$element_name_3]['required'] = true;
					$rules[$element_name_4]['required'] = true;
				}
																		
				$target_input[$element_name_2] = $user_input[$element_name_2];
				$target_input[$element_name_3] = $user_input[$element_name_3];
				$target_input[$element_name_4] = $user_input[$element_name_4];
				
				
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value']   = htmlspecialchars($user_input[$element_name]); 
				$form_data[$element_name_2]['default_value'] = htmlspecialchars($user_input[$element_name_2]);
				$form_data[$element_name_3]['default_value'] = htmlspecialchars($user_input[$element_name_3]);
				$form_data[$element_name_4]['default_value'] = htmlspecialchars($user_input[$element_name_4]);
				$form_data[$element_name_5]['default_value'] = htmlspecialchars($user_input[$element_name_5]);
				
				//prepare data for table column
				$table_data[$element_name] 	 = $user_input[$element_name]; 
				$table_data[$element_name_2] = $user_input[$element_name_2];
				$table_data[$element_name_3] = $user_input[$element_name_3];
				$table_data[$element_name_4] = $user_input[$element_name_4];
				$table_data[$element_name_5] = $user_input[$element_name_5];
				
			}elseif ('time' == $element_type){ //Time
				
				if(!empty($processed_elements) && is_array($processed_elements) && in_array($element_name,$processed_elements)){
					continue;
				}
				
				//compound element, grab the other element, 4 elements total	
				
				$element_name_2 = substr($element_name,0,-1).'2';
				$element_name_3 = substr($element_name,0,-1).'3';
				$element_name_4 = substr($element_name,0,-1).'4';
				
				$processed_elements[] = $element_name_2; //put this element into array so that it won't be processed next
				$processed_elements[] = $element_name_3;
				$processed_elements[] = $element_name_4;
								
				if($element_info[$element_id]['is_required']){
					$rules[$element_name_2]['required'] = true;
					$rules[$element_name_3]['required'] = true;
					if(empty($element_info[$element_id]['time_24hour'])){
						$rules[$element_name_4]['required'] = true;
					}
				}

				//check time validity if any of the compound field entered
				$time_entry_exist = false;
				if(!empty($user_input[$element_name]) || !empty($user_input[$element_name_2]) || !empty($user_input[$element_name_3])){
					$rules['element_time']['time'] = true;
					$time_entry_exist = true;
				}
				
				//for backward compatibility with machform v2 and beyond
				if($element_info[$element_id]['constraint'] == 'show_seconds'){
					$element_info[$element_id]['time_showsecond'] = 1;
				}
				
				if($time_entry_exist && empty($element_info[$element_id]['time_showsecond'])){
					$user_input[$element_name_3] = '00';
				}
				
				if($element_info[$element_id]['is_unique']){
					$rules['element_time_no_meridiem']['unique'] = $form_id.'#'.substr($element_name,0,-2); //to check uniquenes we need to use 24 hours HH:MM:SS format
					$target_input['dbh'] = $dbh; //we need to pass the $dbh for this 'unique' rule
				}
							
				$target_input[$element_name_2] = $user_input[$element_name_2];
				$target_input[$element_name_3] = $user_input[$element_name_3];
				$target_input[$element_name_4] = $user_input[$element_name_4];
				if($time_entry_exist){
					$target_input['element_time']  = trim($user_input[$element_name].':'.$user_input[$element_name_2].':'.$user_input[$element_name_3].' '.$user_input[$element_name_4]);
					$target_input['element_time_no_meridiem'] = @date("G:i:s",strtotime($target_input['element_time']));
				}
				
				
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value']   = htmlspecialchars($user_input[$element_name]); 
				$form_data[$element_name_2]['default_value'] = htmlspecialchars($user_input[$element_name_2]);
				$form_data[$element_name_3]['default_value'] = htmlspecialchars($user_input[$element_name_3]);
				$form_data[$element_name_4]['default_value'] = htmlspecialchars($user_input[$element_name_4]);
				
				//prepare data for table column
				$table_data[substr($element_name,0,-2)] 	 = @$target_input['element_time_no_meridiem'];
								
			}elseif ('address' == $element_type){ //Address
				
				if(!empty($processed_elements) && is_array($processed_elements) && in_array($element_name,$processed_elements)){
					continue;
				}
				
				//compound element, grab the other element, 6 elements total, element #2 (address line 2) is optional	
				$element_name_2 = substr($element_name,0,-1).'2';
				$element_name_3 = substr($element_name,0,-1).'3';
				$element_name_4 = substr($element_name,0,-1).'4';
				$element_name_5 = substr($element_name,0,-1).'5';
				$element_name_6 = substr($element_name,0,-1).'6';
				
				$processed_elements[] = $element_name_2; //put this element into array so that it won't be processed next
				$processed_elements[] = $element_name_3;
				$processed_elements[] = $element_name_4;
				$processed_elements[] = $element_name_5;
				$processed_elements[] = $element_name_6;
								
				if($element_info[$element_id]['is_required']){
					$rules[$element_name]['required'] = true;
					$rules[$element_name_3]['required'] = true;
					$rules[$element_name_4]['required'] = true;
					$rules[$element_name_5]['required'] = true;
					$rules[$element_name_6]['required'] = true;
					
				}
				
				$target_input[$element_name]   = $user_input[$element_name];
				$target_input[$element_name_3] = $user_input[$element_name_3];
				$target_input[$element_name_4] = $user_input[$element_name_4];
				$target_input[$element_name_5] = $user_input[$element_name_5];
				$target_input[$element_name_6] = $user_input[$element_name_6];
			
				
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value']   = htmlspecialchars($user_input[$element_name]); 
				$form_data[$element_name_2]['default_value'] = htmlspecialchars($user_input[$element_name_2]);
				$form_data[$element_name_3]['default_value'] = htmlspecialchars($user_input[$element_name_3]);
				$form_data[$element_name_4]['default_value'] = htmlspecialchars($user_input[$element_name_4]);
				$form_data[$element_name_5]['default_value'] = htmlspecialchars($user_input[$element_name_5]);
				$form_data[$element_name_6]['default_value'] = htmlspecialchars($user_input[$element_name_6]);
				
				//prepare data for table column
				$table_data[$element_name] 	 = $user_input[$element_name]; 
				$table_data[$element_name_2] = $user_input[$element_name_2];
				$table_data[$element_name_3] = $user_input[$element_name_3];
				$table_data[$element_name_4] = $user_input[$element_name_4];
				$table_data[$element_name_5] = $user_input[$element_name_5];
				$table_data[$element_name_6] = $user_input[$element_name_6];
				
			}elseif ('money' == $element_type){ //Price
				
				if(!empty($processed_elements) && is_array($processed_elements) && in_array($element_name,$processed_elements)){
					continue;
				}
				
				//compound element, grab the other element, 2 elements total (for currency other than yen)	
				if($element_info[$element_id]['constraint'] != 'yen'){ //if other than yen
					$base_element_name = substr($element_name,0,-1);
					$element_name_2 = $base_element_name.'2';
					$processed_elements[] = $element_name_2;
										
					if($element_info[$element_id]['is_required']){
						$rules[$base_element_name]['required'] 	= true;
					}
					
					//check for numeric if not empty
					if(!empty($user_input[$element_name]) || !empty($user_input[$element_name_2])){
						$rules[$base_element_name]['numeric'] = true;
					}
					
					if($element_info[$element_id]['is_unique']){
						$rules[$base_element_name]['unique'] 	= $form_id.'#'.substr($element_name,0,-2);
						$target_input['dbh'] = $dbh; //we need to pass the $dbh for this 'unique' rule
					}
				
					$target_input[$base_element_name]   = $user_input[$element_name].'.'.$user_input[$element_name_2]; //join dollar+cent
					if($target_input[$base_element_name] == '.'){
						$target_input[$base_element_name] = '';
					}
					
					//save old data into array, for form redisplay in case errors occured
					$form_data[$element_name]['default_value']   = htmlspecialchars($user_input[$element_name]); 
					$form_data[$element_name_2]['default_value'] = htmlspecialchars($user_input[$element_name_2]);
					
					//prepare data for table column
					if(!empty($user_input[$element_name]) || !empty($user_input[$element_name_2]) 
					   || $user_input[$element_name] === '0' || $user_input[$element_name_2] === '0'){
					  	$table_data[substr($element_name,0,-2)] = $user_input[$element_name].'.'.$user_input[$element_name_2];
					}
					
					//if the user removed the number, set the value to null
					if($user_input[$element_name] == "" && $user_input[$element_name_2] == ""){
						$table_data[substr($element_name,0,-2)] = null;
					} 		
				}else{
					if($element_info[$element_id]['is_required']){
						$rules[$element_name]['required'] 	= true;
					}
					
					//check for numeric if not empty
					if(!empty($user_input[$element_name])){ 
						$rules[$element_name]['numeric'] = true;
					}
					
					if($element_info[$element_id]['is_unique']){
						$rules[$element_name]['unique'] 	= $form_id.'#'.$element_name;
						$target_input['dbh'] = $dbh; //we need to pass the $dbh for this 'unique' rule
					}
									
					$target_input[$element_name]   = $user_input[$element_name];
					
					//save old data into array, for form redisplay in case errors occured
					$form_data[$element_name]['default_value']   = htmlspecialchars($user_input[$element_name]); 
					
					//prepare data for table column
					$table_data[$element_name] 	 = $user_input[$element_name];
					
					//if the user removed the number, set the value to null
					if($table_data[$element_name] == ""){
						$table_data[$element_name] = null;
					} 
								
				}
								
				
												
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
			}elseif ('checkbox' == $element_type){ //Checkboxes
				
				if(!empty($processed_elements) && is_array($processed_elements) && in_array($element_name,$processed_elements)){
					continue;
				}
				
				
				$all_child_array = array();
				$all_child_array = $checkbox_childs[$element_id];  
				
				
				$base_element_name = 'element_' . $element_id . '_';
					
				if(!empty($element_info[$element_id]['choice_has_other'])){
					$all_checkbox_value = $input[$base_element_name.'other'];
						
					//save old data into array, for form redisplay in case errors occured
					$form_data[$base_element_name.'other']['default_value'] = $input[$base_element_name.'other']; 
						
					$table_data[$base_element_name.'other'] = $input[$base_element_name.'other'];
				}else{
					$all_checkbox_value = '';
				}
				
				if($element_info[$element_id]['is_required']){
					//checking 'required' for checkboxes is more complex
					//we need to get total child, and join it into one element
					//only one element is required to be checked
					
					foreach ($all_child_array as $i){
						$all_checkbox_value .= $user_input[$base_element_name.$i];
						$processed_elements[] = $base_element_name.$i;
						
						//save old data into array, for form redisplay in case errors occured
						$form_data[$base_element_name.$i]['default_value']   = $user_input[$base_element_name.$i];
						
						//prepare data for table column
						$table_data[$base_element_name.$i] = $user_input[$base_element_name.$i];
				
					}
					
					$rules[$base_element_name]['required'] 	= true;
					
					$target_input[$base_element_name] = $all_checkbox_value;
					$validation_result = mf_validate_element($target_input,$rules);
					
					if($validation_result !== true){
						if($is_matrix_field && !empty($matrix_childs_array[$element_id])){
							$error_elements[$matrix_childs_array[$element_id]] = $validation_result;
						}else{
							$error_elements[$element_id] = $validation_result;
						}
					}	
					
				}else{ //if not required, we only need to capture all data
						
					foreach ($all_child_array as $i){
											
						//save old data into array, for form redisplay in case errors occured
						$form_data[$base_element_name.$i]['default_value']   = $user_input[$base_element_name.$i];
						
						//prepare data for table column
						$table_data[$base_element_name.$i] = $user_input[$base_element_name.$i];
					}
				    
				}
			}elseif ('select' == $element_type){ //Drop Down
				
				if($element_info[$element_id]['is_required']){
					$rules[$element_name]['required'] 	= true;
				}
																
				$target_input[$element_name] = $element_data;
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value'] = $user_input[$element_name]; 
				
				//prepare data for table column
				$table_data[$element_name] = $user_input[$element_name]; 
				
			}elseif ('date' == $element_type || 'europe_date' == $element_type){ //Date
				
				if(!empty($processed_elements) && is_array($processed_elements) && in_array($element_name,$processed_elements)){
					continue;
				}
				
				//compound element, grab the other element, 3 elements total	
				
				$element_name_2 = substr($element_name,0,-1).'2';
				$element_name_3 = substr($element_name,0,-1).'3';
								
				$processed_elements[] = $element_name_2; //put this element into array so that it won't be processed next
				$processed_elements[] = $element_name_3;
												
				if(!empty($element_info[$element_id]['is_required'])){
					$rules[$element_name]['required'] = true;
					$rules[$element_name_2]['required'] = true;
					$rules[$element_name_3]['required'] = true;
				}
				
				$rules['element_date']['date'] = 'yyyy/mm/dd';
				
				if(!empty($element_info[$element_id]['is_unique'])){
					$rules['element_date']['unique'] = $form_id.'#'.substr($element_name,0,-2); 
					$target_input['dbh'] = $dbh; //we need to pass the $dbh for this 'unique' rule
				}
				
				if(!empty($element_info[$element_id]['date_enable_range'])){
					if(!empty($element_info[$element_id]['date_range_max']) || !empty($element_info[$element_id]['date_range_min'])){
						$rules['element_date']['date_range'] = $element_info[$element_id]['date_range_min'].'#'.$element_info[$element_id]['date_range_max'];
					}
				}
				
				//disable past/future dates, if enabled. this rule override the date range rule being set above
				if(!empty($element_info[$element_id]['date_disable_past_future'])){
					$today_date = date('Y-m-d',time());
					
					if($element_info[$element_id]['date_past_future'] == 'p'){ //disable past dates
						$rules['element_date']['date_range'] = $today_date.'#0000-00-00';
					}else if($element_info[$element_id]['date_past_future'] == 'f'){ //disable future dates
						$rules['element_date']['date_range'] = '0000-00-00#'.$today_date;
					}
				}
				
				//check for weekend dates rule
				if(!empty($element_info[$element_id]['date_disable_weekend'])){
					$rules['element_date']['date_weekend'] = true;
				}
				
				//get disabled dates (either coming from 'date selection limit' or 'disable specific dates' rules)
				$disabled_dates = array();
				
				//get disabled dates from 'date selection limit' rule
				if(!empty($element_info[$element_id]['date_enable_selection_limit']) && !empty($element_info[$element_id]['date_selection_max'])){
				
					$sub_query = "select 
										selected_date 
									from (
											select 
												  date_format(element_{$element_id},'%Y-%c-%e') as selected_date,
												  count(element_{$element_id}) as total_selection 
										      from 
										      	  ".MF_TABLE_PREFIX."form_{$form_id} 
										     where 
										     	  status=1 and element_{$element_id} is not null 
										  group by 
										  		  element_{$element_id}
										 ) as A
								   where 
										 A.total_selection >= ?";
					
					$params = array($element_info[$element_id]['date_selection_max']);
					$sub_sth = mf_do_query($sub_query,$params,$dbh);
					
					while($sub_row = mf_do_fetch_result($sub_sth)){
						$disabled_dates[] = $sub_row['selected_date'];
					}
				}
				
				
				//get disabled dates from 'disable specific dates' rules
				if(!empty($element_info[$element_id]['date_disable_specific']) && !empty($element_info[$element_id]['date_disabled_list'])){
					$exploded = array();
					$exploded = explode(',',$element_info[$element_id]['date_disabled_list']);
					foreach($exploded as $date_value){
						$disabled_dates[] = date('Y-n-j',strtotime(trim($date_value)));
					}
				}
				
				if(!empty($disabled_dates)){
					$rules['element_date']['disabled_dates'] = $disabled_dates;
				}
				
				$target_input[$element_name] = $user_input[$element_name];
				$target_input[$element_name_2] = $user_input[$element_name_2];
				$target_input[$element_name_3] = $user_input[$element_name_3];
				
				$base_element_name = substr($element_name,0,-2);
				if('date' == $element_type){ //MM/DD/YYYY
					$target_input['element_date'] = $user_input[$element_name_3].'-'.$user_input[$element_name].'-'.$user_input[$element_name_2];
					
					//prepare data for table column
					$table_data[$base_element_name] = $user_input[$element_name_3].'-'.$user_input[$element_name].'-'.$user_input[$element_name_2];
				}else{ //DD/MM/YYYY
					$target_input['element_date'] = $user_input[$element_name_3].'-'.$user_input[$element_name_2].'-'.$user_input[$element_name];
					
					//prepare data for table column
					$table_data[$base_element_name] = $user_input[$element_name_3].'-'.$user_input[$element_name_2].'-'.$user_input[$element_name];
				}
				
				$test_empty = str_replace('-','',$target_input['element_date']); //if user not submitting any entry, remove the dashes
				if(empty($test_empty)){
					unset($target_input['element_date']);
					$table_data[$base_element_name] = '';
				}
										
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value']   = htmlspecialchars($user_input[$element_name]); 
				$form_data[$element_name_2]['default_value'] = htmlspecialchars($user_input[$element_name_2]);
				$form_data[$element_name_3]['default_value'] = htmlspecialchars($user_input[$element_name_3]);
								
			}elseif ('simple_phone' == $element_type){ //Simple Phone
							
				if($element_info[$element_id]['is_required']){
					$rules[$element_name]['required'] 	= true;
				}
				
				if(!empty($user_input[$element_name])){
					$rules[$element_name]['simple_phone'] = true;
				}
				
				if($element_info[$element_id]['is_unique']){
					$rules[$element_name]['unique'] 	= $form_id.'#'.$element_name;
					$target_input['dbh'] = $dbh; //we need to pass the $dbh for this 'unique' rule
				}
									
				$target_input[$element_name]   = $user_input[$element_name];
							
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value']   = htmlspecialchars($user_input[$element_name]); 
				
				//prepare data for table column
				$table_data[$element_name] = $user_input[$element_name]; 
								
			}elseif ('phone' == $element_type){ //Phone - US format
				
				if(!empty($processed_elements) && is_array($processed_elements) && in_array($element_name,$processed_elements)){
					continue;
				}
				
				//compound element, grab the other element, 3 elements total	
				
				$element_name_2 = substr($element_name,0,-1).'2';
				$element_name_3 = substr($element_name,0,-1).'3';
								
				$processed_elements[] = $element_name_2; //put this element into array so that it won't be processed next
				$processed_elements[] = $element_name_3;
												
				if($element_info[$element_id]['is_required']){
					$rules[$element_name]['required']   = true;
					$rules[$element_name_2]['required'] = true;
					$rules[$element_name_3]['required'] = true;
				}
				
				$rules['element_phone']['phone'] = true;
				
				
				if($element_info[$element_id]['is_unique']){
					$rules['element_phone']['unique'] = $form_id.'#'.substr($element_name,0,-2); 
					$target_input['dbh'] = $dbh; //we need to pass the $dbh for this 'unique' rule
				}
				
				$target_input[$element_name]   = $user_input[$element_name];			
				$target_input[$element_name_2] = $user_input[$element_name_2];
				$target_input[$element_name_3] = $user_input[$element_name_3];
				$target_input['element_phone'] = $user_input[$element_name].$user_input[$element_name_2].$user_input[$element_name_3];
									
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value']   = htmlspecialchars($user_input[$element_name]); 
				$form_data[$element_name_2]['default_value'] = htmlspecialchars($user_input[$element_name_2]);
				$form_data[$element_name_3]['default_value'] = htmlspecialchars($user_input[$element_name_3]);
				
				//prepare data for table column
				$table_data[substr($element_name,0,-2)] = $user_input[$element_name].$user_input[$element_name_2].$user_input[$element_name_3];
				
			}elseif ('email' == $element_type){ //Email
				
				if($element_info[$element_id]['is_required']){
					$rules[$element_name]['required'] 	= true;
				}
				
				if($element_info[$element_id]['is_unique']){
					$rules[$element_name]['unique'] 	= $form_id.'#'.$element_name;
					$target_input['dbh'] = $dbh; //we need to pass the $dbh for this 'unique' rule
				}
				
				$rules[$element_name]['email'] = true;
																
				$target_input[$element_name] = $element_data;
				$validation_result = mf_validate_element($target_input,$rules);
				
				if($validation_result !== true){
					$error_elements[$element_id] = $validation_result;
				}
				
				//save old data into array, for form redisplay in case errors occured
				$form_data[$element_name]['default_value']   = htmlspecialchars($user_input[$element_name]); 
				
				//prepare data for table column
				$table_data[$element_name] = $user_input[$element_name]; 
				
			}elseif ('file' == $element_type){ //File
				$listfile_name = $input['machform_data_path'].$mf_settings['upload_dir']."/form_{$form_id}/files/listfile_{$input[$element_name.'_token']}.php";
				
				if(!file_exists($listfile_name)){
					
					$check_filetype = false;
					if($element_info[$element_id]['is_required']){
						$rules[$element_name]['required_file'] 	= true;
						$rules[$element_name]['filetype'] 	= true;
						$check_filetype = true;
						
						//if form review enabled, and user pressed back button after going to review page
						//disable the required file checking if file already uploaded
						if(!empty($_SESSION['review_id'])){
							if(!empty($element_info[$element_id]['existing_file'])){
								unset($rules[$element_name]['required_file']);
								unset($rules[$element_name]['filetype']);
								$check_filetype = false;
							}
						}
					}else{
						if($_FILES[$element_name]['size'] > 0){
							$rules[$element_name]['filetype'] 	= true;
							$check_filetype = true;
						}
					}
					
					if($check_filetype == true && !empty($element_info[$element_id]['file_enable_type_limit'])){
						if($element_info[$element_id]['file_block_or_allow'] == 'b'){ //block file type
							$target_input['file_block_or_allow'] = 'b';
						}elseif($element_info[$element_id]['file_block_or_allow'] == 'a'){
							$target_input['file_block_or_allow'] = 'a';
						}
						
						$target_input['file_type_list'] = $element_info[$element_id]['file_type_list'];
					}
																	
					$target_input[$element_name] = $element_name; //special for file, only need to pass input name
					$validation_result = mf_validate_element($target_input,$rules);
					
					if($validation_result !== true){
						$error_elements[$element_id] = $validation_result;
					}else{
						//if validation passed, store uploaded file info into array
						if($_FILES[$element_name]['size'] > 0){
							$uploaded_files[] = $element_name;
						}
					}

				}else{ //if files were uploaded using advance uploader
					//file type validation already done in upload.php, so we don't need to do validation again here
					
					//store uploaded file list into array
					$current_element_uploaded_files_advance = array();
					$current_element_uploaded_files_advance = file($listfile_name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
					array_shift($current_element_uploaded_files_advance); //remove the first index of the array
					array_pop($current_element_uploaded_files_advance); //remove the last index of the array
					
					$uploaded_files_advance[$element_id]['listfile_name'] 	 = $listfile_name;
					$uploaded_files_advance[$element_id]['listfile_content'] = $current_element_uploaded_files_advance;
					
					
					//save old token into array, for form redisplay in case errors occured
					$form_data[$element_name]['file_token']  = $input[$element_name.'_token'];
					
				}
						
				
			}
			
		}

						
		
		//get form redirect info, if any
		//get form properties data
		$query 	= "select 
						 form_redirect,
						 form_redirect_enable,
						 form_email,
						 form_unique_ip,
						 form_captcha,
						 form_captcha_type,
						 form_review,
						 form_page_total,
						 form_resume_enable,
						 form_name,
						 esl_enable,
						 esl_from_name,
						 esl_from_email_address,
						 esl_subject,
						 esl_content,
						 esl_plain_text,
						 esr_enable,
						 esr_email_address,
						 esr_from_name,
						 esr_from_email_address,
						 esr_subject,
						 esr_content,
						 esr_plain_text,
						 payment_enable_merchant,
						 payment_merchant_type,
						 ifnull(payment_paypal_email,'') payment_paypal_email,
						 payment_paypal_language,
						 payment_currency,
						 payment_show_total,
						 payment_total_location,
						 payment_enable_recurring,
						 payment_recurring_cycle,
						 payment_recurring_unit,
						 payment_price_type,
						 payment_price_amount,
						 payment_price_name
				     from 
				     	 `".MF_TABLE_PREFIX."forms` 
				    where 
				    	 form_id=?";
		
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
		
		if(!empty($row['form_redirect_enable'])){
			$form_redirect   = $row['form_redirect'];
		}

		$form_unique_ip  = $row['form_unique_ip'];
		$form_email 	 = $row['form_email'];
		$form_captcha	 = $row['form_captcha'];
		$form_captcha_type	= $row['form_captcha_type'];
		$form_review	 = $row['form_review'];
		$form_page_total = $row['form_page_total'];
		$form_name		 = $row['form_name'];
		
		$user_ip_address 	= $_SERVER['REMOTE_ADDR'];
		
		$esl_enable	    = $row['esl_enable'];
		$esl_from_name 	= $row['esl_from_name'];
		$esl_from_email_address = $row['esl_from_email_address'];
		$esl_subject 	= $row['esl_subject'];
		$esl_content 	= $row['esl_content'];
		$esl_plain_text	= $row['esl_plain_text'];
		
		$esr_enable 	= $row['esr_enable'];
		$esr_email_address 	= $row['esr_email_address'];
		$esr_from_name 	= $row['esr_from_name'];
		$esr_from_email_address = $row['esr_from_email_address'];
		$esr_subject 	= $row['esr_subject'];
		$esr_content 	= $row['esr_content'];
		$esr_plain_text	= $row['esr_plain_text'];
		
		
		$payment_enable_merchant = (int) $row['payment_enable_merchant'];
		if($payment_enable_merchant < 1){
			$payment_enable_merchant = 0;
		}
		
		$payment_merchant_type 	 = $row['payment_merchant_type'];
		$payment_paypal_email 	 = $row['payment_paypal_email'];
		$payment_paypal_language = $row['payment_paypal_language'];
		
		$payment_currency 		  = $row['payment_currency'];
		$payment_show_total 	  = (int) $row['payment_show_total'];
		$payment_total_location   = $row['payment_total_location'];
		$payment_enable_recurring = (int) $row['payment_enable_recurring'];
		$payment_recurring_cycle  = (int) $row['payment_recurring_cycle'];
		$payment_recurring_unit   = $row['payment_recurring_unit'];
		
		$payment_price_type   = $row['payment_price_type'];
		$payment_price_amount = (float) $row['payment_price_amount'];
		$payment_price_name   = $row['payment_price_name'];
		
		//if the user is saving a form to resume later, we need to discard all validation errors
		if(!empty($input['generate_resume_url']) && !empty($row['form_resume_enable']) && ($form_page_total > 1)){
			$is_saving_form_resume = true;
			$error_elements = array();
		}else{
			$is_saving_form_resume = false;
		}
		
		$process_result['form_redirect']  = $form_redirect;
		$process_result['old_values'] 	  = $form_data;
		$process_result['error_elements'] = $error_elements;
		
		//check for ip address
		if(!empty($form_unique_ip)){
			//if ip address checking enabled, compare user ip address with value in db
			$query = "select count(id) total_ip from `".MF_TABLE_PREFIX."form_{$form_id}` where ip_address=?";
			$params = array($user_ip_address);
			
			$sth = mf_do_query($query,$params,$dbh);
			$row = mf_do_fetch_result($sth);
			if(!empty($row['total_ip'])){
				$process_result['custom_error'] = 'Sorry, but this form is limited to one submission per user.';
			}
		}
		
		//check for captcha if enabled and there is no errors from previous fields
		//on multipage form, captcha should be validated on the last page only
		if(!empty($form_captcha) && empty($error_elements)){
			
			if($form_page_total == 1 || ($form_page_total == $page_number)){
				
				if($form_captcha_type == 'i'){//if simple image captcha is being used
					
					if(!empty($_POST['captcha_response_field'])){
						
						$captcha_response_field = trim($_POST['captcha_response_field']);
						 if (PhpCaptcha::Validate($captcha_response_field) !== true) {
						 	$error_elements['element_captcha'] = 'incorrect-captcha-sol';
					        $process_result['error_elements'] = $error_elements;
						 }
					}else{ //user not entered the words at all
						
						$error_elements['element_captcha'] = 'el-required';
					    $process_result['error_elements']  = $error_elements;
					}
					
				}else if($form_captcha_type == 't'){//if simple text captcha is being used
					
					if(!empty($_POST['captcha_response_field'])){
						
						$captcha_response_field =  strtolower(trim($_POST['captcha_response_field']));
						
						if($captcha_response_field != strtolower($_SESSION['MF_TEXT_CAPTCHA_ANSWER'])) {
						 	$error_elements['element_captcha'] = 'incorrect-text-captcha-sol';
					        $process_result['error_elements'] = $error_elements;
						}else{
							unset($_SESSION['MF_TEXT_CAPTCHA_ANSWER']);
						}
					}else{ //user not entered the words at all
						
						$error_elements['element_captcha'] = 'el-text-required';
					    $process_result['error_elements']  = $error_elements;
					}
					
				}else if($form_captcha_type == 'r'){ //otherwise reCaptcha is being used
					if(!empty($_POST['recaptcha_response_field'])){
						$recaptcha_response = recaptcha_check_answer (RECAPTCHA_PRIVATE_KEY,
			                                        $user_ip_address,
			                                        $_POST["recaptcha_challenge_field"],
			                                        $_POST["recaptcha_response_field"]);
						
			            if($recaptcha_response !== false){ //if false, then we can't connect to captcha server, bypass captcha checking            	
			            	if ($recaptcha_response->is_valid === false) {
								$error_elements['element_captcha'] = $recaptcha_response->error;
					            $process_result['error_elements'] = $error_elements;
					        }
			            }
					}else{ //user not entered the words at all
						$error_elements['element_captcha'] = 'el-required';
					    $process_result['error_elements']  = $error_elements;
					}
				}
			}
            
		}
		
		
		//insert ip address and date created
		$table_data['ip_address']   = $user_ip_address;
		$table_data['date_created'] = date("Y-m-d H:i:s");
		
		
		$is_inserted = false;
		
		//start insert data into table ----------------------		
		//dynamically create the field list and field values, based on the input given
		if(!empty($table_data) && empty($error_elements) && empty($process_result['custom_error'])){
			$has_value = false;
			
			$field_list = '';
			$field_values = '';
			
			foreach ($table_data as $key=>$value){
				
				if($value == ''){ //don't insert blank entry
					continue;
				}
				
				$field_list    .= "`{$key}`,";
				$field_values  .= ":{$key},";
				$params_table_data[':'.$key] = $value;
				
				if(!empty($value)){
					$has_value = true;
				}
			}
			
			//add session_id to query if 'form review' enabled or this is multipage forms 
			if(!empty($form_review) || ($form_page_total > 1)){
				//save previously uploaded file list, so users don't need to reupload files 
				//get all file uploads elements first
				
					$session_id = session_id();
					$file_uploads_array = array();
					
					$query = "SELECT 
									element_id 
								FROM 
									".MF_TABLE_PREFIX."form_elements 
							   WHERE 
							   		form_id=? AND 
							   		element_type='file' AND 
							   		element_is_private=0";
					$params = array($form_id);
					
					$sth = mf_do_query($query,$params,$dbh);
					while($row = mf_do_fetch_result($sth)){
						$file_uploads_array[] = 'element_'.$row['element_id'];
					}
					
					$file_uploads_column = implode('`,`',$file_uploads_array);
					$file_uploads_column = '`'.$file_uploads_column.'`';
					
					if(!empty($file_uploads_array)){
						
						if(!empty($_SESSION['review_id'])){ //if this is single page form and has review enabled
							$query = "SELECT {$file_uploads_column} FROM `".MF_TABLE_PREFIX."form_{$form_id}_review` where id=?";
							$params = array($_SESSION['review_id']);
						}elseif ($form_page_total > 1){ //if this is multi page form
							$query = "SELECT {$file_uploads_column} FROM `".MF_TABLE_PREFIX."form_{$form_id}_review` where session_id=?";
							$params = array($session_id);
						}
						
						
						$sth = mf_do_query($query,$params,$dbh);
						$row = mf_do_fetch_result($sth);
						foreach ($file_uploads_array as $element_name){
							if(!empty($row[$element_name])){
								$uploaded_file_lookup[$element_name] = $row[$element_name];
							}
						}
					}
				
			
				
				//add session_id to query if 'form review' enabled 
				
				$field_list    .= "`session_id`,";
				$field_values  .= ":session_id,";
				$params_table_data[':session_id'] = $session_id;
			}
			
			
			if($has_value){ //if blank form submitted, dont insert anything
							
				//start insert query ----------------------------------------	
				$field_list   = substr($field_list,0,-1);
				$field_values = substr($field_values,0,-1);
				
				if(!empty($edit_id) && ($_SESSION['mf_logged_in'] === true)){
					
					//if this is edit_entry page submission, update the table
					$update_values = '';
					$params_update = array();
					
					unset($table_data['date_created']);
					$table_data['date_updated'] = date("Y-m-d H:i:s");
								
					foreach ($table_data as $key=>$value){
						$update_values .= "`$key`=:$key,";
						$params_update[':'.$key] = $value;
					}
					$params_update[':id'] = $edit_id;
								
					$update_values = substr($update_values,0,-1);
								
					$query = "UPDATE `".MF_TABLE_PREFIX."form_{$form_id}` set 
												$update_values
										  where 
									  	  		`id`=:id;";			
					mf_do_query($query,$params_update,$dbh);

					$record_insert_id = $edit_id;
				}else{
					//insert to temporary table, if form review is enabled or this is multipage form
					if(!empty($form_review) || ($form_page_total > 1)){ 
						if($form_page_total > 1){
							//if this is the first page and the first time being submitted, do insert table
							//otherwise, do update table
							$do_review_insert = false;
							
							if($input['page_number'] == 1){
								$session_id = session_id();
								$query = "SELECT count(`id`) as total_row from ".MF_TABLE_PREFIX."form_{$form_id}_review where session_id=?";
								$params = array($session_id);
								
								$sth = mf_do_query($query,$params,$dbh);
								$row = mf_do_fetch_result($sth);
								if($row['total_row'] == 0){
									$do_review_insert = true;
								}
							}
							
							
							//if this is the first page, do insert
							if($do_review_insert){
								$query = "INSERT INTO `".MF_TABLE_PREFIX."form_{$form_id}_review` ($field_list) VALUES ($field_values);";
								mf_do_query($query,$params_table_data,$dbh);
								
								$record_insert_id = (int) $dbh->lastInsertId();
							}else{
								//otherwise, do update
								//dynamically create the sql update string, based on the input given
								$update_values = '';
								$params_update = array();
								foreach ($table_data as $key=>$value){
									$update_values .= "`$key`=:$key,";
									$params_update[':'.$key] = $value;
								}
								
								$update_values = substr($update_values,0,-1);
								
								$params_update[':session_id'] = $session_id;
								
								$query = "UPDATE `".MF_TABLE_PREFIX."form_{$form_id}_review` set 
															$update_values
													  where 
												  	  		session_id=:session_id;";
								
								mf_do_query($query,$params_update,$dbh);
								
								$query = "SELECT `id` from `".MF_TABLE_PREFIX."form_{$form_id}_review` where session_id=?";
								$params = array($session_id);
								
								$sth = mf_do_query($query,$params,$dbh);
								$row = mf_do_fetch_result($sth);
										
								$record_insert_id = $row['id'];
								
								//if this is the last page of the form, check if form review enabled or not
								//if enabled, simply get the record_insert_id and send it as review_id
								//otherwise, commit form review
								
								if($input['page_number'] == $form_page_total && !empty($input['submit_primary']) && !$is_saving_form_resume){
									
									if(!empty($form_review)){
										//pass the current page number, so the user could go back from the preview page
										$process_result['origin_page_number'] = $input['page_number'];
									}else{
										$query = "SELECT `id` from `".MF_TABLE_PREFIX."form_{$form_id}_review` where session_id=?";
										$params = array($session_id);
								
										$sth = mf_do_query($query,$params,$dbh);
										$row = mf_do_fetch_result($sth);
										
										$commit_options = array();
										$commit_options['send_notification'] = false;

										$commit_result = mf_commit_form_review($dbh,$form_id,$row['id'],$commit_options);
										
										$record_insert_id = $commit_result['record_insert_id'];
										$is_committed = true;
										$_SESSION['mf_form_completed'][$form_id] = true;

									}
								}
								
							}
						}else{
							$query = "SELECT `id` from `".MF_TABLE_PREFIX."form_{$form_id}_review` where session_id=?";
							$params = array($session_id);
								
							$sth = mf_do_query($query,$params,$dbh);
							$row = mf_do_fetch_result($sth);
							
							$record_insert_id = $row['id'];
							
							if(empty($record_insert_id)){
								$query = "INSERT INTO `".MF_TABLE_PREFIX."form_{$form_id}_review` ($field_list) VALUES ($field_values);";
								mf_do_query($query,$params_table_data,$dbh);
								
								$record_insert_id = (int) $dbh->lastInsertId();
							}else{
								$update_values = '';
								$params_update = array();
								
								foreach ($table_data as $key=>$value){
									$update_values .= "`$key`=:$key,";
									$params_update[':'.$key] = $value;
								}
								$params_update[':id'] = $record_insert_id;
								
								$update_values = substr($update_values,0,-1);
								
								$query = "UPDATE `".MF_TABLE_PREFIX."form_{$form_id}_review` set 
															$update_values
													  where 
												  	  		`id`=:id;";
								
								mf_do_query($query,$params_update,$dbh);
								
							}
						}
					}else{ 
						$query = "INSERT INTO `".MF_TABLE_PREFIX."form_{$form_id}` ($field_list) VALUES ($field_values);";
						mf_do_query($query,$params_table_data,$dbh);
								
						$record_insert_id = (int) $dbh->lastInsertId(); 
					}
				}
				//end insert query ------------------------------------------
				
				$is_inserted = true;			
			}
		}
		//end insert data into table -------------------------		
		
		//upload the files
		$write_to_permanent_file = false;
		$write_to_temporary_file = false;
		
		
		if($is_inserted){
			
			if(!empty($edit_id) && $_SESSION['mf_logged_in'] === true){
				//if this ie edit_entry page, always write to permanent file
				$write_to_permanent_file = true;	
							
			}else{
				
				if($form_page_total <= 1){ //if this is single page form
					if(empty($form_review)){ //if review disabled, upload the files into permanent filename
						$write_to_permanent_file = true;
					}else{ //if this single form has review enabled
						$write_to_temporary_file = true;
					}
					
				}else{//if this is multipage form
					if($input['page_number'] == $form_page_total && !empty($input['submit_primary']) && $is_committed){
						$write_to_permanent_file = true;
					}else{
						$write_to_temporary_file = true;
					}
				}
			}


		}
		
		if($write_to_permanent_file === true){
			//START writing into permanent file ------------------------
			
			//within one form, it is possible to use a mix of standard file upload field and the advanced/ajax uploader
			//we need to be able processing both at the same time
			
			//if files were uploaded using standard file upload fields
			if(!empty($uploaded_files)){ 
				
				foreach ($uploaded_files as $element_name){
					
					$file_token = md5(uniqid(rand(), true)); //add random token to uploaded filename, to increase security
							
					//move file and check for invalid file
					$destination_file = $input['machform_data_path'].$mf_settings['upload_dir']."/form_{$form_id}/files/{$element_name}_{$file_token}-{$record_insert_id}-{$_FILES[$element_name]['name']}";
					if (move_uploaded_file($_FILES[$element_name]['tmp_name'], $destination_file)) {
						
						$query = "update ".MF_TABLE_PREFIX."form_{$form_id} set {$element_name}=? where id=?";
						
						$file_element = "{$element_name}_{$file_token}-{$record_insert_id}-{$_FILES[$element_name]['name']}";
						$params = array($file_element,$record_insert_id);
						
						mf_do_query($query,$params,$dbh);	
					}
				}
			}
			
			//if files were uploaded using advance uploader
			if(!empty($uploaded_files_advance)){ 	

				if(!empty($edit_id) && $_SESSION['mf_logged_in'] === true){
					//if this is edit_entry, we need to get existing file records and merge the data with the new uploaded files
					$uploaded_element_names= array();
					$uploaded_element_ids = array_keys($uploaded_files_advance);
					foreach ($uploaded_element_ids as $element_id) {
						$uploaded_element_names[] = 'element_'.$element_id;
					}
					$uploaded_element_names_joined = implode(',',$uploaded_element_names);
				
					$query = "SELECT {$uploaded_element_names_joined} from `".MF_TABLE_PREFIX."form_{$form_id}` where `id`=?";
					$params = array($edit_id);
					
					$sth = mf_do_query($query,$params,$dbh);
					$row = mf_do_fetch_result($sth);
					
					$existing_files_data = array();
					$multi_upload_info = array();
					foreach ($uploaded_element_names as $element_name){
						$existing_files_data[$element_name] = trim($row[$element_name]);
						
						$element_name_exploded = explode('_',$element_name);
						$multi_upload_info[$element_name] = $element_info[$element_name_exploded[1]]['file_enable_multi_upload'];
					}
				}

				//loop through each list
				foreach($uploaded_files_advance as $element_id=>$values){
					$current_listfile_name 	  = $values['listfile_name'];
					$current_listfile_content = $values['listfile_content'];
					
					$file_list_array = array();
					foreach($current_listfile_content as $tmp_filename_path){
						$tmp_filename_only =  basename($tmp_filename_path);
						$filename_value    =  substr($tmp_filename_only,strpos($tmp_filename_only,'-')+1);			
						$filename_value	   =  str_replace('|','',str_replace('.tmp', '', $filename_value));
						
						$new_file_token = md5(uniqid(rand(), true)); //add random token to uploaded filename, to increase security
						$new_filename 	= "element_{$element_id}_{$new_file_token}-{$record_insert_id}-{$filename_value}";
						$destination_filename = $input['machform_data_path'].$mf_settings['upload_dir']."/form_{$form_id}/files/".$new_filename;
						
						//remove tmp name and change it into permanent name
						//store all the permanent name into a variable
						if(file_exists($tmp_filename_path)){
							rename($tmp_filename_path,$destination_filename);
						}
						
						$file_list_array[] = $new_filename;	
					}
					
					//delete the listfile for the current element_id
					unlink($current_listfile_name);
					
					//update the table with the file name list
					if(!empty($edit_id) && $_SESSION['mf_logged_in'] === true){
					//if this is edit_entry, we need to get existing file records and merge the data with the new uploaded files
					//which depends on the multi upload setting for each file upload field
					//if multi upload enabled, we need to merge the data. otherwise, replace the old data
						if(!empty($multi_upload_info['element_'.$element_id])){ //if multi upload enabled, merge the data
							$new_files_array = $file_list_array;
							
							if(!empty($existing_files_data['element_'.$element_id])){
								$old_files_array = explode('|',$existing_files_data['element_'.$element_id]);

								$merged_files_array = array_merge($new_files_array,$old_files_array);
								$merged_files_array = array_unique($merged_files_array);
							}else{
								$merged_files_array = $new_files_array;
							}

							$file_list_joined[$element_id]  = implode('|',$merged_files_array);
							
						}else{ //replace the old data with the new file
							$file_list_joined[$element_id]  = implode('|',$file_list_array);
						}
					}else{
						$file_list_joined[$element_id]  = implode('|',$file_list_array);
					}
				}
				
				//update the table with the file name list
				$update_values = '';
				$params_update = array();
				
				foreach ($file_list_joined as $element_id=>$file_joined){
					$update_values .= "element_{$element_id}=:element_{$element_id},";
					$params_update[':element_'.$element_id] = $file_joined;
				}
				$update_values = rtrim($update_values,',');
				
				$params_update[':id'] = $record_insert_id;
				$query = "update ".MF_TABLE_PREFIX."form_{$form_id} set {$update_values} where id=:id";
				
				mf_do_query($query,$params_update,$dbh);
				
			}
			//END writing into permanent file ------------------------
		}else if($write_to_temporary_file === true){
			//START writing into temporary file ------------------------
			
			//if files were uploaded using standard file upload fields
			if(!empty($uploaded_files)){
				$record_review_id = session_id();
				foreach ($uploaded_files as $element_name){
					$file_token = md5(uniqid(rand(), true)); //add random token to uploaded filename, to increase security
						
					//move file and check for invalid file
					$destination_file = $input['machform_data_path'].$mf_settings['upload_dir']."/form_{$form_id}/files/{$element_name}_{$file_token}-{$record_insert_id}-{$_FILES[$element_name]['name']}.tmp";
					if (move_uploaded_file($_FILES[$element_name]['tmp_name'], $destination_file)) {
						$query = "update ".MF_TABLE_PREFIX."form_{$form_id}_review set {$element_name}=? where session_id=?";
						$file_element = "{$element_name}_{$file_token}-{$record_insert_id}-{$_FILES[$element_name]['name']}";
						
						$params = array($file_element,$record_review_id);
						mf_do_query($query,$params,$dbh);
					}
							
					if(!empty($uploaded_file_lookup[$element_name])){
						unset($uploaded_file_lookup[$element_name]);
					}
				}
			}
			
			//if files were uploaded using advance uploader
			if(!empty($uploaded_files_advance)){ 	
				//loop through each list
				foreach($uploaded_files_advance as $element_id=>$values){
					$current_listfile_name 	  = $values['listfile_name'];
					$current_listfile_content = $values['listfile_content'];
					
					$file_list_array = array();
					foreach($current_listfile_content as $tmp_filename_path){
						$tmp_filename_only =  basename($tmp_filename_path);
						$filename_value    =  substr($tmp_filename_only,strpos($tmp_filename_only,'-')+1);			
						$filename_value	   =  str_replace('|','',str_replace('.tmp', '', $filename_value));
						
						$new_file_token = md5(uniqid(rand(), true)); //add random token to uploaded filename, to increase security
						$new_filename 	= "element_{$element_id}_{$new_file_token}-{$record_insert_id}-{$filename_value}";
						$destination_filename = $input['machform_data_path'].$mf_settings['upload_dir']."/form_{$form_id}/files/".$new_filename.".tmp";
						
						//assign new temporary name, using new token and record id
						//store all the temporary name into a variable
						if(file_exists($tmp_filename_path)){
							rename($tmp_filename_path,$destination_filename);
						}
						
						$file_list_array[] = $new_filename;	
					}
					
					//delete the listfile for the current element_id
					unlink($current_listfile_name);
					
					//update the table with the file name list
					$file_list_joined[$element_id]  = implode('|',$file_list_array);
				}
				
				//update the table with the file name list
				$update_values = '';
				$params_update = array();
				
				foreach ($file_list_joined as $element_id=>$file_joined){
					$update_values .= "element_{$element_id}=:element_{$element_id},";
					$params_update[':element_'.$element_id] = $file_joined;
				}
				$update_values = rtrim($update_values,',');
				
				$params_update[':id'] = $record_insert_id;
				
				$query = "update ".MF_TABLE_PREFIX."form_{$form_id}_review set {$update_values} where id=:id";
				mf_do_query($query,$params_update,$dbh);
				
			}
					
			//if the user goes to review page and then go back to the form page or navigate within multipage form, $uploaded_file_lookup will contain the list of the previously submitted files
			//if the multi upload option enabled, make sure to update the previouly uploaded file to the current record during form submit
			//when updating the table, make sure to MERGE existing data within the table and the new one
			//otherwise, if the multi upload is not enabled, we need to delete previous files and don't update the table with the old files data
			
			if(!empty($uploaded_file_lookup)){
				
				//get the existing data within the table
				$uploaded_element_names 	   = array_keys($uploaded_file_lookup);
				$uploaded_element_names_joined = implode(',',$uploaded_element_names);
				
				$query = "SELECT {$uploaded_element_names_joined} from `".MF_TABLE_PREFIX."form_{$form_id}_review` where `id`=?";
				$params = array($record_insert_id);
				
				$sth = mf_do_query($query,$params,$dbh);
				$row = mf_do_fetch_result($sth);
				
				$existing_files_data = array();
				$multi_upload_info = array();
				foreach ($uploaded_element_names as $element_name){
					$existing_files_data[$element_name] = $row[$element_name];
					
					$element_name_exploded = explode('_',$element_name);
					$multi_upload_info[$element_name] = $element_info[$element_name_exploded[1]]['file_enable_multi_upload'];
				}
				
				
				//merge the data
				foreach ($uploaded_file_lookup as $element_name=>$filename){
					$new_files_array = array();
					$old_files_array = array();
					
					$new_files_array = explode('|',$filename);
					$old_files_array = explode('|',$existing_files_data[$element_name]);
					
					if(!empty($multi_upload_info[$element_name])){ //if multi upload enabled, merge the data
						$merged_files_array = array_merge($new_files_array,$old_files_array);
						$merged_files_array = array_unique($merged_files_array);
					}else{//otherwise, just use the new one
						$merged_files_array = $old_files_array;
						
						//delete the old files as well, if the files aren't the same with the new one
						if($filename != $existing_files_data[$element_name]){
							foreach ($new_files_array as $filename){
								$filename = $input['machform_data_path'].$mf_settings['upload_dir']."/form_{$form_id}/files/{$filename}.tmp";
								if(file_exists($filename)){
									unlink($filename);
								}
							}
						}
					}
					$merged_files_joined = implode('|',$merged_files_array);
					$merged_files_data[$element_name] = $merged_files_joined;
				}	
				
				
				$update_clause = '';
				foreach ($merged_files_data as $element_name=>$filename){
					$update_clause .= "`{$element_name}`='{$filename}',";
				}
				$update_clause = rtrim($update_clause,",");
				
				$query = "UPDATE `".MF_TABLE_PREFIX."form_{$form_id}_review` SET {$update_clause} WHERE id=?";
				$params = array($record_insert_id);
				
				mf_do_query($query,$params,$dbh);
				
			}
			//END writing into temporary file ------------------------
		}
		
							
		//start sending notification email to admin ------------------------------------------
		if(($is_inserted && !empty($esl_enable) && !empty($form_email) && empty($form_review) && ($form_page_total == 1)) || 
		   ($is_inserted && !empty($esl_enable) && !empty($form_email) && $is_committed)
		){
			//get parameters for the email
				
			//from name
			if(!empty($esl_from_name)){			
				if(is_numeric($esl_from_name)){
					$admin_email_param['from_name'] = '{element_'.$esl_from_name.'}';
				}else{
					$admin_email_param['from_name'] = $esl_from_name;
				}
			}else{
				$admin_email_param['from_name'] = 'MachForm';
			}
			
			//from email address
			if(!empty($esl_from_email_address)){
				if(is_numeric($esl_from_email_address)){
					$admin_email_param['from_email'] = '{element_'.$esl_from_email_address.'}';
				}else{
					$admin_email_param['from_email'] = $esl_from_email_address;
				}
			}else{
				$domain = str_replace('www.','',$_SERVER['SERVER_NAME']);
				$admin_email_param['from_email'] = "no-reply@{$domain}";
			}
			
			//subject
			if(!empty($esl_subject)){
				$admin_email_param['subject'] = $esl_subject;
			}else{
				$admin_email_param['subject'] = '{form_name} [#{entry_no}]';
			}
			
			//content
			if(!empty($esl_content)){
				$admin_email_param['content'] = $esl_content;
			}else{
				$admin_email_param['content'] = '{entry_data}';
			}
			
			$admin_email_param['as_plain_text'] = $esl_plain_text;
			$admin_email_param['target_is_admin'] = true; 
			$admin_email_param['machform_base_path'] = $input['machform_base_path']; 
			mf_send_notification($dbh,$form_id,$record_insert_id,$form_email,$admin_email_param);
    		
		}
		//end emailing notifications to admin ----------------------------------------------
		
		
		//start sending notification email to user ------------------------------------------
		if(($is_inserted && !empty($esr_enable) && !empty($esr_email_address) && empty($form_review) && ($form_page_total == 1)) || 
		   ($is_inserted && !empty($esr_enable) && !empty($esr_email_address) && $is_committed)
		){
			//get parameters for the email
			
			//to email
			if(is_numeric($esr_email_address)){
				$esr_email_address = '{element_'.$esr_email_address.'}';
			}
					
			//from name
			if(!empty($esr_from_name)){			
				if(is_numeric($esr_from_name)){
					$user_email_param['from_name'] = '{element_'.$esr_from_name.'}';
				}else{
					$user_email_param['from_name'] = $esr_from_name;
				}
			}else{
				$user_email_param['from_name'] = 'MachForm';
			}
			
			//from email address
			if(!empty($esr_from_email_address)){
				if(is_numeric($esr_from_email_address)){
					$user_email_param['from_email'] = '{element_'.$esr_from_email_address.'}';
				}else{
					$user_email_param['from_email'] = $esr_from_email_address;
				}
			}else{
				$domain = str_replace('www.','',$_SERVER['SERVER_NAME']);
				$user_email_param['from_email'] = "no-reply@{$domain}";
			}
			
			//subject
			if(!empty($esr_subject)){
				$user_email_param['subject'] = $esr_subject;
			}else{
				$user_email_param['subject'] = '{form_name} - Receipt';
			}
			
			//content
			if(!empty($esr_content)){
				$user_email_param['content'] = $esr_content;
			}else{
				$user_email_param['content'] = '{entry_data}';
			}
			
			$user_email_param['as_plain_text'] = $esr_plain_text;
			$user_email_param['target_is_admin'] = false; 
			
			mf_send_notification($dbh,$form_id,$record_insert_id,$esr_email_address,$user_email_param);
		}
		//end emailing notifications to user ---------------------------------------------	
		
		//if there is no error message or elements, send true as status
		if(empty($error_elements) && empty($process_result['custom_error'])){		
			$process_result['status'] = true;
			
			if($form_page_total > 1){ //if this is multipage form
				$_SESSION['mf_form_loaded'][$form_id][$page_number] = true;
				
				if($is_saving_form_resume){
					//if the user is saving his progress instead of submitting the form
					//copy the record from review table into main form table and set the status to incomplete (status=2)
					//also generate resume url
					$has_invalid_resume_email = false;
					
					//validate the email address first, if the user entered invalid email address, display error message
					if(!empty($input['element_resume_email'])){
						
						$regex  = '/^[A-z0-9][\w.-]*@[A-z0-9][\w\-\.]+\.[A-z0-9]{2,6}$/';
						$resume_email = trim($input['element_resume_email']);
						
						$preg_result = preg_match($regex, $resume_email);
							
						if(empty($preg_result)){
							$has_invalid_resume_email = true;
							$error_elements['element_resume_email'] = $mf_lang['val_email']; 
							
							$process_result['status'] = false;
							$process_result['error_elements'] = $error_elements;
							$process_result['old_values']['element_resume_email'] = $input['element_resume_email'];
						}
					}
					
					if(!$has_invalid_resume_email){
						$form_resume_key = substr(strtolower(md5(uniqid(rand(), true))),0,10);
						
						//move data from ap_form_x_review table to ap_form_x table
						//get all column name except session_id and id
						$query  = "SELECT * FROM `".MF_TABLE_PREFIX."form_{$form_id}_review` WHERE session_id=?";
						$params = array($session_id);
						
						$sth = mf_do_query($query,$params,$dbh);
						$row = mf_do_fetch_result($sth);
								
						$columns = array();
						foreach($row as $column_name=>$column_data){
							if($column_name != 'id' && $column_name != 'session_id'){
								$columns[] = $column_name;
							}
						}	
						
						$columns_joined = implode("`,`",$columns);
						$columns_joined = '`'.$columns_joined.'`';
						
						$old_resume_key = $row['resume_key'];
						
						//copy data from review table
						$query = "INSERT INTO `".MF_TABLE_PREFIX."form_{$form_id}`($columns_joined) SELECT {$columns_joined} from `".MF_TABLE_PREFIX."form_{$form_id}_review` WHERE session_id=?";
						$params = array($session_id);
						
						mf_do_query($query,$params,$dbh);
						
						$new_record_id = (int) $dbh->lastInsertId();
						
						$query = "UPDATE `".MF_TABLE_PREFIX."form_{$form_id}` set `status`=2,resume_key='{$form_resume_key}' where `id`=?";
						$params = array($new_record_id);
						
						mf_do_query($query,$params,$dbh);
						
						//delete current entry within review table
						$query = "DELETE from `".MF_TABLE_PREFIX."form_{$form_id}_review` WHERE session_id=?";
						$params = array($session_id);
						
						mf_do_query($query,$params,$dbh);
						
						//delete old entries which saved previously
						if(!empty($old_resume_key)){
							$query = "DELETE from `".MF_TABLE_PREFIX."form_{$form_id}` WHERE resume_key=? and status=2";
							$params = array($old_resume_key);
							
							mf_do_query($query,$params,$dbh);
						}
						
						//pass form resume key
						$process_result['form_resume_key'] = $form_resume_key;
						
						//pass form resume url
						$ssl_suffix = mf_get_ssl_suffix();
						$form_resume_url = "http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].mf_get_dirname($_SERVER['PHP_SELF'])."/view.php?id={$form_id}&mf_resume={$form_resume_key}";

						$process_result['form_resume_url'] = $form_resume_url;
					
						if(!empty($resume_email)){
							//send the resume link to the provided email
							mf_send_resume_link($dbh,$form_name,$form_resume_url,$resume_email);
						}
					}
					
				}else{
					//get the next page number and send it
					//don't send page number if this is already the last page, unless back button being clicked
					if($input['page_number'] < $form_page_total){
						if(!empty($input['submit_primary']) || !empty($input['submit_primary_x'])){
							$process_result['next_page_number'] = $page_number + 1;
						}elseif (!empty($input['submit_secondary']) || !empty($input['submit_secondary_x'])){
							$process_result['next_page_number'] = $page_number - 1;
						}else{
							$process_result['next_page_number'] = $page_number + 1;
						}
					}else{ //if this is the last page
						
						if(!empty($input['submit_primary']) || !empty($input['submit_primary_x'])){
							if(!empty($form_review)){
								$process_result['review_id']   = $record_insert_id;
							}
						}elseif (!empty($input['submit_secondary']) || !empty($input['submit_secondary_x'])){
							$process_result['next_page_number'] = $page_number - 1;
						}else{
							if(!empty($form_review)){
								$process_result['review_id']   = $record_insert_id;
							}
						}
					}
				}
			}else{//if this is single page form
				//if 'form review' enabled, send review_id
				if(!empty($form_review)){
					$process_result['review_id']   = $record_insert_id;
				}else{
					//form submitted successfully, set the session to display success page
					$_SESSION['mf_form_completed'][$form_id] = true;
				}
			}
			
			
		}else{
			$process_result['status'] = false;
		}
		
		
		//get payment processor URL, if applicable for this form
		if($process_result['status'] === true){
			$merchant_redirect_url = mf_get_merchant_redirect_url($dbh,$form_id,$record_insert_id);
			
			if(!empty($merchant_redirect_url)){
				$process_result['form_redirect'] = $merchant_redirect_url;
			}
		}
		
				
		return $process_result; 
	}
	
	
	//process form review submit
	//move the record from temporary review table to the actual table
	function mf_commit_form_review($dbh,$form_id,$record_id,$options=array()){
		
		$mf_settings = mf_get_settings($dbh);

		//by default, this function will send notification email
		if($options['send_notification'] === false){
			$send_notification = false;
		}else{
			$send_notification = true;
		}
		//move data from ap_form_x_review table to ap_form_x table
		//get all column name except session_id and id
		$query  = "SELECT * FROM `".MF_TABLE_PREFIX."form_{$form_id}_review` WHERE id=?";
		$params = array($record_id);
				
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
								
		$columns = array();
		foreach($row as $column_name=>$column_data){
			if($column_name != 'id' && $column_name != 'session_id' && $column_name != 'status' && $column_name != 'resume_key'){
				$columns[] = $column_name;				
			}
		}	
		
		$columns_joined = implode("`,`",$columns);
		$columns_joined = '`'.$columns_joined.'`';
		
		//copy data from review table
		$query = "INSERT INTO `".MF_TABLE_PREFIX."form_{$form_id}`($columns_joined) SELECT {$columns_joined} from `".MF_TABLE_PREFIX."form_{$form_id}_review` WHERE id=?";
		$params = array($record_id);
		
		mf_do_query($query,$params,$dbh);
		
		$new_record_id = (int) $dbh->lastInsertId();
		
		//check for resume_key from the review table
		//if there is resume_key, we need to delete the incomplete record within ap_form_x table which contain that resume_key
		$query = "SELECT `resume_key` FROM `".MF_TABLE_PREFIX."form_{$form_id}_review` WHERE id=?";
		$params = array($record_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
		
		if(!empty($row['resume_key'])){
			$query = "DELETE from `".MF_TABLE_PREFIX."form_{$form_id}` where resume_key=? and `status`=2";
			$params = array($row['resume_key']);
			
			mf_do_query($query,$params,$dbh);
		}
		
		//rename file uploads, if any
		//get all file uploads elements first
		$query = "SELECT 
						element_id 
					FROM 
						".MF_TABLE_PREFIX."form_elements 
				   WHERE 
				   		form_id=? AND 
				   		element_type='file' AND 
				   		element_status=1 AND
				   		element_is_private=0";
		$params = array($form_id);
		
		$file_uploads_array = array();
		
		$sth = mf_do_query($query,$params,$dbh);
		while($row = mf_do_fetch_result($sth)){
			$file_uploads_array[] = 'element_'.$row['element_id'];
		}
		
		if(!empty($file_uploads_array)){
			$file_uploads_column = implode('`,`',$file_uploads_array);
			$file_uploads_column = '`'.$file_uploads_column.'`';
			
			$query = "SELECT {$file_uploads_column} FROM `".MF_TABLE_PREFIX."form_{$form_id}_review` where id=?";
			$params = array($record_id);
			
			$sth = mf_do_query($query,$params,$dbh);
			$row = mf_do_fetch_result($sth);
			$file_update_query = '';
			
			foreach ($file_uploads_array as $element_name){
				$filename_record = $row[$element_name];
				
				if(empty($filename_record)){
					continue;
				}
				
				//if the file upload field is using advance uploader, $filename would contain multiple file names, separated by pipe character '|'
				$filename_array = array();
				$filename_array = explode('|',$filename_record);
				
				$file_joined_value = '';
				foreach ($filename_array as $filename){
					$target_filename 	  = $options['machform_data_path'].$mf_settings['upload_dir']."/form_{$form_id}/files/{$filename}.tmp";
					
					$regex    = '/^element_([0-9]*)_([0-9a-zA-Z]*)-([0-9]*)-(.*)$/';
					$matches  = array();
					preg_match($regex, $filename,$matches);
					$filename_noelement = $matches[4];
					
					$file_token = md5(uniqid(rand(), true)); //add random token to uploaded filename, to increase security
					$destination_filename = $options['machform_data_path'].$mf_settings['upload_dir']."/form_{$form_id}/files/{$element_name}_{$file_token}-{$new_record_id}-{$filename_noelement}";
					
					if(file_exists($target_filename)){	
						rename($target_filename,$destination_filename);
					}
				
					$filename_noelement = addslashes(stripslashes($filename_noelement));
					$file_joined_value .= "{$element_name}_{$file_token}-{$new_record_id}-{$filename_noelement}|";
				}
				
				//build update query
				$file_joined_value  = rtrim($file_joined_value,'|');
				$file_update_query .= "`{$element_name}`='{$file_joined_value}',";
			}
			
			$file_update_query = rtrim($file_update_query,',');
			if(!empty($file_update_query)){
				$query = "UPDATE `".MF_TABLE_PREFIX."form_{$form_id}` SET {$file_update_query} WHERE id=?";
				$params = array($new_record_id);
				
				mf_do_query($query,$params,$dbh);
			}
		}
		

		$_SESSION['mf_form_completed'][$form_id] = true;
		
		//send notification emails
		//get form properties data
		$query 	= "select 
						 form_redirect,
						 form_redirect_enable,
						 form_email,
						 esl_enable,
						 esl_from_name,
						 esl_from_email_address,
						 esl_subject,
						 esl_content,
						 esl_plain_text,
						 esr_enable,
						 esr_email_address,
						 esr_from_name,
						 esr_from_email_address,
						 esr_subject,
						 esr_content,
						 esr_plain_text
				     from 
				     	 `".MF_TABLE_PREFIX."forms` 
				    where 
				    	 form_id=?";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
		
		if(!empty($row['form_redirect_enable'])){
			$form_redirect   = $row['form_redirect'];
		}
		$form_email 	= $row['form_email'];
		
		$esl_from_name 	= $row['esl_from_name'];
		$esl_from_email_address = $row['esl_from_email_address'];
		$esl_subject 	= $row['esl_subject'];
		$esl_content 	= $row['esl_content'];
		$esl_plain_text	= $row['esl_plain_text'];
		$esl_enable     = $row['esl_enable'];
		
		$esr_email_address 	= $row['esr_email_address'];
		$esr_from_name 	= $row['esr_from_name'];
		$esr_from_email_address = $row['esr_from_email_address'];
		$esr_subject 	= $row['esr_subject'];
		$esr_content 	= $row['esr_content'];
		$esr_plain_text	= $row['esr_plain_text'];
		$esr_enable		= $row['esr_enable'];
		
		//start sending notification email to admin ------------------------------------------
		if(!empty($esl_enable) && !empty($form_email) && $send_notification === true){
			//get parameters for the email
					
			//from name
			if(!empty($esl_from_name)){
				$admin_email_param['from_name'] = $esl_from_name;
			}else{
				$admin_email_param['from_name'] = 'MachForm';
			}
			
			//from email address
			if(!empty($esl_from_email_address)){
				if(is_numeric($esl_from_email_address)){
					$admin_email_param['from_email'] = '{element_'.$esl_from_email_address.'}';
				}else{
					$admin_email_param['from_email'] = $esl_from_email_address;
				}
			}else{
				$domain = str_replace('www.','',$_SERVER['SERVER_NAME']);
				$admin_email_param['from_email'] = "no-reply@{$domain}";
			}
			
			//subject
			if(!empty($esl_subject)){
				$admin_email_param['subject'] = $esl_subject;
			}else{
				$admin_email_param['subject'] = '{form_name} [#{entry_no}]';
			}
			
			//content
			if(!empty($esl_content)){
				$admin_email_param['content'] = $esl_content;
			}else{
				$admin_email_param['content'] = '{entry_data}';
			}
			
			$admin_email_param['as_plain_text'] = $esl_plain_text;
			$admin_email_param['target_is_admin'] = true; 
			$admin_email_param['machform_base_path'] = $options['machform_base_path']; 
			
			mf_send_notification($dbh,$form_id,$new_record_id,$form_email,$admin_email_param);
    	
		}
		//end emailing notifications to admin ----------------------------------------------
		
		
		//start sending notification email to user ------------------------------------------
		if(!empty($esr_enable) && !empty($esr_email_address) && $send_notification === true){
			//get parameters for the email
			
			//to email
			if(is_numeric($esr_email_address)){
				$esr_email_address = '{element_'.$esr_email_address.'}';
			}
					
			//from name
			if(!empty($esr_from_name)){
				$user_email_param['from_name'] = $esr_from_name;
			}else{
				$user_email_param['from_name'] = 'MachForm';
			}
			
			//from email address
			if(!empty($esr_from_email_address)){
				if(is_numeric($esr_from_email_address)){
					$user_email_param['from_email'] = '{element_'.$esr_from_email_address.'}';
				}else{
					$user_email_param['from_email'] = $esr_from_email_address;
				}
			}else{
				$domain = str_replace('www.','',$_SERVER['SERVER_NAME']);
				$user_email_param['from_email'] = "no-reply@{$domain}";
			}
			
			//subject
			if(!empty($esr_subject)){
				$user_email_param['subject'] = $esr_subject;
			}else{
				$user_email_param['subject'] = '{form_name} - Receipt';
			}
			
			//content
			if(!empty($esr_content)){
				$user_email_param['content'] = $esr_content;
			}else{
				$user_email_param['content'] = '{entry_data}';
			}
			
			$user_email_param['as_plain_text'] = $esr_plain_text;
			$user_email_param['target_is_admin'] = false; 
			
			mf_send_notification($dbh,$form_id,$new_record_id,$esr_email_address,$user_email_param);
		}
		//end emailing notifications to user ----------------------------------------------
		
		//delete all entry from this user in review table
		$session_id = session_id();
		$query = "DELETE FROM `".MF_TABLE_PREFIX."form_{$form_id}_review` where id=? or session_id=?";
		$params = array($record_id,$session_id);
		
		mf_do_query($query,$params,$dbh);
		
		//remove form history from session
		$_SESSION['mf_form_loaded'][$form_id] = array();
		unset($_SESSION['mf_form_loaded'][$form_id]);
		
		//remove form access session
		$_SESSION['mf_form_access'][$form_id] = array();
		unset($_SESSION['mf_form_access'][$form_id]);
		
		$_SESSION['mf_form_resume_url'][$form_id] = array();
		unset($_SESSION['mf_form_resume_url'][$form_id]);
		
		//get merchant redirect url, if enabled for this form
		$merchant_redirect_url = mf_get_merchant_redirect_url($dbh,$form_id,$new_record_id);
		if(!empty($merchant_redirect_url)){
			$form_redirect = $merchant_redirect_url;
		}
		
		$commit_result['form_redirect'] = $form_redirect;
		$commit_result['record_insert_id'] = $new_record_id;
		
		return $commit_result;
	}
	
	//this is a helper function to check POST variable
	//if there is submit button being sent, return true
	function mf_is_form_submitted(){
		if(!empty($_POST['submit_form']) || !empty($_POST['submit_primary']) || !empty($_POST['submit_secondary'])){
			return true;
		}else{
			return false;
		}
	}
	
	//this function checks if the user is allowed to see this particular form page
	function mf_verify_page_access($form_id,$page_number){
		if(empty($form_id)){
			die('ID required.');
		}
		
		if(empty($page_number)){
			return 1; //send the user to page 1 of the form if no page_number being specified
		}else{
			if($_SESSION['mf_form_access'][$form_id][$page_number] === true){
				return $page_number;
			}else{
				return 1;
			}
		}
	}
	
	//generate the merchant redirect URL for particular form
	//the redirect URL contain complete payment information
	function mf_get_merchant_redirect_url($dbh,$form_id,$entry_id){
		
		$mf_settings = mf_get_settings($dbh);
		$merchant_redirect_url = '';
		$payment_has_value = false;
		
		$query 	= "select 
						 payment_enable_merchant,
						 payment_merchant_type,
						 ifnull(payment_paypal_email,'') payment_paypal_email,
						 payment_paypal_language,
						 payment_currency,
						 payment_show_total,
						 payment_total_location,
						 payment_enable_recurring,
						 payment_recurring_cycle,
						 payment_recurring_unit,
						 payment_price_type,
						 payment_price_amount,
						 payment_price_name
				     from 
				     	 `".MF_TABLE_PREFIX."forms` 
				    where 
				    	 form_id=?";
		
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
			
		$payment_enable_merchant = (int) $row['payment_enable_merchant'];
		if($payment_enable_merchant < 1){
			$payment_enable_merchant = 0;
		}

		$payment_merchant_type 	 = $row['payment_merchant_type'];
		$payment_paypal_email 	 = $row['payment_paypal_email'];
		$payment_paypal_language = $row['payment_paypal_language'];
		
		$payment_currency 		  = $row['payment_currency'];
		$payment_show_total 	  = (int) $row['payment_show_total'];
		$payment_total_location   = $row['payment_total_location'];
		$payment_enable_recurring = (int) $row['payment_enable_recurring'];
		$payment_recurring_cycle  = (int) $row['payment_recurring_cycle'];
		$payment_recurring_unit   = $row['payment_recurring_unit'];
		
		$payment_price_type   = $row['payment_price_type'];
		$payment_price_amount = (float) $row['payment_price_amount'];
		$payment_price_name   = $row['payment_price_name'];
		
		
		if(!empty($payment_enable_merchant)){ //if merchant is enabled
				
				//paypal website payment standard
				if($payment_merchant_type == 'paypal_standard'){
					$paypal_params = array();
					
					$paypal_params['charset'] 	    = 'UTF-8';
					$paypal_params['upload']  		= 1;
					$paypal_params['business']      = $payment_paypal_email;
					$paypal_params['currency_code'] = $payment_currency;
					$paypal_params['invoice'] 		= $form_id.'_'.$record_insert_id;
					$paypal_params['rm'] 			= 2; //the buyer’s browser is redirected to the return URL by using the POST method, and all payment variables are included
					$paypal_params['lc'] 			= $payment_paypal_language;
					$paypal_params['return'] 		= $mf_settings['base_url'].'view.php?id='.$form_id.'&done=1'; 
					$paypal_params['notify_url'] 	= $mf_settings['base_url'].'paypal_ipn.php';
					$paypal_params['no_shipping'] 	= 1;
					
					if(!empty($payment_enable_recurring)){ //this is recurring payment
						$paypal_params['cmd'] = '_xclick-subscriptions';
						$paypal_params['src'] = 1; //subscription payments recur, until user cancel it
						$paypal_params['sra'] = 1; //reattempt failed recurring payments before canceling
						$paypal_params['item_name'] = $payment_price_name;
						$paypal_params['p3'] 		= $payment_recurring_cycle;
						$paypal_params['t3'] 		= strtoupper($payment_recurring_unit[0]);
							
						if($paypal_params['t3'] == 'Y' && $payment_recurring_cycle > 5){
							$paypal_params['p3'] = 5; //paypal can only handle 5-year-period recurring payments, maximum	
						}
								
						if($payment_price_type == 'fixed'){ //this is fixed amount payment	
							$paypal_params['a3'] 		= $payment_price_amount;
							
							if(!empty($payment_price_amount)){
								$payment_has_value = true;
							}
						}else if($payment_price_type == 'variable'){
							
							$total_payment_amount = 0;
							
							//get price fields information from ap_element_prices table
							$query = "select 
											A.element_id,
											A.option_id,
											A.price,
											B.element_title,
											B.element_type,
											(select `option` from ".MF_TABLE_PREFIX."element_options where form_id=A.form_id and element_id=A.element_id and option_id=A.option_id and live=1 limit 1) option_title
										from
											".MF_TABLE_PREFIX."element_prices A left join ".MF_TABLE_PREFIX."form_elements B on (A.form_id=B.form_id and A.element_id=B.element_id)
										where
											A.form_id = ?
										order by 
											A.element_id,A.option_id asc";
							
							$params = array($form_id);
							$sth = mf_do_query($query,$params,$dbh);
							
							$price_field_columns = array();
							
							while($row = mf_do_fetch_result($sth)){
								$element_id   = (int) $row['element_id'];
								$option_id 	  = (int) $row['option_id'];
								$element_type = $row['element_type'];
								
								if($element_type == 'checkbox'){
									$column_name = 'element_'.$element_id.'_'.$option_id;
								}else{
									$column_name = 'element_'.$element_id;
								}	
								
								if(!in_array($column_name,$price_field_columns)){
									$price_field_columns[] = $column_name;
									$price_field_types[$column_name] = $row['element_type'];
								}
								
								$price_values[$element_id][$option_id] 	 = $row['price'];
								
							}
							$price_field_columns_joined = implode(',',$price_field_columns);
							
							//check the value of the price fields from the ap_form_x table
							$query = "select {$price_field_columns_joined} from ".MF_TABLE_PREFIX."form_{$form_id} where `id`=?";
							$params = array($entry_id);
							$sth = mf_do_query($query,$params,$dbh);
							$row = mf_do_fetch_result($sth);
							
							$processed_column_name = array();
							
							foreach ($price_field_columns as $column_name){
								if(!empty($row[$column_name]) && !in_array($column_name,$processed_column_name)){
									$temp = explode('_',$column_name);
									$element_id = (int) $temp[1];
									$option_id = (int) $temp[2];
									
									if($price_field_types[$column_name] == 'money'){
										$total_payment_amount += $row[$column_name];
									}else if($price_field_types[$column_name] == 'checkbox'){
										$total_payment_amount += $price_values[$element_id][$option_id];
									}else{
										$option_id = $row[$column_name];
										$total_payment_amount += $price_values[$element_id][$option_id];
									}

									$processed_column_name[] = $column_name;
								}
							}
							
							$paypal_params['a3'] = $total_payment_amount;
							
							if(!empty($total_payment_amount)){
								$payment_has_value = true;
							}
						}//end of variable-recurring payment
					}else{ //non recurring payment
						$paypal_params['cmd'] = '_cart';
						
						if($payment_price_type == 'fixed'){ //this is fixed amount payment
							
							$paypal_params['item_name_1'] = $payment_price_name;
							$paypal_params['amount_1']	  = $payment_price_amount;
							
							if(!empty($payment_price_amount)){
								$payment_has_value = true;
							}
						}else if($payment_price_type == 'variable'){ //this is variable amount payment
							
							//get price fields information from ap_element_prices table
							$query = "select 
											A.element_id,
											A.option_id,
											A.price,
											B.element_title,
											B.element_type,
											(select `option` from ".MF_TABLE_PREFIX."element_options where form_id=A.form_id and element_id=A.element_id and option_id=A.option_id and live=1 limit 1) option_title
										from
											".MF_TABLE_PREFIX."element_prices A left join ".MF_TABLE_PREFIX."form_elements B on (A.form_id=B.form_id and A.element_id=B.element_id)
										where
											A.form_id = ?
										order by 
											A.element_id,A.option_id asc";
							$params = array($form_id);
							$sth = mf_do_query($query,$params,$dbh);
							
							$price_field_columns = array();
							
							while($row = mf_do_fetch_result($sth)){
								$element_id   = (int) $row['element_id'];
								$option_id 	  = (int) $row['option_id'];
								$element_type = $row['element_type'];
								
								if($element_type == 'checkbox'){
									$column_name = 'element_'.$element_id.'_'.$option_id;
								}else{
									$column_name = 'element_'.$element_id;
								}	
								
								if(!in_array($column_name,$price_field_columns)){
									$price_field_columns[] = $column_name;
									$price_field_types[$column_name] = $row['element_type'];
								}
								
								$price_values[$element_id][$option_id] 	 = $row['price'];
								
								if($element_type == 'money'){
									$price_titles[$element_id][$option_id] = $row['element_title'];
								}else{
									$price_titles[$element_id][$option_id] = $row['option_title'];
								}
							}
							$price_field_columns_joined = implode(',',$price_field_columns);
							
							//check the value of the price fields from the ap_form_x table
							$query = "select {$price_field_columns_joined} from ".MF_TABLE_PREFIX."form_{$form_id} where `id`=?";
							$params = array($entry_id);
							$sth = mf_do_query($query,$params,$dbh);
							$row = mf_do_fetch_result($sth);
							
							$i = 1;
							$processed_column_name = array();
							
							foreach ($price_field_columns as $column_name){

								if(!empty($row[$column_name]) && !in_array($column_name,$processed_column_name)){
									
									$temp = explode('_',$column_name);
									$element_id = (int) $temp[1];
									$option_id = (int) $temp[2];
									
									if($price_field_types[$column_name] == 'money'){
										$paypal_params['item_name_'.$i] = $price_titles[$element_id][0];
										$paypal_params['amount_'.$i] = $row[$column_name];
									}else if($price_field_types[$column_name] == 'checkbox'){
										$paypal_params['item_name_'.$i] = $price_titles[$element_id][$option_id];
										$paypal_params['amount_'.$i] = $price_values[$element_id][$option_id];
									}else{
										$option_id = $row[$column_name];
										$paypal_params['item_name_'.$i] = $price_titles[$element_id][$option_id];
										$paypal_params['amount_'.$i] = $price_values[$element_id][$option_id];
									}

									$processed_column_name[] = $column_name;
									$payment_has_value = true;
									$i++;
								}
							}
								
							
						}//end of non-recurring variable payment
					}//end of non-recurring payment
					
					$merchant_redirect_url = 'https://www.paypal.com/cgi-bin/webscr?'.http_build_query($paypal_params);
					
				}//end paypal standard		
		}
		
		if($payment_has_value){
			return $merchant_redirect_url;
		}else{
			return '';
		}
			
	}
	
	//get the total payment of a submission from ap_form_x_review table
	//this is being used to display the temporary total on multipage form
	function mf_get_payment_total($dbh,$form_id,$session_id,$exclude_page_number){
		
		$total_payment_amount = 0;
							
		//get price fields information from ap_element_prices table
		$query = "select 
						A.element_id,
						A.option_id,
						A.price,
						B.element_title,
						B.element_type,
						(select `option` from ".MF_TABLE_PREFIX."element_options where form_id=A.form_id and element_id=A.element_id and option_id=A.option_id and live=1 limit 1) option_title
					from
						".MF_TABLE_PREFIX."element_prices A left join ".MF_TABLE_PREFIX."form_elements B on (A.form_id=B.form_id and A.element_id=B.element_id)
				   where
						A.form_id = ? and B.element_page_number <> ?
				order by 
						A.element_id,A.option_id asc";
		
		$params = array($form_id,$exclude_page_number);
		$sth = mf_do_query($query,$params,$dbh);
							
		$price_field_columns = array();
							
		while($row = mf_do_fetch_result($sth)){

			$element_id   = (int) $row['element_id'];
			$option_id 	  = (int) $row['option_id'];
			$element_type = $row['element_type'];
								
			if($element_type == 'checkbox'){
				$column_name = 'element_'.$element_id.'_'.$option_id;
			}else{
				$column_name = 'element_'.$element_id;
			}	
								
			if(!in_array($column_name,$price_field_columns)){
				$price_field_columns[] = $column_name;
				$price_field_types[$column_name] = $row['element_type'];
			}
								
			$price_values[$element_id][$option_id] 	 = $row['price'];						
		}

		if(empty($price_field_columns)){
			return 0;
		}


		$price_field_columns_joined = implode(',',$price_field_columns);
						
		//check the value of the price fields from the ap_form_x_review table
		$query = "select {$price_field_columns_joined} from ".MF_TABLE_PREFIX."form_{$form_id}_review where `session_id`=?";
		$params = array($session_id);
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
							
		$processed_column_name = array();
							
		foreach ($price_field_columns as $column_name){
			if(!empty($row[$column_name]) && !in_array($column_name,$processed_column_name)){
				$temp = explode('_',$column_name);
				$element_id = (int) $temp[1];
				$option_id = (int) $temp[2];
									
				if($price_field_types[$column_name] == 'money'){
					$total_payment_amount += $row[$column_name];
				}else if($price_field_types[$column_name] == 'checkbox'){
					$total_payment_amount += $price_values[$element_id][$option_id];
				}else{
					$option_id = $row[$column_name];
					$total_payment_amount += $price_values[$element_id][$option_id];
				}

				$processed_column_name[] = $column_name;
			}
		}
							
		return $total_payment_amount;
	}
?>