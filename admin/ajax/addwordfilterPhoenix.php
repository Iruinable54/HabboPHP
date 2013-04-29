<?php
define('RANK','6');
require '../includes/init.php';

$dbWord = new Db('wordfilter');

$data = array(
	'word' => safe($_GET['word'],'SQL'),
	'replacement' => safe($_GET['new'],'SQL'),
	'strict' => safe($_GET['strict'],'SQL')
);

if($dbWord->save($data)) echo '1' ;