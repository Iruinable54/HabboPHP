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
	
	$dbh = mf_connect_db();
	
	$form_id = (int) $_POST['form_id'];
	$tags	 = mf_sanitize($_POST['tags']);
	$action  = $_POST['action'];
	
	if(empty($form_id) || empty($tags) || empty($action)){
		die('error! missing parameters.');
	}
	
	if($action == 'add'){ //add a new tag name
		//get existing tags for current form
		$query = "SELECT `form_tags` from ".MF_TABLE_PREFIX."forms WHERE form_id=?";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
		if(!empty($row['form_tags'])){
			$current_tags_array = explode(',',$row['form_tags']);
		}
		
		//get the new tag names
		$new_tags_array = explode(',',strtolower($tags));
		array_walk($new_tags_array, 'mf_trim_value');
		
		//merge with the new tag names (comma separated)
		if(!empty($current_tags_array)){
			$merged_tags_array = array_merge($current_tags_array,$new_tags_array);
		}else{
			$merged_tags_array = $new_tags_array;
		}
		
		//remove duplicated tags
		$merged_tags_array = array_unique($merged_tags_array);
		
		sort($merged_tags_array);
		
		//save it into database again
		$merged_tags_joined = implode(',',$merged_tags_array);
		
		$query = "UPDATE ".MF_TABLE_PREFIX."forms SET form_tags = ? WHERE form_id = ?";
		$params = array($merged_tags_joined,$form_id);
		mf_do_query($query,$params,$dbh);
		
		//build the tags markup
		rsort($merged_tags_array);
		foreach ($merged_tags_array as $tagname){
			$tags_markup .= "<li>".htmlspecialchars($tagname)." <a class=\"removetag\" href=\"#\" title=\"Remove this tag.\"><img src=\"images/icons/53.png\" /></a></li>";
		}
	}elseif($action == 'delete'){
		$deleted_tagname = trim($tags);
		
		//get existing tags for current form
		$query = "SELECT `form_tags` from ".MF_TABLE_PREFIX."forms WHERE form_id=?";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$row = mf_do_fetch_result($sth);
		if(!empty($row['form_tags'])){
			$current_tags_array = explode(',',$row['form_tags']);
		}
		
		$updated_tags_array = array_diff($current_tags_array, array($deleted_tagname)); 
		sort($updated_tags_array);
		
		//save it into database again
		$updated_tags_joined = implode(',',$updated_tags_array);
		
		$query = "UPDATE ".MF_TABLE_PREFIX."forms SET form_tags = ? WHERE form_id = ?";
		$params = array($updated_tags_joined,$form_id);
		mf_do_query($query,$params,$dbh);
	}
	
	
	$response_data = new stdClass();
	$response_data->status    	= "ok";
	
	$response_data->form_id 	= $form_id;
	$response_data->tags_markup = $tags_markup;
	$response_json = json_encode($response_data);
	
	echo $response_json;
	
?>