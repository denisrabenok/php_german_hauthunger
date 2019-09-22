<?php
$mode = "view";
if ( isset($_GET['mode']) ) {
	$mode = strtolower(trim($_GET['mode']));	
} elseif ( isset($_POST['mode']) ) {
	$mode = strtolower(trim($_POST['mode']));
}

$administrator_id = $_SESSION[WEBSITE_NAME]['admin_id'];

$sub_heading = $mode=='edit' ? '[ '.ucfirst($mode).' ]' : '';

$is_editable_field = $helper->is_editable($mode);
$req_fld = $is_editable_field==true ? REQ_FIELD : "";

$form_action = strtoupper($_POST['form_action']);

$tablename = DB_TABLE_PREFIX.'administrators';

if ( $form_action != '' ) {
	$post_data = array();
	foreach( $_POST as $varname => $value )
	{
		$$varname = $string->sql_safe($value);
		$post_data[$varname] = $$varname;
	}	
	unset($post_data['form_action']);
	unset($post_data['mode']);	
	unset($post_data['administrator_id']);
	unset($post_data['c_username']);
	unset($post_data['c_email_address']);
	unset($post_data['x_password']);
	unset($post_data['c_password']);	
	unset($post_data['password2']);
	unset($post_data['Submit']);
	//$helper->pre_print_r($post_data); exit();
	if ($post_data['password'] == ""){
		unset($post_data['password']);
	}
}

$result = '';

switch ($form_action)
{
	case 'EDIT':		
		$is_updated = $sql_helper->update_all($tablename ,"administrator_id" ,$administrator_id ,$post_data);
		if ( $is_updated == 1 ) {
			$result='true';
		} elseif ( $is_updated == 0 ) {
			$result='';
		} else {
			$result='false';
		}
		header("Location: ".INDEX_PAGE."my-account&a=edit&success=".$result);
		break;

	case 'VIEW':
		header("Location: ".INDEX_PAGE."my-account");
		break;

}

// Retrieve record
$record = $sql_helper->cget_row(DB_TABLE_PREFIX."administrators", "administrator_id = '$administrator_id'") ;
$lastname = $record->lastname;
$firstname = $record->firstname;
$username = $record->username;
$password = $record->password;
$email_address = $record->email_address;
?>

