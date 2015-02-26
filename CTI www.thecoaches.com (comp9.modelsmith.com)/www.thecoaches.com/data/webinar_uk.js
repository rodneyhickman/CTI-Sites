<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: text/javascript');

$username = "cticoaches";
$password = "";
$hostname = "localhost"; 

//connection to the database
$dbh = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

//select a database to work with 
$selected = mysql_select_db("CTIDATABASE",$dbh) 
  or die("Could not select examples");

$mode = @$_GET['mode'];
$el = 'webinar-link';

$result = mysql_query("select * from event_calendar where course_type_id=9 and `event` like '%insp%' order by fmid desc limit 1");

$row = mysql_fetch_array($result,MYSQL_ASSOC);



$call = $row['end_date_formatted'].' '.$row['call_time'];
$html = '<option value="'.$call.'">'.$call.'</option>';
?>
document.write('<?php echo $html?>');
