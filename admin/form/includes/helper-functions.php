<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/
ini_set('display_errors', 0); 
ini_set('log_errors', 0); 
error_reporting(0);	
	//this function accept 'YYYY-MM-DD HH:MM:SS'
	function mf_relative_date($input_date) {
	    
	    $tz = 0;    // change this if your web server and weblog are in different timezones
	           			        
	    $posted_date = str_replace(array('-',' ',':'),'',$input_date);            
	    $month = substr($posted_date,4,2);
	    
	    if ($month == "02") { // february
	    	// check for leap year
	    	$leapYear = mf_is_leap_year(substr($posted_date,0,4));
	    	if ($leapYear) $month_in_seconds = 2505600; // leap year
	    	else $month_in_seconds = 2419200;
	    }
	    else { // not february
	    // check to see if the month has 30/31 days in it
	    	if ($month == "04" or 
	    		$month == "06" or 
	    		$month == "09" or 
	    		$month == "11")
	    		$month_in_seconds = 2592000; // 30 day month
	    	else $month_in_seconds = 2678400; // 31 day month;
	    }
	  
	    $in_seconds = strtotime(substr($posted_date,0,8).' '.
	                  substr($posted_date,8,2).':'.
	                  substr($posted_date,10,2).':'.
	                  substr($posted_date,12,2));
	    $diff = time() - ($in_seconds + ($tz*3600));
	    $months = floor($diff/$month_in_seconds);
	    $diff -= $months*2419200;
	    $weeks = floor($diff/604800);
	    $diff -= $weeks*604800;
	    $days = floor($diff/86400);
	    $diff -= $days*86400;
	    $hours = floor($diff/3600);
	    $diff -= $hours*3600;
	    $minutes = floor($diff/60);
	    $diff -= $minutes*60;
	    $seconds = $diff;
	
	    $relative_date = '';
	    if ($months>0) {
	        // over a month old, just show date ("Month, Day Year")
	        if(!empty($input_date)){
	        	return date('F jS, Y',strtotime($input_date));
	        }else{
	        	return 'N/A';
	        }
	    } else {
	        if ($weeks>0) {
	            // weeks and days
	            $relative_date .= ($relative_date?', ':'').$weeks.' week'.($weeks>1?'s':'');
	            $relative_date .= $days>0?($relative_date?', ':'').$days.' day'.($days>1?'s':''):'';
	        } elseif ($days>0) {
	            // days and hours
	            $relative_date .= ($relative_date?', ':'').$days.' day'.($days>1?'s':'');
	            $relative_date .= $hours>0?($relative_date?', ':'').$hours.' hour'.($hours>1?'s':''):'';
	        } elseif ($hours>0) {
	            // hours and minutes
	            $relative_date .= ($relative_date?', ':'').$hours.' hour'.($hours>1?'s':'');
	            $relative_date .= $minutes>0?($relative_date?', ':'').$minutes.' minute'.($minutes>1?'s':''):'';
	        } elseif ($minutes>0) {
	            // minutes only
	            $relative_date .= ($relative_date?', ':'').$minutes.' minute'.($minutes>1?'s':'');
	        } else {
	            // seconds only
	            $relative_date .= ($relative_date?', ':'').$seconds.' second'.($seconds>1?'s':'');
	        }
	        
	        // show relative date and add proper verbiage
	    	return $relative_date.' ago';
	    }
	    
	}
	
	//this function accept 'YYYY-MM-DD HH:MM:SS'
	function mf_short_relative_date($input_date) {
	    
	    $tz = 0;    // change this if your web server and weblog are in different timezones
	           			        
	    $posted_date = str_replace(array('-',' ',':'),'',$input_date);            
	    $month = substr($posted_date,4,2);
	    $year  = substr($posted_date,0,4);
	    
	    if ($month == "02") { // february
	    	// check for leap year
	    	$leapYear = mf_is_leap_year($year);
	    	if ($leapYear) $month_in_seconds = 2505600; // leap year
	    	else $month_in_seconds = 2419200;
	    }
	    else { // not february
	    // check to see if the month has 30/31 days in it
	    	if ($month == "04" or 
	    		$month == "06" or 
	    		$month == "09" or 
	    		$month == "11")
	    		$month_in_seconds = 2592000; // 30 day month
	    	else $month_in_seconds = 2678400; // 31 day month;
	    }
	  
	    $in_seconds = strtotime(substr($posted_date,0,8).' '.
	                  substr($posted_date,8,2).':'.
	                  substr($posted_date,10,2).':'.
	                  substr($posted_date,12,2));
	    $diff = time() - ($in_seconds + ($tz*3600));
	    $months = floor($diff/$month_in_seconds);
	    $diff -= $months*2419200;
	    $weeks = floor($diff/604800);
	    $diff -= $weeks*604800;
	    $days = floor($diff/86400);
	    $diff -= $days*86400;
	    $hours = floor($diff/3600);
	    $diff -= $hours*3600;
	    $minutes = floor($diff/60);
	    $diff -= $minutes*60;
	    $seconds = $diff;
	
	    $relative_date = '';
	    if ($months>0) {
	    	
	        // over a month old
	        if(!empty($input_date)){
	        	if($year < date('Y')){ //over a year, show international date
	        		return date('Y-m-d',strtotime($input_date));
	        	}else{ //less than a year
	        		return date('M j',strtotime($input_date));
	        	}
	        	
	        }else{
	        	return '';
	        }
	    } else {
	        if ($weeks>0) {
	            // weeks and days
	            $relative_date .= ($relative_date?', ':'').$weeks.' week'.($weeks>1?'s':'');
	            //$relative_date .= $days>0?($relative_date?', ':'').$days.' day'.($days>1?'s':''):'';
	        } elseif ($days>0) {
	            // days and hours
	            $relative_date .= ($relative_date?', ':'').$days.' day'.($days>1?'s':'');
	            //$relative_date .= $hours>0?($relative_date?', ':'').$hours.' hour'.($hours>1?'s':''):'';
	        } elseif ($hours>0) {
	            // hours and minutes
	            $relative_date .= ($relative_date?', ':'').$hours.' hour'.($hours>1?'s':'');
	            //$relative_date .= $minutes>0?($relative_date?', ':'').$minutes.' minute'.($minutes>1?'s':''):'';
	        } elseif ($minutes>0) {
	            // minutes only
	            $relative_date .= ($relative_date?', ':'').$minutes.' minute'.($minutes>1?'s':'');
	        } else {
	            // seconds only
	            $relative_date .= ($relative_date?', ':'').$seconds.' second'.($seconds>1?'s':'');
	        }
	        
	        // show relative date and add proper verbiage
	    	return $relative_date.' ago';
	    }
	    
	}
	
	function mf_is_leap_year($year) {
	        return $year % 4 == 0 && ($year % 400 == 0 || $year % 100 != 0);
	}
	
	//remove a folder and all it's content
	function mf_full_rmdir($dirname){
        if ($dirHandle = opendir($dirname)){
            $old_cwd = getcwd();
            chdir($dirname);

            while ($file = readdir($dirHandle)){
                if ($file == '.' || $file == '..') continue;

                if (is_dir($file)){
                    if (!mf_full_rmdir($file)) return false;
                }else{
                    if (!unlink($file)) return false;
                }
            }

            closedir($dirHandle);
            chdir($old_cwd);
            if (!rmdir($dirname)) return false;

            return true;
        }else{
            return false;
        }
    }

    //show success or error messages
    function mf_show_message(){
    	
    	if(!empty($_SESSION['MF_SUCCESS'])){
    		
    		$message_div = <<<EOT
    		    <div class="alert alert-success">
						{$_SESSION['MF_SUCCESS']}
					<a id="close_notification" class="close" data-dismiss="alert" href="#" onclick="$('.content_notification').fadeOut();return false;"></a>
				</div>
EOT;
    		
    		$_SESSION['MF_SUCCESS'] = '';
    		
    		echo $message_div;
    	}else if(!empty($_SESSION['MF_ERROR'])){
    		$message_div = <<<EOT
    		    <div class="gradient_red content_notification">
					<div class="cn_icon"></div>
					<div class="cn_message">
						<h6 style="font-weight: 700;font-size: 16px">Error!</h6>
						<h6>{$_SESSION['MF_ERROR']}</h6>
					</div>
					<a id="close_notification" href="#" onclick="$('.content_notification').fadeOut();return false;" title="Close Notification"><img src="images/icons/52_red_16.png" /></a>
				</div>
EOT;
    		
    		$_SESSION['MF_ERROR'] = '';
    		
    		echo $message_div;
    	}

    }
    
    //send notification email
    //$to_emails is a comma separated list of email address or {element_x} field
    function mf_send_notification($dbh,$form_id,$entry_id,$to_emails,$email_param){
    	
    	$from_name  = $email_param['from_name'];
    	$from_email = $email_param['from_email'];
    	$subject 	= $email_param['subject'];
    	$content 	= $email_param['content'];
    	$as_plain_text 		= $email_param['as_plain_text']; //if set to 'true' the email content will be a simple plain text
    	$target_is_admin 	= $email_param['target_is_admin']; //if set to 'false', the download link for uploaded file will be removed
    
		//get settings first
    	$mf_settings = mf_get_settings($dbh);
    	
    	//get data for the particular entry id
    	if($target_is_admin === false){
    		$options['strip_download_link'] = true;
    	}
    	
    	$options['strip_checkbox_image'] = true;
    	$options['machform_base_path'] = $email_param['machform_base_path']; //the path to machform
		$entry_details = mf_get_entry_details($dbh,$form_id,$entry_id,$options);
  	
    	//populate field values to template variables
    	$i=0;
    	foreach ($entry_details as $data){
    		$template_variables[$i] = '{element_'.$data['element_id'].'}';
    		$template_values[$i]	= $data['value'];
    		
    		if($data['element_type'] == 'textarea'){
				$template_values[$i] = nl2br($data['value']);
			}elseif ($data['element_type'] == 'file'){
				if($target_is_admin === false){
					$template_values[$i] = strip_tags($data['value']);
				}else{
					$template_values[$i] = strip_tags($data['value'],'<a><br/>');
				}
			}else{
				$template_values[$i]	= $data['value'];
			}
    		    		
    		$i++;
    	}
    	
    	$entry_values = mf_get_entry_values($dbh,$form_id,$entry_id);

    	//get template variables for some complex fields (name and address)
		$query  = "select 
						 element_id,
						 element_type 
				     from
				     	 `".MF_TABLE_PREFIX."form_elements` 
				    where 
				    	 form_id=? and 
				    	 element_type != 'section' and 
				    	 element_status=1 and
				    	 element_type in('simple_name','simple_name_wmiddle','name','name_wmiddle','address')
				 order by 
				 		 element_position asc";
		$params = array($form_id);
		$sth = mf_do_query($query,$params,$dbh);	
	
		while($row = mf_do_fetch_result($sth)){
			$element_id    = $row['element_id'];
			$element_type  = $row['element_type']; 
			
			if('simple_name' == $element_type){
				$total_sub_field = 2;
			}else if('simple_name_wmiddle' == $element_type){
				$total_sub_field = 3;	
			}else if('name' == $element_type){
				$total_sub_field = 4;
			}else if('name_wmiddle' == $element_type){
				$total_sub_field = 5;
			}else if('address' == $element_type){
				$total_sub_field = 6;
			}

			for($j=1;$j<=$total_sub_field;$j++){
				$template_variables[$i] = '{element_'.$element_id.'_'.$j.'}';
    			$template_values[$i]	= $entry_values['element_'.$element_id.'_'.$j]['default_value'];
    			$i++;
			}
		}

    	//get entry timestamp
		$query = "select date_created,ip_address from `".MF_TABLE_PREFIX."form_{$form_id}` where id=?";
		$params = array($entry_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
		
		$date_created = $row['date_created'];
		$ip_address   = $row['ip_address'];
    	    	
    	//get form name
		$query 	= "select form_name	from `".MF_TABLE_PREFIX."forms` where form_id=?";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
		
		$form_name  = $row['form_name'];
    	
    	
		$template_variables[$i] = '{date_created}';
		$template_values[$i]	= $date_created;
		$i++;
		$template_variables[$i] = '{ip_address}';
		$template_values[$i]	= $ip_address;
		$i++;
		$template_variables[$i] = '{form_name}';
		$template_values[$i]	= $form_name;
		$i++;
		$template_variables[$i] = '{entry_no}';
		$template_values[$i]	= $entry_id;
		$i++;
		$template_variables[$i] = '{form_id}';
		$template_values[$i]	= $form_id;
		
		
		//compose {entry_data} based on 'as_plain_text' preferences
		$email_body = '';
		$files_to_attach = array();
		
    	if(!$as_plain_text){
			//compose html format
			$email_body = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Lucida Grande,Tahoma,Arial,Verdana,sans-serif;font-size:12px;text-align:left">'."\n";
			
			$toggle = false;
			$j=0;
			foreach ($entry_details as $data){
				//0 should be displayed, empty string don't
				if((empty($data['value']) || $data['value'] == '&nbsp;') && $data['value'] !== 0 && $data['value'] !== '0'){
					continue;
				}				
				
				//skip pagebreak
				if($data['label'] == 'mf_page_break' && $data['value'] == 'mf_page_break'){
					continue;
				}


				if($toggle){
					$toggle = false;
					$row_style = 'style="background-color:#F3F7FB"';
				}else{
					$toggle = true;
					$row_style = '';
				}
			
				if($data['element_type'] == 'textarea'){
					$data['value'] = nl2br($data['value']);
				}elseif ($data['element_type'] == 'file'){
					
					if($target_is_admin === false){
						$data['value'] = strip_tags($data['value']);
					}else{
						$data['value'] = strip_tags($data['value'],'<a><br/>');
						$data['value'] = str_replace('&nbsp;', '', $data['value']);
						
						//if there is file to be attached
						if(!empty($data['filedata'])){
							foreach ($data['filedata'] as $file_info){
								$files_to_attach[$j]['filename_path']  = $file_info['filename_path'];
								$files_to_attach[$j]['filename_value'] = $file_info['filename_value'];
								$j++;
							}
						}
					}
				}
				
				$email_body .= "<tr {$row_style}>\n";
				$email_body .= '<td width="40%" style="border-bottom:1px solid #DEDEDE;padding:5px 10px;"><strong>'.$data['label'].'</strong> </td>'."\n";
				$email_body .= '<td width="60%" style="border-bottom:1px solid #DEDEDE;padding:5px 10px;">'.$data['value'].'</td>'."\n";
				$email_body .= '</tr>'."\n";	
					
				$i++;
			}
			$email_body .= "</table>\n";
		}else{
			
			$money_symbols = array('&#165;','&#163;','&#8364;','&#3647;','&#75;&#269;','&#122;&#322;','&#65020;');
			$money_plain   = array('¥','£','€','฿','Kč','zł','﷼');

			//compose text format
			foreach ($entry_details as $data){
				
				//0 should be displayed, empty string don't
				if((empty($data['value']) || $data['value'] == '&nbsp;') && $data['value'] !== 0 && $data['value'] !== '0'){
					continue;
				}
				
				$data['value'] = str_replace('<br />', "\n", $data['value']);
								
				if($data['element_type'] == 'textarea' || $data['element_type'] == 'matrix'){
					$data['value'] = trim($data['value'],"\n");
					$email_body .= "{$data['label']}: \n".$data['value']."\n\n";
				}elseif ($data['element_type'] == 'checkbox' || $data['element_type'] == 'address'){
					$email_body .= "{$data['label']}: \n".$data['value']."\n\n";
				}elseif ($data['element_type'] == 'file'){
					$data['value'] = strip_tags($data['value']);
					$data['value'] = str_replace('&nbsp;', "\n- ", $data['value']);
					$email_body .= "{$data['label']}: {$data['value']}\n";
				}elseif($data['element_type'] == 'money'){
					$data['value'] = str_replace($money_symbols, $money_plain, $data['value']);
					$email_body .= "{$data['label']}: {$data['value']} \n\n";
				}elseif($data['element_type'] == 'url'){
					$data['value'] = strip_tags($data['value']);
					$email_body .= "{$data['label']}: {$data['value']} \n\n";
				}else{
					$email_body .= "{$data['label']}: {$data['value']} \n\n";
				}
				
				
			}
		}
		
		$i = count($template_variables);
		$template_variables[$i] = '{entry_data}';
		$template_values[$i]	= $email_body;
		
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
		if(file_exists($mf_settings['upload_dir']."/form_{$form_id}/files")){
			Swift_Preferences::getInstance()->setCacheType('disk')->setTempDir($mf_settings['upload_dir']."/form_{$form_id}/files");
		}
		
		//create the message
    	//parse from_name template
    	if(!empty($from_name)){
    		$from_name = str_replace($template_variables,$template_values,$from_name);
			$from_name = str_replace('&nbsp;','',$from_name);
			
			//decode any html entity
			$from_name = html_entity_decode($from_name,ENT_QUOTES);
    	}else{
			$from_name = 'MachForm';
		}
		
    	//parse from_email_address template
    	if(!empty($from_email)){
    		$from_email = str_replace($template_variables,$template_values,$from_email);
		}else{
			$domain = str_replace('www.','',$_SERVER['SERVER_NAME']);
			$from_email = "no-reply@{$domain}";
		}
		
		//parse subject template
    	if(!empty($subject)){
    		$subject = str_replace($template_variables,$template_values,$subject);
			$subject = str_replace('&nbsp;','',$subject);
		}else{
			if($target_is_admin){
				$subject = utf8_encode("{$form_name} [#{$entry_id}]");
			}else{
				$subject = utf8_encode("{$form_name} - Receipt");
			}
		}
		//decode any html entity
		$subject = html_entity_decode($subject,ENT_QUOTES);
		
		//parse content template
    	$email_content = str_replace($template_variables,$template_values,$content);
    	
    	
    	if(!$as_plain_text){ //html type
	    	//add footer
	    	if(empty($mf_settings['disable_machform_link'])){
				$email_content .= "<br /><br /><br /><br /><br /><b style=\"font-family:Lucida Grande,Tahoma,Arial,Verdana,sans-serif;font-size:12px\">Powered by MachForm</b>";
			}
	    	
	    	
	    	//enclose with container div
	    	$email_content = '<div style="font-family:Lucida Grande,Tahoma,Arial,Verdana,sans-serif;font-size:12px">'.$email_content.'</div>';
	    }
    	
    	$to_emails 		= str_replace('&nbsp;','',str_replace($template_variables,$template_values,$to_emails));
    	
    	if(!empty($to_emails)){
    		$email_address 	= explode(',',$to_emails);
    	}

    	if(!empty($email_address)){
    		
    		if(!$as_plain_text){
	    		$email_content_type = 'text/html';
	    	}else{
	    		$email_content_type = 'text/plain';	
	    	}

			$s_message = Swift_Message::newInstance()
			->setCharset('utf-8')
			->setMaxLineLength(1000)
			->setSubject($subject)
			->setFrom(array($from_email => $from_name))
			->setSender($from_email)
			->setReturnPath($from_email)
			->setTo($email_address)
			->setBody($email_content, $email_content_type);

	    	//attach files, if any
	    	if(!empty($files_to_attach)){
	    		foreach ($files_to_attach as $file_data){
	    			$s_message->attach(Swift_Attachment::fromPath($file_data['filename_path'])->setFilename($file_data['filename_value']));
	    		}
	    	}
			
			//send the message
			$send_result = $s_mailer->send($s_message);
			if(empty($send_result)){
				echo "Error sending email!";
			}
    	}
		
    }
    
    function mf_send_resume_link($dbh,$form_name,$form_resume_url,$resume_email){
    	global $mf_lang;

    	//get settings first
    	$mf_settings = mf_get_settings($dbh);
    	
		$subject = sprintf($mf_lang['resume_email_subject'],$form_name);
    	$email_content = sprintf($mf_lang['resume_email_content'],$form_name,$form_resume_url,$form_resume_url);
    	
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
		if(file_exists($mf_settings['upload_dir']."/form_{$form_id}/files")){
			Swift_Preferences::getInstance()->setCacheType('disk')->setTempDir($mf_settings['upload_dir']."/form_{$form_id}/files");
		}
		
		$from_name  = html_entity_decode($mf_settings['default_from_name'],ENT_QUOTES);
		$from_email = $mf_settings['default_from_email'];
		
		if(!empty($resume_email) && !empty($form_resume_url)){
			$s_message = Swift_Message::newInstance()
			->setCharset('utf-8')
			->setMaxLineLength(1000)
			->setSubject($subject)
			->setFrom(array($from_email => $from_name))
			->setSender($from_email)
			->setReturnPath($from_email)
			->setTo($resume_email)
			->setBody($email_content, 'text/html');

			//send the message
			$send_result = $s_mailer->send($s_message);
			if(empty($send_result)){
				echo "Error sending email!";
			}
		}
    	
    }
    
    function mf_get_ssl_suffix(){
    	if(!empty($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] != 'off')){
			$ssl_suffix = 's';
		}else{
			$ssl_suffix = '';
		}
		
		return $ssl_suffix;
    }
    
    function mf_get_dirname($path){
    	$current_dir = dirname($path);
    	
    	if($current_dir == "/" || $current_dir == "\\"){
			$current_dir = '';
		}
		
		return $current_dir;
    }
    
    function mf_get_settings($dbh){
    	$query = "SELECT * FROM ".MF_TABLE_PREFIX."settings";
    	$sth = mf_do_query($query,array(),$dbh);
    	$row = mf_do_fetch_result($sth);
    	return $row;
    }
    
    function mf_format_bytes($bytes) {
		if ($bytes < 1024) return $bytes.' B';
	   	elseif ($bytes < 1048576) return round($bytes / 1024, 2).' KB';
	   	elseif ($bytes < 1073741824) return round($bytes / 1048576, 2).' MB';
	   	elseif ($bytes < 1099511627776) return round($bytes / 1073741824, 2).' GB';
	   	else return round($bytes / 1099511627776, 2).' TB';
	}
	
	function mf_trim_value(&$value){ 
    	$value = trim($value); 
	}
	
	
	
    
?>