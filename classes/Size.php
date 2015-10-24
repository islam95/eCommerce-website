<?php
	
class Size extends Application{
	
	// getting all the sizes which are numbers
	public function getSizeNumbers(){
		$sql = "SELECT * FROM `size_numbers`
				ORDER BY `id` ASC";	
		return $this->db->getAllRecords($sql);
	}

	// getting only one size which is number
	public function getSizeNumber($id = null){
		if(!empty($id)){
			$sql = "SELECT * FROM `size_numbers`
					WHERE `id` = '".$this->db->escape($id)."'";
			return $this->db->getOneRecord($sql);
		}
	}

	//getting all sizes which are letters like XS, XXL..
	public function getSizeLetters(){
		$sql = "SELECT * FROM `size_letters`
				ORDER BY `id` ASC";	
		return $this->db->getAllRecords($sql);
	}

	// getting only one size which consists of letters
	public function getSizeLetter($id = null){
		if(!empty($id)){
			$sql = "SELECT * FROM `size_letters`
					WHERE `id` = '".$this->db->escape($id)."'";
			return $this->db->getOneRecord($sql);
		}
	}
	
}


