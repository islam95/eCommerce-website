<?php
if(!isset($_SESSION)) {
	session_start();
}

// Website domain name with http.
defined("WEBSITE_URL") || define("WEBSITE_URL", "http://".$_SERVER['SERVER_NAME']);
	
// Directory separator.
defined("DIR_SEP") || define("DIR_SEP", DIRECTORY_SEPARATOR);

// Root path.
defined("ROOT_PATH") || define("ROOT_PATH", realpath(dirname(__FILE__).DIR_SEP."..".DIR_SEP));
	
// Classes folder.
defined("CLASSES_FOLDER") || define("CLASSES_FOLDER", "classes");

// Pages folder.
defined("PAGES_FOLDER") || define("PAGES_FOLDER", "pages");

// Modules folder.
defined("MODULES_FOLDER") || define("MODULES_FOLDER", "modules");
	
// Include folder.
defined("INCLUDE_FOLDER") || define("INCLUDE_FOLDER", "include");
	
// Templates folder.
defined("TEMPLATE_FOLDER") || define("TEMPLATE_FOLDER", "template");
	
// Emails path.
defined("EMAILS_PATH") || define("EMAILS_PATH", ROOT_PATH.DIR_SEP."emails");
	
// Products images path.
defined("PRODUCTS_PATH") || define("PRODUCTS_PATH", ROOT_PATH.DIR_SEP."images".DIR_SEP."products");
	
// Add all above directories to the include path.
set_include_path(
	implode(
		PATH_SEPARATOR, array(
			realpath(ROOT_PATH.DIR_SEP.CLASSES_FOLDER),
			realpath(ROOT_PATH.DIR_SEP.PAGES_FOLDER),
			realpath(ROOT_PATH.DIR_SEP.MODULES_FOLDER),
			realpath(ROOT_PATH.DIR_SEP.INCLUDE_FOLDER),
			realpath(ROOT_PATH.DIR_SEP.TEMPLATE_FOLDER),
			get_include_path()
		)
	)
);