<?php 
define('RANK','6');
require '../includes/init.php';

$newsDb = new Db('habbophp_news');
if($newsDb->delete(safe($_GET['id'],'SQL')) AND addLog($user->username,"Delete a news")) {
	echo "1";
} else {
	echo "Erreur";
}