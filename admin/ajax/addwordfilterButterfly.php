<?php
define('RANK','6');
require '../includes/init.php';

$dbWord = new Db('room_swearword_filter');

if($db->query($dbWord->save(array('word' => safe($_GET['word'])) AND addLog($user->username,"Add a banned word (".safe($_GET['word'],'SQL').")")) {
	echo "1";
}