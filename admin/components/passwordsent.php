<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo WEBSITE_NAME?></title>
<link rel="icon" href="../favicon.ico" type="image/x-icon" />
<link href="../favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="<?php echo CSS?>core.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS?>general.css" rel="stylesheet" type="text/css" />
<script src="<?php echo PLUGINS?>jquery/jquery.js" type="text/javascript" language="Javascript"></script>
<script src="<?php echo PLUGINS?>jquery/jquery.curvycorners.js" type="text/javascript" language="Javascript"></script>
<script src="<?php echo JS?>/forgotpassword.js" type="text/javascript" language="Javascript"></script>
</head>
<body>
<div id="login-container">	
  	<div class="login-content"> 
        <form method="post" id="frmForgotPassword" action="">
            <div class="login-content-main">	
                <div class="login-logo" style="background-color:white;color:#b51e27;font-size:22px;size:30px;font-weight:bold;margin-bottom:5px;"><?php echo WEBSITE_NAME;?></div>
                <h2>Password sent!</h2>
               
                <label>Please check your email for your account details.</label>
                
                
				<div>
					<br /><a href="index.php?option=login">Back to login?</a>
				</div>
				
				 
               
                <div class="clr"></div><br />
                <div align="right"><a href="../">Return to Site Homepage</a></div>
            </div>
        </form>
        <div id="login-credit"><?php echo $conf['website']['copyright']?></div>
       
        <div class="clr"></div>
    </div>
</div>
</body>
</html>
