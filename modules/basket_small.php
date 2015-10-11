
<?php $basket = new Basket(); ?>

<div id="smallB">
	<h3>Basket</h3>
	<table id="basket_small">
		<tr>
			<td>Items:</td>
			<!-- Relates to /modules/basket_small_refresh.php -->
			<td class="items"><span><?php echo $basket->num_of_items; ?></span></td>
		</tr>
		<tr>
			<td>Total:</td>
			<!-- Relates to /modules/basket_small_refresh.php -->
			<td class="total">&pound;<span><?php echo number_format($basket->total_value, 2); ?></span></td>
		</tr>
	</table>
	<p><a href="?page=basket">View Basket</a> | <a href="?page=checkout">Checkout</a></p>
</div>