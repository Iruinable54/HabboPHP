<?php 
define('RANK','6');
require '../includes/init.php';

$userDB = new Db('habbophp_news');

$_POST['shortdesc'] = str_replace('script','',$_POST['shortdesc']);
$_POST['content'] = str_replace('script','',$_POST['content']);

$data = array(
	'id' => safe($_POST['id'],'SQL'),
	'title' => safe($_POST['title'],'SQL'),
	'short' => safe($_POST['shortdesc'],'SQL'),
	'content' => safe($_POST['content'],'SQL')
);

if($userDB->save($data)) echo '1' ;
addLog($user->username,"Edit news ".safe($_POST['title'],'SQL')."");