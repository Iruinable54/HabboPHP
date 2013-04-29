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
$page = (isset($_GET['page'])) ?  safe($_GET['page'],'HTML') : '1';
if($page == 1){
	$config->checkMaintenance();
	if(isset($_POST['bean_gender'])){
		if(isset($_POST['bean_day']) && isset($_POST['bean_month']) && isset($_POST['bean_year'])){
			$day = safe($_POST['bean_day'],'HTML');
			$month = safe($_POST['bean_month'],'HTML');
			$year = safe($_POST['bean_year'],'HTML');
			$gender = safe($_POST['bean_gender'],'HTML');
			if($day < 1 || $day > 31 || $month > 12 || $month < 1 || $year < 1000 || $year > date('Y'))
				$tpl->assign('error_bean','Merci d\'indiquer une date valide');
			elseif($gender != 'F' && $gender != 'M')
				$tpl->assign('error_gender','NULL');
			else{
				$_SESSION['bean'] = $day . "-" . $month . "-" . $year;
				$_SESSION['gender'] = $gender;
				redirection($config->url_site.'/register.php?page=2');
				exit();
			}
			
		}
	}
	$tpl->display('header-lite.tpl');
	$tpl->display('register-step-1.tpl');
}

if($page == 2){
	$config->checkMaintenance();
	if(isset($_POST['submitV'])){
		$Error = new Error();
		
		$req = $db->query('SELECT username FROM users WHERE username = "'.safe($_POST['pseudo'],'SQL').'" LIMIT 1');
		$user_exist = $db->NumRowsC();
		
		$req = $db->query('SELECT mail FROM users WHERE mail = "'.safe($_POST['email'],'SQL').'" LIMIT 1');
		$mail_exist = $db->NumRowsC();
		
		$prefix = array('ADM-','MOD-','M0D-','SOS-','S0S-','XXX-','OWN-','0WN-');
		
		$Syntaxe_email='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'; 
		
		if(isset($_POST['pseudo'])){
			$pseudo_prefix = strtoupper(substr($_POST['pseudo'],0,4)); //Conversion du mot en MAJ et on prend les 4 premières lettre
			$pseudo = trim($_POST['pseudo']);
		}
		
			
		if(isset($_POST['pseudo']) && empty($_POST['pseudo']))
			$Error->set('pseudo',$tpl->assign('error_pseudo','true'));
		elseif(strlen($_POST['pseudo']) > 24)
			$Error->set('pseudo',$tpl->assign('error_pseudo_strlen','true'));
		elseif(!preg_match("#^[0-9a-zA-Z\-]+$#i",$_POST['pseudo']))
			$Error->set('pseudo',$tpl->assign('error_pseudo_preg','true'));
		elseif($user_exist >= 1)
			$Error->set('pseudo',$tpl->assign('error_pseudo_exist','true'));
		elseif(in_array($pseudo_prefix,$prefix))
			$Error->set('pseudo',$tpl->assign('error_pseudo_prefix','true'));
		
			
		if(isset($_POST['email']) && empty($_POST['email']))
			$Error->set('email',$tpl->assign('error_email','true'));
		elseif(!preg_match($Syntaxe_email,$_POST['email']))
			$Error->set('email',$tpl->assign('error_email_syntaxe','true'));
		elseif($mail_exist >= 1)
			$Error->set('email',$tpl->assign('error_email_exist','true'));
			
		if(isset($_POST['password']) && empty($_POST['password']))
			$Error->set('password',$tpl->assign('error_password','true'));
		elseif(strlen($_POST['password']) <= 5)
			$Error->set('password',$tpl->assign('error_strlen','true'));
			
		if(isset($_POST['passwordConfirm']) && empty($_POST['passwordConfirm']))
			$Error->set('passwordConfirm',$tpl->assign('error_passwordConfirm','true'));
			
		if(trim($_POST['passwordConfirm']) != trim($_POST['passwordConfirm']))
			$Error->set('password',$tpl->assign('error_password_different','true'));
		
		if(!isset($_POST['conditions']))
			$Error->set('termofservice',$tpl->assign('error_termofservice','true'));
			
		if($Error->ErrorPresent())
			$tpl->assign('error','true');
				
		else{
				$_SESSION['Register'] = $_POST ;	
				redirection($config->url_site.'/register.php?page=3');
		}
	}
	$tpl->display('header-lite.tpl');
	$tpl->display('register-step-2.tpl');
}


