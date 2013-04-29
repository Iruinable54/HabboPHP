<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
require 'init.php' ;
$tpl->assign('groups','community');
$id=(int) safe($_GET['id'],'HTML');
if(!is_numeric($id) OR empty($id) OR !isset($id))redirection('me.php');
$tpl->assign('formid',$id);

$tpl->display('header.tpl');
$tpl->display('form.tpl');
$tpl->display('footer.tpl');
