<?php
header('Content-type: text/css');
define('CORE','CORE');
$admin=true;
include "../../includes/core.php";
$query=mysql_query("SELECT * FROM habbophp_home_backgrounds_list");
while($row=mysql_fetch_array($query)) {
	echo ".b_".$row['class']." { \n";
	//echo "width:".$row['width']."px;\n";
	//echo "height:".$row['height']."px;\n";
	echo "width:1360px;height:927px;background:url(".$config->url_site."/web-gallery/homepage/backgrounds/".$row['image'].");\n";
	echo " }\n";
}