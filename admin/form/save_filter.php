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
	$filter_properties_array = mf_sanitize($_POST['filter_prop']);
	$filter_type = mf_sanitize($_POST['filter_type']);

	if(empty($form_id)){
		die("This file can't be opened directly.");
	}

	$dbh = mf_connect_db();
	
	//first delete all previous filter
	$query = "delete from `".MF_TABLE_PREFIX."form_filters` where form_id=?";
	$params = array($form_id);
	mf_do_query($query,$params,$dbh);
	
	//save the new filters
	$query = "insert into `".MF_TABLE_PREFIX."form_filters`(form_id,element_name,filter_condition,filter_keyword) values(?,?,?,?)";

	foreach($filter_properties_array as $data){
		$params = array($form_id,$data['element_name'],$data['condition'],$data['keyword']);
		mf_do_query($query,$params,$dbh);
	}

	//update ap_forms table
	$query = "update ".MF_TABLE_PREFIX."forms set entries_enable_filter=1,entries_filter_type=? where form_id=?";
	$params = array($filter_type,$form_id);
	mf_do_query($query,$params,$dbh);

	$response_data = new stdClass();
	$response_data->status    	= "ok";
	$response_data->form_id 	= $form_id;
	
	$response_json = json_encode($response_data);
	
	echo $response_json;
?>