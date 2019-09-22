	<div id="header" style="background-color:#b51e27;color:#FFFEEF;">
    	<div id="logged-user">
			<div class="administrationtext" style="color:#FFFEEF;">
				<?php echo strtoupper("Administration");?>
			</div><br />
			<div align="right" style="color:#FFFEEF;">
			Welcome! You are logged in as <strong><?php echo $_SESSION[WEBSITE_NAME]['admin_name']?></strong>.
			&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="<?php echo INDEX_PAGE?>my-account" style="color:white;">My Account</a>
			&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="<?php echo INDEX_PAGE?>logout" style="color:white;">Logout</a>
			</div>
    	</div>
  		<div id="logo-area" style="color:white;margin-top:5px;font-weight:bold;">
			Elsocial.ch<br/>Content Management System
		</div>    	
    </div>
    <div id="navigation">    	
        <ul class="sf-menu" style="background:#b51e27;">
			
			<li<?php if ($_REQUEST['option'] == "events" or $_REQUEST['option'] == "events-m"){echo ' class="active"';}?>><a href="<?php echo INDEX_PAGE?>events">Special Events Management</a></li>
			<li<?php if ($_REQUEST['option'] == "courses" or $_REQUEST['option'] == "courses-m"){echo ' class="active"';}?>><a href="<?php echo INDEX_PAGE?>courses">Course Management</a></li>
			<li<?php if ($_REQUEST['option'] == "administrators" or $_REQUEST['option'] == "administrators-m"){echo ' class="active"';}?>><a href="<?php echo INDEX_PAGE?>administrators">System User Management</a></li>  
			<!--<li<?php if ($_REQUEST['option'] == "site" or $_REQUEST['option'] == "site-m"){echo ' class="active"';}?>><a href="<?php echo INDEX_PAGE?>site">Site Configuration</a></li>-->
        </ul>
	</div>  
	<div id="menu-content-separator">
		&nbsp;
	</div>
	<div id="content">
	