<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

require'init.php';
if(!isset($_GET['amoutMethod'])) redirection($config->url_site.'/shop.php?errorPaiement');
$amoutMethod = array('starpass','paypal','allopass');
if(!in_array($_GET['amoutMethod'],$amoutMethod)) redirection($config->url_site.'/shop.php?errorPaiement'); //La méthode de paiement n'exsite pas
$am = $_GET['amoutMethod'];



switch($am){
	case "paypal":
		$tpl->assign('MethodPrice',array('amout'=>$config->paypalamount , 'price' => $config->paypalprice , 'type' => $am));
	break ;
		case "starpass":
		$tpl->assign('MethodPrice',array('amout'=>$config->starpassamount , 'price' => '1 Code' , 'type' => $am));
	break ;
		case "allopass" :
		$tpl->assign('MethodPrice',array('amout'=>$config->allopassamount , 'price' => '1 Code' , 'type' => $am));
		$allopassData = explode("/",$config->allopassauth);
		$tpl->assign('allopass',$allopassData);
	break ;
}



$tpl->display('paiement.tpl');


?>