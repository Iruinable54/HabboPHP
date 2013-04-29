<?php


#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require '../includes/init.php';
if(isset($_POST['oid'])){
	$dbRare = new Db('habbophp_shop_rares');
	unset($_POST['token']);
	addLog($user->username,"Add a rare for ".safe($_POST['name'],'SQL')."");
	if($dbRare->save($_POST)) echo '1' ;
	
}

?>