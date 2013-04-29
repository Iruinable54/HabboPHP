<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

session_start();
define('CORE','CORE');
require'includes/core.php';


if(extension_loaded('curl'))
	require 'class/facebook.php';

if($Auth->isConnected()) redirection($config->url_site.'/me.php');
$config->checkMaintenance();

$Error = new Error();
if(isset($_POST['username'])){
	if(isset($_POST['username']) && empty($_POST['username']))
		$Error->set('pseudo',$tpl->assign('error_login_pseudo','true'));
	if(isset($_POST['password']) && empty($_POST['password']))
		$Error->set('password',$tpl->assign('error_login_password','true'));
		
				
	if(!$Error->ErrorPresent()){
		if($Auth->connexion($_POST)){
			redirection($config->url_site.'/me.php');
		}else{
			$Error->set('AuthFalse',$tpl->assign('error_login_wrong','true'));
		}
	}
}


if(isset($_GET['ban']) && is_numeric($_GET['ban'])){
	$isBan = $db->query('SELECT * FROM bans WHERE id="'.safe($_GET['ban'],'SQL').'"',true,false);
	if($isBan){
		$tpl->assign('error_ban','true');
		$tpl->assign('reason',$isBan['reason']);
		$tpl->assign('expire',date('d/m/Y H:i:s',$isBan['expire']));
	}
}

if(isset($_GET['error'])){
	switch($_GET['error']){
		case 'token' :
			$tpl->assign('error_get',$tpl->getConfigVars('error_token'));
		break ;
	
	}
}



$tpl->assign('token',Tools::generate_token());
$tpl->display('index-v2.tpl');
?>