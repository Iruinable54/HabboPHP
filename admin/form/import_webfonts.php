<?php
/********************************************************************************
 MachForm
  
 Copyright 2007-2012 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ********************************************************************************/
 
	/**
	 * This script is being used to import Google Web Fonts list into "ap_fonts" table
	 * Get the list of the font by getting the content of this URL: 
	 * https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=AIzaSyAeqnpk2UnM3za8OQ7vcGa6TvLRb8DIZtg
	 * 
	 * put the content of that URL into webfonts.txt and then run this script.
	 * Make sure to truncate table ap_fonts first.
	 */

	require('includes/init.php');
	
	require('config.php');
	require('includes/db-core.php');
	require('includes/helper-functions.php');
	require('includes/check-session.php');
	
	if(empty($_GET['run'])){
		die("Error. You need to use this URL: import_webfonts.php?run=1");
	}

	$file_content = file_get_contents('webfonts.txt');
	$json_data = json_decode($file_content);
	
	$dbh = mf_connect_db();
	
	$font_items = $json_data->items;
	$i=1;
	
	$query = "INSERT INTO ".MF_TABLE_PREFIX."fonts(font_origin,font_family,font_variants,font_variants_numeric) values(?,?,?,?)";
	
	foreach ($font_items as $font){
		echo "------ Font #{$i} ----------\n";
		echo $font->family."\n";
		
		$variant_numeric = array();
		foreach ($font->variants as $variant){
			echo $variant."\n";
			
			switch($variant){
				case 'regular' : $variant_numeric[] = '400'; break;
				case 'italic'  : $variant_numeric[] = '400-italic'; break;
				case 'bold'	   : $variant_numeric[] = '700'; break;
				case 'bolditalic' : $variant_numeric[] = '700-italic'; break;
				case '100italic' : $variant_numeric[] = '100-italic'; break;
				case '200italic' : $variant_numeric[] = '200-italic'; break;
				case '300italic' : $variant_numeric[] = '300-italic'; break;
				case '400italic' : $variant_numeric[] = '400-italic'; break;
				case '500italic' : $variant_numeric[] = '500-italic'; break;
				case '600italic' : $variant_numeric[] = '600-italic'; break;
				case '700italic' : $variant_numeric[] = '700-italic'; break;
				case '800italic' : $variant_numeric[] = '800-italic'; break;
				default: $variant_numeric[] = $variant;break;
			}
		
		}
		echo "Saving into table.....\n";
		$variant_imploded = implode(',',$font->variants);	
		$variant_numeric_imploded = implode(',',$variant_numeric);
		
		$params = array('google',$font->family,$variant_imploded,$variant_numeric_imploded);
		
		mf_do_query($query,$params,$dbh);
		
		echo "\n\n";
		$i++;
	}

?>