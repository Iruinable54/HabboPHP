<?php 

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

define('RANK','7');
require '../includes/init.php';

$badgesDB = new Db('habbophp_shop_badges');
$data = array(
	'idbadge' => safe($_POST['idbadge'],'SQL'),
	'amount' => safe($_POST['amount'],'SQL')
);
addLog($user->username,"Add badge '".$data['idbadge']."'");
if($badgesDB->save($data)){ echo mysql_insert_id(); }