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
if(isset($_POST['submit'])){
	if($user->getJetons() >= $config->winwinprix){
		$user->addWinWin($config->winwin);
		$user->deleteJetons($config->winwinprix);
		$tpl->assign('success','true');
	}else $tpl->assign('errorPrix','true');
}

$tpl->display('header.tpl');
$tpl->display('winwin.tpl');
$tpl->display('footer.tpl');

?>