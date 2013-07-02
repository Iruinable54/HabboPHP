<?php
require '../init.php';
$req = mysql_query('SELECT * FROM habbophp_notifications ORDER BY id DESC LIMIT 1');
$data = mysql_fetch_assoc($req);
if(!isset($_SESSION['notif_'.$data['id']])){
	$json = array();
	$json['title'] = stripcslashes($data['titre']);
	$json['text'] = stripcslashes($data['contenu']);
	Cookie::Set('notif_'.$dataNotif['id'],1);
	echo json_encode($json);
	$_SESSION['notif_'.$data['id']] = 'ok';
}