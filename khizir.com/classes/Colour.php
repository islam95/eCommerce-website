<?php
	
class Colour extends DBinstance{
	
	
	public function getColours(){
		$sql = "SELECT * FROM `colours`
				ORDER BY `name` ASC";
				
		return $this->db->getAllRecords($sql);
	}
	
}