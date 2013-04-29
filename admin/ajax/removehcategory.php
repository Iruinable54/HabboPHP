<?php 
define('RANK','7');
require '../includes/init.php';

if(mysql_query("DELETE FROM habbophp_help_category WHERE id='".safe($_GET['id'],'SQL')."'") AND addLog($user->username,"Delete a category from help")) {
	echo "1";
} else {
	echo "Erreur";
}