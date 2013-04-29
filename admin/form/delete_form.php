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
	require('includes/theme-functions.php');
		
	$dbh = mf_connect_db();
	$mf_settings = mf_get_settings($dbh);
	
	if(empty($_POST['form_id'])){
		die("Error! You can't open this file directly");
	}
	
	$form_id = (int) $_POST['form_id'];
	
	//depends on the config file 
	//when deleting the form, we can simply set the status of the form_active to '9' which means deleted
	//or delete the form data completely
	if(MF_CONF_TRUE_DELETE === true){ //true deletion
		
		//remove from ap_forms
		$query = "delete from ".MF_TABLE_PREFIX."forms where form_id=?";
		$params = array($form_id);
		mf_do_query($query,$params,$dbh);
		
		//remove from ap_form_elements
		$query = "delete from ".MF_TABLE_PREFIX."form_elements where form_id=?";
		$params = array($form_id);
		mf_do_query($query,$params,$dbh);
		
		//remove from ap_element_options
		$query = "delete from ".MF_TABLE_PREFIX."element_options where form_id=?";
		$params = array($form_id);
		mf_do_query($query,$params,$dbh);
		
		//remove from ap_column_preferences
		$query = "delete from ".MF_TABLE_PREFIX."column_preferences where form_id=?";
		$params = array($form_id);
		mf_do_query($query,$params,$dbh);

		//remove from ap_element_prices
		$query = "delete from ".MF_TABLE_PREFIX."element_prices where form_id=?";
		$params = array($form_id);
		mf_do_query($query,$params,$dbh);
		
		//remove review table
		$query = "drop table if exists `".MF_TABLE_PREFIX."form_{$form_id}_review`";
		$params = array();
		mf_do_query($query,$params,$dbh);
		
		//remove the actual form table
		$query = "drop table if exists `".MF_TABLE_PREFIX."form_{$form_id}`";
		$params = array();
		mf_do_query($query,$params,$dbh);
		
		//remove form folder
		@mf_full_rmdir($mf_settings['upload_dir']."/form_{$form_id}");
		if($mf_settings['upload_dir'] != $mf_settings['data_dir']){
			@mf_full_rmdir($mf_settings['data_dir']."/form_{$form_id}");
		}
		
	}else{ //safe deletion
		$query = "update ".MF_TABLE_PREFIX."forms set form_active=9 where form_id=?";
		$params = array($form_id);
		mf_do_query($query,$params,$dbh);
	}
	
	$_SESSION['MF_SUCCESS'] = 'The form has been deleted.';
  
   	echo '{ "status" : "ok" }';
	
?>