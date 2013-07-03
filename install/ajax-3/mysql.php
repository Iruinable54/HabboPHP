<?php
require '../version.php';
mysql_connect($_POST['dbhost'],$_POST['uname'],$_POST['pwd']) or die('Les informations de connexion vers la base de donnée sont incorrecte.');
mysql_select_db($_POST['dbname']) or die('Les informations de connexion vers la base de donnée sont incorrecte.');
$_POST['em'] = 'phoenix';
$config = "<?php
define('HOST','".$_POST['dbhost']."');
define('USER_DB','".$_POST['uname']."');
define('PASSWORD_DB','".$_POST['pwd']."');
define('NAME_DB','".$_POST['dbname']."');
define('EMULATOR','".$_POST['em']."');
define('VERSION','".VERSION."');
?>";

$f = '../../includes/settings.inc.php';

$handle = fopen($f,"w"); 
if(is_writable($f))
 	fwrite($handle, $config);
fclose($handle);  

if(!file_exists($f)){
	die('Nous ne pouvons pas &eacute;crire le fichier /includes/settings.inc.php<br />Copiez/collez le texte ci-dessous dans includes/setting.inc.php<br /><br /><textarea style="height: 91px;">'.$config.'</textarea>');
}

echo 'true';

?>