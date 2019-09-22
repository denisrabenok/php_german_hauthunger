<?php 
$mode = "";
$upload_dir = PATH_PHOTOS;

$upload_result = "";
$diag_result = "";
$is_diag_failed = false;

// Upload eventy diagnosis
if ( !is_dir($upload_dir) ) {
	$diag_result .= "The eventy <b>($upload_dir)</b> doesn't exist.<br />";
	$is_diag_failed = true;
}

if ( (!is_writeable($upload_dir)) && (is_dir($upload_dir)) ) {
	$diag_result .= "The eventy <b>($upload_dir)</b> is NOT writable, Please CHMOD (777).<br />";
	$is_diag_failed = true;
}

if ( isset($_GET['mode']) ) {
	$mode = strtolower(trim($_GET['mode']));	
} elseif ( isset($_POST['mode']) ) {
	$mode = strtolower(trim($_POST['mode']));
}

$event_id = 0;
if ($_GET['id'] > 0 ) {
	$event_id = $_GET['id'];
} elseif ( isset($_POST['event_id']) ) {
	$event_id = $_POST['event_id'];
}

$sub_heading = ucfirst($mode);

$button = $helper->button_val($mode, "Other Date");
$is_editable_field = $helper->is_editable($mode);
$req_fld = $is_editable_field==true ? REQ_FIELD : "";

$form_action = strtoupper($_POST['form_action']);

$tablename = DB_TABLE_PREFIX.'other_events';

