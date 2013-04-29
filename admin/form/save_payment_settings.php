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
	
	//sleep(3); //temporary for localhost testing
	if(empty($_POST['payment_properties'])){
		die("Error! You can't open this file directly");
	}
	
	$payment_properties = mf_sanitize($_POST['payment_properties']);
	$field_prices = mf_sanitize($_POST['field_prices']);
	
	$form_id = (int) $payment_properties['form_id'];
	unset($payment_properties['form_id']);
	
	//save payment properties into ap_forms table
	foreach ($payment_properties as $key=>$value){
		$form_input['payment_'.$key] = $value;
	}
	
	mf_ap_forms_update($form_id,$form_input,$dbh);
	
	//save field prices into ap_element_prices table
	$query = "delete from ".MF_TABLE_PREFIX."element_prices where form_id=?";
	$params = array($form_id);
	mf_do_query($query,$params,$dbh);
	
	if(!empty($field_prices)){
		foreach ($field_prices as $element_data){
			if($element_data['element_type'] == 'price'){ //if this is price field
				$query = "insert into ".MF_TABLE_PREFIX."element_prices(form_id,element_id,option_id,`price`) values(?,?,?,?)";
				$params = array($form_id,$element_data['element_id'],$element_data['option_id'],$element_data['price']);
				mf_do_query($query,$params,$dbh);
			}else{
				foreach($element_data as $values){
					$element_id = (int) $values['element_id'];
					
					if(!empty($element_id)){
						$query = "insert into ".MF_TABLE_PREFIX."element_prices(form_id,element_id,option_id,`price`) values(?,?,?,?)";
						$params = array($form_id,$values['element_id'],$values['option_id'],$values['price']);
						mf_do_query($query,$params,$dbh);
					}	
				}
			}	
		}
	}
   
	$_SESSION['MF_SUCCESS'] = 'Payment settings has been saved.';
	
   	echo '{ "status" : "ok", "form_id" : "'.$form_id.'" }';
   
?>