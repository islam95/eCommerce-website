<?php
	
class Order extends DBinstance {
	
	private $orders = 'orders';
	private $o_p = 'orders_products';
	private $statuses = 'statuses';
	private $basket = array();
	private $text = array();
	private $products = array();
	private $values = array();
	private $id = array();
	
	
	public function getProducts(){
		
		$this->basket = Session::getSession('basket');
		
		if(!empty($this->basket)){
			
			$productDir = new ProductDir();
			
			foreach($this->basket as $key => $value){
				
				$this->products[$key] = $productDir->getProduct($key);
			}
		}
	}
	
	public function createOrder(){
		
		$this->getProducts();
		
		if(!empty($this->products)){
			
			$newUser = new User();
			$user = $newUser->getUser(Session::getSession(Login::$user_login));
			
			if(!empty($user)){
				
				$newBasket = new Basket();
				$this->text[] = 'user';
				$this->values[] = $this->db->escape($user['id']);
				
				$this->text[] = 'total';
				$this->values[] = $this->db->escape($newBasket->totalValue);
				
				$this->text[] = 'date';
				$this->values[] = Check::setDate();
				
				$sql  = "INSERT INTO `{$this->orders}` (`";
				$sql .= implode("`, `", $this->text);
				$sql .= "`) VALUES ('";
				$sql .= implode("', '", $this->values);
				$sql .= "')";
				
				$this->db->query($sql);
				$this->id = $this->db->lastID();
				
				if(!empty($this->id)){
					
					$this->text = array();
					$this->values = array();
					
					return $this->addProducts($this->id);
				}
				
			}
			
			return false;
		}
		
		return false;
	}
	
	
	
	private function addProducts($o_id = null){
		
		if(!empty($o_id)){
			
			$error = array();
			
			foreach($this->products as $product){
				
				$sql = "INSERT INTO `{$this->o_p}` 
						(`order`, `product`, `price`, `qty`)
						VALUES ('{$o_id}', '".$product['id']."', '".$product['price']."', '".$this->basket[$product['id']]['qty']."')";
						
				if(!$this->db->query($sql)){
					$error[] = $sql;
				}
			}
			
			return empty($error) ? true : false;
		}
		
		return false;
	}
	
	
	public function getOrder($ID = null){
		
		$ID = !empty($ID) ? $ID : $this->id;
		
		$sql = "SELECT * FROM `{$this->orders}` 
				WHERE `id` = '".$this->db->escape($ID)."'";
		
		return $this->db->getAllRecords($sql);		
		
	}
	
	
	public function getItems($ID = null){
		
		$ID = !empty($ID) ? $ID : $this->id;
		
		$sql = "SELECT * FROM `{$this->o_p}` 
				WHERE `order` = '".$this->db->escape($ID)."'";
		
		return $this->db->getAllRecords($sql);
	}
	
	
	
	
	
	
	
	
	
	
	
}