if($page == 3){


	$config->checkMaintenance();
//	if(!isset($_SESSION['uid']) && empty($_SESSION['uid'])) redirection($config->url_site);
	
	$k_public = '6LenR88SAAAAAMcaw4UWGvAUyDD_HIj97eUBsNhf';
	$privatekey = '6LenR88SAAAAAGhwPRprdBpxYR1D591QjX-TVgB9';
	$tpl->assign('captcha',recaptcha_get_html($k_public));
	$tpl->assign('public_key',$k_public);
	
	
	
	if(isset($_POST['hidden']) && isset($_POST["recaptcha_challenge_field"])){
		$resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
		
	if (!$resp->is_valid) {
		$tpl->assign('error_security','true');
		$tpl->assign('error','true');
	}
	elseif(isset($_POST['figure']) && empty($_POST['figure'])){
		$tpl->assign('error_figure','true');
		$tpl->assign('error','true');
	}
	else{
	
		$password = hashMe($_SESSION['Register']['password']);
	
		//print_r($_SESSION);
			
		$UserDB = new Db('users');
		$data = array(
			'username' => 	safe($_SESSION['Register']['pseudo'],'HTML'),
			'password' =>	safe($password),
			'mail'     => 	safe($_SESSION['Register']['email'],'HTML'),
			'rank'     => 	safe($config->rank_default,'SQL'),
			'look'     => 	safe($_POST['figure'],'SQL'),
			'gender'   => 	safe($_SESSION['gender'],'HTML'),
			'motto'    =>	safe($config->motto_default,'SQL'),
			'credits'  => 	safe($config->credit_default,'SQL'),
			'activity_points' => safe($config->activitypoints_default,'SQL'),
			'account_created' => FullDate('hc'),
			'ip_reg'  =>	safe($_SERVER['REMOTE_ADDR'],'HTML'),
			'last_online' => time()
			
		);
		
		$UserDB->save($data);	;
		$uid = $db->getLastID();
		$salt = hashMe(uniqid()) ;
		$Auth->setSaltUsers($uid);
		
		$d = date('Y-m-d') ;
		$req = $db->query('UPDATE habbophp_stats SET inscrits=inscrits+1 WHERE date="'.safe($d,'SQL').'"');
			
			if($req){
				$username = safe($_SESSION['Register']['pseudo'],'SQL') ;
				$password = safe($_SESSION['Register']['password'],'SQL') ;
			
				session_destroy();
				session_start();
				if($Auth->connexion(array('username' => $username,'password' => $password)))
					redirection($config->url_site.'/me.php');
			}
				
			
		}
	}
	$tpl->display('header-lite.tpl');
	$tpl->display('register-step-3.tpl');
}

if($page == 4){

if(!extension_loaded('curl')) redirection($config->url_site.'/index.php?error=facebook_extension_curl');

$config->checkMaintenance();
// Create our Application instance (replace this with your appId and secret).


$facebook = new Facebook(array(
  'appId'  => $config->fb_appid,
  'secret' => $config->fb_secret,
));

Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;

// Get User ID
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
	$_SESSION['fb'] = $user_profile ;
  } catch (FacebookApiException $e) {
   // echo $e->getMessage();
//	echo '<br/>';
//	echo $e->getType();
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
  $token = $facebook->getAccessToken();
} else {
}

$user_profile = $_SESSION['fb'];

