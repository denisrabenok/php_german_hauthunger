<?php
$upload_dir = "../uploads/logo/";
$mode = "view";
if ( isset($_GET['mode']) ) {
	$mode = strtolower(trim($_GET['mode']));	
} elseif ( isset($_POST['mode']) ) {
	$mode = strtolower(trim($_POST['mode']));
}

$config_id = 1;

$sub_heading = $mode=='edit' ? '[ '.ucfirst($mode).' ]' : '';

$is_editable_field = $helper->is_editable($mode);
$req_fld = $is_editable_field==true ? REQ_FIELD : "";

$form_action = strtoupper($_POST['form_action']);

$tablename = DB_TABLE_PREFIX.'config';

if ( $form_action != '' ) {
	$post_data = array();
	foreach( $_POST as $varname => $value )
	{
		$$varname = $string->sql_safe($value);
		$post_data[$varname] = $$varname;
	}	
	unset($post_data['form_action']);
	unset($post_data['mode']);	
	unset($post_data['config_id']);
	unset($post_data['c_username']);
	unset($post_data['x_password']);
	unset($post_data['c_password']);	
	unset($post_data['password2']);
	unset($post_data['Submit']);
	//$helper->pre_print_r($post_data); exit();
	$is_file_uploaded = false;
	$new_file = $_FILES['site_logo'];	  
	$filename = $new_file['name'];
	$filename = str_replace(' ', '_', $filename);
	$file_tmp = $new_file['tmp_name'];	
	$ext = strtolower(strrchr($filename,'.'));

	$new_filename = '';
	$unique_id = $helper->unique_id();
	$upload_result_msg = '';
	
	// Check if the file was selected or not.

	$is_valid_file = true;


	if ($is_valid_file==true)
	{
		$upload_result_msg .= "Failed to upload.<br>";
		$is_file_uploaded = false;
		
		// Upload the file	
		$new_filename = $unique_id.$ext;
		if (move_uploaded_file($file_tmp,$upload_dir.$new_filename))
		{			   			   			
			$info = getimagesize($upload_dir.$new_filename);
			list($width_old, $height_old) = $info;
			$img_width = 150;
			$img_height = 120;
			$img_thumb_width = 150;
			$img_thumb_height = 150;
			
			if ( $width_old < $height_old ) {
				$img_width = $img_height;
				$img_height = $img_width;
			}
			
			// Resize to required size
			// Large
			if ( $image->create_image( $upload_dir, $new_filename, $new_filename, $img_width, $img_height, true, false) )
			{
				// Thumbnail
				$new_filename_thumb = $unique_id."_thumb".$ext;
				if ( $image->create_image( $upload_dir, $new_filename, $new_filename_thumb, $img_thumb_width, $img_thumb_height, true, false) )
				{
					$upload_result_msg .= "Uploaded.<br>";
					$is_file_uploaded = true;			   
				} else {
					$upload_result_msg .= "Failed to upload.<br>";
				}
			} else {
				$upload_result_msg .= "Failed to upload.<br>";
			}
			
		}else{
			$upload_result_msg .= "Failed to upload.<br>";
		}
	}

	if ($is_file_uploaded==true) {
		$post_data['site_logo'] = $new_filename;
	} else {
		unset($post_data['site_logo']);
	}
}

$result = '';

switch ($form_action)
{
	case 'EDIT':		
		$is_updated = $sql_helper->update_all($tablename ,"config_id" ,$config_id ,$post_data);
		if ( $is_updated == 1 ) {
			$result='true';
		} elseif ( $is_updated == 0 ) {
			$result='true';
		} else {
			$result='false';
		}
		header("Location: ".INDEX_PAGE."site&a=edit&success=".$result);
		break;

	case 'VIEW':
		header("Location: ".INDEX_PAGE."site");
		break;

}

// Retrieve record
$record = $sql_helper->cget_row(DB_TABLE_PREFIX."config", "config_id = '$config_id'") ;
$site_name = $record->site_name;
$site_meta_title = $record->site_meta_title;
$site_paypal_email = $record->site_paypal_email;
$site_url = $record->site_url;
$welcome_content = $record->welcome_content;
$site_email = $record->site_email;
$site_facebook = $record->site_facebook;
$site_logo = $record->site_logo;
$is_site_logo_activated = $record->is_site_logo_activated;
$site_meta_keyword = $record->site_meta_keyword;
$site_meta_description = $record->site_meta_description;
$site_meta_title = $record->site_meta_title;
$site_facebook_url = $record->site_facebook_url;
$site_twitter_url = $record->site_twitter_url;
$site_google_url = $record->site_google_url;
$design_photo_img = '<img src="../uploads/logo/'.$site_logo.'" border="0">';
?>

