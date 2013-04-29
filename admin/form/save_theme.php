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
	require('includes/theme-functions.php');
		
	$dbh = mf_connect_db();
	$mf_settings = mf_get_settings($dbh);
	
	//sleep(3); //temporary for localhost testing
	if(empty($_POST['tp'])){
		die("Error! You can't open this file directly");
	}
	
	$theme_properties = mf_sanitize($_POST['tp']);
	$theme_id = (int) $theme_properties['theme_id'];
	
	unset($theme_properties['theme_id']);
	
	if(empty($theme_id)){
		$is_new_theme = true;
	}else{
		$is_new_theme = false;
	}
	 
	
	//If this is new theme, insert new record into the table
   	if($is_new_theme){
   		
   		$theme_properties['status'] = 1;
   		
   		//dynamically create the field list and field values, based on the input given
		$params = array();
		foreach ($theme_properties as $key=>$value){
			$field_list    .= "`{$key}`,";
			$field_values  .= ":{$key},";
			$params[':'.$key] = $value;
		}
		
		$field_list = rtrim($field_list,',');
		$field_values = rtrim($field_values,',');
		
		//insert into ap_form_themes  table
		$query = "INSERT INTO `".MF_TABLE_PREFIX."form_themes` ($field_list) VALUES ($field_values);"; 
		mf_do_query($query,$params,$dbh);
		
		$theme_id = (int) $dbh->lastInsertId();
   		
   	}else{ //If this is old theme, update the data
   		mf_ap_form_themes_update($theme_id,$theme_properties,$dbh);

   		//if the theme is being deleted (status=0)
   		//we need to update ap_forms table and update all forms which use the deleted theme
   		$theme_status = (int) $theme_properties['status'];
   		if(empty($theme_status)){
   			$query = "update ".MF_TABLE_PREFIX."forms set form_theme_id=0 where form_theme_id=?";
   			$params = array($theme_id);
   			mf_do_query($query,$params,$dbh);
   		}
   	}
	
   	//create/update the CSS file for the theme
	$css_theme_filename = $mf_settings['data_dir']."/themes/theme_{$theme_id}.css";
	$css_theme_content  = mf_theme_get_css_content($dbh,$theme_id);
	
	$fpc_result = @file_put_contents($css_theme_filename,$css_theme_content);
	
	if(empty($fpc_result)){ //if we're unable to write into the css file, set the 'theme_has_css' to 0
		$params = array(0,$theme_id);
	}else{
		$params = array(1,$theme_id);
	}
	$query = "UPDATE ".MF_TABLE_PREFIX."form_themes SET theme_has_css = ? WHERE theme_id = ?";
	mf_do_query($query,$params,$dbh);
	
	
   	if(!empty($theme_id)){
   		echo '{ "status" : "ok", "theme_id" : "'.$theme_id.'" }';
   	}else{
   		echo '{ "status" : "error", "message" : "Unable to save theme." }';
   	}
	
?>