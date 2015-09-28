<?php
class DB {

	private $db_host = "localhost";
	private $db_user = "acjx557";
	private $db_password = "100041754";
	private $db_name = "acjx557";
	private $connectToDB = false;
	
	public $id;
	public $insert_keys = array();
	public $insert_values = array();
	public $update_records = array();
	public $last_query = null;
	public $affected_rows = 0;
	
	
	
	public function __construct() {
		$this->connect();
	}
	
	
	private function connect() {
		
		$this->connectToDB = mysql_connect($this->db_host, $this->db_user, $this->db_password);
		
		if (!$this->connectToDB) {
			
			die("Database connection error!<br />" . mysql_error());
			
		} else {
			
			$select = mysql_select_db($this->db_name, $this->connectToDB);
			
			if (!$select) {
				
				die("Database selection error!<br />" . mysql_error());
			}
		}
		
		mysql_set_charset("utf8", $this->connectToDB);
	}
	
	
	public function close() {
		
		if (!mysql_close($this->connectToDB)) {
			
			die("Closing connection failed.");
		}
	}
	
	
	public function escape($value) {
		
		if(function_exists("mysql_real_escape_string")) {
			
			if (get_magic_quotes_gpc()) {
				
				$value = stripslashes($value);
			}
			
			$value = mysql_real_escape_string($value);
			
		} else {
			
			if(!get_magic_quotes_gpc()) {
				
				$value = addcslashes($value);
			}
		}
		
		return $value;
	}
	
	
	public function query($sql) {
		
		$this->last_query = $sql;
		$result = mysql_query($sql, $this->connectToDB);
		$this->displayQuery($result);
		
		return $result;
	}
	
	
	public function displayQuery($result) {
		
		if(!$result) {
			
			$print  = "Database query failed: ". mysql_error() . "<br />";
			$print .= "SQL query was: ".$this->last_query;
			
			die($print);
			
		} else {
			
			$this->affected_rows = mysql_affected_rows($this->connectToDB);
		}
	}
	
	
	public function getAllRecords($sql) {
		
		$result = $this->query($sql);
		$output = array();
		
		while($row = mysql_fetch_assoc($result)) {
			
			$output[] = $row;
		}
		
		mysql_free_result($result);
		
		return $output;
	}
	
	
	public function getOneRecord($sql) {
		
		$output = $this->getAllRecords($sql);
		
		return array_shift($output);
	}
	
	
	public function lastID() {
		
		return mysql_insert_id($this->connectToDB);
	}
	
	
	public function insert($array = null){
		
		if(!empty($array)){
			
			foreach($array as $key => $value){
				
				$this->insert_keys[] = $key;
				$this->insert_values[] = $this->escape($value);
			}
		}
	}
	
	
	public function insertData($users = null){
		
		if(!empty($users) && !empty($this->insert_keys) && !empty($this->insert_values)){
			
			$sql  = "INSERT INTO `{$users}` (`";
			$sql .= implode("`, `", $this->insert_keys);
			$sql .= "`) VALUES ('";
			$sql .= implode("', '", $this->insert_values);
			$sql .= "');";
			
			if($this->query($sql)){
				
				$this->id = $this->lastID();
				
				return true;
			}
			
			return false;
		}
	}
	
	
	public function update($array = null){
		
		if(!empty($array)){
			
			foreach($array as $key => $value){
				
				$this->update_records[] = "`{$key}` = '".$this->escape($value)."'";
			}
		}
	}
	
	
	public function updateTable($table = null, $id = null){
		
		if(!empty($table) && !empty($id) && !empty($this->update_records)){
			
			$sql  = "UPDATE `{$table}` SET ";
			$sql .= implode(", ", $this->update_records);
			$sql .= " WHERE `id` = '".$this->escape($id)."'";
			
			return $this->query($sql);
		}
	}
	
	
	
	
	
}