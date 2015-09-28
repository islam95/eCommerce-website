<?php 

require_once('header.php');
require_once("offerSection.php");
require_once('navigation.php');
require_once('sidebar.php');	

$name = addslashes($_POST['name']);
$email = addslashes($_POST['email']);
$comments = addslashes($_POST['comments']);

$toemail = "islam.dudaev@city.ac.uk";
$subject = "From Khizir.com online store";

$headers = "MIME-Version: 1.0\n"
        ."From: \"".$name."\" <".$email.">\n"
        ."Content-type: text/html; charset=iso-8859-1\n";

$body = "Name: ".$name."<br>\n"
     ."Email: ".$email."<br>\n"
     ."Comments:<br>\n"
     .$comments;

if (!ereg("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $email)){
	
?>
	<h3>That is not a valid email address!</h3>
	<p>Please return to the previous page and try again</p>

<?php
	
	exit;

} else {

	mail($toemail, $subject, $body, $headers);
?>
	<div>
		<h2>Thank you!</h2> 
	
		Thank you for contacting us! We will get back to you shortly.
	
		<br /><br />
	</div>
<?php
}
?>

<?php require_once('footer.php'); ?>