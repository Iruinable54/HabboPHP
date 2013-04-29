<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/
	
	//check for magic quotes, if on, remove all slashes from input
	function mf_sanitize($input){
		if(get_magic_quotes_gpc() && !empty($input)){
			 $input = is_array($input) ?
	                array_map('mf_stripslashes_deep', $input) :
	                stripslashes($input);
		}
		
		return $input;
	}
	
	function mf_stripslashes_deep($value){
		
	    $value = is_array($value) ?
	                array_map('mf_stripslashes_deep', $value) :
	                stripslashes($value);
	
	    return $value;
	}

?>