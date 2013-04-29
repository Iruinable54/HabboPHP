<?php
session_start();
define('CORE','CORE');
$admin = true ;
require'../includes/core.php';

$tpl->display('help_header.tpl');
$tpl->display('help_submit.tpl');
$tpl->display('help_footer.tpl');

?>