if ( $form_action != '' ) {
	$post_data = array();
	foreach( $_POST as $varname => $value )
	{
		$$varname = $string->sql_safe($value);
		$post_data[$varname] = $$varname;
	}	
	unset($post_data['event_date_repetition']);
	unset($post_data['form_action']);
	unset($post_data['mode']);	
	unset($post_data['event_id']);
	unset($post_data['c_event_start_date']);
	unset($post_data['event_end_date2']);
	unset($post_data['Submit']);
	unset($post_data['c_event_location']);
	unset($post_data['event_start_time']);
	unset($post_data['event_end_time']);
	unset($post_data['event_start_date']);
	unset($post_data['event_end_date']);
	
	$delctr = 0;
	$deldatefrm = mysql_query("select * from tbl_event_dates where eevent_id='$event_id' and section=3 order by date_id asc");
	while ($delrows = mysql_fetch_array($deldatefrm)){
		$delctr++;
		
		
		$eventstartdate = $_POST['event_start_date'.$delctr];
		list($day, $month, $year) = split('[/.-]', $eventstartdate);
		$eventstartdate = "20".$year."-".$month."-".dayconvert($day);
		
		$eventenddate = $_POST['event_end_date'.$delctr];
		list($day, $month, $year) = split('[/.-]', $eventenddate);
		$eventenddate = "20".$year."-".$month."-".dayconvert($day);
		
		$streventstarttime = strlen($_POST['event_start_time'.$delctr]);
		if ($streventstarttime == 3){
			$event_start_time = "0".$_POST['event_start_time'.$delctr];
		}elseif ($streventstarttime == 4){
			$event_start_time = $_POST['event_start_time'.$delctr];
			$event_start_time = substr($event_start_time,0,2) . ":" . substr($event_start_time,-2);
		}else{
			$event_start_time = $_POST['event_start_time'.$delctr];
		}
		
		if (substr($event_start_time,0,-2) > 59){
			$event_start_time = substr($event_start_time,0,2) . ":00";
		}
		
		$streventendtime = strlen($_POST['event_end_time'.$delctr]);
		if ($streventendtime == 3){
			$event_end_time = "0".$_POST['event_end_time'.$delctr];
		}elseif ($streventendtime == 4){
			$event_end_time = $_POST['event_end_time'.$delctr];
			$event_end_time = substr($event_end_time,0,2) . ":" . substr($event_end_time,-2);
		}else{
			$event_end_time = $_POST['event_end_time'.$delctr];
		}
		
		if (substr($event_end_time,0,-2) > 59){
			$event_end_time = substr($event_end_time,0,2) . ":00";
		}
		
		$start_date = date("Y-m-d H:i:s",strtotime($eventstartdate . ' ' . $event_start_time));
		$end_date = date("Y-m-d H:i:s",strtotime($eventenddate . ' ' . $event_end_time));
		
		mysql_query("update tbl_event_dates set start_date='$start_date', end_date='$end_date' where date_id='".$_POST['event_date_id_'.$delctr]."'");
		
		
		unset($post_data['event_date_id_'.$delctr]);
		unset($post_data['event_start_date'.$delctr]);
		unset($post_data['event_start_time'.$delctr]);
		unset($post_data['event_end_date'.$delctr]);
		unset($post_data['event_end_time'.$delctr]);
		
	}
	
	//$helper->pre_print_r($post_data); //exit();
	
	$eventstartdate = $_POST['event_start_date'];
	list($day, $month, $year) = split('[/.-]', $eventstartdate);
	$eventstartdate = "20".$year."-".$month."-".dayconvert($day);
	
	$eventenddate = $_POST['event_end_date'];
	list($day, $month, $year) = split('[/.-]', $eventenddate);
	$eventenddate = "20".$year."-".$month."-".dayconvert($day);
	
	$streventstarttime = strlen($_POST['event_start_time']);
	if ($streventstarttime == 3){
		$event_start_time = "0".$_POST['event_start_time'];
	}elseif ($streventstarttime == 4){
		$event_start_time = $_POST['event_start_time'];
		$event_start_time = substr($event_start_time,0,2) . ":" . substr($event_start_time,-2);
	}else{
		$event_start_time = $_POST['event_start_time'];
	}
	
	/*if (substr($event_start_time,0,-2) > 59){
		$event_start_time = substr($event_start_time,0,2) . ":00";
	}*/
	
	$streventendtime = strlen($_POST['event_end_time']);
	if ($streventendtime == 3){
		$event_end_time = "0".$_POST['event_end_time'];
	}elseif ($streventendtime == 4){
		$event_end_time = $_POST['event_end_time'];
		$event_end_time = substr($event_end_time,0,2) . ":" . substr($event_end_time,-2);
	}else{
		$event_end_time = $_POST['event_end_time'];
	}
	
	/*if (substr($event_end_time,0,-2) > 59){
		$event_end_time = substr($event_end_time,0,2) . ":00";
	}*/
	
	
	
	
	$event_start_datex2 = date("Y-m-d H:i:s",strtotime($eventstartdate . ' ' . $event_start_time));
	$event_end_datex2 = date("Y-m-d H:i:s",strtotime($eventenddate . ' ' . $event_end_time));
	
	
}
function dayconvert($date){
	return $date;
}
$result = '';

