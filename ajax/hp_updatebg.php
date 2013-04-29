<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
require '../init.php';

if(!Validate::ValideInput(array('class' => 'isClean'))) exit ;

$class=safe(safe($_GET['class'],'HTML'),'SQL');


$db->query("DELETE FROM habbophp_home_backgrounds WHERE uid=".safe($user->id,'SQL')."");
$db->query("INSERT INTO habbophp_home_backgrounds VALUES ('','".$user->id."','".strtolower($class)."')"); 