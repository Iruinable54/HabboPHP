<?php

require '../init.php';
if(!Validate::ValideInput(array('badge' => 'isCleanBadge'))) exit ;

$badge = (isset($_POST['badge'])) ? safe($_POST['badge'],'SQL') : '' ;

$req = $db->query('SELECT badge_id FROM user_badges WHERE badge_id="'.safe($badge,'SQL').'" AND user_id="'.safe($user->id,'SQL').'"');
if ($db->NumRowsC() == 0)
{
	$dataPlayer = $db->query('SELECT * FROM habbophp_shop_badges WHERE idbadge="'.safe($badge,'SQL').'"',true,false) ;
	if($db->NumRowsC() > 0){
		if($dataPlayer['amount'] <= $user->jetons)	
		{ 
			if($db->query("INSERT INTO user_badges (user_id,badge_id,badge_slot) VALUES ('".$user->id."','".$badge."','0')")) echo '1';
			if($user->deleteJetons($dataPlayer['amount'])) echo '1' ;
		}
		else echo 'nomoney' ;
	}
}
else
echo'existe';


?>