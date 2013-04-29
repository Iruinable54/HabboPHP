<?php
define('RANK','7');
require '../includes/init.php';


if(isset($_POST['value']) && isset($_POST['type'])){

	if(substr($_POST['type'],0,4) == 'smtp'){
		if($_POST['type'] == 'smtp_username') $_POST['value'] =  $_POST['value'].'@gmail.com' ;
		$db->query('UPDATE habbophp_form_settings SET '.safe($_POST['type'],'SQL').' = "'.safe($_POST['value'],'SQL').'" WHERE id=1');
	}
	$config->editConfig(safe($_POST['type'],'SQL'),safe($_POST['value'],'SQL'));
	
	if(addLog($user->username,"Update configuration ''".safe($_POST['type'],'SQL')."''")) { echo "1"; }
}
