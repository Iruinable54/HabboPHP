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
	$action					= trim($_POST['action']); 
	$update_success = false;
	
	if(!empty($form_id) && !empty($action)){
		if($action == 'enable' || $action == 'disable'){
			if($action == 'enable'){
				$form_active = 1;
			}else if($action == 'disable'){
				$form_active = 0;
			}
			
			$params = array($form_active,$form_id);
			$query = "UPDATE `".MF_TABLE_PREFIX."forms` SET form_active=? WHERE form_id=?";
			mf_do_query($query,$params,$dbh);
			
			$update_success = true;
		}
	}
	
	
	

	$response_data = new stdClass();
	
	if($update_success){
		$response_data->status    	= "ok";
	}else{
		$response_data->status    	= "error";
	}
	
	$response_data->form_id 	= $form_id;
	$response_data->action 		= $action;
	$response_json = json_encode($response_data);
	
	echo $response_json;
	
?>