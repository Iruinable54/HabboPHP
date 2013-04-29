<?php
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
if(!defined('CORE')) die('Error core acces') ;

ini_set('display_errors', 1); 
ini_set('log_errors', 1); 
error_reporting(1);

$path = dirname(__FILE__) ;
$path = str_replace("includes","",$path);
define('PATH',$path);


/*+===================================+
|            Security                |
+===================================+*/

$injection = 'INSERT|UNION|SELECT|NULL|COUNT|FROM|LIKE|DROP|TABLE|WHERE|COUNT|COLUMN|TABLES|INFORMATION_SCHEMA|OR' ;
foreach($_GET as $getSearchs){
	$getSearch = explode(" ",$getSearchs);
	foreach($getSearch as $k=>$v){
		if(in_array(strtoupper(trim($v)),explode('|',$injection))){
			exit;
		}
	}
}




/*+===================================+
|            Configuration PHP        |
+===================================+*/

// correct Apache charset (except if it's too late
if (!headers_sent())
	header('Content-Type: text/html; charset=utf-8');
	
ini_set('default_charset', 'utf-8');

if (function_exists('date_default_timezone_set')){
	@date_default_timezone_set('Europe/Paris');
}


if (!defined('_MYSQL_REAL_ESCAPE_STRING_'))
	define('_MYSQL_REAL_ESCAPE_STRING_', function_exists('mysql_real_escape_string'));



/*+===================================+
|   Verification installation         |
+===================================+*/


$file_settings = $path.'includes/settings.inc.php' ;
if(!file_exists($file_settings)){
	if(!file_exists($path.'/install')){
		die('Install directory is missing ( ERROR 04 ). Le dossier d\'installation a &eacute;t&aecute; supprim&eacute;. Vous devez le remettre');
	}
	header('Location:install/');
}



/*+===================================+
|   Importation des librarys          |
+===================================+*/
if(!defined('SETTINGS'))
	require	$path.'includes/settings.inc.php';


require	$path.'class/html_dom.php' ;

require	$path.'class/class.config.php' ;

require	$path.'class/class.mysql.php' ;

require	$path.'class/class.db.php' ;

require	$path.'class/smarty/Smarty.class.php';

require	$path.'includes/functions.php';

require	$path.'class/class.users.php';

require	$path.'class/class.auth.php';

require	$path.'class/class.error.php' ;

require	$path.'class/recaptchalib.php' ;

require	$path.'class/class.phpmailer.php' ;

require	$path.'class/class.tools.php' ;

require	$path.'class/class.validate.php' ;

require	$path.'class/rooms.class.php' ;

require	$path.'class/groups.class.php' ;

/*+===================================+
|   Connexion to database             |
+===================================+*/

$Mysql = new Mysql(HOST,USER_DB,PASSWORD_DB,NAME_DB) ;

mysql_query("SET NAMES UTF8");

/*+===================================+
|   Initialisation des class          |
+===================================+*/



$tpl = new Smarty(); //Template
$config = new config() ; //Configuration
$Auth = new Auth(); //Authentification
$db = new Db();
setGlobalStats();

/*+===================================+
|   Initialisation du user            |
+===================================+*/

if(isset($_SESSION['uid']) && !empty($_SESSION['uid']) && is_numeric($_SESSION['uid']))
	$user = new users($_SESSION['uid']);

//if(isset($_SESSION['uid']) && !empty($_SESSION['uid']) && is_numeric($_SESSION['uid']))
//	$user = Factory::load($path,'users'.EMULATOR,array('id' => $_SESSION['uid']));


/*+===================================+
|    Configuration smarty             |
+===================================+*/

//Configuration smarty
$tpl->force_compile = true ; //TRUE : Developpement ; FALSE : Production
//$tpl->cache_lifetime = 900; //Temps d'expiration du cache en seconde
$tpl->compile_check = false;
$tpl->debugging = false; 
$tpl->debugging_ctrl = 'NONE'; // 'NONE' on production
$tpl->caching = false;

$tpl->template_dir = 	$path.'themes/templates/';
$tpl->compile_dir = 	$path.'themes/templates/templates_c/';
$tpl->config_dir = 		$path.'modules/lang/';

//Variable du template
$arrStr = explode("/", $_SERVER['SCRIPT_NAME'] ); 
$arrStr = array_reverse($arrStr );
$tpl->assign('url',$arrStr[0]);
$tpl->assign('emulator',EMULATOR);
$tpl->assign('lang_dir',$path.'modules/lang');
$tpl->assign('lang',$config->lang);
$tpl->assignByRef('config', $config);
$tpl->assignByRef('user', $user);
$tpl->configLoad($path.'modules/lang/'.$config->lang.'.lang');
define('SMARTY_DEBUG_CONSOLE', false); 



/*+===================================+
|    Gestion des erreurs              |
+===================================+*/



if (!isset($_SERVER['REQUEST_URI']) OR empty($_SERVER['REQUEST_URI']))
{
	if (substr($_SERVER['SCRIPT_NAME'], -9) == 'index.php' && empty($_SERVER['QUERY_STRING']))
		$_SERVER['REQUEST_URI'] = dirname($_SERVER['SCRIPT_NAME']).'/';
	else
	{
		$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
		if (isset($_SERVER['QUERY_STRING']) AND !empty($_SERVER['QUERY_STRING']))
			$_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
	}
}

if (!isset($_SERVER['HTTP_HOST']) OR empty($_SERVER['HTTP_HOST']))
	$_SERVER['HTTP_HOST'] = @getenv('HTTP_HOST');


?>