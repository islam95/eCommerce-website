DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL,
	PRIMARY KEY (`id`)
);
INSERT INTO `categories` VALUES (1, 'Accessories');
INSERT INTO `categories` VALUES (2, 'Dresses');
INSERT INTO `categories` VALUES (3, 'Hoodies');
INSERT INTO `categories` VALUES (4, 'Jackets & Coats');
INSERT INTO `categories` VALUES (5, 'Jeans');
INSERT INTO `categories` VALUES (6, 'Jumpers & Cardigans');
INSERT INTO `categories` VALUES (7, 'Leather Jackets');
INSERT INTO `categories` VALUES (8, 'Shirts');
INSERT INTO `categories` VALUES (9, 'Shoes & Boots');
INSERT INTO `categories` VALUES (10, 'Suits & Blazers');
INSERT INTO `categories` VALUES (11, 'T-Shirts');
INSERT INTO `categories` VALUES (12, 'Underwear & Socks');



DROP TABLE IF EXISTS `statuses`;
CREATE TABLE `statuses` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `statuses` VALUES(1, 'Pending');
INSERT INTO `statuses` VALUES(2, 'Processing');
INSERT INTO `statuses` VALUES(3, 'Dispatched');



DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(100) NOT NULL,
  `last_name` VARCHAR(100) NOT NULL,
  `address_1` VARCHAR(255) NOT NULL,
  `address_2` VARCHAR(255) NOT NULL,
  `city` VARCHAR(100) NOT NULL,
  `county` VARCHAR(100) NOT NULL,
  `post_code` VARCHAR(10) NOT NULL,
  `country` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `date` DATETIME NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT '1',
  `encode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);



DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`(
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`user` INT(10) NOT NULL,
	`total` DECIMAL(8,2) NOT NULL,
	`date` DATETIME NOT NULL,
	`status` INT(10) NOT NULL DEFAULT '1',
	`paypal_status` TINYINT(1) NOT NULL DEFAULT '0',
	`payment_status` VARCHAR(100) DEFAULT NULL,
	`notes` TEXT,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`user`) REFERENCES `users`(`id`),
	FOREIGN KEY (`status`) REFERENCES `statuses`(`id`)
);


DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL,
	`description` TEXT NOT NULL,
	`price` DECIMAL(8,2) DEFAULT '0.00' NOT NULL,
	`date` DATETIME NOT NULL,
	`category` INT(10) NOT NULL,
	`image` VARCHAR(100) DEFAULT NULL,
	`color` VARCHAR(100) DEFAULT NULL,
	`size_number` VARCHAR(100) DEFAULT NULL, -- size for shoose or other: like 35,40,43, etc.
	`size_letter` VARCHAR(100) DEFAULT NULL, -- size for clothes: like S, M, L, XXL, etc.
	`brand` VARCHAR(100) DEFAULT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`category`) REFERENCES `categories` (`id`)
);
INSERT INTO `products` VALUES (1, 'Highwayman Bridge Coat', '<p>Layering is king when temperatures drop, and a chunky coat is integral to the winter assemble. The single-breasted overcoat provides a broad silhouette that’s long been a favourite of those who want premium protection from the elements.</p>
<p>The Highwayman Bridge coat from Superdry is fitted with a one button fastening and twin side pockets that are the perfect place to keep your hands away out the cold. The centre vent provides a tailored silhouette, whilst the inner lining buzzes with flashes of blue.</p>
<p>Whether you’re using it to protect your suit from the morning commute or wearing it at the weekends to upgrade your off-duty attire, this Superdry coat is a solid investment for the cold that won’t ever go out of fashion.</p>
<p>Details:</p>
<ul>
	<li>Mens coat by Superdry</li>
	<li>Highwayman Bridge</li>
	<li>Slim fit</li>
	<li>Single breasted with 1 button fastening</li>
	<li>Dual side pockets</li>
	<li>Centre vent</li>
</ul>
<p>60% wool, 40% other fibres. Dry clean only.</p>', 100.00, '2015-04-24 23:34:23', 4, 'HighwaymanBridgeCoat.jpg', 'grey', NULL, 'M',  'Superdry');
INSERT INTO `products` VALUES (2, 'Hi-Tec Waterproof Jacket', '<p>ONLINE EXCLUSIVE</p><p>Get set for this year’s outdoor adventures in this waterproof jacket from Hi-Tec. With a zipped pockets on the hip and a Hi-Tec logo on the chest, the jacket is made with TECPROOF technology with taped seams, a funnel neckline, covered placket and pack-away hood for warmth.</p>
<p>Zip-through fastening with a riptape fastened placket</p>
<p>Sits on the hip</p>', 40.00, '2015-04-24 12:34:23', 4,  'WaterproofJacket.png', 'blue', NULL, 'L', 'Hi-Tec');
INSERT INTO `products` VALUES (3, 'Petite Tea Dress', '<p>With a choice of two staple colours – this petite fit tea dress by South effortlessly takes you from week-to-weekend in classic style.</p>
<p>This petite tea dress is a blend of sassy and sweet making it the perfect pick to see you from the office to the dance floor. The wrap style top makes the most of your feminine curves for a sleek silhouette, while the short-sleeved cut keeps you cool in the sunshine. Its cinched waist defines your shape and the flippy skirt is a flirty twist that stays classy in length!</p>
<p>Wear this petite fit tea dress with block heeled sandals for a cute look on your next hot date.</p>
<p>Useful info:</p>
<ul>
	<li>Tea dress by South</li>
	<li>Designed for the petite figure</li>
	<li>Cinched waist</li>
	<li>V-neckline</li>
	<li>Short-sleeved</li>
	<li>33 inch length</li>
</ul>
<p>95% viscose, 5% elastane. Machine washable.</p>', 8.20, '2015-04-24 13:34:12', 2, 'SouthPetiteTeaDress.png', 'navy', '16', NULL,  'South');
INSERT INTO `products` VALUES (4, 'Ella Skinny Jeans', '<p>Super-skinny in a choice of two washes, these Ella high rise skinny jeans from South perfectly complement your off-duty style.</p>
<p>Skinny jeans are a style staple in every women’s wardrobe. These skinnies, with their high rise design, lend your legs supermodel length! In a super-soft fabric with a slight stretch they’re so comfy you won’t want to take them off - perfect for round the clock dressing. The statement washes sleeken the silhouette and bring versatility day-to-night.</p>
<p>Pair these super soft skinny jeans with crop top, heels and accessories with a clutch for effortless chic.</p>
</p>Useful info:</p>
<ul>
	<li>Skinny jeans by South</li>
	<li>High rise design</li>
	<li>Button and fly fastening to front</li>
	<li>5-pocket detail</li>
	<li>Available in 2 sizes</li>
</ul>
<p>Colours: Black, Indigo. 70% cotton, 26% polyester, 4% elastane. Machine washable.</p>', 25.00, '2015-04-25 15:23:54', 5, 'SouthHighRiseEllaJeans.png', 'Indigo', '12', NULL, 'South');
INSERT INTO `products` VALUES (5, 'Crew T-shirt', '<p>A big hitter in the world of menswear, this tee is given a denim pocket hit that works for a variety of occasions - from dinner on holiday to a night spent socialising.</p>
<p>The round neck, short sleeve silhouette ensures essential comfort, whilst the patterned denim-style pocket is the statement focal point. Matching tipping to the cuffs complete a trendy style that anticipates the summer sunshine.</p>
<p>Pair this T-shirt with denim shorts and boat shoes for smart-casual attire that makes an immediate impact.</p>
<p>Useful info:</p>
<ul>
	<li>Mens T-shirt by Goodsouls</li>
	<li>Contrast denim pocket</li>
	<li>Short sleeve</li>
	<li>Round neck</li>
	<li>Tipping to cuffs</li>
</ul>
<p>Colour: Navy. Cotton. Machine washable.</p>', 18.00, '2015-04-24 16:23:31', 11, 'GoodsoulsMensCrew.png', 'Navy', NULL, 'M', 'Goodsouls');
INSERT INTO `products` VALUES (6, 'Fill Zip Hoody', '<p>Long-sleeve, brush back full-zip hoody with transparent ripstop overlay on hood and back panel. Zip pull attachment with reflective flecks. Pop colour, full-zip and back bib binding. Centre front, high-density Nike Sportswear logo screen print. Cut-and-sew shoulder and back panels.</p>
<p>Colour: Black/White. 80% cotton, 20% polyester. Machine washable.</p>', 60.00, '2015-04-24 12:34:12', 3, 'FillZipHoody.png', 'black', NULL, 'L', 'Nike');
INSERT INTO `products` VALUES (7, 'Plaintiff Sunglasses', '<p>Oakley Sunglasses Plaintiff Squared Polished Gold/Dark Grey is designed for men and the frame is gold. This style has a xtra large - 63mm - lens diameter. The bridge size for this model is 14mm and the side length is standard. This adult designer sunglasses model is a metal, square shape with a full rimmed frame. The Oakley sunglasses come inclusive of soft bag & cleaning cloth. minmum 12 month warranty and authenticity guaranteed.</p>', 145.00, '2015-04-26 21:53:23', 1, 'PlaintiffSquared.png', 'Lead', NULL, 'XL', 'Oakley');
INSERT INTO `products` VALUES (8, 'Devie Mar Sandals', '<p>Giving the classic a little glam update, the Devie mar leather gladiator sandals by UGG® Australia are the perfect mix of function and style.</p>
<p>Available in two classic colours, go for black for a wear-with-anything guarantee or chocolate to show off your summer tan. Thin criss-cross straps add to the gladiator appeal of these flats, while the double buckled fastenings create an antique look with their old school metal look. Cushioned under foot with a flexible moulded rubber outsole, they provide unparalleled comfort that’ll come in handy when spending days at a time sightseeing this summer.</p>
<p>Wear them with denim shorts, maxi dresses and skirts this season to show off just how versatile they are.</p>
<p>Useful info:</p>
<ul>
   <li>Devie Mar leather gladiator sandals by UGG® Australia</li>
	<li>Thin criss-cross leather straps</li>
	<li>Hidden hook closures for easy entry</li>
	<li>Double metal buckled fastenings to ankle</li>
	<li>Flexible moulded rubber outsole</li>
	<li>Plush Poron® cushioned foot bed</li>
</ul>
<p>Colours: Black, Chocolate. Upper: Leather. Lining: Leather. Sole: Other materials.</p>', 99.00, '2015-04-24 18:24:45', 9, 'DevieMarGladiatorSandals.png', 'Chocolate', '35', NULL, 'Ugg');
INSERT INTO `products` VALUES (9, 'Stretch Shirt', '<p>Slim fit shirt with stretch for fashion fit. Single cuff.</p>
<p>Colour: White. 97% cotton, 3% elastane. Machine washable.</p>', 13.50, '2015-04-24 14:23:43', 8, 'TaylorReeceMensStretch.png', 'White', '16.5', NULL, 'Taylor & Reece');
INSERT INTO `products` VALUES (10, 'Slim Fit PV Suit Jacket', '<p>Get suited and booted with this fine Taylor & Reece suit jacket.</p>
<p>In a rich navy colourway it’s a luxurious offering for the contemporary gent. The slim fit ensures that you retain a suave silhouette, whilst the centre back vent allows for an elegant tapered fit.</p>
<p>A minimal two-button fastening with flapover pockets and a single chest pocket provide the essential formal detailing, with a striped contrast lining offering a sharp finish.</p>
<p>Paired with the matching trousers and waistcoat this Taylor & Reece jacket provides the perfect finish to your formal looks.</p>
<p>Useful info:</p>
<ul>
	<li>Mens jacket by Taylor & Reece</li>
	<li>Navy</li>
	<li>Slim fit</li>
	<li>2-button fastening</li>
	<li>Centre back vent</li>
	<li>Contrast lining</li>
	<li>Flapover pockets</li>
	<li>Button cuffs</li>
</ul>
<p>Colour: Navy. 80% polyester, 18% viscose, 2% linen. Dry clean only.</p>', 65.00, '2015-04-24 23:34:12', 4, 'SlimFitPVSuitJacket.png', 'Navy', '40', NULL, 'Taylor & Reece');



DROP TABLE IF EXISTS `orders_products`;
CREATE TABLE `orders_products` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `order` INT(10) NOT NULL,
  `product` INT(10) NOT NULL,
  `price` DECIMAL(8,2) NOT NULL,
  `qty` INT(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order`) REFERENCES `orders` (`id`),
	FOREIGN KEY (`product`) REFERENCES `products` (`id`)
);


DROP TABLE IF EXISTS `discounts`;
CREATE TABLE `discounts`(
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`code` VARCHAR(100) NOT NULL,
	`value` DECIMAL(8,2) NOT NULL,
	PRIMARY KEY (`id`)
);
INSERT INTO `discounts` VALUES (1, 'DIS10', 0.10);
INSERT INTO `discounts` VALUES (2, 'DIS15', 0.15);
INSERT INTO `discounts` VALUES (3, 'DIS20', 0.20);
INSERT INTO `discounts` VALUES (4, 'DIS25', 0.25);
INSERT INTO `discounts` VALUES (5, 'DIS50', 0.50); 



DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `address` TEXT NOT NULL,
  `phone` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `website` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `company` VALUES(1, 'Khizir Store', '11 Bastwick Street<br />London<br />EC1V 3AQ', '01434 454 345', 'info@khizir.com', 'Khizir.com');



DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(100) NOT NULL,
  `last_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `admins` VALUES(1, 'Islam', 'Dudaev', 'islam89uk@gmail.com', 'islam895');