<!-- This is going to be a javascript pop up basket on any page when a basket icon is clicked. -->
<?php $basket = new Basket(); ?>

<div id="smallB">
	<h3>Basket</h3>
	<table id="basket_right">
		<tr>
			<td>Items:</td>
			<td class="items"><span><?php echo $basket->numOfItems; ?></span></td>
		</tr>
		<tr>
			<td>Total:</td>
			<td class="total">&pound;<span><?php echo number_format($basket->totalValue, 2); ?></span></td>
		</tr>
	</table>
	<p><a href="?page=basket">View Basket</a> | <a href="?page=checkout">Checkout</a></p>
</div>