<?php
require '../init.php';

if(!Validate::ValideInput(array('id' => 'isNumeric')) OR !Validate::ValideInput(array('type' => 'isClean')) OR !Validate::ValideInput(array('design' => 'isClean'))) exit ;

$id=(int) safe($_GET['id'],'SQL'); //id du widget
$type=safe($_GET['type'],'SQL');
$design=safe($_GET['design'],'SQL');

if($design=="w_skin_speechbubbleskin" OR $design=="w_skin_notepadskin" OR $design=="w_skin_goldenskin" OR $design=="w_skin_defaultskin" OR $design=="w_skin_metalskin" OR $design=="w_skin_noteitskin"){
if($user->rank>=6) $db->query("UPDATE habbophp_home_widget SET ".$type."style='".$design."'");
else $db->query("UPDATE habbophp_home_widget SET ".$type."style='".$design."' WHERE userid=".$user->id."");
}