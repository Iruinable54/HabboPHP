<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/
	global $mf_lang;
	
	//simple name and extended name
	$mf_lang['name_first']			=	'First';
	$mf_lang['name_middle']			=	'Middle';
	$mf_lang['name_last']			=	'Last';
	$mf_lang['name_title']			=	'Title';
	$mf_lang['name_suffix']			=	'Suffix';
	
	//address
	$mf_lang['address_street']		=	'Street Address';
	$mf_lang['address_street2']		=	'Address Line 2';
	$mf_lang['address_city']		=	'City';
	$mf_lang['address_state']		=	'State / Province / Region';
	$mf_lang['address_zip']			=	'Postal / Zip Code';
	$mf_lang['address_country']		=	'Country';

	//captcha
	$mf_lang['captcha_required']			=	'This field is required. Please enter the letters shown in the image.';
	$mf_lang['captcha_mismatch']			=	'The letters in the image do not match. Try again.';
	$mf_lang['captcha_text_mismatch'] 		=	'Incorrect answer. Please try again.';
	$mf_lang['captcha_error']				=	'Error while processing, please try again.';
	$mf_lang['captcha_simple_image_title']	= 'Type the letters you see in the image below.';
	$mf_lang['captcha_simple_text_title']	= 'Spam Protection. Please answer this simple question.';
	
	//date
	$mf_lang['date_dd']				=	'DD';
	$mf_lang['date_mm']				=	'MM';
	$mf_lang['date_yyyy']			=	'YYYY';
	
	//price
	$mf_lang['price_dollar_main']	=	'Dollars';
	$mf_lang['price_dollar_sub']	=	'Cents';
	$mf_lang['price_euro_main']		=	'Euros';
	$mf_lang['price_euro_sub']		=	'Cents';
	$mf_lang['price_pound_main']	=	'Pounds';
	$mf_lang['price_pound_sub']		=	'Pence';
	$mf_lang['price_yen']			=	'Yen';
	$mf_lang['price_baht_main']		=	'Baht';
	$mf_lang['price_baht_sub']		=	'Satang';
	$mf_lang['price_rupees_main']	=	'Rupees';
	$mf_lang['price_rupees_sub']	=	'Paise';
	$mf_lang['price_rand_main']		=	'Rand';
	$mf_lang['price_rand_sub']		=	'Cents';
	$mf_lang['price_forint_main']	=	'Forint';
	$mf_lang['price_forint_sub']	=	'Filler';
	$mf_lang['price_franc_main']	=	'Francs';
	$mf_lang['price_franc_sub']		=	'Rappen';
	$mf_lang['price_koruna_main']	=	'Koruna';
	$mf_lang['price_koruna_sub']	=	'Haléřů';
	$mf_lang['price_krona_main']	=	'Kronor';
	$mf_lang['price_krona_sub']		=	'Ore';
	$mf_lang['price_pesos_main']	=	'Pesos';
	$mf_lang['price_pesos_sub']		=	'Cents';
	$mf_lang['price_ringgit_main']	=	'Ringgit';
	$mf_lang['price_ringgit_sub']	=	'Sen';
	$mf_lang['price_zloty_main']	=	'Złoty';
	$mf_lang['price_zloty_sub']		=	'Grosz';
	$mf_lang['price_riyals_main']	=	'Riyals';
	$mf_lang['price_riyals_sub']	=	'Halalah';
	
	//time
	$mf_lang['time_hh']				=	'HH';
	$mf_lang['time_mm']				=	'MM';
	$mf_lang['time_ss']				=	'SS';
	
	//error message
	$mf_lang['error_title']			=	'There was a problem with your submission.';
	$mf_lang['error_desc']			=	'Errors have been <strong>highlighted</strong> below.';
	
	//form buttons
	$mf_lang['submit_button']		=	'Submit';
	$mf_lang['continue_button']		=	'Continue';
	$mf_lang['back_button']			=	'Previous';
	
	//form status
	$mf_lang['form_inactive']		=	'This form is currently inactive.';
	$mf_lang['form_limited']		=   'Sorry, but this form is no longer accepting any entries.';
	
	//form password
	$mf_lang['form_pass_title']		=	'This form is password protected.';
	$mf_lang['form_pass_desc']		=	'Please enter your password.';
	$mf_lang['form_pass_invalid']	=	'Invalid Password!';
	
	//form review
	$mf_lang['review_title']		=	'Review Your Entry';
	$mf_lang['review_message']		=	'Please review your entry below. Click Submit button to finish.';
	
	//validation message 
	$mf_lang['val_required'] 		=	'This field is required. Please enter a value.';
	$mf_lang['val_required_file'] 	=	'This field is required. Please upload a file.';
	$mf_lang['val_unique'] 			=	'This field requires a unique entry and this value has already been used.';
	$mf_lang['val_integer'] 		=	'This field must be an integer.';
	$mf_lang['val_float'] 			=	'This field must be a float.';
	$mf_lang['val_numeric'] 		=	'This field must be a number.';
	$mf_lang['val_email'] 			=	'This field is not in the correct email format.';
	$mf_lang['val_website'] 		=	'This field is not in the correct website address format.';
	$mf_lang['val_username'] 		=	'This field may only consist of a-z 0-9 and underscores.';
	$mf_lang['val_equal'] 			=	'%s must match.';
	$mf_lang['val_date'] 			=	'This field is not in the correct date format.';
	$mf_lang['val_date_range'] 		=	'This date field must be between %s and %s.';
	$mf_lang['val_date_min'] 		=	'This date field must be greater than or equal to %s.';
	$mf_lang['val_date_max'] 		=	'This date field must be less than or equal to %s.';
	$mf_lang['val_date_na'] 		=	'This date is not available for selection.';
	$mf_lang['val_time'] 			=	'This field is not in the correct time format.';
	$mf_lang['val_phone'] 			=	'Please enter a valid phone number.';
	$mf_lang['val_filetype']		=	'The filetype you are attempting to upload is not allowed.';
	
	//fields on excel/csv
	$mf_lang['export_num']			=	'No.';
	$mf_lang['date_created']		=	'Date Created';
	$mf_lang['date_updated']		=	'Date Updated';
	$mf_lang['ip_address']			=	'IP Address';

	//form resume
	$mf_lang['resume_email_subject']		= 'Your submission to %s has been saved';
	$mf_lang['resume_email_content'] 		= 'Thank you! Your submission to <b>%s</b> has been saved.<br /><br />You can resume the form at any time by clicking the link below:<br /><a href="%s">%s</a><br /><br /><br /><br /><b>IMPORTANT:</b><br />Your submission is considered incomplete until you resume the form and press the submit button.';							

	$mf_lang['resume_success_title']   		= 'Your progress has been saved.';
	$mf_lang['resume_success_content'] 		= 'Please copy the link below and save it in a safe place:<br/>%s<br/><br/>You can resume the form at any time by going to the above link.';

	$mf_lang['resume_checkbox_title']		= 'Save my progress and resume later';
	$mf_lang['resume_email_input_label']	= 'Enter Your Email Address';
	$mf_lang['resume_submit_button_text']	= 'Save form and resume later';
	$mf_lang['resume_guideline']			= 'A special link to resume the form will be sent to your email address.';

	//range validation
	$mf_lang['range_type_digit']			= 'digits';
	$mf_lang['range_type_chars'] 			= 'characters';
	$mf_lang['range_type_words'] 			= 'words';

	$mf_lang['range_min']  					= 'Minimum of %s required.'; 
	$mf_lang['range_min_entered']   		= 'Currently Entered: %s.';

	$mf_lang['range_max']					= 'Maximum of %s allowed.';
	$mf_lang['range_max_entered']   		= 'Currently Entered: %s.';

	$mf_lang['range_min_max'] 				= 'Must be between %s and %s.';
	$mf_lang['range_min_max_entered'] 		= 'Currently Entered: %s.';

	$mf_lang['range_number_min']	 		= 'Must be a number greater than or equal to %s.';
	$mf_lang['range_number_max']	 		= 'Must be a number less than or equal to %s.';
	$mf_lang['range_number_min_max'] 		= 'Must be a number between %s and %s';

	//file uploads
	$mf_lang['file_queue_limited'] 			= 'This field is limited to maximum %s files.';
	$mf_lang['file_upload_max']	   			= 'Error. Maximum %sMB allowed.';
	$mf_lang['file_type_limited']  			= 'Error. This file type is not allowed.';
	$mf_lang['file_error_upload']  			= 'Error! Unable to upload';
	$mf_lang['file_attach']		  			= 'Attach Files';

	//payment total
	$mf_lang['payment_total'] 				= 'Total';	

	//multipage
	$mf_lang['page_title']					= 'Page %s of %s';






	/** Functions **/

	//this function set the global language variable ($mf_language) to the selected language
	function mf_set_language($target_language){
		global $mf_lang;

		if(empty($target_language)){
			$target_language = 'english';
		}
		$target_language = strtolower($target_language);

		if($target_language == 'english'){
			//simple name and extended name
			$languages['name_first']			= 'First';
			$languages['name_middle']			= 'Middle';
			$languages['name_last']				= 'Last';
			$languages['name_title']			= 'Title';
			$languages['name_suffix']			= 'Suffix';
			
			//address
			$languages['address_street']		= 'Street Address';
			$languages['address_street2']		= 'Address Line 2';
			$languages['address_city']			= 'City';
			$languages['address_state']			= 'State / Province / Region';
			$languages['address_zip']			= 'Postal / Zip Code';
			$languages['address_country']		= 'Country';

			//captcha
			$languages['captcha_required']				= 'This field is required. Please enter the letters shown in the image.';
			$languages['captcha_mismatch']				= 'The letters in the image do not match. Try again.';
			$languages['captcha_text_mismatch'] 		= 'Incorrect answer. Please try again.';
			$languages['captcha_error']					= 'Error while processing, please try again.';
			$languages['captcha_simple_image_title']	= 'Type the letters you see in the image below.';
			$languages['captcha_simple_text_title']		= 'Spam Protection. Please answer this simple question.';
			
			//date
			$languages['date_dd']				= 'DD';
			$languages['date_mm']				= 'MM';
			$languages['date_yyyy']				= 'YYYY';
			
			//price
			$languages['price_dollar_main']		=	'Dollars';
			$languages['price_dollar_sub']		=	'Cents';
			$languages['price_euro_main']		=	'Euros';
			$languages['price_euro_sub']		=	'Cents';
			$languages['price_pound_main']		=	'Pounds';
			$languages['price_pound_sub']		=	'Pence';
			$languages['price_yen']				=	'Yen';
			$languages['price_baht_main']		=	'Baht';
			$languages['price_baht_sub']		=	'Satang';
			$languages['price_rupees_main']		=	'Rupees';
			$languages['price_rupees_sub']		=	'Paise';
			$languages['price_rand_main']		=	'Rand';
			$languages['price_rand_sub']		=	'Cents';
			$languages['price_forint_main']		=	'Forint';
			$languages['price_forint_sub']		=	'Filler';
			$languages['price_franc_main']		=	'Francs';
			$languages['price_franc_sub']		=	'Rappen';
			$languages['price_koruna_main']		=	'Koruna';
			$languages['price_koruna_sub']		=	'Haléřů';
			$languages['price_krona_main']		=	'Kronor';
			$languages['price_krona_sub']		=	'Ore';
			$languages['price_pesos_main']		=	'Pesos';
			$languages['price_pesos_sub']		=	'Cents';
			$languages['price_ringgit_main']	=	'Ringgit';
			$languages['price_ringgit_sub']		=	'Sen';
			$languages['price_zloty_main']		=	'Złoty';
			$languages['price_zloty_sub']		=	'Grosz';
			$languages['price_riyals_main']		=	'Riyals';
			$languages['price_riyals_sub']		=	'Halalah';
			
			//time
			$languages['time_hh']				=	'HH';
			$languages['time_mm']				=	'MM';
			$languages['time_ss']				=	'SS';
			
			//error message
			$languages['error_title']			=	'There was a problem with your submission.';
			$languages['error_desc']			=	'Errors have been <strong>highlighted</strong> below.';
			
			//form buttons
			$languages['submit_button']			=	'Submit';
			$languages['continue_button']		=	'Continue';
			$languages['back_button']			=	'Previous';
			
			//form status
			$languages['form_inactive']			=	'This form is currently inactive.';
			$languages['form_limited']			=   'Sorry, but this form is no longer accepting any entries.';
			
			//form password
			$languages['form_pass_title']		=	'This form is password protected.';
			$languages['form_pass_desc']		=	'Please enter your password.';
			$languages['form_pass_invalid']		=	'Invalid Password!';
			
			//form review
			$languages['review_title']			=	'Review Your Entry';
			$languages['review_message']		=	'Please review your entry below. Click Submit button to finish.';
			
			//validation message 
			$languages['val_required'] 			=	'This field is required. Please enter a value.';
			$languages['val_required_file'] 	=	'This field is required. Please upload a file.';
			$languages['val_unique'] 			=	'This field requires a unique entry and this value has already been used.';
			$languages['val_integer'] 			=	'This field must be an integer.';
			$languages['val_float'] 			=	'This field must be a float.';
			$languages['val_numeric'] 			=	'This field must be a number.';
			$languages['val_email'] 			=	'This field is not in the correct email format.';
			$languages['val_website'] 			=	'This field is not in the correct website address format.';
			$languages['val_username'] 			=	'This field may only consist of a-z 0-9 and underscores.';
			$languages['val_equal'] 			=	'%s must match.';
			$languages['val_date'] 				=	'This field is not in the correct date format.';
			$languages['val_date_range'] 		=	'This date field must be between %s and %s.';
			$languages['val_date_min'] 			=	'This date field must be greater than or equal to %s.';
			$languages['val_date_max'] 			=	'This date field must be less than or equal to %s.';
			$languages['val_date_na'] 			=	'This date is not available for selection.';
			$languages['val_time'] 				=	'This field is not in the correct time format.';
			$languages['val_phone'] 			=	'Please enter a valid phone number.';
			$languages['val_filetype']			=	'The filetype you are attempting to upload is not allowed.';
			
			//fields on excel/csv
			$languages['export_num']			=	'No.';
			$languages['date_created']			=	'Date Created';
			$languages['date_updated']			=	'Date Updated';
			$languages['ip_address']			=	'IP Address';

			//form resume
			$languages['resume_email_subject']		= 'Your submission to %s has been saved';
			$languages['resume_email_content'] 		= 'Thank you! Your submission to <b>%s</b> has been saved.<br /><br />You can resume the form at any time by clicking the link below:<br /><a href="%s">%s</a><br /><br /><br /><br /><b>IMPORTANT:</b><br />Your submission is considered incomplete until you resume the form and press the submit button.';							

			$languages['resume_success_title']   	= 'Your progress has been saved.';
			$languages['resume_success_content'] 	= 'Please copy the link below and save it in a safe place:<br/>%s<br/><br/>You can resume the form at any time by going to the above link.';

			$languages['resume_checkbox_title']		= 'Save my progress and resume later';
			$languages['resume_email_input_label']	= 'Enter Your Email Address';
			$languages['resume_submit_button_text']	= 'Save form and resume later';
			$languages['resume_guideline']			= 'A special link to resume the form will be sent to your email address.';

			//range validation
			$languages['range_type_digit']			= 'digits';
			$languages['range_type_chars'] 			= 'characters';
			$languages['range_type_words'] 			= 'words';

			$languages['range_min']  				= 'Minimum of %s required.'; 
			$languages['range_min_entered']   		= 'Currently Entered: %s.';

			$languages['range_max']					= 'Maximum of %s allowed.';
			$languages['range_max_entered']   		= 'Currently Entered: %s.';

			$languages['range_min_max'] 			= 'Must be between %s and %s.';
			$languages['range_min_max_entered'] 	= 'Currently Entered: %s.';

			$languages['range_number_min']	 		= 'Must be a number greater than or equal to %s.';
			$languages['range_number_max']	 		= 'Must be a number less than or equal to %s.';
			$languages['range_number_min_max'] 		= 'Must be a number between %s and %s';

			//file uploads
			$languages['file_queue_limited'] 		= 'This field is limited to maximum %s files.';
			$languages['file_upload_max']	   		= 'Error. Maximum %sMB allowed.';
			$languages['file_type_limited']  		= 'Error. This file type is not allowed.';
			$languages['file_error_upload']  		= 'Error! Unable to upload';
			$languages['file_attach']		  		= 'Attach Files';

			//payment total
			$languages['payment_total'] 			= 'Total';	

			//multipage
			$languages['page_title']				= 'Page %s of %s';
		}else if($target_language == 'dutch'){
			//simple name and extended name
			$languages['name_first']			= 'Eerste';
			$languages['name_middle']			= 'Midden';
			$languages['name_last']				= 'Laatste';
			$languages['name_title']			= 'Titel';
			$languages['name_suffix']			= 'Achtervoegsel';
			
			//address
			$languages['address_street']		= 'Adres en huisnummer';
			$languages['address_street2']		= 'Adresregel 2';
			$languages['address_city']			= 'Woonplaats';
			$languages['address_state']			= 'Provincie';
			$languages['address_zip']			= 'Postcode';
			$languages['address_country']		= 'Land';

			//captcha
			$languages['captcha_required']				= 'Dit veld is verplicht. Vul de letters in die u ziet in de afbeelding';
			$languages['captcha_mismatch']				= 'De letters komen niet overeen. Probeer het opnieuw.';
			$languages['captcha_text_mismatch'] 		= 'Verkeerde antwoord. Probeer het opnieuw.';
			$languages['captcha_error']					= 'Fout bij het verwerken, probeer het opnieuw.';
			$languages['captcha_simple_image_title']	= 'Typ de letters in die u in onderstaande afbeelding ziet.';
			$languages['captcha_simple_text_title']		= 'Spam bescherming. Beantwoord deze eenvoudige vraag.';
			
			//date
			$languages['date_dd']				= 'DD';
			$languages['date_mm']				= 'MM';
			$languages['date_yyyy']				= 'JJJJ';
			
			//price
			$languages['price_dollar_main']		=	'Dollars';
			$languages['price_dollar_sub']		=	'Cents';
			$languages['price_euro_main']		=	'Euros';
			$languages['price_euro_sub']		=	'Cents';
			$languages['price_pound_main']		=	'Pounds';
			$languages['price_pound_sub']		=	'Pence';
			$languages['price_yen']				=	'Yen';
			$languages['price_baht_main']		=	'Baht';
			$languages['price_baht_sub']		=	'Satang';
			$languages['price_rupees_main']		=	'Rupees';
			$languages['price_rupees_sub']		=	'Paise';
			$languages['price_rand_main']		=	'Rand';
			$languages['price_rand_sub']		=	'Cents';
			$languages['price_forint_main']		=	'Forint';
			$languages['price_forint_sub']		=	'Filler';
			$languages['price_franc_main']		=	'Francs';
			$languages['price_franc_sub']		=	'Rappen';
			$languages['price_koruna_main']		=	'Koruna';
			$languages['price_koruna_sub']		=	'Haléřů';
			$languages['price_krona_main']		=	'Kronor';
			$languages['price_krona_sub']		=	'Ore';
			$languages['price_pesos_main']		=	'Pesos';
			$languages['price_pesos_sub']		=	'Cents';
			$languages['price_ringgit_main']	=	'Ringgit';
			$languages['price_ringgit_sub']		=	'Sen';
			$languages['price_zloty_main']		=	'Złoty';
			$languages['price_zloty_sub']		=	'Grosz';
			$languages['price_riyals_main']		=	'Riyals';
			$languages['price_riyals_sub']		=	'Halalah';
			
			//time
			$languages['time_hh']				=	'UU';
			$languages['time_mm']				=	'MM';
			$languages['time_ss']				=	'SS';
			
			//error message
			$languages['error_title']			=	'Er is een probleem met uw inzending.';
			$languages['error_desc']			=	'Fouten zijn hieronder <strong>gemarkeerd</strong>.';
			
			//form buttons
			$languages['submit_button']			=	'Bevestig';
			$languages['continue_button']		=	'Doorgaan';
			$languages['back_button']			=	'Vorige';
			
			//form status
			$languages['form_inactive']			=	'Dit formulier is op dit moment niet actief.';
			$languages['form_limited']			=   'Sorry, maar dit formulier kan niet langer inzendingen verwerken.';
			
			//form password
			$languages['form_pass_title']		=	'Dit formulier is beveiligd met een wachtwoord.';
			$languages['form_pass_desc']		=	'Vul uw wachtwoord in.';
			$languages['form_pass_invalid']		=	'Ongeldig wachtwoord!';
			
			//form review
			$languages['review_title']			=	'Herzie Uw Inzending';
			$languages['review_message']		=	'Gelieve de onderstaande inzending te herzien. Klik op Bevestig om te voltooien.';
			
			//validation message 
			$languages['val_required'] 			=	'Dit veld is verplicht. Geef een waarde in.';
			$languages['val_required_file'] 	=	'Dit veld is verplicht. Upload een bestand.';
			$languages['val_unique'] 			=	'Dit veld vereist een unieke invoer en deze waarde is al gebruikt.';
			$languages['val_integer'] 			=	'Dit veld een geheel getal zijn.';
			$languages['val_float'] 			=	'Dit veld moet een float zijn.';
			$languages['val_numeric'] 			=	'Dit veld moet een getal zijn.';
			$languages['val_email'] 			=	'Dit veld heeft niet het juiste e-mail formaat.';
			$languages['val_website'] 			=	'Dit veld heeft niet het juiste website adresformaat.';
			$languages['val_username'] 			=	'Dit veld mag alleen bestaan uit a-z, 0-9 en underscores.';
			$languages['val_equal'] 			=	'%s moeten overeenkomen.';
			$languages['val_date'] 				=	'Dit veld heeft niet het juiste datum formaat.';
			$languages['val_date_range'] 		=	'Dit datumveld moet tussen %s en %s zijn.';
			$languages['val_date_min'] 			=	'Dit datumveld moet groter zijn dan of gelijk aan %s zijn.';
			$languages['val_date_max'] 			=	'Dit datumveld moet kleiner zijn dan of gelijk aan %s zijn.';
			$languages['val_date_na'] 			=	'Deze datum kan niet worden geselecteerd.';
			$languages['val_time'] 				=	'Dit veld heeft niet het juiste tijd formaat.';
			$languages['val_phone'] 			=	'Vul een geldig telefoonnummer in.';
			$languages['val_filetype']			=	'Het bestandstype dat u probeert te uploaden is niet toegestaan.';
			
			//fields on excel/csv
			$languages['export_num']			=	'Nee.';
			$languages['date_created']			=	'Aanmaakdatum';
			$languages['date_updated']			=	'Datum bijgewerkt';
			$languages['ip_address']			=	'IP-adres';

			//form resume
			$languages['resume_email_subject']		= 'Uw inschrijving via het %s formulier is opgeslagen.';
			$languages['resume_email_content'] 		= 'Dank u wel! Uw inschrijving via <b>%s</b> is opgeslagen.<br /><br />U kunt het formulier te allen tijde opnieuw opvragen door te klikken op de onderstaande link:<br /><a href="%s">%s</a><br /><br /><br /><br /><b>BELANGRIJK:</b><br />Uw inschrijving wordt beschouwd als onvolledig totdat u het formulier opnieuw opvraagt en op bevestigen klikt.';							

			$languages['resume_success_title']   	= 'Uw vooruitgang is opgeslagen.';
			$languages['resume_success_content'] 	= 'Kopieer de onderstaande link en sla het op op een veilige plaats:<br/>%s<br/><br/>U kunt het formulier te allen tijde opnieuw opvragen door naar de bovenstaande link te gaan.';

			$languages['resume_checkbox_title']		= 'Bewaar mijn vooruitgang en hervat later';
			$languages['resume_email_input_label']	= 'Vul Uw E-mailadres In';
			$languages['resume_submit_button_text']	= 'Sla formulier op en hervat later';
			$languages['resume_guideline']			= 'Een speciale link om het formulier opnieuw op te vragen zal naar uw e-mailadres worden verzonden';

			//range validation
			$languages['range_type_digit']			= 'cijfers';
			$languages['range_type_chars'] 			= 'tekens';
			$languages['range_type_words'] 			= 'woorden';

			$languages['range_min']  				= 'Minimaal %s nodig zijn.'; 
			$languages['range_min_entered']   		= 'Op dit moment ingevuld: %s.';

			$languages['range_max']					= 'Maximaal %s toegestaan.';
			$languages['range_max_entered']   		= 'Op dit moment ingevuld: %s.';

			$languages['range_min_max'] 			= 'Moet tussen %s en %s hebben.';
			$languages['range_min_max_entered'] 	= 'Op dit moment ingevuld: %s.';

			$languages['range_number_min']	 		= 'Moet een getal groter dan of gelijk aan %s zijn.';
			$languages['range_number_max']	 		= 'Moet een getal kleiner dan of gelijk aan %s zijn.';
			$languages['range_number_min_max'] 		= 'Moet een getal tussen %s en %s zijn.';

			//file uploads
			$languages['file_queue_limited'] 		= 'Dit veld is beperkt tot maximaal %s bestanden.';
			$languages['file_upload_max']	   		= 'Fout. Maximaal %s MB toegestaan.';
			$languages['file_type_limited']  		= 'Fout. Dit bestandstype is niet toegestaan.';
			$languages['file_error_upload']  		= 'Fout! Niet in staat om te uploaden';
			$languages['file_attach']		  		= 'Bevestig Bestanden';

			//payment total
			$languages['payment_total'] 			= 'Totaal';	

			//multipage
			$languages['page_title']				= 'Pagina %s of %s';
		}else if($target_language == 'french'){
			//simple name and extended name
			$languages['name_first']			= 'Prénom';
			$languages['name_middle']			= 'Autres prénoms';
			$languages['name_last']				= 'Nom de famille';
			$languages['name_title']			= 'Titre';
			$languages['name_suffix']			= 'Suffixe';
			
			//address
			$languages['address_street']		= 'Nom de rue';
			$languages['address_street2']		= 'Complément d\'adress';
			$languages['address_city']			= 'Ville';
			$languages['address_state']			= 'Département';
			$languages['address_zip']			= 'Code postal';
			$languages['address_country']		= 'Pays';

			//captcha
			$languages['captcha_required']				= 'Ce champ est obligatoire. Veuillez entrer les lettres que vous voyez sur l\'image.';
			$languages['captcha_mismatch']				= 'Ce que vous n\'avez tapé ne correspond pas à l\'image. Veuillez recommencer.';
			$languages['captcha_text_mismatch'] 		= 'Mauvaise réponse. Veuillez réessayer.';
			$languages['captcha_error']					= 'Une erreur est survenue, veuillez réessayer.';
			$languages['captcha_simple_image_title']	= 'Entrez les lettres telles que vous les voyez dans l\'image ci-dessus.';
			$languages['captcha_simple_text_title']		= 'Protection contre les spams. Veuillez répondre à cette question simple.';
			
			//date
			$languages['date_dd']				= 'JJ';
			$languages['date_mm']				= 'MM';
			$languages['date_yyyy']				= 'AAAA';
			
			//price
			$languages['price_dollar_main']		=	'Dollars';
			$languages['price_dollar_sub']		=	'Cents';
			$languages['price_euro_main']		=	'Euros';
			$languages['price_euro_sub']		=	'Cents';
			$languages['price_pound_main']		=	'Pounds';
			$languages['price_pound_sub']		=	'Pence';
			$languages['price_yen']				=	'Yen';
			$languages['price_baht_main']		=	'Baht';
			$languages['price_baht_sub']		=	'Satang';
			$languages['price_rupees_main']		=	'Rupees';
			$languages['price_rupees_sub']		=	'Paise';
			$languages['price_rand_main']		=	'Rand';
			$languages['price_rand_sub']		=	'Cents';
			$languages['price_forint_main']		=	'Forint';
			$languages['price_forint_sub']		=	'Filler';
			$languages['price_franc_main']		=	'Francs';
			$languages['price_franc_sub']		=	'Rappen';
			$languages['price_koruna_main']		=	'Koruna';
			$languages['price_koruna_sub']		=	'Haléřů';
			$languages['price_krona_main']		=	'Kronor';
			$languages['price_krona_sub']		=	'Ore';
			$languages['price_pesos_main']		=	'Pesos';
			$languages['price_pesos_sub']		=	'Cents';
			$languages['price_ringgit_main']	=	'Ringgit';
			$languages['price_ringgit_sub']		=	'Sen';
			$languages['price_zloty_main']		=	'Złoty';
			$languages['price_zloty_sub']		=	'Grosz';
			$languages['price_riyals_main']		=	'Riyals';
			$languages['price_riyals_sub']		=	'Halalah';
			
			//time
			$languages['time_hh']				=	'HH';
			$languages['time_mm']				=	'MM';
			$languages['time_ss']				=	'SS';
			
			//error message
			$languages['error_title']			=	'Votre application a rencontré un problème.';
			$languages['error_desc']			=	'Les erreurs ont été <strong>surlignées</strong> ci-dessous.';
			
			//form buttons
			$languages['submit_button']			=	'Envoyer';
			$languages['continue_button']		=	'Continuer';
			$languages['back_button']			=	'Précédent';
			
			//form status
			$languages['form_inactive']			=	'Ce formulaire est actuellement inactif.';
			$languages['form_limited']			=   'Désolé, mais ce formulaire n\'est désormais plus accepté.';
			
			//form password
			$languages['form_pass_title']		=	'Ce formulaire est protégé par un mot de passe.';
			$languages['form_pass_desc']		=	'Veuillez entrer votre mot de passe.';
			$languages['form_pass_invalid']		=	'Mot de passe invalide!';
			
			//form review
			$languages['review_title']			=	'Commenter Votre Billet';
			$languages['review_message']		=	'Veuillez relire votre billet. Cliquer sur envoyer pour achever le processus.';
			
			//validation message 
			$languages['val_required'] 			=	'Ce champ est obligatoire. Veuillez entrer une valeur.';
			$languages['val_required_file'] 	=	'Ce champ est obligatoire. Veuillez envoyer un fichier.';
			$languages['val_unique'] 			=	'Ce champ nécessite une unique entrée et cette valeur a déjà été utilisée.';
			$languages['val_integer'] 			=	'Ce champ doit être un intégré.';
			$languages['val_float'] 			=	'Ce champ doit être flottant.';
			$languages['val_numeric'] 			=	'Ce champ doit être un nombre.';
			$languages['val_email'] 			=	'Ce champ n\'est pas dans le bon format e-mail.';
			$languages['val_website'] 			=	'Ce champ ne contient pas d\'adresse email au format correct.';
			$languages['val_username'] 			=	'Ce champ ne peut contenir que des lettres et chiffres, a-z, 0-9, et _.';
			$languages['val_equal'] 			=	'%s doivent correspondre.';
			$languages['val_date'] 				=	'Ce champ n\'est pas au bon format de date.';
			$languages['val_date_range'] 		=	'Ce champ doit rester entre %s et %s.';
			$languages['val_date_min'] 			=	'Ce champ doit être supérieur ou égal à %s.';
			$languages['val_date_max'] 			=	'Ce champ doit être inférieur ou égal à %s.';
			$languages['val_date_na'] 			=	'Cette date n\'est pas disponible pour la sélection.';
			$languages['val_time'] 				=	'Ce champ n\'est pas au bon format de temps.';
			$languages['val_phone'] 			=	'Veuillez entrer un numéro de téléphone valide.';
			$languages['val_filetype']			=	'Le type de fichier que vous tentez de télécharger n\'est pas supporté.';
			
			//fields on excel/csv
			$languages['export_num']			=	'Non.';
			$languages['date_created']			=	'Date de création';
			$languages['date_updated']			=	'Date de téléchargement';
			$languages['ip_address']			=	'Adresse IP';

			//form resume
			$languages['resume_email_subject']		= 'Votre application pour le formulaire %s a été sauvegardée.';
			$languages['resume_email_content'] 		= 'Merci! Votre soumission à <b>%s</b> a été acceptée. <br /><br />Vous pouvez fermer le formulaire à n\'importe quel moment en cliquant ci-dessous:<br /><a href="%s">%s</a><br /><br /><br /><br /><b>IMPORTANT:</b><br />Votre application est considérée comme incomplète tant que vous n\'avez pas validé en cliquant sur le bouton d\'envoi.';							

			$languages['resume_success_title']   	= 'Votre progression a été sauvegardée.';
			$languages['resume_success_content'] 	= 'Veuillez copier le lien ci-dessous et le sauvegarder dans un endroit sûr:<br/>%s<br/><br/>Vous pouvez fermer le formulaire à n\'importe quel moment en cliquant ci-dessus.';

			$languages['resume_checkbox_title']		= 'Sauvegarder ma progression et revenir plus tard';
			$languages['resume_email_input_label']	= 'Entrez Votre Adresse Email';
			$languages['resume_submit_button_text']	= 'Sauvegarder le formulaire et revenir plus tard';
			$languages['resume_guideline']			= 'Un lien spécial pour revenir au formulaire vous sera envoyé par email.';

			//range validation
			$languages['range_type_digit']			= 'chiffres';
			$languages['range_type_chars'] 			= 'caractères';
			$languages['range_type_words'] 			= 'mots';

			$languages['range_min']  				= '%s minimum nécessaires.'; 
			$languages['range_min_entered']   		= 'Actuellement entrés: %s.';

			$languages['range_max']					= '%s maximum autorisés.';
			$languages['range_max_entered']   		= 'Actuellement entrés: %s.';

			$languages['range_min_max'] 			= 'Le nombre doit être compris entre %s et %s.';
			$languages['range_min_max_entered'] 	= 'Actuellement entrés: %s.';

			$languages['range_number_min']	 		= 'Le nombre doit être supérieur ou égal à %s.';
			$languages['range_number_max']	 		= 'Le nombre doit être inférieur ou égal à %s.';
			$languages['range_number_min_max'] 		= 'Le nombre doit être compris entre %s et %s';

			//file uploads
			$languages['file_queue_limited'] 		= 'Ce champ est limité à %s fichiers.';
			$languages['file_upload_max']	   		= 'Erreur. %sMB Maximum autorisés.';
			$languages['file_type_limited']  		= 'Erreur. Ce type de fichier n\'est pas pris en charge.';
			$languages['file_error_upload']  		= 'Erreur! Téléchargement impossible.';
			$languages['file_attach']		  		= 'Joindre les fichiers';

			//payment total
			$languages['payment_total'] 			= 'Total';	

			//multipage
			$languages['page_title']				= 'Page %s sur %s';
		}else if($target_language == 'german'){
			//simple name and extended name
			$languages['name_first']			= 'Vorname';
			$languages['name_middle']			= '2. Vorname';
			$languages['name_last']				= 'Nachname';
			$languages['name_title']			= 'Titel';
			$languages['name_suffix']			= 'Zusatz';
			
			//address
			$languages['address_street']		= 'Straße, Hausnr.';
			$languages['address_street2']		= '2. Adresszeile';
			$languages['address_city']			= 'Stadt';
			$languages['address_state']			= 'Bundesland / Kanton';
			$languages['address_zip']			= 'PLZ';
			$languages['address_country']		= 'Land';

			//captcha
			$languages['captcha_required']				= 'Dieses Feld ist erforderlich. Geben Sie bitte die im Bild gezeigten Buchstaben ein.';
			$languages['captcha_mismatch']				= 'Die Buchstaben im Bild stimmen nicht überein. Versuchen Sie es erneut.';
			$languages['captcha_text_mismatch'] 		= 'Ungültige Antwort. Versuchen Sie es erneut.';
			$languages['captcha_error']					= 'Fehler in der Verarbeitung, versuchen Sie es bitte erneut.';
			$languages['captcha_simple_image_title']	= 'Geben Sie die Buchstaben aus dem Bild unten ein.';
			$languages['captcha_simple_text_title']		= 'Spamschutz. Beantworten Sie bitte diese einfache Frage.';
			
			//date
			$languages['date_dd']				= 'TT';
			$languages['date_mm']				= 'MM';
			$languages['date_yyyy']				= 'JJJJ';
			
			//price
			$languages['price_dollar_main']		=	'Dollars';
			$languages['price_dollar_sub']		=	'Cents';
			$languages['price_euro_main']		=	'Euros';
			$languages['price_euro_sub']		=	'Cents';
			$languages['price_pound_main']		=	'Pounds';
			$languages['price_pound_sub']		=	'Pence';
			$languages['price_yen']				=	'Yen';
			$languages['price_baht_main']		=	'Baht';
			$languages['price_baht_sub']		=	'Satang';
			$languages['price_rupees_main']		=	'Rupees';
			$languages['price_rupees_sub']		=	'Paise';
			$languages['price_rand_main']		=	'Rand';
			$languages['price_rand_sub']		=	'Cents';
			$languages['price_forint_main']		=	'Forint';
			$languages['price_forint_sub']		=	'Filler';
			$languages['price_franc_main']		=	'Francs';
			$languages['price_franc_sub']		=	'Rappen';
			$languages['price_koruna_main']		=	'Koruna';
			$languages['price_koruna_sub']		=	'Haléřů';
			$languages['price_krona_main']		=	'Kronor';
			$languages['price_krona_sub']		=	'Ore';
			$languages['price_pesos_main']		=	'Pesos';
			$languages['price_pesos_sub']		=	'Cents';
			$languages['price_ringgit_main']	=	'Ringgit';
			$languages['price_ringgit_sub']		=	'Sen';
			$languages['price_zloty_main']		=	'Złoty';
			$languages['price_zloty_sub']		=	'Grosz';
			$languages['price_riyals_main']		=	'Riyals';
			$languages['price_riyals_sub']		=	'Halalah';
			
			//time
			$languages['time_hh']				=	'HH';
			$languages['time_mm']				=	'MM';
			$languages['time_ss']				=	'SS';
			
			//error message
			$languages['error_title']			=	'Mit Ihren Eingaben gab es ein Problem.';
			$languages['error_desc']			=	'Fehler sind unten <strong>hervorgehoben</strong>.';
			
			//form buttons
			$languages['submit_button']			=	'Absenden';
			$languages['continue_button']		=	'Weiter';
			$languages['back_button']			=	'Zurück';
			
			//form status
			$languages['form_inactive']			=	'Dieses Formular ist im Moment nicht aktiv.';
			$languages['form_limited']			=   'Dieses Formular nimmt leider keine weiteren Eingaben mehr an.';
			
			//form password
			$languages['form_pass_title']		=	'Dieses Formular ist passwortgeschützt.';
			$languages['form_pass_desc']		=	'Geben Sie bitte Ihr Passwort ein.';
			$languages['form_pass_invalid']		=	'Ungültiges Passwort!';
			
			//form review
			$languages['review_title']			=	'Überprüfen Sie Ihre Eingabe.';
			$languages['review_message']		=	'Überprüfen Sie bitte Ihre Eingabe unten. Klicken Sie zum Beenden auf "Absenden".';
			
			//validation message 
			$languages['val_required'] 			=	'Dieses Feld ist erforderlich. Geben Sie bitte einen Wert ein.';
			$languages['val_required_file'] 	=	'Dieses Feld ist erforderlich. Laden Sie bitte eine Datei hoch.';
			$languages['val_unique'] 			=	'Dieses Feld verlangt eine eindeutige Eingabe, und dieser Wert wurde bereits verwendet.';
			$languages['val_integer'] 			=	'Dieses Feld ist zwingend eine Ganzzahl.';
			$languages['val_float'] 			=	'Dieses Feld ist zwingend eine Gleitkommazahl.';
			$languages['val_numeric'] 			=	'Dieses Feld ist zwingend eine Nummer.';
			$languages['val_email'] 			=	'Dieses Feld enthält kein gültiges Email-Format.';
			$languages['val_website'] 			=	'Dieses Feld enthält kein gültiges Adressformat einer Website.';
			$languages['val_username'] 			=	'Dieses Feld darf nur a-z, 0-9 und Unterstriche enthalten.';
			$languages['val_equal'] 			=	'%s müssen übereinstimmen.';
			$languages['val_date'] 				=	'Dieses Feld enthält kein gültiges Datumsformat.';
			$languages['val_date_range'] 		=	'Dieses Datumsfeld muss zwischen %s und %s liegen.';
			$languages['val_date_min'] 			=	'Dieses Datumsfeld muss größer oder gleich %s sein. ';
			$languages['val_date_max'] 			=	'Dieses Datumsfeld muss kleiner oder gleich %s sein.';
			$languages['val_date_na'] 			=	'Dieses Datum können Sie nicht wählen.';
			$languages['val_time'] 				=	'Dieses Feld enthält kein gültiges Zeit-Format.';
			$languages['val_phone'] 			=	'Geben Sie bitte eine gültige Telefonnummer ein.';
			$languages['val_filetype']			=	'Sie versuchen einen nicht unterstützten Dateityp hochzuladen.';
			
			//fields on excel/csv
			$languages['export_num']			=	'Nein.';
			$languages['date_created']			=	'Erstellungsdatum';
			$languages['date_updated']			=	'Änderungsdatum';
			$languages['ip_address']			=	'IP Adresse';

			//form resume
			$languages['resume_email_subject']		= 'Ihre Angaben zum %s Formular sind gesichert worden.';
			$languages['resume_email_content'] 		= 'Vielen Dank! Ihre Angaben zu <b>%s</b> sind gesichert worden.<br /><br />Sie können jederzeit das Formular wieder aufnehmen, indem Sie auf den Link unten klicken:<br /><a href="%s">%s</a><br /><br /><br /><br /><b>WICHTIG:</b><br />Ihre Angaben gelten als unvollständig, bis Sie das Formular wieder aufnehmen und "Absenden" klicken.';							

			$languages['resume_success_title']   	= 'Ihr aktueller Arbeitsstand ist gesichert worden.';
			$languages['resume_success_content'] 	= 'Kopieren Sie bitte den Link unten und bewahren Sie ihn an einem sicheren Ort auf:<br/>%s<br/><br/>Sie können jederzeit im Formular weiterarbeiten, indem Sie obigen Link aufrufen.';

			$languages['resume_checkbox_title']		= 'Meinen aktuellen Arbeitsstand sichern und später weitermachen';
			$languages['resume_email_input_label']	= 'Geben Sie Ihre Email-Adresse ein';
			$languages['resume_submit_button_text']	= 'Formular sichern und später weitermachen';
			$languages['resume_guideline']			= 'Einen speziellen Link zur Wiederaufnahme des Formulars erhalten Sie unter Ihrer Email-Adresse';

			//range validation
			$languages['range_type_digit']			= 'ziffern';
			$languages['range_type_chars'] 			= 'zeichen';
			$languages['range_type_words'] 			= 'wörter';

			$languages['range_min']  				= 'Mindestens %s erforderlich.'; 
			$languages['range_min_entered']   		= 'Soeben eingegeben: %s.';

			$languages['range_max']					= 'Höchstens %s erlaubt.';
			$languages['range_max_entered']   		= 'Soeben eingegeben: %s.';

			$languages['range_min_max'] 			= '%s bis %s erlaubt.';
			$languages['range_min_max_entered'] 	= 'Soeben eingegeben: %s.';

			$languages['range_number_min']	 		= 'Muss eine Zahl größer oder gleich %s sein.';
			$languages['range_number_max']	 		= 'Muss eine Zahl kleiner oder gleich %s sein.';
			$languages['range_number_min_max'] 		= 'Muss eine Zahl zwischen %s und %s sein.';

			//file uploads
			$languages['file_queue_limited'] 		= 'Dieses Feld ist auf höchstens %s Dateien begrenzt.';
			$languages['file_upload_max']	   		= 'Fehler: Höchstens %sMB erlaubt';
			$languages['file_type_limited']  		= 'Fehler: Dieser Dateityp wird nicht unterstützt';
			$languages['file_error_upload']  		= 'Fehler! Hochladen nicht möglich';
			$languages['file_attach']		  		= 'Dateien anfügen';

			//payment total
			$languages['payment_total'] 			= 'Gesamt';	

			//multipage
			$languages['page_title']				= 'Seite %s von %s';
		}else if($target_language == 'italian'){
			//simple name and extended name
			$languages['name_first']			= 'Nome';
			$languages['name_middle']			= 'Secondo nome';
			$languages['name_last']				= 'Cognome';
			$languages['name_title']			= 'Titolo';
			$languages['name_suffix']			= 'Suffisso';
			
			//address
			$languages['address_street']		= 'Indirizzo';
			$languages['address_street2']		= 'Indirizzo (continua)';
			$languages['address_city']			= 'Città';
			$languages['address_state']			= 'Stato / Provincia / Regione';
			$languages['address_zip']			= 'CAP';
			$languages['address_country']		= 'Paese';

			//captcha
			$languages['captcha_required']				= 'Questo campo è obbligatorio. Inserisci le lettere che vedi nell\'immagine.';
			$languages['captcha_mismatch']				= 'Le lettere nell\'immagine non corrispondono. Prova di nuovo.';
			$languages['captcha_text_mismatch'] 		= 'Risposta errata. Riprova.';
			$languages['captcha_error']					= 'Errore durante l\'elaborazione. Riprova.';
			$languages['captcha_simple_image_title']	= 'Digita le lettere che vedi nell\'immagine qui sotto.';
			$languages['captcha_simple_text_title']		= 'Protezione contro lo spam. Rispondi a questa semplice domanda.';
			
			//date
			$languages['date_dd']				= 'GG';
			$languages['date_mm']				= 'MM';
			$languages['date_yyyy']				= 'AAAA';
			
			//price
			$languages['price_dollar_main']		=	'Dollars';
			$languages['price_dollar_sub']		=	'Cents';
			$languages['price_euro_main']		=	'Euros';
			$languages['price_euro_sub']		=	'Cents';
			$languages['price_pound_main']		=	'Pounds';
			$languages['price_pound_sub']		=	'Pence';
			$languages['price_yen']				=	'Yen';
			$languages['price_baht_main']		=	'Baht';
			$languages['price_baht_sub']		=	'Satang';
			$languages['price_rupees_main']		=	'Rupees';
			$languages['price_rupees_sub']		=	'Paise';
			$languages['price_rand_main']		=	'Rand';
			$languages['price_rand_sub']		=	'Cents';
			$languages['price_forint_main']		=	'Forint';
			$languages['price_forint_sub']		=	'Filler';
			$languages['price_franc_main']		=	'Francs';
			$languages['price_franc_sub']		=	'Rappen';
			$languages['price_koruna_main']		=	'Koruna';
			$languages['price_koruna_sub']		=	'Haléřů';
			$languages['price_krona_main']		=	'Kronor';
			$languages['price_krona_sub']		=	'Ore';
			$languages['price_pesos_main']		=	'Pesos';
			$languages['price_pesos_sub']		=	'Cents';
			$languages['price_ringgit_main']	=	'Ringgit';
			$languages['price_ringgit_sub']		=	'Sen';
			$languages['price_zloty_main']		=	'Złoty';
			$languages['price_zloty_sub']		=	'Grosz';
			$languages['price_riyals_main']		=	'Riyals';
			$languages['price_riyals_sub']		=	'Halalah';
			
			//time
			$languages['time_hh']				=	'OO';
			$languages['time_mm']				=	'MM';
			$languages['time_ss']				=	'SS';
			
			//error message
			$languages['error_title']			=	'Si è verificato un problema durante l\'invio dei dati.';
			$languages['error_desc']			=	'Gli errori sono <strong>evidenziati</strong> qui di seguito.';
			
			//form buttons
			$languages['submit_button']			=	'Invia';
			$languages['continue_button']		=	'Continua';
			$languages['back_button']			=	'Indietro';
			
			//form status
			$languages['form_inactive']			=	'Questo modulo attualmente non è attivo.';
			$languages['form_limited']			=   'Siamo spiacenti, ma questo modulo non accetta più partecipazioni.';
			
			//form password
			$languages['form_pass_title']		=	'Questo modulo è protetto da password.';
			$languages['form_pass_desc']		=	'Inserisci la tua password.';
			$languages['form_pass_invalid']		=	'Password non valida!';
			
			//form review
			$languages['review_title']			=	'Controlla i dati inseriti';
			$languages['review_message']		=	'Rivedi la tua partecipazione qui di seguito. Fai clic su Invia per inoltrarla.';
			
			//validation message 
			$languages['val_required'] 			=	'Questo campo è obbligatorio. Inserisci un valore.';
			$languages['val_required_file'] 	=	'Questo campo è obbligatorio. Carica un file.';
			$languages['val_unique'] 			=	'Questo campo richiede una voce unica e questo valore è già stato utilizzato.';
			$languages['val_integer'] 			=	'Questo campo deve essere un numero intero.';
			$languages['val_float'] 			=	'Questo campo deve essere un numero decimale.';
			$languages['val_numeric'] 			=	'Questo campo deve essere un numero.';
			$languages['val_email'] 			=	'Questo campo non è nel formato corretto di indirizzo e-mail.';
			$languages['val_website'] 			=	'Questo campo non è nel formato corretto di indirizzo Web.';
			$languages['val_username'] 			=	'Questo campo può essere costituito solo da a-z 0-9 e trattini bassi.';
			$languages['val_equal'] 			=	'%s devono corrispondere.';
			$languages['val_date'] 				=	'Questo campo non è nel formato di data corretto.';
			$languages['val_date_range'] 		=	'Questo campo della data deve essere compreso tra %s e %s.';
			$languages['val_date_min'] 			=	'Questo campo della data deve essere maggiore o uguale a %s.';
			$languages['val_date_max'] 			=	'Questo campo della data deve essere minore o uguale a %s.';
			$languages['val_date_na'] 			=	'Questa data non è disponibile per la selezione.';
			$languages['val_time'] 				=	'Questo campo non è nel formato corretto dell\'ora.';
			$languages['val_phone'] 			=	'Inserisci un numero di telefono valido.';
			$languages['val_filetype']			=	'Il tipo di file che stai tentando di caricare non è consentito.';
			
			//fields on excel/csv
			$languages['export_num']			=	'No.';
			$languages['date_created']			=	'Data di creazione';
			$languages['date_updated']			=	'Data di aggiornamento';
			$languages['ip_address']			=	'Indirizzo IP';

			//form resume
			$languages['resume_email_subject']		= 'La tua partecipazione a %s è stata salvata.';
			$languages['resume_email_content'] 		= 'Grazie! La tua partecipazione a <b>%s</b> è stata salvata.<br /><br />Puoi riprendere il modulo in qualsiasi momento utilizzando il seguente link:<br /><a href="%s">%s</a><br /><br /><br /><br /><b>ATTENZIONE:</b><br />La tua partecipazione è considerata incompleta fino a quando non riprendi il modulo e premi il pulsante Invia.';							

			$languages['resume_success_title']   	= 'Il tuo progresso è stato salvato.';
			$languages['resume_success_content'] 	= 'Copiate i link qui sotto e salvalo in un luogo sicuro:<br/>%s<br/><br/>Puoi riprendere il modulo in qualsiasi momento accedendo al link qui sopra.';

			$languages['resume_checkbox_title']		= 'Salva il mio progresso e riprendi più tardi';
			$languages['resume_email_input_label']	= 'Inserisci il tuo indirizzo e-mail';
			$languages['resume_submit_button_text']	= 'Salva il modulo e riprendi più tardi';
			$languages['resume_guideline']			= 'Al tuo indirizzo e-mail verrà inviato un link speciale per riprendere il modulo';

			//range validation
			$languages['range_type_digit']			= 'cifre';
			$languages['range_type_chars'] 			= 'caratteri';
			$languages['range_type_words'] 			= 'parole';

			$languages['range_min']  				= 'Minimo %s richieste.'; 
			$languages['range_min_entered']   		= 'Attualmente inserite: %s.';

			$languages['range_max']					= 'Massimo %s consentiti.';
			$languages['range_max_entered']   		= 'Attualmente inserite: %s.';

			$languages['range_min_max'] 			= 'Deve essere compreso tra %s e %s.';
			$languages['range_min_max_entered'] 	= 'Attualmente inserite: %s.';

			$languages['range_number_min']	 		= 'Deve essere un numero maggiore o uguale a %s.';
			$languages['range_number_max']	 		= 'Deve essere un numero inferiore o uguale a %s.';
			$languages['range_number_min_max'] 		= 'Deve essere un numero compreso tra %s e %s.';

			//file uploads
			$languages['file_queue_limited'] 		= 'Questo campo è limitato ad un massimo di %s file.';
			$languages['file_upload_max']	   		= 'Errore. Massimo %s MB consentiti.';
			$languages['file_type_limited']  		= 'Errore. Questo tipo di file non è consentito.';
			$languages['file_error_upload']  		= 'Errore! Impossibile caricare';
			$languages['file_attach']		  		= 'Allega file';

			//payment total
			$languages['payment_total'] 			= 'Totale';	

			//multipage
			$languages['page_title']				= 'Pagina %s di %s';
		}else if($target_language == 'portuguese'){
			//simple name and extended name
			$languages['name_first']			= 'Primeiro';
			$languages['name_middle']			= 'Meio';
			$languages['name_last']				= 'Último';
			$languages['name_title']			= 'Título';
			$languages['name_suffix']			= 'Sufixo';
			
			//address
			$languages['address_street']		= 'Endereço';
			$languages['address_street2']		= 'Endereço linha 2';
			$languages['address_city']			= 'Cidade';
			$languages['address_state']			= 'Estado / Província / Região';
			$languages['address_zip']			= 'Caixa postal / Código postal';
			$languages['address_country']		= 'País';

			//captcha
			$languages['captcha_required']				= 'Esse campo é obrigatório. Por favor digite as letras mostradas na imagem';
			$languages['captcha_mismatch']				= 'As letras não batem com as da imagem. Tente novamente.';
			$languages['captcha_text_mismatch'] 		= 'Resposta incorreta. Por favor tente novamente.';
			$languages['captcha_error']					= 'Erro ao processar, por favor tente novamente.';
			$languages['captcha_simple_image_title']	= 'Digite as letras que vê na figura abaixo.';
			$languages['captcha_simple_text_title']		= 'Proteção anti-spam. Por favor responda a esta pergunta simples.';
			
			//date
			$languages['date_dd']				= 'DD';
			$languages['date_mm']				= 'MM';
			$languages['date_yyyy']				= 'AAAA';
			
			//price
			$languages['price_dollar_main']		=	'Dollars';
			$languages['price_dollar_sub']		=	'Cents';
			$languages['price_euro_main']		=	'Euros';
			$languages['price_euro_sub']		=	'Cents';
			$languages['price_pound_main']		=	'Pounds';
			$languages['price_pound_sub']		=	'Pence';
			$languages['price_yen']				=	'Yen';
			$languages['price_baht_main']		=	'Baht';
			$languages['price_baht_sub']		=	'Satang';
			$languages['price_rupees_main']		=	'Rupees';
			$languages['price_rupees_sub']		=	'Paise';
			$languages['price_rand_main']		=	'Rand';
			$languages['price_rand_sub']		=	'Cents';
			$languages['price_forint_main']		=	'Forint';
			$languages['price_forint_sub']		=	'Filler';
			$languages['price_franc_main']		=	'Francs';
			$languages['price_franc_sub']		=	'Rappen';
			$languages['price_koruna_main']		=	'Koruna';
			$languages['price_koruna_sub']		=	'Haléřů';
			$languages['price_krona_main']		=	'Kronor';
			$languages['price_krona_sub']		=	'Ore';
			$languages['price_pesos_main']		=	'Pesos';
			$languages['price_pesos_sub']		=	'Cents';
			$languages['price_ringgit_main']	=	'Ringgit';
			$languages['price_ringgit_sub']		=	'Sen';
			$languages['price_zloty_main']		=	'Złoty';
			$languages['price_zloty_sub']		=	'Grosz';
			$languages['price_riyals_main']		=	'Riyals';
			$languages['price_riyals_sub']		=	'Halalah';
			
			//time
			$languages['time_hh']				=	'HH';
			$languages['time_mm']				=	'MM';
			$languages['time_ss']				=	'SS';
			
			//error message
			$languages['error_title']			=	'Houve um problema com seu envio.';
			$languages['error_desc']			=	'Os erros foram <strong>destacados</strong> abaixo.';
			
			//form buttons
			$languages['submit_button']			=	'Enviar';
			$languages['continue_button']		=	'Continuar';
			$languages['back_button']			=	'Anterior';
			
			//form status
			$languages['form_inactive']			=	'Este formulário está inativo atualmente.';
			$languages['form_limited']			=   'Descupe, mas esse formolário não está aceitando nenhuma entrada mais.';
			
			//form password
			$languages['form_pass_title']		=	'Este formulário é protegido por senha.';
			$languages['form_pass_desc']		=	'Por favor digite sua senha.';
			$languages['form_pass_invalid']		=	'Senha inválida!';
			
			//form review
			$languages['review_title']			=	'Reveja o que digitou';
			$languages['review_message']		=	'Reveja o que digitou abaixo. Clique no botão enviar para finalizar.';
			
			//validation message 
			$languages['val_required'] 			=	'Este campo é necessário. Por favor digite um valor.';
			$languages['val_required_file'] 	=	'Este campo é necessári. Por favor envie um arquivo.';
			$languages['val_unique'] 			=	'Esse campo requer apenas uma entrada e esse valor já foi usado.';
			$languages['val_integer'] 			=	'Este campo deve receber um inteiro.';
			$languages['val_float'] 			=	'Este campo deve receber um decimal.';
			$languages['val_numeric'] 			=	'Este campo deve receber um número.';
			$languages['val_email'] 			=	'Este campo não está no formato de email correto.';
			$languages['val_website'] 			=	'Este campo não está no formato de site correto.';
			$languages['val_username'] 			=	'Este campo deve consistir apenas de a-z e 0-9 e sublinhados.';
			$languages['val_equal'] 			=	'%s não batem.';
			$languages['val_date'] 				=	'Este campo não está no formato correto.';
			$languages['val_date_range'] 		=	'Este campo de data deve estar entre XXX e %s.';
			$languages['val_date_min'] 			=	'Este campo de data deve ser maior ou igual a %s.';
			$languages['val_date_max'] 			=	'Este campo de data deve ser menor ou igual a %s.';
			$languages['val_date_na'] 			=	'Esta data não está disponível para seleção.';
			$languages['val_time'] 				=	'Este campo não está no formato de data correto.';
			$languages['val_phone'] 			=	'Por favor entre com um número de telefone válido.';
			$languages['val_filetype']			=	'O tipo de arquivo que está tentando enviar não é permitido.';
			
			//fields on excel/csv
			$languages['export_num']			=	'Não.';
			$languages['date_created']			=	'Dados criados';
			$languages['date_updated']			=	'Dados atualizados';
			$languages['ip_address']			=	'Endereço IP';

			//form resume
			$languages['resume_email_subject']		= 'Seu cadastro de formulário de %s foi salvo.';
			$languages['resume_email_content'] 		= 'Obrigado! Seu cadastro de formulário de <b>%s</b> foi salvo.<br /><br />Você pode continuar o formulário a qualquer momento clicando no link abaixo:<br /><a href="%s">%s</a><br /><br /><br /><br /><b>IMPORTANTE:</b><br />Seu cadastro é considerado incompleto até que você continue o formulário e aperte o botão de envio.';							

			$languages['resume_success_title']   	= 'Seu progresso foi salvo.';
			$languages['resume_success_content'] 	= 'Por favor copie o link abaixo e guarde em local seguro:<br/>%s<br/><br/>Você pode continuar o formulário a qualquer momento clicando no link acima.';

			$languages['resume_checkbox_title']		= 'Salvar meu progresso e continuar mais tarde';
			$languages['resume_email_input_label']	= 'Forneça seu endereço de email';
			$languages['resume_submit_button_text']	= 'Salvar formulário e continuar mais tarde';
			$languages['resume_guideline']			= 'Um link especial para continuar o formulário será enviado para seu email.';

			//range validation
			$languages['range_type_digit']			= 'dígitos';
			$languages['range_type_chars'] 			= 'caracteres';
			$languages['range_type_words'] 			= 'palavras';

			$languages['range_min']  				= 'Mínimo de %s necessárias.'; 
			$languages['range_min_entered']   		= 'Quantidade Fornecida: %s.';

			$languages['range_max']					= 'Máximo de %s permitidas.';
			$languages['range_max_entered']   		= 'Quantidade Fornecida: %s.';

			$languages['range_min_max'] 			= 'Precisa ter entre %s e %s.';
			$languages['range_min_max_entered'] 	= 'Quantidade Fornecida: %s.';

			$languages['range_number_min']	 		= 'Precisa ser um número maior ou igual a %s.';
			$languages['range_number_max']	 		= 'Precisa ser um número menor ou igual a %s.';
			$languages['range_number_min_max'] 		= 'Precisa ser um número entre %s e %s.';

			//file uploads
			$languages['file_queue_limited'] 		= 'Este campo está limitado a um máximo de %s arquivos.';
			$languages['file_upload_max']	   		= 'Erro. Máximo de %sMB permitidos.';
			$languages['file_type_limited']  		= 'Erro. Este arquivo não é permitido.';
			$languages['file_error_upload']  		= 'Erro! incapaz de enviar';
			$languages['file_attach']		  		= 'Anexar arquivos';

			//payment total
			$languages['payment_total'] 			= 'Total';	

			//multipage
			$languages['page_title']				= 'Página %s de %s';
		}else if($target_language == 'spanish'){
			//simple name and extended name
			$languages['name_first']			= 'Primero';
			$languages['name_middle']			= 'Segundo';
			$languages['name_last']				= 'Apellido';
			$languages['name_title']			= 'Título';
			$languages['name_suffix']			= 'Sufijo';
			
			//address
			$languages['address_street']		= 'Dirección';
			$languages['address_street2']		= 'Dirección (continuación)';
			$languages['address_city']			= 'Ciudad';
			$languages['address_state']			= 'Estado / Provincia / Región';
			$languages['address_zip']			= 'Código postal';
			$languages['address_country']		= 'País';

			//captcha
			$languages['captcha_required']				= 'Este campo es obligatorio. Por favor ingrese las letras que aparecen en la imagen.';
			$languages['captcha_mismatch']				= 'Las letras en la imagen no coinciden. Intente de nuevo.';
			$languages['captcha_text_mismatch'] 		= 'Respuesta incorrecta. Por favor intente de nuevo.';
			$languages['captcha_error']					= 'Error durante el procesamiento. Por favor intente de nuevo.';
			$languages['captcha_simple_image_title']	= 'Ingrese las letras que ve en la imagen de abajo.';
			$languages['captcha_simple_text_title']		= 'Protección contra correo no deseado. Por favor responda esta sencilla pregunta.';
			
			//date
			$languages['date_dd']				= 'DD';
			$languages['date_mm']				= 'MM';
			$languages['date_yyyy']				= 'AAAA';
			
			//price
			$languages['price_dollar_main']		=	'Dollars';
			$languages['price_dollar_sub']		=	'Cents';
			$languages['price_euro_main']		=	'Euros';
			$languages['price_euro_sub']		=	'Cents';
			$languages['price_pound_main']		=	'Pounds';
			$languages['price_pound_sub']		=	'Pence';
			$languages['price_yen']				=	'Yen';
			$languages['price_baht_main']		=	'Baht';
			$languages['price_baht_sub']		=	'Satang';
			$languages['price_rupees_main']		=	'Rupees';
			$languages['price_rupees_sub']		=	'Paise';
			$languages['price_rand_main']		=	'Rand';
			$languages['price_rand_sub']		=	'Cents';
			$languages['price_forint_main']		=	'Forint';
			$languages['price_forint_sub']		=	'Filler';
			$languages['price_franc_main']		=	'Francs';
			$languages['price_franc_sub']		=	'Rappen';
			$languages['price_koruna_main']		=	'Koruna';
			$languages['price_koruna_sub']		=	'Haléřů';
			$languages['price_krona_main']		=	'Kronor';
			$languages['price_krona_sub']		=	'Ore';
			$languages['price_pesos_main']		=	'Pesos';
			$languages['price_pesos_sub']		=	'Cents';
			$languages['price_ringgit_main']	=	'Ringgit';
			$languages['price_ringgit_sub']		=	'Sen';
			$languages['price_zloty_main']		=	'Złoty';
			$languages['price_zloty_sub']		=	'Grosz';
			$languages['price_riyals_main']		=	'Riyals';
			$languages['price_riyals_sub']		=	'Halalah';
			
			//time
			$languages['time_hh']				=	'HH';
			$languages['time_mm']				=	'MM';
			$languages['time_ss']				=	'SS';
			
			//error message
			$languages['error_title']			=	'Hubo un error con su envío.';
			$languages['error_desc']			=	'Abajo aparecen <strong>destacados</strong> los errores.';
			
			//form buttons
			$languages['submit_button']			=	'Enviar';
			$languages['continue_button']		=	'Continuar';
			$languages['back_button']			=	'Anterior';
			
			//form status
			$languages['form_inactive']			=	'Este formulario ahora está inactivo.';
			$languages['form_limited']			=   'Lo siento, pero este formulario ya no acepta más entradas.';
			
			//form password
			$languages['form_pass_title']		=	'Este formulario está protegido por contraseña.';
			$languages['form_pass_desc']		=	'Por favor ingrese su contraseña.';
			$languages['form_pass_invalid']		=	'¡Contraseña inválida!';
			
			//form review
			$languages['review_title']			=	'Revise su entrada';
			$languages['review_message']		=	'Por favor revise su entrada a continuación. Para terminar, haga clic en el botón Enviar.';
			
			//validation message 
			$languages['val_required'] 			=	'Este campo es obligatorio. Por favor ingrese un valor.';
			$languages['val_required_file'] 	=	'Este campo es obligatorio. Por favor suba un archivo.';
			$languages['val_unique'] 			=	'Este campo requiere una entrada única y este valor ya se ha usado.';
			$languages['val_integer'] 			=	'Este campo debe tener un entero.';
			$languages['val_float'] 			=	'Este campo debe tener un flotante.';
			$languages['val_numeric'] 			=	'Este campo debe tener un número.';
			$languages['val_email'] 			=	'Este campo no tiene el formato correcto de correo electrónico.';
			$languages['val_website'] 			=	'Este campo no tiene el formato correcto de dirección de sitio web.';
			$languages['val_username'] 			=	'Este campo solo puede contener a-z 0-9 y guion bajo.';
			$languages['val_equal'] 			=	'%s deben coincidir.';
			$languages['val_date'] 				=	'Este campo no tiene el formato de fecha correcto.';
			$languages['val_date_range'] 		=	'Este campo de fecha debe estar entre %s y %s.';
			$languages['val_date_min'] 			=	'Este campo de fecha debe ser superior o igual a %s.';
			$languages['val_date_max'] 			=	'Este campo de fecha debe ser inferior o igual a %s.';
			$languages['val_date_na'] 			=	'Esta fecha no se puede seleccionar.';
			$languages['val_time'] 				=	'Este campo no tiene el formato de hora correcto.';
			$languages['val_phone'] 			=	'Por favor ingrese un número telefónico válido.';
			$languages['val_filetype']			=	'No se permite el tipo de archivo que intenta subir.';
			
			//fields on excel/csv
			$languages['export_num']			=	'No.';
			$languages['date_created']			=	'Fecha creada';
			$languages['date_updated']			=	'Fecha actualizada';
			$languages['ip_address']			=	'Dirección IP';

			//form resume
			$languages['resume_email_subject']		= 'Su envío del formulario %s se ha guardado.';
			$languages['resume_email_content'] 		= '¡Gracias! Su envío de %s se ha guardado.<br /><br />Puede reanudar el formulario en cualquier momento haciendo clic en el enlace siguiente:<br /><a href="%s">%s</a><br /><br /><br /><br /><b>IMPORTANTE:</b><br />Se considera que su envío está incompleto hasta que reanude el formulario y presione el botón de envío.';							

			$languages['resume_success_title']   	= 'Se ha guardado su progreso.';
			$languages['resume_success_content'] 	= 'Por favor copie el enlace siguiente y guárdelo en un lugar seguro:<br/>%s<br/><br/>Puede reanudar el formulario en cualquier momento visitando el enlace de arriba.';

			$languages['resume_checkbox_title']		= 'Guardar mi progreso y reanudar luego';
			$languages['resume_email_input_label']	= 'Ingresar su dirección de correo electrónico';
			$languages['resume_submit_button_text']	= 'Guardar formulario y reanudar luego';
			$languages['resume_guideline']			= 'Se enviará a su dirección de correo un enlace especial para reanudar el formulario.';

			//range validation
			$languages['range_type_digit']			= 'dígitos';
			$languages['range_type_chars'] 			= 'caracteres';
			$languages['range_type_words'] 			= 'palabras';

			$languages['range_min']  				= 'Obligatorio un mínimo de %s.'; 
			$languages['range_min_entered']   		= 'Ha ingresado: %s.';

			$languages['range_max']					= 'Se permite un máximo de %s.';
			$languages['range_max_entered']   		= 'Ha ingresado: %s.';

			$languages['range_min_max'] 			= 'Debe contener entre %s y %s.';
			$languages['range_min_max_entered'] 	= 'Ha ingresado: %s.';

			$languages['range_number_min']	 		= 'Debe ser un número superior o igual a %s.';
			$languages['range_number_max']	 		= 'Debe ser un número menor o igual a %s.';
			$languages['range_number_min_max'] 		= 'Debe ser un número entre %s y %s.';

			//file uploads
			$languages['file_queue_limited'] 		= 'Este campo tiene un límite máximo de %s archivos.';
			$languages['file_upload_max']	   		= 'Error. Se permite un máximo de %s MB.';
			$languages['file_type_limited']  		= 'Error. No se permite este tipo de archivo.';
			$languages['file_error_upload']  		= '¡Error! Falló la subida';
			$languages['file_attach']		  		= 'Agregar archivos';

			//payment total
			$languages['payment_total'] 			= 'Total';	

			//multipage
			$languages['page_title']				= 'Página %s de %s';
		}else if($target_language == 'swedish'){
			//simple name and extended name
			$languages['name_first']			= 'Förnamn';
			$languages['name_middle']			= 'Mellannamn';
			$languages['name_last']				= 'Efternamn';
			$languages['name_title']			= 'Titel';
			$languages['name_suffix']			= 'Ändelse';
			
			//address
			$languages['address_street']		= 'Gatuadress';
			$languages['address_street2']		= 'Adressrad 2';
			$languages['address_city']			= 'Stad';
			$languages['address_state']			= 'Delstat / Län / Region';
			$languages['address_zip']			= 'Postnummer';
			$languages['address_country']		= 'Land';

			//captcha
			$languages['captcha_required']				= 'Detta fält är obligatoriskt. Vänligen skriv in bokstäverna som visas i bilden.';
			$languages['captcha_mismatch']				= 'Bokstäverna i bilden stämmer inte överrens. Försök igen.';
			$languages['captcha_text_mismatch'] 		= 'Fel svar. Vänligen försök igen.';
			$languages['captcha_error']					= 'Fel vid bearbetning, vänligen försök igen.';
			$languages['captcha_simple_image_title']	= 'Skriv bokstäverna du ser i bilden nedan.';
			$languages['captcha_simple_text_title']		= 'Spamskydd. Vänligen svara på denna enkla fråga.';
			
			//date
			$languages['date_dd']				= 'DD';
			$languages['date_mm']				= 'MM';
			$languages['date_yyyy']				= 'ÅÅÅÅ';
			
			//price
			$languages['price_dollar_main']		=	'Dollars';
			$languages['price_dollar_sub']		=	'Cents';
			$languages['price_euro_main']		=	'Euros';
			$languages['price_euro_sub']		=	'Cents';
			$languages['price_pound_main']		=	'Pounds';
			$languages['price_pound_sub']		=	'Pence';
			$languages['price_yen']				=	'Yen';
			$languages['price_baht_main']		=	'Baht';
			$languages['price_baht_sub']		=	'Satang';
			$languages['price_rupees_main']		=	'Rupees';
			$languages['price_rupees_sub']		=	'Paise';
			$languages['price_rand_main']		=	'Rand';
			$languages['price_rand_sub']		=	'Cents';
			$languages['price_forint_main']		=	'Forint';
			$languages['price_forint_sub']		=	'Filler';
			$languages['price_franc_main']		=	'Francs';
			$languages['price_franc_sub']		=	'Rappen';
			$languages['price_koruna_main']		=	'Koruna';
			$languages['price_koruna_sub']		=	'Haléřů';
			$languages['price_krona_main']		=	'Kronor';
			$languages['price_krona_sub']		=	'Ore';
			$languages['price_pesos_main']		=	'Pesos';
			$languages['price_pesos_sub']		=	'Cents';
			$languages['price_ringgit_main']	=	'Ringgit';
			$languages['price_ringgit_sub']		=	'Sen';
			$languages['price_zloty_main']		=	'Złoty';
			$languages['price_zloty_sub']		=	'Grosz';
			$languages['price_riyals_main']		=	'Riyals';
			$languages['price_riyals_sub']		=	'Halalah';
			
			//time
			$languages['time_hh']				=	'TT';
			$languages['time_mm']				=	'MM';
			$languages['time_ss']				=	'SS';
			
			//error message
			$languages['error_title']			=	'Ett problem uppstog med ditt formulär.';
			$languages['error_desc']			=	'Felen har <strong>markerats</strong> nedan.';
			
			//form buttons
			$languages['submit_button']			=	'Skicka';
			$languages['continue_button']		=	'Fortsätt';
			$languages['back_button']			=	'Föregående';
			
			//form status
			$languages['form_inactive']			=	'Detta formulär är för närvarande inaktivt.';
			$languages['form_limited']			=   'Tyvärr så tar detta formulär inte emot några fler inmatningar.';
			
			//form password
			$languages['form_pass_title']		=	'Detta formulär är lösenordsskyddat.';
			$languages['form_pass_desc']		=	'Vänligen skriv in ditt lösenord.';
			$languages['form_pass_invalid']		=	'Fel lösenord!';
			
			//form review
			$languages['review_title']			=	'Kontrollera dina uppgifter';
			$languages['review_message']		=	'Vänligen kontrollera dina uppgifter nedan. Tryck Skicka-knappen för att slutföra.';
			
			//validation message 
			$languages['val_required'] 			=	'Detta fält är obligatoriskt. Vänligen skriv in ett värde.';
			$languages['val_required_file'] 	=	'Detta fält är obligatoriskt. Vänligen ladda upp en fil.';
			$languages['val_unique'] 			=	'Detta fält kräver ett unikt värde och detta värde har redan använts.';
			$languages['val_integer'] 			=	'Detta fält måste vara en siffra.';
			$languages['val_float'] 			=	'Detta fält måste vara ett flyttal.';
			$languages['val_numeric'] 			=	'Detta fält måste vara ett nummer.';
			$languages['val_email'] 			=	'Detta fält har inte ett korrekt e-postformat.';
			$languages['val_website'] 			=	'Detta fält har inte ett korrekt webbadressformat.';
			$languages['val_username'] 			=	'Detta fält får endast bestå av a-z 0-9 och understreck.';
			$languages['val_equal'] 			=	'%s måste stämma överrens.';
			$languages['val_date'] 				=	'Detta fält har inte rätt datumformat.';
			$languages['val_date_range'] 		=	'Detta fält måste vara mellan %s och %s.';
			$languages['val_date_min'] 			=	'Detta fält måste vara större än eller lika med %s.';
			$languages['val_date_max'] 			=	'Detta fält måste vara mindre än eller lika med %s.';
			$languages['val_date_na'] 			=	'Detta datum är inte tillgängligt.';
			$languages['val_time'] 				=	'Detta fält har inte rätt tidsformat.';
			$languages['val_phone'] 			=	'Vänligen skriv in ett giltigt telefonnummer.';
			$languages['val_filetype']			=	'Den filtyp du försöker ladda upp är inte tillåten.';
			
			//fields on excel/csv
			$languages['export_num']			=	'Nej.';
			$languages['date_created']			=	'Datum skapat';
			$languages['date_updated']			=	'Datum uppdaterat';
			$languages['ip_address']			=	'IP-adress';

			//form resume
			$languages['resume_email_subject']		= 'Ditt formulär till %s-formuläret har sparats.';
			$languages['resume_email_content'] 		= 'Tack! Ditt formulär till <b>%s</b> har sparats.<br /><br />Du kan återuppta ifyllnaden av formuläret när som helst genom att klicka på länken nedan:<br /><a href="%s">%s</a><br /><br /><br /><br /><b>VIKTIGT:</b><br />Ditt formulär anses vara ofullständig tills du återupptar formuläret och trycker på skicka-knappen.';							

			$languages['resume_success_title']   	= 'Din data har sparats.';
			$languages['resume_success_content'] 	= 'Vänligen kopiera nedanstående länk och spara den på ett säkert ställe:<br/>%s<br/><br/>Du kan återuppta ifyllnaden av formuläret när som helst genom att gå till ovanstående länk';

			$languages['resume_checkbox_title']		= 'Spara min data och fortsätt senare';
			$languages['resume_email_input_label']	= 'Skriv in din e-postadress';
			$languages['resume_submit_button_text']	= 'Spara formulär och återuppta senare';
			$languages['resume_guideline']			= 'En speciell länk för att fortsätta fylla i formuläret kommer skickas till din e-postadress';

			//range validation
			$languages['range_type_digit']			= 'siffror';
			$languages['range_type_chars'] 			= 'tecken';
			$languages['range_type_words'] 			= 'ord';

			$languages['range_min']  				= 'Minst %s krävs.'; 
			$languages['range_min_entered']   		= 'Är för närvarande: %s.';

			$languages['range_max']					= 'Maximalt %s tillåts.';
			$languages['range_max_entered']   		= 'Är för närvarande: %s.';

			$languages['range_min_max'] 			= 'Måste vara mellan %s och %s.';
			$languages['range_min_max_entered'] 	= 'Är för närvarande: %s.';

			$languages['range_number_min']	 		= 'Måste vara ett nummer större än eller lika med %s.';
			$languages['range_number_max']	 		= 'Måste vara ett nummer mindre än eller lika med %s.';
			$languages['range_number_min_max'] 		= 'Måste vara ett nummer mellan %s and %s.';

			//file uploads
			$languages['file_queue_limited'] 		= 'Detta fält är begränsat till högst %s filer.';
			$languages['file_upload_max']	   		= 'Fel. Maximalt %sMB tillåts.';
			$languages['file_type_limited']  		= 'Fel. Denna filtyp tillåts inte.';
			$languages['file_error_upload']  		= 'Fel! Kunde inte ladda upp';
			$languages['file_attach']		  		= 'Bifoga filer';

			//payment total
			$languages['payment_total'] 			= 'Totalt';	

			//multipage
			$languages['page_title']				= 'Sidan %s av %s';
		}else if($target_language == 'japanese'){
			//simple name and extended name
			$languages['name_first']			= '名';
			$languages['name_middle']			= 'ミドルネーム';
			$languages['name_last']				= '姓';
			$languages['name_title']			= '敬称';
			$languages['name_suffix']			= '称号';
			
			//address
			$languages['address_street']		= '住所';
			$languages['address_street2']		= '住所２行目';
			$languages['address_city']			= '市';
			$languages['address_state']			= '県（州／省／地域';
			$languages['address_zip']			= '郵便番号';
			$languages['address_country']		= '国';

			//captcha
			$languages['captcha_required']				= 'この欄は必須です。画像に表示されている文字を入力してください。';
			$languages['captcha_mismatch']				= '文字が画像と一致しません。もう一度試してください。';
			$languages['captcha_text_mismatch'] 		= '答えが不正確です。もう一度試してください。';
			$languages['captcha_error']					= '処理中にエラーが発生しました。もう一度試してください。';
			$languages['captcha_simple_image_title']	= '以下の画像に表示されている文字を入力してください。';
			$languages['captcha_simple_text_title']		= 'スパム防止です。この簡単な質問に答えてください。';
			
			//date
			$languages['date_dd']				= '日';
			$languages['date_mm']				= '月';
			$languages['date_yyyy']				= '年';
			
			//price
			$languages['price_dollar_main']		=	'Dollars';
			$languages['price_dollar_sub']		=	'Cents';
			$languages['price_euro_main']		=	'Euros';
			$languages['price_euro_sub']		=	'Cents';
			$languages['price_pound_main']		=	'Pounds';
			$languages['price_pound_sub']		=	'Pence';
			$languages['price_yen']				=	'Yen';
			$languages['price_baht_main']		=	'Baht';
			$languages['price_baht_sub']		=	'Satang';
			$languages['price_rupees_main']		=	'Rupees';
			$languages['price_rupees_sub']		=	'Paise';
			$languages['price_rand_main']		=	'Rand';
			$languages['price_rand_sub']		=	'Cents';
			$languages['price_forint_main']		=	'Forint';
			$languages['price_forint_sub']		=	'Filler';
			$languages['price_franc_main']		=	'Francs';
			$languages['price_franc_sub']		=	'Rappen';
			$languages['price_koruna_main']		=	'Koruna';
			$languages['price_koruna_sub']		=	'Haléřů';
			$languages['price_krona_main']		=	'Kronor';
			$languages['price_krona_sub']		=	'Ore';
			$languages['price_pesos_main']		=	'Pesos';
			$languages['price_pesos_sub']		=	'Cents';
			$languages['price_ringgit_main']	=	'Ringgit';
			$languages['price_ringgit_sub']		=	'Sen';
			$languages['price_zloty_main']		=	'Złoty';
			$languages['price_zloty_sub']		=	'Grosz';
			$languages['price_riyals_main']		=	'Riyals';
			$languages['price_riyals_sub']		=	'Halalah';
			
			//time
			$languages['time_hh']				=	'時';
			$languages['time_mm']				=	'分';
			$languages['time_ss']				=	'秒';
			
			//error message
			$languages['error_title']			=	'送信に不具合が発生しました。';
			$languages['error_desc']			=	'エラーは以下に<strong>強調</strong>されています。';
			
			//form buttons
			$languages['submit_button']			=	'送信';
			$languages['continue_button']		=	'続ける';
			$languages['back_button']			=	'前へ';
			
			//form status
			$languages['form_inactive']			=	'このフォームは現在休止中です。';
			$languages['form_limited']			=   '申し訳ありませんが、このフォームはエントリーの受付を終了しました。';
			
			//form password
			$languages['form_pass_title']		=	'このフォームはパスワードによって保護されています。';
			$languages['form_pass_desc']		=	'パスワードを入力してください。';
			$languages['form_pass_invalid']		=	'無効なパスワードです！';
			
			//form review
			$languages['review_title']			=	'エントリーを確認する';
			$languages['review_message']		=	'以下のエントリーを確認してください。送信ボタンをクリックすると終了します。';
			
			//validation message 
			$languages['val_required'] 			=	'この欄は必須です。数値を入力してください。';
			$languages['val_required_file'] 	=	'この欄は必須です。ファイルをアップロードしてください。';
			$languages['val_unique'] 			=	'この欄には固有のエントリーが必要です。この数値は既に使用されています。';
			$languages['val_integer'] 			=	'この欄は整数でなければいけません。';
			$languages['val_float'] 			=	'この欄は浮動小数でなければいけません。';
			$languages['val_numeric'] 			=	'この欄は数字でなければいけません。';
			$languages['val_email'] 			=	'この欄には適切なＥメール形式が入力されていません。';
			$languages['val_website'] 			=	'この欄には適切なウェブサイトアドレス形式が入力されていません。';
			$languages['val_username'] 			=	'この欄にはa〜zおよび0〜9、アンダースコアのみを入力することができます。';
			$languages['val_equal'] 			=	'%sが一致しなければいけません。';
			$languages['val_date'] 				=	'この欄には適切な日付の形式が入力されていません。';
			$languages['val_date_range'] 		=	'この日付欄は%sから%sの間でなければいけません。';
			$languages['val_date_min'] 			=	'この日付欄は%s以上でなければいけません。';
			$languages['val_date_max'] 			=	'この日付欄は%s以下でなければいけません。';
			$languages['val_date_na'] 			=	'この日付は選択できません。';
			$languages['val_time'] 				=	'この欄には適切な時間形式が入力されていません。';
			$languages['val_phone'] 			=	'有効な電話番号を入力してください。';
			$languages['val_filetype']			=	'アップロードしようとしているファイル形式には対応していません。';
			
			//fields on excel/csv
			$languages['export_num']			=	'Ｎｏ．';
			$languages['date_created']			=	'作成日時';
			$languages['date_updated']			=	'更新日時';
			$languages['ip_address']			=	'ＩＰアドレス';

			//form resume
			$languages['resume_email_subject']		= '%sフォームへの入力が保存されました。';
			$languages['resume_email_content'] 		= 'ありがとうございます！<b>%s</b>への入力が保存されました。<br /><br />以下のリンクをクリックすることでいつでもフォームの入力を再開することができます：<br /><a href="%s">%s</a><br /><br /><br /><br /><b>重要：</b><br />フォームの入力を再開して送信ボタンを押すまで、お客様の入力は不完全なものとみなされます。';							

			$languages['resume_success_title']   	= 'お客様の進捗が保存されました。';
			$languages['resume_success_content'] 	= '以下のリンクをコピーして安全な場所に保存してください：<br/>%s<br/><br/>上のリンクを開くことでいつでもフォームの入力を再開することができます';

			$languages['resume_checkbox_title']		= '進捗を保存して後で再開する';
			$languages['resume_email_input_label']	= 'Ｅメールアドレスを入力してください。';
			$languages['resume_submit_button_text']	= 'フォームを保存して後で再開する';
			$languages['resume_guideline']			= 'フォームの入力を再開するための特別なリンクがお客様のＥメールアドレスに送信されます';

			//range validation
			$languages['range_type_digit']			= '桁';
			$languages['range_type_chars'] 			= '文字';
			$languages['range_type_words'] 			= '語';

			$languages['range_min']  				= '最小%sの入力が必要です。'; 
			$languages['range_min_entered']   		= '現在の入力数： %s.';

			$languages['range_max']					= '最大%sがの入力が可能です。';
			$languages['range_max_entered']   		= '現在の入力数： %s.';

			$languages['range_min_max'] 			= '%sから%sでなければいけません。';
			$languages['range_min_max_entered'] 	= '現在の入力数： %s.';

			$languages['range_number_min']	 		= '%s以上の数字でなければいけません。';
			$languages['range_number_max']	 		= '%s以下の数字でなければいけません。';
			$languages['range_number_min_max'] 		= '%sから%sの数字でなければいけません。';

			//file uploads
			$languages['file_queue_limited'] 		= 'この欄は最大%sファイルまでに限定されています。';
			$languages['file_upload_max']	   		= 'エラーです。最大%sＭＢまで利用可能です。';
			$languages['file_type_limited']  		= 'エラーです。このファイル形式には対応していません。';
			$languages['file_error_upload']  		= 'エラーです！アップロードできません';
			$languages['file_attach']		  		= '添付ファイル';

			//payment total
			$languages['payment_total'] 			= '計';	

			//multipage
			$languages['page_title']				= '%sページ。%s:総ページ数';
		}

		$mf_lang = $languages;
	}
?>