<?php

Login::noAccess(); // not logged in user cannot access this page

$token = mt_rand();
$tokenEncrypted = Login::encrypt($token);

Session::setSession('tokenEncrypted', $tokenEncrypted);

$basket = new Basket();
$productArray = array();
$session = Session::getSession('basket');

if(!empty($session)){
	$products = new ProductDir();
	
	foreach($session as $key => $value){
		$productArray[$key] = $products->getProduct($key);
	}
}

require_once('header.php');
require_once('navigation.php');
require_once('sidebar.php');
?>


<?php if(!empty($productArray)){ ?>
		<div id="cart">
			<h2>Order summary</h2>
			<form action="" method="post" id="basket_form">
				<table>
					<tr class="bold">
						<th>Name</th>
						<th>Color</th>
						<th>Size</th>
						<th>Qty</th>
						<th>Price</th>
					</tr>		
					<tr>
						<td colspan="5">
							<hr />
						</td>
					</tr>
					<?php foreach($productArray as $product){ ?>
							<tr>
								<td class="title">
								<?php echo $product['name']; ?>
								</td>
								
								<td><?php echo $product['color']; ?></td>
								
								<?php 
									if(!empty($product['size_number'])){
										echo "<td>".$product['size_number']."</td>";
									} else {
										echo "<td>".$product['size_letter']."</td>";
									}
								?>
									
								<td>
								<?php echo $session[$product['id']]['qty']; ?> 
								</td>
								
								<td>
									&pound;<?php echo number_format($basket->priceByQty($product['price'], $session[$product['id']]['qty']), 2); ?>
								</td>
								
							</tr>
							<tr>
								<td colspan="5">
									<hr />
								</td>
							</tr>
					<?php } ?>
					
					<tr>
						<td colspan="5" class="total"><p>Total: <span>&pound;<?php echo number_format($basket->totalValue, 2); ?></span></p>
						</td>
					</tr>
				</table>
				
				<div class="paypal" id="<?php echo $token; ?>">
						<span class="paypal_btn">Proceed to PayPal>></span>
				</div>
				
				<div>
					<a href="?page=basket" class="back">Back to Basket</a>
				</div>
				
				 
			</form>
		</div>	
		<div>
			<p class="dn loading"></p>
		</div>
	
<?php } else { ?>
		<p>You do not have any items in you basket.</p>
		
<?php } ?>

<?php
require_once('footer.php');
?>