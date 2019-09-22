<?php
require ( 'admin/includes/config.php' );
require ( 'admin/'.PATH_LIBRARIES.'libraries.php' );	

$sqlquery = mysql_query("select * from tbl_events where event_id='".$_GET['id']."'");
$rowquery = mysql_fetch_array($sqlquery);
if ($_GET['email'] == ""){
header("Content-Type: text/Calendar");
header("Content-Disposition: inline; filename=".$rowquery['event_title'].".ics");
}
$event_title = $rowquery['event_title'];
$title = $rowquery['event_title'];
$event_sub_title = $rowquery['event_sub_title'];
$event_location = $rowquery['event_location'];
$event_sub_title = $rowquery['event_sub_title'];
$date_start = $rowquery['event_start_date'];
$date_end = $rowquery['event_end_date'];
$date_start = date('d.m.Y',strtotime($rowquery['event_start_date']));
$date_end = date('d.m.Y',strtotime($rowquery['event_start_date']));
$description = "";
$description .='<table class="form-table" style="width:370px;">';  
$description .='<tr><td width="150px"><b>Event Title:</b></td><td width="250px">'.$rowquery['event_title'].'</td></tr>';
$description .='<tr><td width="150px"><b>Event Sub-Title:</b></td><td width="250px">'.$rowquery['event_sub_title'].'</td></tr>';
$description .='<tr><td width="150px"><b>Event Location:</b></td><td width="250px">'.$rowquery['event_location'].'</td></tr>';
$start_day = date("j",strtotime($rowquery["event_start_date"]));
$end_day = date("j",strtotime($rowquery["event_end_date"]));
if ($rowquery['event_photo'] != ""){
	//$description .= '<tr><td width="150px"><b>Event Photo</b>:</td><td><img src="http://hauthunger.ch/uploads/photos/'.$rowquery[event_photo].'" border="0" style="margin: 5px 0px;" width="320px"></td></tr>';
}else{
	$description .= "";
}
if ($start_day != $end_day){
	$description .='<tr><td width="150px"><b>When:</b></td><td width="250px">'.date("M j, Y h:i a",strtotime($rowquery["event_start_date"])).'-'.date("M j, Y h:i a",strtotime($rowquery["event_end_date"])).'</td></tr>';
}else{
	$description .='<tr><td width="150px"><b>When:</b></td><td width="250px">'.date("M j, Y h:i a",strtotime($rowquery["event_start_date"])).'-'.date("h:i a",strtotime($rowquery["event_end_date"])).'</td></tr>';
}
$description .= '</table>';

$icaldetails .="BEGIN:VCALENDAR\n";
$icaldetails .="PRODID:-//Microsoft Corporation//Outlook 14.0 MIMEDIR//EN\n";
$icaldetails .="VERSION:2.0\n";
$icaldetails .="METHOD:REQUEST\n";
$icaldetails .="X-MS-OLK-FORCEINSPECTOROPEN:TRUE\n";
$icaldetails .="BEGIN:VEVENT\n";
$icaldetails .="CLASS:PUBLIC\n";
$icaldetails .="CREATED:".date('Ymd')."T".date('His')."Z\n";
$icaldetails .="DESCRIPTION:".$description."\n";
$icaldetails .="TZID:CET\n";
$icaldetails .="TZNAME:CET\n";
$icaldetails .="DTEND;TZID=CET:"  . date('Ymd',strtotime($rowquery['event_end_date']))."T".date('His',strtotime($rowquery['event_end_date']))."\n";
$icaldetails .="DTSTART;TZID=CET:" .  date('Ymd',strtotime($rowquery['event_start_date']))."T".date('His',strtotime($rowquery['event_start_date']))."\n";
$icaldetails .="DTSTAMP;TZID=CET:".date('Ymd',strtotime($rowquery['event_created_date']))."T".date('His',strtotime($rowquery['event_created_date']))."\n";
$icaldetails .="LAST-MODIFIED;TZID=CET:".date('Ymd',strtotime($rowquery['event_updated_date']))."T".date('His',strtotime($rowquery['event_updated_date']))."\n";
$icaldetails .="LOCATION:".$rowquery['event_location']."\n";								
$icaldetails .="SUMMARY;LANGUAGE=De:".$rowquery['event_title']."\n";
$icaldetails .='ORGANIZER;CN="Elsocial Team":mailto:info@hauthunger.ch\n';
$icaldetails .="SEQUENCE:0\n";
$icaldetails .="TRANSP:OPAQUE\n";
$icaldetails .="UID:".date('Ymd')."T".date('His')."uid1@example.com\n";
$icaldetails .='X-ALT-DESC;FMTTYPE=text/html:<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">\n<HTML>\n<HEAD>\n<META NAME="Generator" CONTENT="MS Exchange Server version 14.02.5004.000">\n<TITLE></TITLE>\n</HEAD>\n<BODY>\n'.$description.'\n\n</BODY>\n</HTML>\n';
if($_GET['email'] == ""){
	echo utf8_encode($icaldetails);
}else{
	//Create Mime Boundry
	$mime_boundary = "----Meeting Booking----".md5(time());
	//$icaldetails = utf8_encode($icaldetails);	
	//Create Email Headers
	$headers = "From: hauthunger.ch <info@hauthunger.ch>\n";
	$headers .= "Reply-To: hauthunger.ch <info@hauthunger.ch>\n";
	
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
	$headers .= "Content-class: urn:content-classes:calendarmessage\n";
	
	//Create Email Body (HTML)
	$message .= "--$mime_boundary\n";
	$message .= "Content-Type: text/html; charset=UTF-8\n";
	$message .= "Content-Transfer-Encoding: 8bit\n\n";
	
	$message .= "<html>\n";
	$message .= "<body>\n"; 
	$message .= "test</body>\n";
	$message .= "</html>\n";
	$message .= "--$mime_boundary\n";
	
	$message .= 'Content-Type: text/calendar;name="event.ics";charset=utf-8\n';
	$message .= 'Content-Type: text/calendar;name="event.ics"\n';
	$message .= "Content-Transfer-Encoding: 8bit\n\n";
	$message .= utf8_encode($icaldetails);   
	
	//SEND MAIL
	file_put_contents('uploads/'.$title.'.ics',utf8_encode($icaldetails));

	$message  ="";
	$headers  ="";
	$files = "../uploads/".$title.".ics";
	// email fields: to, from, subject, and so on
    $from = "info@hauthunger.ch"; 
	
    $subject = $rowquery['event_title']; 
    $headers = "From: $from";
 
    // boundary 
    $semi_rand = md5(time()); 
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
 
    // headers for attachment 
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
 
    // multipart boundary 
    $message = "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" .
    "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
 
        if(is_file($files)){
            $message .= "--{$mime_boundary}\n";
            $fp =  @fopen($files,"rb");
			$data =  @fread($fp,filesize($files));
            @fclose($fp);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: application/octet-stream; name=\"".basename($files)."\"\n" . 
            "Content-Description: ".basename($files)."\n" .
            "Content-Disposition: attachment;\n" . " filename=\"".basename($files)."\"; size=".filesize($files).";\n" .
            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }

    $message .= "--{$mime_boundary}--";
    $returnpath = "-finfo@hauthunger.ch";
	$emailaddress = $_GET['email_address'];
    $ok = @mail($emailaddress, $subject, $message, $headers, $returnpath); 
}
?>