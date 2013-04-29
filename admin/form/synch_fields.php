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
	
	$element_properties_array = mf_sanitize($_POST['fp']);
	$form_id				  = (int) $_POST['form_id'];

	$response_data 	  = new stdClass();
	$updated_element_id = ''; 
	
	//loop through each element properties
	if(!empty($element_properties_array)){
		foreach($element_properties_array as $element_properties){
			
			unset($element_properties['is_db_live']);
			unset($element_properties['last_option_id']); //this property exist for choices field type
			unset($element_properties['page_total']); //this property exist for page break field type
			
			$element_options = array();
			$element_options = $element_properties['options'];
			unset($element_properties['options']); 
			
			/***************************************************************************************************************/	
			/* 1. Synch into ap_elements_options table																   	   */
			/***************************************************************************************************************/
			// This is only necessary for multiple choice, checkboxes, dropdown and matrix field
			if(in_array($element_properties['type'],array('radio','checkbox','select'))){
				
				//delete any previous records of this element
				$query = "DELETE FROM 
									 ".MF_TABLE_PREFIX."element_options
								WHERE
									 form_id = :form_id AND element_id = :element_id and live='2'"; 
				
				$params = array(':form_id' => $form_id,
								':element_id' => $element_properties['id']);	
				
				mf_do_query($query,$params,$dbh);
				
				//insert the new options
				$query = "INSERT INTO 
									`".MF_TABLE_PREFIX."element_options` 
									(`form_id`,`element_id`,`option_id`,`position`,`option`,`option_is_default`,`live`) 
							  VALUES 
							  		(:form_id,:element_id,:option_id,:position,:option,:is_default,'2');"; 
				
				foreach ($element_options as $option_id=>$value){
					
					$params = array(':form_id' => $form_id,
									':element_id' => $element_properties['id'],
									':option_id' => $option_id,
									':position' => $value['position'],
									':option' => $value['option'],
									':is_default' => $value['is_default']);
					mf_do_query($query,$params,$dbh);
				}
				
				
			}else if($element_properties['type'] == 'matrix'){
				$column_data = array();
				$column_data = $element_options[$element_properties['id']]['column_data'];
				
				foreach ($element_options as $m_element_id=>$value){
					
					//delete any previous records of this element	
					$query = "DELETE FROM 
										 ".MF_TABLE_PREFIX."element_options
									WHERE
										 form_id = :form_id AND element_id = :element_id and live='2'";
					
					
					$params = array(':form_id' => $form_id,
									':element_id' => $m_element_id);	
					mf_do_query($query,$params,$dbh);
									
					
					//insert the new options		
					$query = "INSERT INTO 
										`".MF_TABLE_PREFIX."element_options` 
										(`form_id`,`element_id`,`option_id`,`position`,`option`,`option_is_default`,`live`) 
								  VALUES 
								   		(:form_id,:element_id,:option_id,:position,:option,'0','2');";
					 
					foreach ($column_data as $option_id=>$data){
						$params = array(':form_id' => $form_id,
										':element_id' => $m_element_id,
										':option_id' => $option_id ,
										':position' => $data['position'],
										':option' => $data['column_title']);
						mf_do_query($query,$params,$dbh);
					}
					
				}
			}
			
			/***************************************************************************************************************/	
			/* 2. Synch into ap_form_elements table																	   	   */
			/***************************************************************************************************************/
			$update_values = '';
			$params = array();
			
			//dynamically create the sql update string, based on the input given
			foreach ($element_properties as $key=>$value){
				$update_values .= "`element_{$key}`= :element_{$key},";
				$params[':element_'.$key] = $value;
			}
			$update_values = rtrim($update_values,',');
			
			$query = "UPDATE `".MF_TABLE_PREFIX."form_elements` set 
										$update_values
								  where 
							  	  		form_id = :form_id and element_id = :w_element_id";
										
			$params[':form_id'] = $form_id;
			$params[':w_element_id'] = $element_properties['id'];
			
			mf_do_query($query,$params,$dbh);
										
			$updated_element_id .= '#li_'.$element_properties['id'].',';
			
			//if this is matrix field, the element title need to be updated again from the options, the position as well
			if($element_properties['type'] == 'matrix'){
				
				$query = "UPDATE 
								`".MF_TABLE_PREFIX."form_elements` 
							 SET 
								`element_title` = :element_title,
								`element_position` = :element_position		
						   WHERE 
								form_id = :form_id and element_id = :element_id";
				
				
				foreach ($element_options as $m_element_id=>$value){
					
					$params = array();
					$params[':element_title'] 		= $value['row_title'];
					$params[':element_position']	= $value['position'];
					$params[':form_id']				= $form_id;
					$params[':element_id']			= $m_element_id;
					
					mf_do_query($query,$params,$dbh);	
				} //end foreach element_options
			}
		}
	}
	
	$updated_element_id = rtrim($updated_element_id,',');
	
	$response_data->status    			= "ok";
	$response_data->updated_element_id 	= $updated_element_id;
	
	$response_json = json_encode($response_data);
	
	echo $response_json;
	
?>