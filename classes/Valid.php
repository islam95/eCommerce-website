<?php
class Valid {
	
	private $select;
	private $errors = array(); 
	public $expect = array();
	public $requirement = array();
	public $spec_field = array();
	public $post = array();
	public $remove_post = array();
	public $format_post = array();
	// messages for user
	public $message = array(
		"first_name" => "You missed your first name",
		"last_name" => "You missed your last name",
		"address_1" => "You missed first line of your address",
		"city" => "You missed your city name",
		"county" => "You missed your county name",
		"post_code" => "You missed your post code",
		"country" => "You missed your country name",
		"email" => "Please provide valid email address",
		"same-email" => "This email address already exists",
		"login" => "Please enter a valid email address or password.",
		"password" => "Please create a password",
		"confirm_password" => "Please confirm a password above",
		"password_match" => "Passwords does not match"
	);	
	
	
	public function __construct($select){
		$this->select = $select;
	}
	
	
	public function process(){
		if($this->select->isPost() && !empty($this->requirement)){
			// get only expected fields
			$this->post = $this->select->postList($this->expect);
			if(!empty($this->post)){
				foreach($this->post as $key => $value){
					$this->check($key, $value);
				}
			}
		}
	}
	
	
	public function inErrors($key){
		$this->errors[] = $key;
	}
	
	
	
	
	
	public function check($key, $value){
		if(!empty($this->spec_field) && array_key_exists($key, $this->spec_field)) {
			$this->checkSpecField($key, $value);
		} else {
			if(in_array($key, $this->requirement) && empty($value)){
				$this->inErrors($key);
			}
		}
	}
	
	public function checkSpecField($key, $value){
		switch($this->spec_field[$key]){
			case 'email':
			if (!$this->isEmail($value)){
				$this->inErrors($key);
			}
			break;
		}
	}

	
	
	
	public function isEmail($email = null){
		if(!empty($email)){
			$result = filter_var($email, FILTER_VALIDATE_EMAIL);
			return !$result ? false : true;
		}
		return false;
	}
	
	
	
	public function isValid(){
		$this->process();
		
		if(empty($this->errors) && !empty($this->post)){
			// Remove all unwanted fields.
			if(!empty($this->remove_post)){
				foreach($this->remove_post as $value){
					unset($this->post[$value]);
				}
			}
			
			// Format all required fields
			if(!empty($this->format_post)){
				foreach($this->format_post as $key => $value){
					$this->format($key, $value);
				}
			}
			return true;
		}
		return false;
	}
	
	
	
	
	public function format($key, $value){
		switch($value){
			case 'password':
			$this->post[$key] = Login::encrypt($this->post[$key]);
			break;
		}
	}
	
	
	
	public function warn($key){
		if(!empty($this->errors) && in_array($key, $this->errors)){
			return $this->warning($this->message[$key]);
		}
	}
	
	
	public function warning($string = null){
		if(!empty($string)){
			return "<span class=\"warning\">{$string}</span>";
		}
	}
	
	
	
	
	
}