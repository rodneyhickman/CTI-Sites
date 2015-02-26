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
$id = @$_GET['id'];
$el = 'webinar-link';

if($mode == 'lead'){
   // $result = mysql_query("select event,fmid,booking_link,call_time,start_date from event_calendar where course_type_id=120 and TRIM(booking_link) <>'' and `event` like '%leadership%' order by start_date asc");
    $result = mysql_query("select event,fmid,booking_link,call_time,start_date from event_calendar where course_type_id=120 and TRIM(booking_link) <>'' and `event` like '%leadership%' order by fmid asc");
    $el = 'webinar-link-lead';
}
else if($mode == 'cert'){
    $result = mysql_query("select booking_link,call_time,start_date from event_calendar where course_type_id=120 and `event` like 'cert%' order by fmid asc");
    $el = 'webinar-link-cert';
}
else { // mode==fund
    $result = mysql_query("select booking_link,call_time,start_date from event_calendar where course_type_id=120 and `event` like 'fun%' order by fmid asc");
}


//$onehour_timestamp = strtotime('+1 hour');
$onehour_timestamp = time();
 
while($row = mysql_fetch_array($result)){
  //print_r($row);

  preg_match('/(\d\d?:\d\d\s+[AP]M)/i',$row['call_time'],$matches);
  if(count($matches) >= 1){
    $call_time = $matches[1];
  }
  $start_date = Date('F d, Y',strtotime( preg_replace('/\s.*/','',$row['start_date']) ) );
  $start_timestamp = strtotime("$start_date $call_time America/Los_Angeles");

  //echo "$start_date $call_time America/Los_Angeles $start_timestamp\n";
  //echo Date('F d, Y H:i:s',$start_timestamp)."\n";
//echo date('d/m/Y',$start_timestamp);
 
 // echo date('d/m/Y',$onehour_timestamp);
   
  if($start_timestamp > $onehour_timestamp){ // use this booking link, as long as start timestamp is greater than one hour from now
 // echo date('d/m/Y',$start_timestamp)."<br>";
 // echo date('d/m/Y',$onehour_timestamp)."<br>";
    $link = $row['booking_link'];
	$event=$row['event'];
	$fmid=$row['fmid'];
	break;
  }
}


if($link == ''){
    $link = "https://www1.gotomeeting.com/register/208314176";
}

if($id != ''){
    $el = $id;
}

?>
<?php echo $link ."--".$event.'--'.$fmid; 


 
?>