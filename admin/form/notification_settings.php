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
	
	require('includes/filter-functions.php');
	require('includes/entry-functions.php');

	$form_id = (int) trim($_GET['id']);
	
	$dbh = mf_connect_db();
	$mf_settings = mf_get_settings($dbh);

	//handle form submission if there is any
	if(!empty($_POST['form_id'])){

		$form_id = (int) $_POST['form_id'];

		$notification_settings = mf_sanitize($_POST);
		array_walk($notification_settings, 'mf_trim_value');

		//save settings for 'Send Notification Emails to My Inbox' section
		$form_input['esl_enable'] = (int) $notification_settings['esl_enable'];

		if(empty($notification_settings['esl_email_address'])){
			$form_input['esl_enable'] = 0;
		}

		$form_input['form_email'] = $notification_settings['esl_email_address'];
		
		if($notification_settings['esl_from_name'] == 'custom'){
			$form_input['esl_from_name'] = $notification_settings['esl_from_name_custom'];
		}else{
			$form_input['esl_from_name'] = $notification_settings['esl_from_name'];
		}

		if($notification_settings['esl_from_email_address'] == 'custom'){
			$form_input['esl_from_email_address'] = $notification_settings['esl_from_email_address_custom'];
		}else{
			$form_input['esl_from_email_address'] = $notification_settings['esl_from_email_address'];
		}

		$form_input['esl_subject'] = $notification_settings['esl_subject'];
		$form_input['esl_content'] = $notification_settings['esl_content'];
		$form_input['esl_plain_text'] = (int) $notification_settings['esl_plain_text'];

		//save settings for 'Send Confirmation to User' section
		$form_input['esr_enable'] = (int) $notification_settings['esr_enable'];
		$form_input['esr_email_address'] = $notification_settings['esr_email_address'];
		
		if($notification_settings['esr_from_name'] == 'custom'){
			$form_input['esr_from_name'] = $notification_settings['esr_from_name_custom'];
		}else{
			$form_input['esr_from_name'] = $notification_settings['esr_from_name'];
		}

		if($notification_settings['esr_from_email_address'] == 'custom'){
			$form_input['esr_from_email_address'] = $notification_settings['esr_from_email_address_custom'];
		}else{
			$form_input['esr_from_email_address'] = $notification_settings['esr_from_email_address'];
		}

		$form_input['esr_subject'] = $notification_settings['esr_subject'];
		$form_input['esr_content'] = $notification_settings['esr_content'];
		$form_input['esr_plain_text'] = (int) $notification_settings['esr_plain_text'];

		mf_ap_forms_update($form_id,$form_input,$dbh);

		$_SESSION['MF_SUCCESS'] = 'Notification settings has been saved.';

		$ssl_suffix = mf_get_ssl_suffix();						
		header("Location: http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].mf_get_dirname($_SERVER['PHP_SELF'])."/manage_forms.php?id={$form_id}&hl=1");
		exit;

	}
	
	//get form properties
	$query 	= "select 
					form_name,
					form_email,
					esl_enable,
					esl_from_name,
					esl_from_email_address,
					esl_subject,
					esl_content,
					esl_plain_text,
					esr_enable,
					esr_email_address,
					esr_from_name,
					esr_from_email_address,
					esr_subject,
					esr_content,
					esr_plain_text 
			     from 
			     	 ".MF_TABLE_PREFIX."forms 
			    where 
			    	 form_id = ?";
	$params = array($form_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
	
	if(!empty($row)){
		$form_name 		= htmlspecialchars($row['form_name']);
		$form_email 	= htmlspecialchars($row['form_email']);
		$esl_from_name 	= htmlspecialchars($row['esl_from_name']);
		$esl_from_email_address	= htmlspecialchars($row['esl_from_email_address']);
		$esl_subject 	= htmlspecialchars($row['esl_subject']);
		$esl_content 	= htmlspecialchars($row['esl_content'],ENT_QUOTES);
		$esl_plain_text	= htmlspecialchars($row['esl_plain_text']);
		$esr_email_address = htmlspecialchars($row['esr_email_address']);
		$esr_from_name 	= htmlspecialchars($row['esr_from_name']);
		$esr_from_email_address	= htmlspecialchars($row['esr_from_email_address']);
		$esr_subject 	= htmlspecialchars($row['esr_subject']);
		$esr_content 	= htmlspecialchars($row['esr_content'],ENT_QUOTES);
		$esr_plain_text	= htmlspecialchars($row['esr_plain_text']);
		$esl_enable     = (int) $row['esl_enable'];
		$esr_enable     = (int) $row['esr_enable'];
	}
	
	//get email fields for this form
	$query = "select 
					element_id,
					element_title 
				from 
					`".MF_TABLE_PREFIX."form_elements` 
			   where 
			   		form_id=? and element_type='email' and element_is_private=0 and element_status=1
			order by 
					element_title asc";
	$params = array($form_id);
	$sth = mf_do_query($query,$params,$dbh);

	$i=1;
	$email_fields = array();
	while($row = mf_do_fetch_result($sth)){
		$email_fields[$i]['label'] = $row['element_title'];
		$email_fields[$i]['value'] = $row['element_id'];
		$i++;
	}
	
	$domain = str_replace('www.','',$_SERVER['SERVER_NAME']);

	//get "from name" fields for this form, which are name fields and single line text fields
	//get email fields for this form
	$query = "select 
					element_id,
					element_title 
				from 
					`".MF_TABLE_PREFIX."form_elements` 
			   where 
			   		form_id=? and element_is_private=0 and element_status=1
			   		and element_type in('text','simple_name','simple_name_wmiddle','name','name_wmiddle')
			order by 
					element_title asc";
	$params = array($form_id);
	$sth = mf_do_query($query,$params,$dbh);

	$i=1;
	$name_fields = array();
	while($row = mf_do_fetch_result($sth)){
		$name_fields[$i]['label'] = $row['element_title'];
		$name_fields[$i]['value'] = $row['element_id'];
		$i++;
	}

	//prepare the values for 'Send Notification Emails to My Inbox'
	
	//from name
	if(empty($esl_from_name)){
		$esl_from_name = 'MachForm';
	}

	$esl_from_name_list[0]['label'] = 'MachForm';
	$esl_from_name_list[0]['value'] = 'MachForm';
	$esl_from_name_list = array_merge($esl_from_name_list,$name_fields);
		
	$array_max_index = count($esl_from_name_list);

	$esl_from_name_list[$array_max_index]['label'] = '&#8674; Set Custom Name';
	$esl_from_name_list[$array_max_index]['value'] = 'custom';

	$esl_from_name_values = array();
	foreach ($esl_from_name_list as $value) {
		$esl_from_name_values[] = $value['value'];
	}

	if(!in_array($esl_from_name, $esl_from_name_values)){
		$esl_from_name_custom = $esl_from_name;
		$esl_from_name = 'custom';
	}

	//from email address
	if(empty($esl_from_email_address)){
		$esl_from_email_address = "no-reply@{$domain}";
	}

	$esl_from_email_address_list[0]['label'] = "no-reply@{$domain}";
	$esl_from_email_address_list[0]['value'] = "no-reply@{$domain}";
	$esl_from_email_address_list = array_merge($esl_from_email_address_list,$email_fields);
		
	$array_max_index = count($esl_from_email_address_list);

	$esl_from_email_address_list[$array_max_index]['label'] = '&#8674; Set Custom Address';
	$esl_from_email_address_list[$array_max_index]['value'] = 'custom';

	$esl_from_email_address_values = array();
	foreach ($esl_from_email_address_list as $value) {
		$esl_from_email_address_values[] = $value['value'];
	}

	if(!in_array($esl_from_email_address, $esl_from_email_address_values)){
		$esl_from_email_address_custom = $esl_from_email_address;
		$esl_from_email_address = 'custom';
	}



	//subject
	if(empty($esl_subject)){
		$esl_subject = '{form_name} [#{entry_no}]';
	}

	//content
	if(empty($esl_content)){
		$esl_content = '{entry_data}';
	}


	//prepare the values for 'Send Confirmation Email to User'
	
	//from name
	if(empty($esr_from_name)){
		$esr_from_name = 'MachForm';
	}

	$esr_from_name_list[0]['label'] = 'MachForm';
	$esr_from_name_list[0]['value'] = 'MachForm';
	$esr_from_name_list = array_merge($esr_from_name_list,$name_fields);
		
	$array_max_index = count($esr_from_name_list);

	$esr_from_name_list[$array_max_index]['label'] = '&#8674; Set Custom Name';
	$esr_from_name_list[$array_max_index]['value'] = 'custom';

	$esr_from_name_values = array();
	foreach ($esr_from_name_list as $value) {
		$esr_from_name_values[] = $value['value'];
	}

	if(!in_array($esr_from_name, $esr_from_name_values)){
		$esr_from_name_custom = $esr_from_name;
		$esr_from_name = 'custom';
	}

	//from email address
	if(empty($esr_from_email_address)){
		$esr_from_email_address = "no-reply@{$domain}";
	}

	$esr_from_email_address_list[0]['label'] = "no-reply@{$domain}";
	$esr_from_email_address_list[0]['value'] = "no-reply@{$domain}";
	$esr_from_email_address_list = array_merge($esr_from_email_address_list,$email_fields);
		
	$array_max_index = count($esr_from_email_address_list);

	$esr_from_email_address_list[$array_max_index]['label'] = '&#8674; Set Custom Address';
	$esr_from_email_address_list[$array_max_index]['value'] = 'custom';

	$esr_from_email_address_values = array();
	foreach ($esr_from_email_address_list as $value) {
		$esr_from_email_address_values[] = $value['value'];
	}

	if(!in_array($esr_from_email_address, $esr_from_email_address_values)){
		$esr_from_email_address_custom = $esr_from_email_address;
		$esr_from_email_address = 'custom';
	}



	//subject
	if(empty($esr_subject)){
		$esr_subject = '{form_name} - Receipt';
	}

	//content
	if(empty($esr_content)){
		$esr_content = '{entry_data}';
	}


	//get all available columns label
	$query  = "select 
					 element_id,
					 element_title,
					 element_type 
			     from
			     	 `".MF_TABLE_PREFIX."form_elements` 
			    where 
			    	 form_id=? and 
			    	 element_type != 'section' and 
			    	 element_status=1
			 order by 
			 		 element_position asc";
	$params = array($form_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	
	
	$columns_label = array();
	$complex_field_columns_label = array();
	while($row = mf_do_fetch_result($sth)){
		$element_title = $row['element_title'];
		$element_id    = $row['element_id'];
		$element_type  = $row['element_type']; 

		//limit the title length to 40 characters max
		if(strlen($element_title) > 40){
			$element_title = substr($element_title,0,40).'...';
		}

		$element_title = htmlspecialchars($element_title,ENT_QUOTES);
		$columns_label['element_'.$element_id] = $element_title;

		//for some field type, we need to provide more detailed template variables
		//the special field types are Name and Address
		if('simple_name' == $element_type){
			$complex_field_columns_label['element_'.$element_id.'_1'] = $element_title." (First)";
			$complex_field_columns_label['element_'.$element_id.'_2'] = $element_title." (Last)";
		}else if('simple_name_wmiddle' == $element_type){
			$complex_field_columns_label['element_'.$element_id.'_1'] = $element_title." (First)";
			$complex_field_columns_label['element_'.$element_id.'_2'] = $element_title." (Middle)";
			$complex_field_columns_label['element_'.$element_id.'_3'] = $element_title." (Last)";			
		}else if('name' == $element_type){
			$complex_field_columns_label['element_'.$element_id.'_1'] = $element_title." (Title)";
			$complex_field_columns_label['element_'.$element_id.'_2'] = $element_title." (First)";
			$complex_field_columns_label['element_'.$element_id.'_3'] = $element_title." (Last)";
			$complex_field_columns_label['element_'.$element_id.'_4'] = $element_title." (Suffix)";
		}else if('name_wmiddle' == $element_type){
			$complex_field_columns_label['element_'.$element_id.'_1'] = $element_title." (Title)";
			$complex_field_columns_label['element_'.$element_id.'_2'] = $element_title." (First)";
			$complex_field_columns_label['element_'.$element_id.'_3'] = $element_title." (Middle)";
			$complex_field_columns_label['element_'.$element_id.'_4'] = $element_title." (Last)";
			$complex_field_columns_label['element_'.$element_id.'_5'] = $element_title." (Suffix)";
		}else if('address' == $element_type){
			$complex_field_columns_label['element_'.$element_id.'_1'] = $element_title." (Street)";
			$complex_field_columns_label['element_'.$element_id.'_2'] = $element_title." (Address Line 2)";
			$complex_field_columns_label['element_'.$element_id.'_3'] = $element_title." (City)";
			$complex_field_columns_label['element_'.$element_id.'_4'] = $element_title." (State)";
			$complex_field_columns_label['element_'.$element_id.'_5'] = $element_title." (Postal/Zip Code)";
			$complex_field_columns_label['element_'.$element_id.'_6'] = $element_title." (Country)";
		}
	}


		$header_data =<<<EOT
<link type="text/css" href="js/jquery-ui/themes/base/jquery.ui.all.css" rel="stylesheet" />
EOT;

	$current_nav_tab = 'manage_forms';
	require('includes/header.php'); 
	
?>


		<div id="content" class="full">
			<div class="post notification_settings">

<ul class="breadcrumb" style="margin-top:14px;">
  <li>
    <a href="manage_forms.php"><?php echo $lang['Forms']; ?></a> <span class="divider">></span>
  </li>
  <li>
    <a href="#"><?php echo $lang['EmailNotifications']; ?></a> <span class="divider">></span>
  </li>
  <li class="active"><?php echo $form_name; ?></li>
</ul>


					
				</div>
				<div class="content_body">
					
					<form id="ns_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<center><input type="submit" class="btn btn-primary btn-large" value="<?php echo $lang['Update']; ?>" /></center>
					<br />
					<ul id="ns_main_list">
						<li>
							<div id="ns_box_myinbox">
								<div class="well form-inline" <?php if(empty($esl_enable) && !empty($form_email)){ echo 'style="display: none"'; } ?>>
									<label class="checkbox">
    									<input type="checkbox" value="1" class="checkbox" id="esl_enable" name="esl_enable" <?php if(!empty($esl_enable) || (empty($esl_enable) && empty($form_email))){ echo 'checked="checked"';} ?>> <?php echo $lang['SendMeAnEmailWhenTheyAreANewEntrie']; ?>&nbsp;&nbsp;&nbsp;
 								    </label>
									
									<input id="esl_email_address" placeholder="<?php echo $lang['MyEmail']; ?>" name="esl_email_address" value="<?php echo $form_email; ?>" type="text">
									
								</div>
								<div class="ns_box_more" style="display: none">
									<label class="description" for="esl_from_name">From Name <img class="helpmsg" src="images/icons/68_blue.png" style="vertical-align: top" title="If your form has 'Name' or 'Single Line Text' field type, it will be available here and you can choose it as the 'From Name' of the email. Or you can set your own custom 'From Name'"/></label>
									
									<select name="esl_from_name" id="esl_from_name" class="element select medium"> 
										<?php
											foreach ($esl_from_name_list as $data){
												if($esl_from_name == $data['value']){
													$selected = 'selected="selected"';
												}else{
													$selected = '';
												}

												echo "<option value=\"{$data['value']}\" {$selected}>{$data['label']}</option>";
											}
										?>			
									</select>
									<span id="esl_from_name_custom_span" <?php if(empty($esl_from_name_custom)){ echo 'style="display: none"'; } ?>>&#8674; <input id="esl_from_name_custom" name="esl_from_name_custom" class="element text" style="width: 44%" value="<?php echo $esl_from_name_custom; ?>" type="text"></span>
									
									
									<label class="description" for="esl_from_email_address">From Email Address <img class="helpmsg" src="images/icons/68_blue.png" style="vertical-align: top" title="If your form has 'Email' field type, it will be available here and you can choose it as the sender address. Or you can set your own 'From Email Address'"/></label>
									<select name="esl_from_email_address" id="esl_from_email_address" class="element select medium"> 
										<?php
											foreach ($esl_from_email_address_list as $data){
												if($esl_from_email_address == $data['value']){
													$selected = 'selected="selected"';
												}else{
													$selected = '';
												}

												echo "<option value=\"{$data['value']}\" {$selected}>{$data['label']}</option>";
											}
										?>			
									</select>
									<span id="esl_from_email_address_custom_span" <?php if(empty($esl_from_email_address_custom)){ echo 'style="display: none"'; } ?>>&#8674; <input id="esl_from_email_address_custom" name="esl_from_email_address_custom" class="element text" style="width: 44%" value="<?php echo $esl_from_email_address_custom; ?>" type="text"></span>

									<label class="description" for="esl_subject">Email Subject</label>
									<input id="esl_subject" name="esl_subject" class="element text large" value="<?php echo $esl_subject; ?>" type="text">

									<label class="description" for="esl_content">Email Content <img class="helpmsg" src="images/icons/68_blue.png" style="vertical-align: top" title="This field accept HTML codes."/></label>
									<textarea class="element textarea medium" name="esl_content" id="esl_content"><?php echo $esl_content; ?></textarea>

									<span style="display: block;margin-top: 10px">
									<input type="checkbox" value="1" class="checkbox" <?php if(!empty($esl_plain_text)){ echo 'checked="checked"'; } ?> id="esl_plain_text" name="esl_plain_text" style="margin-left: 0px">
									<label for="esl_plain_text" >Send Email in Plain Text Format</label>
									</span>

									<span class="ns_temp_vars"><img style="vertical-align: middle" src="images/icons/70_blue.png"> You can insert <a href="#" class="tempvar_link">template variables</a> into the email template.</span>

								</div>
								<div class="ns_box_more_switcher" <?php if(empty($esl_enable) && !empty($form_email)){ echo 'style="display: none"'; } ?>>
									<a id="more_option_myinbox" href="#">more options</a>
									<img id="myinbox_img_arrow" style="vertical-align: top;margin-left: 3px" src="images/icons/38_rightblue_16.png">
								</div>

							</div>
						</li>
						<li>&nbsp;</li>
						<li>
							<div id="ns_box_user_email" class="well form-inline">
							<label class="checkbox"><input type="checkbox" value="1" class="checkbox" id="esr_enable" name="esr_enable" <?php if(!empty($esr_enable) && !empty($esr_email_address)){ echo 'checked="checked"';} ?>>Send Confirmation Email to User</label>
								<div class="ns_box_email" <?php if(empty($esr_enable)){ echo 'style="display: none"'; } ?>>
									
									<?php if(!empty($email_fields)){ ?>
									<br /><br /><br />
									User Email Address
									<select name="esr_email_address" id="esr_email_address" class="element select medium"> 
										<?php
											foreach ($email_fields as $data){
												if($esr_email_address == $data['value']){
													$selected = 'selected="selected"';
												}else{
													$selected = '';
												}

												echo "<option value=\"{$data['value']}\" {$selected}>{$data['label']}</option>";
											}
										?>			
									</select>
									<?php }else{ ?><br /><br /><br />
										<div class="alert alert-error">No email field available! <br />You need to add an email field into your form.</div>
									<?php } ?>
								</div>
								<div class="ns_box_more" style="display: none">
									<label class="description" for="esr_from_name">From Name <img class="helpmsg" src="images/icons/68_red.png" style="vertical-align: top" title="If your form has 'Name' or 'Single Line Text' field type, it will be available here and you can choose it as the 'From Name' of the email. Or you can set your own custom 'From Name'"/></label>
									<select name="esr_from_name" id="esr_from_name" class="element select medium"> 
										<?php
											foreach ($esr_from_name_list as $data){
												if($esr_from_name == $data['value']){
													$selected = 'selected="selected"';
												}else{
													$selected = '';
												}

												echo "<option value=\"{$data['value']}\" {$selected}>{$data['label']}</option>";
											}
										?>		
									</select>
									<span id="esr_from_name_custom_span" <?php if(empty($esr_from_name_custom)){ echo 'style="display: none"'; } ?>>&#8674; <input id="esr_from_name_custom" name="esr_from_name_custom" class="element text" style="width: 44%" value="<?php echo $esr_from_name_custom; ?>" type="text"></span>

									<label class="description" for="esr_from_email_address">From Email Address <img class="helpmsg" src="images/icons/68_red.png" style="vertical-align: top" title="If your form has 'Email' field type, it will be available here and you can choose it as the sender address. Or you can set your own 'From Email Address'"/></label>
									<select name="esr_from_email_address" id="esr_from_email_address" class="element select medium"> 
										<?php
											foreach ($esr_from_email_address_list as $data){
												if($esr_from_email_address == $data['value']){
													$selected = 'selected="selected"';
												}else{
													$selected = '';
												}

												echo "<option value=\"{$data['value']}\" {$selected}>{$data['label']}</option>";
											}
										?>			
									</select>
									<span id="esr_from_email_address_custom_span" <?php if(empty($esr_from_email_address_custom)){ echo 'style="display: none"'; } ?>>&#8674; <input id="esr_from_email_address_custom" name="esr_from_email_address_custom" class="element text" style="width: 44%" value="<?php echo $esr_from_email_address_custom; ?>" type="text"></span>

									<label class="description" for="esr_subject">Email Subject</label>
									<input id="esr_subject" name="esr_subject" class="element text large" value="<?php echo $esr_subject; ?>" type="text">

									<label class="description" for="esr_content">Email Content <img class="helpmsg" src="images/icons/68_red.png" style="vertical-align: top" title="This field accept HTML codes."/></label>
									<textarea class="element textarea medium" name="esr_content" id="esl_content"><?php echo $esr_content; ?></textarea>

									<span style="display: block;margin-top: 10px">
									<input type="checkbox" value="1" <?php if(!empty($esr_plain_text)){ echo 'checked="checked"'; } ?> class="checkbox" id="esr_plain_text" name="esr_plain_text" style="margin-left: 0px">
									<label for="esr_plain_text" >Send Email in Plain Text Format</label>
									</span>

									<span class="ns_temp_vars"><img style="vertical-align: middle" src="images/icons/70_red2.png"> You can insert <a href="#" class="tempvar_link">template variables</a> into the email template.</span>
								</div>
								<?php if(!empty($email_fields)){ ?>
								<div class="ns_box_more_switcher" <?php if(empty($esr_enable)){ echo 'style="display: none"'; } ?>>
									<a id="more_option_confirmation_email" href="#">more options</a>
									<img id="confirmation_email_img_arrow" style="vertical-align: top;margin-left: 3px" src="images/icons/38_rightred_16.png">
								</div>
								<?php } ?>
							</div>
						</li>		
					</ul>
					<input type="hidden" id="form_id" name="form_id" value="<?php echo $form_id; ?>">
					</form>


					<div id="dialog-template-variable" title="Template Variable Lookup" class="buttons" style="display: none"> 
						<form id="dialog-template-variable-form" class="dialog-form" style="padding-left: 10px;padding-bottom: 10px">				
							<ul>
								<li>
									<div>
										
										<div style="margin: 0px 0 10px 0">
											Template variable &#8674; <span id="tempvar_value">{form_name}</span>
										</div>

										<select class="select full" id="dialog-template-variable-input" style="margin-bottom: 10px" name="dialog-template-variable-input">
											<optgroup label="Form Fields">
											<?php 
												foreach ($columns_label as $element_name => $element_label) {
													echo "<option value=\"{$element_name}\">{$element_label}</option>\n";
												}
											?>
											</optgroup>
											<?php
												if(!empty($complex_field_columns_label)){
													echo "<optgroup label=\"Complex Form Fields (Detailed)\">";
													foreach ($complex_field_columns_label as $element_name => $element_label) {
														echo "<option value=\"{$element_name}\">{$element_label}</option>\n";
													}
													echo "</optgroup>";
												}
											?>
											<optgroup label="Entry Information">
												<option value="entry_no">Entry No.</option>
												<option value="date_created">Date Created</option>
												<option value="ip_address">IP Address</option>
												<option value="form_id">Form ID</option>
												<option value="form_name" selected="selected">Form Name</option>
												<option value="entry_data">Complete Entry</option>
											</optgroup>
										</select>
										
										<div>
											<div id="tempvar_help_content" style="display: none">
												<h5>What is template variable?</h5>
												<p>A template variable is a special identifier that is automatically replaced with data typed in by a user.</p>

												<h5>How can I use it?</h5>
												<p>Simply copy the variable name (including curly braces) into your email template.</p>

												<h5>Where can I use it?</h5>
												<p>You can insert template variable into Email Subject and Email Content.</p>
											</div>
											<div id="tempvar_help_trigger" style="overflow: auto"><a href="">more info</a></div>
										</div>
									</div> 
								</li>
							</ul>
							
							
						</form>
					</div>
				</div> <!-- /end of content_body -->	
			
			</div><!-- /.post -->
		</div><!-- /#content -->

 
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
<script type="text/javascript" src="js/jquery-ui/ui/jquery.effects.core.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.effects.pulsate.js"></script>
<script type="text/javascript" src="js/jquery.tools.min.js"></script>
<script type="text/javascript" src="js/notification_settings.js"></script>
EOT;

	require('includes/footer.php'); 
?>