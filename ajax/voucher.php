<?php
require '../init.php';
if(!isset($_POST['voucher']) OR !Validate::ValideInput(array('voucher' => 'isClean')) ) exit ;
if($user->useVoucher($_POST['voucher'])) echo '1' ; else echo'2';
