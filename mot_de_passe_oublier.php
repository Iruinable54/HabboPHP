<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

define('CORE','CORE');
require 'includes/core.php';

if(!isset($_GET['key']) OR !Validate::ValideInput(array('key' => 'isClean'))) redirection ($config->url_site.'/'); 

$key = safe($_GET['key'],'SQL');
$req = $db->query('SELECT pf.* , us.mail FROM  habbophp_password_forgotten pf  LEFT JOIN users us ON pf.uid = us.id WHERE pf.keysecret="'.$key.'"');
if ($db->NumRowsC() == 0) redirection($config->url_site);
$data = $db->getQuery(true);



if(time() > $data['expire']){
	$db->query('DELETE FROM habbophp_password_forgotten WHERE id="'.$data['id'].'"');
	redirection($config->url_site.'/');
}


if(isset($_POST['password'])){
	$Error = new error();
	$s = true ;
	if(isset($_POST['password']) && empty($_POST['password'])){
		$Error->set('password',$tpl->assign('error_password_empty','true'));
		$tpl->assign('error','true');
		$s = false ;
	}
	elseif(strlen($_POST['password']) <= 5)
			$Error->set('password',$tpl->assign('error_strlen','true'));
			
	if(isset($_POST['retypedPassword']) && empty($_POST['retypedPassword'])){
		$Error->set('retypedPassword',$tpl->assign('error_empty_retypedPassword','true'));
		$tpl->assign('error','true');
		$s = false ;
	}
	if(isset($_POST['password']) && isset($_POST['retypedPassword']) && $s == true){
		if(trim($_POST['password']) != trim($_POST['retypedPassword'])){
			$Error->set('passwordNot',$tpl->assign('error_password_not_egal','true'));	
			$tpl->assign('error','true');
			
		}
	}
	
	if(!$Error->ErrorPresent()){
		$password = hashMe($_POST['password']);
		
		$req = $db->query('UPDATE users SET password="'.safe($password,'HTML').'" WHERE id="'.safe($data['uid'],'HTML').'"');
			   $db->query('DELETE FROM habbophp_password_forgotten WHERE id="'.safe($data['id'],'HTML').'"');
			redirection($config->url_site.'/');
	
	}
	
}

$tpl->assign('email',$data['mail']);


$tpl->display('password_forgotten.tpl');

?>