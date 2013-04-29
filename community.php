<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
define('AUTH','AUTH');
require 'init.php' ;

$tpl->assign('groups','community');
$tpl->assign('selected','selected');


$dataNews = $db->query('SELECT * FROM habbophp_news ORDER BY id DESC LIMIT 0,'.safe($config->slideNews).'',true);


$dataHome = $db->query('SELECT h.userid,u.username FROM habbophp_home_widget h LEFT JOIN users u  ON h.userid=u.id WHERE u.username != ""  ORDER BY RAND() LIMIT 11',true);



if(isset($dataHome) && !empty($dataHome) && !empty($dataHome[0]['username'])){ $tpl->assign('home',$dataHome) ;} else { $tpl->assign('home','empty'); }
$tpl->assign('news',$dataNews);

$tpl->display('header.tpl');
$tpl->display('community.tpl');
$tpl->display('footer.tpl');

?>