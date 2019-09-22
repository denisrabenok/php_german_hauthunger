<?php	
	switch ($page_option)
	{
		// DEFAULT
		case 'home':
			$page_heading = "Home";
			$page_name = "Home";
			require('home.php');
			break;  
		case 'my-account':
			$page_heading = "My Account";
			$page_name = "my-account";
			require('my-account.php');
			break; 
		case 'site':
			$page_heading = "Site Configuration";
			$page_name = "Site Configuration";
			require('site.php');
			break;
		case 'types':
			$page_heading = "Types Management";
			$page_name = "types";
			require('types.php');
			break;  
		case 'types-m':
			$page_heading = "Types Management";
			$page_name = "types";
			require('types-maint.php');
			break; 
		case 'administrators':
			$page_heading = "System User Management";
			$page_name = "administrators";
			require('administrators.php');
			break;  
		case 'administrators-m':
			$page_heading = "System User Management";
			$page_name = "administrators";
			require('administrators-maint.php');
			break; 
		
		case 'logout':
			require('logout.php');
			break;  
		
		// CUSTOM	
		case 'events':
			$page_heading = "Calendar Management";
			$page_name = "events";
			require('events.php');
			break;  
		case 'events-m':
			$page_heading = "Calendar Manager";
			$page_name = "events";
			require('events-maint.php');
			break;	
		case 'courses':
			$page_heading = "Course Management";
			$page_name = "courses";
			require('courses.php');
			break;  
		case 'courses-m':
			$page_heading = "Course Manager";
			$page_name = "courses";
			require('courses-maint.php');
			break;
		case 'other-events':
			$page_heading = "Other Dates Management";
			$page_name = "other-events";
			require('other-events.php');
			break;  
		case 'other-events-m':
			$page_heading = "Other Dates Manager";
			$page_name = "other-events";
			require('other-events-maint.php');
			break;	
		default:
			require('home.php');
	}
?>