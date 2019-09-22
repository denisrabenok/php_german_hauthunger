<?php
	unset($_SESSION[WEBSITE_NAME]);
	session_destroy();
	header("Location: ".INDEX_PAGE."login");
?>