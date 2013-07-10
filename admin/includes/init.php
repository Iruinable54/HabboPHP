<?php

	header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');
	header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	header('Pragma: no-cache');
	header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

 	@session_start();
 		
 	$path2 = dirname(__FILE__) ;
 	$pathCore = str_replace("admin","",$path2);
 	$pathLang = str_replace("includes","",$path2);
 
 	define('CORE','CORE');
 	
	require $pathCore."/core.php";
	require $path2."/acl.php";
	require $pathLang."/lang/fr.php";
	
	ini_set('display_errors', 1); 
	ini_set('log_errors', 1); 
	error_reporting(E_ALL);
	if(!$Auth->isConnected()) redirection($config->url_site.'/logout.php');
	if($user->rank < 6) redirection($config->url_site.'/logout.php');	
	
?>