<script type="text/javascript">
$(document).ready(function() {

	var validator = $("#frm_site").validate({
		rules: {
			site_meta_keyword: {
				required: true
			},
			site_meta_description: {
				required: true
			},
			site_name: {
				required: true
			},site_meta_title: {
				required: true,
				number:true
			},
			site_url: {
				required: true,
				url:true
			},
			site_facebook_url: {
				required: true,
				url:true
			},
			site_twitter_url: {
				required: true,
				url:true
			},
			site_google_url: {
				required: true,
				url:true
			},
			site_email: {
				required: true,
				email: true
			},
			site_logo: {
				<?php if ($mode == "add") { ?>
				required: true,
				<?php } ?>
				accept: "(jpg|png|jpeg|JPEG|JPG|gif|GIF)"
			}
		},
		messages: {
			UserLevel: "<?php echo $messages['validate']['required']; ?>",
			firstname: "<?php echo $messages['validate']['required']; ?>",
			lastname: "<?php echo $messages['validate']['required']; ?>",
			site_meta_keyword: "<?php echo $messages['validate']['required']; ?>",
			scrolltext: "<?php echo $messages['validate']['required']; ?>",
			home: "<?php echo $messages['validate']['required']; ?>",
			photos: "<?php echo $messages['validate']['required']; ?>",
			videos: "<?php echo $messages['validate']['required']; ?>",
			sections: "<?php echo $messages['validate']['required']; ?>",
			news_feed: "<?php echo $messages['validate']['required']; ?>",
			featured_event: "<?php echo $messages['validate']['required']; ?>",
			youtube_channel: "<?php echo $messages['validate']['required']; ?>",
			family_connections: "<?php echo $messages['validate']['required']; ?>",
			weather: "<?php echo $messages['validate']['required']; ?>",
			location_id: "<?php echo $messages['validate']['required']; ?>",
			location_name: "<?php echo $messages['validate']['required']; ?>",
			events_valendar: "<?php echo $messages['validate']['required']; ?>",
			back_to_list: "<?php echo $messages['validate']['required']; ?>",
			copyright: "<?php echo $messages['validate']['required']; ?>",
			all_right_reserved: "<?php echo $messages['validate']['required']; ?>",
			
			contact: "<?php echo $messages['validate']['required']; ?>",
			contact_name: "<?php echo $messages['validate']['required']; ?>",
			contact_sender: "<?php echo $messages['validate']['required']; ?>",
			contact_title: "<?php echo $messages['validate']['required']; ?>",
			contact_message: "<?php echo $messages['validate']['required']; ?>",
			contact_submit: "<?php echo $messages['validate']['required']; ?>",
			contact_error_submit: "<?php echo $messages['validate']['required']; ?>",
			contact_success_submit: "<?php echo $messages['validate']['required']; ?>",
			contact_receiver: "<?php echo $messages['validate']['required']; ?>",
			contact_captcha: "<?php echo $messages['validate']['required']; ?>",
			
			site_name: {
				required: "<?php echo $messages['validate']['required']; ?>"
			},site_meta_title: {
				required: "<?php echo $messages['validate']['required']; ?>"
			},
			site_url: {
				required: "<?php echo $messages['validate']['required']; ?>"
			},
			site_facebook_url: {
				required: "<?php echo $messages['validate']['required']; ?>"
			},
			site_twitter_url: {
				required: "<?php echo $messages['validate']['required']; ?>"
			},
			site_google_url: {
				required: "<?php echo $messages['validate']['required']; ?>"
			},
			site_email: {
				required: "<?php echo $messages['validate']['required']; ?>"
			},site_paypal_email: {
				required: "<?php echo $messages['validate']['required']; ?>"
			},
			site_facebook: {
				required: "<?php echo $messages['validate']['required']; ?>"
			},
			site_logo: {
				required: "<?php echo $messages['validate']['required']?>",
				accept: "Invalid file type! Must be an image."
			},site_meta_keyword: {
				required: "<?php echo $messages['validate']['required']?>"
			},site_meta_description: {
				required: "<?php echo $messages['validate']['required']?>",
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
		location.href = '<?php echo INDEX_PAGE."site"?>';
	});
		
});

</script>

<h1><?php echo $page_heading; ?> <small><?php echo $sub_heading; ?></small></h1>
	<?php if ( (isset($_GET['success'])) && ($_GET['success']=='true') ) { ?>
    <div id="system-message">
        <div class="info">
            <div class="message">Site configuration update successful!</div>
        </div>
    </div>        
    <?php } elseif ($_GET['success']=='false') { ?>
    <div id="system-message">
	    <div class="alert">
    	    <div class="message">Site configuration update failed!</a></div>
    	</div>        
    </div>
    <?php } ?>
<div class="content-main wide70">
	<?php if ( $is_editable_field == 1 ) { ?>
	<div class="standard-form-instruction"><strong>Note:</strong> <?php echo $req_fld?> denotes required field.</div>
    <?php } ?>
    <form action="<?php echo INDEX_PAGE . $page_option; ?>" method="post" id="frm_site" name="frm_site" enctype="multipart/form-data">
        <input type="hidden" name="form_action" value="<?php echo strtoupper($mode); ?>">
        <input type="hidden" name="mode" value="<?php echo $mode; ?>">
        <input type="hidden" name="config_id" value="<?php echo $config_id; ?>">
        <fieldset class="standard-form">
            <legend>Details</legend>
            <table class="form-table wide100">       
            	<?php if ( $mode == 'view' ) { ?>
                <tr>
                	<td colspan="2" align="right">[ <strong><a href="<?php echo INDEX_PAGE."site&mode=edit"; ?>">Update Configuration</a></strong> ]</td>
                </tr>     	
                <?php } ?>
                <!--<tr>
                    <td class="key"><label for="site_name">Site Name <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field ) { ?>
                    <td>
                    	<input type="text" name="site_name" id="site_name" size="35" maxlength="50" value="<?php echo $site_name?>" />
                        <span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><?php echo $site_name?></td>
                    <?php } ?>                                                                                                    
                </tr>
			    
				<tr>
					<td class="key"><label for="design_photo">Site Logo
					  <?php if ($mode=='add') echo $req_fld; ?>
					  </label></td>
					<?php if ( $is_editable_field ) { ?>
					<td><?php if ($mode=='edit') echo $design_photo_img."<p>" ?>
					  <input name="site_logo" id="site_logo" type="file" size="35" />
					  <span class="validation-status"></span>
					  <?php if ($mode=='edit') echo "</p>" ?>
					</td>
					<?php } else { ?>
					<td><?php echo $design_photo_img?></td>
					<?php } ?>
				</tr>
				<tr>
                    <td class="key"><label for="add_email_list">Site Logo Activated? <?php echo $req_fld?></label></td>
                    <?php  if ( $is_editable_field == 1 ) { ?>
                    <td>
                    	<?php
						$is_site_logo_activated = $mode=='add' ? 1 : $is_site_logo_activated;
						echo $scaffold->radio_arr($options=array('Yes','No'), $values=array(1, 0), "is_site_logo_activated", $is_site_logo_activated, "&nbsp;&nbsp;&nbsp;", $other_attributes="");
						?>
                        <span class="validation-status"></span>
                    </td>
                    <?php  } else { ?>
                    <td><?php echo $is_site_logo_activated==1 ? 'Yes' : 'No';?></td>
                    <?php  } ?>                                                                                                    
                </tr>
                <tr>
                    <td class="key"><label for="site_url">Site URL <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field ) { ?>
                    <td>
                    	<input type="text" name="site_url" id="site_url" size="35" maxlength="50" value="<?php echo $site_url?>" />
                    	<span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><a href="<?php echo $site_url?>" target="_blank"><?php echo $site_url?></a>
					</td>
                    <?php } ?>                                                                                                    
                </tr>
				
				-->
				
				<tr>
                    <td class="key"><label for="site_email">Site Email <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field ) { ?>
                    <td>
                    	<input type="text" name="site_email" id="site_email" size="35" maxlength="50" value="<?php echo $site_email?>" />
                        <span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><a href="mailto:<?php echo $site_email?>"><?php echo $site_email?></a></td>
                    <?php } ?>                                                                                                    
                </tr>
				
				<tr>
                    <td class="key"><label for="site_meta_title">Video Size limit(mb) <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field ) { ?>
                    <td>
                    	<input type="text" name="site_meta_title" id="site_meta_title" size="35" maxlength="50" value="<?php echo $site_meta_title?>" />
                        <span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><?php echo $site_meta_title?></td>
                    <?php } ?>                                                                                                    
                </tr>
				<!--
				<tr>
                    <td class="key key-vtop"><label for="site_meta_title">Meta Title <?php echo $req_fld?></label></td>
                    <?php  if ( $is_editable_field == 1 ) { ?>
                    <td>
                    	<textarea name="site_meta_title" class="site_meta_title" id="page_overview" cols="45" rows="1"><?php echo $site_meta_title?></textarea>
                    	<span class="validation-status"></span>
                    </td>
                    <?php  } else { ?>
                    <td><?php echo $site_meta_title?></td>
                    <?php  } ?>                                                                                                    
                </tr>
                
                <tr>
                    <td class="key key-vtop"><label for="site_meta_keyword">Meta Keyword <?php echo $req_fld?></label></td>
                    <?php  if ( $is_editable_field == 1 ) { ?>
                    <td>
                    	<textarea name="site_meta_keyword" class="site_meta_keyword" id="page_overview" cols="45" rows="3"><?php echo $site_meta_keyword?></textarea>
                    	<span class="validation-status"></span>
                    </td>
                    <?php  } else { ?>
                    <td><?php echo $site_meta_keyword?></td>
                    <?php  } ?>                                                                                                    
                </tr>
				
				<tr>
                    <td class="key key-vtop"><label for="site_meta_description">Meta Description <?php echo $req_fld?></label></td>
                    <?php  if ( $is_editable_field == 1 ) { ?>
                    <td>
                    	<textarea name="site_meta_description" class="site_meta_description" id="page_overview" cols="45" rows="3"><?php echo $site_meta_description?></textarea>
                    	<span class="validation-status"></span>
                    </td>
                    <?php  } else { ?>
                    <td><?php echo $site_meta_description?></td>
                    <?php  } ?>                                                                                                    
                </tr>
				
				<tr>
                    <td class="key"><label for="site_facebook_url">Site Facebook URL <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field ) { ?>
                    <td>
                    	<input type="text" name="site_facebook_url" id="site_facebook_url" size="35" maxlength="100" value="<?php echo $site_facebook_url?>" />
                        <span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><a href="<?php echo $site_facebook_url?>" target="_blank"><?php echo $site_facebook_url?></a></td>
                    <?php } ?>
				</tr>
				<tr>
                    <td class="key"><label for="site_twitter_url">Site Twitter URL <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field ) { ?>
                    <td>
                    	<input type="text" name="site_twitter_url" id="site_twitter_url" size="35" maxlength="100" value="<?php echo $site_twitter_url?>" />
                        <span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><a href="<?php echo $site_twitter_url?>" target="_blank"><?php echo $site_twitter_url?></a></td>
                    <?php } ?>
				</tr>
				<tr>
                    <td class="key"><label for="site_google_url">Site Google URL <?php echo $req_fld?></label></td>
                    <?php if ( $is_editable_field ) { ?>
                    <td>
                    	<input type="text" name="site_google_url" id="site_google_url" size="35" maxlength="100" value="<?php echo $site_google_url?>" />
                        <span class="validation-status"></span>
                    </td>
                    <?php } else { ?>
                    <td><a href="<?php echo $site_google_url?>" target="_blank"><?php echo $site_google_url?></a></td>
                    <?php } ?>
				</tr>
				-->
				
			    <tr>
                	<td colspan="2"></td>
                </tr>
            </table>        	
        </fieldset>    
        
        <?php if ( $mode == 'edit' ) { ?>       
        <div class="standard-form-buttons">
			<input class="button" name="Submit" id="Submit" type="submit" value="Update">
            <?php if ( $is_editable_field ) { ?>
            &nbsp;&nbsp;<input class="button" name="btnCancel" id="btnCancel" type="button" value="Cancel">
            <?php } ?>
        </div>
        <?php } ?>

    </form>
    <div class="clr"></div>
</div>
