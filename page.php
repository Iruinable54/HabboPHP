<?php
require 'init.php' ;
$tpl->assign('groups','index');

if(!isset($_GET['id']) OR !is_numeric($_GET['id'])) redirection($config->url_site);

$query  = $db->query('select * from habbophp_pages WHERE id="'.safe($_GET['id'],'SQL').'"',true,false);
if ($db->NumRowsC() == 0) redirection($config->url_site);
$tpl->assign('page',$query);

$tpl->display('header.tpl');
$tpl->display('page.tpl');
$tpl->display('footer.tpl');