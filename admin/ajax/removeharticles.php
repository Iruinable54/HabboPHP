<?php 
define('RANK','7');
require '../includes/init.php';

if(mysql_query("DELETE FROM habbophp_help_articles WHERE id='".safe($_GET['id'],'SQL')."'") AND addLog($user->username,"Delete a article from help")) {
	echo "1";
} else {
	echo "Erreur";
}