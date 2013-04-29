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
		
	$dbh = mf_connect_db();
	
	$form_id				= (int) $_POST['form_id'];
	$element_id				= (int) $_POST['element_id']; 
	
	//we need to know if this matrix row is live or just a draft
	//if this is a live row, only set the status to 0
	//if this is a draft row, delete the row completely from the table
	
	$query  = "select 
					 element_status,
					 element_matrix_parent_id 
				from 
					 `".MF_TABLE_PREFIX."form_elements` 
			   where 
			   		 form_id=? and 
		 			 element_id=?";
	$params = array($form_id,$element_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);

	$element_matrix_parent_id = $row['element_matrix_parent_id'];
	
	if($row['element_status'] == 2){ //if this is just a draft row
		$query = "delete from `".MF_TABLE_PREFIX."form_elements` where form_id = ? and element_id = ? and element_status=2";	
		$params = array($form_id,$element_id);
		mf_do_query($query,$params,$dbh);
		
		$query = "delete from `".MF_TABLE_PREFIX."element_options` where form_id = ? and element_id = ?";
		$params = array($form_id,$element_id);
		mf_do_query($query,$params,$dbh);
	}else{
		if(MF_CONF_TRUE_DELETE === true){
			//delete permanently

			//check if this is checkbox matrix or radio button matrix
			$query = "select element_matrix_allow_multiselect from `".MF_TABLE_PREFIX."form_elements` where form_id = ? and element_id = ?";
			$params = array($form_id,$element_matrix_parent_id);
			
			$sth = mf_do_query($query,$params,$dbh);
			$row = mf_do_fetch_result($sth);
			
			if(!empty($row['element_matrix_allow_multiselect'])){
				$matrix_allow_multiselect = true;
			}else{
				$matrix_allow_multiselect = false;
			}

			if($matrix_allow_multiselect){
				//get option_id list
				$query = "select option_id from ".MF_TABLE_PREFIX."element_options where form_id = ? and element_id = ? and live=1";
				$params = array($form_id,$element_id);
				$sth = mf_do_query($query,$params,$dbh);
						
				$option_id_array = array();
				while($row = mf_do_fetch_result($sth)){
					$option_id_array[] = $row['option_id'];
				}
						
				//delete each option from the form table
				$query = "ALTER TABLE `".MF_TABLE_PREFIX."form_{$form_id}` ";
				foreach ($option_id_array as $option_id){
					$query .= " DROP COLUMN `element_{$element_id}_{$option_id}`,";
				}
						
				$query = rtrim($query,',');
				$params = array();
				mf_do_query($query,$params,$dbh);
			}else{ //if this is radio button matrix
				$query = "ALTER TABLE `".MF_TABLE_PREFIX."form_{$form_id}` DROP COLUMN `element_{$element_id}`";
				mf_do_query($query,array(),$dbh);
			}

			//delete on table ap_form_elements
			$query = "delete from `".MF_TABLE_PREFIX."form_elements` where form_id = ? and element_id = ?";
			$params = array($form_id,$element_id);
			mf_do_query($query,$params,$dbh);
							
			//delete on table ap_element_options
			$query = "delete from `".MF_TABLE_PREFIX."element_options` where form_id = ? and element_id = ?";
			$params = array($form_id,$m_element_id);
			mf_do_query($query,$params,$dbh);

		}else{		
			//update the status of the deleted row
			$query = "update `".MF_TABLE_PREFIX."form_elements` set element_status=0 where form_id = ? and element_id = ?";
			$params = array($form_id,$element_id);
			mf_do_query($query,$params,$dbh);
			
			$query = "update `".MF_TABLE_PREFIX."element_options` set `live`=0 where form_id = ? and element_id = ?";
			$params = array($form_id,$element_id);
			mf_do_query($query,$params,$dbh);
		}
	}

	//update the element_constraint column on parent matrix row
	$query = "select element_constraint from ".MF_TABLE_PREFIX."form_elements where form_id=? and element_id=?";
	$params = array($form_id,$element_matrix_parent_id);
		
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
	$element_constraint = $row['element_constraint'];
		
	$element_constraint_array = explode(',', $element_constraint);
	$key = array_search($element_id, $element_constraint_array);
	unset($element_constraint_array[$key]);

	$element_constraint_joined = implode(',', $element_constraint_array);
	$query = "update `".MF_TABLE_PREFIX."form_elements` set element_constraint=? where form_id = ? and element_id = ?";
	$params = array($element_constraint_joined,$form_id,$element_matrix_parent_id);
	mf_do_query($query,$params,$dbh);

	$response_data = new stdClass();
	
	$response_data->status    	= "ok";
	$response_data->element_id 	= $element_id;
	
	$response_json = json_encode($response_data);

	echo $response_json;
	
?>