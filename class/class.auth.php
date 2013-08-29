<?php
class Auth{

	private $uid ;

	private $_db ;
	
	private $_db_security ;
	
	function __construct(){
		$this->_db = new Db();
			if(isset($_SESSION['Auth']) && isset($_SESSION['uid']))
				$this->uid = $_SESSION['uid'];
	}
	

	private function setIP_last($uid){
		$ip = safe($_SERVER['REMOTE_ADDR'],'SQL');
		$this->_db->query("UPDATE users SET ip_last = '".$ip."' WHERE id = '".$uid."'");
	}
	
	private function setLast_online($uid){
		$this->_db->query("UPDATE users SET last_online = '".date('Y-m-d H:i:s')."' WHERE id = '".$uid."'");
	}
	
	private function isBan($username){
	global $config ;
			$data = $this->_db->query("SELECT * FROM bans WHERE value = '".$username."' OR value ='".$_SERVER['REMOTE_ADDR']."' LIMIT 1",true,false);	
			if($data){
				if(time() > $data['expire']){
					$req = $this->_db->query('DELETE FROM bans WHERE id='.safe($data['id'],'SQL'));	
					return false ;
				}
				else{
					$this->logout();
					redirection($config->url_site.'/index.php?ban='.$data['id']);
				}	
		}
	}		
	
	
	/*
	Si vous utilisez IPSTAFF, décommentez la ligne 72 et 109
	function : checkIPStaff
	@param : $username ( string )
	@param : $rank  ( init )
	@return bool
	*/
	
	private function checkIPStaff($username,$rank){
	global $config ;
		$remote_ip = safe($_SERVER["REMOTE_ADDR"],'SQL');
		$retour = mysql_query("SELECT COUNT(ip) AS acces FROM ip_staff WHERE ip = '".$remote_ip."' and pseudo = '".safe($username,'SQL')."'");
		$donnees = mysql_fetch_array($retour);
 		$acces = $donnees['acces'];
 		if($rank > 3 and $acces < "1"){
 			$this->logout();
 			redirection($config->url_site.'/index.php?error=ip');
 		}
	}
	
	public function connexionFB($fid,$m = NULL){
	sleep(1);
		$fid = safe($fid,'SQL');
		$this->_db->query('SELECT * FROM habbophp_users_facebook WHERE fid='.safe($fid,'SQL'));
		if($this->_db->NumRowsC() == 1){
			$data = $this->_db->getQuery(true);
			$dataUser = $this->_db->query('SELECT username,id,rank FROM users WHERE id="'.safe($data['uid'],'SQL').'"',true,false);
			
			if($m == true && $dataUser['rank'] < 6){ $this->logout();  redirection($config->url_site.'/maintenance.php'); }
			
			$this->isBan($dataUser['username']);
			//$this->checkIPStaff($dataUser['username'],$dataUser['rank']);
			$this->setSaltUsers($data['uid']);
			@setcookie('Auth', $this->getSaltUsers($dataUser['id']), time() + 12*3600);
			$_SESSION['uid'] = $data['uid'] ;
			$_SESSION['Rank'] = $dataUser['rank'];
			$_SESSION['FB'] = true ;
			$_SESSION['Auth'] = true ;
			$_SESSION['Timeout'] = time() + 3 * 3600 ;
			
			$d = date('Y-m-d') ;
			$this->_db->query('UPDATE habbophp_stats SET connexions=connexions+1 WHERE date="'.$d.'"');

			
			$this->setLast_online($data['uid']);
			$this->setIP_last($data['uid']);
		
			
			return true ;
		}
		else{
			return (false);
		}

	}
	
	public function connexion($tab,$m = NULL){
	sleep(1); //Anti bruteforce
		$pseudo = safe($tab['username'],'SQL');
		$password = safe($tab['password'],'SQL');
		if($m)
			$sql = mysql_query('SELECT id,rank FROM users WHERE username="'.$pseudo.'" AND password = "'.hashMe($password).'" AND rank >= 6');
		else
			$sql = mysql_query('SELECT id,rank FROM users WHERE (username="'.$pseudo.'" OR mail="'.$pseudo.'") AND password = "'.hashMe($password).'"');
				
		if(mysql_num_rows($sql) == 1){

			$data = mysql_fetch_assoc($sql);	
			$this->isBan($pseudo);
			//$this->checkIPStaff($pseudo,$data['rank']);
			$this->setSaltUsers($data['id']);
			@setcookie('Auth', $this->getSaltUsers($data['id']), time() + 12*3600);
			$_SESSION['uid'] = $data['id'] ;
			$_SESSION['Rank'] = $data['rank'];
			$_SESSION['Auth'] = true ;
		
			if(!isset($tab['login_remember_me']))
				$_SESSION['Timeout'] = time() + 3 * 3600 ;
			else
				$_SESSION['Timeout'] = time() + 24 * 3600 * 31;
			
			$d = date('Y-m-d') ;
			$this->_db->query('UPDATE habbophp_stats SET connexions=connexions+1 WHERE date="'.$d.'"');
			
			$this->setLast_online($data['id']);
			$this->setIP_last($data['id']);
			
			return true ;
		} 
		else{
			return false ;
		}
		
	}
	

	
	public function getSaltUsers($id){
		$data = $this->_db->query('SELECT * FROM habbophp_users_security WHERE uid="'.safe($id,'SQL').'"',true,false);
		return $data['salt'];
		
	}
	
	public function setSaltUsers($id){
		$dataSalt = $this->_db->query('SELECT * FROM habbophp_users_security WHERE uid="'.safe($id,'SQL').'"',true,false);
		$this->_db_security = new Db('habbophp_users_security');	
		if($this->_db->NumRowsC() == 0){
			$data = array(
				'salt' => hashMe(uniqid()),
				'uid' => $id,
				'expire' => time() + 12*3600
			);
				$this->_db_security->save($data);
		}
		else{
			if(time() > $dataSalt['expire']){
			$data = array(
				'salt' => hashMe(uniqid()),
				'uid' => $id,
				'expire' => time() + 12*3600,
				'id' => $dataSalt['id']
			);
				$this->_db_security->save($data);
			}
		}
	}
	
	public function isConnected(){
		if(isset($_SESSION['Auth']) && $_SESSION['Auth'] == true)
		{
			return true ;
		}
		return false ;
							
	}	
	
	public function initSALT($salt){
		if(strlen($salt) == 40)
			setcookie('Auth', $salt, time() + 12*3600);
			//return true;
	}
	
	public function logout(){
		global $_SESSION ;
		$_SESSION = array();
		@setcookie('Auth', "", time() - 3600);
		session_destroy();
		return true ;
	}
	
	

}

?>