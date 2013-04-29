<?php
header('Content-type: text/css');
define('CORE','CORE');
$admin=true;
include "../../includes/core.php";
$query=mysql_query("SELECT * FROM habbophp_home_images_list");
while($row=mysql_fetch_array($query)) {
	echo ".s_".$row['class']." { \n";
	echo "width:".$row['width']."px;\n";
	echo "height:".$row['height']."px;\n";
	echo "background:url(".$config->url_site."/web-gallery/homepage/stickers/".$row['image'].") no-repeat;\n";
	echo " }\n";
}