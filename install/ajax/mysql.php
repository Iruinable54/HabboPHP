<?php

require '../init.php' ;

	ini_set('display_errors', 0); 
	ini_set('log_errors', 0); 
	error_reporting(NONE);
	$error=0;
	if(!mysql_connect($_GET['server'],$_GET['user'],$_GET['pass'])){echo '<div lang="en" class="error">Cannot connect to the database - Impossible de se connecter a la base de donn&eacute;es</div>';$error=1;}
	if(!mysql_select_db($_GET['db'])){echo '<div lang="en" class="error">Cannot select database - Impossible de trouver la base de donn&eacute;es</div>';$error=1;}
	

require'../../includes/release.php' ;
	
$requetes = ''; 
$sql = file('../db.sql');
foreach($sql as $lecture){if(substr(trim($lecture), 0, 2) != '--'){$requetes .= $lecture;}}
 
$reqs = split(';', $requetes); 
foreach($reqs as $req){if(!mysql_query($req) AND trim($req) != ''){}}
	
	
$f = '../../includes/settings.inc.php'; 
$text = "<?php\r
define('HOST','".$_GET['server']."');
define('USER_DB','".$_GET['user']."');
define('PASSWORD_DB','".$_GET['pass']."');
define('NAME_DB','".$_GET['db']."');

define('VERSION','".VERSION."');
define('EMULATOR','".$_GET['em']."');
define('_PREFIX_','habbophp_');
define('TIMEOUT_TOKEN',3600);
?>"; 
$handle = fopen($f,"w"); 

if(is_writable($f))
 	fwrite($handle, $text);
fclose($handle);  

if(!file_exists($f)){

      echo 'We can\'t write the file /includes/settings.inc.php<br />Now you only need to copy/paste the<br />code below in /includes/setting.inc.php<br /><br />Nous ne pouvons pas &eacute;crire le fichier /includes/settings.inc.php<br />Copiez/collez le texte ci-dessous dans includes/setting.inc.php<br /><br /><textarea>';
      echo "<?php\r
define('HOST','".$_GET['server']."');
define('USER_DB','".$_GET['user']."');
define('PASSWORD_DB','".$_GET['pass']."');
define('NAME_DB','".$_GET['db']."');
\r
define('VERSION','".VERSION."');
define('EMULATOR','".$_GET['em']."');
define('_PREFIX_','habbophp_');
define('TIMEOUT_TOKEN',3600);
?>";
	  echo "</textarea><br /><br />";
      $error=2; 
   
}

	
	if($error==0) echo '<script>$("#dbform").animate({opacity:0}).slideUp("slow",function(){$("#okdb").slideDown("slow").animate({opacity:1});});</script><div id="okdb" style="display:none;opacity:0;height:212px;"><br />Everything is okay!<br />Tout est ok!<br /><br /><a href="javascript:void(0);" onclick="step(3);" class="downloadButton" lang="en">Next</a></div>';
	elseif($error==2) echo '<script>$("#dbform").animate({opacity:0}).slideUp("slow",function(){$("#okdb").slideDown("slow").animate({opacity:1});});</script><div id="okdb" style="display:none;opacity:0;height:212px;"><br />When it\'s okay, continue :)<br />Quand c\'est fait, continuons :)<br /><br /><a href="javascript:void(0);" onclick="step(3);" class="downloadButton" lang="en">Next</a></div>';
	else echo '<script>$("#next2").html("Retest");</script>';
?>