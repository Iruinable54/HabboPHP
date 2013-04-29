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
	
	require('includes/theme-functions.php');
	
	$theme_id = (int) $_GET['theme_id'];
	
	$dbh = mf_connect_db();
	
	$css_content = mf_theme_get_css_content($dbh,$theme_id);
	
	header('Content-type: text/css');
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	
	echo $css_content;
?>