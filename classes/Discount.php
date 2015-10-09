<?php
class Discount extends Application {
	
	private $table = 'discounts';
	
	public function getDiscount() {
		$sql = "SELECT * FROM `{$this->table}`
				WHERE `id` = 1";
		return $this->db->getOneRecord($sql);
	}
	
	
	
}