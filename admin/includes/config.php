<?php
header('Content-type: text/html; charset=UTF-8');
/**
*  Application define
*/

// Global definitions
//
ini_set("error_reporting",		"on");

define( 'PATH_LIBRARIES',	 	'libraries/' );
define( 'PATH_INCLUDES',		'includes/'   );
define( 'PATH_COMPONENTS',		'components/'   );
define( 'PATH_TEMPLATES',		'templates/' );

define( 'PATH_UPLOADS',			'../uploads/' );
define( 'PATH_PHOTOS',			PATH_UPLOADS.'photos/' );

$location = "LIVE_not";
switch ($location) {
	case "LIVE":
		define(	'WEBSITE_TINYMCE_URL', 	'http://www.hauthunger.ch/uploads/tinymce/');
		// define(	'WEBSITE_ADMIN_URL', 	'http://www.hauthunger.ch/uploads/admin/');
		define(	'WEBSITE_ADMIN_URL', 	'http://localhost:8080/German_php/admin/');
		define(	'TINYMCE_BASE_URL', 	'http://www.hauthunger.ch/uploads/');
		define( 'DB_HOST',				'localhost' );
		define( 'DB_USER',				'root' );
		define( 'DB_PASSWORD',			'' );
		// define( 'DB_USER',				'schlaepferd_haut' );
		// define( 'DB_PASSWORD',			'schlaepferd_haut' );
		define( 'DB_NAME',				'schlaepferd_haut' );
		define( 'WEBSITE_EMAIL',		'' );
		define( 'EMAIL_CONTACT_US',		'' );		
		break;
	
	default:
		define(	'WEBSITE_TINYMCE_URL', 	'http://localhost/newsite/uploads/tinymce/');
		define(	'WEBSITE_ADMIN_URL', 	'ttp://localhost/German_php_origin/admin/');
		define(	'TINYMCE_BASE_URL', 	'http://localhost/German_php_origin/');
		define( 'DB_HOST',				'localhost' );
		define( 'DB_USER',				'root' );
		define( 'DB_PASSWORD',			'' );
		define( 'DB_NAME',				'schlaepferd_haut' );
		define( 'WEBSITE_EMAIL',		'' );
		define( 'EMAIL_CONTACT_US',		'' );			
}

define( 'WEBSITE_NAME',			"hauthunger.ch Content Management System" );
define( 'INDEX_PAGE',			'index.php?option=' );
define( 'DB_TABLE_PREFIX',		'tbl_' );

define( 'IMAGES',	 			'images/' );
define( 'CSS',					'css/' );
define( 'JS',					'js/' );
define( 'PLUGINS',				'plugins/' );
define( 'ENCRYPT_KEY',			'elsocialcms' );

$page_option = "";

define( 'PWD_MIN_LEN',			6 );
define( 'REQ_FIELD',			'<span class="required">*</span>' );
define( 'CONFIRM_DELETE',		'Are you sure you want to DELETE the selected ' );

// ADDITIONAL

define( 'COLORPICKER',			PLUGINS.'jquery/colorpicker/' );

// FILE UPLOADS CONFIGURATIONS

$config['product']['img_ext'] 				= array('.jpg', '.jpeg', '.png');
$config['product']['img_width'] 			= 800;
$config['product']['img_height'] 			= 687;
$config['product']['img_gallery_width']		= 290;
$config['product']['img_gallery_height']	= 249;
$config['product']['img_thumb_width'] 		= 140;
$config['product']['img_thumb_height'] 		= 120;
$config['product']['img_tick_width'] 		= 100;
$config['product']['img_tick_height'] 		= 86;
$config['product']['img_thumb_postfix'] 	= '_s';
$config['product']['img_tick_postfix'] 		= '_t';
$config['product']['img_gallery_postfix'] 	= '_g';
$config['product']['max_quantity']			=	5;


$config['store']['img_ext'] 			= array('.jpg', '.jpeg');
$config['store']['img_width'] 			= 655;
$config['store']['img_height'] 			= 491;
$config['store']['img_thumb_width'] 	= 255;
$config['store']['img_thumb_height'] 	= 191;
$config['store']['img_thumb_postfix'] 	= '_s';

$config['testimonials']['img_ext'] 			= array('.jpg', '.jpeg');
$config['testimonials']['img_width'] 			= 80;
$config['testimonials']['img_height'] 			= 80;



