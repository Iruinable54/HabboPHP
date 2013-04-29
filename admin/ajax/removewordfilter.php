<?php 
define('RANK','6');
require '../includes/init.php';

$colonne = (EMULATOR == 'phoenix') ? 'wordfilter' : 'room_swearword_filter' ;

if($db->query("DELETE FROM ".$colonne." WHERE word='".safe($_GET['word'],'SQL')."'") AND addLog($user->username,"Remove a banned word (".safe($_GET['word'],'SQL').")")) {
	echo "1";
} else {
	echo "Erreur";
}