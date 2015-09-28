<?php
class URL {

	public static $folder = PAGES_FOLDER;
	public static $page = "page";
	public static $params = array();
	
	public static function getParameter($param) {
		return isset($_GET[$param]) && $_GET[$param] != "" ?
				$_GET[$param] : null;
		
	}
	
	public static function currentPage() {
		return isset($_GET[self::$page]) ? 
				$_GET[self::$page] : 'index';
	}
	
	public static function getPage() {
		$currentPage = self::$folder.DIR_SEP.self::currentPage().".php";
		$error = self::$folder.DIR_SEP."error.php";
		return is_file($currentPage) ? $currentPage : $error;
	}
	
	public static function getAll() {
		if (!empty($_GET)) {
			foreach($_GET as $key => $value) {
				if (!empty($value)) {
					self::$params[$key] = $value;
				}
			}
		}
	}
	
	public static function getURL($remove = null){
		
		self::getAll();
		$arr = array();

		if(!empty($remove)){
			$remove = !is_array($remove) ? array($remove) : $remove;
			foreach(self::$params as $key => $value){
				if(in_array($key, $remove)){
					unset(self::$params[$key]);
				}
			}
		}

		foreach(self::$params as $key => $value){
			$arr[] = $key."=".$value;
		}

		return "?".implode("&", $arr);
	}
	
	
	
	public static function getRedirectURL(){
		
		$aPage = self::getParameter(Login::$redirect);
		
		return !empty($aPage) ? "?page={$aPage}" : null;
	}
	
	
	
	
	
	
	
	
	
}