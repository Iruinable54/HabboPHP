<?php

define('RANK','7');
require '../includes/init.php';

$dbCat = new Db('habbophp_help_category');

if($dbCat->save(array('value' => safe($_GET['value']))) AND addLog($user->username,"Add a category (".safe($_GET['value'],'SQL').") in Help")) {
	echo "1";
}