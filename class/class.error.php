<?php
	class Error
		{
		private $error;
		
		public function __construct()
		{
			$this->error = array();
		}
		
		public function set($index, $msg)
		{
			$this->error[$index] = $msg;
		}
		
		public function exist($index)
		{
			if (isset($this->error[$index]))
			{
				return true;
			}
			return false;
		}
		
		public function display($index)
		{
			if ($this->exist($index))
			{
				return ($this->error[$index]);
			}
			return false;
		}
		
		public function Get(){
			return $this->error ;
		}
			
		public function ErrorPresent()
		{
			foreach($this->error as $val)
			{
				if ($val != '')
				{
					return true;
				}
			}
			return false;
		}
		public function __destruct()
		{
			unset($this->error);
		}
	}
	
?>