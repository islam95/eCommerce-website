<?php
	
class Login {
    
    // for users
	public static $login_page = "?page=login"; // url of this page
	public static $orders_page = "?page=orders"; // url of order page
	public static $user_login = "uID"; // user id
	
	// for admin
	public static $login_page_admin = "admin";
	public static $dashboard_admin = "admin/?page=products";
    public static $admin_login = "aID";

	public static $redirect = "redirect";
	public static $valid = "valid";
	
	
	// Checking if the user is logged in already
	public static function loggedIn($case = null){
		if(!empty($case)){
			if(isset($_SESSION[self::$valid]) && $_SESSION[self::$valid] == 1){
				return isset($_SESSION[$case]) ? true : false;
			}
			return false;
		}
		return false;
	}
	
	// used in login.php
	public static function userLogin($id, $url = null) {
		$url = !empty($url) ? $url : self::$orders_page;
		$_SESSION[self::$user_login] = $id;
		$_SESSION[self::$valid] = 1;
		
		Check::redirect($url);
	}
	
	// Used in checkout.php to restrict the user to continue without login
	public static function noAccess(){
		// Checking if the user is logged in
		if(!self::loggedIn(self::$user_login)){
			$url = URL::currentPage() != "logout" ? 
			self::$login_page."&".self::$redirect."=".URL::currentPage() : 
			self::$login_page;
			
			Check::redirect($url);
		}
	}
	
	// encrypting string (passwords) with hash encryption called sha384,
	// can be used any hash function. 
	public static function encrypt($string = null){ // See Valid.php -> format() method
		if(!empty($string)){
			return hash('sha384', $string);
		}
	}
	
	
	
}


