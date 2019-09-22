<?php 
error_reporting(0);
$page = 5;
$whitecolor = "font-color:white;color:white;color:#FFFFFF;";
$activecolor = "font-color:#00CCFF;color:#00CCFF;";
$category_id = $_GET['category_id'];
include ('templates/header.php');?>
			<?php include ('templates/left-panel.php');?>
			<div id="content-right">
				<h1>So erreichst Du mich</h1>
				Per <strong>Email</strong> auf <a href="mailto:maya-sinnerose@bluewin.ch">maya-sinnerose@bluewin.ch</a>.<br />
				Per <strong>Telefon</strong> Donnerstag und Freitag oder SMS: 079 722 01 85 (keine Combox).
				<p>Bitte hab Verst&auml;ndnis, wenn ich nicht immer gleich antworte, bzw. das Telefon abnehmen kann.<br />
				</p>
				
				<strong>
				<a href="calendar.php" class="white-link<?php if (!isset($category_id)){ echo '-active';}?>">Nach Vereinbarung Termin m&ouml;glich</a>&nbsp;&nbsp;
				<a href="calendar.php?category_id=12" class="brown-link<?php if (isset($category_id) && $category_id == 12){ echo '-active';}?>">Basel</a>&nbsp;&nbsp;
				<a href="calendar.php?category_id=13" class="red-link<?php if (isset($category_id) && $category_id == 13){ echo '-active';}?>">Reserviert</a>&nbsp;&nbsp;</strong>
			  <iframe src="course-calendar.php?category_id=<?php echo $category_id;?>" width="550" height="500" frameborder="0" scrolling="no"></iframe>
			</div>
<?php include ('templates/footer.php');?>
			
		