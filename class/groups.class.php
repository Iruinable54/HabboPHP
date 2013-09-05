<?php


class Groups{
	
	private $groupid ;
	
	private $name ; 
	
	private $desc ; 
	
	private $badge ;
	
	private $ownerid ;
	
	private $created ;
	
	private $roomid ;
	
	private $locked ;
	
	private $privacy ;
	
	private $_db ;
	
	var $erreurs = array();
	
	
	public function __construct($donnees){
		if($donnees != null)
			$this->hydrate($donnees);
		$this->_db = new Db();

	}
	
	public function hydrate(array $donnees)
	{
	    foreach ($donnees as $key => $value)
	    {
	        // On récupère le nom du setter correspondant à l'attribut
	        $method = 'set'.ucfirst($key);
	        
	        // Si le setter correspondant existe
	        if (method_exists($this, $method))
	        {
	            // On appelle le setter
	            $this->$method($value);
	        }
	    }
	}
	
	
	/////////////////////////////////////////////////
	// Getters
	/////////////////////////////////////////////////

	public function __get($var){
		return $this->$var;
	}
	
	/////////////////////////////////////////////////
	// Setters
	/////////////////////////////////////////////////
	
	
	public function setGroupid($groupid){
		if(is_numeric($groupid) && !empty($groupid))
			$this->groupid = intval($groupid);
		else
			$this->erreurs['groupidError'] = true ;
	}

	
	public function setName($name){
		if(is_string($name) && strlen($name) <= 50 && !empty($name)){
			$this->name = $name ;
		}else{
			$this->erreurs['NameError'] = true;
		}
	}
	
	public function setDesc($desc){
		if(is_string($desc) && strlen($desc) <= 255 && !empty($des)){
			$this->desc = $des ;
		}else{
			$this->erreurs['DescError'] = true;
		}
	}
	
	public function setBadge($badge){
		if(!empty($badge) && is_string($badge)){
			$this->badge = $badge ;
		}else{
			$this->erreurs['BadgeError'] = true ;
		}
	}
	
	public function setOwnerid($ownerid){
		if(is_numeric($ownerid) && !empty($ownerid))
			$this->ownerid = intval($ownerid);
		else
			$this->erreurs['OwneridError'] = true ;
	}
	
	public function setCreated($created){
		$this->created = $created ;
	}
	
	public function setLocked($locked){
		$locked_allowed = array('closed','locked','open');
		if(in_array($locked,$locked_allowed)){
			$this->locked = $locked ;
		}else{
			$this->erreurs['lockedError'] = true ;
		}
	}
	
	public function setPrivacy($privacy){
		$privacy_allowed = array('blocked','open');
		if(in_array($privacy, $privacy_allowed)){
			$this->privacy = $privacy ;
		}else{
			$this->erreurs['privacyError'] = true ;
		}
	}
	
	/////////////////////////////////////////////////
	// Manager
	/////////////////////////////////////////////////
	
	
	/*Chercher des informations général sur le groupe*/
	
	public function getInfo(){
		$d = array();
		$req = mysql_query('SELECT g.*,u.username FROM groups g LEFT JOIN users u ON u.id=g.ownerid WHERE g.id='.$this->groupid);
		return mysql_fetch_assoc($req);
		
	}
	
	/*Cherche tout les groupes au quel la personne appartient.*/
	public function getGroupsMembershipsOwn(){
		$d = array();
		$req = mysql_query('SELECT g.name,g.ownerid,g.id
							FROM group_memberships m
							LEFT JOIN groups g ON m.groupid = g.id
							WHERE m.userid='.$_SESSION['uid']);
		while($data = mysql_fetch_assoc($req)){
			$d[] = $data ;
		}
		return $d ;
	}
	
	/*Donne la liste des membres d'un groupe*/
	
	public function getGroupsMemberships(){
		$d = array();
		$req = mysql_query('SELECT u.username,u.look,g.name
							FROM group_memberships m
							LEFT JOIN groups g ON m.groupid = g.id
							LEFT JOIN users u ON u.id= m.userid
							WHERE m.groupid='.$this->groupid);
		while($data = mysql_fetch_assoc($req)){
			$d[] = $data ;
		}
		return $d ;
	}

	
	/*Créer un groupe*/
	
	public function add(){
		/*$this->_db->table = 'groups' ;
		$data  = array(
			'name' => safe($this->name,'SQL'),
			'ownerid' => intval($_SESSION['uid']),
			'desc' => safe($this->desc,'SQL')
		);
		$this->_db->save($data);
		
		$groupid = $this->_db->id ;
		
		$this->_db->table = 'group_memberships';
		$data2 = array(
			'groupid' => $groupid,
			'userid' =>  intval($_SESSION['uid'])
		);
		$this->_db->save($data2);
		
		$this->setGroupid($groupid) ;
		*/
		
	}
	
	/*Edit*/
	
	public function editBadge(){
	/*	$this->_db->table = 'groups';
		$this->_db->save(array('id' => $this->groupid , 'badge' => $this->badge)); */
		return true;
	}

	
	/*Savoir si le groupe demandé existe*/
	
	public function Exist(){
		/*$req = mysql_query('SELECT id FROM groups WHERE id='.$this->groupid);
		if(mysql_num_rows($req) >=1)
			return true;
		return false;
		*/
	}
	

}


?>