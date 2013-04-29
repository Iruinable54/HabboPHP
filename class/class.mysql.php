<?php

class Mysql{

	 /** @var string Server (eg. localhost) */
     protected $_server;
     
     /** @var string Database user (eg. root) */
     protected $_user;
            
     /** @var string Database password (eg. can be empty !) */
     protected $_password;
            
     /** @var string Database type (MySQL, PgSQL) */
     protected $_type;
            
     /** @var string Database name */
     protected $_database;
     
     /** @var mixed Ressource link */
     protected $_link;
            
     /** @var mixed SQL cached result */
     protected $_result;
     
     private $_portdb ;
     
     /** @var mixed ? */
     protected static $_db;  
     
     public $connection ;   

            
     /** @var mixed Object instance for singleton */
     private static $_instance;
     
     public function __construct($server,$user,$password,$database){
     
     	$this->_server = $server;
      	$this->_user = $user;
      	$this->_password = $password;
      	$this->_database = $database;
      	//$this->_database_type = $database_type ;
      	
      	$this->connectBDD();
      	
     }
    
	public function connectBDD(){  
		try
		{

	  			$connection = mysql_connect($this->_server, $this->_user, $this->_password);	  			
	  			if ($connection === false)
	  			{
	    			throw new Exception('Cannot connect to mysql ( ERROR 01 ) Impossible de se connect&eacute; à la base de donn&eacute;e');
	  			}
		}
		catch (Exception $e)
		{
  			echo $e->getMessage();
  			exit ;
		}
		
		try
		{
	  		$database = mysql_select_db($this->_database);
	 
	 		if ($database === false){
	    		throw new Exception('Cannot connect to database : '.$this->_database.' ( ERROR 02 ) La base de donn&eacute;e choisie n\'&eacute;xiste pas');
	  		}
	  	}
		catch (Exception $e)
		{
	  		echo $e->getMessage();
	  		exit ;
		}
	

		
    }
    
    
    public function __sleep(){
    	mysql_close();
    }
    
     public function __wakeup()
     {
     	$this->connexionBDD();
     }
     
        
}

?>