<?php
class Application {

	public $db;
	
	public function __construct() {
		$this->db = new DB(); // new instance of database class.
	}
	
}

