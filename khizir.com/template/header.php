<?php
$objProductDir = new ProductDir();
$cats = $objProductDir->getCategories();
	
$objCompany = new Company();
$company = $objCompany->getCompany();	
?>
<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<title><?php echo $company['name']; ?></title>
	<meta name="Author" content="Islam Dudaev" />
	<meta name="description" content="Khizir online shop for clothing." />
	<meta name="keywords" content="online shop, online store, khizir store, khizir shop" />
	<link href="css/main.css" rel="stylesheet" type="text/css">
</head>
	

<body>
	<!-- Connection to Facebook in order to allow visitor to comment on 
		the products using their facebook accounts or like button on this website.
	-->
	<div id="fb-root"></div>
		<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.3";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
	
	<div id="mainWrapper">
		<header>
			<!-- This contains Logo and links -->
			<div id="logo">
				<a href="?page=index">
					<img src="images/logo.gif" alt="<?php echo $company['name']; ?>" />
				</a>
			</div>

			<!-- Search field -->
			<div id="search">
				<form name="search" action="#" method="get">
					<!-- Search field. Javascript used for deleting the search text in search field when user types in. -->
					<input type="text" name="q" value="Search..." onfocus="if(this.value == 'Search...'){this.value = '';}" onblur="if(this.value == ''){this.value = 'Search...';}" />
				</form>
			</div>

			<div id="headerLinks">
				<a href="?page=login" title="Login/Register">Login/Register</a>
				<a href="?page=basket" title="Cart">Basket</a>
				<a href="?page=basket" title="CartImg">
					<img src="images/basket/basket.png" alt="Basket" class="imgBasket" />
				</a>
			</div>
		</header>
