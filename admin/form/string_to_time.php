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
	
	$_POST = mf_sanitize($_POST);
	
	$default_date = trim($_POST['default_date']);
	$input_format = trim($_POST['date_format']);
		
	$response_data 	  = new stdClass();
	
	$slash_pos = strpos($default_date,'/');
	if(($input_format == 'europe_date') && !empty($slash_pos) ){
		//if the input format is europe date (dd/mm/yyyy) and the input is ##/##/#### we need to convert the input into mm/dd/yyyy format
		//since the strtotime function only accept mm/dd/yyyy
		$exploded = explode('/',$default_date);
		$default_date = $exploded[1].'/'.$exploded[0].'/'.$exploded[2];
	}
	
	$timestamp = strtotime($default_date);

	if(($timestamp !== false) && ($timestamp != -1)){
		$response_data->status    			= "ok";
		$response_data->default_date 		= date('d-m-Y', $timestamp);
		
	}else{
		$response_data->status    			= "false";
	}
	
	
	
	$response_json = json_encode($response_data);
	
	echo $response_json;
	
?>