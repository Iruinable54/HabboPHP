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

	$dbh = mf_connect_db();
	
	$ssl_suffix = '';
	if(!empty($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] != 'off')){
			$ssl_suffix = 's';
	}
	
	$current_dir = dirname($_SERVER['PHP_SELF']);
    if($current_dir == "/" || $current_dir == "\\"){
		$current_dir = '';
	}
	
	$_SESSION = array();

	setcookie('mf_remember','', time()-3600, "/"); //delete the remember me cookie
	$query = "update ".MF_TABLE_PREFIX."settings set cookie_hash=?";
	$params = array('');
	mf_do_query($query,$params,$dbh);

	header("Location: http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].$current_dir."/index.php");
	exit;
?>