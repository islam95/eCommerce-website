<?php
	
$cat = URL::getParameter('category');

$objProducts = new Products();

$products = $objProducts->getAllProducts();
$category = $objProducts->getCategory($cat);


if(empty($products)){
	
	require_once('no_products.php');
	
} else {
	
	
	
	$paging = new Paging($products);
	$products = $paging->getRecords();
	
	require_once('header.php');
	require_once('offerSection.php');
	require_once('navigation.php');
	require_once('sidebar.php'); 
		
?>
	<div class="productRow">

<?php
	foreach($products as $product){

		$image = !empty($product['image']) ? $objProducts->path.$product['image'] : 'images/ImageUnavailable.png';	
?>	
		<div class="productInfo">
			
			<div>
				<a href="?page=product&amp;category=<?php echo $category['id']; ?>&amp;id=<?php echo $product['id']; ?>">
					<img src="<?php echo $image; ?>" alt="<?php echo Check::encodeHtml($product['name'], 1); ?>" />
				</a>
			</div>
			<p class="productContent">
				<a href="?page=product&amp;category=<?php echo $category['id']; ?>&amp;id=<?php echo $product['id']; ?>">
					<?php echo Check::encodeHtml($product['name'], 1); ?>
				</a>
			</p>
			<p class="price">
				<?php echo Products::$currency; echo number_format($product['price'], 2); ?>
			</p>
			<p><?php echo Basket::activeButton($product['id']); ?></p>
			
		</div>
		
<?php 
	
	}
	
	echo $paging->getPaging();
?>

	</div>

<?php require_once('footer.php'); 

}
?>