//if(!isset($user_profile)) redirection($config->url_site.'/index.php?error=facebook_data_empty');

	if(isset($user_profile['id'])){
	
		
		
		$req = $db->query('SELECT users.id , fb.* FROM users  LEFT JOIN habbophp_users_facebook fb ON fb.uid = users.id WHERE users.id = fb.uid') ;	
		if($db->NumRowsC() == 0)
			$db->query('DELETE FROM habbophp_users_facebook WHERE fid = '.safe($user_profile['id'],'SQL'));
	
		$sql = $db->query('SELECT fid FROM habbophp_users_facebook WHERE fid='.safe($user_profile['id'],'SQL').' LIMIT 1');
		$row = $db->NumRowsC();
		$Error = new Error();
		$tpl->assign('mail_fb',$user_profile['email']);
		if($row == 0){ // Il n'a pas de compte facebook
			if(isset($_POST['figure']) && empty($_POST['figure'])){
				$tpl->assign('error_figure','true');
				$tpl->assign('error','true');
				$Error->set('figure','true');
			}
			if(isset($_POST['hidden'])){
			
				$req = $db->query('SELECT username FROM users WHERE username = "'.safe($_POST['pseudo'],'SQL').'" LIMIT 1');
				$user_exist = $db->NumRowsC();			 
																
				$prefix = array('ADM-','MOD-','M0D-','SOS-','S0S-','XXX-','OWN-','0WN-');
																
				$Syntaxe_email='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'; 
																
				if(isset($_POST['pseudo']))
				$pseudo_prefix = strtoupper(substr($_POST['pseudo'],0,4)); //Conversion du mot en MAJ et on prend les 4 premières lettre
					
				$req = $db->query('SELECT * FROM users WHERE mail = "'.safe($_POST['email'],'SQL').'" LIMIT 1');
				$mail_exist = $db->NumRowsC();
			
					
				if(isset($_POST['pseudo']) && empty($_POST['pseudo']))
					$Error->set('pseudo',$tpl->assign('error_pseudo','true'));
				elseif(strlen($_POST['pseudo']) > 24)
				$Error->set('pseudo',$tpl->assign('error_pseudo_strlen','true'));
				elseif(!preg_match("#^([0-9a-zA-Z\-]+)$#i",$_POST['pseudo']))
					$Error->set('pseudo',$tpl->assign('error_pseudo_preg','true'));
				elseif($user_exist >= 1)
					$Error->set('pseudo',$tpl->assign('error_pseudo_exist','true'));
				elseif(in_array($pseudo_prefix,$prefix))
					$Error->set('pseudo',$tpl->assign('error_pseudo_prefix','true'));
					
				if(isset($_POST['email']) && empty($_POST['email']))
					$Error->set('email',$tpl->assign('error_email','true'));
				elseif(!preg_match($Syntaxe_email,$_POST['email']))
					$Error->set('email',$tpl->assign('error_email_syntaxe','true'));
				elseif($mail_exist >= 1)
					$Error->set('email',$tpl->assign('error_email_exist','true'));
								
			
				if($Error->ErrorPresent()){		
					$tpl->assign('error','true');
				}
				else{
				
					if($user_profile['gender'] == 'male')
						$gender = 'M';
					if($user_profile['gender'] == 'female')
						$gender = 'F' ;
					
					
					$UserDB = new Db('users');
					$data = array(
					'username' => 	safe($_POST['pseudo'],'SQL'),
					'password' =>	'FB_'.hashMe(uniqid()),
					'mail'     => 	safe($_POST['email'],'SQL'),
					'rank'     => 	$config->rank_default,
					'look'     => 	safe($_POST['figure'],'SQL'),
					'gender'   => 	safe($gender['gender'],'SQL'),
					'motto'    =>	$config->motto_default,
					'credits'  => 	$config->credit_default,
					'activity_points' => $config->activitypoints_default,
					'account_created' => FullDate('hc'),
					'ip_reg'  =>	safe($_SERVER['REMOTE_ADDR'],'SQL'),
					'last_online' => time()
			
				);
				
					$UserDB->save($data);
						
					$uid = $db->getLastID();
				
					$salt = hashMe(uniqid()) ;
					
					$req  = $db->query('INSERT INTO habbophp_users_facebook VALUES ("","'.safe($uid,'SQL').'","'.safe($user_profile['id'],'SQL').'")');
					
					$Auth->setSaltUsers($uid);
					
					$d = date('Y-m-d') ;
					$db->query('UPDATE habbophp_stats SET inscrits=inscrits+1 WHERE date="'.$d.'"');
					
					$fid = $user_profile['id'];
					if($Auth->connexionFB($fid) == true)
						redirection($config->url_site.'/me.php');
	
	
				}
			
			}
			$tpl->display('header-lite.tpl');
			$tpl->display('register-fb.tpl');	
				
		} //L'utilisateur a déjà un compte facebook
		else{
	
		
			$fid = $user_profile['id'];
		
			if($Auth->connexionFB($fid) == true)
				redirection($config->url_site.'/me.php');
		}
		
		
		
	}
}

if($page == 5){
$facebook = new Facebook(array(
  'appId'  => $config->fb_appid,
  'secret' => $config->fb_secret
));

Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;

// Get User ID
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
  $token = $facebook->getAccessToken();
} else {

}



if(!isset($user_profile)) { redirection($config->url_site) ; exit ;}

$fid = $user_profile['id'];
if($Auth->connexionFB($fid,true))
	redirection($config->url_site.'/me.php');
else
	redirection($config->url_site);

}

if(!is_numeric($page)) redirection($config->url_site);

?>