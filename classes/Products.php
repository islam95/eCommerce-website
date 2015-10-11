<?php

class Products extends Application {

	private $categories = 'categories';
	private $products = 'products';

	public $path = 'images/products/';
	public static $currency = '&pound;';
	
	
	// Returns the list of categories ordered alphabetically
	public function getCategories() {
		$sql = "SELECT * FROM `{$this->categories}`
				ORDER BY `name` ASC";
		return $this->db->getAllRecords($sql);
	}
	
	// Returns the category name
	public function getCategory($id){
		$sql = "SELECT * FROM `{$this->categories}`
				WHERE `id` = '".$this->db->escape($id)."'";
		return $this->db->getOneRecord($sql);
	}
	
	// Returns the list of products ordered by newest products first.
	public function getProducts($cat){
		$sql = "SELECT * FROM `{$this->products}`
				WHERE `category` = '".$this->db->escape($cat)."'
				ORDER BY `date` DESC";
		return $this->db->getAllRecords($sql);
	}
	
	
	public function getProduct($id){
		$sql = "SELECT * FROM `{$this->products}`
				WHERE `id` = '".$this->db->escape($id)."'";
		return $this->db->getOneRecord($sql);
	}
	
	public function getAllProducts(){
		$sql = "SELECT * FROM `{$this->products}`
				ORDER BY `name` ASC";
		return $this->db->getAllRecords($sql);
	}
	
}