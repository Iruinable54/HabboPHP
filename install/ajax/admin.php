<?php

require '../init.php' ;

	ini_set('display_errors', 1); 
	ini_set('log_errors', 1); 
include "../../includes/settings.inc.php";
include "../../includes/functions.php";
mysql_connect(HOST,USER_DB,PASSWORD_DB);
mysql_select_db(NAME_DB);
	
$error=0;

$req = mysql_query('SHOW TABLES FROM '.NAME_DB.'');



$d = array();
while ($row = mysql_fetch_array($req)) {
   $d[] =  $row[0];
}


if(!in_array('users',$d) OR !in_array('bans',$d) OR !in_array('server_status',$d)){
echo '<br /><br /><div lang="en"  class="error">Pheonix database must be imported. <br/>Votre base de donn&eacute;e ne contient pas de tables de phoenix. Importez les tables de phoenix avant de continuer.</div><br/>' ;
$error = 1 ;
}

if(empty($_GET['username'])){echo '<br /><br /><div lang="en" class="error">You have to complete all the fields<br />Vous devez compl&eacute;ter tous les champs</div>';$error=1;}
if(empty($_GET['password'])){echo '<br /><br /><div lang="en" class="error">You have to complete all the fields<br />Vous devez compl&eacute;ter tous les champs</div>';$error=1;}
if(empty($_GET['email'])){echo '<br /><br /><div lang="en" class="error">You have to complete all the fields<br />Vous devez compl&eacute;ter tous les champs</div>';$error=1;}
if(!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)){echo '<br /><br /><div lang="en" class="error">Mail is invalid<br />L\'email est invalide</div>';$error=1;}
if($error==0){

mysql_query('INSERT INTO users (username,password,mail,rank) VALUES ("'.safe($_GET['username'],'SQL').'","'.hashMe($_GET['password']).'","'.safe($_GET['email'],'SQL').'",7)');


echo '<script>$("#adminform").animate({opacity:0}).slideUp("slow",function(){$("#okadmin").slideDown("slow").animate({opacity:1});});</script><div style="opacity:0;display:none;" id="okadmin"><font lang="en">It\'s terminate!<br />Please delete the /install folder !<br /><br />C\'est termin&eacute;!<br />Veuillez supprimer le dossier /install</font><br /><br /><br /><a href="/" class="downloadButton" lang="en">Go!</a></div>';}else exit();
