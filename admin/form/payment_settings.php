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
	
	$form_id = (int) trim($_REQUEST['id']);
	
	$dbh = mf_connect_db();
	$mf_settings = mf_get_settings($dbh);
	
	//load the payment settings property from ap_forms table
	$payment_properties = new stdClass();
	
	$query 	= "select 
					 form_name,
					 payment_enable_merchant,
					 payment_merchant_type,
					 ifnull(payment_paypal_email,'') payment_paypal_email,
					 payment_paypal_language,
					 payment_currency,
					 payment_show_total,
					 payment_total_location,
					 payment_enable_recurring,
					 payment_recurring_cycle,
					 payment_recurring_unit,
					 payment_price_type,
					 payment_price_amount,
					 payment_price_name
			     from 
			     	 ".MF_TABLE_PREFIX."forms 
			    where 
			    	 form_id = ?";
	$params = array($form_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
	
	if(!empty($row)){
		
		$form_name = htmlspecialchars($row['form_name']);
		
		$payment_properties->form_id = $form_id;
		$payment_properties->enable_merchant = (int) $row['payment_enable_merchant'];
		$payment_properties->merchant_type 	 = $row['payment_merchant_type'];
		$payment_properties->paypal_email 	 = $row['payment_paypal_email'];
		$payment_properties->paypal_language = $row['payment_paypal_language'];
		
		$payment_properties->currency 		  = $row['payment_currency'];
		$payment_properties->show_total 	  = (int) $row['payment_show_total'];
		$payment_properties->total_location   = $row['payment_total_location'];
		$payment_properties->enable_recurring = (int) $row['payment_enable_recurring'];
		$payment_properties->recurring_cycle  = (int) $row['payment_recurring_cycle'];
		$payment_properties->recurring_unit   = $row['payment_recurring_unit'];
		
		$payment_properties->price_type   = $row['payment_price_type'];
		$payment_properties->price_amount = (float) $row['payment_price_amount'];
		$payment_properties->price_name   = $row['payment_price_name'];
		
		if(empty($payment_properties->price_name)){
			$payment_properties->price_name = $form_name.' Fee';
		}
		
		//payment_enable_merchant has 3 possible values:
		// -1 : disabled
		//  0 : disabled
		//  1 : enabled
		//the -1 is the default for all newly created form
		//once the user save the payment settings page, the only possible values are 0 or 1
		//we put -1 as an option, so that when the first time user load the payment settings page, it will enable the payment setting by default
		if($payment_properties->enable_merchant === -1){
			$payment_properties->enable_merchant = 1;
		}
	}
	
	$json_payment_properties = json_encode($payment_properties);
	$jquery_data_code = "\$('#ps_main_list').data('payment_properties',{$json_payment_properties});\n";
	
	//when certain fields (checkboxes, radio buttons, dropdown) has an option being deleted
	//the related ap_element_prices records are not being updated
	//thus we need to do a cleanup here, before loading the prices
	$query = "select element_id,option_id from ".MF_TABLE_PREFIX."element_options where form_id = ? and live = 0";
	$params = array($form_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	$deleted_element_options = array();
	$i=0;
	while($row = mf_do_fetch_result($sth)){
		$deleted_element_options[$i]['element_id'] = $row['element_id'];
		$deleted_element_options[$i]['option_id']  = $row['option_id'];
		$i++;
	}

	foreach ($deleted_element_options as $value) {
		$query = "delete from ".MF_TABLE_PREFIX."element_prices where form_id=? and element_id=? and option_id=?";
	
		$params = array($form_id,$value['element_id'],$value['option_id']);
		mf_do_query($query,$params,$dbh);
	}

	//get price-ready fields for this form and put them into array
	//price-ready fields are the following types: price, checkboxes, multiple choice, dropdown
	$query = "select 
					element_title,
					element_id,
					element_type 
				from 
					".MF_TABLE_PREFIX."form_elements 
			   where 
			   		form_id=? and 
			   		element_status=1 and 
			   		element_is_private=0 and 
			   		element_type in('radio','money','select','checkbox') 
		    order by 
		    		element_title asc";
	$params = array($form_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	$price_field_array = array();
	$price_field_options_array = array();
	$price_field_options_lookup = array();
	
	while($row = mf_do_fetch_result($sth)){
		$element_id = $row['element_id'];
		$price_field_array[$element_id]['element_title'] = htmlspecialchars($row['element_title']);
		$price_field_array[$element_id]['element_type'] = $row['element_type'];
		
		if($row['element_type'] != 'money'){
			//get the choices for the field
			$sub_query = "select 
								option_id,
								`option` 
							from 
								".MF_TABLE_PREFIX."element_options 
						   where 
						   		form_id=? and 
						   		live=1 and 
						   		element_id=? 
						order by 
								`position` asc";
			$sub_params = array($form_id,$element_id);
			$sub_sth = mf_do_query($sub_query,$sub_params,$dbh);
			$i=0;
			while($sub_row = mf_do_fetch_result($sub_sth)){
				$price_field_options_array[$element_id][$i]['option_id'] = $sub_row['option_id'];
				$price_field_options_array[$element_id][$i]['option'] = htmlspecialchars($sub_row['option']);
				$price_field_options_lookup[$element_id][$sub_row['option_id']] = htmlspecialchars($sub_row['option']);
				$i++;
			}
			
		}
	}
	
	if(!empty($price_field_options_array)){
		$json_price_field_options = json_encode($price_field_options_array);
		$jquery_data_code .= "\$('#ps_box_define_prices').data('field_options',{$json_price_field_options});\n";
	}
	
	//load existing data from ap_element_prices table
	$query = "select element_id,option_id,`price` from ".MF_TABLE_PREFIX."element_prices where form_id=? order by element_id,option_id asc";
	$params = array($form_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	$current_price_settings = array();
	
	while($row = mf_do_fetch_result($sth)){
		$element_id = (int) $row['element_id'];
		$option_id = (int) $row['option_id'];
		$current_price_settings[$element_id][$option_id]  = $row['price'];
	}
	
	
	//prepare the dom data for the prices fields
	foreach ($current_price_settings as $element_id=>$values){
		if($price_field_array[$element_id]['element_type'] == 'money'){ //if this is 'price' field
			$price_values = new stdClass();
			
			$price_values->element_id = $element_id;
			$price_values->option_id  = 0;
			$price_values->price      = 0;
			$price_values->element_type = 'price';
			
			$json_price_values = json_encode($price_values);
			$jquery_data_code .= "\$('#liprice_{$element_id}').data('field_price_properties',{$json_price_values});\n";
		}else{
			
			
			$price_values_array = array();
			foreach ($values as $option_id=>$price){
				$price_values = new stdClass();
				
				$price_values->element_id = $element_id;
				$price_values->option_id  = $option_id;
				$price_values->price      = $price;
				$price_values->element_type = 'multi';
				
				$price_values_array[$option_id] = $price_values;
			}
			
			$json_price_values = json_encode($price_values_array);
			$jquery_data_code .= "\$('#liprice_{$element_id}').data('field_price_properties',{$json_price_values});\n";
		}	
	}
	
	
	$current_nav_tab = 'manage_forms';
	require('includes/header.php'); 
	
?>


		<div id="content" class="full">
			<div class="post payment_settings">
				<div class="content_header">
					<div class="content_header_title">
						<div style="float: left">
							<h2><?php echo "<a class=\"breadcrumb\" href='manage_forms.php?id={$form_id}'>".$form_name.'</a>'; ?> <img src="images/icons/resultset_next.gif" /> Payment Settings</h2>
							<p>Configure payment options for your form</p>
						</div>	
						<div style="float: right;margin-right: 5px">
								<a href="#" id="button_save_payment" class="bb_button bb_small bb_green">
									Save Settings
								</a>
						</div>
						<div style="clear: both; height: 1px"></div>
					</div>
					
				</div>
				<div class="content_body">
					
					<ul id="ps_main_list">
						<li>
							<div id="ps_box_merchant_settings" class="ps_box_main gradient_blue">
								<div class="ps_box_meta">
									<h1>1.</h1>
									<h6>Merchant Settings</h6>
								</div>
								<div class="ps_box_content">
									<span>	
										<input id="ps_enable_merchant" class="checkbox" value="" type="checkbox" style="margin-left: 0px" <?php if(!empty($payment_properties->enable_merchant)){ echo 'checked="checked"'; } ?>>
										<label class="choice" for="ps_enable_merchant">Enable Merchant</label> 
										<img class="helpmsg" src="images/icons/68_blue.png" style="vertical-align: top" title="Disabling this option will turn off the payment functionality of your form."/>
									</span>
									
									<label class="description" for="ps_select_merchant" style="margin-top: 10px">
										Select a Merchant 
										<img class="helpmsg" src="images/icons/68_blue.png" style="vertical-align: top" title="A merchant will process transactions on your form and authorize the payments."/>
									</label>
									<select class="select medium" id="ps_select_merchant" autocomplete="off">
										<option value="paypal_standard" selected="selected">PayPal Standard</option>
										<option value="soon">-------------</option>
										<option value="soon">More Coming Soon!</option>
									</select>
									<div id="ps_paypal_options">
										<label class="description" for="ps_paypal_email">PayPal Email Address <span class="required">*</span> <img class="helpmsg" src="images/icons/68_blue.png" style="vertical-align: top" title="This is the email address associated with your PayPal account."/></label>
										<input id="ps_paypal_email" name="ps_paypal_email" class="element text large" value="<?php echo htmlspecialchars($payment_properties->paypal_email); ?>" type="text">
					
										<label class="description" for="ps_paypal_language">Language <img class="helpmsg" src="images/icons/68_blue.png" style="vertical-align: top" title="Select the language to be displayed on PayPal pages."/></label>
										<select id="ps_paypal_language" name="ps_paypal_language" class="select large" style="width: 93%">
											<option value="US" <?php if($payment_properties->paypal_language == 'US'){ echo 'selected="selected"'; } ?>>English (American)</option>
											<option value="GB" <?php if($payment_properties->paypal_language == 'GB'){ echo 'selected="selected"'; } ?>>English (Great Britain)</option>
											<option value="AU" <?php if($payment_properties->paypal_language == 'AU'){ echo 'selected="selected"'; } ?>>English (Australian)</option>
											<option value="CN" <?php if($payment_properties->paypal_language == 'CN'){ echo 'selected="selected"'; } ?>>Chinese</option>
											<option value="DK" <?php if($payment_properties->paypal_language == 'DK'){ echo 'selected="selected"'; } ?>>Danish</option>
											<option value="FR" <?php if($payment_properties->paypal_language == 'FR'){ echo 'selected="selected"'; } ?>>French</option>
											<option value="DE" <?php if($payment_properties->paypal_language == 'DE'){ echo 'selected="selected"'; } ?>>German</option>
											<option value="IT" <?php if($payment_properties->paypal_language == 'IT'){ echo 'selected="selected"'; } ?>>Italian</option>
											<option value="NO" <?php if($payment_properties->paypal_language == 'NO'){ echo 'selected="selected"'; } ?>>Norwegian</option>
											<option value="PT" <?php if($payment_properties->paypal_language == 'PT'){ echo 'selected="selected"'; } ?>>Portuguese</option>
											<option value="CH" <?php if($payment_properties->paypal_language == 'CH'){ echo 'selected="selected"'; } ?>>Swiss-German</option>
											<option value="ES" <?php if($payment_properties->paypal_language == 'ES'){ echo 'selected="selected"'; } ?>>Spanish</option>
										</select>				
									</div>
								</div>
							</div>
						</li>
						<li class="ps_arrow" <?php if($payment_properties->enable_merchant === 0){ echo 'style="display: none;"'; } ?>><img src="images/icons/33_orange.png" /></li>
						<li <?php if($payment_properties->enable_merchant === 0){ echo 'style="display: none;"'; } ?>>
							<div id="ps_box_payment_options" class="ps_box_main gradient_red">
								<div class="ps_box_meta">
									<h1>2.</h1>
									<h6>Payment Options</h6>
								</div>
								<div class="ps_box_content">
									<label class="description" for="ps_currency" style="margin-top: 2px">
									Currency
									<img class="helpmsg" src="images/icons/68_red.png" style="vertical-align: top" title="Select the currency you would like to use to accept the payment from your clients."/>
									</label>
									<select class="select large" id="ps_currency" name="ps_currency" autocomplete="off">
										<option value="USD" <?php if($payment_properties->currency == 'USD'){ echo 'selected="selected"'; } ?>>&#36; - U.S. Dollar</option>
										<option value="EUR" <?php if($payment_properties->currency == 'EUR'){ echo 'selected="selected"'; } ?>>&#8364; - Euro</option>
										<option value="GBP" <?php if($payment_properties->currency == 'GBP'){ echo 'selected="selected"'; } ?>>&#163; - Pound Sterling</option>
										<option value="AUD" <?php if($payment_properties->currency == 'AUD'){ echo 'selected="selected"'; } ?>>A&#36; - Australian Dollar</option>
										<option value="CAD" <?php if($payment_properties->currency == 'CAD'){ echo 'selected="selected"'; } ?>>C&#36; - Canadian Dollar</option>
										
										<option value="JPY" <?php if($payment_properties->currency == 'JPY'){ echo 'selected="selected"'; } ?>>&#165; - Japanese Yen</option>
										<option value="THB" <?php if($payment_properties->currency == 'THB'){ echo 'selected="selected"'; } ?>>&#3647; - Thai Baht</option>
										<option value="HUF" <?php if($payment_properties->currency == 'HUF'){ echo 'selected="selected"'; } ?>>&#70;&#116; - Hungarian Forint</option>
										<option value="CHF" <?php if($payment_properties->currency == 'CHF'){ echo 'selected="selected"'; } ?>>CHF - Swiss Francs</option>
										<option value="CZK" <?php if($payment_properties->currency == 'CZK'){ echo 'selected="selected"'; } ?>>&#75;&#269; - Czech Koruna</option>
										<option value="SEK" <?php if($payment_properties->currency == 'SEK'){ echo 'selected="selected"'; } ?>>kr - Swedish Krona</option>
										<option value="DKK" <?php if($payment_properties->currency == 'DKK'){ echo 'selected="selected"'; } ?>>kr - Danish Krone</option>
										<option value="PHP" <?php if($payment_properties->currency == 'PHP'){ echo 'selected="selected"'; } ?>>&#36; - Philippine Peso</option>
										<option value="MYR" <?php if($payment_properties->currency == 'MYR'){ echo 'selected="selected"'; } ?>>RM - Malaysian Ringgit</option>
										<option value="PLN" <?php if($payment_properties->currency == 'PLN'){ echo 'selected="selected"'; } ?>>&#122;&#322; - Polish Złoty</option>
										<option value="BRL" <?php if($payment_properties->currency == 'BRL'){ echo 'selected="selected"'; } ?>>R&#36; - Brazilian Real</option>
										<option value="HKD" <?php if($payment_properties->currency == 'HKD'){ echo 'selected="selected"'; } ?>>HK&#36; - Hong Kong Dollar</option>
										<option value="MXN" <?php if($payment_properties->currency == 'MXN'){ echo 'selected="selected"'; } ?>>Mex&#36; - Mexican Peso</option>
										<option value="TWD" <?php if($payment_properties->currency == 'TWD'){ echo 'selected="selected"'; } ?>>NT&#36; - Taiwan New Dollar</option>
										<option value="TRY" <?php if($payment_properties->currency == 'TRY'){ echo 'selected="selected"'; } ?>>TL - Turkish Lira</option>
									</select>
									
									<div id="ps_optional_settings">
										<label class="description" style="margin-bottom: 15px">
										Optional Settings
										</label>
									
										<input id="ps_show_total_amount" <?php if(!empty($payment_properties->show_total)){ echo 'checked="checked"'; } ?> class="checkbox" value="" type="checkbox" style="margin-left: 0px">
										<label class="choice" for="ps_show_total_amount">Show Total Amount</label>
										<img class="helpmsg" src="images/icons/68_red.png" style="vertical-align: top" title="Shows the total amount of the payment to the client as they are filling out the form. You can also select the location of the total amount placement within the form."/>
										<div id="ps_show_total_location_div" <?php if(empty($payment_properties->show_total)){ echo 'style="display: none"'; } ?>>
												Display at 
												<select class="select medium" id="ps_show_total_location" name="ps_show_total_location" autocomplete="off">
													<option <?php if($payment_properties->total_location == 'top'){ echo 'selected="selected"'; } ?> id="ps_location_top" value="top">top</option>
													<option <?php if($payment_properties->total_location == 'bottom'){ echo 'selected="selected"'; } ?> id="ps_location_bottom" value="bottom">bottom</option>
													<option <?php if($payment_properties->total_location == 'top-bottom'){ echo 'selected="selected"'; } ?> id="ps_location_top_bottom" value="top-bottom">top and bottom</option>
													<option <?php if($payment_properties->total_location == 'review'){ echo 'selected="selected"'; } ?> id="ps_location_review_page" value="review">review page</option>
													<option <?php if($payment_properties->total_location == 'all'){ echo 'selected="selected"'; } ?> id="ps_location_all" value="all">all locations</option>
												</select>
										</div>
										
										<div style="clear: both;margin-top: 10px"></div>
										
										<input id="ps_enable_recurring" <?php if(!empty($payment_properties->enable_recurring)){ echo 'checked="checked"'; } ?> class="checkbox" value="" type="checkbox" style="margin-left: 0px;">
										<label class="choice" for="ps_enable_recurring">Enable Recurring Payments</label>
										<img class="helpmsg" src="images/icons/68_red.png" style="vertical-align: top" title="If enabled, your clients will be charged automatically for every period of time, until they cancel the subscription from their PayPal account."/>
										<div id="ps_recurring_div" <?php if(empty($payment_properties->enable_recurring)){ echo 'style="display: none"'; } ?>>
											<label class="description" style="margin-top: 5px">Charge Payment Every:</label>
											<select id="ps_recurring_cycle">
												<?php 
													for($i=1;$i<=10;$i++){
														if($i == $payment_properties->recurring_cycle){
															echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
														}else{
															echo '<option value="'.$i.'">'.$i.'</option>';	
														}
													}
												?>
											</select>
											<select id="ps_recurring_cycle_unit">
												<option value="day" <?php if($payment_properties->recurring_unit == 'day'){ echo 'selected="selected"'; } ?>>Day(s)</option>
												<option value="week" <?php if($payment_properties->recurring_unit == 'week'){ echo 'selected="selected"'; } ?>>Week(s)</option>
												<option value="month" <?php if($payment_properties->recurring_unit == 'month'){ echo 'selected="selected"'; } ?>>Month(s)</option>
												<option value="year" <?php if($payment_properties->recurring_unit == 'year'){ echo 'selected="selected"'; } ?>>Year(s)</option>
											</select>
						
										</div>
									
									</div>
								</div>
							</div>
						</li>
						<li class="ps_arrow" <?php if($payment_properties->enable_merchant === 0){ echo 'style="display: none;"'; } ?>><img src="images/icons/33_orange.png" /></li>
						<li <?php if($payment_properties->enable_merchant === 0){ echo 'style="display: none;"'; } ?>>
							<div id="ps_box_define_prices" class="ps_box_main gradient_green">
								<div class="ps_box_meta">
									<h1>3.</h1>
									<h6>Define Prices</h6>
								</div>
								<div class="ps_box_content">
									<div id="ps_box_price_selector">
										<select id="ps_pricing_type">
												<option value="fixed" <?php if($payment_properties->price_type == 'fixed'){ echo 'selected="selected"'; } ?>>Fixed Amount</option>
												<option value="variable" <?php if($payment_properties->price_type == 'variable'){ echo 'selected="selected"'; } ?>>Variable Amount</option>
										</select>
									</div>
									<div id="ps_box_price_fields">
										<div id="ps_box_price_fixed_amount_div" <?php if($payment_properties->price_type == 'variable'){ echo 'style="display: none;"'; } ?>>
											
											<label class="description" for="ps_price_amount" style="margin-top: 0px">Price Amount <span class="required">*</span> <img class="helpmsg" src="images/icons/68_green.png" style="vertical-align: top" title="Enter the amount to be charged to your client."/></label>
											<span class="symbol">$</span><span><input id="ps_price_amount" name="ps_price_amount" class="element text medium" value="<?php echo $payment_properties->price_amount; ?>" type="text"></span>
											
											<label class="description" for="ps_price_name" style="margin-top: 15px">Price Name <span class="required">*</span> <img class="helpmsg" src="images/icons/68_green.png" style="vertical-align: top" title="Enter a descriptive name for the price. This will be displayed into PayPal pages and the receipt email being sent to your client."/></label>
											<input id="ps_price_name" name="ps_price_name" class="element text large" value="<?php echo $payment_properties->price_name; ?>" type="text">
											
											<p><img class="helpmsg" src="images/icons/70_green2.png" style="vertical-align: top" /> Fixed Amount - Your clients will be charged a fixed amount per form submission.</p>
										</div>
										<div id="ps_box_price_variable_amount_div" <?php if($payment_properties->price_type == 'fixed'){ echo 'style="display: none;"'; } ?>>
											
											<?php if(!empty($price_field_array)){ ?>
											
											<label class="description" for="ps_select_field_prices" style="margin-top: 2px">
											Add a Field To Set Prices
											<img class="helpmsg" src="images/icons/68_green.png" style="vertical-align: top" title="Add one or more field from this list to set the prices. A field can have one or more prices, depends on the type. When your client select any of the field you've set here, he will be charged the amount being assigned for the selected field. Supported fields: Checkboxes, Drop Down, Multiple Choice, Price"/>
											</label>
											<select class="select large" id="ps_select_field_prices" name="ps_select_field_prices" autocomplete="off">
												<option value=""></option>
												<?php 
													foreach ($price_field_array as $element_id=>$data){
														
														if($data['element_type'] == 'radio'){
															$element_type = 'Multiple Choice';
														}else if($data['element_type'] == 'money'){
															$element_type = 'Price';
														}else if($data['element_type'] == 'select'){
															$element_type = 'Drop Down';
														}else if($data['element_type'] == 'checkbox'){
															$element_type = 'Checkboxes';
														}
														
														$price_field_array[$element_id]['complete_title'] = $data['element_title'].' ('.$element_type.')';
														$price_field_array[$element_id]['element_type']   = $data['element_type'];
														
														if(empty($current_price_settings[$element_id])){
															echo "<option value=\"{$element_id}\">{$data['element_title']} ({$element_type})</option>";
														}
													}
												?>
											</select>
											<ul id="ps_field_assignment">
												<?php 
													
													if(!empty($current_price_settings)){
														
														//get the currency symbol first
														switch($payment_properties->currency){
															case 'USD' : $currency_symbol = '&#36;';break;
															case 'EUR' : $currency_symbol = '&#8364;';break;
															case 'GBP' : $currency_symbol = '&#163;';break;
															case 'AUD' : $currency_symbol = 'A&#36;';break;
															case 'CAD' : $currency_symbol = 'C&#36;';break;
															case 'JPY' : $currency_symbol = '&#165;';break;
															case 'THB' : $currency_symbol = '&#3647;';break;
															case 'HUF' : $currency_symbol = '&#70;&#116;';break;
															case 'CHF' : $currency_symbol = 'CHF';break;
															case 'CZK' : $currency_symbol = '&#75;&#269;';break;
															case 'SEK' : $currency_symbol = 'kr';break;
															case 'DKK' : $currency_symbol = 'kr';break;
															case 'PHP' : $currency_symbol = '&#36;';break;
															case 'MYR' : $currency_symbol = 'RM';break;
															case 'PLN' : $currency_symbol = '&#122;&#322;';break;
															case 'BRL' : $currency_symbol = 'R&#36;';break;
															case 'HKD' : $currency_symbol = 'HK&#36;';break;
															case 'MXN' : $currency_symbol = 'Mex&#36;';break;
															case 'TWD' : $currency_symbol = 'NT&#36;';break;
															case 'TRY' : $currency_symbol = 'TL';break;
														}
														
														foreach ($current_price_settings as $element_id=>$data){
															$liprice_markup = '';
															
															if($price_field_array[$element_id]['element_type'] == 'money'){ //if this is price field
																$liprice_markup = '<li id="liprice_'.$element_id.'">'.
																	'<table width="100%" cellspacing="0">'.
																		'<thead>'.
																			'<tr><td>'.
																				'<strong>'.$price_field_array[$element_id]['complete_title'].'</strong>'.
																				'<a href="#" id="deleteliprice_'.$element_id.'" class="delete_liprice"><img src="images/icons/53.png"></a>'.
																			'</td></tr>'.
																		'</thead>'.
																		'<tbody>'.
																			'<tr><td class="ps_td_field_label">Amount will be entered by the client.</td></tr>'.
																		'</tbody>'.
																	'</table>'.
																	'</li>';
															}else{
																
																$liprice_markup = '<li style="" id="liprice_'.$element_id.'">'.
																	'<table width="100%" cellspacing="0">'.
																		'<thead>'.
																			'<tr><td colspan="2">'.
																				'<strong>'.$price_field_array[$element_id]['complete_title'].'</strong>'.
																				'<a href="#" id="deleteliprice_'.$element_id.'" class="delete_liprice"><img src="images/icons/53.png"></a>'.
																			'</td></tr>'.
																		'</thead>'.
																		'<tbody>';
																		
																foreach ($data as $option_id=>$price){
																	$liprice_markup .=	'<tr>'.
																				'<td class="ps_td_field_label">'.$price_field_options_lookup[$element_id][$option_id].'</td>'.
																				'<td class="ps_td_field_price">'.
																					'<span class="ps_td_currency">'.$currency_symbol.'</span>'.
																					'<input type="text" class="element text large" value="'.$price.'" id="price_'.$element_id.'_'.$option_id.'">'.
																				'</td>'.
																			'</tr>';
																}
																			
																$liprice_markup .= '</tbody></table></li>';
															}
															
															echo $liprice_markup;
														}
													}
												?>
											</ul>
											
											<?php } else { ?>
												<div id="ps_no_price_fields">
													<h6>No Available Fields Found</h6>
													<p>To set variable amount prices, you need to add one or more of the following field types into your form: <span style="font-weight: 700">Checkboxes, Drop Down, Multiple Choice, Price.</span></p>
												</div>
											<?php } ?>
											
											<p><img class="helpmsg" src="images/icons/70_green2.png" style="vertical-align: top" /> Variable Amount - Your clients will be charged a certain amount depends on their selection.</p>
										</div>
									</div>
								</div>
							</div>
						</li>
								
					</ul>
					
					
				</div> <!-- /end of content_body -->	
			
			</div><!-- /.post -->
		</div><!-- /#content -->

 
<?php
	$footer_data =<<<EOT
<script type="text/javascript">
	$(function(){
		{$jquery_data_code}		
    });
</script>
<script type="text/javascript" src="js/jquery.tools.min.js"></script>
<script type="text/javascript" src="js/payment_settings.js"></script>
EOT;

	require('includes/footer.php'); 
?>