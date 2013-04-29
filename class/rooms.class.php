<?php
class Rooms{

	private $room_id ;
	
	private $_db ;
	
	
	public function __construct(){
		$this->_db = new Db('rooms');
	}
	
	public function getRoomsUser($username = null){
		global $user ;
		$username = ($username == null) ? $user->username : $username ;
		return $this->_db->find(array('conditions' => 'owner = "'.$username.'"','fields' => 'owner,id,caption'));
	}
	
	public function roomsBelongsToUser($id){
		global  $user;
		$belongs = $this->_db->find(array('conditions' => 'owner = "'.$user->username.'" AND id='.intval($id).'','fields' => 'id'));	
		if($belongs != null)
			return true ;
		return false ;
	}
	
	
	/*
	Create a rooms for phoenix
	*/
	
	public function createRooms($roomtype,$caption,$owner,$desc,$model_name){
		$data = array(
			'roomtype' => $roomtype,
			'caption' => $caption,
			'owner' => $owner,
			'description' => $desc,
			'model_name' => $model_name
		);
		if(!$this->_db->save($data))
			throw new exception('Unable to save rooms');
		$this->room_id = $this->_db->id ;
		return true;
	}
	
	/*
	Add items to rooms
	*/
	
	public function addItemsToRooms($user_id,$room_id,$base_item,$coord = array(),$rot){
		if(isset($this->room_id)) $room_id = $this->room_id ;
		$req = mysql_query('SELECT id FROM items ORDER BY id DESC LIMIT 1'); //last id
		$last_id = mysql_fetch_assoc($req);
		$id = $last_id['id']+1;
		$data = array(
			'id' => $id,
			'user_id' => intval($user_id),
			'room_id' => intval($room_id),
			'base_item' => $base_item,
			'x' => $coord['x'],
			'y' => $coord['y'],
			'z' => $coord['z'],
			'rot' => $rot
		);
		$this->_db->table = 'items';
		if(!$this->_db->save($data,false))
			throw new exception('Unable to save items');
		return true;
	}
	
	public function loadModel($model){
		global $config ;
		$path  = PATH.'modules/rooms/'.$model.'.xml';
		if(file_exists($path)){
			return $path;
		}else{
			throw new exception('Impossible de load xml file');
		}
	}
	
	public function buildModel($model){
		try{
			$dom = new DomDocument();
			$dom->Load($this->loadModel($model));
			$rooms_base = $dom->getElementsByTagName( "roomdata" );
			foreach($rooms_base as $rooms_bases){
				$roomtypes = $rooms_bases->getElementsByTagName( "roomtype" )->item(0)->nodeValue;
				$caption = $rooms_bases->getElementsByTagName( "caption" )->item(0)->nodeValue;
				$model_name = $rooms_bases->getElementsByTagName( "model_name" )->item(0)->nodeValue;
				$description =  $rooms_bases->getElementsByTagName( "description" )->item(0)->nodeValue;
				
				if($this->createRooms($roomtypes,$caption,$username,$description,$model_name))
					echo 'Done rooms<br/>';
				
			}
			
			
			foreach($dom->getElementsByTagName( "roomitem" ) as $room_items){
					foreach($room_items->getElementsByTagName( "item" ) as $item){
						$base_item =  $item->getElementsByTagName( "base_item" )->item(0)->nodeValue;
						$x =  $item->getElementsByTagName( "x" )->item(0)->nodeValue;	
						$y =  $item->getElementsByTagName( "y" )->item(0)->nodeValue;	
						$z =  $item->getElementsByTagName( "z" )->item(0)->nodeValue;	
						$rot =  $item->getElementsByTagName( "rot" )->item(0)->nodeValue;	
						$coord = array('x' => $x,'y' => $y,'z'=>$z);
						if($this->addItemsToRooms($user_id,null,$base_item,$coord,$rot))
							echo 'Done '.$base_item.'<br/>';
					}
			}
			
		}catch(Exception $e){
		 	echo $e->getMessage();
		}
	}
	
}	
?>