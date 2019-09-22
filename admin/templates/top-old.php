<?php
header('Content-type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo WEBSITE_NAME?></title>

<link href="<?php echo CSS?>general.css" rel="stylesheet" type="text/css" />
<link href="css/jquery-ui-1.7.1.custom.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS?>core.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="../favicon.ico" type="image/x-icon" />
<link href="../favicon.ico" rel="shortcut icon" type="image/x-icon" />
<?php if ($_GET['option'] == "events-m"){?>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js" type="text/javascript" language="Javascript"></script>-->
<script src="<?php echo PLUGINS?>jquery/jquery.js" type="text/javascript" language="Javascript"></script>
<?php } else {?>
<script src="<?php echo PLUGINS?>jquery/jquery.js" type="text/javascript" language="Javascript"></script>
<?php } ?>
<script src="<?php echo PLUGINS?>jquery/jquery.curvycorners.js" type="text/javascript" language="Javascript"></script>
<script src="<?php echo PLUGINS?>jquery/jquery.validate.js" type="text/javascript" language="Javascript"></script>
<script src="<?php echo PLUGINS?>jquery/jquery.form.js" type="text/javascript" language="Javascript"></script>
<script src="<?php echo PLUGINS?>jquery/jquery.getattributes.js" type="text/javascript" language="Javascript"></script>
<script src="<?php echo PLUGINS?>jquery/jquery.popupwindow.js" type="text/javascript" language="Javascript"></script>
<script src="<?php echo PLUGINS?>jquery/flexigrid/flexigrid.js" type="text/javascript" language="Javascript"></script>
<script src="<?php echo PLUGINS?>jquery/lightbox/jquery.lightbox.js" type="text/javascript" language="Javascript"></script>
<script src="<?php echo PLUGINS?>jquery/superfish/superfish.js" type="text/javascript" language="Javascript"></script>
<script src="<?php echo PLUGINS?>jquery/superfish/hoverIntent.js" type="text/javascript" language="Javascript"></script>
<script src="<?php echo PLUGINS?>jquery/jquery.maskedinput-1.2.2.min.js" type="text/javascript" language="Javascript"></script>
<script src="js/imagepreview.js" type="text/javascript" language="Javascript"></script>
<script src="<?php echo PLUGINS?>tiny_mce/tiny_mce.js" type="text/javascript" language="Javascript"></script>
<script src="<?php echo JS?>helper.js" type="text/javascript" language="Javascript"></script>
<script src="<?php echo JS?>popup.js" type="text/javascript" language="Javascript"></script>
<script type="text/javascript"> 
	$(document).ready(function(){ 
		$(function(){
			$('ul.sf-menu').superfish();
		});
	}); 
</script>


<!--[if lte IE 7]>
<link href="css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if lte IE 6]>

<link href="css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->


<!--date picker -->
<link rel="stylesheet" href="js/jquery-ui-1.7.1.custom.css" type="text/css" />
<script src="js/jquery-ui-1.7.1.custom.min.js"></script>
<script>
$(document).ready(function() {
	$("#start_date").datepicker({
		onSelect:function(theDate) {
			$("#end_date").datepicker('option','minDate',new Date(theDate))
		}
	})
	$("#end_date").datepicker({
		onSelect:function(theDate) {
			$("#start_date").datepicker('option','maxDate',new Date(theDate))
		}
	})
})
</script>



</head>
<body>
<div id="container">
