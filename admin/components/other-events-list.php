<?php
require ( '../includes/config.php' );
require ( '../'.PATH_LIBRARIES.'libraries.php' );
require ( '../'.PATH_INCLUDES.'json-headers.php' );
session_start();
$table_name = DB_TABLE_PREFIX."other_events";
$page = $_POST['page'];
$rp = $_POST['rp'];
$sortname = $_POST['sortname'];
$sortorder = $_POST['sortorder'];
if (!$sortname) $sortname = $fg_events['sortname'];
if (!$sortorder) $sortorder = $fg_events['sortorder'];
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
		$field_names = array('event_title', 'event_sub_title','event_location');
	}	
	$where = $sql_helper->where_like($field_names, $search_keyword);
	$where .= " and edates.section=3";
}else{
	$where .= " where edates.section=3";
}
$sql = "SELECT *,MIN(start_date) as event_start_date, MAX(end_date) as event_end_date FROM $table_name e inner join tbl_course_categories cat on 
	e.category_id=cat.category_id
	inner join tbl_event_dates edates on edates.eevent_id=e.event_id
	$where group by e.event_id $sort $limit";
$result = mysql_query($sql);
$total = $sql_helper->get_var("SELECT count(*) FROM $table_name e inner join tbl_course_categories cat on 
	e.category_id=cat.category_id inner join tbl_event_dates edates on edates.eevent_id=e.event_id $where group by e.event_id  $sort") ;
	
$total = $total ? $total : 0;
$json = "";
$json .= "{\n";
$json .= "page: $page,\n";
$json .= "total: $total,\n";
$json .= "rows: [";
$operation_url = INDEX_PAGE.'other-events-m&mode=';
$rc = false;	
while ($row = mysql_fetch_array($result))
{
	$start++;
	$record_id = $row['event_id'];
	if ($row['event_is_active'] == 1){
		$active = '<img src="images/check.png" alt="Active" title="Active">';
	}else{
		$active = '<img src="images/x.png" alt="In-active" title="In-active">';
	}
	$action	= '';
	$action .= '<a href="'.$operation_url.'view&id='.$record_id.'">'.ICON_VIEW.'</a>';
	$action .= '<a href="'.$operation_url.'edit&id='.$record_id.'">'.ICON_EDIT.'</a>';
	$action .= '<a href="'.$operation_url.'delete&id='.$record_id.'">'.ICON_DELETE.'</a>';
	$email_address = '<a href="mailto:'.$row['email_address'].'">'.$row['email_address'].'</a>';
	
	$event_start_date = date("j.n.y h:iA",strtotime($row['event_start_date']));
	$event_end_date = date("j.n.y h:iA",strtotime($row['event_end_date']));
	
	if ($rc) $json .= ",";
	$json .= "\n{";
	$json .= "id:'".$record_id."',";
	$json .= "cell:['".$start."'";
	$json .= ",'".$action."'";
	$json .= ",'".$row['category_name']."'";
	$json .= ",'".$string->grid_safe($row['event_title'])."'";
	$json .= ",'".$string->grid_safe($row['event_sub_title'])."'";
	$json .= ",'".$string->grid_safe($event_start_date)."'";
	$json .= ",'".$string->grid_safe($event_end_date)."'";
	$json .= ",'".$string->grid_safe($row['event_location'])."'";
	$json .= ",'".$active."']";
	$json .= "}";
	$rc = true;		
}
$json .= "]\n";
$json .= "}";
echo $json;
?>