<?php

class UsersPhoenix{

	private $_db ;
	
	private $_users ;
	
	private $_parent ;
		
	function __construct($parent){
		$this->_db = new Db('users');
		$this->_parent = $parent  ;	
		}
	
		
	public function getListFriends(){
		$dataFriends = $this->_db->query('SELECT fr.*,us.username,us.last_online FROM messenger_friendships fr LEFT JOIN users us ON fr.user_two_id = us.id
		 WHERE fr.user_one_id='.$this->_parent->id,true);

		return $dataFriends ;
	}
	
	
	
	public function checkVIP(){
	if($this->_parent->vip == 1 && $this->_parent->rank==2 &&  !empty($this->_parent->id)){
		$query = $this->_db->query("SELECT * FROM habbophp_users_vip WHERE uid=".$this->_parent->id."",true);
		if($query){
			foreach($query as $row){
				$expire=$row['expire'];
				if(time() > $row['expire']) {
					$this->_parent->updateUser('rank',1);
					$this->_parent->updateUser('vip',0);
				}
			}
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
		
		if($this->_parent->vip==1 && $this->_parent->rank==2 && !empty($this->_parent->id) && is_numeric($this->_parent->id)) {
			$d = $this->_db->query("SELECT * FROM habbophp_users_vip WHERE uid=".$this->_parent->id."",true,false);
			$datetime = date('<b>d/m/Y</b> à H:i', $d['expire']);
			return '<b>VIP</b> jusqu\'au '.$datetime.')' ;
		} else {
			return '' ;
		}
	}
	
	public function deleteFriends($data = array()){
		$this->_db->query('DELETE FROM messenger_friendships WHERE user_one_id="'.$data['oid'].'" AND user_two_id="'.$data['tid'].'"');
		$this->_db->query('DELETE FROM messenger_friendships WHERE user_two_id="'.$data['oid'].'" AND user_one_id="'.$data['tid'].'"');
		return true ;
	}
	
	
	
}

?>