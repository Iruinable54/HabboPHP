<?php

class Config{

	private $_db ;

	public function __construct(){
	
		$this->_db = new Db('habbophp_config');
	
		$getConfig = $this->_db->query('SELECT * FROM  habbophp_config',true);
		foreach($getConfig as  $data){
			$this->$data['name'] = safe($data['value'],'HTML') ;
		}
		define('URL_SITE',$this->url_site);
		$this->getServer_status();
	}
	
	public function editConfig($name,$value){
		$this->_db->query("UPDATE habbophp_config SET value='".safe($value,'SQL')."' WHERE name='".safe($name,'SQL')."'");

	}
	
	/**
	Check if config is existing
	**/
	
	public function configExist($name){
		$req = mysql_query("SELECT value FROM habbophp_config WHERE name='".safe($name,'SQL')."'");
		$data = mysql_fetch_assoc($req);
		if($data['value'] != null){
			return true;
		}
		return false;
	}
	
	public function checkUpdatePath(){
	
		$lastPath = $this->path_habbo ;
	
		$html = file_get_html('http://habbo.fr');
		$result = $html->find('link',0)->href;
		$replace = str_replace("http://images.habbo.com/habboweb/","",$result);
		$newPath = str_replace("/web-gallery/v2/favicon.ico","",$replace);
		
		if(trim($newPath) != trim($lastPath)){
			$this->editConfig('path_habbo',$newPath);
		}
		
	}
	
	static function getAmout($amout){
		return self::paypalamout  ;
	}
	
	public function checkMaintenance(){
	if(isset($this->maintenance)){
		$m = $this->maintenance ;
		if($m == 'true' && $_SESSION['Rank'] < 5){
			session_destroy();
			redirection($this->url_site.'/maintenance.php');
		}
		else
			return false ;
	}
		
	}
	
	public function getServer_status(){
		$req = mysql_query('SELECT * FROM server_status') or die(mysql_error());
		$data = mysql_fetch_assoc($req);
		if($data){
			foreach($data as $k=>$v){
				if(is_numeric($v))$v=number_format($v);
				$this->$k = $v ;
			}
		}
	}
	
	
}

?>
