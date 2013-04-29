<?php

class UsersButterfly{

	private $_db ;
	
	private $_users ;
	
	private $_parent ;
		
	function __construct($parent){
		$this->_db = new Db('users');
		$this->_parent = $parent  ;	
		}
	
		
	public function getListFriends(){
		$d = array();
		$req = mysql_query('SELECT fr.*,us.username,us.last_online,us.id FROM messenger_friendships fr LEFT JOIN users us ON fr.receiver = us.id
		 WHERE fr.sender='.$this->_parent->id);
		while($data = mysql_fetch_assoc($req)){
			if($data['last_online'] == NULL) $data['last_online'] = 'Jamais' ;
			$d[] = $data;
		}
		$req = mysql_query('SELECT fr.*,us.username,us.last_online,us.id FROM messenger_friendships fr LEFT JOIN users us ON fr.sender = us.id
		 WHERE fr.receiver='.$this->_parent->id);
		while($data = mysql_fetch_assoc($req)){
			if($data['last_online'] == NULL) $data['last_online'] = 'Jamais' ;
			$d[] = $data;
		}
		return $d ;

	}
	
	
	
	public function checkVIP(){
	if($this->_parent->rank == 2){
		$query = $this->_db->query("SELECT * FROM habbophp_users_vip WHERE uid=".$this->_parent->id."",true);
		if($query){
			foreach($query as $row){
				$expire=$row['expire'];
				if(time() > $row['expire']) {
					$this->_parent->updateUser('rank',2);
				}
			}
		//	$this->_parent->updateUser('rank',1);
		}
		if(!isset($expire)){
			$vipDB = new Db('habbophp_users_vip');
			$data = array(
				'uid' => $this->_parent->id,
				'expire' => time() + 3600 * 24  * 1 * 7
			);
			$vipDB->save($data); 
			redirection('me.php');
			}
		}
	}
	
	public function getSatutsVIP(){
		if($this->_parent->rank==2) {
			$d = $this->_db->query("SELECT * FROM habbophp_users_vip WHERE uid=".$this->_parent->id."",true,false);
			$datetime = date('<b>d/m/Y</b> à H:i', $d['expire']);
			return '<b>VIP</b> jusqu\'au '.$datetime.')' ;
		} else {
			return '' ;
		}
	}
	
	public function deleteFriends($data = array()){
		$this->_db->query('DELETE FROM messenger_friendships WHERE receiver='.$data['id'].' AND sender='.$this->_parent->id.'');
		$this->_db->query('DELETE FROM messenger_friendships WHERE sender='.$data['id'].'   AND receiver='.$this->_parent->id.'');
		return true ;
	}
	
	
	
}

?>