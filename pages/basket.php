<?php
$session = Session::getSession('basket'); // populating the information on the basket

$basket = new Basket();

$productArray = array();

if(!empty($session)){
	$objProducts = new Products();
	foreach($session as $key => $value){
		$productArray[$key] = $objProducts->getProduct($key);
	}
}

require_once('header.php');
require_once('offerSection.php');
require_once('navigation.php');
require_once('sidebar.php');
?>
	
<?php if (!empty($productArray)) { ?>	


<div id="cart">
	<h2>Your basket</h2>
	<form action="" method="post" id="basket_form">
		<table>
			<tr class="bold">
				<th>Product</th>
				<th class="name">Name</th>
				<th>Color</th>
				<th>Size</th>
				<th>Qty</th>
				<th>Price</th>
				<th></th>
			</tr>
			<tr>
				<td colspan="7">
					<hr />
				</td>
			</tr>

	<?php foreach($productArray as $product){ ?>
			<tr>
				<td>
					<?php 
						$image = !empty($product['image']) ? 'images/products/'.$product['image'] : null;

						if(!empty($image)){
							echo "<img src=\"{$image}\" alt=\"";
							echo Check::encodeHTML($product['name'], 1);
							echo "\" class=\"photo\" />";
						}					
					?>
				</td>
				
				<td class="title">
					<?php echo Check::encodeHTML($product['name']); ?>
				</td>
				
				<td><?php echo $product['colour']; ?></td>
				
			<?php 
				if(!empty($product['size_number'])){
					echo "<td>".$product['size_number']."</td>";
				} else {
					echo "<td>".$product['size_letter']."</td>";
				}
			?>	
				<td>
					<!-- name and id = qty-product_id So that each row will have different name assigned to it
						Used in js/basket.js file to update the total value of all products in the basket.
					-->
					<input type="text" name="qty-<?php echo $product['id']; ?>" id="qty-<?php echo $product['id']; ?>" 
					class="input_qty" value="<?php echo $session[$product['id']]['qty']; ?>" />
				</td>
				<td>
					&pound;<?php echo number_format($basket->priceByQty($product['price'], $session[$product['id']]['qty']), 2); ?>
				</td>
				<td>
					<?php echo Basket::removeX($product['id']); ?>		
				</td>
			</tr>
			<tr>
				<td colspan="7">
					<hr />
				</td>
			</tr>
	<?php } ?>
		
			<tr>
				<td colspan="7" class="total">
					<p>Total: <span>&pound;<?php echo number_format($basket->total_value, 2); ?></span></p>
				</td>
			</tr>
		</table>
				
		<!--
<form action="?page=checkout" method="post" id="check_out">
			<input type="submit" name="checkout" id="checkout" value="Checkout>" />
		</form>
-->
		<!-- Checkout button -->
		<div class="checkout">
			<a href="?page=checkout" class="checkout_btn">Checkout &raquo;</a>
		</div>
		
		<!-- Update the basket button -->
		<div class="update_basket">
			<span class="update_btn">Update</span>
		</div>
		
	</form>
</div>
<?php } else { ?>
			<h2>Basket is empty!</h2>
			<p>You do not have any items in your basket.</p>
<?php } ?>
	
<?php require_once('footer.php'); ?>




