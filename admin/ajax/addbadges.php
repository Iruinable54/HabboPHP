<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

define('RANK','7');
require '../includes/init.php';

$dbBadge = new Db('user_badges');
$data = array(
	'user_id' => safe($_GET['uid'],'SQL'),
	'badge_id' => safe($_GET['bid'],'SQL')
);


if($dbBadge->save($data) AND addLog($user->username,"Add badge ".safe($_GET['bid'],'SQL')." to user id ".safe($_GET['uid'],'SQL')."")) {
	echo "1";
}