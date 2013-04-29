<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require'init.php';


$tpl->assign('jetons',$user->getJetons());
$tpl->assign('groups','shop');
$tpl->assign('token',Tools::generate_token());

$raresData = $db->query('SELECT * FROM habbophp_shop_rares',true);

$tpl->assign('Rares',$raresData);

$tpl->display('header.tpl');
$tpl->display('rares.tpl');
$tpl->display('footer.tpl');
