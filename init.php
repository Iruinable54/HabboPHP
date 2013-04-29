<?php

	header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');
	header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	header('Pragma: no-cache');
	header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

 	@session_start();
 	
 	if($_SERVER['PHP_SELF'] == '/init.php') exit ;
 	
 	if(preg_match('#ajax#',$_SERVER['PHP_SELF'])){
 		define('SMARTY_LANG','SMARTY_LANG');
 		$admin = false ;
 	}
 	
 	define('CORE','CORE');
	require dirname(__FILE__)."/includes/core.php";
	if(!defined('AUTH'))
		if(!$Auth->isConnected()) redirection($config->url_site.'/logout.php');	
	
?>