<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/
	//check if user logged in or not
	//if not redirect them into login page

	//first we need to check if the user has "remember me" cookie or not
	/*if(!empty($_COOKIE['mf_remember']) && empty($_SESSION['mf_logged_in'])){
		$dbh	     = mf_connect_db();
		$mf_settings = mf_get_settings($dbh);

		if($mf_settings['cookie_hash'] == $_COOKIE['mf_remember']){
			$_SESSION['mf_logged_in'] = true;
		}

	}

	if(empty($_SESSION['mf_logged_in'])){
		if(!empty($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] != 'off')){
			$ssl_suffix = 's';
		}
		
		$current_dir = dirname($_SERVER['PHP_SELF']);
      	if($current_dir == "/" || $current_dir == "\\"){
			$current_dir = '';
		}
		
		$_SESSION['MF_LOGIN_ERROR'] = 'Your session has expired. Please login.';
		header("Location: http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].$current_dir.'/index.php?from='.base64_encode($_SERVER['REQUEST_URI']));
		exit;
	}*/
	
?>