switch ($form_action)
{
	case 'ADD':		
	
		/////////////////////////////////////////////////  STEP 1
		$new_file = $_FILES['event_photo'];
		$filename = $new_file['name'];
		$filename = str_replace(' ', '_', $filename);
		$file_tmp = $new_file['tmp_name'];
		$ext = strtolower(strrchr($filename,'.'));
		$new_filename = '';
		$unique_id = $helper->unique_id();
		
		/////////////////////////////////////////////////  STEP 2 
		if ($filename != ""){
			
			// Upload the file	
			$new_filename = $unique_id.$ext;
			if (move_uploaded_file($file_tmp,$upload_dir.$new_filename))
			{			   			   			
				$info = getimagesize($upload_dir.$new_filename);
				list($width_old, $height_old) = $info;
							
				$img_width 			= 300;
				$img_height 		= 250;
				
				if ( $width_old < $height_old ) {
					$img_width = $img_height;
					$img_height = $img_width;
				}
				// Resize to required size
				// Large
				if ( $image->create_image( $upload_dir, $new_filename, $new_filename, $img_width, $img_height, false, false) )
				{
					$upload_result_msg .= "Uploaded.<br>";	
					$is_uploaded = 1;
				}else{	
					$upload_result_msg .= "Failed to upload.<br>";	
					$is_uploaded = 0;
				}
			}
		}
		
		/////////////////////////////////////////////////  STEP 3
		
		if ($new_filename != "")	{	$post_data['event_photo'] = $new_filename;	}
		else						{	unset($post_data['event_photo']);			}
	
		$post_data['event_created_date'] = "now";
		$post_data['event_updated_date'] = "now";
		$id = $sql_helper->insert_all($tablename,$post_data);
		if ($id > 0){
			//multiple date events || repetitions
			$xrep = 1;
			for ($r = 1;$r<=$_POST['event_date_repetition'];$r++){
				if ($r == 1){
					$start_date = $event_start_datex2;
					$end_date = $event_end_datex2;
				}else{
					$xrep = $r - 1;
					$timeStamp = strtotime($event_start_datex2);
					$timeStamp += 24 * 60 * 60 * ($xrep*7);
					$start_date = date('Y-m-d H:i:s',$timeStamp);
					$timeStampx = strtotime($event_end_datex2);
					$timeStampx += 24 * 60 * 60 * ($xrep*7);
					$end_date = date('Y-m-d H:i:s',$timeStampx);
				}
				$section = 3;
				$eevent_id = $id;
				mysql_query("insert into tbl_event_dates values(0,'$eevent_id','$section','$start_date','$end_date')");
			}
		}
		$is_added = $id > 0 ? true : false;		
		$result =  $is_added==true ? $result='true' : $result='false';
		header("Location: ".INDEX_PAGE."other-events&a=add&success=true");
		break;
	
	case 'EDIT':
		
		/////////////////////////////////////////////////  STEP 1
	
		$new_file = $_FILES['event_photo'];
		$filename = $new_file['name'];
		$filename = str_replace(' ', '_', $filename);
		$file_tmp = $new_file['tmp_name'];
		$ext = strtolower(strrchr($filename,'.'));
		$new_filename = '';
		$unique_id = $helper->unique_id();
		
		
		/////////////////////////////////////////////////  STEP 2
		
		//// 
		if ($filename != ""){
			// Delete previous file	
			$record = $sql_helper->cget_row(DB_TABLE_PREFIX."events", "event_id = '$event_id'") ;
			if($record->event_photo != ""){
				$banner_photo_path			= PATH_PHOTOS.$record->event_photo;
				$file->delete($banner_photo_path);
			}
			// Upload the file	
			$new_filename = $unique_id.$ext;
			if (move_uploaded_file($file_tmp,$upload_dir.$new_filename))
			{			   			   			
				$info = getimagesize($upload_dir.$new_filename);
				list($width_old, $height_old) = $info;
							
				$img_width 			= 300;
				$img_height 		= 250;
				
				if ( $width_old < $height_old ) {
					$img_width = $img_height;
					$img_height = $img_width;
				}
				// Resize to required size
				// Large
				if ( $image->create_image( $upload_dir, $new_filename, $new_filename, $img_width, $img_height, false, false) )
				{
					$upload_result_msg .= "Uploaded.<br>";	
					$is_uploaded = 1;
				}else{	
					$upload_result_msg .= "Failed to upload.<br>";	
					$is_uploaded = 0;
				}
			}
		}
		
		/////////////////////////////////////////////////  STEP 3
		
		if ($new_filename != "")	{	$post_data['event_photo'] = $new_filename;	}
		else						{	unset($post_data['event_photo']);			}
	
		
		$is_updated = $sql_helper->update_all($tablename ,"event_id" ,$event_id ,$post_data);
		if ( $is_updated == 1 ) {
			$post_data['event_updated_date'] = "now";
			$sql_helper->update_all($tablename ,"event_id" ,$event_id ,$post_data);
			$result='true';
		} elseif ( $is_updated == 0 ) {
			$result='';
		} else {
			$result='false';
		}
		header("Location: ".INDEX_PAGE."other-events&a=edit&success=".$result);
		break;
	
	case 'DELETE':
		if ( (strtoupper($_POST["Delete"]) == 'YES')) {
			$count_deleted = $sql_helper->delete($tablename ,"event_id" ,$event_id);
			$result = $count_deleted > 0 ? 'true' : 'false';
			header("Location: ".INDEX_PAGE."other-events&a=delete&success=".$result);
		} elseif ( strtoupper($_POST["Delete"]) == 'NO' ) {
			header("Location: ".INDEX_PAGE."event");
		} else { 
			header("Location: ".INDEX_PAGE."other-events-m&id=".$event_id);
		}				
		break;
	
	case 'VIEW':
		header("Location: ".INDEX_PAGE."other-events");
		break;

}

