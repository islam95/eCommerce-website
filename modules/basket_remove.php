<?php
require_once('../include/autoload.php');

if(isset($_POST['id'])){
	
	$id = $_POST['id'];
	
	Session::removeItem($id);
}


