<?php
	require('includes/init.php');


	require('config.php');
	require('includes/language.php');
	require('includes/db-core.php');
	require('includes/common-validator.php');
	require('includes/view-functions.php');
	require('includes/post-functions.php');
	require('includes/filter-functions.php');
	require('includes/entry-functions.php');
	require('includes/helper-functions.php');
	require('includes/theme-functions.php');
	require('lib/swift-mailer/swift_required.php');
	require('lib/recaptchalib.php');
	require('lib/php-captcha/php-captcha.inc.php');
	require('lib/text-captcha.php');
		
	$dbh = mf_connect_db();

	
	if(mf_is_form_submitted()){ //if form submitted
		$input_array   = mf_sanitize($_POST);
		$submit_result = mf_process_form($dbh,$input_array);
		
		if(!isset($input_array['password'])){ //if normal form submitted
			
			if($submit_result['status'] === true){
				if(!empty($submit_result['form_resume_url'])){ //the user saving a form, display success page with the resume URL
					$ssl_suffix = mf_get_ssl_suffix();
					$_SESSION['mf_form_resume_url'][$input_array['form_id']] = $submit_result['form_resume_url'];
					
					header("Location: http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?id={$input_array['form_id']}&done=1");
					exit;
				}else if(!empty($submit_result['review_id'])){ //redirect to review page
					$ssl_suffix = mf_get_ssl_suffix();	
					
					if(!empty($submit_result['origin_page_number'])){
						$page_num_params = '&mf_page_from='.$submit_result['origin_page_number'];
					}
					
					$_SESSION['review_id'] = $submit_result['review_id'];
					header("Location: http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].mf_get_dirname($_SERVER['PHP_SELF'])."/confirm.php?id={$input_array['form_id']}{$page_num_params}");
					exit;
				}else{
					if(!empty($submit_result['next_page_number'])){ //redirect to the next page number
						$_SESSION['mf_form_access'][$input_array['form_id']][$submit_result['next_page_number']] = true;
						$ssl_suffix = mf_get_ssl_suffix();						
							
						header("Location: http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?id={$input_array['form_id']}&mf_page={$submit_result['next_page_number']}");
						exit;
					}else{ //otherwise display success message or redirect to the custom redirect URL
						if(empty($submit_result['form_redirect'])){
							$ssl_suffix = mf_get_ssl_suffix();						
							
							header("Location: http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?id={$input_array['form_id']}&done=1");
							exit;
						}else{
							echo "<script type=\"text/javascript\">window.location.replace('{$submit_result['form_redirect']}')</script>";
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
				
				$markup = mf_display_form($dbh,$input_array['form_id'],$form_params);
			}
		}else{ //if password form submitted
			
			if($submit_result['status'] === true){ //on success, display the form
				$markup = mf_display_form($dbh,$input_array['form_id']);
			}else{
				$custom_error = $submit_result['custom_error']; //error, display the pasword form again
				
				$form_params = array();
				$form_params['custom_error'] = $custom_error;
 				$markup = mf_display_form($dbh,$input_array['form_id'],$form_params);
			}
		}
	}else{
		$form_id 		= (int) trim($_GET['id']);
		$page_number	= (int) trim($_GET['mf_page']);
		
		$page_number 	= mf_verify_page_access($form_id,$page_number);
		
		$resume_key		= trim($_GET['mf_resume']);
		if(!empty($resume_key)){
			$_SESSION['mf_form_resume_key'][$form_id] = $resume_key;
		}
		
		if(!empty($_GET['done']) && (!empty($_SESSION['mf_form_completed'][$form_id]) || !empty($_SESSION['mf_form_resume_url'][$form_id]))){
			$markup = mf_display_success($dbh,$form_id);
		}else{
			$form_params = array();
			$form_params['page_number'] = $page_number;
			$markup = mf_display_form($dbh,$form_id,$form_params);
		}
	}
	
	header("Content-Type: text/html; charset=UTF-8");
	echo $markup;
	echo '<br style="clear:both"/>';
	
?>