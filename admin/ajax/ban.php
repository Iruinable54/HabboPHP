<?php
define('RANK','6');
require '../includes/init.php';

if($_GET['type'] == 'ip'){
$data = $db->query("SELECT ip_reg FROM users WHERE username = '".safe($_GET['value'],'SQL')."'",true,false);
$_GET['value'] = $data['ip_reg'];
}

$data = array(
	'bantype' => safe($_GET['type'],'SQL'),
	'value' => safe($_GET['value'],'SQL'),
	'reason' => safe($_GET['reason'],'SQL'),
	'expire' => time() + safe($_GET['duree'],'SQL'),
	'added_by' => safe($user->username),
	'added_date' => date('Y-m-d'),
	'appeal_state' => 0
);

$banManager = new Db('bans');
if($banManager->save($data)) echo '1' ;
addLog($user->username,"Ban ".safe($_GET['type'],'SQL')." : ".safe($_GET['value'],'SQL')."");