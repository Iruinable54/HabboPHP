<?php
/**
 * Objet Model
 * Permet les intéractions avec la base de donnée
 * */


class Db{
    
    public $table;
    
    public $id;
    
    var $index_update = 'id' ;
    
    private $query ;
    
    public $queryR ;

    /**
     * Défini les varible
     * @param init $nomTable
     * @param init $id 
     **/
    public function __construct($table = NULL,$id = NULL){
		$this->table = (isset($table)) ? $table : '' ;
		$this->id = (isset($id)) ? $id : '' ;
    }
    
    /**
     * Lit une ligne dans la base de donnée par rapport à l'ID de l'objet
     * @param $fields Liste des champs à récupérer
     * */
    public function read($fields=null , $champ = null, $order = null){
        if($fields==null){            $fields = "*";        }
        if($champ==null){  $champ = 'id' ;   }
        if($order==null){ $order = "id DESC"; }
        $sql = "SELECT $fields FROM ".$this->table." WHERE ".$champ."='".$this->id."' ORDER BY $order LIMIT 1 " ;
        $req = mysql_query($sql) or die(mysql_error()."<br/> => ".mysql_query());
        $data = mysql_fetch_assoc($req);
        foreach($data as $k=>$v){
             $this->$k = $v;
       }
    }
    
    public function count($champs = null){
   		if($champs == null)
    		$sql = 'SELECT COUNT(*) AS count FROM '.$this->table.'' ;
    	if($champs != null)
    		$sql = mysql_query('SELECT COUNT(*) AS count FROM '.$this->table.' WHERE '.$champs.' = "'.$this->id.'"') ;
    	
    	$data = mysql_fetch_assoc($sql);
    
   		return $data['count'] ;
    
    }
    
     /**
     * Compte le nombre d'entrées pour une requête simple
     * @param $sql Requête a effectué
     * */
    
    public function NumRows($champs){
    	$req = mysql_query('SELECT '.$champs.' FROM '.$this->table.' WHERE '.$champs.' = "'.$this->id.'"');
    	$data = mysql_num_rows($req);
    	//echo 'SELECT '.$champs.' FROM '.$this->table.' WHERE '.$champs.' = "'.$this->id.'"' ;
    	return $data ;
    }
    
    /**
     * Sauvegarde les donnée passé en paramètre dans la base de donnée
     * @param $data Donnée à sauvegarder
     * */
    public function save($data,$update = true){
        if(isset($data[$this->index_update]) && !empty($data[$this->index_update]) && $update){
            $sql = "UPDATE ".$this->table." SET ";
            foreach($data as $k=>$v){
                if($k!="id"){
                    $sql .= "$k='$v',";
                }
            }
            $sql = substr($sql,0,-1);
            $sql .= "WHERE ".$this->index_update."=".$data["id"];
        }
        else{
            $sql = "INSERT INTO ".$this->table." (";
           if($update == true) unset($data["id"]);
            foreach($data as $k=>$v){
           		 	$k = safe($k,'SQL');
            		$v = safe($v,'SQL');
            		
                    $sql .= "`$k`,";
            }
            $sql = substr($sql,0,-1);
            $sql .=") VALUES (";
            foreach($data as $v){
            		$v = safe($v,'SQL');
                    $sql .= "'$v',";
            }
            $sql = substr($sql,0,-1);
            $sql .= ")";
        }
        
        
        

        
        if(mysql_query($sql)){
        	
        	if(!isset($data["id"])){
           		 $this->id=mysql_insert_id();
	        }
	        else{
	            $this->id = $data["id"];
	        }

        
        	return true ;
        }
        	 
        	 
        	       	
       
    }
    
    /**
     * Permet de récupérer plusieurs ligne dans la BDD
     * @param $data conditions de récupérations
     * */
    public function find($data=array()){
            $conditions = "1=1";
            $fields = "*";
            $limit = "";
            $order = "id DESC";
            extract($data);
            if(isset($data["limit"])){ $limit = "LIMIT ".$data["limit"]; }
            $sql = "SELECT $fields FROM ".$this->table." WHERE $conditions ORDER BY $order $limit";
            $req = mysql_query($sql) or die(mysql_error()."<br/> => ".$sql);
            $d = array();
            while($data = mysql_fetch_assoc($req)){
                $d[] = $data;
            }
            return $d;
    }
    
    /**
     * Permet de supprimer une ligne dans la base de donnée
     * @param $id ID de la ligne à supprimer
     * */
    public function delete($id=null){
        if($id==null){ $id = $this->id; }
        $sql = "DELETE FROM ".$this->table." WHERE id=$id";
        $req = mysql_query($sql);
        if($req) return true ;
    }
    
    /**
     * Permet de faire une requête complexe
     * @param $sql Requête a effectué
     * */
        public function query($sql,$data = NULL,$forceWhile = true){
			$this->query = mysql_query($sql) or die(mysql_error()."<br/> => ".$sql);
			$queryData = array();
			if($data == true){	
				if($forceWhile == true){
					while($data = mysql_fetch_assoc($this->query)){
						$queryData[] = $data ;
					}
				}
				else{
					$queryData = mysql_fetch_assoc($this->query);			
				}
				return $queryData ;
			}
				   $this->queryR = $this->query ;
			return $this->query ;
        }
        
      /**
     * Permet de compter le nombre d'entrées pour une requête complexe
     * @param $sql Requête a effectué
     * */
     
     public function NumRowsC(){
     	if($this->query){
     		return mysql_num_rows($this->query);
     	}
     	
     }
     
     public function getQuery($oneRow = NULL)
     {
     	if($this->query)
     	{
	     	if($this->NumRowsC() == 1 OR $oneRow)
				$d = mysql_fetch_assoc($this->query);
			else
				while($data = mysql_fetch_assoc($this->query)){ $d[] = $data ;}
			return $d ;
		}
     }
     
     public function getLastID(){
     	return mysql_insert_id();
     }

    
}
?>