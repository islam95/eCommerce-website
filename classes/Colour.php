<?php
	
class Colour extends Application{
	
	public function getColours(){
		$sql = "SELECT * FROM `colours`
				ORDER BY `id` ASC";
		return $this->db->getAllRecords($sql);
	}
	
}

