<?php
include "../../includes/settings.inc.php";
include "../../includes/functions.php";
mysql_connect(HOST,USER_DB,PASSWORD_DB);
mysql_select_db(NAME_DB);
	if(empty($_POST['login'])) die ('Login ?');
	if(empty($_POST['pwd'])) die ('Un mot de passe ?');
	if(empty($_POST['nom_retro'])) die ('Un nom pour ton beau rétro ?');
	
	mysql_query('INSERT INTO users (username,password,rank) VALUES ("'.safe($_POST['login'],'SQL').'","'.hashMe($_POST['pwd']).'"
	,7)') or die('Error mysql');

	
	mysql_query("UPDATE habbophp_config SET value='".$_POST['url']."' WHERE name='url_site'") or die('Error mysql (url)');
	mysql_query("UPDATE habbophp_config SET value='".$_POST['nom_retro']."' WHERE name='name'") or die('Error mysql (nom rétro)');

	echo 'true';
?>