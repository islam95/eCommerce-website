<?php
	
	$id = URL::getParameter('id');
	
	if(!empty($id)){
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
						<select name="size" id="size">
							<option value="">XS</option>
							<option value="2">S</option>
							<option value="3">M</option>
							<option value="4">L</option>
							<option value="5">XL</option>
						</select>
					</td>
					<td>
						<p>Colour</p>
						<select name="colour" id="colour">
							<option value="">Select</option>
							<option value="2">White</option>
							<option value="3">Red</option>
							<option value="4">Navy</option>
							<option value="5">Grey</option>
							<option value="6">Black</option>
						</select>
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


