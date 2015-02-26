<?php

$username = "cticoaches";
$password = "";
$hostname = "localhost"; 

//connection to the database
$dbh = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

//select a database to work with 
$selected = mysql_select_db("CTIDATABASE",$dbh) 
  or die("Could not select examples");


$result = mysql_query("select booking_link,call_time,start_date from event_calendar where course_type_id=120 and `event` like 'leadership info%' order by fmid asc limit 2");

$onehour_timestamp = strtotime('+1 hour');
$booking_link = '';
while($row = mysql_fetch_array($result)){
  print_r($row);
  preg_match('/(\d\d?:\d\d\s+[AP]M)/i',$row['call_time'],$matches);
  if(count($matches) >= 1){
    $call_time = $matches[1];
  }
  $start_date = Date('F d, Y',strtotime( preg_replace('/\s.*/','',$row['start_date']) ) );
  $start_timestamp = strtotime("$start_date $call_time America/Los_Angeles");
  echo "$start_date $call_time America/Los_Angeles $start_timestamp\n";

  echo Date('F d, Y H:i:s',$start_timestamp)."\n";

  if($start_timestamp > $onehour_timestamp){
    $booking_link = $row['booking_link'];
  }
}

echo "booking_link: $booking_link\n";
