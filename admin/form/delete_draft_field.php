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
	
	$dbh = mf_connect_db();
	
	//sleep(1); //temporary for localhost testing
	
	$form_id				= (int) $_POST['form_id'];
	$element_id				= (int) $_POST['element_id']; 
	$element_type			= trim($_POST['element_type']);
	
	if($element_type == 'page_break'){
		//exception for page break, we can ignore the element status, live or draft field can be deleted immediately
		$query  = "delete from `".MF_TABLE_PREFIX."form_elements` where form_id = ? and element_id = ?";
		$params = array($form_id,$element_id);
		
		mf_do_query($query,$params,$dbh);
		
		//after deleting the page break, we need to recalculate the page number field for all existing live field on the form
		$query = "SELECT 
						element_id,element_position 
					FROM 
						".MF_TABLE_PREFIX."form_elements 
				   WHERE 
				   		form_id = ? and element_type='page_break' and element_status=1 
				ORDER BY 
						element_position asc";
		$params = array($form_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		$page_number = 1;
		while($row = mf_do_fetch_result($sth)){
			$page_break_list[$page_number] = $row['element_position'];
			$page_number++;
		}
		
		$total_page = $page_number;
		if(!empty($page_break_list)){
			krsort($page_break_list);
		}
		
		//set the page number of all fields to the highest page number
		$query = "UPDATE 
						".MF_TABLE_PREFIX."form_elements 
					 SET 
						element_page_number = ?
				   WHERE
					    form_id = ? and element_status=1";
		$params = array($total_page,$form_id);
		mf_do_query($query,$params,$dbh);
		
		//then loop through each page break and set the page number of all fields below that page break
		if(!empty($page_break_list)){
			$query = "UPDATE 
							".MF_TABLE_PREFIX."form_elements 
						 SET 
							element_page_number = ?
					   WHERE
						   	form_id = ? and element_status=1 and element_position <= ?";
			foreach ($page_break_list as $page_number=>$position){
				$params = array($page_number,$form_id,$position);
				mf_do_query($query,$params,$dbh);
			}
		}
		
		//update ap_forms page_total
		$query  = "update `".MF_TABLE_PREFIX."forms` set form_page_total = ? where form_id = ?";
		$params = array($total_page,$form_id); 
		mf_do_query($query,$params,$dbh);
		
	}else if($element_type == 'matrix'){
		//delete the main element and all child rows
		$query  = "delete from `".MF_TABLE_PREFIX."form_elements` where form_id = ? and element_id = ? and element_status=2";
		$params = array($form_id,$element_id);
		mf_do_query($query,$params,$dbh);
		
		//get all child ids and delete them from ap_element_options table
		$child_element_ids = array();
		$child_placeholders = array();
		
		$query = "select element_id from `".MF_TABLE_PREFIX."form_elements` where form_id = ? and element_matrix_parent_id = ? and element_type='matrix' and element_status=2";
		$params = array($form_id,$element_id);
		
		$sth = mf_do_query($query,$params,$dbh);
		while($row = mf_do_fetch_result($sth)){
			$child_element_ids[]  = $row['element_id'];
			$child_placeholders[] = '?';	
		}
		
		$child_element_ids[] = $element_id; //delete the first row options as well
		$child_placeholders[] = '?';
		
		$child_placeholders_joined = implode(',',$child_placeholders);
		
		$query = "delete from `".MF_TABLE_PREFIX."element_options` where form_id = ? and live = 2 and element_id in({$child_placeholders_joined})";
		$params = array_merge((array) $form_id,$child_element_ids);
		mf_do_query($query,$params,$dbh);
		
		//delete child rows from ap_form_elements table
		$query = "delete from `".MF_TABLE_PREFIX."form_elements` where form_id = ? and element_matrix_parent_id = ? and element_type='matrix' and element_status=2";
		$params = array($form_id,$element_id);
		mf_do_query($query,$params,$dbh);
	}else{
		$query  = "delete from `".MF_TABLE_PREFIX."form_elements` where form_id = :form_id and element_id = :element_id and element_status=2";
		$params = array(':form_id'=>$form_id,':element_id'=>$element_id);
		
		mf_do_query($query,$params,$dbh);
	}
	

	$response_data = new stdClass();
	
	$response_data->status    	= "ok";
	$response_data->element_id 	= $element_id;
	
	$response_json = json_encode($response_data);
	
	echo $response_json;
	
?>