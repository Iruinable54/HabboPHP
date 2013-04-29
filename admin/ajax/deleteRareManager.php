<?php


#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require '../includes/init.php';
if(isset($_POST['id'])){
	$dbRare = new Db('habbophp_shop_rares');
	unset($_POST['token']);
	addLog($user->username,"Delete a rare for ".safe($_POST['id'],'SQL')."");
	if($dbRare->delete($_POST['id'])) echo '1' ;
	
}

?>