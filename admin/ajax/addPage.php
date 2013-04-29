<?php
require_once('../includes/init.php');

if(isset($_POST['title'])){
	$pageDB = new Db('habbophp_pages');
	if(!isset($_POST['id'])){
		$data = array(
			'title' => safe($_POST['title'],'SQL'),
			'content' => safe($_POST['content'],'SQL')
		);
		addLog($user->username,"Add page '".$data['title']."'");
	}
	else{
		$data = array(
			'id' => safe($_POST['id'],'SQL'),
			'title' => safe($_POST['title'],'SQL'),
			'content' => safe($_POST['content'],'SQL')
		);
		addLog($user->username,"Edit page '".$data['title']."'");
	}
	
	if($pageDB->save($data)) echo '1' ;
}