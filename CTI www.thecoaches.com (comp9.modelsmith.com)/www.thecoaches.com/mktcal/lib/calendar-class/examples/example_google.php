<?php include('calendar.class.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>PHP Calendar Class w/Google</title>

<style type="text/css" media="all">
body {
	background-color: #2A2A2A;
	color: #EEEEEE;
	font-family: "Lucida Grande","Lucida Sans Unicode",sans-serif;
	font-size: 12px;
	padding:20px;
	margin:0;
}
</style>
</head>
<body>
<?php
$cal = new CALENDAR();
$cal->weeknumbers = 'left';
$cal->addGoogleCalendar(
	array(
	'xmlfeed'=>'http://www.google.com/calendar/feeds/ckvf91cpb85v3crjn0mpnn53u4%40group.calendar.google.com/public/basic',
	'color'=>'#D6FFD6'
	)
);
$cal->addEvent(
	array(
		"title"=>"Normal Event w/all values",
		"from"=>date('Y')."-".date('n')."-24",
		"to"=>date('Y')."-".date('n')."-28",
		"starttime"=>"5:30am",
		"endtime"=>"7:30pm",
		"color"=>"#FFF6D6",
		"location"=>"Wisconsin Rapids, WI",
		"details"=>"Can be mixed with regular events.",
		"link"=>"http://www.klovera.com"
	)
);
echo $cal->showcal();
?>
</body>
</html>