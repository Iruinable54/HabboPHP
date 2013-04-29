<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require'init.php';

$tpl->assign('groups','shop');
$badgeData = $db->query('SELECT * FROM habbophp_shop_badges',true);

$tpl->assign('token',Tools::generate_token());
$tpl->assign('badges',$badgeData);

$tpl->display('header.tpl');
$tpl->display('badges.tpl');	
$tpl->display('footer.tpl');

?>