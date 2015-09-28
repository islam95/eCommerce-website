<?php
class DBinstance {

	public $db;
	
	public function __construct() {
		$this->db = new DB();
	}
	
}