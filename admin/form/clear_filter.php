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
	
	if(empty($form_id)){
		die("This file can't be opened directly.");
	}

	$dbh = mf_connect_db();
	
	//first delete all previous filter
	$query = "delete from `".MF_TABLE_PREFIX."form_filters` where form_id=?";
	$params = array($form_id);
	mf_do_query($query,$params,$dbh);

	//update ap_forms table
	$query = "update ".MF_TABLE_PREFIX."forms set entries_enable_filter=0,entries_filter_type='all' where form_id=?";
	$params = array($form_id);
	mf_do_query($query,$params,$dbh);
	
	$response_data = new stdClass();
	$response_data->status    	= "ok";
	$response_data->form_id 	= $form_id;
	
	$response_json = json_encode($response_data);
	
	echo $response_json;
?>