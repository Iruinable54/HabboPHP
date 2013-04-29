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
	
	$dbh = mf_connect_db();
	$mf_settings = mf_get_settings($dbh);
	
	$form_id		= (int) $_POST['form_id'];
	$holder_id		= trim($_POST['holder_id']);
	$filename		= trim($_POST['filename']);
	$element_id		= (int) $_POST['element_id'];
	$is_db_live		= (int) $_POST['is_db_live'];	
	$key_id			= trim($_POST['key_id']);

	$machform_data_path = dirname(__FILE__).'/';
	
	$is_delete_completed = false;
	
	if(!empty($is_db_live)){
		//if the file already inserted into the review table
		$entry_id = (int) $key_id;
		
		//directory traversal prevention
		$filename = str_replace('.tmp', '', $filename);
		$filename = str_replace('..','',$filename);
		
		if($is_db_live == 2 && $_SESSION['mf_logged_in'] === true){
			//if this is edit_entry page
			$table_suffix = "";
		}else{
			$table_suffix = "_review";
		}

		//check if the file exist within the db or not
		$query = "select `element_{$element_id}` as file_record from ".MF_TABLE_PREFIX."form_{$form_id}{$table_suffix} where `id` = :entry_id and element_{$element_id} like :filename";
		$params = array('entry_id' => $entry_id,'filename' => '%'.$filename.'%');

		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
		
		if(!empty($row['file_record'])){
			$file_record_array = explode('|',$row['file_record']);
			
			$regex    = '/^element_([0-9]*)_([0-9a-zA-Z]*)-([0-9]*)-(.*)$/';
			$new_files = array();
			foreach ($file_record_array as $current_file_record){
				$matches  = array();
				preg_match($regex, $current_file_record,$matches);
				$filename_noelement = $matches[4];
				
				if($filename_noelement == $filename){
					$complete_filename = $current_file_record;
				}else{
					$new_files[] = $current_file_record;
				}
			}
		}
		
		
		if(!empty($complete_filename)){
			
			if($is_db_live == 2 && $_SESSION['mf_logged_in'] === true){
				//if this is edit_entry page
				$file_tmp_suffix = "";
			}else{
				$file_tmp_suffix = ".tmp";
			}

			$complete_filename = $machform_data_path.$mf_settings['upload_dir']."/form_{$form_id}/files/{$complete_filename}{$file_tmp_suffix}";
			
			if(file_exists($complete_filename)){
				unlink($complete_filename);
				
				//update the data within the table
				$new_files_joined = implode('|',$new_files);
				$query = "update ".MF_TABLE_PREFIX."form_{$form_id}{$table_suffix} set `element_{$element_id}` = ? where `id` = ?";
				$params = array($new_files_joined,$entry_id);
				mf_do_query($query,$params,$dbh);
				
				$is_delete_completed = true;
			}
		}
		
	}else{
		//if the file not being saved into the table yet, only within the list file
		$file_token = $key_id;
		
		//directory traversal prevention
		$filename = str_replace('../','',$filename);
		
		$complete_filename = $machform_data_path.$mf_settings['upload_dir']."/form_{$form_id}/files/element_{$element_id}_{$file_token}-{$filename}.tmp";
		
		if(file_exists($complete_filename)){
			unlink($complete_filename);
			$is_delete_completed = true;
		
		}
		
		$listfile_name = $machform_data_path.$mf_settings['upload_dir']."/form_{$form_id}/files/listfile_{$file_token}.php";
		
		$current_files = file($listfile_name);
		$new_files = '';
		foreach ($current_files as $value){
			$current_line = trim($value);
			$target_file  = $complete_filename;
			
			if($target_file != $current_line){
				$new_files .= $value;
			}
		}
		
		if($new_files == "<?php\n?>"){
			unlink($listfile_name);
		}else{
			file_put_contents($listfile_name, $new_files, LOCK_EX);
		}
	}
	
	$response_data = new stdClass();
	
	if($is_delete_completed){
		$response_data->status    	= "ok";
		$response_data->holder_id	= $holder_id;
	}else{
		$response_data->status    	= "error";
	}
	
	$response_json = json_encode($response_data);
	
	echo $response_json;
	
?>