<?php
require_once('../include/load.php');
	
// tokens
$token2 = Session::getSession('token2');
$form = new Select();
$token = $form->getPost('token');

if($token2 == Login::encrypt($token)){
	
	// Creating order.
	$newOrder = new Order();
	
	if($newOrder->createOrder()){
		
		// insert into order details.
		$order = $newOrder->getOrder();
		$products = $newOrder->getItems();
		
		if(!empty($order) && !empty($products)){
			
			$newBasket = new Basket();
			$productDir = new ProductDir();
			$newPayPal = new PayPal();
			
			foreach($products as $product){
				$item = $productDir->getProduct($product['product']);
				$newPayPal->addProduct($product['product'], $item['name'], $product['price'], $product['qty']);
			}
			
			$newUser = new User();
			$user = $newUser->getUser($order['user']);
			
			if(!empty($user)){
				
				$newPayPal->populate = array(
					'address1' => $user['address_1'],
					'address2' => $user['address_2'],
					'city' => $user['city'],
					'state' => $user['county'],
					'zip' => $user['post_code'],
					'country' => 'GB',
					'email' => $user['email'],
					'first_name' => $user['first_name'],
					'last_name' => $user['last_name']
				);
				
				// redirecting to PayPal
				echo $newPayPal->redirectPayPal($order['id']);
				
			}
			
		}
		
	}
}