<?php
	
class Size extends Application{
	
	public function getSizeNumbers(){
		$sql = "SELECT * FROM `size_numbers`
				ORDER BY `id` ASC";	
		return $this->db->getAllRecords($sql);
	}

	public function getSizeLetters(){
		$sql = "SELECT * FROM `size_letters`
				ORDER BY `id` ASC";	
		return $this->db->getAllRecords($sql);
	}
	
}


