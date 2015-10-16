<?php

$id = URL::getParameter('id');

if(!empty($id)){
	$form = new Form();
	$objProducts = new Products();
	$product = $objProducts->getProduct($id);
	
	if(!empty($product)){
		$category = $objProducts->getCategory($product['category']);
		require_once('header.php');
		require_once("offerSection.php");
		require_once('navigation.php');
		require_once('sidebar.php');
?>
	<!-- Display the path of the page on the website -->
	<table class="navArrow navProduct">
		<tr>
			<td>
				<a href="?page=index">Home</a>
			</td>
			<td>
				<img src="images/nav_arrow.gif" alt="" />
			</td>
			<td>
				<a href="?page=categories&amp;category=<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a>
			</td>
			<td>
				<img src="images/nav_arrow.gif" alt="" />
			</td>
			<td>
				<p><?php echo $product['name']; ?></p>
			</td>
		</tr>
	</table>

<!-- Product information -->
<table id="product">
	<tr>
		<td>
		
<?php 
		$image = !empty($product['image']) ? 'images/products/'.$product['image'] : null;

		if(!empty($image)){
			echo "<img src=\"{$image}\" alt=\"";
			echo Check::encodeHTML($product['name'], 1);
			echo "\" />";
		}					
?>
		</td>
	<td>
		<p class="title"><?php echo $product['name']; ?></p>
		<table class="choose">
			<tr>
				<td>
					<p>Size</p>
					<?php 
					if(!empty($product['size_number'])){
						echo $form->getSizeNumber(1);
					} else {
						echo $form->getSizeLetter(1);
					}
					?>	
					
				</td>
				<td>
					<p>Colour</p>
					<?php echo $form->getColour(); ?> 
				</td>
			</tr>
			<tr>
				<td>
					<p class="price">
						<?php echo "&pound;".$product['price']; ?>
					</p>
				</td>
				<td>
					<p>
					<?php echo Basket::activeButton($product['id']); ?>
					</p>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td colspan="2">
		<div>
		<p class="info">Description:</p>
			<?php echo Check::encodeHTML($product['description']); ?>
		</div>
	</td>
</tr>
<tr>
	<td>
		<p>
			<?php
				//Go back one page on click.
				echo "<a class=\"go_back\" href=\"javascript:history.go(-1)\">&laquo; Back</a>"; 
			?>
		</p>
	</td>
</tr>
</table>
	
<?php			
		require_once('footer.php');
	} else {
		require_once('error.php');
	}
	

} else {
	require_once('error.php');
}


