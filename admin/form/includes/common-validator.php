<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/
	
	//validation for required field
	function mf_validate_required($value){
		global $mf_lang;

		$value = $value[0]; 
		if(empty($value) && (($value != 0) || ($value != '0'))){ //0  and '0' should not considered as empty
			return $mf_lang['val_required'];
		}else{
			return true;
		}
	}	
	
	//validation for unique checking on db table
	function mf_validate_unique($value){
		global $mf_lang;

		$input_value  = $value[0]; 
	
		$exploded = explode('#',$value[1]);
		$form_id  = $exploded[0];
		$element_name = $exploded[1];
		
		$dbh = $value[2]['dbh'];
		
		if(!empty($_SESSION['edit_entry']) && ($_SESSION['edit_entry']['form_id'] == $form_id)){
			//if admin is editing through edit_entry.php, bypass the unique checking if the new entry is the same as previous
			$query = "select count($element_name) total from ".MF_TABLE_PREFIX."form_{$form_id} where {$element_name}=? and `id` != ?";
			$params = array($input_value,$_SESSION['edit_entry']['entry_id']);
			
			$sth = mf_do_query($query,$params,$dbh);
			$row = mf_do_fetch_result($sth);
		}else{
			$query = "select count($element_name) total from ".MF_TABLE_PREFIX."form_{$form_id} where {$element_name}=? ";
			$params = array($input_value);
			
			$sth = mf_do_query($query,$params,$dbh);
			$row = mf_do_fetch_result($sth);
		}
		
		if(!empty($row['total'])){ 
			return $mf_lang['val_unique'];
		}else{
			return true;
		}
	}	
	
		
	//validation for integer
	function mf_validate_integer($value){
		global $mf_lang;

		$error_message = $mf_lang['val_integer'];
		
		$value = $value[0];
		if(is_int($value)){
			return true; //it's integer
		}else if(is_float($value)){
			return $error_message; //it's float
		}else if(is_numeric($value)){
			$result = strpos($value,'.');
			if($result !== false){
				return $error_message; //it's float
			}else{
				return true; //it's integer
			}
		}else{
			return $error_message; //it's not even a number!
		}
	}
	
	//validation for float aka double
	function mf_validate_float($value){
		global $mf_lang;

		$error_message = $mf_lang['val_float'];
		
		$value = $value[0];
		if(is_int($value)){
			return $error_message; //it's integer
		}else if(is_float($value)){
			return true; //it's float
		}else if(is_numeric($value)){
			$result = strpos($value,'.');
			if($result !== false){
				return true; //it's float
			}else{
				return $error_message; //it's integer
			}
		}else{
			return $error_message; //it's not even a number!
		}
	}
	
	//validation for numeric
	function mf_validate_numeric($value){
		global $mf_lang;

		$error_message = $mf_lang['val_numeric'];
				
		$value = $value[0];
		if(is_numeric($value)){
			return true;
		}else{
			return $error_message;
		}
		
	}
	
	//validation for phone (###) ### ####
	function mf_validate_phone($value){
		global $mf_lang;

		$error_message = $mf_lang['val_phone'];
		
		if(!empty($value[0])){
			$regex  = '/^[1-9][0-9]{9}$/';
			$result = preg_match($regex, $value[0]);
			
			if(empty($result)){
				return $error_message;
			}else{
				return true;
			}
		}else{
			return true;
		}
		
	}
	
	//validation for simple phone, international phone
	function mf_validate_simple_phone($value){
		global $mf_lang;

		$error_message = $mf_lang['val_phone'];
		
		if($value[0]{0} == '+'){
			$test_value = substr($value[0],1);
		}else{
			$test_value = $value[0];
		}
		
		if(is_numeric($test_value) && (strlen($test_value) > 3)){
			return true;
		}else{
			return $error_message;
		}
	}
	
	//validation for minimum length
	function mf_validate_min_length($value){
		global $mf_lang;

		$target_value = $value[0];
		$exploded 	  = explode('#',$value[1]);
		
		$range_limit_by = $exploded[0];
		$range_min		= (int) $exploded[1];
		
		if($range_limit_by == 'c' || $range_limit_by == 'd'){
			$target_length = strlen($target_value);
		}elseif ($range_limit_by == 'w'){
			$target_length = count(preg_split("/[\s\.]+/", $target_value, NULL, PREG_SPLIT_NO_EMPTY));
		}
		
		if($target_length < $range_min){
			return 'error_no_display';
		}else{
			return true;
		}
	}
	
	//validation for number minimum value
	function mf_validate_min_value($value){
		global $mf_lang;

		$target_value = (int) $value[0];
		$range_min	  = (int) $value[1];
		
		if($target_value < $range_min){
			return 'error_no_display';
		}else{
			return true;
		}
	}
	
	//validation for maximum length
	function mf_validate_max_length($value){
		global $mf_lang;

		$target_value = $value[0];
		$exploded 	  = explode('#',$value[1]);
		
		$range_limit_by = $exploded[0];
		$range_max		= (int) $exploded[1];
		
		if($range_limit_by == 'c' || $range_limit_by == 'd'){
			$target_length = strlen($target_value);
		}elseif ($range_limit_by == 'w'){
			$target_length = count(preg_split("/[\s\.]+/", $target_value, NULL, PREG_SPLIT_NO_EMPTY));
		}
		
		if($target_length > $range_max){
			return 'error_no_display';
		}else{
			return true;
		}
	}
	
	//validation for number minimum value
	function mf_validate_max_value($value){
		global $mf_lang;

		$target_value = (int) $value[0];
		$range_max	  = (int) $value[1];
		
		if($target_value > $range_max){
			return 'error_no_display';
		}else{
			return true;
		}
	}
	
	//validation for range length
	function mf_validate_range_length($value){
		global $mf_lang;

		$target_value = $value[0];
		$exploded 	  = explode('#',$value[1]);
		
		$range_limit_by = $exploded[0];
		$range_min		= (int) $exploded[1];
		$range_max		= (int) $exploded[2];
		
		if($range_limit_by == 'c' || $range_limit_by == 'd'){
			$target_length = strlen($target_value);
		}elseif ($range_limit_by == 'w'){
			$target_length = count(preg_split("/[\s\.]+/", $target_value, NULL, PREG_SPLIT_NO_EMPTY));
		}
		
		if(!($range_min <= $target_length && $target_length <= $range_max)){
			return 'error_no_display';
		}else{
			return true;
		}
	}
	
	//validation for number range value
	function mf_validate_range_value($value){
		global $mf_lang;

		$target_value = (int) $value[0];
		$exploded 	  = explode('#',$value[1]);
		
		$range_min		= (int) $exploded[0];
		$range_max		= (int) $exploded[1];
		
		if(!($range_min <= $target_value && $target_value <= $range_max)){
			return 'error_no_display';
		}else{
			return true;
		}
	}
	
	//validation to check email address format
	function mf_validate_email($value) {
		global $mf_lang;

		$error_message = $mf_lang['val_email'];
		
		if(!empty($value[0])){
			$regex  = '/^[A-z0-9][\w.-]*@[A-z0-9][\w\-\.]*\.[A-z0-9]{2,6}$/';
			$result = preg_match($regex, $value[0]);
			
			if(empty($result)){
				return sprintf($error_message,'%s',$value[0]);
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
	
	//validation to check URL format
	function mf_validate_website($value) {
		global $mf_lang;

		$error_message = $mf_lang['val_website'];
		$value[0] = $value[0].'/';
		
		if(!empty($value[0]) && ($value[0] != '/')){
			$regex  = '/^https?:\/\/([a-z0-9]([-a-z0-9]*[a-z0-9])?\.)+((a[cdefgilmnoqrstuwxz]|aero|arpa)|(b[abdefghijmnorstvwyz]|biz)|(c[acdfghiklmnorsuvxyz]|cat|com|coop)|d[ejkmoz]|(e[ceghrstu]|edu)|f[ijkmor]|(g[abdefghilmnpqrstuwy]|gov)|h[kmnrtu]|(i[delmnoqrst]|info|int)|(j[emop]|jobs)|k[eghimnprwyz]|l[abcikrstuvy]|(m[acdghklmnopqrstuvwxyz]|mil|mobi|museum)|(n[acefgilopruz]|name|net)|(om|org)|(p[aefghklmnrstwy]|pro)|qa|r[eouw]|s[abcdeghijklmnortvyz]|(t[cdfghjklmnoprtvwz]|travel)|u[agkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw])(\/)(.*)$/i';
			$result = preg_match($regex, $value[0]);
			
			if(empty($result)){
				return sprintf($error_message,'%s',$value[0]);
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
	
	//validation to allow only a-z 0-9 and underscores 
	function mf_validate_username($value){
		global $mf_lang;

		$error_message = $mf_lang['val_username'];
		
		if(!preg_match("/^[a-z0-9][\w]*$/i",$value[0])){
			return sprintf($error_message,'%s',$value[0]);
		}else{
			return true;
		}
	}
	
	
	
	//validation to check two variable equality. usefull for checking password 
	function mf_validate_equal($value){
		global $mf_lang;

		$error_message = $mf_lang['val_equal'];
		
		if($value[0] != $value[2][$value[1]]){
			return $error_message;
		}else{
			return true;
		}
	}
	
	//validate date format
	//currently only support this format: mm/dd/yyyy or mm-dd-yyyy, yyyy/mm/dd or yyyy-mm-dd
	function mf_validate_date($value) {
		global $mf_lang;

		$error_message = $mf_lang['val_date'];
		
		if(!empty($value[0])){
			if($value[1] == 'yyyy/mm/dd'){
				$regex = "/^([1-9][0-9])\d\d[-\/](0?[1-9]|1[012])[-\/](0?[1-9]|[12][0-9]|3[01])$/";
			}elseif($value[1] == 'mm/dd/yyyy'){
				$regex = "/^(0[1-9]|1[012])[-\/](0[1-9]|[12][0-9]|3[01])[-\/](19|20)\d\d$/";
			}
			
			$result = preg_match($regex, $value[0]);
		}
		
		
		if(empty($result)){
			return sprintf($error_message,'%s',$value[1]);
		}else{
			return true;
		}
	}
	
	//validate date range
	function mf_validate_date_range($value){
		global $mf_lang;

		$error_message = $mf_lang['val_date_range'];
		
		$target_value = strtotime($value[0]);
		$exploded 	  = explode('#',$value[1]);
		
		$range_min		= strtotime($exploded[0]);
		$range_max		= strtotime($exploded[1]);
		
		$range_min_formatted = date('M j, Y',$range_min);
		$range_max_formatted = date('M j, Y',$range_max);
		
		if(!empty($range_min) && !empty($range_max)){
			if(!($range_min <= $target_value && $target_value <= $range_max)){
				$error_message = $mf_lang['val_date_range'];
				return sprintf($error_message,$range_min_formatted,$range_max_formatted);
			}
		}else if(!empty($range_min)){
			if($target_value < $range_min){
				$error_message = $mf_lang['val_date_min'];
				return sprintf($error_message,$range_min_formatted);
			}
		}else if (!empty($range_max)){
			if($target_value > $range_max){
				$error_message = $mf_lang['val_date_max'];
				return sprintf($error_message,$range_max_formatted);
			}
		}
		
		return true;
	}
	
	function mf_validate_disabled_dates($value){
		global $mf_lang;

		$error_message = $mf_lang['val_date_na'];
		
		$target_value   = $value[0];
		$disabled_dates = $value[1];
		
		if(in_array($target_value,$disabled_dates)){
			return $error_message;
		}else{
			return true;
		}
	}
	
	//check if a date is a weekend date or not
	function mf_validate_date_weekend($value){
		global $mf_lang;

		$error_message = $mf_lang['val_date_na'];
		
		$target_value   = $value[0];
		
		if(date('N', strtotime($target_value)) >= 6){
			return $error_message;
		}else{
			return true;
		}
	}
	
	//validation to check valid time format 
	function mf_validate_time($value){
		global $mf_lang;

		$error_message = $mf_lang['val_time'];
		
		$timestamp = strtotime($value[0]);
		
		if($timestamp == -1 || $timestamp === false){
			return $error_message;
		}else{
			return true;
		}
	}
	
	
	//validation for required file
	function mf_validate_required_file($value){
		global $mf_lang;

		$error_message = $mf_lang['val_required_file'];
		$element_file = $value[0];
		
		if($_FILES[$element_file]['size'] > 0){
			return true;
		}else{
			return $error_message;
		}
	}
	
	//validation for file upload filetype
	function mf_validate_filetype($value){
		global $mf_lang;

		$file_rules = $value[2];
		
		$error_message = $mf_lang['val_filetype'];
		$value = $value[0];
		
		$ext = pathinfo(strtolower($_FILES[$value]['name']), PATHINFO_EXTENSION);
		
		if(!empty($file_rules['file_type_list'])){
			
			$file_type_array = explode(',',$file_rules['file_type_list']);
			array_walk($file_type_array,create_function('&$val','$val = strtolower(trim($val));'));
			
			if($file_rules['file_block_or_allow'] == 'b'){
				if(in_array($ext,$file_type_array)){
					return $error_message;
				}	
			}else if($file_rules['file_block_or_allow'] == 'a'){
				if(!in_array($ext,$file_type_array)){
					return $error_message;
				}
			}
		}
		
		
		return true;
	}
	
	/*********************************************************
	* This is main validation function
	* This function will call sub function, called validate_xx
	* Each sub function is specific for one rule
	*
	* Syntax: $rules[field_name][validation_type] = value
	* validation_type: required,integer,float,min,max,range,email,username,equal,date
	* Example rules:
	*
	* $rules['author_id']['required'] = true; //author_id is required
	* $rules['author_id']['integer']  = true; //author_id must be an integer
	* $rules['author_id']['range']    = '2-10'; //author_id length must be between 2 - 10 characters
	*
	**********************************************************/
	function mf_validate_rules($input,$rules){
		global $mf_lang;

		//traverse for each input, check for rules to be applied
		foreach ($input as $key=>$value){
			$current_rules = @$rules[$key];
			$error_message = array();
			
			if(!empty($current_rules)){
				//an input can be validated by many rules, check that here
				foreach ($current_rules as $key2=>$value2){
					$argument_array = array($value,$value2,$input);
					$result = call_user_func('mf_validate_'.$key2,$argument_array);
					
					if($result !== true){ //if we got error message, break the loop
						$error_message = $result;
						break;
					}
				}
			}
			if(count($error_message) > 0){
				$total_error_message[$key] = $error_message;
			}
		}
		
		if(@is_array($total_error_message)){
			return $total_error_message;
		}else{
			return true;
		}
	}
	
	//similar as function above, but this is specific for validating form inputs, with only one error message per input
	function mf_validate_element($input,$rules){
		global $mf_lang;
		
		//traverse for each input, check for rules to be applied
		foreach ($input as $key=>$value){
			$current_rules = @$rules[$key];
			$error_message = array();
			
			if(!empty($current_rules)){
				//an input can be validated by many rules, check that here
				foreach ($current_rules as $key2=>$value2){
					$argument_array = array($value,$value2,$input);
					$result = call_user_func('mf_validate_'.$key2,$argument_array);
					
					if($result !== true){ //if we got error message, break the loop
						$error_message = $result;
						break;
					}
				}
			}
			if(count($error_message) > 0){
				$last_error_message = $error_message;
				break;
			}
		}
		
		if(!empty($last_error_message)){
			return $last_error_message;
		}else{
			return true;
		}
	}
?>