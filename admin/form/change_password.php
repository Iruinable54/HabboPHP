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
	require('lib/password-hash.php');
	
	$dbh = mf_connect_db();
	
	$input = mf_sanitize($_POST);

	if(empty($input['np'])){
		die("Error! You can't open this file directly");
	}else{
		$new_password_plain = $input['np'];
	}

	$hasher = new PasswordHash(8, FALSE);
	$new_password_hash = $hasher->HashPassword($new_password_plain);
	

	$settings['admin_password'] = $new_password_hash;
	mf_ap_settings_update($settings,$dbh);
	
	$_SESSION['MF_SUCCESS'] = 'Your new password has been saved.';

   	echo '{"status" : "ok"}';
	
?>