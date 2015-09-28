<?php
class Company extends DBinstance {
	
	private $table = 'company';
	
	public function getCompany() {
		$sql = "SELECT * FROM `{$this->table}`
				WHERE `id` = 1";
		return $this->db->getOneRecord($sql);
	}
	
	
	
}