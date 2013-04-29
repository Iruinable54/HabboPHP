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
	require('includes/entry-functions.php');
	
	$form_id 		   = (int) trim($_POST['form_id']);
	$selected_entries  = mf_sanitize($_POST['selected_entries']);
	$delete_all		   = (int) $_POST['delete_all'];
	$origin			   = trim($_POST['origin']);

	if(empty($form_id)){
		die("This file can't be opened directly.");
	}

	$dbh = mf_connect_db();
	$mf_settings = mf_get_settings($dbh);

	if(!empty($delete_all)){ //this is delete all entries operation
		//check if this form has filter enabled or not
		//if there is filter, delete all entries within the defined filter only
		$query 	= "select 
						 entries_enable_filter
				     from 
				     	 ".MF_TABLE_PREFIX."forms 
				    where 
				    	 form_id = ?";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);

		if(!empty($row)){
			$entries_enable_filter = $row['entries_enable_filter'];
		}

		if(empty($entries_enable_filter)){
			if(MF_CONF_TRUE_DELETE == true){
				//empty the table
				$query = "truncate `".MF_TABLE_PREFIX."form_{$form_id}`";
				$params = array();
				mf_do_query($query,$params,$dbh);

				//empty files folder
				@mf_full_rmdir($mf_settings['upload_dir']."/form_{$form_id}/files");
		
				$old_mask = umask(0);
				mkdir($mf_settings['upload_dir']."/form_{$form_id}/files",0777);
				umask($old_mask);
			}else{
				$query = "update ".MF_TABLE_PREFIX."form_{$form_id} set `status`=0";
				$params = array();
				mf_do_query($query,$params,$dbh);
			}
		}else{ //if there is filter enabled
			//get the entry_id of all rows within the filter
			$target_entry_id_array = mf_get_filtered_entries_ids($dbh,$form_id);
			
			//delete them
			if(!empty($target_entry_id_array)){
				$target_entry_id_joined = implode("','", $target_entry_id_array);

				if(MF_CONF_TRUE_DELETE == true){
					//delete the records from a_form_x table
					$query = "delete from `".MF_TABLE_PREFIX."form_{$form_id}` where `id` in('{$target_entry_id_joined}')";
					$params = array();
					mf_do_query($query,$params,$dbh);

					//delete file uploads too
					//get the element id for file fields
					$file_element_id_array = array();

					$query = "select element_id from ".MF_TABLE_PREFIX."form_elements where element_type='file' and form_id=?";
					$params = array($form_id);
					
					$sth = mf_do_query($query,$params,$dbh);
					while($row = mf_do_fetch_result($sth)){
						$file_element_id_array[] = $row['element_id'];
					}
					
					//delete the files from data folder
					if(!empty($file_element_id_array)){
						foreach ($target_entry_id_array as $entry_id){
							foreach ($file_element_id_array as $element_id){
								$file_uploads = array();
								$file_uploads = glob($mf_settings['upload_dir']."/form_{$form_id}/files/element_{$element_id}_*-{$entry_id}-*");
								
								foreach ($file_uploads as $filename) {
									@unlink($filename);
								}
							}
						}
					}

				}else{
					//simply set the status of the record to 0
					$query = "update `".MF_TABLE_PREFIX."form_{$form_id}` set `status`=0 where `id` in('{$target_entry_id_joined}')";
					$params = array();
					mf_do_query($query,$params,$dbh);
				}
			}
		}
		
	}else{ //only some selected entries being deleted
		
		if(!empty($selected_entries)){
			$target_entry_id_array = array();
			foreach ($selected_entries as $data) {
				$target_entry_id_array[] = (int) str_replace('entry_', '', $data['name']);
			}

			if(!empty($target_entry_id_array)){


				//if the request coming from view_entry.php page, only 1 entry being deleted
				if(!empty($origin) && ($origin == 'view_entry')){

					$_SESSION['MF_SUCCESS'] = "Entry #{$target_entry_id_array[0]} has been deleted.";

					//get the next entry_id
					$all_entry_id_array = mf_get_filtered_entries_ids($dbh,$form_id);
					$entry_key = array_keys($all_entry_id_array,$target_entry_id_array[0]);
					$entry_key = $entry_key[0];
				
					$entry_key++;		

					$next_entry_id = $all_entry_id_array[$entry_key];

					//if there is no entry_id, fetch the first member of the array
					if(empty($next_entry_id) && ($target_entry_id_array[0] != $all_entry_id_array[0])){
						$next_entry_id = $all_entry_id_array[0];
					}
	
				}else{
					$_SESSION['MF_SUCCESS'] = 'Selected entries has been deleted.';
				}

				$target_entry_id_joined = implode("','", $target_entry_id_array);
				
				if(MF_CONF_TRUE_DELETE == true){
					//delete the records from a_form_x table
					$query = "delete from `".MF_TABLE_PREFIX."form_{$form_id}` where `id` in('{$target_entry_id_joined}')";
					$params = array();
					mf_do_query($query,$params,$dbh);

					//delete file uploads too
					//get the element id for file fields
					$file_element_id_array = array();

					$query = "select element_id from ".MF_TABLE_PREFIX."form_elements where element_type='file' and form_id=?";
					$params = array($form_id);
					
					$sth = mf_do_query($query,$params,$dbh);
					while($row = mf_do_fetch_result($sth)){
						$file_element_id_array[] = $row['element_id'];
					}
					
					//delete the files from data folder
					if(!empty($file_element_id_array)){
						foreach ($target_entry_id_array as $entry_id){
							foreach ($file_element_id_array as $element_id){
								$file_uploads = array();
								$file_uploads = glob($mf_settings['upload_dir']."/form_{$form_id}/files/element_{$element_id}_*-{$entry_id}-*");
								
								foreach ($file_uploads as $filename) {
									@unlink($filename);
								}
							}
						}
					}

				}else{
					//simply set the status of the record to 0
					$query = "update `".MF_TABLE_PREFIX."form_{$form_id}` set `status`=0 where `id` in('{$target_entry_id_joined}')";
					$params = array();
					mf_do_query($query,$params,$dbh);
				}
			}
		}
	}	

	
	
	$response_data = new stdClass();
	$response_data->status    	= "ok";
	$response_data->form_id 	= $form_id;

	if(!empty($next_entry_id)){
		$response_data->entry_id = $next_entry_id;
	}else{
		$response_data->entry_id = 0;
	}

	$response_json = json_encode($response_data);
		
	echo $response_json;
?>