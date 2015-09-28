<?php
require_once('../include/load.php');

if (isset($_POST['qty']) && isset($_POST['id'])) {
	
	$print = array();
	$id = $_POST['id'];
	$number = $_POST['qty'];
	
	$productDir = new ProductDir();
	$product = $productDir->getProduct($id);
	
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