//
// Messages
//
$messages = array();
$messages['fg']['sel_rec_delete'] 	= "Please select record(s) to DELETE!";
$messages['fg']['sel_rec_edit'] 	= "Please select a record to EDIT!";
$messages['fg']['sel_rec_view'] 	= "Please select a record to VIEW!";
$messages['fg']['sel_rec_print'] 	= "Please select record(s) to PRINT!";
$messages['fg']['sel_rec_export'] 	= "Please select record(s) to EXPORT!";

$messages['validate']['required'] 		= "";
$messages['validate']['pwd_mismatch'] 	= "Password mismatch";
$messages['validate']['mail_mismatch'] 	= "Email mismatch";
$messages['validate']['min_len'] 		= "Required minimun length: ";
$messages['validate']['max_len'] 		= "Required maximum number: ";
$messages['validate']['unavailable'] 	= " is already in use";
$messages['validate']['accept_jpg'] 	= "Must be in image format";
$messages['validate']['accept_video'] 	= "Must be in FLV format";
$messages['validate']['accept_img'] 	= "Must be in '.png' | '.jpeg' | '.jpg' ";
$messages['validate']['number'] 		= "Must be numeric";
$messages['validate']['amount'] 		= "Invalid Amount";
$messages['validate']['url_format'] 		= "Invalid URL";

$messages['system']['exists'] = " already exists!&nbsp;&nbsp;Please choose another.";


// 
// Grid Settings
//
define( 'GRID_1COL',				'30' );
define( 'GRID_2COL',				'44' );
define( 'GRID_3COL',				'60' );
define( 'GRID_4COL',				'80' );

define( 'ICON_VIEW' ,				'<img class="ico-action" src="'.IMAGES.'icon-view.png" alt="View" title="View" border="0" />' );
define( 'ICON_ADD' ,				'<img class="ico-action" src="'.IMAGES.'icon-add.png" alt="Add" title="Add" border="0" />' );
define( 'ICON_EDIT' ,				'<img class="ico-action" src="'.IMAGES.'icon-edit.png" alt="Edit" title="Edit" border="0" />' );
define( 'ICON_DELETE' ,				'<img class="ico-action" src="'.IMAGES.'icon-delete.png" alt="Delete" title="Delete" border="0" />' );
define( 'ICON_NO_EDIT' ,			'<img class="ico-action" style="FILTER: alpha(opacity=30);opacity: 0.30;" src="'.IMAGES.'icon-edit.png" />' );
define( 'ICON_NO_DELETE' ,			'<img class="ico-action" style="FILTER: alpha(opacity=30);opacity: 0.30;" src="'.IMAGES.'icon-delete.png" alt="" title="" border="0" />' );
define( 'ICON_ADD1' ,				'<img class="ico-action" src="'.IMAGES.'icon-add.png" alt="Sizes Management" title="Sizes Management" border="0" />' );

$fgrid_rp_options 					= "[5,10,15,20,25,40]";	

// Administrators
$fg_admins = array();
$fg_admins['sortname'] 				= "username";
$fg_admins['sortorder'] 			= "asc";
$fg_admins['rp'] 					= "15";
$fg_admins['rpOptions'] 			= $fgrid_rp_options;
$fg_admins['showTableToggleBtn'] 	= "false";
$fg_admins['width'] 				= "950";
$fg_admins['height'] 				= "536";
$fg_admins['resizable'] 			= "false";

// Events
$fg_events = array();
$fg_events['sortname'] 				= "event_title";
$fg_events['sortorder'] 			= "asc";
$fg_events['rp'] 					= "15";
$fg_events['rpOptions'] 			= $fgrid_rp_options;
$fg_events['showTableToggleBtn'] 	= "false";
$fg_events['width'] 				= "950";
$fg_events['height'] 				= "536";
$fg_events['resizable'] 			= "false";

// Types
$fg_types = array();
$fg_types['sortname'] 				= "category_name";
$fg_types['sortorder'] 			= "asc";
$fg_types['rp'] 					= "15";
$fg_types['rpOptions'] 			= $fgrid_rp_options;
$fg_types['showTableToggleBtn'] 	= "false";
$fg_types['width'] 				= "950";
$fg_types['height'] 				= "536";
$fg_types['resizable'] 			= "false";

?>