<?php
class Basket {
	
	public $products;
	public $emp;
	public $numOfItems;
	public $totalValue;
	
	public function __construct() {
		$this->products = new Products();
		$this->emp = empty($_SESSION['basket']) ? true : false;
		
		$this->numOfItems();
		$this->total();
		
	}
	
	public function numOfItems() {
		$value = 0;
		if (!$this->emp) {
			foreach($_SESSION['basket'] as $key => $items) {
				$value += $items['qty'];
			}
		}
		$this->numOfItems = $value;
	}
	
	
	public function total() {
		$value = 0;
		if (!$this->emp) {
			foreach($_SESSION['basket'] as $key => $items) {
				$product = $this->products->getProduct($key);
				$value += ($items['qty'] * $product['price']);	
			}
		}		
		$this->totalValue = round($value, 2);
	}
	
	// Method for the buttons: Add to basket and Remove.
	public static function activeButton($session_id) {
		if(isset($_SESSION['basket'][$session_id])) {
			$id = 0;
			$label = "Remove";
		} else {
			$id = 1;
			$label = "Add to basket";
		}
		
		$print  = "<a href=\"#\" class=\"add_to_basket";
		$print .= $id == 0 ? " red" : null;
		$print .= "\" rel=\"";
		$print .= $session_id."_".$id;
		$print .= "\">{$label}</a>";
		return $print;
	}
	
	

   	public function priceByQty($price = null, $qty = null) {
   		if (!empty($price) && !empty($qty)) {
   			return round(($price * $qty), 2);
   		}
   	}
   	
   	
   	public static function removeX($id = null) {
   		if (!empty($id)) {
   			if (isset($_SESSION['basket'][$id])) {
   				$print  = "<a href=\"#\" class=\"removeItem removeX";
   				$print .= "\" rel=\"{$id}\"></a>";
   				return $print;
   			}
   		}
   	}


	
	
	
	
	
	

}