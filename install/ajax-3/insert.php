<?php
include "../../includes/settings.inc.php";
include "../../includes/functions.php";
mysql_connect(HOST,USER_DB,PASSWORD_DB);
mysql_select_db(NAME_DB);
$req = mysql_query('SHOW TABLES FROM '.NAME_DB.'');



$d = array();
while ($row = mysql_fetch_array($req)) {
   $d[] =  $row[0];
}


if(!in_array('users',$d) OR !in_array('bans',$d) OR !in_array('server_status',$d)){
die( 'Votre base de donn&eacute;e ne contient pas de tables de phoenix/butterfly. Importez les tables avant de continuer.') ;
}

$requetes = ''; 
$sql = file('../db.sql');
foreach($sql as $lecture){if(substr(trim($lecture), 0, 2) != '--'){$requetes .= $lecture;}}
 
$reqs = split(';', $requetes); 
foreach($reqs as $req){if(!mysql_query($req) AND trim($req) != ''){}}

echo 'true';
?>