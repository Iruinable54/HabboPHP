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
	
	$form_id 	= (int) trim($_POST['form_id']);
	$column_preferences = mf_sanitize($_POST['col_pref']);

	if(empty($form_id)){
		die("This file can't be opened directly.");
	}

	$dbh = mf_connect_db();
	
	//first delete all previous preferences
	$query = "delete from `".MF_TABLE_PREFIX."column_preferences` where form_id=?";
	$params = array($form_id);
	mf_do_query($query,$params,$dbh);

	//save the new preference
	$query = "insert into `".MF_TABLE_PREFIX."column_preferences`(form_id,element_name,position) values(?,?,?)";

	$position = 1;
	if(!empty($column_preferences)){
		foreach($column_preferences as $data){
			$column_name = $data['name'];
			
			$params = array($form_id,$column_name,$position);
			mf_do_query($query,$params,$dbh);

			$position++;
		}
	}
	
	$response_data = new stdClass();
	$response_data->status    	= "ok";
	$response_data->form_id 	= $form_id;
	
	$response_json = json_encode($response_data);
	
	$_SESSION['MF_SUCCESS'] = 'Your fields preference has been saved.';

	echo $response_json;
?>