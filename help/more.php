<?php
session_start();
define('CORE','CORE');
$admin = true ;
require'../includes/core.php';


if(isset($_GET['id']) && empty($_GET['id']) OR !is_numeric($_GET['id']))
	header('Location:/');
	
$query=mysql_query("SELECT * FROM habbophp_help_articles WHERE id=".safe($_GET['id'],'SQL')."");
$row=mysql_fetch_array($query);

$tpl->assign("title",$row['title'],true);
$tpl->assign("content",$row['articles'],true);


$tpl->display('help_header.tpl');
$tpl->display('help_more.tpl');
$tpl->display('help_footer.tpl');

?>