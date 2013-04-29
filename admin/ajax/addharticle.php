<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

define('RANK','7');
require '../includes/init.php';

$dbHelp = new Db('habbophp_help_articles');

$data = array(
	'cid' => safe($_POST['cat'],'SQL'),
	'title' => safe($_POST['title'],'SQL'),
	'articles' => safe($_POST['content'],'SQL')
);

if($dbHelp->save($data) AND addLog($user->username,"Add a new article (".safe($_POST['title'],'SQL').") in Help")) {
	echo "1";
}