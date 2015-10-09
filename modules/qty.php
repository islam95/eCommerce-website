<?php
require_once('../include/autoload.php');

if (isset($_POST['qty']) && isset($_POST['id'])) {
	
	$print = array();
	$id = $_POST['id'];
	$number = $_POST['qty'];
	
	$products = new Products();
	$product = $products->getProduct($id);
	
	if (!empty($product)) {
		
		switch($number) {
			case 0:
			Session::removeItem($id);
			break;
			default:
			Session::setItem($id, $number);
		}
		
	}
	
}