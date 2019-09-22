<?php
ob_start();
header("Expires: Thu, 17 May 2001 10:17:17 GMT");    			// Date in the past
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header ("Cache-Control: no-cache, must-revalidate");  			// HTTP/1.1
header ("Pragma: no-cache");                          			// HTTP/1.0

//error_reporting('E_ALL');
session_start();
require_once ( 'includes/config.php' );
require_once ( PATH_LIBRARIES.'libraries.php' );
$timezone = "Asia/Manila";
date_default_timezone_set ($timezone);

$page_option = trim($_GET['option']);

if( !isset($_SESSION[WEBSITE_NAME] ) ) {
	if ($page_option == "login"){
		include PATH_COMPONENTS."login.php";
	}elseif($page_option == "forgotpassword"){
		include PATH_COMPONENTS."forgotpassword.php";
	}elseif($page_option == "passwordsent"){
		include PATH_COMPONENTS."passwordsent.php";
	}else{
		include PATH_COMPONENTS."login.php";
	}
} else {
	include PATH_TEMPLATES."top.php";
	include PATH_TEMPLATES."header.php";
	include PATH_COMPONENTS."main.php";
	include PATH_TEMPLATES."footer.php";
}

ob_end_flush();
?>