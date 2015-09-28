<?php
	
class Main {
	
	public function run() {
		
		ob_start();
		require_once(URL::getPage());
		ob_get_flush();
	}

}