<?php
//Clear the basket after successful payment.
Session::clear('basket');

require_once('header.php');
require_once('offerSection.php');
require_once('navigation.php');
require_once('sidebar.php'); 
?>

<h1>Thank you!</h1>
<p>Your payment was successful. Thank you for your order.</p>

<?php require_once('footer.php'); ?>