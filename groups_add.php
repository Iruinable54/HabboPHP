<?php
require 'init.php' ;
$tpl->assign('groups','index');
$tpl->display('header.tpl');
$tpl->display('groups_add.tpl');
$tpl->display('footer.tpl');