// Retrieve record

$record = $sql_helper->cget_row(DB_TABLE_PREFIX."other_events", "event_id = '$event_id'") ;
$event_title = $record->event_title;
$event_sub_title = $record->event_sub_title;
$event_start_date = $record->event_start_date;
$event_end_date = $record->event_end_date;
$event_is_active = $record->event_is_active;
$event_location = $record->event_location;
$event_photo = $record->event_photo;
$event_link = $record->event_link;
$event_date_repetition = $record->event_date_repetition; 
$event_price = $record->event_price;
$photo_img = "";
if ($image != ""){
	$photo_img = '<img src="'.PATH_PHOTOS.$event_photo.'" border="0" style="margin: 5px 0px;" width="120px"><br /><br />';
}
if ($event_link != ""){
	$event_link = '<a href="'.$event_link.'" target=_blank>'.$rowevents['event_link'].'</a><br /><br />';
}
$category_id = $record->category_id;
$category_record = $sql_helper->cget_row(DB_TABLE_PREFIX."course_categories", "category_id = '$category_id'") ;
$category_name = $category_record ->category_name;
if ($mode == "add"){
	$event_start_date = "";
	$event_end_date = "";
}

if ($record->event_date_repetition == 0 or $record->event_date_repetition == ""){
	$record->event_date_repetition = 1;
}

?>
<script src="<?php echo PLUGINS?>jquery/jquery.timepicker.js"></script>

<script type="text/javascript">
function numericFilter(txb) {
   txb.value = txb.value.replace(/[^\0-9:]/ig, "");
}
$(document).ready(function() {
jQuery.validator.addMethod("complete_url", function(val, elem) {
    // if no url, don't do anything
    if (val.length == 0) { return true; }

    // if user has not entered http:// https:// or ftp:// assume they mean http://
    if(!/^(https?|ftp):\/\//i.test(val)) {
        val = 'http://'+val; // set both the value
        $(elem).val(val); // also update the form element
    }
    // now check if valid url
    // http://docs.jquery.com/Plugins/Validation/Methods/url
    // contributed by Scott Gonzalez: http://projects.scottsplayground.com/iri/
    return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(val);
});
	var validator = $("#frm_<?php echo $page_name?>").validate({
		rules: {
			event_sub_title: "required",
			event_title: "required",
			event_start_date: "required",
			event_end_date: "required",
			category_id: "required",
			event_price:{required:true},
			event_date_repetition:{required:true,number:true,min:1,maxlength:3},
			event_start_time: {required:true,minlength:3},
			event_end_time: {required:true,minlength:3},
			event_description: "required",
			event_location: {
				required: true
			},
			event_link: {
				required: true,
				complete_url:true
			},
			event_photo: {
				<?php if ($mode == "adzzd"){?>
				required: true,
				<?php } ?>
				accept: "(jpg|png|jpeg|JPEG|JPG|GIF|gif)"
			}
			
		},
		messages: {
			event_sub_title: "<?php echo $messages['validate']['required']?>",
			event_title: "<?php echo $messages['validate']['required']?>",
			category_id: "<?php echo $messages['validate']['required']?>",
			event_price: "<?php echo $messages['validate']['required']?>",
			event_description: "<?php echo $messages['validate']['required']?>",
			event_location: {	
				required: "<?php echo $messages['validate']['required']?>"
			},
			event_start_date: {
				required: "<?php echo $messages['validate']['required']?>"	
			},
			event_end_date: {
				required: "<?php echo $messages['validate']['required']?>"
			},
			event_link: {
				required: "",
				complete_url:"Invalid URL."
			},
			event_date_repetition:{required:"<?php echo $messages['validate']['required']?>",maxlength:"<?php echo $messages['validate']['required']?>"},
			event_start_time: {required:"<?php echo $messages['validate']['required']?>",minlength:"<?php echo $messages['validate']['required']?>"},
			event_end_time: {required:"<?php echo $messages['validate']['required']?>",minlength:"<?php echo $messages['validate']['required']?>"},
			event_photo: {
				<?php if ($mode == "add"){?>
				required: "<?php echo $messages['validate']['required']?>",
				<?php } ?>
			}
		},
		errorPlacement: function(error, element) {
			if ( element.is(":radio") )
				error.appendTo( element.parent().next().next() );
			else if ( element.is(":checkbox") )
				error.appendTo ( element.next() );
			else
				error.appendTo( element.parent().find('span.validation-status') );
		}
	});
	
	$('#btnCancel').click(function () {
		location.href = '<?php echo INDEX_PAGE."other-events"?>';
	});
	
});
/*
$(function() {
	$('#event_start_date,#event_end_date').appendDtpicker({
		"dateFormat": "YYYY-MM-DD hh:mm"
	});
});*/
</script>

