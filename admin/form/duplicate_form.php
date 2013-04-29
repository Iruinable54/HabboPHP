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
	$mf_settings = mf_get_settings($dbh);
	
	$form_id = (int) $_POST['form_id'];
	$duplicate_success = false;
	
	
	//get the new form name
	$query 	= "select form_name from `".MF_TABLE_PREFIX."forms` where form_id=?";
	$params = array($form_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
	
	$form_name 	 = trim($row['form_name']);
	$form_name .= " Copy";
	
	//get the new form_id
	$query = "select max(form_id)+1 new_form_id from `".MF_TABLE_PREFIX."forms`";
	$params = array();
	
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
	$new_form_id = trim($row['new_form_id']);
	
	
	//get the columns of ap_forms table
	$query = "show columns from ".MF_TABLE_PREFIX."forms where Field <> 'form_id' and Field <> 'form_name'";
	$params = array();
	
	$columns = array();
	$sth = mf_do_query($query,$params,$dbh);
	while($row = mf_do_fetch_result($sth)){
		$columns[] = $row['Field'];
	}
	
	$columns_joined = implode(",",$columns);
	
	//insert the new record into ap_forms table
	$query = "insert into 
							`".MF_TABLE_PREFIX."forms`(form_id,form_name,{$columns_joined}) 
					   select 
							? , ? ,{$columns_joined} 
						from 
							`".MF_TABLE_PREFIX."forms` 
						where 
							form_id = ?";
	$params = array($new_form_id,$form_name,$form_id);
	mf_do_query($query,$params,$dbh);
	
	//create the new table
	$query = "create table `".MF_TABLE_PREFIX."form_{$new_form_id}` like `".MF_TABLE_PREFIX."form_{$form_id}`";
	$params = array();
	mf_do_query($query,$params,$dbh);
	
	//copy ap_form_elements table
	
	//get the columns of ap_form_elements table
	$query = "show columns from ".MF_TABLE_PREFIX."form_elements where Field <> 'form_id'";
	$params = array();
	
	$columns = array();
	$sth = mf_do_query($query,$params,$dbh);
	while($row = mf_do_fetch_result($sth)){
		$columns[] = $row['Field'];
	}
	
	$columns_joined = implode(",",$columns);
	
	//insert the new record into ap_form_elements table
	$query = "insert into 
							`".MF_TABLE_PREFIX."form_elements`(form_id, {$columns_joined}) 
					   select 
							? , {$columns_joined} 
						from 
							`".MF_TABLE_PREFIX."form_elements` 
						where 
							form_id = ?";
	$params = array($new_form_id,$form_id);
	mf_do_query($query,$params,$dbh);
	
	//copy ap_element_options table
	
	//get the columns of ap_element_options table
	$query = "show columns from ".MF_TABLE_PREFIX."element_options where Field <> 'form_id' and Field <> 'aeo_id'";
	$params = array();
	
	$columns = array();
	$sth = mf_do_query($query,$params,$dbh);
	while($row = mf_do_fetch_result($sth)){
		$columns[] = $row['Field'];
	}
	
	$columns_joined = implode("`,`",$columns);
	
	//insert the new record into ap_element_options table
	$query = "insert into 
							`".MF_TABLE_PREFIX."element_options`(form_id, `{$columns_joined}`) 
					   select 
							? , `{$columns_joined}` 
						from 
							`".MF_TABLE_PREFIX."element_options` 
						where 
							form_id = ?";
	$params = array($new_form_id,$form_id);
	mf_do_query($query,$params,$dbh);
	
	//copy ap_column_preferences table
	
	//get the columns of ap_column_preferences table
	$query = "show columns from ".MF_TABLE_PREFIX."column_preferences where Field <> 'form_id' and Field <> 'acp_id'";
	$params = array();
	
	$columns = array();
	$sth = mf_do_query($query,$params,$dbh);
	while($row = mf_do_fetch_result($sth)){
		$columns[] = $row['Field'];
	}
	
	$columns_joined = implode(",",$columns);
	
	//insert the new record into ap_column_preferences table
	$query = "insert into 
							`".MF_TABLE_PREFIX."column_preferences`(form_id, {$columns_joined}) 
					   select 
							? , {$columns_joined} 
						from 
							`".MF_TABLE_PREFIX."column_preferences` 
						where 
							form_id = ?";
	$params = array($new_form_id,$form_id);
	mf_do_query($query,$params,$dbh);
	
	
	//copy ap_element_prices table
	
	//get the columns of ap_element_prices table
	$query = "show columns from ".MF_TABLE_PREFIX."element_prices where Field <> 'form_id' and Field <> 'aep_id'";
	$params = array();
	
	$columns = array();
	$sth = mf_do_query($query,$params,$dbh);
	while($row = mf_do_fetch_result($sth)){
		$columns[] = $row['Field'];
	}
	
	$columns_joined = implode("`,`",$columns);
	
	//insert the new record into ap_element_options table
	$query = "insert into 
							`".MF_TABLE_PREFIX."element_prices`(form_id, `{$columns_joined}`) 
					   select 
							? , `{$columns_joined}` 
						from 
							`".MF_TABLE_PREFIX."element_prices` 
						where 
							form_id = ?";
	$params = array($new_form_id,$form_id);
	mf_do_query($query,$params,$dbh);
	
	
	//copy review table, if there is any
	$review_table_exist = true;
	try {
		  $dbh->query("select count(*) from `".MF_TABLE_PREFIX."form_{$form_id}_review`");
	} catch(PDOException $e) {
		  $review_table_exist  = false;
	}
	
	if($review_table_exist){
		$query = "CREATE TABLE `".MF_TABLE_PREFIX."form_{$new_form_id}_review` like `".MF_TABLE_PREFIX."form_{$form_id}_review`";
		mf_do_query($query,$params,$dbh);
	}
	
	
	//create data folder for this form
	if(is_writable($mf_settings['data_dir'])){
			
		$old_mask = umask(0);
		mkdir($mf_settings['data_dir']."/form_{$new_form_id}",0777);
		mkdir($mf_settings['data_dir']."/form_{$new_form_id}/css",0777);
		if($mf_settings['data_dir'] != $mf_settings['upload_dir']){
			mkdir($mf_settings['upload_dir']."/form_{$new_form_id}",0777);
		}
		mkdir($mf_settings['upload_dir']."/form_{$new_form_id}/files",0777);
			
		//copy css file	
		copy($mf_settings['data_dir']."/form_{$form_id}/css/view.css",$mf_settings['data_dir']."/form_{$new_form_id}/css/view.css");
			
		umask($old_mask);
	}
	
	
	
	$duplicate_success = true;

	$response_data = new stdClass();
	
	if($duplicate_success){
		$response_data->status    	= "ok";
	}else{
		$response_data->status    	= "error";
	}
	
	$response_data->form_id 	= $new_form_id;
	$response_json = json_encode($response_data);
	
	$_SESSION['MF_SUCCESS'] = 'Your form has been duplicated.';
	
	echo $response_json;
	
?>