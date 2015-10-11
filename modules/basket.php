<?php
require_once('../include/autoload.php');
	
if(isset($_POST['job']) && isset($_POST['id'])){
	
	$print = array();
	$job = $_POST['job'];
	$id = $_POST['id'];
	
	$products = new Products();
	$product = $products->getProduct($id);
	
	// If the product has been found
	if(!empty($product)){
		
		switch($job){
			
			case 0:
			Session::removeItem($id);
			$print['job'] = 1;
			break;
			
			case 1:
			Session::setItem($id);
			$print['job'] = 0;
			break;
			
		}
		
		echo json_encode($print); // converts normal php array to javascript array.
		
	} 
	
	
	
}	