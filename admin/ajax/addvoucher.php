<?php
define('RANK','6');
require '../includes/init.php';
if(!isset($_GET['amount'])) exit ;
$voucher=Tools::passwdGen(8);

$dbVoucher = new Db('habbophp_voucher');

$data = array(
	'voucher' => $voucher,
	'amount' => safe($_GET['amount'],'SQL')
);

if($dbVoucher->save($data) AND addLog($user->username,"Add a voucher for ".safe($_GET['amount'],'SQL')." coins (jetons)")) {
	echo $voucher;
}