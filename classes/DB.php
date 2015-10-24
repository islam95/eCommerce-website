<?php
class DB {

	private $db_host = "localhost";
	private $db_user = "root";
	private $db_password = "";
	private $db_name = "khizir";
	private $connectToDB = false;
	
	public $id;
	// for inserting records to the database.
	public $insert_keys = array(); 
	public $insert_values = array();
	// for updating records.
	public $update_records = array();

	public $last_query = null;
	public $affected_rows = 0; 
	
	
	// Constructor of this class. Executed automatically when this class is instantiated
	public function __construct() {
		$this->connect(); // connecting to the database.
	}
	
	// Connecting to the database
	private function connect() {
		$this->connectToDB = mysql_connect($this->db_host, $this->db_user, $this->db_password);
		if (!$this->connectToDB) {
			die("Database connection error!<br><br>" . mysql_error());
		} else {
			$select = mysql_select_db($this->db_name, $this->connectToDB);
			if (!$select) {
				die("Database selection error!<br><br>" . mysql_error());
			}
		}
		mysql_set_charset("utf8", $this->connectToDB);
	}
	
	// closing the connection
	public function close() {
		if (!mysql_close($this->connectToDB)) {
			die("Closing connection failed.");
		}
	}
	
	// To escape all illegal characters for interacting with the database.
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
			$print  = "Database query failed: ". mysql_error() . "<br>";
			$print .= "Last SQL query was: ".$this->last_query;
			die($print);
		} else {
			$this->affected_rows = mysql_affected_rows($this->connectToDB);
		}
	}
	
	// To get all records from the table in db
	public function getAllRecords($sql) {
		$result = $this->query($sql);
		$output = array();
		while($row = mysql_fetch_assoc($result)) {
			$output[] = $row;
		}
		mysql_free_result($result);
		return $output;
	}
	
	// To get just one specific record from the table in db
	public function getOneRecord($sql) {
		$output = $this->getAllRecords($sql);
		return array_shift($output);
	}
	
	// the id of the lastly inserted record to the database
	public function lastID() {
		return mysql_insert_id($this->connectToDB);
	}
	
	// Method for preparing the data to insert into the table using insertData()
	// used in User.php -> addUser() method
	public function insert($array = null){
		if(!empty($array)){
			foreach($array as $key => $value){
				$this->insert_keys[] = $key;
				$this->insert_values[] = $this->escape($value);
			}
		}
	}
	
	// Inserts data into the table
	// used in User.php -> addUser() method
	public function insertData($users = null){
		if(!empty($users) && !empty($this->insert_keys) && !empty($this->insert_values)){
			$sql  = "INSERT INTO `{$users}` (`";
			$sql .= implode("`, `", $this->insert_keys); // implode - joins the values from array using concatinator (,)
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
	
	// Method for preparing the info to update the table using updateTable()
	// used in User.php -> updateUser()method 
	public function update($array = null){
		if(!empty($array)){
			foreach($array as $key => $value){
				$this->update_records[] = "`{$key}` = '".$this->escape($value)."'";
			}
		}
	}
	
	// Updates the table info
	// used in User.php -> updateUser()method and other
	public function updateTable($table = null, $id = null){
		if(!empty($table) && !empty($id) && !empty($this->update_records)){
			$sql  = "UPDATE `{$table}` SET ";
			$sql .= implode(", ", $this->update_records);
			$sql .= " WHERE `id` = '".$this->escape($id)."'";
			return $this->query($sql);
		}
	}
	

	
}


