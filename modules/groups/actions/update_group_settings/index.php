<?php
	require '../../../../init.php';
	
	$Error = new Error();
	
	print_r($_GET);
	
	if(!isset($_GET['name']) or empty($_GET['name'])){
		$Error->set('name','Le nom n\'est pas défini');
	}
	
?>