<?php
define ('AUTH','AUTH');
require '../init.php';
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
			$Error->set('pseudo','Il faut un pseudo.');
			
		elseif(strlen($_POST['pseudo']) > 24)
			$Error->set('pseudo','Le pseudo est trop long');
			
		elseif(!preg_match("#^[0-9a-zA-Z\-]+$#i",$_POST['pseudo']))
			$Error->set('pseudo','Caractères interdit');
			
		elseif($user_exist >= 1)
			$Error->set('pseudo','Le pseudo est déjà utilisé');
			
		elseif(in_array($pseudo_prefix,$prefix))
			$Error->set('pseudo','Tu n\'as pas le droit de prendre ce suffix.');
		
			
		if(isset($_POST['email']) && empty($_POST['email']))
			$Error->set('email','Le mail est vide');
			
		elseif(!preg_match($Syntaxe_email,$_POST['email']))
			$Error->set('email','Le mail n\'est pas valide.');
			
		elseif($mail_exist >= 1)
			$Error->set('email','Le mail est déjà utilisé');
			
		if(isset($_POST['password']) && empty($_POST['password']))
			$Error->set('password','Il faut un mot de passe');
		elseif(strlen($_POST['password']) <= 5)
			$Error->set('password','Trop court');
	$json = array();	
		

	if(isset($_POST["recaptcha_challenge_field"])){
		$resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],
		$_POST["recaptcha_challenge_field"],
		$_POST["recaptcha_response_field"]);
		
		if (!$resp->is_valid) {
			$json['c'] = 'Le captcha n\'est pas bon';
			$Error->set('captcha','vide');
		}

	}else{
		$Error->set('captcha','vide');
		$json['c'] = 'Le captcha n\'est pas bon';
	}
	


if(!$Error->ErrorPresent()){
	$password = hashMe($_POST['password']);
	
	$UserDB = new Db('users');
		$data = array(
			'username' => 	safe($_POST['pseudo'],'SQL'),
			'password' =>	safe($password),
			'mail'     => 	safe($_POST['email'],'SQL'),
			'rank'     => 	safe($config->rank_default,'SQL'),
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
				$username = safe($_POST['pseudo'],'SQL') ;
				$password = safe($_POST['password'],'SQL') ;
			
				session_destroy();
				session_start();
				if($Auth->connexion(array('username' => $username,'password' => $password))){
					$json['fini'] = 'yep';
					$json['Auth'] = $Auth->getSaltUsers($uid);
				}
			}
}	
		

$json['pseudo'] = $Error->display('pseudo');
$json['email'] = $Error->display('email');
echo json_encode($json);
			
?>