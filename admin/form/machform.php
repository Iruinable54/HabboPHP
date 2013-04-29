<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/
	error_reporting(0);

	$include_path = dirname(__FILE__).'/';

	require($include_path.'config.php');
	require($include_path.'includes/language.php');
	require($include_path.'includes/db-core.php');
	require($include_path.'includes/common-validator.php');
	require($include_path.'includes/view-functions.php');
	require($include_path.'includes/post-functions.php');
	require($include_path.'includes/entry-functions.php');
	require($include_path.'includes/filter-functions.php');
	require($include_path.'includes/helper-functions.php');
	require($include_path.'includes/theme-functions.php');
	require($include_path.'hooks/custom_hooks.php');
	require($include_path.'lib/swift-mailer/swift_required.php');		
	require($include_path.'lib/recaptchalib.php');
	require($include_path.'lib/php-captcha/php-captcha.inc.php');
	require($include_path.'lib/text-captcha.php');
	
		
	function display_machform($config){
		
		$form_id       = $config['form_id'];
		$show_border   = $config['show_border'];
		$machform_path = $config['base_path'];
		$machform_data_path = dirname(__FILE__).'/';
		
		if($show_border === true){
			$integration_method = '';
		}else{
			$integration_method = 'php';
		}

		//start session if there isn't any
		if(session_id() == ""){
			@session_start();
		}
		
		$dbh = mf_connect_db();

		if(mf_is_form_submitted()){ //if form submitted
			$input_array   = mf_sanitize($_POST);

			$input_array['machform_data_path'] = $machform_data_path;
			$input_array['machform_base_path'] = $machform_path;
			$submit_result = mf_process_form($dbh,$input_array);
			
			if(!isset($input_array['password'])){ //if normal form submitted
				
				if($submit_result['status'] === true){
					if(!empty($submit_result['form_resume_url'])){ //the user saving a form, display success page with the resume URL
						$_SESSION['mf_form_resume_url'][$input_array['form_id']] = $submit_result['form_resume_url'];
						$ssl_suffix = mf_get_ssl_suffix();

						echo "<script type=\"text/javascript\">top.location = 'http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?id={$input_array['form_id']}&done=1'</script>";
						exit;
					}else if(!empty($submit_result['review_id'])){ //redirect to review page
						$ssl_suffix = mf_get_ssl_suffix();	
						
						if(!empty($submit_result['origin_page_number'])){
							$page_num_params = '&mf_page_from='.$submit_result['origin_page_number'];
						}
						
						$_SESSION['review_id'] = $submit_result['review_id'];
						
						if(strpos($_SERVER['REQUEST_URI'],'?') === false){
							echo "<script type=\"text/javascript\">top.location = '{$_SERVER['REQUEST_URI']}?show_review=1{$page_num_params}'</script>";
						}else{
							echo "<script type=\"text/javascript\">top.location = '{$_SERVER['REQUEST_URI']}&show_review=1{$page_num_params}'</script>";
						}
						exit;
					}else{
						if(!empty($submit_result['next_page_number'])){ //redirect to the next page number
							$_SESSION['mf_form_access'][$input_array['form_id']][$submit_result['next_page_number']] = true;
							$ssl_suffix = mf_get_ssl_suffix();						
								
							echo "<script type=\"text/javascript\">top.location = 'http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?id={$input_array['form_id']}&mf_page={$submit_result['next_page_number']}'</script>";
							exit;
						}else{ //otherwise display success message or redirect to the custom redirect URL
							if(empty($submit_result['form_redirect'])){
								$ssl_suffix = mf_get_ssl_suffix();						
								
								echo "<script type=\"text/javascript\">top.location = 'http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?id={$input_array['form_id']}&done=1'</script>";
								exit;
							}else{
								echo "<script type=\"text/javascript\">top.location = '{$submit_result['form_redirect']}'</script>";
								exit;
							}
						}
					}
				}else if($submit_result['status'] === false){ //there are errors, display the form again with the errors
					$old_values 	= $submit_result['old_values'];
					$custom_error 	= @$submit_result['custom_error'];
					$error_elements = $submit_result['error_elements'];
					
					$form_params = array();
					$form_params['page_number'] = $input_array['page_number'];
					$form_params['populated_values'] = $old_values;
					$form_params['error_elements'] = $error_elements;
					$form_params['custom_error'] = $custom_error;
					$form_params['integration_method'] = $integration_method;
					$form_params['machform_path'] = $machform_path;
					$form_params['machform_data_path'] = $machform_data_path;

					$markup = mf_display_form($dbh,$input_array['form_id'],$form_params);
				}
			}else{ //if password form submitted
				
				if($submit_result['status'] === true){ //on success, display the form
					$form_params = array();
					$form_params['integration_method'] = $integration_method;
					$form_params['machform_path'] = $machform_path;
					$form_params['machform_data_path'] = $machform_data_path;
					
					$markup = mf_display_form($dbh,$input_array['form_id'],$form_params);
				}else{
					$custom_error = $submit_result['custom_error']; //error, display the pasword form again
					
					$form_params = array();
					$form_params['custom_error'] = $custom_error;
	 				$form_params['integration_method'] = $integration_method;
	 				$form_params['machform_path'] = $machform_path;
	 				$form_params['machform_data_path'] = $machform_data_path;

	 				$markup = mf_display_form($dbh,$input_array['form_id'],$form_params);
				}
			}
		}else if(!empty($_POST['review_submit']) || !empty($_POST['review_submit_x'])){ //if form review being submitted	
			//commit data from review table to actual table
			$record_id 	   = $_SESSION['review_id'];
			
			$form_params = array();
			$form_params['machform_path'] = $machform_path;
			$form_params['machform_data_path'] = $machform_data_path;

			$commit_result = mf_commit_form_review($dbh,$form_id,$record_id,$form_params);
			
			unset($_SESSION['review_id']);
			
			if(empty($commit_result['form_redirect'])){
				$ssl_suffix = mf_get_ssl_suffix();
				
				echo "<script type=\"text/javascript\">top.location = 'http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?id={$form_id}&done=1'</script>";
				exit;
			}else{
				
				echo "<script type=\"text/javascript\">top.location = '{$commit_result['form_redirect']}'</script>";
				exit;
			}
		}elseif (!empty($_POST['review_back']) || !empty($_POST['review_back_x'])){ 
			//go back to form
			$origin_page_num = (int) $_POST['mf_page_from'];
			$ssl_suffix = mf_get_ssl_suffix();
			
			echo "<script type=\"text/javascript\">top.location = 'http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?id={$form_id}&mf_page={$origin_page_num}'</script>";
			exit;
		}elseif (!empty($_GET['show_review'])){ //show review page
				if(empty($_SESSION['review_id'])){
					die("Your session has been expired. Please start again.");
				}else{
					$record_id = $_SESSION['review_id'];
				}
				
				$from_page_num = (int) $_GET['mf_page_from'];
				if(empty($from_page_num)){
					$form_page_num = 1;
				}
				
				$form_params = array();
				$form_params['integration_method'] = $integration_method;
				$form_params['machform_path'] = $machform_path;
				$form_params['machform_data_path'] = $machform_data_path;

				$markup = mf_display_form_review($dbh,$form_id,$record_id,$from_page_num,$form_params);
		}else{
			$form_id 		= $form_id;
			$page_number	= (int) trim($_GET['mf_page']);
			
			$page_number 	= mf_verify_page_access($form_id,$page_number);
			
			$resume_key		= trim($_GET['mf_resume']);
			if(!empty($resume_key)){
				$_SESSION['mf_form_resume_key'][$form_id] = $resume_key;
			}
			
			if(!empty($_GET['done']) && (!empty($_SESSION['mf_form_completed'][$form_id]) || !empty($_SESSION['mf_form_resume_url'][$form_id]))){
				
				$form_params = array();
				$form_params['integration_method'] = $integration_method;
				$form_params['machform_path'] 	   = $machform_path;
				
				$markup = mf_display_success($dbh,$form_id,$form_params);
			}else{
				$form_params = array();
				$form_params['page_number'] = $page_number;
				$form_params['integration_method'] = $integration_method;
				$form_params['machform_path'] = $machform_path;
				$form_params['machform_data_path'] = $machform_data_path;
				
				$markup = mf_display_form($dbh,$form_id,$form_params);
			}
		}		


		echo $markup;

		
	}

?>