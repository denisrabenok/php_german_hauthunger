<?php
class Helper
{
	function init_grid($grid_id="")
	{
		$grid = '	<table id="'.strtolower($grid_id).'" style="display:none"></table>';
		return $grid;
	}
	
	function button_val($mode, $button_name) 
	{	
		switch ($mode)
		{
			case 'add':
				return "Add New " . $button_name;
				break;
			case 'edit':
				return "Update " . $button_name;
				break;
			case "delete":
				return "Delete " . $button_name;
				break;
			default: 
				return "&nbsp;&nbsp;&nbsp;OK&nbsp;&nbsp;&nbsp;";
		}	
	}

	function operation_msg($action="", $result="", $record="")
	{			
		$result_msg = "";
		$is_successful = true;
		if ( $result != "true" ) {
			$is_successful = false;
		}
		
		switch ($action) 
		{
			case 'add':
				$result_msg = $record . " successfully SAVED!";
				if ( $is_successful == false ) {
					$result_msg = "Adding " & $record & " failed!";
				}
				break;
			case 'edit':
				$result_msg = $record . " successfully UPDATED!";
				if ( $is_successful == false ) {
					if ( $result == '' ) {
						$result_msg = "You haven't made any changes from the selected record!";
					} else {
						$result_msg = $record . " update failed!";
					}
				}
				break;
			case 'delete':
				$result_msg = $record . " successfully DELETED!";
				if ( $is_successful == false ) {
					$result_msg = $record . " delete failed!&nbsp;&nbsp;The record might be already in use or the request cannot be processed.";
				}
				break;
			default:
				$result_msg = "";
		}			
		return $result_msg;		
	}
	
	
	function is_editable($mode)
	{		
		switch ($mode)
		{
			case 'view':
				return false;
				break;
			case 'add':
				return true;
				break;
			case 'edit':
				return true;
				break;
			case 'delete':
				return false;
				break;
			default:
				return false;
		}
	}
	
	function pre_print_r($array)
	{
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}


	function unique_id()
	{
		list($usec, $sec) = explode(" ", microtime());
		list($int, $dec) = explode(".", $usec);
		return $sec.$dec;   
	}


	function get_photo_size($file, $postfix="")
	{
		$dot = strrpos($file, '.');
		$ext = substr($file, $dot);		
		$basename = preg_replace('#\.[^.]*$#', '', $file);
		$filename = $basename.$postfix.$ext;

//		$ext = strtolower(strrchr($file,'.'));		
//		$pos = strrpos($file, ".");
//		$filename = substr($file, 0, $pos).$postfix.$ext;
		
		return $filename;	
	}

	function readable_date($var,$format="d-M-Y")
	{
		return date($format, strtotime($var));
	}

	function readable_datetime($var,$format="d-M-Y, h:i A")
	{
		return date($format, strtotime($var));
	}
	
}
?>