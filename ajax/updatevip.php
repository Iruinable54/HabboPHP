<?php
require '../init.php';
if(!isset($_POST['expire'])) exit ;
if(!is_numeric($_POST['expire'])){ echo 'errorData'; exit; }
if($_POST['expire'] == 0){ echo 'errorMois' ; exit ; }
if($user->rank >= 3){ echo 'errorRank' ; exit ; }
$jetonsNeed = $config->vipprice * safe($_POST['expire'],'HTML') ;

if($jetonsNeed > $user->jetons){ echo  'nomoney' ; exit ; }

$userDB = new Db('users');
$vipDB = new Db('habbophp_users_vip',$user->id);

if($vipDB->NumRows('uid') == 0){
$data = array(
	'uid' => $user->id,
 	'expire' => time() + 3600 * 24 * 30 * safe($_POST['expire'],'SQL')
);
	
if($vipDB->save($data)) echo '1'; 
if(EMULATOR == 'phoenix')
	if($userDB->save(array('id' => $user->id  ,'rank' => 2 , 'vip' => '1' ))) echo '1' ;
elseif(EMULATOR == 'butterfly')
	if($userDB->save(array('id' => $user->id  ,'rank' => 2))) echo '1' ;

$user->deleteJetons($jetonsNeed);

}
else{
	$expire = 3600 * 24 * 30 * safe($_POST['expire'],'SQL') ;
	if($db->query('UPDATE habbophp_users_vip SET expire=expire+"'.$expire.'" WHERE uid="'.safe($user->id,'SQL').'"')){ echo '1';  }
	if(EMULATOR == 'phoenix')
		if($userDB->save(array('id' => $user->id ,'rank' => 2 , 'vip' => '1'))) echo '1' ;
	elseif(EMULATOR == 'butterfly')
		if($userDB->save(array('id' => $user->id ,'rank' => 2))) echo '1' ;

	$user->deleteJetons($jetonsNeed);
}
?>