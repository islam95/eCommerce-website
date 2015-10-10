<?php
	
$cat = URL::getParameter('category');

if(empty($cat)){
	require_once("error.php");
} else {
	
	$objProducts = new Products();
	$category = $objProducts->getCategory($cat);
	
	if(empty($category)){
		require_once("error.php");
	} else{
		$rows = $objProducts->getProducts($cat);
		
		//instantiate paging class
		$paging = new Paging($rows);
		$rows = $paging->getRecords();

		include_once("header.php");
		include_once("offerSection.php");
		include_once('navigation.php');
		include_once('sidebar.php');

?>

		
		<table id="navArrow">
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
			</tr>
		</table>

		<div class="productRow">
<?php
	
	if(!empty($rows)){
		foreach($rows as $row){
?>
			
			<?php
				$image = !empty($row['image']) ? $objProducts->path.$row['image'] : 'images/ImageUnavailable.png';
			
			?>
					
				<div class="productInfo">
					
					<div>
						<a href="?page=product&amp;category=<?php echo $category['id']; ?>&amp;id=<?php echo $row['id']; ?>">
							<img src="<?php echo $image; ?>" alt="<?php echo Check::encodeHtml($row['name'], 1); ?>" />
						</a>
					</div>
					<p class="productContent">
						<a href="?page=product&amp;category=<?php echo $category['id']; ?>&amp;id=<?php echo $row['id']; ?>">
							<?php echo Check::encodeHtml($row['name'], 1); ?>
						</a>
					</p>
					<p class="price">
						<?php echo Products::$currency; echo number_format($row['price'], 2); ?>
					</p>
					<p><?php echo Basket::activeButton($row['id']); ?></p>
					
				</div>
			
			
<?php 
		}
		
			echo $paging->getPaging();
		
	} else {
?>
		<p>There are no products in this category yet.</p>
<?php
	} 
?>
		</div>
<?php
 		include_once("footer.php");
	}
}
?>