<?php 
define('RANK','7');
require '../includes/init.php';

if($db->query("DELETE FROM user_badges WHERE badge_id='".safe($_GET['bid'],'SQL')."' AND user_id='".safe($_GET['uid'],'SQL')."'") AND addLog($user->username,"Delete badge ".safe($_GET['bid'],'SQL')." from user ".safe($_GET['uid'],'SQL')."")) {
	echo "1";
} else {
	echo "Erreur";
}