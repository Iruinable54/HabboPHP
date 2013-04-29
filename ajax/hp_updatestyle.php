<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
require '../init.php';


$x=(int) safe($_GET['x'],'SQL'); //left
$y=(int) safe($_GET['y'],'SQL'); //top
$z=(int) safe($_GET['z'],'SQL'); //z-index
$id=(int) safe($_GET['id'],'SQL'); //id du widget
$type=safe($_GET['type'],'SQL');
$wid=safe($_GET['wid'],'SQL');

if(!Validate::ValideInput(array('x' => 'isCleanPx','y' => 'isCleanPx','z' => 'isCleanPx','type' => 'isCleanHomeType','wid' => 'isClean'))) exit ;

if($type=="image"){
if($user->rank>=6) $db->query("UPDATE habbophp_home_images SET x=".$x.", y=".$y.", z=".$z." WHERE id=".$id."") ;
else $db->query("UPDATE habbophp_home_images SET x=".$x.", y=".$y.", z=".$z." WHERE userid=".$user->id." AND id=".$id."") ;
}

if($type=="note"){
if($user->rank>=6) $db->query("UPDATE habbophp_home_notes SET x=".$x.", y=".$y.", z=".$z." WHERE id=".$id."");
else $db->query("UPDATE habbophp_home_notes SET x=".$x.", y=".$y.", z=".$z." WHERE userid=".$user->id." AND id=".$id."");
}

if($type=="widget"){
if($user->rank>=6) $db->query("UPDATE habbophp_home_widget SET ".$wid."x=".$x.", ".$wid."y=".$y.", ".$wid."z=1 WHERE id=".$id."");
else $db->query("UPDATE habbophp_home_widget SET ".$wid."x=".$x.", ".$wid."y=".$y.", ".$wid."z=1 WHERE userid=".$user->id." AND id=".$id."");
}