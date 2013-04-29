<?php
session_start();
define('CORE','CORE');
$admin = true ;
require'../includes/core.php';

if(!is_string($_GET['suggestions_query'])) exit ;

$q = safe(safe($_GET['suggestions_query'],'SQL'),'HTML');
$s = explode(" ",$q);
$sql = "SELECT * FROM habbophp_help_articles";
$i = 0 ;
foreach($s as $mot){
	if(strlen($mot) > 3){
		if($i==0){
			$sql.=" WHERE ";
		}
		else{
			$sql.=" OR ";
		}
		$sql.=" articles LIKE '%$mot%'";
		$i++;
	}
}
$req = mysql_query($sql);
$tpl->assign('total_rows',mysql_num_rows($req));
while($data = mysql_fetch_assoc($req)){
	$d[] = $data ;
}
if(isset($d))
$tpl->assign('data',$d);


$tpl->display('help_header.tpl');
$tpl->display('help_search.tpl');
$tpl->display('help_footer.tpl');

?>