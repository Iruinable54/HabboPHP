<?php
session_start();
define('CORE','CORE');
$admin=true;
include("../../includes/core.php");
if(!$Auth->isConnected()) redirection('/logout.php');
if($user->rank<7) exit();
$ii=0;
$query=$db->quert("SELECT * FROM habbophp_shop_stats ORDER BY id DESC LIMIT 15",true); 
foreach($query as $row) {
	echo ''.date("Y, m, d", strtotime($row['date'])).';'.$row['value'].'\n';
}
