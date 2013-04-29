<?php
	require '../../../../init.php';
	if(!isset($_POST['groupId']) or !is_numeric($_POST['groupId'])) exit ;
	if(!isset($_POST['code'])) exit ;
	$Groups = new Groups(array('groupid' => intval($_POST['groupId']) , 'badge' => $_POST['code']));
	if(!$Groups->Exist()) exit ;
	$Groups->editBadge();
	header('Location:'.$config->url_site.'/groups.php?id='.$_POST['groupId']);

?>