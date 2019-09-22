<?php 
$mode = "";
if ( isset($_GET['mode']) ) {
	$mode = strtolower(trim($_GET['mode']));	
} elseif ( isset($_POST['mode']) ) {
	$mode = strtolower(trim($_POST['mode']));
}

$category_id = 0;
if ($_GET['id'] > 0 ) {
	$category_id = $_GET['id'];
} elseif ( isset($_POST['category_id']) ) {
	$category_id = $_POST['category_id'];
}

$sub_heading = ucfirst($mode);

$button = $helper->button_val($mode, "Type");
$is_editable_field = $helper->is_editable($mode);
$req_fld = $is_editable_field==true ? REQ_FIELD : "";

$form_action = strtoupper($_POST['form_action']);

$tablename = DB_TABLE_PREFIX.'course_categories';

if ( $form_action != '' ) {
	$post_data = array();
	foreach( $_POST as $varname => $value )
	{
		$$varname = $string->sql_safe($value);
		$post_data[$varname] = $$varname;
	}	
	unset($post_data['form_action']);
	unset($post_data['mode']);	
	unset($post_data['category_id']);
	unset($post_data['c_username']);
	unset($post_data['password2']);
	unset($post_data['Submit']);
	unset($post_data['c_email_address']);
	//$helper->pre_print_r($post_data); //exit();
	if ($post_data['password'] == ""){
		unset($post_data['password']);
	}
}

$result = '';

switch ($form_action)
{
	case 'ADD':		
		$post_data['section'] = 1;
		$id = $sql_helper->insert_all($tablename,$post_data);
		$is_added = $id > 0 ? true : false;		
		$result =  $is_added==true ? $result='true' : $result='false';
		header("Location: ".INDEX_PAGE."types&a=add&success=".$result);
		break;
	
	case 'EDIT':
		$is_updated = $sql_helper->update_all($tablename ,"category_id" ,$category_id ,$post_data);
		if ( $is_updated == 1 ) {
			$result='true';
		} elseif ( $is_updated == 0 ) {
			$result='';
		} else {
			$result='false';
		}
		header("Location: ".INDEX_PAGE."types&a=edit&success=".$result);
		break;
	
	case 'DELETE':
		if ( (strtoupper($_POST["Delete"]) == 'YES') && ($category_id != 1) ) {
			$count_deleted = $sql_helper->delete($tablename ,"category_id" ,$category_id);
			$result = $count_deleted > 0 ? 'true' : 'false';
			header("Location: ".INDEX_PAGE."types&a=delete&success=".$result);
		} elseif ( strtoupper($_POST["Delete"]) == 'NO' ) {
			header("Location: ".INDEX_PAGE."types");
		} else { 
			header("Location: ".INDEX_PAGE."types-m&id=".$category_id);
		}				
		break;
	
	case 'VIEW':
		header("Location: ".INDEX_PAGE."types");
		break;

}

// Retrieve record

$record = $sql_helper->cget_row(DB_TABLE_PREFIX."course_categories", "category_id = '$category_id'") ;
$category_name = $record->category_name;
$category_text_color = $record->category_text_color;
?>

<script type="text/javascript">
$(document).ready(function() {

	var validator = $("#frm_<?php echo $page_name?>").validate({
		rules: {
			category_text_color: "required",
			category_name: "required"
		},
		messages: {
			category_text_color: "<?php echo $messages['validate']['required']?>",
			category_name: "<?php echo $messages['validate']['required']?>"
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
		location.href = '<?php echo INDEX_PAGE."types"?>';
	});
		
});

</script>

<h1><?php echo $page_heading?> <small>[ <?php echo $sub_heading?> ]</small></h1>

<?php if ( $mode == 'delete' ) { ?>
	
	<div id="system-message">
		<form action="<?php echo INDEX_PAGE . $page_option ?>" method="post" name="frm_<?php echo $page_name?>">
		<input type="hidden" name="form_action" value="<?php echo strtoupper($mode)?>">
        <input type="hidden" name="mode" value="<?php echo $mode?>">
		<input type="hidden" name="category_id" value="<?php echo $category_id?>">						
		<div class="alert">
			<div class="message">
			<?php echo CONFIRM_DELETE . "Type" ?>?&nbsp;&nbsp;
			<input class="button" name="Delete" type="submit" value="Yes" />&nbsp;&nbsp;
            <input class="button" name="Delete" type="submit" value="No" />
            </div>
		</div>
		</form>
	</div>
	   
<?php } ?>

<div class="content-main default-height wide65">
	<?php if ( $is_editable_field ) { ?>
	<div class="standard-form-instruction"><strong>Note:</strong> <?php echo $req_fld?> denotes required field.</div>
    <?php } ?>
    <form action="<?php echo INDEX_PAGE . $page_option ?>" method="post" id="frm_<?php echo $page_name?>">
        <input type="hidden" name="form_action" value="<?php echo strtoupper($mode)?>">
        <input type="hidden" name="mode" value="<?php echo $mode?>">
        <input type="hidden" name="category_id" value="<?php echo $category_id?>">
        <fieldset class="standard-form">
            <legend>Details</legend>
            <table class="form-table">  
				<tr>
                    <td class="key"><label for="category_name">Type <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field ) { ?>
                    <td>
                    	<input type="text" name="category_name" id="category_name" size="35" maxlength="50" value="<?php echo htmlentities($category_name)?>" />
                    	<span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><?php echo $category_name?></td>
                    <?php } ?>                                                                                                    
                </tr>
                <tr>
                    <td class="key"><label for="category_text_color">Color <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field ) { ?>
                    <td>
                    	<input type="text" name="category_text_color" id="category_text_color" readonly="readonly" size="35" maxlength="50" value="<?php echo htmlentities($category_text_color)?>" />
                        <span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><?php echo $category_text_color?></td>
                    <?php } ?>                                                                                                    
                </tr>
                
            </table>        	
        </fieldset>    
        
        <?php if ( $mode != 'delete' ) { ?>       
        <div class="standard-form-buttons">
			<input class="button" name="Submit" id="Submit" type="submit" value="<?php echo $button?>">
            <?php if ( $is_editable_field ) { ?>
            &nbsp;&nbsp;<input class="button" name="btnCancel" id="btnCancel" type="button" value="Cancel">
            <?php } ?>
        </div>
        <?php } ?>

    </form>
</div>
<style>
@media all 
{
	#jPicker { margin: 0px 8px; text-align: left; }
	#jPicker ul { font-size: 15px; margin: 0px 0px 0px 15px; padding: 0px; }
	#jPicker ul li { list-style: disc; padding: 2px 0px; }
	#jPicker ul li ul { margin-bottom: 10px; }
	#jPicker ul li ul li { list-style: circle; }
	#jPicker p { font-size: 13px; padding: 0px 10px; }
	#jPicker hr { clear: both; }
	#jPicker h2.jPicker { font-size: 16px; padding: 20px 10px; }
	#jPicker code { color: #8bd; font-size: 14px; font-weight: bold; }
	#jPicker pre { background: #eee; border: 1px solid #000; color: #000; display: block; font-size: 11px; margin: 10px 5px; padding: 5px; }
	#jPicker span { font-size: 13px; text-align: center; }
	#jPicker a { color: #ff8050; }
	#jPicker input { font-size: 13px; padding: 2px 5px; }
	#jPicker h2 { font-size: 16px; margin: 10px 0px; }
}
</style>
  <script src="js/jpicker-1.1.6.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(function()
    {
      $('#category_text_color').jPicker();
    });
  </script>