<script>
$(document).ready(function() {
	$("#event_start_date").datepicker({
		dateFormat: 'd.m.y',
		onSelect:function(theDate) {
			$("#event_end_date").datepicker('option','minDate',new Date(theDate))
		}
	})
	$("#event_end_date").datepicker({
		dateFormat: 'd.m.y',
		onSelect:function(theDate) {
			$("#event_start_date").datepicker('option','maxDate',new Date(theDate))
		}
	})
})
</script>

<h1><?php echo $page_heading?> <small>[ <?php echo $sub_heading?> ]</small></h1>

<?php if ( $mode == 'delete' ) { ?>
	
	<div id="system-message">
		<form action="<?php echo INDEX_PAGE . $page_option ?>" method="post" name="frm_<?php echo $page_name?>">
		<input type="hidden" name="form_action" value="<?php echo strtoupper($mode)?>">
        <input type="hidden" name="mode" value="<?php echo $mode?>">
		<input type="hidden" name="event_id" value="<?php echo $event_id?>">						
       
		<div class="alert">
			<div class="message">
			<?php echo CONFIRM_DELETE . "other date" ?>?&nbsp;&nbsp;
			<input class="button" name="Delete" type="submit" value="Yes" />&nbsp;&nbsp;
            <input class="button" name="Delete" type="submit" value="No" />
            </div>
		</div>
        
		</form>
	</div>
	   
<?php } ?>

