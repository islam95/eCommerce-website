<?php
	
class Order extends Application {
	
	private $orders = 'orders';
	private $o_p = 'orders_products';
	private $statuses = 'statuses';

	private $basket = array();
	private $fields = array();
	private $products = array();
	private $values = array();
	private $id = null;
	
	
	// Get products from the session from basket
	public function getProducts(){
		$this->basket = Session::getSession('basket');
		if(!empty($this->basket)){
			$objProducts = new Products();
			foreach($this->basket as $key => $value){
				$this->products[$key] = $objProducts->getProduct($key);
			}
		}
	}
	
	//used in modules/paypal.php file to create an order
	public function createOrder(){
		$this->getProducts();
		if(!empty($this->products)){
			$newUser = new User();
			$user = $newUser->getUser(Session::getSession(Login::$user_login));
			
			if(!empty($user)){
				$newBasket = new Basket();
				$this->fields[] = 'user';
				$this->values[] = $this->db->escape($user['id']);
				
				$this->fields[] = 'total';
				$this->values[] = $this->db->escape($newBasket->total_value);
				
				$this->fields[] = 'date';
				$this->values[] = Check::setDate();
				
				$sql  = "INSERT INTO `{$this->orders}` (`";
				$sql .= implode("`, `", $this->fields);
				$sql .= "`) VALUES ('";
				$sql .= implode("', '", $this->values);
				$sql .= "')";
				
				$this->db->query($sql);
				$this->id = $this->db->lastID();
				
				if(!empty($this->id)){
					//clearing up the arrays
					$this->fields = array();
					$this->values = array();
					return $this->addProducts($this->id);//can add later an item to the order
				}
			}
			return false;
		}
		return false;
	}
	
	// Adding products to the orders_products table.
	private function addProducts($order_id = null){
		if(!empty($order_id)){
			$error = array();
			foreach($this->products as $product){
				$sql = "INSERT INTO `{$this->o_p}` 
						(`order`, `product`, `price`, `qty`)
						VALUES ('{$order_id}', '".$product['id']."', '".$product['price']."', '".$this->basket[$product['id']]['qty']."')";
				if(!$this->db->query($sql)){
					$error[] = $sql;
				}
			}
			return empty($error) ? true : false;
		}
		return false;
	}
	
	public function getOrder($_id = null){
		$_id = !empty($_id) ? $_id : $this->id;
		$sql = "SELECT * FROM `{$this->orders}` 
				WHERE `id` = '".$this->db->escape($_id)."'";
		return $this->db->getOneRecord($sql);	
	}
	
	public function getOrderItems($order_id = null){
		$order_id = !empty($order_id) ? $order_id : $this->id;
		$sql = "SELECT * FROM `{$this->o_p}` 
				WHERE `order` = '".$this->db->escape($order_id)."'";
		return $this->db->getAllRecords($sql);
	}
	
	
	

}


