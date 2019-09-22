<?php 
$page = 3;
include ('templates/header.php');?>
			<?php include ('templates/left-panel.php');?>
			<div id="content-right">
				<h1>Bilder</h1>
				Ich m&ouml;chte hier niemanden entt&auml;uschen. Ich weiss, dass Bilder mehr als Tausend Worte sagen.
				<p>Ich finde jedoch, dass weniger manchmal mehr ist.</p>
				<p>Befl&uuml;gle Deine Phantasie und mach Dir selber ein Bild von mir.</p> 
				
				<ul id="gallery">
					<li><a href="#" id="img1"><img src="images/image1.JPG" width="140px" height="190px" alt="bilder"></a></li>
					<li><a href="#" id="img2"><img src="images/image2.JPG" width="140px" height="190px" alt="bilder"></a></li>
					<li><a href="#" id="img3"><img src="images/image3.JPG" width="140px" height="190px" alt="bilder"></a></li>
				</ul>
			</div>
<script src='js/jquery-1.9.1.min.js' language="javascript" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {	
		$("#img1").click(function(){ $('#content-left').html('<img src="images/image1.JPG" width="300px" height="400px" alt="hauthunger.ch" id="leftpanel-img" />');}); 
		$("#img2").click(function(){ $('#content-left').html('<img src="images/image2.JPG" width="300px" height="400px" alt="hauthunger.ch" id="leftpanel-img" />');}); 
		$("#img3").click(function(){ $('#content-left').html('<img src="images/image3.JPG" width="300px" height="400px" alt="hauthunger.ch" id="leftpanel-img" />');}); 
	})
</script>
<?php include ('templates/footer.php');?>
			
		