<script type="text/javascript">
$(document).ready(function() {

	var validator = $("#frm_<?php echo $page_name?>").validate({
		rules: {
			firstname: "required",
			lastname: "required",
			username: {
				required: true,
				remote: "<?php echo PATH_COMPONENTS?>is_exists.php?tn=<?php echo urlencode($crypt->encrypt('administrators'))?>&fn=<?php echo urlencode($crypt->encrypt('username'))?>&current=<?php echo $username?>&m=<?php echo $mode?>"
			},
			email_address: {
				required: true,
				email:true,
				remote: "<?php echo PATH_COMPONENTS?>is_exists.php?tn=<?php echo urlencode($crypt->encrypt('administrators'))?>&fn=<?php echo urlencode($crypt->encrypt('email_address'))?>&current=<?php echo $email_address?>&m=<?php echo $mode?>"
			},
			c_password: {
				//required: true,
				//equalTo: '#x_password'
			},
			password: {
				//required: true,
				minlength: <?php echo PWD_MIN_LEN?>
			},
			password2: {
				//required: true,
				equalTo: '#password'
			}
		},
		messages: {
			UserLevel: "<?php echo $messages['validate']['required']?>",
			firstname: "<?php echo $messages['validate']['required']?>",
			lastname: "<?php echo $messages['validate']['required']?>",
			username: {
				required: "<?php echo $messages['validate']['required']?>",
				remote: $.format("<strong>{0}</strong> <?php echo $messages['validate']['unavailable']?>")				
			},
			email_address: {
				required: "",
				email: "Invalid email",
				remote: $.format("<strong>{0}</strong>  is already in use")
			},
			c_password: {
				required: "<?php echo $messages['validate']['required']?>",
				equalTo: "<?php echo $messages['validate']['pwd_mismatch']?>"
			},
			password: {
				required: "<?php echo $messages['validate']['required']?>",
				minlength: "<?php echo $messages['validate']['min_len'] . PWD_MIN_LEN ?>"
			},
			password2: {
				required: "<?php echo $messages['validate']['required']?>",
				equalTo: "<?php echo $messages['validate']['pwd_mismatch']?>"
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
		location.href = '<?php echo INDEX_PAGE."my-account"?>';
	});
		
});

</script>

<h1><?php echo $page_heading?> <small><?php echo $sub_heading?></small></h1>
	<?php if ( (isset($_GET['success'])) && ($_GET['success']=='true') ) { ?>
    <div id="system-message">
        <div class="info">
            <div class="message">Account update successful!</div>
        </div>
    </div>        
    <?php } elseif ($_GET['success']=='false') { ?>
    <div id="system-message">
	    <div class="alert">
    	    <div class="message">Account update failed!</a></div>
    	</div>        
    </div>
    <?php } ?>
<div class="content-main default-height wide60">
	<?php if ( $is_editable_field == 1 ) { ?>
	<div class="standard-form-instruction"><strong>Note:</strong> <?php echo $req_fld?> denotes required field.</div>
    <?php } ?>
    <form action="<?php echo INDEX_PAGE . $page_option ?>" method="post" id="frm_<?php echo $page_name?>">
        <input type="hidden" name="form_action" value="<?php echo strtoupper($mode)?>">
        <input type="hidden" name="mode" value="<?php echo $mode?>">
        <input type="hidden" name="administrator_id" value="<?php echo $administrator_id?>">
        <fieldset class="standard-form">
            <legend>Details</legend>
            <table class="form-table wide100">       
            	<?php if ( $mode == 'view' ) { ?>
                <tr>
                	<td colspan="2" align="right">[ <strong><a href="<?php echo INDEX_PAGE."my-account&mode=edit"?>">Update My Account</a></strong> ]</td>
                </tr>     	
                <?php } ?>
                <tr>
                    <td class="key"><label for="firstname">First Name <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field == 1 ) { ?>
                    <td>
                    	<input type="text" name="firstname" id="firstname" size="35" maxlength="50" value="<?php echo htmlentities($firstname)?>" />
                        <span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><?php echo $firstname?></td>
                    <?php } ?>                                                                                                    
                </tr>
                <tr>
                    <td class="key"><label for="lastname">Last Name <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field == 1 ) { ?>
                    <td>
                    	<input type="text" name="lastname" id="lastname" size="35" maxlength="50" value="<?php echo htmlentities($lastname)?>" />
                    	<span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><?php echo $lastname?></td>
                    <?php } ?>                                                                                                    
                </tr>
                <tr>
                    <td class="key"><label for="Username">Username <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field == 1 ) { ?>
                    <td>
                    	<input type="text" name="username" id="username" size="35" maxlength="50" value="<?php echo htmlentities($username)?>" />
                    	<span class="validation-status"></span>
                        <input type="hidden" name="c_username" id="c_username" value="<?php echo htmlentities(current_username)?>" />
                    </td>
                    <?php } else { ?>
                    <td><?php echo $username?></td>
                    <?php } ?>                                                                                                    
                </tr>
				<tr>
                    <td class="key"><label for="email_address">Email Address  <?php echo $req_fld?></label></td>
					 <?php if ( $is_editable_field ) { ?>
					<td>
						<input type="text" name="email_address" id="email_address" size="35" maxlength="50" value="<?php echo htmlentities($email_address)?>" />
						<span class="validation-status"></span>
						<input type="hidden" name="c_email_address" id="c_email_address" value="<?php echo htmlentities(current_email_address)?>" />
					</td>
					<?php } else { ?>
                    <td><?php echo '<a href="mailto:'.$email_address.'">'.$email_address.'</a>';?></td>
					 <?php } ?>  
                </tr>
                <?php if ( $is_editable_field == 0 ) { ?>
                <tr>
                    <td class="key"><label for="Password">Password</label></td>                   
                    <td>- Not Shown -</td>
                </tr>   
                <?php } ?>                                          
                <?php if ( $is_editable_field == 1 ) { ?>
                <tr>
                    <td class="key"><label for="Password">Current Password </label></td>                   
                    <td>
                    	<input type="password" name="c_password" id="c_password" size="35" maxlength="50" />
                        <input type="hidden" name="x_password" id="x_password" value="<?php echo $password?>" />
                        <span class="validation-status"></span>
						
                    </td>
                </tr>   
                <?php } ?>                                          
               	<?php if ( $is_editable_field == 1 ) { ?>                                                                                                    
                <tr>
                    <td class="key"><label for="Password">New Password </label></td>
                    <td>
                    	<input type="password" name="password" id="password" size="35" maxlength="50" />
                        <span class="validation-status"></span>
                    </td>
                </tr>
                <?php } ?>   
                <?php if ( $is_editable_field == 1 ) { ?>                                          
                <tr>
                    <td class="key"><label for="Password2">Verify New Password </label></td>
                    <td>
                    	<input type="password" name="password2" id="password2" size="35" maxlength="50" />
                        <span class="validation-status"></span>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                	<td colspan="2"></td>
                </tr>
            </table>        	
        </fieldset>    
        
        <?php if ( $mode == 'edit' ) { ?>       
        <div class="standard-form-buttons">
			<input class="button" name="Submit" id="Submit" type="submit" value="Update">
            <?php if ( $is_editable_field == 1 ) { ?>
            &nbsp;&nbsp;<input class="button" name="btnCancel" id="btnCancel" type="button" value="Cancel">
            <?php } ?>
        </div>
        <?php } ?>

    </form>
    <div class="clr"></div>
</div>
