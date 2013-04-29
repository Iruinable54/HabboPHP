<?php

require '../init.php' ;
	ini_set('display_errors', 0); 
	ini_set('log_errors', 0); 
	error_reporting(NONE);
$error=0;



if(!file_exists('../../includes/settings.inc.php')){
echo'<br /><br /><font lang="en" class="error">Settings.inc.php n\'&eacute;xiste pas, recommencez l\'installation</font><br />';
$error = 1 ;
}

if(empty($_GET['name'])){echo '<br /><br /><font lang="en" class="error">You have to complete all the fields - Vous devez compl&eacute;ter tous les champs</font><br />';$error=1;}if(empty($_GET['shortname'])){echo '<br /><br /><font lang="en" class="error">You have to complete all the fields - Vous devez compl&eacute;ter tous les champs</font><br />';$error=1;}if(empty($_GET['url'])){echo '<br /><br /><font lang="en" class="error">You have to complete all the fields - Vous devez compl&eacute;ter tous les champs</font><br />';$error=1;}if(!preg_match('#http://#',$_GET['url'])){echo '<br /><br /><font lang="en" class="error">The URL must begin by http:// - L\'URL doit commencer par http://</font><br />';$error=1;}if(substr($_GET['url'], -1)=="/"){$_GET['url']=substr($_GET['url'],0,-1);}if($error==1)exit();
$error=1;
define('CORE','CORE');
$admin=true;
include "../../includes/settings.inc.php";
mysql_connect(HOST,USER_DB,PASSWORD_DB);
mysql_select_db(NAME_DB);

if(mysql_query("UPDATE habbophp_config SET value='".$_GET['name']."' WHERE name='name'") AND 
mysql_query("UPDATE habbophp_config SET value='".$_GET['shortname']."' WHERE name='shortname'") AND 
mysql_query("UPDATE habbophp_config SET value='".$_GET['url']."' WHERE name='url_site'")){$error=0;}if($error==0) echo '<script>$("#configform").animate({opacity:0}).slideUp("slow",function(){$("#okconfig").slideDown("slow").animate({opacity:1});});</script><div style="opacity:0;display:none;" id="okconfig"><font lang="en">Everything is okay!<br />Tout est ok!</font><br /><br /><br /><a href="javascript:void(0);" onclick="step(4);" class="downloadButton" lang="en">Next</a></div>';
else{echo '<br /><br />There is an error. Please verify your settings.inc.php file.';}
?>