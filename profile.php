<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require 'init.php';
$tpl->assign('groups','index');

$prefix = substr($user->password,0,2);
$tpl->assign('prefix',$prefix);

$tpl->display('header.tpl');

$page = (isset($_GET['page'])) ?  safe($_GET['page'],'HTML') : 'index';

if($page == 'index'){

	if(isset($_POST['tab'])){

		$user->updateUser('motto',safe($_POST['motto'],'HTML'));
		if(EMULATOR == 'phoenix'){
			$user->updateUser('hide_online',safe($_POST['visibility'],'HTML'));
			$user->updateUser('hide_inroom',safe($_POST['followFriendMode'],'HTML'));
			
			$Syntaxe_email='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'; 
			$db->query('SELECT * FROM users WHERE mail = "'.safe($_POST['email'],'SQL').'" LIMIT 1');
			$mail_exist = $db->NumRowsC();
			$Error = new Error();
			if(isset($_POST['email']) && empty($_POST['email']))
					$Error->set('email',$tpl->assign('error_mail',$tpl->getConfigVars('register_error_email')));
				elseif(!preg_match($Syntaxe_email,$_POST['email'])){
					$Error->set('email',$tpl->assign('error_mail',$tpl->getConfigVars('register_error_email_syntaxe')));
					echo 'coucou' ;
					}
				elseif($_POST['email'] != $user->mail){
					if($mail_exist >= 1){
						
						$Error->set('email',$tpl->assign('error_mail',$tpl->getConfigVars('register_error_email_exist')));
						}
				}
					
			if($Error->ErrorPresent())
				$tpl->assign('error','true');
			else{
				$user->updateUser('mail',safe($_POST['email']));
				$tpl->assign('ok','ture');
				$user->refreshData();
			}
			
		}
		
		
	}

	$tpl->display('profile.tpl');

}

if($page == 'password'){

	
	
	if(isset($_POST['tab'])){
		$Error = new Error();
	if($prefix != 'FB'){
		$lastPassword = hashMe($_POST['lastPassword']);
		$req = $db->query('SELECT password FROM users WHERE password="'.safe($lastPassword,'SQL').'"');
		
		if(isset($_POST['lastPassword']) && empty($_POST['lastPassword']))
			$Error->set('lastPassword',$tpl->assign('error_last_password','true'));
		elseif ($db->NumRowsC() == 0)
			$Error->set('lastPassword',$tpl->assign('profile_error_last_password_correct','true'));
		}
			
		if(isset($_POST['newPassword']) && empty($_POST['newPassword']))
			$Error->set('newPassword',$tpl->assign('profile_error_new_password_empty','true'));
		elseif(strlen($_POST['newPassword']) <= 5)
			$Error->set('password',$tpl->assign('profile_error_new_password_strlen','true'));
			
		if(isset($_POST['newPasswordConfirm']) && empty($_POST['newPasswordConfirm']))
			$Error->set('password',$tpl->assign('profile_error_new_passwordConfirm_empty','true'));
			
		if(trim($_POST['newPasswordConfirm']) != trim($_POST['newPassword']))
			$Error->set('password',$tpl->assign('profile_error_not_egale','true'));
		
		if($Error->ErrorPresent())
			$tpl->assign('error','true');
		else{
			$req = $db->query('UPDATE users SET password="'.hashMe($_POST['newPassword'],'SQL').'" WHERE id="'.$user->id.'"');
			if($req){
				$tpl->assign('success','true');
			}
		}
	}

	$tpl->display('profile-password.tpl');


}



$tpl->display('footer.tpl');

?>