<?php
// no access for whome is not logged in.
Login::noAccess();

$token1 = mt_rand(); //generating random number
$token2 = Login::encrypt($token1); // encrypting for security
Session::setSession('token2', $token2);

$basket = new Basket();
$array = array();
$session = Session::getSession('basket'); //for all the products which are currently in the basket

// populating the array with the products.
if(!empty($session)){
	$objProducts = new Products();
	foreach($session as $key => $value){
		$array[$key] = $objProducts->getProduct($key);
	}
}

require_once('header.php');
require_once('navigation.php');
require_once('sidebar.php');

if(!empty($array)){ ?>

	<div id="cart">
		<h2>Order summary</h2>
		<form action="" method="post" id="basket_form">
			<table>
				<tr class="bold">
					<th class="name">Name</th>
					<th>Qty</th>
					<th>Price</th>
				</tr>		
				<tr>
					<td colspan="3"><hr /></td>
				</tr>
		<?php foreach($array as $product){ ?>
				<tr>
					<td class="title"><?php echo $product['name']; ?></td>	
					<td><?php echo $session[$product['id']]['qty']; ?></td>
					<td>
						&pound;<?php echo number_format($basket->priceByQty($product['price'], $session[$product['id']]['qty']), 2); ?>
					</td>
				</tr>
				<tr>
					<td colspan="3"><hr /></td>
				</tr>
		<?php } ?>
				<tr>
					<td colspan="3" class="total">
						<p>Total: <span>&pound;<?php echo number_format($basket->total_value, 2); ?></span></p>
					</td>
				</tr>
			</table>
			
			<div class="paypal" id="<?php echo $token1; ?>">
				<span class="paypal_btn">Proceed to PayPal &raquo;</span>
			</div>
			<div><a href="?page=basket" class="back_order">&laquo; Back</a></div> 
		</form>
	</div>	
	<div class="dn">
		<img src="images/loading.gif" alt="Redirecting to PayPal" />
	</div>
<?php 
} else { ?>
	<p>You do not have any items in your basket.</p>	
<?php } ?>

<?php
require_once('footer.php');
?>

