<?php
	define ('AUTH','AUTH');
	require '../init.php' ;
		
if(!isset($_GET['mail']) OR empty($_GET['mail']) OR !Validate::ValideInput(array('mail' => 'isEmail')) ){ echo 'no' ; exit ; }
	$p = safe($_GET['mail'],'SQL');
	if(isset($p) && !empty($p) && $_SERVER['REQUEST_METHOD'] == "GET")
	{
		

		$db->query('SELECT id,username,mail FROM users WHERE mail="'.$p.'"');
	
		if($db->NumRowsC() == 1){
		
		$data = $db->getQuery();
		
		$new_password = hashMe(uniqid()).hashMe(uniqid());
		$expire = time() + 3600 * 24 ;
		$req = $db->query('SELECT id,uid FROM habbophp_password_forgotten WHERE uid="'.$data['id'].'"',true);
		if ($db->NumRowsC() == 0){
			$db->query('INSERT INTO habbophp_password_forgotten VALUES ("","'.$data['id'].'","'.$new_password.'","'.$expire.'")');
		}
		else{
			$db->query("UPDATE habbophp_password_forgotten SET keysecret='".safe($new_password,'SQL')."' WHERE uid='".safe($data['id'],'SQL')."'");
		}
			
		
		
		
		$link = $config->url_site.'/mot_de_passe_oublier.php?key='.$new_password ;
		
		$body = file_get_contents('../modules/mail/password_forgotten.html');
		$body = str_replace('{$url_site}',$config->url_site,$body);
		$body = str_replace('{$pseudo}',$data['username'],$body);
		$body = str_replace('{$link}',$link,$body);
		
		
		
		$mail = new PHPMailer(); // defaults to using php "mail()"
		
		if(!empty($config->smtp_username) && !empty($config->smtp_password)){
		
		$mail->IsSMTP(); // telling the class to use SMTP 
		$mail->SMTPAuth = true; // turn on SMTP authentication 
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465; 
		$mail->Username = $config->smtp_username ;
		$mail->Password = $config->smtp_password ;		
		}
		$mail->setFrom = $config->name ;
		$mail->AddReplyTo($config->email,$config->name);
		$mail->SetFrom($config->email,$config->name);
		$mail->AddReplyTo($config->email,$config->name);
		$mail->AddAddress($p, $data['username']);
		$mail->Subject    = 'Mot de pase oublié' ;
		
		$mail->MsgHTML($body);

			if($mail->Send()) echo "ok"; else echo "errormail" ;
		}
	else{
		echo'no' ;
	}
}
	
?>