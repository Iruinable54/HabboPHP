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
	
	//get the font list parameter
	$start_font_id = (int) $_POST['start_id'];
	$list_length   = (int) $_POST['list_length'];
	
	//create the list markup
	$query = "SELECT 
					font_id,font_family,font_variants,font_variants_numeric 
				FROM 
					".MF_TABLE_PREFIX."fonts 
			   WHERE 
			   		font_id >= ? and font_id < ? 
			ORDER BY 
			   		font_id";
	$end_font_id = $start_font_id + $list_length;
	$params = array($start_font_id,$end_font_id);
	
	$sth = mf_do_query($query,$params,$dbh);
	
	$font_list_markup = '';
	$font_styles = array();
	$font_css_markup = '';
	$font_css_array = array();
	
	while($row = mf_do_fetch_result($sth)){
		$encoded_font_family = urlencode($row['font_family']);
		
		$markup =<<<EOT
					<li data-fontid="{$row['font_id']}">
						<div class="font_picker_preview" style="font-family: '{$row['font_family']}',Arial;">{$row['font_family']}</div>
						<div class="font_picker_meta">
							<div class="font_name">{$row['font_family']}</div>
							<div class="font_info">Google Web Font</div>
							<div class="font_icon"><a href="http://www.google.com/webfonts/specimen/{$encoded_font_family}" target="_blank"><img src="images/icons/70.png" class="img-font-icon" /></a></div>
						</div>
					</li>
EOT;
			
		$font_list_markup .= $markup;
		
		//get the styles for each font and store them into array
		$font_variants = array();
		$font_variants_pair = array();
		
		$font_variants = explode(',',$row['font_variants_numeric']);
		foreach ($font_variants as $font_variant_raw){
			$font_variant_raw_exploded = explode('-',$font_variant_raw);
			
			if($font_variant_raw_exploded[1] == 'italic'){
				$secondary_style = ' Italic';
			}else{
				$secondary_style = '';
			}
			
			switch($font_variant_raw_exploded[0]){
				case '100' : $primary_style = 'Ultra-Light';break;
				case '200' : $primary_style = 'Light';break;
				case '300' : $primary_style = 'Book';break;
				case '400' : $primary_style = 'Normal';break;
				case '500' : $primary_style = 'Medium';break;
				case '600' : $primary_style = 'Semi-Bold';break;
				case '700' : $primary_style = 'Bold';break;
				case '800' : $primary_style = 'Extra-Bold';break;
			}
			
			$font_variants_pair[$font_variant_raw] = $primary_style.$secondary_style;
		}
		
		$font_family_slug = strtolower(str_replace(' ','',$row['font_family']));
		$font_data[$font_family_slug] = $font_variants_pair;
		
		//build the css markup for each font
		$font_css_array[] = urlencode($row['font_family']).":".$row['font_variants'];
		
	}
	
	$font_css_markup = implode('|',$font_css_array);
	$font_css_markup = "<link href='http://fonts.googleapis.com/css?family={$font_css_markup}' rel='stylesheet' type='text/css'>\n";
	
	//determine if the font list is reaching the end or not
	$query = "select max(font_id) max_font_id from ".MF_TABLE_PREFIX."fonts";
	$params = array();
	$sth = mf_do_query($query,$params,$dbh);
	$row = mf_do_fetch_result($sth);
	
	if($end_font_id > $row['max_font_id']){
		$list_end = true;
	}else{
		$list_end = false;
	}
	
	
	//send the final markup and data
	$response_data = new stdClass();
	
	$response_data->status    	 = "ok";
	$response_data->markup    	 = $font_list_markup;
	$response_data->last_font_id = $end_font_id - 1; 
	$response_data->list_end	 = $list_end;
	$response_data->font_styles	 = $font_data;
	$response_data->font_css_markup	 = $font_css_markup;
	
	$response_json = json_encode($response_data);
	
	echo $response_json;
?>