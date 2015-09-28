<?php

require_once('../include/load.php');

if(isset($_POST['id'])){
	
	$id = $_POST['id'];
	
	Session::removeItem($id);
	
}