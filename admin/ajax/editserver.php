<?php
define('RANK','7');
require '../includes/init.php';
$i = 0 ;
unset($_GET['token']);
foreach($_GET as $k=>$v){
	$config->editConfig($k,$v); $i++ ;
}

if($i == 4) echo '1' ;
addLog($user->username,"Edit server configuration");
?>