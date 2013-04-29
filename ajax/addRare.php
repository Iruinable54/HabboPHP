<?php

require '../init.php';
if(!Validate::ValideInput(array('rare' => 'isNumeric'))) exit ;

	$dataRare = $db->query('SELECT * FROM habbophp_shop_rares WHERE oid="'.safe($_POST['rare'],'SQL').'"',true,false) ;
	if($db->NumRowsC() > 0){
		if($dataRare['prix'] <= $user->jetons)	
		{ 
			if($user->addRare(safe($_POST['rare']))) echo '1' ;
			if($user->deleteJetons($dataRare['prix'])) echo '2' ;
		}
	else echo 'nomoney' ;
	}


?>