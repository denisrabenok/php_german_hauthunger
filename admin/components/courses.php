<?php
session_start();
$grid_id = $page_name;
$target_url = INDEX_PAGE.$page_option.'-m&mode=';
?>
<?php if ($_SESSION[WEBSITE_NAME]['admin_id']  !=1){ ?>
<script>document.location.href='index.php?option=director';</script>
<?php } ?>
<form id="frm_customsearch">
<div style="float:left;">
	<h1><?php echo $page_heading?></h1>
</div>
<div id="custom-search-form" class="form-search">
		<strong>Keyword</strong>&nbsp;&nbsp;<input type="text" name="search_keyword" id="search_keyword">
		<?php
		$options_col = array('Title', 'Sub-title','Location');
		$values_col = array('event_title', 'event_sub_title','event_location');
		echo "&nbsp;<strong> by</strong> &nbsp;" . $scaffold->dropdown_arr($options_col, $values_col,"column","","Any","") . "&nbsp;";
		?> 
		<input class="button-search" type="button" value="Search" id="btn_customsearch">
  	    <input class="button-search" type="button" name="btn_reset" id="btn_reset" value="Clear" />
</div>
</form>
<div class="clr"></div>
<?php if ( isset($_GET['a']) && $_GET['a'] != '' ) { ?>
<div id="system-message">
    <div class="info">
        <div class="message"><?php echo $helper->operation_msg($_GET['a'], $_GET['success'], "Course")?></div>
    </div>
</div>
<?php } ?>

<?php require(PATH_TEMPLATES.'delete-msg-box.php'); ?>
<div class="clr"></div>

<?php echo $helper->init_grid($grid_id)?>

<script type="text/javascript">
	$("#<?php echo $grid_id?>").flexigrid
	({
		url: '<?php echo PATH_COMPONENTS.$page_name?>-list.php',
		dataType: 'json',
		colModel : 
			[	
			{display: '#', width : '30', align: 'right'},
			{display: 'Action', width : <?php echo GRID_3COL?>, align: 'center'},
			{display: 'Category', name : 'cat.category_name', width : 160, sortable : true, align: 'left'},
			{display: 'Title', name : 'event_title', width : 150, sortable : true, align: 'left'},
			{display: 'Sub-Title', name : 'event_sub_title', width : 100, sortable : true, align: 'left'},
			{display: 'Start', name : 'event_start_date', width : 80, sortable : false, align: 'right'},
			{display: 'End', name : 'event_end_date', width : 80, sortable : false, align: 'left'},
			{display: 'Location', name : 'event_location', width : 105, sortable : true, align: 'left'},
			{display: 'Activated', name : 'event_is_active', width : 55, sortable : true, align: 'center'}
			],
		buttons : 
			[
			{name: 'Add', bclass: 'add', onpress : buttonAction},
			{name: 'Delete', bclass: 'delete', onpress : buttonAction},
			{separator: true},
			{name: 'Select All', bclass: 'selectall', onpress : buttonAction},
			{name: 'Deselect All', bclass: 'deselectall', onpress : buttonAction},				
			{separator: true},
			{name: 'Default Listing', bclass: 'refresh', onpress : buttonAction}
			],
		sortname: "<?php echo $fg_events['sortname']?>",
		sortorder: "<?php echo $fg_events['sortorder']?>",
		usepager: true,
		useRp: true,
		rp: <?php echo $fg_events['rp']?>,
		rpOptions: <?php echo $fg_events['rpOptions']?>,
		showTableToggleBtn: <?php echo $fg_events['showTableToggleBtn']?>,
		width: '<?php echo $fg_events['width']?>',
		height: 'auto',
		resizable: <?php echo $fg_events['resizable']?>,
		onSubmit: addFormData,
		onRowSelected: RowSelected,
		multiSelect: true
	});
	
	function RowSelected(id, row, grid)
	{
		//alert("row id is " + id);
	}
	
	function buttonAction(com,grid)
	{
		if (com=='Delete')
		{
			if($('.trSelected',grid).length>0)
			{
				if(confirm('Delete ' + $('.trSelected',grid).length + ' record(s)?'))
				{
					var items = $('.trSelected',grid);
					var itemlist ='';
					for(i=0;i<items.length;i++) {
						itemlist+= items[i].id.substr(3)+",";
					}

					$.ajax 
					({
						type: "POST",
						dataType: "json",
						url: "<?php echo PATH_COMPONENTS?>delete.php?tn=<?php echo urlencode($crypt->encrypt('courses'))?>&fn=<?php echo urlencode($crypt->encrypt('event_id'))?>",
						data: "items="+itemlist,
						success: function(data) {
							if ( data.total_records > 0 ) {
								$('#system-message').hide();
								$('.system-message').fadeOut(1000);
								$('#del-result').html(data.result);							
								$('.system-message').fadeIn(1000).css({ display:"block" });
							}
							$("#<?php echo $grid_id?>").flexReload();
						}
					});
				}
			} else {
				alert("<?php echo $messages['fg']['sel_rec_delete']?>");
				return false;
			}
		}					
		else if (com=='Edit')
		{
			var items = $('.trSelected',grid);
			if (items.length > 0) {
				location.href = '<?php echo $target_url?>edit&id='+items[0].id.substr(3)
			}else{
				alert("<?php echo $messages['fg']['sel_rec_edit']?>");
			}
		}			
		else if (com=='Add')
		{
			location.href = '<?php echo $target_url?>add'
		}
		else if (com=='Default Listing')
		{
			location.href = '<?php echo INDEX_PAGE.$page_option?>'
			//$('#system-message').hide(); 
			//$('#<?php echo $grid_id; ?>').flexOptions({newp: 1}).flexReload();
			//return true;  	
		}
		else if (com=='View')
		{
			var items = $('.trSelected',grid);
			if (items.length > 0) {
				location.href = '<?php echo $target_url?>view&id='+items[0].id.substr(3)
			}else{
				alert("<?php echo $messages['fg']['sel_rec_view']?>");
			}
		}			
		else if (com=='Select All')
		{
			$('.bDiv tbody tr',grid).addClass('trSelected');
		}				
		else if (com=='Deselect All')
		{
			$('.bDiv tbody tr',grid).removeClass('trSelected');
		}				
	}
	
	$('b.top').click(function() {
		$(this).parent().toggleClass('fh');
	});
	
	<?php require(PATH_INCLUDES.'customsearch.js.php'); ?>			

</script>
