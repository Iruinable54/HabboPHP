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
	
	//sleep(3); //temporary for localhost testing
	
	if(empty($_POST['form_id'])){
		die("Error! You can't open this file directly");
	}
	
	$form_id = (int) $_POST['form_id'];
	$theme_id = (int) $_POST['theme_id'];
	
	
	$query = "update ".MF_TABLE_PREFIX."forms set form_theme_id=? where form_id=?";
	$params = array($theme_id,$form_id);
	mf_do_query($query,$params,$dbh);
  
   	echo '{ "status" : "ok" }';
	
?>