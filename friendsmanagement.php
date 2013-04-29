<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require 'init.php' ;

$FriendsList = $user->getListFriends();

$tpl->assign('token',Tools::generate_token());
$tpl->assign('friends',$FriendsList);
$tpl->assign('groups','index');
$tpl->display('header.tpl');
$tpl->display('friendsmanagement-'.EMULATOR.'.tpl');
$tpl->display('footer.tpl');
?>