<?php
class Basket {
	
	public $products;
	public $empty_basket;
	public $num_of_items;
	public $total_value;
	
	public function __construct() {
		$this->products = new Products();
		// is basket empty or not?
		$this->empty_basket = empty($_SESSION['basket']) ? true : false;
		
		$this->numOfItems();
		$this->total();
	}
	
	// Number of items in the basket
	public function numOfItems() {
		$value = 0;
		if (!$this->empty_basket) {
			foreach($_SESSION['basket'] as $key => $items) {
				$value += $items['qty']; //number of items in the basket
			}
		}
		$this->num_of_items = $value;
	}
	
	// Total value of the items in the basket.
	public function total() {
		$value = 0;
		if (!$this->empty_basket) {
			foreach($_SESSION['basket'] as $key => $items) {
				$product = $this->products->getProduct($key);
				$value += ($items['qty'] * $product['price']);	
			}
		}		
		$this->total_value = round($value, 2);
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
		$print .= $id == 0 ? " remove_btn" : null;
		$print .= "\" rel=\"";
		$print .= $session_id."_".$id;
		$print .= "\">{$label}</a>";
		return $print;
	}
	
	// See pages/basket.php Used to calculate the total amount in main basket.
	public function priceByQty($price = null, $qty = null) {
		if (!empty($price) && !empty($qty)) {
			return round(($price * $qty), 2); 
		}
	}
	
	// See pages/basket.php and removeFromBasket() in basket.js. 
	// This red cross button removes the item from the main basket.
	public static function removeX($id = null) {
		if (!empty($id)) {
			//If the product is in the basket 
			if (isset($_SESSION['basket'][$id])) {
				$print  = "<a href=\"#\" class=\"remove_item removeX";
				$print .= "\" rel=\"{$id}\"></a>";
				return $print;
			}
		}
	}
	


}


