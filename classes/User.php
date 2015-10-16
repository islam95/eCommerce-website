<?php
	
class User extends Application {
	
	private $users = "users"; // users table in db
	public $user_id;
	
	
	// Check if the user with specific email address and password exists.
	public function exist($email, $password){
		$password = Login::encrypt($password); // encripting the password
		
		$sql = "SELECT * FROM `{$this->users}` 
				WHERE `email` = '".$this->db->escape($email)."' 
				AND `password` = '".$this->db->escape($password)."'
				AND `active` = 1";
				
		$result = $this->db->getOneRecord($sql);
		
		if(!empty($result)) {
			$this->user_id = $result['id'];
			return true;
		}
		return false;
	}
	
	
	
	public function addUser($var = null, $password = null){
		
		if(!empty($var) && !empty($password)){
   			$this->db->insert($var);
   			if($this->db->insertData($this->users)){
				return true;
   			}
   		}
   		return false;

	}
	
	
	
	public function getByEmail($email = null){
		if(!empty($email)){
			$sql = "SELECT `id` FROM `{$this->users}`
					WHERE `email` = '".$this->db->escape($email)."'";
			return $this->db->getOneRecord($sql);
		}
	}
	
	
	
	public function getUser($id = null){
		if(!empty($id)){
			$sql = "SELECT * FROM `{$this->users}`
					WHERE `id` = '".$this->db->escape($id)."'";
			return $this->db->getOneRecord($sql);
		}
	}
	
	
	
	public function updateUser($array = null, $id = null){
		
		if(!empty($array) && !empty($id)){
			$this->db->update($array);
			
			if($this->db->updateTable($this->users, $id)){
				return true;
			}
			return false;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
}