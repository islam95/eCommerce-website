<?php
$session = Session::getSession('basket');
$basket = new Basket();


$productArray = array();

if(!empty($session)){
	$productDir = new ProductDir();
	foreach($session as $key => $value){
		$productArray[$key] = $productDir->getProduct($key);
	}
}
	
	require_once('header.php');
	require_once('offerSection.php');
	require_once('navigation.php');
	require_once('sidebar.php');
?>
	
<?php if (!empty($productArray)) { ?>	


<div id="cart">
	<h2>Basket</h2>
	<form action="" method="post" id="basket_form">
		<table>
			<tr class="bold">
				<th>Product</th>
				<th>Name</th>
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
				
				<td><?php echo $product['color']; ?></td>
				
			<?php 
				if(!empty($product['size_number'])){
					echo "<td>".$product['size_number']."</td>";
				} else {
					echo "<td>".$product['size_letter']."</td>";
				}
			?>	
				<td>
					<input type="text" name="qty-<?php echo $product['id']; ?>" id="qty-<?php echo $product['id']; ?>" class="input_qty" value="<?php echo $session[$product['id']]['qty']; ?>" />
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
				<td colspan="7" class="total"><p>Total: <span>&pound;<?php echo number_format($basket->totalValue, 2); ?></span></p></td>
			</tr>
		</table>
				
		<form action="?page=checkout" method="post" id="check_out">
			<input type="submit" name="checkout" id="checkout" value="Checkout>" />
		</form>
		<!--
		<div><p><a id="checkout" href="?page=checkout">Checkout >></a></p></div>
		-->
		<div><p class="update"></p></div>
		
	</form>
</div>
<?php } else { ?>
			<h2>Basket is empty!</h2>
			<p>You do not have any items in your basket.</p>
<?php } ?>
	
<?php require_once('footer.php'); ?>