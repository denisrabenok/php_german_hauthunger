<?php
require ( '../includes/config.php' );
require ( '../'.PATH_LIBRARIES.'libraries.php' );
require ( '../'.PATH_INCLUDES.'json-headers.php' );
session_start();
$table_name = DB_TABLE_PREFIX."administrators";
$page = $_POST['page'];
$rp = $_POST['rp'];
$sortname = $_POST['sortname'];
$sortorder = $_POST['sortorder'];

if (!$sortname) $sortname = $fg_admins['sortname'];
if (!$sortorder) $sortorder = $fg_admins['sortorder'];

$sort = "ORDER BY $sortname $sortorder";

if (!$page) $page = 1;
if (!$rp) $rp = 10;

$start = (($page-1) * $rp);
$limit = "LIMIT $start, $rp";

$search_keyword = $_POST['search_keyword'];
$columns = $_POST['column'];
$where = '';
if ( ($search_keyword != '') || ($columns != '') ) {
	if ( $columns != '' ) {
		$field_names = array($columns);
	}else{
		$field_names = array('username', 'is_active');
	}	
	$where = $sql_helper->where_like($field_names, $search_keyword);
}

$sql = "SELECT * FROM $table_name $where $sort $limit";
$result = mysql_query($sql);

$total = $sql_helper->get_var("SELECT count(*) FROM $table_name $where $sort") ;
$total = $total ? $total : 0;

$json = "";
$json .= "{\n";
$json .= "page: $page,\n";
$json .= "total: $total,\n";
$json .= "rows: [";

$operation_url = INDEX_PAGE.'administrators-m&mode=';
$rc = false;	
while ($row = mysql_fetch_array($result))
{
	$start++;
	$record_id = $row['administrator_id'];
	//$active = $row['is_active'] == 1 ? "Yes" : "No" ;
	if ($row['is_active'] == 1){
		$active = '<img src="images/check.png" alt="Active" title="Active">';
	}else{
		$active = '<img src="images/x.png" alt="In-active" title="In-active">';
	}
	$action	= '';
	
	if ($record_id != $_SESSION[WEBSITE_NAME]['admin_id'])
	{
		$action .= '<a href="'.$operation_url.'view&id='.$record_id.'">'.ICON_VIEW.'</a>';
		$action .= '<a href="'.$operation_url.'edit&id='.$record_id.'">'.ICON_EDIT.'</a>';
		$action .= '<a href="'.$operation_url.'delete&id='.$record_id.'">'.ICON_DELETE.'</a>';
		
	}else{
		$action .= '<a href="'.$operation_url.'view&id='.$record_id.'">'.ICON_VIEW.'</a>';
		$action .= '<a href="'.$operation_url.'edit&id='.$record_id.'">'.ICON_EDIT.'</a>';
		$action .= ICON_NO_DELETE;
	}
	$email_address = '<a href="mailto:'.$row['email_address'].'">'.$row['email_address'].'</a>';
	if ($rc) $json .= ",";
	$json .= "\n{";
	$json .= "id:'".$record_id."',";
	$json .= "cell:['".$start."'";
	$json .= ",'".$action."'";
	$json .= ",'".$string->grid_safe($row['username'])."'";
	$json .= ",'".$string->grid_safe($row['firstname'])."'";
	$json .= ",'".$string->grid_safe($row['lastname'])."'";
	//$json .= ",'".$string->grid_safe($row['user_type_name'])."'";
	$json .= ",'".$active."']";
	$json .= "}";
	$rc = true;		
}
$json .= "]\n";
$json .= "}";
echo $json;
?>
