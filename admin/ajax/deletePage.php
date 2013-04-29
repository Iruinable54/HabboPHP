<?php
define('RANK','6');
require '../includes/init.php';
if(isset($_POST['id']) && is_numeric($_POST['id'])){
	$dbPage = new Db('habbophp_pages');
	$dbPage->delete(safe($_POST['id']));
	
}
