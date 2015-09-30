<?php
require_once('config.php');

function __autoload($class_name) {
	$class = explode("_", $class_name); // devides any class names by "_" and puts into array
	$path = implode("/", $class).".php"; // concatenates an array using "/". E.g. folder/file.php
	require_once($path);
}