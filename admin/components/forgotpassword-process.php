<?php
	session_start();
	require ( '../includes/config.php' );
	require ( '../'.PATH_LIBRARIES.'libraries.php' );
	$is_valid = 'no';	
	if(isset($_POST['email'])) 
	{		
		$email = $string->sql_safe($_POST['email']);
	
		$row = $db->get_row("SELECT * FROM ".DB_TABLE_PREFIX."administrators WHERE email_address = '$email' AND is_active = '1'") ;	
		
		if( $row->administrator_id > 0 ) 
		{
			//sending an email here
			$to = $email;
			$subject = "elsocial.ch: Retrieve your password..";
			$body = "<div style='font-family:tahoma;font-size:13px;size:13px;'>
			Dear Admin User,<br /><br />

			Here is your username and password.<br /><br />

			<b>Username:</b> ".$row->username."<br />
			<b>Password:</b> ".$row->password."<br /><br />

			If you have any questions or concerns, please feel free to contact us!<br /><br />

			Best regards,<br />
			elsocial.ch Staff<br /><br />

			
			</div>";
				
			$from = "info@elsocial.ch";
					
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= "From: $from\r\n";

			mail($to,$subject,$body,$headers);
			
			$is_valid = 'yes';
		}
	}	
	echo $is_valid;	
?>