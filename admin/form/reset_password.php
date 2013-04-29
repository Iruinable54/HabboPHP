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
	require('lib/swift-mailer/swift_required.php');
	require('lib/password-hash.php');
	
	$target_email = strtolower(trim($_POST['target_email']));

	if(empty($target_email)){
		die("Invalid parameters.");
	}
	
	
	$dbh = mf_connect_db();
	$mf_settings = mf_get_settings($dbh);
	
	//if the wrong email addess being entered, return error message
	if(strtolower($mf_settings['admin_login']) != $target_email){
		echo '{"status" : "error", "message" : "Incorrect email address. Please try again."}';
		return true;
	}

	$new_password = generate_random_string('ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789',10);
	$hasher 	  = new PasswordHash(8, FALSE);
	$new_password_hash = $hasher->HashPassword($new_password);
	$ip_address = $_SERVER['REMOTE_ADDR'];

    $subject = "Your new MachForm password";
    $email_content =<<< EOT
Hello,<br />
<br />
Your password has been reset. Please login to your MachForm admin panel with the new one provided below.<br /><br/>
-------------------------------<br/>
New Password: {$new_password}
<br/>-------------------------------<br/>
<br /><br /><br />
<small>The request to reset the password was being submitted by IP Address: {$ip_address}</small>
EOT;
    	
    $subject = utf8_encode($subject);
    	
    //create the mail transport
	if(!empty($mf_settings['smtp_enable'])){
		$s_transport = Swift_SmtpTransport::newInstance($mf_settings['smtp_host'], $mf_settings['smtp_port']);
			
		if(!empty($mf_settings['smtp_secure'])){
			$s_transport->setEncryption('tls');
		}
			
		if(!empty($mf_settings['smtp_auth'])){
			$s_transport->setUsername($mf_settings['smtp_username']);
  			$s_transport->setPassword($mf_settings['smtp_password']);
		}
	}else{
		$s_transport = Swift_MailTransport::newInstance(); //use PHP mail() transport
	}
    	
    //create mailer instance
	$s_mailer = Swift_Mailer::newInstance($s_transport);
		
	$from_name  = html_entity_decode($mf_settings['default_from_name'],ENT_QUOTES);
	$from_email = $mf_settings['default_from_email'];
		
	if(!empty($mf_settings['admin_login'])){
		$s_message = Swift_Message::newInstance()
		->setCharset('utf-8')
		->setMaxLineLength(1000)
		->setSubject($subject)
		->setFrom(array($from_email => $from_name))
		->setSender($from_email)
		->setReturnPath($from_email)
		->setTo($mf_settings['admin_login'])
		->setBody($email_content, 'text/html');

		//send the message
		$send_result = $s_mailer->send($s_message);
		if(empty($send_result)){
			echo "Error sending email!";
		}else{
			//commit the new password into the database
			$query = "update ".MF_TABLE_PREFIX."settings set admin_password=?";
		   	$params = array($new_password_hash);
		   	mf_do_query($query,$params,$dbh);
		}
	}
	
   	echo '{"status" : "ok", "message" : "A new password has been sent to your email address."}';
   	
   	function generate_random_string($valid_chars, $length){
	   
	    $random_string = "";
	    $num_valid_chars = strlen($valid_chars);

	    for ($i = 0; $i < $length; $i++){
	        $random_pick = mt_rand(1, $num_valid_chars);
	        $random_char = $valid_chars[$random_pick-1];
	        $random_string .= $random_char;
	    }
	    return $random_string;
	}
?>