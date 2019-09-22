<?php
	require ( 'admin/includes/config.php' );
	require ( 'admin/'.PATH_LIBRARIES.'libraries.php' );	
	$events = array();
	$_REQUEST['start'] = $_REQUEST['start'] - 86400;
	$startreservationdate = date('Y-m-d 00:00:00',$_REQUEST['start']);//+(86400));
	$endreservationdate = date('Y-m-d 23:59:59',$_REQUEST['end']);
	$eventImage = "";
	if (isset($_GET['category_id']) && $_GET['category_id'] != ""){
		$andquery = " and e.category_id='".$_GET['category_id']."'";
	}

	$sqlevents = mysql_query("select * from tbl_events e inner join tbl_course_categories c on 
	e.category_id=c.category_id
	inner join tbl_event_dates edates on edates.eevent_id=e.event_id
	where edates.start_date>='$startreservationdate' and edates.end_date<='$endreservationdate' and event_is_active=1 and edates.section=1 $andquery");


	while ($rowevents = mysql_fetch_array($sqlevents)){
		if ($rowevents['event_photo'] != ""){
			$eventImage = '<img src="uploads/photos/'.$rowevents[event_photo].'" border="0" style="margin: 5px 0px;" width="120px"><br /><br />';
		}else{
			$eventImage = "";
		}
		if ($rowevents['category_text_color'] == "#FFFFFF"){
			$text_color = "#969696";
		}elseif ($rowevents['category_text_color'] == "#CCFF66"){
			$rowevents['category_text_color'] = "#8FD602";
			$text_color = "white";
		}else{
			$text_color = "white";
		}
		if ($rowevents['event_link'] != ""){
			if ($rowevents['category_text_color'] != "#FFFFFF"){
				$event_link = '<br /><br /><a href="'.$rowevents['event_link'].'" target=_blank style="color:#ffffff;font-color:#ffffff;">'.$rowevents['event_link'].'</a>';
			}else{
				$event_link = '<br /><br /><a href="'.$rowevents['event_link'].'" target=_blank style="color:#00CCFF;font-color:#00CCFF;">'.$rowevents['event_link'].'</a>';
			}
		}else{
			$event_link = '';
		}
		$event_link = '';
		if ($rowevents['event_price'] != ""){
			$event_price = '<br /><strong>Preis</strong>: '.$rowevents['event_price'].' CHF';
		}else{
			$event_price = '';
		}
		
		
		// $eventArray['title'] = $rowevents["event_title"] . " - ". $rowevents['event_sub_title'];
		$eventArray['title'] = ($rowevents['event_title']=="Bassersdorf"?"Basel":$rowevents['event_title']) . " - ". $rowevents['event_sub_title'];
		$eventArray['start'] = $rowevents["start_date"];
		$eventArray['end'] = $rowevents["end_date"];	
		$eventArray['dayname'] = date("l",strtotime($rowevents["start_date"]));
		$start_day = date("j",strtotime($rowevents["start_date"]));
		$end_day = date("j",strtotime($rowevents["end_date"]));
		if ($start_day != $end_day){
			// $eventArray['description'] = '<div style=padding:15px;font-family:arial;background-color:'.$rowevents['category_text_color'].';color:'.$text_color.';><h2>'.$rowevents["event_title"].'</h2><h3>'.$rowevents["event_sub_title"].'</h3><strong>Datum</strong>: '.date("M j, Y H:i",strtotime($rowevents["start_date"])).'-'.date("M j, Y H:i",strtotime($rowevents["end_date"])).'<br /><strong>Wo</strong>: '.$rowevents['event_location'].$event_price.$event_link.'<br /><br />'.$eventImage.'<a href="download-ical.php?id='.$rowevents["event_id"].'"><img src=images/icon-downloads.png width=16px height=16px border=0/></a> <a onclick=emailevent(1,"'.$rowevents[event_id].'") style=cursor:pointer;><img src=images/icon-send-email.png width=16px height=16px border=0/></a></div>';
			$eventArray['description'] = '<div style=padding:15px;font-family:arial;background-color:'.$rowevents['category_text_color'].';color:'.$text_color.';><h2>'.($rowevents['event_title']=="Bassersdorf"?"Basel":$rowevents['event_title']).'</h2><h3>'.$rowevents["event_sub_title"].'</h3><strong>Datum</strong>: '.date("M j, Y H:i",strtotime($rowevents["start_date"])).'-'.date("M j, Y H:i",strtotime($rowevents["end_date"])).'<br /><strong>Wo</strong>: '.$rowevents['event_location'].$event_price.$event_link.'<br /><br />'.$eventImage.'<a href="download-ical.php?id='.$rowevents["event_id"].'"><img src=images/icon-downloads.png width=16px height=16px border=0/></a> <a onclick=emailevent(1,"'.$rowevents[event_id].'") style=cursor:pointer;><img src=images/icon-send-email.png width=16px height=16px border=0/></a></div>';
		}else{
				$eventArray['description'] = '<div style=padding:15px;font-family:arial;background-color:'.$rowevents['category_text_color'].';color:'.$text_color.';><h2>'.($rowevents['event_title']=="Bassersdorf"?"Basel":$rowevents['event_title']).'</h2><h3>'.$rowevents["event_sub_title"].'</h3><strong>Datum</strong>: '.date("M j, Y H:i",strtotime($rowevents["start_date"])).'-'.date("H:i",strtotime($rowevents["end_date"])).'<br /><strong>Wo</strong>: '.$rowevents['event_location'].$event_price.$event_link.'<br /><br />'.$eventImage.'<a href="download-ical.php?id='.$rowevents["event_id"].'"><img src=images/icon-downloads.png width=16px height=16px border=0/></a> <a onclick=emailevent(1,"'.$rowevents[event_id].'") style=cursor:pointer;><img src=images/icon-send-email.png width=16px height=16px border=0/></a></div>';
			}
		
		$eventArray['className'] = 'event' . $rowevents['category_id'];
		$eventArray['id'] = $rowevents["event_id"];
		$eventArray['allDay'] = false;
		$eventArray['editable'] = false;
		$eventArray['disableResizing'] = true;
		$events[] = $eventArray;
	}
	header('Content-type: application/json');
	echo json_encode($events);
?>