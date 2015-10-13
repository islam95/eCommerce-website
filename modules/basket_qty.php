<?php
require_once('../include/autoload.php');

// See updateBasket() method inside js/basket.js. 
// We passing two parameters using POST - id and qty.
if (isset($_POST['qty']) && isset($_POST['id'])) { // checking if they have been set by POST
	
	$print = array();
	$id = $_POST['id'];
	$value = $_POST['qty'];
	
	$products = new Products();
	$product = $products->getProduct($id);
	
	// If product exists
	if (!empty($product)) {
		
		switch($value) {
			case 0:
			Session::removeItem($id);
			break;
			default:
			Session::setItem($id, $value);
		}
		
	}
	
}