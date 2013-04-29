<?php
require '../init.php';
if(!Validate::ValideInput(array('id' => 'isNumeric','type' => 'isCleanHomeType'))) exit ;
$id=(int) safe($_GET['id'],'SQL'); //id du widget
$type=safe($_GET['type'],'SQL');

$db->query("UPDATE habbophp_home_widget SET ".$type."=1 WHERE id=".$id." AND userid=".$user->id."");