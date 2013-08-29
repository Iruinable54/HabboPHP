<?php 
define('RANK','5');
require '../includes/init.php';

if(Tools::checkACL($user->rank,ACL_SITE_NEWS_POST)) {

if(isset($_POST['title'])){
$_POST['shortdesc'] = str_replace('script','',$_POST['shortdesc']);
$_POST['content'] = str_replace('script','',$_POST['content']);
if($db->query("INSERT INTO habbophp_news VALUES ('',
'".safe($_POST['title'],'SQL')."',
'".safe($_POST['shortdesc'],'SQL')."',
'".safe($_POST['content'],'SQL')."',
'".safe($_POST['image'],'SQL')."'
, '".date('Y-m-d H:i:s')."',
'".safe($_POST['comment'],'SQL')."',
'".safe($_POST['button_texte'],'SQL')."'
,'".safe($_POST['button_display'],'SQL')."',
'".safe($_POST['button_link'],'SQL')."')")

AND addLog($user->username,"Add a news (".safe($_POST['title'],'SQL').")")) {
	echo "1";
}

}

}