<?php
	session_start();
	require ( '../includes/config.php' );
	require ( '../'.PATH_LIBRARIES.'libraries.php' );
	$is_valid = 'no';	
	if(isset($_POST['username'])) 
	{		
		$username = $string->sql_safe($_POST['username']);
		$password = $string->sql_safe($_POST['password']);
	
		$row = $db->get_row("SELECT * FROM ".DB_TABLE_PREFIX."administrators WHERE username = '$username' AND password = '$password' AND is_active = '1'") ;	
		
		if( $row->administrator_id > 0 ) 
		{
			$_SESSION[WEBSITE_NAME]['admin_id']    	= $row->administrator_id;
			$_SESSION[WEBSITE_NAME]['username'] 	= $row->username;
			$_SESSION[WEBSITE_NAME]['admin_name']   = $row->firstname.' '.$row->lastname;
			$_SESSION[WEBSITE_NAME]['user_type'] 	= $row->user_type_id;
			$is_valid = 'yes';
		}
	}	
	echo $is_valid;	
?>