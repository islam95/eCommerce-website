<?php
require_once("../include/autoload.php");

$basket = new Basket();
$print = array();

//Relates to Basket.php and modules/basket_small.php
//Populates the small basket with number of items and a cost.
$print['items'] = $basket->num_of_items;
$print['total'] = number_format($basket->total_value, 2);

echo json_encode($print);
