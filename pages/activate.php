<?php

$code = URL::getParameter('encode');

if (!empty($code)) {
	$objUser = new User();
	$user = $objUser->getByCode($code);

	if (!empty($user)) {
		// if user is not active meaning that the user has not activated the account by clicking the link provided by email
		if($user['active'] == 0){
			if($objUser->setActive($user['id'])){
				$message  = "<h2>Thank you</h2>";
				$message .= "<p>Your account has now been successfully activated.<br>";
				$message .= "You can now log in and continue with your order.</p>";
			} else{
				$message  = "<h2>Activation unsuccessful</h2>";
				$message .= "<p>There has been a problem activating your account.</br>";
				$message .= "Please, contact website administrator.</p>";
			}

		} else {
			$message = "<h2>Account already activated</h2>";
			$message .= "<p>This account has already been activated.</p>";
		}

	} else {
		Check::redirect("?page=error");
	}

	require_once('header.php');
	require_once("offerSection.php");
	require_once('navigation.php');
	require_once('sidebar.php');
	echo $message;
	require_once('footer.php');

} else {
	Check::redirect("?page=error");
}


