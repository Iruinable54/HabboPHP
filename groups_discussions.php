<?php
require 'init.php' ;

$tpl->assign('groups','index');


$Groups = new Groups(array(
	'groupid' => intval($_GET['id'])
));

$Rooms = new Rooms();

if(!$Groups->Exist()){
	redirection($config->url_site);
}

$GroupsInfo = $Groups->getInfo() ;

$tpl->assign('Groups',$GroupsInfo);
$tpl->assign('Rooms_groups',$Rooms->getRoomsUser($GroupsInfo['username']));
$tpl->assign('Membres',$Groups->getGroupsMemberships());


//print_r($Groups->getGroupsMemberships());

$tpl->display('header.tpl');
$tpl->display('groups_discussions.tpl');
$tpl->display('footer.tpl');

