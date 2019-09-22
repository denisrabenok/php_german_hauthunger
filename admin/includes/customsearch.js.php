	//This function adds paramaters to the post of flexigrid. 
	//You can add a verification as well by return to false if you don't want flexigrid to submit			
	function addFormData() {				
		//passing a form object to serializeArray will get the valid data from all the objects,
		//but, if the you pass a non-form object, you have to specify the input elements that the data will come from
		var dt = $('#frm_customsearch').serializeArray();
		$("#<?php echo $grid_id; ?>").flexOptions({params: dt});
		return true;
	}

	//Submit Custom Search from data if button id="btn_customsearch" was clicked
	$('#btn_customsearch').click(function ()	{
		$('#system-message').hide();
		$('#<?php echo $grid_id; ?>').flexOptions({newp: 1}).flexReload();
		return false;
	});				

	//Submit Custom Search from data if Enter key was hit
	$("#frm_customsearch input").keypress(function (e) {  
		if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) { 
			$('#system-message').hide(); 
			$('#<?php echo $grid_id; ?>').flexOptions({newp: 1}).flexReload();
			return false;  
		} else {  
			return true;  
		}  
	});	

	$("#frm_customsearch").bind("submit", function(e) {
		//setCustomSearchSubmitStatus();
		$('#system-message').hide();
		$('#<?php echo $grid_id; ?>').flexOptions({newp: 1}).flexReload();            
	});

	$("#btn_reset").click(function() {
		$('#frm_customsearch').resetForm();
		//$('#search_keyword').val('');
		//$('#btn_customsearch').attr("disabled", false);
	});
	
	$(".refresh").bind("submit", function(e) {
		//setCustomSearchSubmitStatus();
		$('#system-message').hide();
		$('#<?php echo $grid_id; ?>').flexOptions({newp: 1}).flexReload();            
	});
