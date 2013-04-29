<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/
	//get an array containing values from respective table for certain id
	function mf_get_entry_values($dbh,$form_id,$entry_id,$use_review_table=false,$options=array()){
	
		$mf_settings = mf_get_settings($dbh);
		
		if($use_review_table){
			$table_suffix = '_review';
		}else{
			$table_suffix = '';
		}
			
		//get form elements	
		$query  = "select 
						 element_id,
						 element_type,
						 element_constraint,
						 element_matrix_allow_multiselect,
						 element_time_24hour 
				     from 
				     	 `".MF_TABLE_PREFIX."form_elements` 
				    where 
				    	 form_id=? 
				 order by 
				 		 element_position asc";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$i=0;
		while($row = mf_do_fetch_result($sth)){
			$form_elements[$i]['element_id'] 		 			   = $row['element_id'];
			$form_elements[$i]['element_type'] 		 			   = $row['element_type'];
			$form_elements[$i]['element_constraint'] 			   = $row['element_constraint'];
			$form_elements[$i]['element_matrix_allow_multiselect'] = $row['element_matrix_allow_multiselect'];
			$form_elements[$i]['element_time_24hour'] = $row['element_time_24hour'];
			$i++;
		}
		
		//get whole entry for current id
		$query  = "select * from `".MF_TABLE_PREFIX."form_{$form_id}{$table_suffix}` where id=? limit 1";
		$params = array($entry_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
		
		if(!empty($row)){
			foreach ($row as $column_name=>$column_data){
				$entry_data[$column_name] = htmlspecialchars($column_data,ENT_QUOTES);
			}
		}
		
		
		//get form element options
		$query = "select element_id,option_id,`option` from ".MF_TABLE_PREFIX."element_options where form_id=? and live=1";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		while($row = mf_do_fetch_result($sth)){
			$element_id = $row['element_id'];
			$option_id  = $row['option_id'];
			
			$element_option_lookup[$element_id][$option_id] = true; //array index will hold option_id
		}
		
		
		//loop through each element to get the values
		foreach ($form_elements as $element){
			$element_type 		= $element['element_type'];
			$element_id   		= $element['element_id'];
			$element_constraint = $element['element_constraint'];
			$element_matrix_allow_multiselect = $element['element_matrix_allow_multiselect'];
		
			if('simple_name' == $element_type){ //Simple Name - 2 elements
				$form_values['element_'.$element_id.'_1']['default_value'] = $entry_data['element_'.$element_id.'_1'];
				$form_values['element_'.$element_id.'_2']['default_value'] = $entry_data['element_'.$element_id.'_2'];
			}elseif ('simple_name_wmiddle' == $element_type){ //Simple Name with Middle - 3 elements
				$form_values['element_'.$element_id.'_1']['default_value'] = $entry_data['element_'.$element_id.'_1'];
				$form_values['element_'.$element_id.'_2']['default_value'] = $entry_data['element_'.$element_id.'_2'];
				$form_values['element_'.$element_id.'_3']['default_value'] = $entry_data['element_'.$element_id.'_3'];
			}elseif ('name' == $element_type){ //Extended Name - 4 elements
				$form_values['element_'.$element_id.'_1']['default_value'] = $entry_data['element_'.$element_id.'_1'];
				$form_values['element_'.$element_id.'_2']['default_value'] = $entry_data['element_'.$element_id.'_2'];
				$form_values['element_'.$element_id.'_3']['default_value'] = $entry_data['element_'.$element_id.'_3'];
				$form_values['element_'.$element_id.'_4']['default_value'] = $entry_data['element_'.$element_id.'_4'];
			}elseif ('name_wmiddle' == $element_type){ //Name with Middle - 5 elements
				$form_values['element_'.$element_id.'_1']['default_value'] = $entry_data['element_'.$element_id.'_1'];
				$form_values['element_'.$element_id.'_2']['default_value'] = $entry_data['element_'.$element_id.'_2'];
				$form_values['element_'.$element_id.'_3']['default_value'] = $entry_data['element_'.$element_id.'_3'];
				$form_values['element_'.$element_id.'_4']['default_value'] = $entry_data['element_'.$element_id.'_4'];
				$form_values['element_'.$element_id.'_5']['default_value'] = $entry_data['element_'.$element_id.'_5'];
			}elseif ('time' == $element_type){ //Time - 4 elements

				//convert into time and split into 4 elements
				if(!empty($entry_data['element_'.$element_id]) && ($entry_data['element_'.$element_id] != '00:00:00')){
					$time_value = $entry_data['element_'.$element_id];

					if(!empty($element['element_time_24hour'])){
						$time_value = date("H/i/s/A",strtotime($time_value));
					}else{
						$time_value = date("h/i/s/A",strtotime($time_value));
					}

					$exploded = array();
					$exploded = explode('/',$time_value);
					
					$form_values['element_'.$element_id.'_1']['default_value'] = $exploded[0];
					$form_values['element_'.$element_id.'_2']['default_value'] = $exploded[1];
					$form_values['element_'.$element_id.'_3']['default_value'] = $exploded[2];
					$form_values['element_'.$element_id.'_4']['default_value'] = $exploded[3];
				}
			}elseif ('address' == $element_type){ //Address - 6	 elements
				$form_values['element_'.$element_id.'_1']['default_value'] = $entry_data['element_'.$element_id.'_1'];
				$form_values['element_'.$element_id.'_2']['default_value'] = $entry_data['element_'.$element_id.'_2'];
				$form_values['element_'.$element_id.'_3']['default_value'] = $entry_data['element_'.$element_id.'_3'];
				$form_values['element_'.$element_id.'_4']['default_value'] = $entry_data['element_'.$element_id.'_4'];
				$form_values['element_'.$element_id.'_5']['default_value'] = $entry_data['element_'.$element_id.'_5'];
				$form_values['element_'.$element_id.'_6']['default_value'] = $entry_data['element_'.$element_id.'_6'];
			}elseif ('money' == $element_type){ //Price
				if($element_constraint == 'yen'){ //yen only has 1 element
					$form_values['element_'.$element_id]['default_value'] = $entry_data['element_'.$element_id];
				}else{ //other has 2 fields
					$exploded = array();
					$exploded = explode('.',$entry_data['element_'.$element_id]);
					
					$form_values['element_'.$element_id.'_1']['default_value'] = $exploded[0];
					$form_values['element_'.$element_id.'_2']['default_value'] = $exploded[1];
				}
						
			}elseif ('date' == $element_type){  //date with format MM/DD/YYYY
				if(!empty($entry_data['element_'.$element_id]) && ($entry_data['element_'.$element_id] != '0000-00-00')){
					$date_value = $entry_data['element_'.$element_id];
					$date_value = date("m/d/Y",strtotime($date_value));
					
					$exploded = array();
					$exploded = explode('/',$date_value);
	
					$form_values['element_'.$element_id.'_1']['default_value'] = $exploded[0];
					$form_values['element_'.$element_id.'_2']['default_value'] = $exploded[1];
					$form_values['element_'.$element_id.'_3']['default_value'] = $exploded[2];
				}
				
			}elseif ('europe_date' == $element_type){  //date with format DD/MM/YYYY
				if(!empty($entry_data['element_'.$element_id]) && ($entry_data['element_'.$element_id] != '0000-00-00')){
					$date_value = $entry_data['element_'.$element_id];
					$date_value = date("d/m/Y",strtotime($date_value));
					
					$exploded = array();
					$exploded = explode('/',$date_value);
	
					$form_values['element_'.$element_id.'_1']['default_value'] = $exploded[0];
					$form_values['element_'.$element_id.'_2']['default_value'] = $exploded[1];
					$form_values['element_'.$element_id.'_3']['default_value'] = $exploded[2];
				}
				
			}elseif ('phone' == $element_type){ //Phone - 3 elements
				
				$phone_value = $entry_data['element_'.$element_id];
				$phone_1 = substr($phone_value,0,3);
				$phone_2 = substr($phone_value,3,3);
				$phone_3 = substr($phone_value,-4);
				
				$form_values['element_'.$element_id.'_1']['default_value'] = $phone_1;
				$form_values['element_'.$element_id.'_2']['default_value'] = $phone_2;
				$form_values['element_'.$element_id.'_3']['default_value'] = $phone_3;
				
			}elseif ('checkbox' == $element_type){ //Checkbox - multiple elements
				$checkbox_childs = $element_option_lookup[$element_id];
				
				if(!empty($checkbox_childs)){
					foreach ($checkbox_childs as $option_id=>$dumb){
						$form_values['element_'.$element_id.'_'.$option_id]['default_value'] = $entry_data['element_'.$element_id.'_'.$option_id];
					}
				}
				
				if(!empty($entry_data['element_'.$element_id.'_other'])){
					$form_values['element_'.$element_id.'_other']['default_value'] = $entry_data['element_'.$element_id.'_other'];
				}
			}elseif ('file' == $element_type){ //File 
				
				$filename_record = $entry_data['element_'.$element_id];
				$filename_array  = array();
				
				if(!empty($filename_record)){
					$filename_array  = explode('|',$filename_record);
				}
				
				if(!empty($filename_array)){
					$i=0;
					
					foreach ($filename_array as $filename_value){
						if($use_review_table){
							$filename_path = $options['machform_data_path'].$mf_settings['upload_dir']."/form_{$form_id}/files/{$filename_value}.tmp";
						}else{
							$filename_path = $options['machform_data_path'].$mf_settings['upload_dir']."/form_{$form_id}/files/{$filename_value}";
						}

						$file_size = mf_format_bytes(filesize($filename_path));
						
						$file_1 	    =  substr($filename_value,strpos($filename_value,'-')+1);
						$filename_value = substr($file_1,strpos($file_1,'-')+1);
						
						$form_values['element_'.$element_id]['default_value'][$i]['filename'] = $filename_value;
						$form_values['element_'.$element_id]['default_value'][$i]['filesize'] = $file_size;
						$form_values['element_'.$element_id]['default_value'][$i]['entry_id'] = $entry_id;
						$i++;
					}
					
					
				}
			}else if ('matrix' == $element_type) {
				if(!empty($element_matrix_allow_multiselect)){ //this is checkboxes matrix
					$temp_matrix_child_element_id_array = explode(',',trim($element_constraint));
					array_unshift($temp_matrix_child_element_id_array, $element_id);
						
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
							$element_to_get = "element_{$mc_element_id}_{$sub_row['option_id']}";
							$form_values[$element_to_get]['default_value'] = $entry_data[$element_to_get];
						}	
					}
				}else{
					$form_values['element_'.$element_id]['default_value'] = $entry_data['element_'.$element_id];
				}
			}else{ //element with only 1 input
				$form_values['element_'.$element_id]['default_value'] = $entry_data['element_'.$element_id];
			}
			
		}
		
		
		return $form_values;	
					
		
	}

	//get an array containing values from respective table for certain id
	//similar to mf_get_entry_values() function, but this one is higher level and include labels
	function mf_get_entry_details($dbh,$form_id,$entry_id,$options=array()){
		
		$mf_settings = mf_get_settings($dbh);
		
		$admin_clause = '';
		if(!empty($options['review_mode'])){ //hide admin fields in review page
			$admin_clause = ' and element_is_private=0 ';
		}

		if(!empty($options['checkbox_image'])){
			$checkbox_image = $options['checkbox_image'];
		}else{
			$checkbox_image = $options['machform_path'].'images/icons/checkbox_16.gif';
		}

		//get form elements	
		$query  = "select 
						 element_id,
						 element_type,
						 element_constraint,
						 element_title,
						 element_file_as_attachment,
						 element_time_showsecond,
						 element_time_24hour,
						 (select if(element_matrix_parent_id=0,
							 		element_matrix_allow_multiselect,
									(select 
											B.element_matrix_allow_multiselect 
									   from 
									   		".MF_TABLE_PREFIX."form_elements B 
									  where 
									  		B.form_id=A.form_id and 
									  		B.element_id=A.element_matrix_parent_id
									)
								 )
						 ) matrix_multiselect_status  
					 from 
					 	 `".MF_TABLE_PREFIX."form_elements` A
					where 
						 form_id=? and 
						 element_status = 1 and
						 element_type <> 'section'
						 {$admin_clause} 
				 order by 
				 		 element_position asc";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$i=0;
		while($row = mf_do_fetch_result($sth)){
			$form_elements[$i]['element_id'] 		 = $row['element_id'];
			$form_elements[$i]['element_type'] 		 = $row['element_type'];
			$form_elements[$i]['element_constraint'] = $row['element_constraint'];
			$form_elements[$i]['element_file_as_attachment'] = $row['element_file_as_attachment'];
			$form_elements[$i]['element_time_showsecond'] = $row['element_time_showsecond'];
			$form_elements[$i]['element_time_24hour'] 	  = $row['element_time_24hour'];
			$form_elements[$i]['element_matrix_allow_multiselect'] = $row['matrix_multiselect_status'];
			
			//store element title into array for reference later
			$element_title_lookup[$row['element_id']] = $row['element_title'];
			
			$i++;
		}
		
		if(!empty($options['review_mode'])){
			$table_suffix = '_review';
		}else{
			$table_suffix = '';
		}
		
		//get whole entry for current id
		$query  = "select * from `".MF_TABLE_PREFIX."form_{$form_id}{$table_suffix}` where id=? limit 1";
		$params = array($entry_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
		
		foreach ($row as $column_name=>$column_data){
			$entry_data[$column_name] = htmlspecialchars($column_data,ENT_QUOTES);
		}
		
		
		//get form element options
		$query = "select element_id,option_id,`option` from ".MF_TABLE_PREFIX."element_options where form_id=? and live=1 order by position asc";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		while($row = mf_do_fetch_result($sth)){
			$element_id = $row['element_id'];
			$option_id  = $row['option_id'];
			
			$element_option_lookup[$element_id][$option_id] = $row['option']; //array index will hold option_id
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
			
			$matrix_element_option_lookup[$element_id][$option_id] = htmlspecialchars($row['option_label'],ENT_QUOTES);
		}
		
		//loop through each element to get the values
		$i = 0;
		foreach ($form_elements as $element){
			$element_type 		= $element['element_type'];
			$element_id   		= $element['element_id'];
			$element_constraint = $element['element_constraint'];
			$element_file_as_attachment = $element['element_file_as_attachment'];
			$element_time_24hour 		= $element['element_time_24hour'];
			$element_time_showsecond 	= $element['element_time_showsecond'];
			$element_matrix_allow_multiselect = $element['element_matrix_allow_multiselect'];
			
			$entry_details[$i]['label'] = $element_title_lookup[$element_id];
			$entry_details[$i]['value'] = '&nbsp;'; //default value
			$entry_details[$i]['element_id'] 	= $element_id;
			$entry_details[$i]['element_type'] 	= $element_type;
			
			
			if('simple_name' == $element_type){ //Simple Name - 2 elements
				$simple_name_value = trim($entry_data['element_'.$element_id.'_1'].' '.$entry_data['element_'.$element_id.'_2']);
				if(!empty($simple_name_value)){
					$entry_details[$i]['value'] = $simple_name_value;
				}
			}elseif ('simple_name_wmiddle' == $element_type){ //Simple Name with Middle - 3 elements
				$simple_name_wmiddle_value = trim($entry_data['element_'.$element_id.'_1'].' '.$entry_data['element_'.$element_id.'_2'].' '.$entry_data['element_'.$element_id.'_3']);
				if(!empty($simple_name_wmiddle_value)){
					$entry_details[$i]['value'] = $simple_name_wmiddle_value;
				}
			}elseif ('name' == $element_type){ //Extended Name - 4 elements
				$name_value = trim($entry_data['element_'.$element_id.'_1'].' '. $entry_data['element_'.$element_id.'_2'].' '.$entry_data['element_'.$element_id.'_3'].' '.$entry_data['element_'.$element_id.'_4']);
				if(!empty($name_value)){
					$entry_details[$i]['value'] = $name_value;
				}
			}elseif ('name_wmiddle' == $element_type){ //Extended Name  with Middle- 5 elements
				$name_wmiddle_value = trim($entry_data['element_'.$element_id.'_1'].' '. $entry_data['element_'.$element_id.'_2'].' '.$entry_data['element_'.$element_id.'_3'].' '.$entry_data['element_'.$element_id.'_4'].' '.$entry_data['element_'.$element_id.'_5']);
				if(!empty($name_wmiddle_value)){
					$entry_details[$i]['value'] = $name_wmiddle_value;
				}
			}elseif ('time' == $element_type){ //Time - 4 elements
				//convert into time and split into 4 elements
				if(!empty($entry_data['element_'.$element_id]) && ($entry_data['element_'.$element_id] != '00:00:00')){
					$time_value = $entry_data['element_'.$element_id];
					
					if(!empty($element_time_24hour)){
						if(!empty($element_time_showsecond)){
							$time_value = date("H:i:s",strtotime($time_value));
						}else{
							$time_value = date("H:i",strtotime($time_value));
						}
					}else{
						if(!empty($element_time_showsecond)){
							$time_value = date("h:i:s A",strtotime($time_value));
						}else{
							$time_value = date("h:i A",strtotime($time_value));
						}
					}
					
					$entry_details[$i]['value'] = $time_value;
				}
			}elseif ('address' == $element_type){ //Address - 6	 elements
								
				if(!empty($entry_data['element_'.$element_id.'_3'])){
					$entry_data['element_'.$element_id.'_3'] = $entry_data['element_'.$element_id.'_3'].',';
				}
				
				$entry_details[$i]['value'] = $entry_data['element_'.$element_id.'_1'].' '.$entry_data['element_'.$element_id.'_2'].'<br />'.$entry_data['element_'.$element_id.'_3'].' '.$entry_data['element_'.$element_id.'_4'].' '.$entry_data['element_'.$element_id.'_5'].'<br />'.$entry_data['element_'.$element_id.'_6'];
				
				//if empty, shows blank instead of breaks
				if(trim(str_replace("<br />","",$entry_details[$i]['value'])) == ""){
					$entry_details[$i]['value'] = '&nbsp;';
				}
											  
			}elseif ('money' == $element_type){ //Price
				switch ($element_constraint){
					case 'pound'  : $currency = '&#163;';break;
					case 'euro'   : $currency = '&#8364;';break;
					case 'yen' 	  : $currency = '&#165;';break;
					case 'baht'   : $currency = '&#3647;';break;
					case 'rupees' : $currency = 'Rs';break;
					case 'rand'   : $currency = 'R';break;
					case 'forint' : $currency = '&#70;&#116;';break;
					case 'franc'  : $currency = 'CHF';break;
					case 'koruna' : $currency = '&#75;&#269;';break;
					case 'krona'  : $currency = 'kr';break;
					case 'pesos'  : $currency = '&#36;';break;
					case 'ringgit' : $currency = 'RM';break;
					case 'zloty'  : $currency = '&#122;&#322;';break;
					case 'riyals' : $currency = '&#65020;';break;
					default : $currency = '$';break;	
				}
				
				if(!empty($entry_data['element_'.$element_id]) || $entry_data['element_'.$element_id] === 0 || $entry_data['element_'.$element_id] === '0'){
					$entry_details[$i]['value'] = $currency.$entry_data['element_'.$element_id];
				}
						
			}elseif ('date' == $element_type){  //date with format MM/DD/YYYY
				if(!empty($entry_data['element_'.$element_id]) && ($entry_data['element_'.$element_id] != '0000-00-00')){
					$date_value = $entry_data['element_'.$element_id];
					$date_value = date("M d, Y",strtotime($date_value));
					
					$entry_details[$i]['value'] = $date_value;
				}
				
			}elseif ('europe_date' == $element_type){  //date with format DD/MM/YYYY
				if(!empty($entry_data['element_'.$element_id]) && ($entry_data['element_'.$element_id] != '0000-00-00')){
					$date_value = $entry_data['element_'.$element_id];
					$date_value = date("d M Y",strtotime($date_value));
					
					$entry_details[$i]['value'] = $date_value;
				}
				
			}elseif ('phone' == $element_type){ //Phone - 3 elements
				
				$phone_value = $entry_data['element_'.$element_id];
				$phone_1 = substr($phone_value,0,3);
				$phone_2 = substr($phone_value,3,3);
				$phone_3 = substr($phone_value,-4);
				
				if(!empty($phone_value)){
					$entry_details[$i]['value'] = "($phone_1) {$phone_2}-{$phone_3}";
				}
							
			}elseif ('checkbox' == $element_type){ //Checkbox - multiple elements
				$checkbox_childs = $element_option_lookup[$element_id];
								
				$checkbox_content = '';
				if($checkbox_childs){
					foreach ($checkbox_childs as $option_id=>$option_label){
						if(!empty($entry_data['element_'.$element_id.'_'.$option_id])){
							if(empty($options['strip_checkbox_image'])){
								$checkbox_content .= '<img src="'.$checkbox_image.'" align="absmiddle" /> '.$option_label.'<br />';
							}else{
								$checkbox_content .= '- '.$option_label.'<br />';
							}
						}
					}
				}

				if(!empty($entry_data['element_'.$element_id.'_other'])){
					
					if(empty($options['strip_checkbox_image'])){
						$checkbox_content .= '<img src="'.$checkbox_image.'" align="absmiddle" /> '.$entry_data['element_'.$element_id.'_other'];
					}else{
						$checkbox_content .= '- '.$entry_data['element_'.$element_id.'_other'];
					}
				}				
				
				if(!empty($checkbox_content)){
					$entry_details[$i]['value'] = $checkbox_content;
				}
			}elseif ('file' == $element_type){ //File 
				
				$filename_record = $entry_data['element_'.$element_id];
				$filename_array  = array();
				
				if(!empty($filename_record)){
					$filename_array  = explode('|',$filename_record);
				}
				
				if(!empty($filename_array)){
					$entry_details[$i]['value'] = '';
					$j = 0 ;

					foreach ($filename_array as $filename_value){
						$filename_md5 = md5($filename_value);
						$filename_path = $options['machform_data_path'].$mf_settings['upload_dir']."/form_{$form_id}/files/{$filename_value}.tmp";
						if(!file_exists($filename_path)){
							$filename_path = $options['machform_data_path'].$mf_settings['upload_dir']."/form_{$form_id}/files/{$filename_value}";
						}
						
						$file_size = @mf_format_bytes(filesize($filename_path));
						
						$file_1 	    =  substr($filename_value,strpos($filename_value,'-')+1);
						$filename_value = substr($file_1,strpos($file_1,'-')+1);
						
						//encode the long query string for more readibility
						$q_string = base64_encode("form_id={$form_id}&id={$entry_id}&el=element_{$element_id}&hash={$filename_md5}");
						
						if(!empty($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] != 'off')){
							$ssl_suffix = 's';
						}else{
							$ssl_suffix = '';
						}
							
						//'show_attach_image' is being called on review page
						if(!empty($options['show_attach_image'])){
							
							//trim filename if more than 30 characters
							if(strlen($filename_value) > 30){
								$filename_value = substr($filename_value,0,30)."...";
							}
							
							$entry_details[$i]['value'] .= '<img src="'.$options['machform_path'].'images/icons/185.png" align="absmiddle" style="vertical-align: middle" />&nbsp;'."{$filename_value} ({$file_size})<br/>";
						}else{
							
							//provide a markup to download the file
							if(!empty($options['machform_base_path'])){ //if the form is called from advanced form code
								$entry_details[$i]['value'] .= '<img src="'.$options['machform_path'].'images/icons/185.png" align="absmiddle" style="vertical-align: middle" />&nbsp;<a class="entry_link" href="'.$options['machform_base_path'].'download.php?q='.$q_string.'">'.$filename_value.'</a><br/>';
							}else{
								$entry_details[$i]['value'] .= '<img src="'.$options['machform_path'].'images/icons/185.png" align="absmiddle" style="vertical-align: middle" />&nbsp;<a class="entry_link" href="http'.$ssl_suffix.'://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/download.php?q='.$q_string.'">'.$filename_value.'</a><br/>';
							}
							
							if(!empty($options['strip_download_link'])){
								$entry_details[$i]['value'] .= $filename_value.'<br/>';
							}
							
							if(!empty($element_file_as_attachment)){
								$entry_details[$i]['filedata'][$j]['filename_path']  = $filename_path;
								$entry_details[$i]['filedata'][$j]['filename_value'] = $filename_value;
							}
						}
						$j++;	
					}
					$entry_details[$i]['value'] = rtrim($entry_details[$i]['value'],'<br/>');
					
					
				}
				
			}elseif('select' == $element_type){
				if(!empty($entry_data['element_'.$element_id])){
					$entry_details[$i]['value'] = $element_option_lookup[$element_id][$entry_data['element_'.$element_id]];
				}
			}elseif('radio' == $element_type){
				if(!empty($entry_data['element_'.$element_id])){
					$entry_details[$i]['value'] = $element_option_lookup[$element_id][$entry_data['element_'.$element_id]];
				}else{
					if(!empty($entry_data['element_'.$element_id.'_other'])){
						$entry_details[$i]['value'] = $entry_data['element_'.$element_id.'_other'];
					}else{
						$entry_details[$i]['value'] = '&nbsp;';
					}
				}
			}elseif('matrix' == $element_type){
				if(!empty($element_matrix_allow_multiselect)){ //this is checkbox matrix
					$checkbox_childs = $element_option_lookup[$element_id];
								
					$checkbox_content = '';
					foreach ($checkbox_childs as $option_id=>$option_label){
						if(!empty($entry_data['element_'.$element_id.'_'.$option_id])){
							if(empty($options['strip_checkbox_image'])){
								$checkbox_content .= '<img src="'.$checkbox_image.'" align="absmiddle" /> '.$option_label.'<br />';
							}else{
								$checkbox_content .= '- '.$option_label.'<br />';
							}
						}
					}

					if(!empty($entry_data['element_'.$element_id.'_other'])){
						$checkbox_content .= '<img src="'.$checkbox_image.'" align="absmiddle" /> '.$entry_data['element_'.$element_id.'_other'];
					}				
					
					if(!empty($checkbox_content)){
						$entry_details[$i]['value'] = $checkbox_content;
					}
				}else{ //this is radio matrix
					
					if(!empty($entry_data['element_'.$element_id])){
						$entry_details[$i]['value'] = $matrix_element_option_lookup[$element_id][$entry_data['element_'.$element_id]];
					}else{
						$entry_details[$i]['value'] = '&nbsp;';	
					}

				}
			}elseif ('url' == $element_type){
				if(!empty($entry_data['element_'.$element_id])){
					$entry_details[$i]['value'] = "<a class=\"entry_link\" href=\"{$entry_data['element_'.$element_id]}\">{$entry_data['element_'.$element_id]}</a>";
				}
			}elseif('page_break' == $element_type){
				$entry_details[$i]['value'] = 'mf_page_break';
				$entry_details[$i]['label'] = 'mf_page_break';
			}else{ //element with only 1 input

				if(isset($entry_data['element_'.$element_id])){
					$entry_details[$i]['value'] = $entry_data['element_'.$element_id];
				}
			}
			
			$i++;
		}
		
		return $entry_details;
	}
	
	//display a table which contain entries of a selected form
	function mf_display_entries_table($dbh,$form_id,$options){

		$form_id = (int) $form_id;

		$max_data_length = 80; //maximum length of column content
		$pageno 	   = $options['page_number'];
		$rows_per_page = $options['rows_per_page'];
		$sort_element  = $options['sort_element'];
		$sort_order	   = $options['sort_order'];
		$filter_data   = $options['filter_data'];
		$filter_type   = $options['filter_type'];

		if(empty($sort_element)){ //set the default sorting order
			$sort_element = 'id';
			$sort_order	  = 'desc';
		}


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
			
			$element_option_lookup[$element_id][$option_id] = htmlspecialchars($row['option'],ENT_QUOTES);
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
			
			$matrix_element_option_lookup[$element_id][$option_id] = htmlspecialchars($row['option_label'],ENT_QUOTES);
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
					$element_option_lookup[$row['element_id']]['other'] = htmlspecialchars($row['element_choice_other_label'],ENT_QUOTES);
				
					if($element_type == 'radio'){
						$element_radio_has_other['element_'.$row['element_id']] = true;	
					}
				}
			}

			$row['element_title'] = htmlspecialchars($row['element_title'],ENT_QUOTES);

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
					$column_name_lookup['element_'.$row['element_id'].'_'.$option_id] = htmlspecialchars($option,ENT_QUOTES);
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
						$column_name_lookup['element_'.$row['element_id'].'_'.$option_id] = htmlspecialchars($option,ENT_QUOTES);
						$column_type_lookup['element_'.$row['element_id'].'_'.$option_id] = 'matrix_checkbox';
					}
				}
			}else{ //for other elements with only 1 field
				$column_name_lookup['element_'.$row['element_id']] = $row['element_title'];
				$column_type_lookup['element_'.$row['element_id']] = $row['element_type'];
			}

			
		}
		/******************************************************************************************/
		
		
		//get column preferences and store it into array
		$query = "select element_name from ".MF_TABLE_PREFIX."column_preferences where form_id=? order by position asc";
		$params = array($form_id);
		$sth = mf_do_query($query,$params,$dbh);
		while($row = mf_do_fetch_result($sth)){
			if($row['element_name'] == 'id'){
				continue;
			}
			$column_prefs[] = $row['element_name'];
		}


		//if there is no column preferences, display the first 6 fields
		if(empty($column_prefs)){
			$temp_slice = array_slice($column_name_lookup,0,8);
			unset($temp_slice['date_updated']);
			unset($temp_slice['ip_address']);
			$column_prefs = array_keys($temp_slice);
		}
		
		//determine column labels
		//the first 2 columns are always id and row_num
		$column_labels = array();

		$column_labels[] = 'mf_id';
		$column_labels[] = 'mf_row_num';
		
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

		/** pagination **/
		//identify how many database rows are available
		$query = "select count(*) total_row from (select 
						`id`,
						`id` as `row_num`,
						{$column_prefs_joined}
						{$sorting_query} 
				    from 
				    	".MF_TABLE_PREFIX."form_{$form_id} A 
				    	{$where_clause} ) B ";
		$params = array();
			
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
		
		$numrows   = $row['total_row'];
		$lastpage  = ceil($numrows/$rows_per_page);
							
							
		//ensure that $pageno is within range
		//this code checks that the value of $pageno is an integer between 1 and $lastpage
		$pageno = (int) $pageno;
							
		if ($pageno < 1) { 
		   $pageno = 1;
		}
		elseif ($pageno > $lastpage){
			$pageno = $lastpage;
		}
							
		//construct the LIMIT clause for the sql SELECT statement
		if(!empty($numrows)){
			$limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
		}
		/** end pagination **/

		$query = "select 
						`id`,
						`id` as `row_num`,
						{$column_prefs_joined}
						{$sorting_query} 
				    from 
				    	".MF_TABLE_PREFIX."form_{$form_id} A 
				    	{$where_clause} 
				order by 
						{$sort_element} {$sort_order}
						{$limit}";
		
		$params = array();
		$sth = mf_do_query($query,$params,$dbh);
		$i=0;
		
		//prepend "id" and "row_num" into the column preferences
		array_unshift($column_prefs,"id","row_num");
		
		while($row = mf_do_fetch_result($sth)){
			$j=0;
			foreach($column_prefs as $column_name){
				$form_data[$i][$j] = '';

				//limit the data length, unless for file element
				if($column_type_lookup[$column_name] != 'file'){
					if(strlen($row[$column_name]) > $max_data_length){
						$row[$column_name] = substr($row[$column_name],0,$max_data_length).'...';
					}
				}
				
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
					$column_type_temp = explode('_',$column_type_lookup[$column_name]);
					$column_type = $column_type_temp[1];

					switch ($column_type){
						case 'dollar' : $currency = '&#36;';break;	
						case 'pound'  : $currency = '&#163;';break;
						case 'euro'   : $currency = '&#8364;';break;
						case 'yen' 	  : $currency = '&#165;';break;
						case 'baht'   : $currency = '&#3647;';break;
						case 'forint' : $currency = '&#70;&#116;';break;
						case 'franc'  : $currency = 'CHF';break;
						case 'koruna' : $currency = '&#75;&#269;';break;
						case 'krona'  : $currency = 'kr';break;
						case 'pesos'  : $currency = '&#36;';break;
						case 'rand'   : $currency = 'R';break;
						case 'ringgit' : $currency = 'RM';break;
						case 'rupees' : $currency = 'Rs';break;
						case 'zloty'  : $currency = '&#122;&#322;';break;
						case 'riyals' : $currency = '&#65020;';break;
					}
					
					if(!empty($row[$column_name])){
						$form_data[$i][$j] = '<div class="me_right_div">'.$currency.$row[$column_name].'</div>';
					}else{
						$form_data[$i][$j] = '';
					}
				}elseif($column_type_lookup[$column_name] == 'date'){ //date with format MM/DD/YYYY
					if(!empty($row[$column_name]) && ($row[$column_name] != '0000-00-00')){
						$form_data[$i][$j]  = date('M d, Y',strtotime($row[$column_name]));
					}

					if($column_name == 'date_created' || $column_name == 'date_updated'){
						$form_data[$i][$j] = mf_short_relative_date($row[$column_name]);
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
							$form_data[$i][$j]  = '<div class="me_center_div"><img src="images/icons/62_blue_16.png" align="absmiddle" /></div>';
						}else{
							$form_data[$i][$j]  = '';
						}
					}
				}elseif($column_type_lookup[$column_name] == 'checkbox'){
					
					if(!empty($row[$column_name])){
						if(substr($column_name,-5) == "other"){ //if this is an 'other' field, display the actual value
							$form_data[$i][$j] = htmlspecialchars($row[$column_name],ENT_QUOTES);
						}else{
							$form_data[$i][$j]  = '<div class="me_center_div"><img src="images/icons/62_blue_16.png" align="absmiddle" /></div>';
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
						$form_data[$i][$j]  = '<div class="me_file_div">'.$clean_filenames_joined.'</div>';
					}
				}else{
					$form_data[$i][$j] = htmlspecialchars(str_replace("\r","",str_replace("\n"," ",$row[$column_name])),ENT_QUOTES);
				}
				

				$j++;
			}
			$i++;
		}
		
		//generate table markup for the entries
		$table_header_markup = '<thead><tr>'."\n";

		foreach($column_labels as $label_name){
			if($label_name == 'mf_id'){
				$table_header_markup .= '<th class="me_action" scope="col"><input type="checkbox" value="1" name="col_select" id="col_select" /></th>'."\n";
			}else if($label_name == 'mf_row_num'){
				$table_header_markup .= '<th class="me_number" scope="col">#</th>'."\n";
			}else{
				$table_header_markup .= '<th scope="col"><div title="'.$label_name.'">'.$label_name.'</div></th>'."\n";	
			}
			
		}

		$table_header_markup .= '</tr></thead>'."\n";

		$table_body_markup = '<tbody>'."\n";

		$toggle = false;
		
		$first_row_number = ($pageno -1) * $rows_per_page + 1;
		$last_row_number  = $first_row_number;

		if(!empty($form_data)){
			foreach($form_data as $row_data){
				if($toggle){
					$toggle = false;
					$row_style = 'class="alt"';
				}else{
					$toggle = true;
					$row_style = '';
				}

				$table_body_markup .= "<tr id=\"row_{$row_data[0]}\" {$row_style}>";
				foreach ($row_data as $key=>$column_data){
					if($key == 0){ //this is "id" column
						$table_body_markup .= '<td class="me_action"><input type="checkbox" id="entry_'.$column_data.'" name="entry_'.$column_data.'" value="1" /></td>'."\n";
					}elseif ($key == 1){ //this is "row_num" column
						$table_body_markup .= '<td class="me_number">'.$column_data.'</td>'."\n";
					}else{
						$table_body_markup .= '<td><div>'.$column_data.'</div></td>'."\n";
					}
				}
				$table_body_markup .= "</tr>"."\n";
				$last_row_number++;
			}
		}else{
			$table_body_markup .= "<tr><td colspan=\"".count($column_labels)."\"> <div id=\"filter_no_results\"><h3>Your search returned no results.</h3></div></td></tr>";
		}

		$last_row_number--;

		$table_body_markup .= '</tbody>'."\n";
		$table_markup = '<table width="100%" cellspacing="0" cellpadding="0" border="0" id="entries_table" class="table table-bordered table-striped">'."\n";
		$table_markup .= $table_header_markup.$table_body_markup;
		$table_markup .= '</table>'."\n";

		$entries_markup = '<div id="entries_container">';
		$entries_markup .= $table_markup;
		$entries_markup .= '</div>';

		$pagination_markup = '';
		


		if(!empty($lastpage) && $numrows > $rows_per_page){
			
			if ($pageno != 1) {
			   if($lastpage > 13 && $pageno > 7){	
			   		$pagination_markup .= "<li class=\"page\"><a href='{$_SERVER['PHP_SELF']}?id={$form_id}&pageno=1'>&#8676; First</a></li>";
			   }
			   $prevpage = $pageno-1;
			} 
			
			//middle navigation
			if($pageno == 1){
				$i=1;
				while(($i<=13) && ($i<=$lastpage)){
					if($i != 1){
							$active_style = '';
						}else{
							$active_style = 'current_page';
					}
					$pagination_markup .= "<li class=\"page {$active_style}\"><a href='{$_SERVER['PHP_SELF']}?id={$form_id}&pageno={$i}'>{$i}</a></li>";
					$i++;
				}
				if($lastpage > $i){
					$pagination_markup .= "<li class=\"page_more\">...</li>";
				}
			}elseif ($pageno == $lastpage){
				
				if(($lastpage - 13) > 1){
					$pagination_markup .= "<li class=\"page_more\">...</li>";
					$i=1;
					$j=$lastpage - 12;
					while($i<=13){
						if($j != $lastpage){
							$active_style = '';
						}else{
							$active_style = 'current_page';
						}
						$pagination_markup .= "<li class=\"page {$active_style}\"><a href='{$_SERVER['PHP_SELF']}?id={$form_id}&pageno={$j}'>{$j}</a></li>";
						$i++;
						$j++;
					}
				}else{
					$i=1;
					while(($i<=13) && ($i<=$lastpage)){
						if($i != $lastpage){
							$active_style = '';
						}else{
							$active_style = 'current_page';
						}
						$pagination_markup .= "<li class=\"page {$active_style}\"><a href='{$_SERVER['PHP_SELF']}?id={$form_id}&pageno={$i}'>{$i}</a></li>";
						$i++;
					}
				}
				
			}else{
				$next_pages = false;
				$prev_pages = false;
				
				if(($lastpage - ($pageno + 6)) >= 1){
					$next_pages = true;
				}
				if(($pageno - 6) > 1){
					$prev_pages = true;
				}
				
				if($prev_pages){ //if there are previous pages
					$pagination_markup .= "<li class=\"page_more\">...</li>";
					if($next_pages){ //if there are next pages
						$i=1;
						$j=$pageno - 6;
						while($i<=13){
							if($j != $pageno){
								$active_style = '';
							}else{
								$active_style = 'current_page';
							}
							$pagination_markup .= "<li class=\"page {$active_style}\"><a href='{$_SERVER['PHP_SELF']}?id={$form_id}&pageno={$j}'>{$j}</a></li>";
							$i++;
							$j++;
						}
						$pagination_markup .= "<li class=\"page_more\">...</li>";
					}else{
						
						$i=1;
						$j=$pageno - 9;
						while(($i<=13) && ($j <= $lastpage)){
							if($j != $pageno){
								$active_style = '';
							}else{
								$active_style = 'current_page';
							}
							$pagination_markup .= "<li class=\"page {$active_style}\"><a href='{$_SERVER['PHP_SELF']}?id={$form_id}&pageno={$j}'>{$j}</a></li>";
							$i++;
							$j++;
						}
					}	
				}else{ //if there aren't previous pages
				
					$i=1;
  					while(($i<=13) && ($i <= $lastpage)){
  						if($i != $pageno){
							$active_style = '';
						}else{
							$active_style = 'current_page';
						}
						$pagination_markup .= "<li class=\"page {$active_style}\"><a href='{$_SERVER['PHP_SELF']}?id={$form_id}&pageno={$i}'>{$i}</a></li>";
						$i++;	
					}
					if($next_pages){
						$pagination_markup .= "<li class=\"page_more\">...</li>";
					}
				}
				
				
			}
				
			if ($pageno != $lastpage) 
			{
			   $nextpage = $pageno+1;
			   if($lastpage > 13){
			   		$pagination_markup .= "<li class=\"page\"><a href='{$_SERVER['PHP_SELF']}?id={$form_id}&pageno=$lastpage'>Last &#8677;</a></li>";
			   }
			}
			
			$pagination_markup = '<ul class="pages bluesoft small" id="me_pagination">'.$pagination_markup.'</ul>';
			$pagination_markup .= "<div id=\"me_pagination_label\">Displaying <strong>{$first_row_number}-{$last_row_number}</strong> of <strong id=\"me_entries_total\">{$numrows}</strong> entries</div>";
		}else{
			$pagination_markup = '<div style="width: 100%; height: 20px;"></div>';
		}
		
		
		$entries_markup .= $pagination_markup;
		
		return $entries_markup;

	}

	//get an array of all element fields' label and types within a form
	function mf_get_columns_meta($dbh,$form_id){
		
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
			
			$element_option_lookup[$element_id][$option_id] = htmlspecialchars($row['option'],ENT_QUOTES);
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
				   		A.form_id=? and A.live=1 and B.element_status=1 and B.element_type='matrix' 
				order by 
						A.element_id,A.option_id asc";
		$params = array($form_id);
		$sth = mf_do_query($query,$params,$dbh);
		
		while($row = mf_do_fetch_result($sth)){
			$element_id = $row['element_id'];
			$option_id  = $row['option_id'];
			
			$matrix_element_option_lookup[$element_id][$option_id] = htmlspecialchars($row['option_label'],ENT_QUOTES);
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


		
		//set column properties for basic fields
		$column_name_lookup['id'] 			= 'ID#';
		$column_name_lookup['date_created'] = 'Date Created';
		$column_name_lookup['date_updated'] = 'Date Updated';
		$column_name_lookup['ip_address'] 	= 'IP Address';

		$column_type_lookup['id'] 			= 'number';
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
					$element_option_lookup[$row['element_id']]['other'] = htmlspecialchars($row['element_choice_other_label'],ENT_QUOTES);
				
					if($element_type == 'radio'){
						$element_radio_has_other['element_'.$row['element_id']] = true;	
					}
				}
			}

			$row['element_title'] = htmlspecialchars($row['element_title'],ENT_QUOTES);

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

				$column_type_lookup['element_'.$row['element_id']] = 'money';

			}elseif('checkbox' == $element_type){ //checkboxes, get childs elements
							
				$this_checkbox_options = $element_option_lookup[$row['element_id']];
				
				foreach ($this_checkbox_options as $option_id=>$option){
					$column_name_lookup['element_'.$row['element_id'].'_'.$option_id] = htmlspecialchars($option,ENT_QUOTES);
					$column_type_lookup['element_'.$row['element_id'].'_'.$option_id] = $row['element_type'];
				}
			}elseif ('time' == $element_type){
				$column_name_lookup['element_'.$row['element_id']] = $row['element_title'];

				$column_type_lookup['element_'.$row['element_id']] = 'time';

			}else if('matrix' == $element_type){ 
				
				if(empty($matrix_multiselect_status[$row['element_id']])){
					$column_name_lookup['element_'.$row['element_id']] = $row['element_title'];
					$column_type_lookup['element_'.$row['element_id']] = 'matrix';
				}else{
					$this_checkbox_options = $matrix_element_option_lookup[$row['element_id']];
					
					foreach ($this_checkbox_options as $option_id=>$option){
						$option = $option.' - '.$row['element_title'];
						$column_name_lookup['element_'.$row['element_id'].'_'.$option_id] = htmlspecialchars($option,ENT_QUOTES);
						$column_type_lookup['element_'.$row['element_id'].'_'.$option_id] = 'matrix';
					}
				}
			}else{ //for other elements with only 1 field
				$column_name_lookup['element_'.$row['element_id']] = $row['element_title'];
				$column_type_lookup['element_'.$row['element_id']] = $row['element_type'];
			}

			
		}
		
		$column_meta['name_lookup'] = $column_name_lookup;
		$column_meta['type_lookup'] = $column_type_lookup;

		return $column_meta;
	}

	//get an array containing id number of all filtered entries within a form
	function mf_get_filtered_entries_ids($dbh,$form_id){
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

		$query 	= "select 
						 entries_filter_type,
						 entries_sort_by
				     from 
				     	 ".MF_TABLE_PREFIX."forms 
				    where 
				    	 form_id = ?";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);

		if(!empty($row)){
			$filter_type   = $row['entries_filter_type'];
			$sort_by 	   = $row['entries_sort_by'];

			$exploded = explode('-', $sort_by);
			$sort_element = $exploded[0]; //the element name, e.g. element_2
			$sort_order	  = $exploded[1]; //asc or desc
		}

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
						element_id,option_id asc";
		$params = array($form_id);
		$sth = mf_do_query($query,$params,$dbh);
		
		while($row = mf_do_fetch_result($sth)){
			$element_id = $row['element_id'];
			$option_id  = $row['option_id'];
			
			$element_option_lookup[$element_id][$option_id] = htmlspecialchars($row['option'],ENT_QUOTES);
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
			
			$matrix_element_option_lookup[$element_id][$option_id] = htmlspecialchars($row['option_label'],ENT_QUOTES);
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
					$element_option_lookup[$row['element_id']]['other'] = htmlspecialchars($row['element_choice_other_label'],ENT_QUOTES);
				
					if($element_type == 'radio'){
						$element_radio_has_other['element_'.$row['element_id']] = true;	
					}
				}
			}

			$row['element_title'] = htmlspecialchars($row['element_title'],ENT_QUOTES);

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
					$column_name_lookup['element_'.$row['element_id'].'_'.$option_id] = htmlspecialchars($option,ENT_QUOTES);
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
						$column_name_lookup['element_'.$row['element_id'].'_'.$option_id] = htmlspecialchars($option,ENT_QUOTES);
						$column_type_lookup['element_'.$row['element_id'].'_'.$option_id] = 'matrix_checkbox';
					}
				}
			}else{ //for other elements with only 1 field
				$column_name_lookup['element_'.$row['element_id']] = $row['element_title'];
				$column_type_lookup['element_'.$row['element_id']] = $row['element_type'];
			}

			
		}
		/******************************************************************************************/

		//get column preferences and store it into array
		$query = "select element_name from ".MF_TABLE_PREFIX."column_preferences where form_id=? order by position asc";
		$params = array($form_id);
		$sth = mf_do_query($query,$params,$dbh);
		while($row = mf_do_fetch_result($sth)){
			$column_prefs[] = $row['element_name'];
		}


		//if there is no column preferences, display the first 6 fields
		if(empty($column_prefs)){
			$temp_slice = array_slice($column_name_lookup,0,8);
			unset($temp_slice['date_updated']);
			unset($temp_slice['ip_address']);
			$column_prefs = array_keys($temp_slice);
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

		$query = "select 
						`id`,
						`id` as `row_num`,
						{$column_prefs_joined}
						{$sorting_query}
				    from 
				    	".MF_TABLE_PREFIX."form_{$form_id} A 
				    	{$where_clause}
				order by 
						{$sort_element} {$sort_order}";
		
		$params = array();
		$sth = mf_do_query($query,$params,$dbh);
		
		$filtered_entry_id_array = array();
		while($row = mf_do_fetch_result($sth)){
			$filtered_entry_id_array[] = $row['id'];
		}

		return $filtered_entry_id_array;
	}
	
?>