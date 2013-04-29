<?php
define('RANK','7');
require '../includes/init.php';

$usersManage = new Db('users');
if($_GET['password'] == '') unset($_GET['password']); else $_GET['password'] = hashMe($_GET['password']);
$_GET['username'] = safe($_GET['username'],'SQL');

if(EMULATOR == 'phoenix') if($_GET['rank'] == 2) $_GET['vip'] = 1 ;

unset($_GET['token']);
$jetons = $_GET['jetons'];
unset($_GET['jetons']);
if($usersManage->save($_GET)) echo '1' ;



$req = mysql_query('SELECT * FROM habbophp_users_jetons WHERE uid="'.safe($_GET['id'],'SQL').'"');
if (!mysql_num_rows($req)){
	$reqJ = mysql_query('INSERT INTO habbophp_users_jetons VALUES ("","'.safe($_GET['id'],'SQL').'","'.$jetons.'")') ;
}
else{
	$reqJ = mysql_query('UPDATE habbophp_users_jetons SET jetons='.$jetons.' WHERE uid="'.safe($_GET['id'],'SQL').'"');
}
if($reqJ) echo '1' ;

addLog($user->username,"Update user ".safe($_GET['username'],'SQL')."");

?>