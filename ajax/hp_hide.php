<?php
require '../init.php';
if(!Validate::ValideInput(array('id' => 'isNumeric','type' => 'isCleanHomeType'))) exit ;
$id=(int) safe($_GET['id'],'SQL'); //id du widget
$type=safe($_GET['type'],'SQL');
if($user->rank>=6){if($db->query("UPDATE habbophp_home_widget SET ".$type."=0 WHERE id=".$id."")) echo'1' ;}else{if(mysql_query("UPDATE habbophp_home_widget SET ".$type."=0 WHERE id=".$id." AND userid=".$user->id."")) echo'1';}