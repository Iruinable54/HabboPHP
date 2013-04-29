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

	require('includes/language.php');
	require('includes/common-validator.php');
	require('includes/post-functions.php');
	require('includes/filter-functions.php');
	require('includes/entry-functions.php');
	require('includes/view-functions.php');
	
	$form_id  = (int) trim($_GET['form_id']);
	$entry_id = (int) trim($_GET['entry_id']);
	$nav = trim($_GET['nav']);

	$dbh = mf_connect_db();
	$mf_settings = mf_get_settings($dbh);
	
	//get form name
	$query 	= "select 
					 form_name
			     from 
			     	 ".MF_TABLE_PREFIX."forms 
			    where 
			    	 form_id = ?";
	$params = array($form_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
	
	if(!empty($row)){
		$form_name = htmlspecialchars($row['form_name']);
	}

	//if there is "nav" parameter, we need to determine the correct entry id and override the existing entry_id
	if(!empty($nav)){
		$all_entry_id_array = mf_get_filtered_entries_ids($dbh,$form_id);
		$entry_key = array_keys($all_entry_id_array,$entry_id);
		$entry_key = $entry_key[0];

		if($nav == 'prev'){
			$entry_key--;
		}else{
			$entry_key++;
		}

		$entry_id = $all_entry_id_array[$entry_key];

		//if there is no entry_id, fetch the first/last member of the array
		if(empty($entry_id)){
			if($nav == 'prev'){
				$entry_id = array_pop($all_entry_id_array);
			}else{
				$entry_id = $all_entry_id_array[0];
			}
		}
	}

	if(mf_is_form_submitted()){ //if form submitted
		$input_array   = mf_sanitize($_POST);
		$submit_result = mf_process_form($dbh,$input_array);
		
		if($submit_result['status'] === true){
			$_SESSION['MF_SUCCESS'] = 'Entry #'.$input_array['edit_id'].' has been updated.';

			$ssl_suffix = mf_get_ssl_suffix();						
			header("Location: http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].mf_get_dirname($_SERVER['PHP_SELF'])."/view_entry.php?form_id={$input_array['form_id']}&entry_id={$input_array['edit_id']}");
			exit;
		}else if($submit_result['status'] === false){ //there are errors, display the form again with the errors
			$old_values 	= $submit_result['old_values'];
			$custom_error 	= @$submit_result['custom_error'];
			$error_elements = $submit_result['error_elements'];
				
			$form_params = array();
			$form_params['populated_values'] = $old_values;
			$form_params['error_elements']   = $error_elements;
			$form_params['custom_error'] 	 = $custom_error;
			$form_params['edit_id']			 = $input_array['edit_id'];
			$form_params['integration_method'] = 'php';
			$form_params['page_number'] = 0; //display all pages (if any) as a single page

			$form_markup = mf_display_form($dbh,$input_array['form_id'],$form_params);
		}

	}else{ //otherwise, display the form with the values
		//set session value to override password protected form
		$_SESSION['user_authenticated'] = $form_id;
		
		//set session value to bypass unique checking
		$_SESSION['edit_entry']['form_id']  = $form_id;
		$_SESSION['edit_entry']['entry_id'] = $entry_id;

		$form_values = mf_get_entry_values($dbh,$form_id,$entry_id);
		
		$form_params = array();
		$form_params['populated_values'] = $form_values;
		$form_params['edit_id']			 = $entry_id;
		$form_params['integration_method'] = 'php';
		$form_params['page_number'] = 0; //display all pages (if any) as a single page

		$form_markup = mf_display_form($dbh,$form_id,$form_params);
	}
	

	$header_data =<<<EOT
<link type="text/css" href="js/jquery-ui/themes/base/jquery.ui.all.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="css/entry_print.css" media="print">
EOT;

	$current_nav_tab = 'manage_forms';
	require('includes/header.php'); 
	
?>


		<div id="content" class="full">
			<div class="post edit_entry">
				<div class="content_header">
					<div class="content_header_title">
						<div style="float: left">
							<h2><?php echo "<a class=\"breadcrumb\" href='manage_forms.php?id={$form_id}'>".$form_name.'</a>'; ?> <img src="images/icons/resultset_next.gif" /> <?php echo "<a id=\"ve_a_entries\" class=\"breadcrumb\" href='manage_entries.php?id={$form_id}'>Entries</a>"; ?> <img id="ve_a_next" src="images/icons/resultset_next.gif" /> #<?php echo $entry_id; ?></h2>
							<br />
						</div>	
						
						<div style="clear: both; height: 1px"></div>
					</div>
					
				</div>

				<?php mf_show_message(); ?>

				<div class="content_body">
					<div id="ve_details" data-formid="<?php echo $form_id; ?>" data-entryid="<?php echo $entry_id; ?>">
						<?php echo $form_markup; ?>
					</div>
					<div id="ve_actions">
						<div id="ve_entry_navigation">
							<a href="<?php echo "edit_entry.php?form_id={$form_id}&entry_id={$entry_id}&nav=prev"; ?>" title="Previous Entry"><img src="images/icons/16_left.png" /></a>
							<a href="<?php echo "edit_entry.php?form_id={$form_id}&entry_id={$entry_id}&nav=next"; ?>" title="Next Entry" style="margin-left: 5px"><img src="images/icons/16_right.png" /></a>
						</div>
						<div id="ve_entry_actions" class="gradient_blue">
							<ul>
								<li style="border-bottom: 1px dashed #8EACCF"><a id="ve_action_view" title="View Entry" href="<?php echo "view_entry.php?form_id={$form_id}&entry_id={$entry_id}"; ?>">View</a></li>
								<li style="border-bottom: 1px dashed #8EACCF"><a id="ve_action_email" title="Email Entry" href="#">Email</a></li>
								<li><a id="ve_action_delete" title="Delete Entry" href="#">Delete</a></li>
							</ul>
						</div>
					</div>
				</div> <!-- /end of content_body -->	
			
			</div><!-- /.post -->
		</div><!-- /#content -->

<div id="dialog-confirm-entry-delete" title="Are you sure you want to delete this entry?" class="buttons" style="display: none">
	<img src="images/icons/hand.png" title="Confirmation" /> 
	<p id="dialog-confirm-entry-delete-msg">
		This action cannot be undone.<br/>
		<strong id="dialog-confirm-entry-delete-info">Data and files associated with this entry will be deleted.</strong><br/><br/>
		If you are sure with this, you can continue with the deletion.<br /><br />
	</p>				
</div>

<div id="dialog-email-entry" title="Email entry #<?php echo $entry_id; ?> to:" class="buttons" style="display: none"> 
	<form id="dialog-email-entry-form" class="dialog-form" style="padding-left: 10px;padding-bottom: 10px">	
		<ul>
			<li>
				<div>
					<input type="text" value="" class="text" name="dialog-email-entry-input" id="dialog-email-entry-input" />
				</div> 
				<div class="infomessage" style="padding-top: 5px;padding-bottom: 0px">Use commas to separate email addresses.</div>
			</li>
		</ul>
	</form>
</div>

<div id="dialog-entry-sent" title="Success!" class="buttons" style="display: none">
	<img src="images/icons/62_green_48.png" title="Success" /> 
	<p id="dialog-entry-sent-msg">
			The entry has been sent.
	</p>
</div>
 
<?php

	$footer_data =<<<EOT
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.tabs.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.sortable.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.draggable.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.position.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.dialog.js"></script>
<script type="text/javascript" src="js/view_entry.js"></script>
EOT;

	$disable_jquery_loading = true;
	
	require('includes/footer.php'); 
?>