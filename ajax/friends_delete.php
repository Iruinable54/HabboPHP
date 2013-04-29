<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require '../init.php' ;


if(EMULATOR == 'phoenix'){
if(!is_numeric($_GET['oid']) OR !is_numeric($_GET['tid']))exit ;
$oid = (is_numeric($_GET['oid'])) ? safe($_GET['oid'],'SQL') : '' ;
$tid = (is_numeric($_GET['tid'])) ? safe($_GET['tid'],'SQL') : '' ;
$delete = $user->deleteFriends(array('oid' => $oid,'tid' => $tid));
}
else{
	if(!is_numeric($_GET['id'])) exit ;
	$id = (is_numeric($_GET['id'])) ? safe($_GET['id'],'SQL') : '' ;
	$delete = $user->deleteFriends(array('id' => $id));
}

if($delete) echo '1' ;


//$req = $db->query('DELETE FROM messenger_friendships WHERE user_one_id="'.$oid.'" AND user_two_id="'.$tid.'"');
//$req2 = $db->query('DELETE FROM messenger_friendships WHERE user_two_id="'.$oid.'" AND user_one_id="'.$tid.'"');

?>