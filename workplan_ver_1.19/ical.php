<?php

// If you point to this page from another page, you can add variables to the link: eg:

// calendar.php?startdate=201307015&apptTime=100000&location=My Office

// Start date format needs to be YYYYMMDD

$startdate=$_GET['startdate'];

// Appointment time format needs to be HHMMSS

$enddate=$_GET['enddate'];

$projectname=$_GET['projectname'];

$details=$_GET['details'];
$description=$_GET['description'];

$ical = "BEGIN:VCALENDAR\n".
"VERSION:2.0\n".
"PRODID:-//hacksw/handcal//NONSGML v1.0//EN\n".
"X-WR-CALNAME:". $projectname."\n".
"X-WR-TIMEZONE:GMT\n".
"BEGIN:VEVENT\n".
"DTSTART;VALUE=DATE:".$startdate. "\n".
"DTEND;VALUE=DATE:".$enddate."\n".
"UID:" . md5(uniqid(mt_rand(), true)) . "@yourhost.test\n".
"SUMMARY:".$details."\n".
"DESCRIPTION:".$description."\n".
"END:VEVENT\n".
"END:VCALENDAR";
//set correct content-type-header
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename="Project Calendar.ics"');
echo $ical;
exit;

?>