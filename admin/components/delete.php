<?php
require ( '../includes/config.php' );
require ( '../'.PATH_LIBRARIES.'libraries.php' );

$table_name = '';
$field_name = '';
$val = ''; 								// To contain all the selected record IDs to delelete

$table_name = trim($_GET['tn'])!='' ? trim($_GET['tn']) : '';
$table_name = $crypt->decrypt($table_name);
$table_name = DB_TABLE_PREFIX.$table_name;
$field_name = trim($_GET['fn'])!='' ? trim($_GET['fn']) : '';
$field_name = $crypt->decrypt($field_name);
$val = trim($_POST['items']);			// $_POST['items'] are being passed as 1,3,4,7,12,15, <-- with extra comma at the end

$record_ids = explode(",", $val);
array_pop($record_ids); 				// Remove the last empty value cause by extra comma at the $_POST['items']
$total_ids = count($record_ids);
//$helper->pre_print_r($record_ids);

$total_deleted = 0;
$count_deleted = 0;

foreach($record_ids as $record_id)
{
	if ( $record_id==1 && $table_name==DB_TABLE_PREFIX.'administrators' && $total_ids==1 ) {
		$result = "Cannot delete the default Administrator!";
	} else {
		if ( $table_name == DB_TABLE_PREFIX.'administrators' ) {
			if ( $record_id != 1 ) { 
				$count_deleted = $sql_helper->delete($table_name, $field_name, $record_id);
				if ( $count_deleted > 0 ) {
					$total_deleted++; 
				}					
			} 
		}else{
			
			$count_deleted = $sql_helper->delete($table_name, $field_name, $record_id);			
			

			if ( $count_deleted > 0 ) {
				$total_deleted++; 
			}												

		}		
	}
}

$result = 'There are <strong style="font-size:1.5em; color:red;">'.$total_deleted.'</strong> of '.$total_ids.' record(s) DELETED!';		

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-type: text/x-json");
?>
{ affected_rows: '<?php echo $total_deleted?>', total_records : '<?php echo $total_ids?>' , result: '<?php echo $result?>' }