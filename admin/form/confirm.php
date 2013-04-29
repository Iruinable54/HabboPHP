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
	
	require('includes/language.php');
	require('includes/common-validator.php');
	require('includes/view-functions.php');
	require('includes/theme-functions.php');
	require('includes/post-functions.php');
	require('includes/entry-functions.php');
	require('lib/swift-mailer/swift_required.php');
		
	//get data from database
	$dbh = mf_connect_db();
	
	$form_id   = (int) trim($_REQUEST['id']);
	
	if(!empty($_POST['review_submit']) || !empty($_POST['review_submit_x'])){ //if form submitted
		
		//commit data from review table to actual table
		$record_id 	   = $_SESSION['review_id'];
		$commit_result = mf_commit_form_review($dbh,$form_id,$record_id);
		
		unset($_SESSION['review_id']);
		
		if(empty($commit_result['form_redirect'])){
			$ssl_suffix = mf_get_ssl_suffix();
			
			header("Location: http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?id={$form_id}&done=1");
			exit;
		}else{
			
			echo "<script type=\"text/javascript\">top.location.replace('{$commit_result['form_redirect']}')</script>";
			exit;
		}
		
	}elseif (!empty($_POST['review_back']) || !empty($_POST['review_back_x'])){ 
		//go back to form
		$origin_page_num = (int) $_POST['mf_page_from'];
		$ssl_suffix = mf_get_ssl_suffix();
		header("Location: http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].mf_get_dirname($_SERVER['PHP_SELF'])."/view.php?id={$form_id}&mf_page={$origin_page_num}");
		exit;
	}else{
				
		if(empty($form_id)){
			die('ID required.');
		}
		
		if(!empty($_GET['done']) && !empty($_SESSION['mf_form_completed'][$form_id])){
			$markup = mf_display_success($dbh,$form_id);
		}else{
			if(empty($_SESSION['review_id'])){
				die("Your session has been expired. Please <a href='view.php?id={$form_id}'>click here</a> to start again.");
			}else{
				$record_id = $_SESSION['review_id'];
			}
			
			$from_page_num = (int) $_GET['mf_page_from'];
			if(empty($from_page_num)){
				$form_page_num = 1;
			}
			
			$markup = mf_display_form_review($dbh,$form_id,$record_id,$from_page_num);
		}
	}
	
	header("Content-Type: text/html; charset=UTF-8");
	echo $markup;
	
?>
