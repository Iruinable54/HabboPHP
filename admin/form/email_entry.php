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
	require('includes/check-session.php');

	require('includes/entry-functions.php');
	require('lib/swift-mailer/swift_required.php');
	
	$form_id  = (int) trim($_POST['form_id']);
	$entry_id = (int) trim($_POST['entry_id']);
	$target_email = trim($_POST['target_email']);

	if(empty($form_id) || empty($entry_id) || empty($target_email)){
		die("Invalid parameters.");
	}
		
	$dbh = mf_connect_db();
	$mf_settings = mf_get_settings($dbh);

	//get form properties data
	$query 	= "select 
					 esl_from_name,
					 esl_from_email_address,
					 esl_subject,
					 esl_content,
					 esl_plain_text
				 from 
			     	 `".MF_TABLE_PREFIX."forms` 
			    where 
			    	 form_id=?";
	
	$params = array($form_id);
		
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
				
	$esl_from_name 	= $row['esl_from_name'];
	$esl_from_email_address = $row['esl_from_email_address'];
	$esl_subject 	= $row['esl_subject'];
	$esl_content 	= $row['esl_content'];
	$esl_plain_text	= $row['esl_plain_text'];
	
	//get parameters for the email

	//from name
	if(!empty($esl_from_name)){
		$admin_email_param['from_name'] = $esl_from_name;
	}else{
		$admin_email_param['from_name'] = 'MachForm';
	}
			
	//from email address
	if(!empty($esl_from_email_address)){
		if(is_numeric($esl_from_email_address)){
			$admin_email_param['from_email'] = '{element_'.$esl_from_email_address.'}';
		}else{
			$admin_email_param['from_email'] = $esl_from_email_address;
		}
	}else{
		$domain = str_replace('www.','',$_SERVER['SERVER_NAME']);
		$admin_email_param['from_email'] = "no-reply@{$domain}";
	}
			
	//subject
	if(!empty($esl_subject)){
		$admin_email_param['subject'] = $esl_subject;
	}else{
		$admin_email_param['subject'] = '{form_name} [#{entry_no}]';
	}
			
	//content
	if(!empty($esl_content)){
		$admin_email_param['content'] = $esl_content;
	}else{
		$admin_email_param['content'] = '{entry_data}';
	}

	$admin_email_param['as_plain_text'] = $esl_plain_text;
	$admin_email_param['target_is_admin'] = true; 

	mf_send_notification($dbh,$form_id,$entry_id,$target_email,$admin_email_param);
	
   	echo '{"status" : "ok"}';

?>