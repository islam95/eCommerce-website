<?php
require_once('../include/autoload.php');
	
// tokens
$token2 = Session::getSession('token2');
$form = new Form();
$token1 = $form->getPost('token');

// checking if they match
if($token2 == Login::encrypt($token1)){
	// Creating order.
	$newOrder = new Order();
	if($newOrder->createOrder()){
		//populate order details.
		$order = $newOrder->getOrder();
		$items = $newOrder->getOrderProducts();
		
		if(!empty($order) && !empty($items)){
			$newProducts = new Products();
			$newPayPal = new PayPal();
			
			foreach($items as $item){
				$product = $newProducts->getProduct($item['product']);
				$newPayPal->addProduct($item['product'], $product['name'], $item['price'], $item['qty']);
			}
			//populate user details.
			$newUser = new User();
			$user = $newUser->getUser($order['user']);
			
			if(!empty($user)){
				// passing user details to PayPal instance.
				$newPayPal->populate = array(
					'address1' 		=> $user['address_1'],
					'address2' 		=> $user['address_2'],
					'city' 			=> $user['city'],
					'state' 		=> $user['county'],
					'zip' 			=> $user['post_code'],
					'country' 		=> 'GB',
					'email' 		=> $user['email'],
					'first_name' 	=> $user['first_name'],
					'last_name' 	=> $user['last_name']
				);
				
				// redirecting the user to PayPal
				echo $newPayPal->run($order['id']);
			}
		}
	}
}

