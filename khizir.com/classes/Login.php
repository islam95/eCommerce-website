<?php
	
class Login {
	
	public static $login_page = "?page=login";
	public static $orders_page = "?page=orders";
	public static $user_login = "uID";
	public static $redirect = "redirect";
	public static $valid = "valid";
	
	
	public static function loggedIn($sess = null){
		
		if(!empty($sess)){
			
			if(isset($_SESSION[self::$valid]) && $_SESSION[self::$valid] == 1){
				
				return isset($_SESSION[$sess]) ? true : false;
			}
			
			return false;
		}
		
		return false;
	}
	
	
	public static function userLogin($id, $url = null) {
			
		$url = !empty($url) ? $url : self::$orders_page;
		
		$_SESSION[self::$user_login] = $id;
		$_SESSION[self::$valid] = 1;
		
		Check::redirect($url);
	}
	
	
	public static function noAccess(){
		
		if(!self::loggedIn(self::$user_login)){
			
			$url = URL::currentPage() != "logout" ? 
			self::$login_page."&".self::$redirect."=".URL::currentPage() : 
			self::$login_page;
			
			Check::redirect($url);
		}
	}
	
	
	// encrypting string (passwords) with hash encryption called sha384,
	// can be used any hash function for this assignment purpose.
	public static function encrypt($string = null){
		
		if(!empty($string)){
			
			return hash('sha384', $string);
		}
	}
	
}