<?php
	
class Session {

	public static function setItem($id, $qty = 1) {
		// Creating a sesssion called basket with the id of the product and its quantity.
		$_SESSION['basket'][$id]['qty'] = $qty; 
	}
	
	// Removing an item from the session.
	public static function removeItem($id, $qty = null) {
		if ($qty != null && $qty < $_SESSION['basket'][$id]['qty']) {
			$_SESSION['basket'][$id]['qty'] = ($_SESSION['basket'][$id]['qty'] - $qty);
		} else {
			$_SESSION['basket'][$id] = null;
			unset($_SESSION['basket'][$id]);
		}
	}
	
	public static function getSession($session = null){
		if(!empty($session)){
			return isset($_SESSION[$session]) ? $_SESSION[$session] : null;
		}
	}

	public static function setSession($name = null, $value = null){
		if(!empty($name) && !empty($value)){
			$_SESSION[$name] = $value;
		}
	}

	// To clear the session, e.g. the basket 
	public static function clear($id = null){
		if (!empty($id) && isset($_SESSION[$id])) {
			$_SESSION[$id] = null;
			unset($_SESSION[$id]);			
		} else{
			//if we don't pass any parameter all the sessions will be cleared.
			session_destroy();
		}
	}


}

