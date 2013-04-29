<?php 
define('RANK','7');
require '../includes/init.php';

if($db->query("DELETE FROM bans WHERE id='".safe($_POST['id'],'SQL')."'") AND addLog($user->username,"Remove a ban")) echo '1' ;