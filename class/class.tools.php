<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|


class Tools{

	public static function passwdGen($length = 8)
	{
		$str = 'abcdefghijkmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		for ($i = 0, $passwd = ''; $i < $length; $i++)
			$passwd .= substr($str, mt_rand(0, strlen($str) - 1), 1);
		return $passwd;
	}
	
	public static function getProtocol($use_ssl = null)
	{
		return (!is_null($use_ssl) && $use_ssl ? 'https://' : 'http://');
	}
	
	public static function checkACL($ranks,$acl){
		$acl_liste = explode(";",$acl);
		if(in_array($ranks,$acl_liste))
			return true ;
		return false ;
	}
	
	static function getServerName()
	{
		if (isset($_SERVER['HTTP_X_FORWARDED_SERVER']) AND $_SERVER['HTTP_X_FORWARDED_SERVER'])
			return $_SERVER['HTTP_X_FORWARDED_SERVER'];
		return $_SERVER['SERVER_NAME'];
	}
	
	static function generate_token(){
		$token = uniqid(rand(), true);
		$_SESSION['token'] = $token;
		return $token;
	}
	
	static function verifier_token()
	{
		return true ;
		if(isset($_GET['token'])){
			if(isset($_SESSION['token']) && isset($_GET['token']))
				if($_SESSION['token'] == $_GET['token'])
					return true;
			return false ;
		}
		if(isset($_POST['token'])){
			if(isset($_SESSION['token']) && isset($_POST['token']))
				if($_SESSION['token'] == $_POST['token'])
					return true;
			return false;
		}
	} 
	
	static function TokenNotValide(){
	}
	
	static function getToken(){
		return $_SESSION['token'];
	}
	
	public static function apacheModExists($name)
	{
		if (function_exists('apache_get_modules'))
		{
			static $apache_module_list = null;

			if (!is_array($apache_module_list))
				$apache_module_list = apache_get_modules();

			// we need strpos (example, evasive can be evasive20)
			foreach ($apache_module_list as $module)
			{
				if (strpos($module, $name) !== false)
					return true;
			}
		}
		return false;
	}

	
	
}

?>