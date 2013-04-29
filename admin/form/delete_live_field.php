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
	
	$form_id 	= (int) trim($_POST['form_id']);
	$element_id = (int) trim($_POST['element_id']);

	$dbh = mf_connect_db();
	$mf_settings = mf_get_settings($dbh);
	
	//get type of this element
	$query 	= "select 
					 element_type,
					 element_choice_has_other 
				 from 
				 	 `".MF_TABLE_PREFIX."form_elements` 
				where 
					 form_id = ? and 
					 element_id = ?";
	$params = array($form_id,$element_id);
		
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
		
	$element_type 			  = $row['element_type'];
	$element_choice_has_other = $row['element_choice_has_other'];
		
	if(MF_CONF_TRUE_DELETE == true){
		
		$params = array();
		
		//delete actual field on respective table data
		if('address' == $element_type){
			$query = "ALTER TABLE `".MF_TABLE_PREFIX."form_{$form_id}` DROP COLUMN `element_{$element_id}_1`,DROP COLUMN `element_{$element_id}_2`, DROP COLUMN `element_{$element_id}_3`, DROP COLUMN `element_{$element_id}_4`, DROP COLUMN `element_{$element_id}_5`, DROP COLUMN `element_{$element_id}_6`;";
			mf_do_query($query,$params,$dbh);
			
		}elseif ('simple_name' == $element_type){
			$query = "ALTER TABLE `".MF_TABLE_PREFIX."form_{$form_id}` DROP COLUMN `element_{$element_id}_1`,DROP COLUMN `element_{$element_id}_2`;";
			mf_do_query($query,$params,$dbh);
			
		}elseif ('simple_name_wmiddle' == $element_type){
			$query = "ALTER TABLE `".MF_TABLE_PREFIX."form_{$form_id}` DROP COLUMN `element_{$element_id}_1`,DROP COLUMN `element_{$element_id}_2`,DROP COLUMN `element_{$element_id}_3`;";
			mf_do_query($query,$params,$dbh);
			
		}elseif ('name' == $element_type){
			$query = "ALTER TABLE `".MF_TABLE_PREFIX."form_{$form_id}` DROP COLUMN `element_{$element_id}_1`,DROP COLUMN `element_{$element_id}_2`, DROP COLUMN `element_{$element_id}_3`, DROP COLUMN `element_{$element_id}_4`;";
			mf_do_query($query,$params,$dbh);
			
		}elseif ('name_wmiddle' == $element_type){
			$query = "ALTER TABLE `".MF_TABLE_PREFIX."form_{$form_id}` DROP COLUMN `element_{$element_id}_1`,DROP COLUMN `element_{$element_id}_2`, DROP COLUMN `element_{$element_id}_3`, DROP COLUMN `element_{$element_id}_4`, DROP COLUMN `element_{$element_id}_5`;";
			mf_do_query($query,$params,$dbh);
			
		}elseif ('checkbox' == $element_type){
			
			//get option_id list
			$query = "select option_id from ".MF_TABLE_PREFIX."element_options where form_id = ? and element_id = ? and live=1";
			$params = array($form_id,$element_id);
			$sth = mf_do_query($query,$params,$dbh);
			
			$option_id_array = array();
			while($row = mf_do_fetch_result($sth)){
				$option_id_array[] = $row['option_id'];
			}
			
			//delete each option
			$query = "ALTER TABLE `".MF_TABLE_PREFIX."form_{$form_id}` ";
			foreach ($option_id_array as $option_id){
				$query .= " DROP COLUMN `element_{$element_id}_{$option_id}`,";
			}
			
			$query = rtrim($query,',');
			$params = array();
			mf_do_query($query,$params,$dbh);

			//delete 'other' field
			if(!empty($element_choice_has_other)){
				$query = "ALTER TABLE `".MF_TABLE_PREFIX."form_{$form_id}` DROP COLUMN `element_{$element_id}_other`";
				$params = array();
				mf_do_query($query,$params,$dbh);
			}
			
		}elseif('radio' == $element_type){
			$query = "ALTER TABLE `".MF_TABLE_PREFIX."form_{$form_id}` DROP COLUMN `element_{$element_id}`;";
			mf_do_query($query,$params,$dbh);

			//delete 'other' field
			if(!empty($element_choice_has_other)){
				$query = "ALTER TABLE `".MF_TABLE_PREFIX."form_{$form_id}` DROP COLUMN `element_{$element_id}_other`";
				$params = array();
				mf_do_query($query,$params,$dbh);
			}

		}elseif('matrix' == $element_type){
			//check if this is checkbox matrix or radio button matrix
			$query = "select element_matrix_allow_multiselect from `".MF_TABLE_PREFIX."form_elements` where form_id = ? and element_id = ?";
			$params = array($form_id,$element_id);
			
			$sth = mf_do_query($query,$params,$dbh);
			$row = mf_do_fetch_result($sth);
			
			if(!empty($row['element_matrix_allow_multiselect'])){
				$matrix_allow_multiselect = true;
			}else{
				$matrix_allow_multiselect = false;
			}
			
			//get all rows id
			$matrix_rows_ids = array();
			
			$query = "select element_id from `".MF_TABLE_PREFIX."form_elements` where form_id = ? and element_matrix_parent_id = ? and element_type='matrix'";
			$params = array($form_id,$element_id);
			
			$sth = mf_do_query($query,$params,$dbh);
			while($row = mf_do_fetch_result($sth)){
				$matrix_rows_ids[]  = $row['element_id'];	
			}
			$matrix_rows_ids[] = $element_id; //add the first row id
			
			if($matrix_allow_multiselect){ //if this is checkbox matrix
				foreach ($matrix_rows_ids as $m_element_id){
						//get option_id list
						$query = "select option_id from ".MF_TABLE_PREFIX."element_options where form_id = ? and element_id = ? and live=1";
						$params = array($form_id,$m_element_id);
						$sth = mf_do_query($query,$params,$dbh);
						
						$option_id_array = array();
						while($row = mf_do_fetch_result($sth)){
							$option_id_array[] = $row['option_id'];
						}
						
						//delete each option from the form table
						$query = "ALTER TABLE `".MF_TABLE_PREFIX."form_{$form_id}` ";
						foreach ($option_id_array as $option_id){
							$query .= " DROP COLUMN `element_{$m_element_id}_{$option_id}`,";
						}
						
						$query = rtrim($query,',');
						$params = array();
						mf_do_query($query,$params,$dbh);
						
						//delete on table ap_form_elements
						$query = "delete from `".MF_TABLE_PREFIX."form_elements` where form_id = ? and element_id = ?";
						$params = array($form_id,$m_element_id);
						mf_do_query($query,$params,$dbh);
						
						//delete on table ap_element_options
						$query = "delete from `".MF_TABLE_PREFIX."element_options` where form_id = ? and element_id = ?";
						$params = array($form_id,$m_element_id);
						mf_do_query($query,$params,$dbh);
				}	
			}else{ //if this is radio button matrix
				
				foreach ($matrix_rows_ids as $m_element_id){
						//delete each option from the form table
						$query = "ALTER TABLE `".MF_TABLE_PREFIX."form_{$form_id}` DROP COLUMN `element_{$m_element_id}`";
						mf_do_query($query,array(),$dbh);
						
						//delete on table ap_form_elements
						$query = "delete from `".MF_TABLE_PREFIX."form_elements` where form_id = ? and element_id = ?";
						$params = array($form_id,$m_element_id);
						mf_do_query($query,$params,$dbh);
						
						//delete on table ap_element_options
						$query = "delete from `".MF_TABLE_PREFIX."element_options` where form_id = ? and element_id = ?";
						$params = array($form_id,$m_element_id);
						mf_do_query($query,$params,$dbh);
				}	
			}
			
		}elseif ('section' == $element_type){
			//do nothing for section break
		}elseif ('file' == $element_type){
			//delete the files first
			$query = "select element_{$element_id} from `".MF_TABLE_PREFIX."form_{$form_id}`";
			$sth = mf_do_query($query,$params,$dbh);
			while($row = mf_do_fetch_result($sth)){
				$filename = $row['element_'.$element_id];
				@unlink($mf_settings['upload_dir']."/form_{$form_id}/files/".$filename);
			}
			
			$query = "ALTER TABLE `".MF_TABLE_PREFIX."form_{$form_id}` DROP COLUMN `element_{$element_id}`;";
			mf_do_query($query,$params,$dbh);
			
		}else{
			$query = "ALTER TABLE `".MF_TABLE_PREFIX."form_{$form_id}` DROP COLUMN `element_{$element_id}`;";
			mf_do_query($query,$params,$dbh);
			
		}
		
		
		//delete on table ap_element_options
		$query = "delete from `".MF_TABLE_PREFIX."element_options` where form_id = ? and element_id = ?";
		$params = array($form_id,$element_id);
		mf_do_query($query,$params,$dbh);
		
		//delete on table ap_form_elements
		$query = "delete from `".MF_TABLE_PREFIX."form_elements` where form_id = ? and element_id = ?";
		$params = array($form_id,$element_id);
		mf_do_query($query,$params,$dbh);
		
	}else{
		//set the status on ap_form_elements table to 0
		$query = "update `".MF_TABLE_PREFIX."form_elements` set element_status = 0 where form_id = ? and element_id = ?";
		$params = array($form_id,$element_id);
		mf_do_query($query,$params,$dbh);
		
		//set the status on ap_element_options table to 0
		$query = "update `".MF_TABLE_PREFIX."element_options` set `live` = 0 where form_id = ? and element_id = ?";
		$params = array($form_id,$element_id);
		mf_do_query($query,$params,$dbh);
		
		//if this is matrix, we need to disable all child rows as well
		if('matrix' == $element_type){
			//check if this is checkbox matrix or radio button matrix
			$query = "select element_matrix_allow_multiselect from `".MF_TABLE_PREFIX."form_elements` where form_id = ? and element_id = ?";
			$params = array($form_id,$element_id);
			
			$sth = mf_do_query($query,$params,$dbh);
			$row = mf_do_fetch_result($sth);
			
			if(!empty($row['element_matrix_allow_multiselect'])){
				$matrix_allow_multiselect = true;
			}else{
				$matrix_allow_multiselect = false;
			}
			
			//get all rows id
			$matrix_rows_ids = array();
			
			$query = "select element_id from `".MF_TABLE_PREFIX."form_elements` where form_id = ? and element_matrix_parent_id = ? and element_type='matrix'";
			$params = array($form_id,$element_id);
			
			$sth = mf_do_query($query,$params,$dbh);
			while($row = mf_do_fetch_result($sth)){
				$matrix_rows_ids[]  = $row['element_id'];	
			}
			$matrix_rows_ids[] = $element_id; //add the first row id
			
			if($matrix_allow_multiselect){ //if this is checkbox matrix
				foreach ($matrix_rows_ids as $m_element_id){
						//get option_id list
						$query = "select option_id from ".MF_TABLE_PREFIX."element_options where form_id = ? and element_id = ? and live=1";
						$params = array($form_id,$m_element_id);
						$sth = mf_do_query($query,$params,$dbh);
						
						$option_id_array = array();
						while($row = mf_do_fetch_result($sth)){
							$option_id_array[] = $row['option_id'];
						}
						
						//delete on table ap_form_elements
						$query = "update `".MF_TABLE_PREFIX."form_elements` set element_status=0 where form_id = ? and element_id = ?";
						$params = array($form_id,$m_element_id);
						mf_do_query($query,$params,$dbh);
						
						//delete on table ap_element_options
						$query = "update `".MF_TABLE_PREFIX."element_options` set live=0 where form_id = ? and element_id = ?";
						$params = array($form_id,$m_element_id);
						mf_do_query($query,$params,$dbh);
				}	
			}else{ //if this is radio button matrix
				
				foreach ($matrix_rows_ids as $m_element_id){
						
						//delete on table ap_form_elements
						$query = "update `".MF_TABLE_PREFIX."form_elements` set element_status=0 where form_id = ? and element_id = ?";
						$params = array($form_id,$m_element_id);
						mf_do_query($query,$params,$dbh);
						
						//delete on table ap_element_options
						$query = "update `".MF_TABLE_PREFIX."element_options` set live=0 where form_id = ? and element_id = ?";
						$params = array($form_id,$m_element_id);
						mf_do_query($query,$params,$dbh);
				}	
			}
		}
	}	
	
	//delete the records on ap_column_preferences, regardless of the MF_CONF_TRUE_DELETE value
	//if the field is matrix field, we need to delete the childs as well
	if('matrix' == $element_type){
		foreach ($matrix_rows_ids as $m_element_id) {
			$query = "delete from ".MF_TABLE_PREFIX."column_preferences where form_id = ? and element_name like ?";
			$params = array($form_id, "element_{$m_element_id}%");
			mf_do_query($query,$params,$dbh);
		}
	}else{
		$query = "delete from ".MF_TABLE_PREFIX."column_preferences where form_id = ? and element_name like ?";
		$params = array($form_id, "element_{$element_id}%");
		mf_do_query($query,$params,$dbh);
	}

	//delete the records on ap_element_prices, regardless of the MF_CONF_TRUE_DELETE
	$query = "delete from ".MF_TABLE_PREFIX."element_prices where form_id = ? and element_id = ?";
	$params = array($form_id,$element_id);
	mf_do_query($query,$params,$dbh);

	//if there is no price fields available, make sure to set the value of payment_enable_merchant on ap_forms table to 0
	$query = "select count(*) total_price_fields from ".MF_TABLE_PREFIX."element_prices where form_id=?";
	$params = array($form_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);

	if(empty($row['total_price_fields'])){
		$query = "update ".MF_TABLE_PREFIX."forms set payment_enable_merchant='0' where form_id=?";
		$params = array($form_id);
		mf_do_query($query,$params,$dbh);
	}

	//reset the value of "entries_sort_by" on ap_forms to "id-desc"
	//in the future, we need to improve this and doesn't simply reset to "id-desc"
	//the value should be reset only when the field being deleted is the same as "entries_sort_by" value
	$query = "update ".MF_TABLE_PREFIX."forms set entries_sort_by='id-desc' where form_id=?";
	$params = array($form_id);
	mf_do_query($query,$params,$dbh);
	
	
	$response_data = new stdClass();
	
	$response_data->status    	= "ok";
	$response_data->element_id 	= $element_id;
	
	$response_json = json_encode($response_data);
	
	echo $response_json;
?>