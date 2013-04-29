<?php
require '../init.php';

if(!Validate::ValideInput(array('id' => 'isNumeric','type' => 'isCleanHomeType')))  exit ;

$id=(int) safe($_GET['id'],'SQL');
$type=safe($_GET['type'],'SQL');

if($type=="note") $table="habbophp_home_notes";
elseif($type=="image") $table="habbophp_home_images";
elseif($type=="widget") $table="habbophp_home_widget";
else exit();

if($user->rank>=6) {
$db->query("DELETE FROM ".$table." WHERE id=".$id."");
}
else {
$db->query("DELETE FROM ".$table." WHERE id=".$id." AND userid=".$user->id."");
}