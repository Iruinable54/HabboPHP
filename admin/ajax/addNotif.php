<?php
require '../includes/init.php';
if(Tools::checkACL($user->rank,ACL_SITE_NOTIF)) {
	$nDB = new Db('habbophp_notifications');
	$data = array(
		'titre' => safe($_POST['titre']),
		'contenu' => safe($_POST['contenu'])
	);
	$nDB->save($data);
}