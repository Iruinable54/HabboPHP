<?php
class Users{

	//253

	private $_emulator ;
	
	private $_db ;
	
	private $colonne = array('phoenix' => 	'id,
											password,
											username,
											mail,
											rank,
											credits,
											vip_points,
											last_online,
											look,
											motto,
											online,
											account_created,
											vip,
											hide_inroom,
											hide_online,look',
											
							'butterfly' =>	'id,
											password,
											username,
											mail,
											rank,
											credits,
											vip_points,
											last_online,
											look,
											motto,
											online,
											account_created'
							) ;
							
	public $id ;

	
	public function __construct($id){
		$this->_db = new Db('users') ;
		$req = $this->_db->query('SELECT '.$this->colonne[EMULATOR].' FROM users WHERE id='.safe($id,'SQL'));
		if ($this->_db->NumRowsC() == 1)
		{
			$data = $this->_db->getQuery();
       		foreach($data as $k=>$v){
        	     $this->$k = safe($v,'HTML');
       		}	
       	}
       	
       	$this->jetons = $this->getJetons();
       	
		$emulateur = 'users'.EMULATOR ;
		require PATH.'class/class.'.$emulateur.'.php' ;
		$this->_emulator = new $emulateur($this);
	}
	
	
	public function addRare($id){
		if(is_numeric($id)){
	
			$lastID = $this->_db->query('SELECT id FROM items ORDER BY id DESC LIMIT 1',true,false);
			$lastID = $lastID['id'] + 1 ;
			if($this->_db->query("INSERT INTO items (id,user_id,base_item,extra_data) VALUES ('".$lastID."','".$this->id."','".$id."','0')"))
				return true ;
		}
	}
	
	
	public function refreshData(){
		$req = $this->_db->query('SELECT '.$this->colonne[EMULATOR].' FROM users WHERE id='.safe($this->id,'SQL'));
		if ($this->_db->NumRowsC() == 1)
		{
			$data = $this->_db->getQuery();
       		foreach($data as $k=>$v){
        	     $this->$k = safe($v,'HTML');
       		}	
       		return true ;
       	}
       	else return false ;
	}
	
	public function updateUser($colonne,$value){
		if($this->_db->query('UPDATE users SET '.$colonne.'="'.safe($value,'SQL').'" WHERE id="'.$this->id.'"')) return true ;
	}
	
	//Badges
	
	public function addBadges($badge){
		if($this->_db->query("INSERT INTO user_badges (user_id,badge_id,badge_slot) VALUES ('".$this->id."','".$badge."','0')"))
			return true ;
	}
	
	public function addWinWin($winwin){
		if(is_numeric($winwin)){
			$this->_db->query('UPDATE user_stats SET AchievementScore=AchievementScore+'.$winwin.' WHERE id="'.$this->id.'"');
		}
	}
	
	//Jetons
	
	public function addJetonsToUsers($number){
		$this->_db->query('SELECT * FROM habbophp_users_jetons WHERE uid="'.$this->id.'"');
		if ($this->_db->NumRowsC() == 0){
			$req = $this->_db->query('INSERT INTO habbophp_users_jetons VALUES ("","'.safe($this->id,'SQL').'","'.$number.'")') ;
		}
		else{
			$req = $this->_db->query('UPDATE habbophp_users_jetons SET jetons=jetons+'.$number.' WHERE uid="'.$this->id.'"');
		}
		$this->setJetonsStats();
	}

	public function addJetons($methodPaiement){
		$data =  $this->_db->query('SELECT value FROM habbophp_config WHERE name="'.safe($methodPaiement.'amount','SQL').'"',true,false);
		$this->_db->query('SELECT * FROM habbophp_users_jetons WHERE uid="'.$this->id.'"');
		if ($this->_db->NumRowsC() == 0){
			$req = $this->_db->query('INSERT INTO habbophp_users_jetons VALUES ("","'.safe($this->id,'SQL').'","'.$data['value'].'")') ;
		}
		else{
			$req = $this->_db->query('UPDATE habbophp_users_jetons SET jetons=jetons+'.$data['value'].' WHERE uid="'.$this->id.'"');
		}
		$this->setJetonsStats();

	}
	
	public function setJetonsStats(){
		$date = date("Y-m-d");
		$this->_db->query('SELECT date FROM habbophp_shop_stats WHERE date="'.$date.'"');
		if ($this->_db->NumRowsC() == 1)
			$this->_db->query('UPDATE habbophp_shop_stats SET value=value+1  WHERE date="'.$date.'"');
		else
			$this->_db->query('INSERT INTO  habbophp_shop_stats VALUES ("","'.$date.'","1")');
	}
	
	public function deleteJetons($jetons){
		$jetons = (int) $jetons ;
		$this->_db->query('UPDATE habbophp_users_jetons SET jetons=jetons-'.$jetons.' WHERE uid="'.$this->id.'"');
		return true ;
	}
	
	public function getJetons(){
		$data = $this->_db->query('SELECT jetons FROM habbophp_users_jetons WHERE uid="'.$this->id.'"',true,false);
		return $this->jetons = $data['jetons'];
	}
	
	public function useVoucher($code){
		$data = $this->_db->query('SELECT * FROM  habbophp_voucher WHERE voucher="'.safe($code,'SQL').'"',true,false);
		if ($this->_db->NumRowsC() == 1){
				$this->_db->query('SELECT * FROM habbophp_users_jetons WHERE uid="'.$this->id.'"');
			if ($this->_db->NumRowsC() == 0){
				$this->_db->query('INSERT INTO habbophp_users_jetons VALUES ("","'.safe($this->id,'SQL').'","'.$data['amount'].'")') ;
			}
			else{
				$this->_db->query('UPDATE habbophp_users_jetons SET jetons=jetons+'.$data['amount'].' WHERE uid="'.$this->id.'"');
			}
				$this->_db->query('DELETE FROM habbophp_voucher WHERE id="'.safe($data['id'],'SQL').'"');
			return true;
		}
		return false ;
	}
	
	public function TicketRefresh(){
		$data = array(
			'auth_ticket' => uniqid(),
			'id' => $this->id
		);
		$this->_db->save($data);
	}
	
	//Rooms
	
	public function loadRooms(){
		$dataRooms = $this->_db->query("SELECT * FROM rooms WHERE owner = '".$this->username."'",true);
		return $dataRooms ;
	}
	
	public function haveRooms(){
		$dataRooms = $this->loadRooms();
			if($dataRooms != NULL){
				return true;
			}
		return false ;
	}
	
	
	//Function only for emulator differences
	
	public function checkVIP(){
		return $this->_emulator->checkVIP();
	}
	
	public function getSatutsVIP(){
		return $this->_emulator->getSatutsVIP();
	}
	
	public function getListFriends(){
		return $this->_emulator->getListFriends();
	}
	
	public function deleteFriends($data = array()){
		return $this->_emulator->deleteFriends($data);
	}
	
}

?>