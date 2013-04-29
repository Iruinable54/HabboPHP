<?php


class Validate
{

	public $input ;
	
	
	public static function ValideInput($input = array()){
		foreach($input as $k=>$v){
			if(isset($_POST[$k])){
				if(self::$v($_POST[$k]) && !empty($_POST[$k]))
					return true;
				else{
					return false ;
					}
			}
			if(isset($_GET[$k])){
				if(self::$v($_GET[$k]) && !empty($_GET[$k]))
					return true;
				else
					return false ;
			}
		}
	}
	
	public static function isCleanHomeType($type) {
		$type_liste = array('profil','badges','player','rooms','friends','books','groups','image','note');
		return in_array($type,$type_liste);
	}


	public static function isUsername($username){
		return preg_match("#^[0-9a-zA-Z\-\:.!\#&@=]+$#i",$username);
	}

	/**
	* Check for e-mail validity
	*
	* @param string $email e-mail address to validate
	* @return boolean Validity is ok or not
	*/
	public static function isEmail($email)
	{
		return !empty($email) AND preg_match('/^[a-z0-9!#$%&\'*+\/=?^`{}|~_-]+[.a-z0-9!#$%&\'*+\/=?^`{}|~_-]*@[a-z0-9]+[._a-z0-9-]*\.[a-z0-9]+$/ui', $email);
	}
	
	public static function isNumeric($data){
		return preg_match("#^[0-9]+$#i",$data);
	}
	
	public static function isHomeBook($data){
	
	}
	
	public static function isCleanPx($lenght){
		return preg_match('/^[0-9]+.px+$/ui',$lenght);
	}
	
	
	public static function isClean($data){
		return preg_match("#([0-9A-Za-z\-\_]+)#i",$data);
	}
	
	
	public static function isCleanBadge($data){
		return preg_match("#^([0-9a-zA-Z]+)$#i",$data);
	}
	
	/**
	* Check for HTML field validity (no XSS please !)
	*
	* @param string $html HTML field to validate
	* @return boolean Validity is ok or not
	*/
	public static function isCleanHtml($html)
	{
		$jsEvent = 'onmousedown|onmousemove|onmmouseup|onmouseover|onmouseout|onload|onunload|onfocus|onblur|onchange|onsubmit|ondblclick|onclick|onkeydown|onkeyup|onkeypress|onmouseenter|onmouseleave|onerror';
		return (!preg_match('/<[ \t\n]*script/i', $html) && !preg_match('/<?.*('.$jsEvent.')[ \t\n]*=/i', $html)  && !preg_match('/.*script\:/i', $html));
	}
	
	public static function isName($name)
	{
		return preg_match('/^[^0-9!<>,;?=+()@#"°{}_$%:]*$/u', stripslashes($name));
	}


	
}


?>