<div class="content-main wide65">
	<?php if ( $is_editable_field ) { ?>
	<div class="standard-form-instruction"><strong>Note:</strong> <?php echo $req_fld?> denotes required field.</div>
    <?php } ?>
    <form action="<?php echo INDEX_PAGE . $page_option ?>" method="post" id="frm_<?php echo $page_name?>"  enctype="multipart/form-data">
        <input type="hidden" name="form_action" value="<?php echo strtoupper($mode)?>">
        <input type="hidden" name="mode" value="<?php echo $mode?>">
        <input type="hidden" name="event_id" value="<?php echo $event_id?>">
        <fieldset class="standard-form">
            <legend>Details</legend>
            <table class="form-table">            	
                <tr>
					<td class="key"><label for="category_id">Type <?php echo $req_fld?></label></td>
					<?php if ( $is_editable_field ) { ?>
					<td>
						<?php
							$value_display['value'] = "category_id";
							$value_display['display'] = "category_name";
							$rs = $db->get_results("SELECT * FROM ".DB_TABLE_PREFIX."course_categories where section=1 ORDER BY category_name ASC");	
							echo $scaffold->dropdown_rs($rs,$value_display,"category_id",$category_id,"Select","style='width:195px;'");
						?>
						<span class="validation-status"></span>
					</td>
					<?php } else { ?>
					<td><?php echo $category_name ?></td>
					<?php } ?>                                                                                                    
				</tr>
                <tr>
                    <td class="key"><label for="event_title">Title <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field ) { ?>
                    <td>
                    	<input type="text" name="event_title" id="event_title" size="35" maxlength="50" value="<?php echo htmlentities($event_title)?>" />
                    	<span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><?php echo $event_title?></td>
                    <?php } ?>                                                                                                    
                </tr>
				<tr>
                    <td class="key"><label for="event_sub_title">Sub Title <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field ) { ?>
                    <td>
                    	<input type="text" name="event_sub_title" id="event_sub_title" size="35" maxlength="50" value="<?php echo htmlentities($event_sub_title)?>" />
                        <span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><?php echo $event_sub_title?></td>
                    <?php } ?>                                                                                                    
                </tr>
				
				<tr>
                    <td class="key"><label for="event_location">Location  <?php echo $req_fld?></label></td>
					 <?php if ( $is_editable_field ) { ?>
					<td>
						<input type="text" name="event_location" id="event_location" size="35" maxlength="50" value="<?php echo htmlentities($event_location)?>" />
						<span class="validation-status"></span>
						
					</td>
					<?php } else { ?>
                    <td><?php echo $event_location;?></td>
					 <?php } ?>  
                </tr>
				<tr>
                    <td class="key"><label for="event_description">Description <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field ) { ?>
                    <td>
					<textarea name="event_description" id="event_description" style="width:320px;height:150px;"><?php echo htmlentities($record->event_description)?></textarea>
                    	<span class="validation-status"></span>
						<span id="counter"></span>
					<script>
					$(document).ready(function()  {
						var characters = 1000;

						$("#counter").append("<br />You have <strong>"+  characters+"</strong> characters remaining");
						$("#event_description").keyup(function(){
							if($(this).val().length > characters){
							$(this).val($(this).val().substr(0, characters));
							}
						var remaining = characters -  $(this).val().length;
						$("#counter").html("<br />You have <strong>"+  remaining+"</strong> characters remaining");
						if(remaining <= 10)
						{
							$("#counter").css("color","red");
						}
						else
						{
							$("#counter").css("color","black");
						}
						});
					});
					</script>
                    </td>
                    <?php } else { ?>
                    <td><?php echo $record->event_description;?></td>
                    <?php } ?>                                                                                                    
                </tr>
				<tr>
                    <td class="key"><label for="event_price">Price  <?php echo $req_fld?></label></td>
					 <?php if ( $is_editable_field ) { ?>
					<td>
						<input type="text" name="event_price" id="event_price" size="35" maxlength="3" value="<?php echo htmlentities($record->event_price)?>" /> CHF
						<span class="validation-status"></span>
						
					</td>
					<?php } else { ?>
                    <td><?php echo $record->event_price;?> CHF				
					</td>
					 <?php } ?>  
                </tr>
				<tr>
                    <td class="key"><label for="event_link">URL  <?php echo $req_fld?></label></td>
					 <?php if ( $is_editable_field ) { ?>
					<td>
						<input type="text" name="event_link" id="event_link" size="35" maxlength="50" value="<?php echo htmlentities($record->event_link)?>" />
						<span class="validation-status"></span>
						
					</td>
					<?php } else { ?>
                    <td><a href="<?php echo $record->event_link;?>" target="_blank"><?php echo $record->event_link;?></a>
					
					</td>
					 <?php } ?>  
                </tr>
                <?php
				if ($mode == "add"){
			?>
                <tr>
                    <td class="key"><label for="event_start_date">Start Date & Time <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field ) { ?>
                    <td>
                    	<input type="text" name="event_start_date" id="event_start_date" style="width:45px;" maxlength="50" readonly="readonly" value="<?php if ($mode != "add"){echo htmlentities(date("j.n.y",strtotime($event_start_date)));}?>" /> 
						<input type="text" name="event_start_time" id="event_start_time" style="width:33px;" maxlength="5" value="<?php if ($mode != "add"){echo htmlentities(date("H:i",strtotime($event_start_date)));}?>" onKeyUp="numericFilter(this);"/> 
                    	<span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><?php echo  date("j.n.y h:iA",strtotime($event_start_date));?></td>
                    <?php } ?>                                                                                                    
                </tr>
                <tr>
                    <td class="key"><label for="event_end_date">End Date & Time <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field ) { ?>
                    <td>
                    	<input type="text" name="event_end_date" id="event_end_date" style="width:45px;" maxlength="50" readonly="readonly" value="<?php if ($mode != "add"){echo htmlentities(date("j.n.y",strtotime($event_end_date)));}?>" /> 
						<input type="text" name="event_end_time" id="event_end_time" style="width:33px;" maxlength="5" value="<?php if ($mode != "add"){echo htmlentities(date("H:i",strtotime($event_end_date)));}?>" onKeyUp="numericFilter(this);"/> 
                        <span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><?php echo  date("j.n.y h:iA",strtotime($event_end_date));?></td>
                    <?php } ?>                                                                                                    
                </tr>  

				<tr>
                    <td class="key"><label for="event_link">Repetition  <?php echo $req_fld?></label></td>
					 <?php if ( $is_editable_field ) { ?>
					<td>
						<input type="text" name="event_date_repetition" id="event_date_repetition" style="width:45px;" maxlength="3" value="<?php echo htmlentities($record->event_date_repetition)?>" />
						<span class="validation-status"></span>
						
					</td>
					<?php } else { ?>
                    <td><?php echo $record->event_date_repetition;?>
					
					</td>
					 <?php } ?>  
                </tr>
            <?php
				}else{
			?>
				<tr>
                    <td class="key"><label for="event_link">Dates </label></td>
					<td>
						<?php if ( isset($_GET['delid']) && $_GET['delid'] != '' ) { 
							$deldate = mysql_query("delete from tbl_event_dates where date_id='".$_GET['delid']."'");
						?>
						<div id="system-message">
							<div class="info">
								<div class="message">Event Date successfully DELETED!</div>
							</div>
						</div>
						<?php } ?>
						<table>
							<tr>
								<td><b>Start</b></td>
								<td><b>End</b></td>
							</tr>
							<?php
								$rowdatexctr = 0;
								$sqldates = mysql_query("select * from tbl_event_dates where eevent_id='$event_id' and section=3 order by date_id asc");
								$eventdatecount = mysql_num_rows($sqldates);
								while ($rowdates = mysql_fetch_array($sqldates)){
								
								$rowdatexctr++;
								$event_start_date = $rowdates['start_date'];
								$event_end_date = $rowdates['end_date'];
							?>
							<tr>
								<td>
									<input type="hidden" name="event_date_id_<?php echo $rowdatexctr;?>" value="<?php echo $rowdates['date_id'];?>" >
									<input type="text" name="event_start_date<?php echo $rowdatexctr;?>" id="event_start_date<?php echo $rowdatexctr;?>" style="width:45px;" maxlength="50" readonly="readonly" value="<?php if ($mode != "add"){echo htmlentities(date("j.n.y",strtotime($event_start_date)));}?>" /> 
									<input type="text" name="event_start_time<?php echo $rowdatexctr;?>" id="event_start_time" style="width:33px;" maxlength="5" value="<?php if ($mode != "add"){echo htmlentities(date("H:i",strtotime($event_start_date)));}?>" onKeyUp="numericFilter(this);"/>
								</td>
								<td>
									<input type="text" name="event_end_date<?php echo $rowdatexctr;?>" id="event_end_date<?php echo $rowdatexctr;?>" style="width:45px;" maxlength="50" readonly="readonly" value="<?php if ($mode != "add"){echo htmlentities(date("j.n.y",strtotime($event_end_date)));}?>" /> 
									<input type="text" name="event_end_time<?php echo $rowdatexctr;?>" id="event_end_time" style="width:33px;" maxlength="5" value="<?php if ($mode != "add"){echo htmlentities(date("H:i",strtotime($event_end_date)));}?>" onKeyUp="numericFilter(this);"/> 
									<?php if ($eventdatecount > 1){?>
									<a href="index.php?option=other-events-m&mode=<?php echo $mode;?>&id=<?php echo $event_id;?>&action=delete&delid=<?php echo $rowdates['date_id'];?>"><img src="images/x.png" border="0"/></a>
									<?php } ?>
								</td>
							</tr>
							<script>
							$(document).ready(function() {
								$("#event_start_date<?php echo $rowdatexctr;?>").datepicker({
									dateFormat: 'd.m.y',
									onSelect:function(theDate) {
										$("#event_end_date<?php echo $rowdatexctr;?>").datepicker('option','minDate',new Date(theDate))
									}
								})
								$("#event_end_date<?php echo $rowdatexctr;?>").datepicker({
									dateFormat: 'd.m.y',
									onSelect:function(theDate) {
										$("#event_start_date<?php echo $rowdatexctr;?>").datepicker('option','maxDate',new Date(theDate))
									}
								})
							})
							</script>
							<?php } ?>
						</table>
					</td>
                </tr>
				
			<?php
				}
			?>

				
                
				<tr>
                    <td class="key" valign="top"><label for="image">Image </label></td>
                    <?php if ( $is_editable_field ) { ?>
                    <td>
						<?php 
						if ($mode != "add"){
							if ($record->event_photo != ""){
								echo $photo_img;
							}
						}
						?>
						<b>Required Image Size: </b>
						<span style="padding-left: 20px;">Height: 300px</span>
						<span style="padding-left: 20px;">Width: 250px</span><br />
						<b>Supported File Types:</b> 
						<span style="padding-left: 20px;">(JPG, PNG, GIF)</span>
						<br /><br />
                    	<input name="event_photo" id="event_photo" type="file" size="25" />
                    	<span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><?php 
					if ($record->event_photo != ""){
						echo $photo_img;
					}
					?></td>
                    <?php } ?>	
				</tr>
				
				<tr>
					<td class="key"><label for="customer_status">Active </label></td>
					<?php if ( $is_editable_field ) { ?>
					<td>
					<?php
						$event_is_active = $mode=='add' ? 1 : $event_is_active;
						echo $scaffold->radio_arr($options=array('Yes','No'), $values=array(1, 0), "event_is_active", $event_is_active, "&nbsp;&nbsp;&nbsp;", $other_attributes="style='border:0;'");
					?>
					<span class="validation-status"></span>
					</td>
					<?php } else { ?>
					<td><?php if($event_is_active==1){	echo "Yes";	}else{ echo "No";	}	?></td>
					<?php } ?>                                                                                                    
				</tr>	
				<?php if ($mode != "add"){
				?>
				<tr>
                    <td class="key"><label for="event_end_date">Date Created</label></td>
                    <td><?php echo  date("j.n.y h:iA",strtotime($record->event_created_date));?></td>                                                                                           
                </tr>
					<?php if ($record->event_created_date != $record->event_updated_date && ($record->event_updated_date != "" && $record->event_updated_date !="0000-00-00 00:00:00")){
					?>
						<tr>
                    <td class="key"><label for="event_end_date">Date Updated</label></td>
                    <td><?php echo  date("j.n.y h:iA",strtotime($record->event_updated_date));?></td>                                                                                           
					</tr>
					
					<?php
					}
					?>
				<?php
				}
				?>
				
            </table>        	
        </fieldset>    
        
        <?php if ( $mode != 'delete' ) { ?>       
        <div class="standard-form-buttons">
			<?php if ($mode == "edit"){?>
			<input class="button" name="Submit" id="Submit" type="submit" value="Save">
			<?php } else {?>
			<input class="button" name="Submit" id="Submit" type="submit" value="<?php echo $button?>">
			<?php } ?>
            <?php if ( $is_editable_field ) { ?>
            &nbsp;&nbsp;<input class="button" name="btnCancel" id="btnCancel" type="button" value="Cancel">
            <?php } ?>
        </div>
        <?php } ?>

    </form>
</div>
