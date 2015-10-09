<?php
require_once('../include/autoload.php');
	
if(isset($_POST['id']) && isset($_POST['job'])){
	
	$print = array();
	$id = $_POST['id'];
	$job = $_POST['job'];
	
	$products = new Products();
	$product = $products->getProduct($id);
	
	
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
		
		echo json_encode($print);
		
	} 
	
	
	
}	