<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
 $server = 'localhost';
 $login='cticoaches';
 $pass='';
 $db='CTIDATABASE';
 
 $spojeni=mysql_connect($server,$login,$pass) or die (mysql_error());
 mysql_select_db($db,$spojeni) or die(mysql_error());
 
if ($conn = mysql_connect($server,$login,$pass)) {
  echo  'MySql successfully connected!<br>';
} else {
  // failure
  echo  'MySql connection failed<br>';
}
 //exit;
//echo "<h1>Welcome</h1>";
if($_REQUEST['fmid']){
	$fmid=$_REQUEST['fmid'];
	 
	 $date     = explode('/',$_REQUEST['date']); 
	 $date = mktime(0, 0, 0, $date[0] , $date[1], $date[2]);
	 $day_of_week=date('l',$date);
	 $start_date_month=date('m',$date);
	 $start_date=date("Y-m-d H:i:s",$date);
	 
	 $end_date     = explode('/',$_REQUEST['edate']);
	 $edate = mktime(0, 0, 0, $end_date[0] , $end_date[1], $end_date[2]);
	 $end_date_month=date('m',$edate);
	 $end_date = mktime(0, 0, 0, $end_date[0] , $end_date[1], $end_date[2]);
	 
	 $end_date = date("Y-m-d H:i:s",$end_date);
	 
	 if ($start_date_month == $end_date_month) {
		$start_date_formatted = date('M j',$date).'-'.date('j, Y',$edate);
		 
	  }
	  else {  
		$start_date_formatted = date('M j',$date).'-'.date('M j, Y',$edate);
	  }
	$end_date_formatted = date('F j, Y',$edate);
	 
	 
	
	$event =$_REQUEST['event'];
	$region =$_REQUEST['region'];
	$location =$_REQUEST['location'];
	$call_time=$_REQUEST['call_time']; 
	$course_type_id =$_REQUEST['course_type_id'];
	//$series_id =$_REQUEST['series_id'];
	$assistant_count=$_REQUEST['assistant_count']; 
	//$assistant_wait_count =$_REQUEST['assistant_wait_count'];
	$booking_link =$_REQUEST['booking_link'];
	$pod_name =$_REQUEST['pod_name'];
	$leader_name=$_REQUEST['leader_name'];
	
	$g_sql=mysql_query("select * from event_calendar where fmid='".$fmid."'") or die(mysql_error());
	 $num_rows = mysql_num_rows($g_sql);
	
	if($num_rows>0)
	{
	echo $up_red="update event_calendar set  date='".date('m/d/Y',$date)."',event='".$_REQUEST['event']."',region='0',
	location='".$_REQUEST['location']."',call_time='".$_REQUEST['call_time']."',course_type_id='".$_REQUEST['course_type_id']."',series_id='0',
	assistant_count='".$_REQUEST['assistant_count']."',assistant_wait_count='0', booking_link='".$_REQUEST['booking_link']."',pod_name='".$_REQUEST['pod_name']."',leader_name='".$_REQUEST['leader_name']."',
	start_date_formatted='".$start_date_formatted."',end_date_formatted='".$end_date_formatted."',edate='".date('m/d/Y',$edate)."',start_date='".$start_date."',
	end_date='".$end_date."',day_of_week= '".$day_of_week."'   where fmid='".$fmid."'";
	mysql_query($up_red) or die(mysql_error());
	}
	else
	{
		echo $ins_red="insert into event_calendar(fmid,date,event,region,location,call_time,course_type_id,series_id,assistant_count,assistant_wait_count, booking_link,pod_name,leader_name,start_date_formatted,end_date_formatted,edate,start_date,end_date,day_of_week) VALUES ('".$_REQUEST['fmid']."','".date('m/d/Y',$date)."',																																																														'".$_REQUEST['event']."',																																																														'0','".$_REQUEST['location']."','".$_REQUEST['call_time']."','".$_REQUEST['course_type_id']."','0',
	'".$_REQUEST['assistant_count']."','0','".$_REQUEST['booking_link']."','".$_REQUEST['pod_name']."','".$_REQUEST['leader_name']."','".$start_date_formatted."','".$end_date_formatted."','".date('m/d/Y',$edate)."','".$start_date."','".$end_date."','".$day_of_week."')";
		mysql_query($ins_red) or die(mysql_error());
	}
	
	//print_r($_REQUEST);
	//echo $_REQUEST['booking_link'];
	//echo $_REQUEST['fmid'];
	//phpinfo();
}
else
{
	echo "Oops!... Filemaker Id is not there!";
}
?>
</body>
</html>