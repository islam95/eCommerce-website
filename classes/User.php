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
	
	// Adds new user to the database
	public function addUser($var = null, $password = null){
		if(!empty($var) && !empty($password)){
			$this->db->insert($var);
			if($this->db->insertData($this->users)){
				
				// sending activation email. 1.php is inside emails folder
				/*
				$email = new Email();
				if($email->process(1, array(
					'email' 		=> $var['email'],
					'first_name' 	=> $var['first_name'],
					'last_name' 	=> $var['last_name'],
					'password' 		=> $password,
					'encode' 		=> $var['encode'] //'encode' is generated in pages/login.php file
				))){
				*/
					return true;
				/*
				}
			return false;
			*/
			}
			return false;
		}
		return false;
	}
	
	// Getting the user by its id.
	public function getUser($id = null){
		if(!empty($id)){
			$sql = "SELECT * FROM `{$this->users}`
					WHERE `id` = '".$this->db->escape($id)."'";
			return $this->db->getOneRecord($sql);
		}
	}
	
	// Getting the user by email
	// used for checking for the same email addresses
	public function getByEmail($email = null){
		if(!empty($email)){
			$sql = "SELECT `id` FROM `{$this->users}`
					WHERE `email` = '".$this->db->escape($email)."'
					AND `active` = 1";
			return $this->db->getOneRecord($sql);
		}
	}

	// Used in pages/activate.php file to get the user by encoding to insert to the link.
	public function getByCode($code = null){
		if(!empty($code)){
			$sql = "SELECT * FROM `{$this->users}`
					WHERE `encode` = '";
			$sql .= $this->db->escape($code)."'";
			return $this->db->getOneRecord($sql);
		}
	}
	
	//Setting the user active when user clicks the link provided by email
	//Used only when activation email function is available.
	public function setActive($id = null){
		if(!empty($id)){
			$sql = "UPDATE `{$this->users}`
					SET `active` = 1
					WHERE `id` = '".$this->db->escape($id)."'";
			return $this->db->query($sql);
		}
	}
	
	// Updating the user info (e.g. in the shipping details.)
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


