<?php
session_start();
define('CORE','CORE');
$admin = true ;
require '../../includes/core.php';


// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}
// post back to PayPal system to validate
$header  = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

 if (isset($_POST['item_name']) && isset($_POST['item_number']) && isset($_POST['payment_status']) && isset($_POST['custom'])){

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];




if($receiver_email == $config->paypalemail && $config->paypalprice == $payment_amount ){
	if (!$fp) {
		// HTTP ERROR
	} else {
	fputs ($fp, $header . $req);
	while (!feof($fp)) {
		$res = fgets ($fp, 1024);
			if (strcmp ($res, "VERIFIED") == 0) {
				if ( $payment_status == "Completed") {
					$Jetons_authorized = array($config->starpassamount,$config->allopassamount,$config->paypalamount);
					$user->addJetons('paypal');
					addLogsPaiement($user->username,'paypal');
					redirection($config->url_site.'/shop.php?success');
				}

			}
			else if (strcmp ($res, "INVALID") == 0) {
				redirection($config->url_site.'/shop.php?error');
			}
	}
	fclose ($fp);
	}
}
else
	redirection($config->url_site.'/shop.php?error');
}
else
	redirection($config->url_site.'/shop.php?error');
?>