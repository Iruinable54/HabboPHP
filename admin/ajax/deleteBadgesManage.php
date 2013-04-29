<?php 
define('RANK','6');
require '../includes/init.php';

if(isset($_POST['id']) && is_numeric($_POST['id'])){
	$badgeDb = new Db('habbophp_shop_badges');
	if($badgeDb->delete(safe($_POST['id'],'SQL'))){
		 echo '1' ;
		 addLog($user->username,"Delete badge ID : ".safe($_POST['id'],'SQL')."");
	}
}