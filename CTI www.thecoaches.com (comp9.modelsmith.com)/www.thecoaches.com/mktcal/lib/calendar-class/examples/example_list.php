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
$cal = new CALENDAR('list');
$cal->weeknumbers = 'right';
$cal->basecolor = 'aaaaaa';
$cal->addEvent(
	array(
		"title"=>"Single-Day Event",
		"from"=>date('Y')."-".date('n')."-7",
		"to"=>date('Y')."-".date('n')."-7",
		"color"=>"#D6FFD6"
	)
);
$cal->addEvent(
	array(
		"title"=>"Another Single-Day Event",
		"from"=>date('Y')."-".date('n')."-27",
		"to"=>date('Y')."-".date('n')."-27",
		"color"=>"#D6FFD6"
	)
);
$cal->addEvent(
	array(
		"title"=>"Multi-Day Event",
		"from"=>date('Y')."-".date('n')."-6",
		"to"=>date('Y')."-".date('n')."-10",
		"color"=>"#FFF6D6"
	)
);
$cal->addEvent(
	array(
		"title"=>"Event w/time",
		"from"=>date('Y')."-".date('n')."-6",
		"to"=>date('Y')."-".date('n')."-8",
		"color"=>"#FFD6D6",
		"starttime"=>"6:30pm",
		"details"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eleifend quam eu orci auctor non porta odio placerat. Donec vel velit ipsum. Etiam a nibh.",
	)
);
$cal->addEvent(
	array(
		"title"=>"Event w/all values",
		"from"=>date('Y')."-".date('n')."-24",
		"to"=>date('Y')."-".date('n')."-28",
		"starttime"=>"5:30am",
		"endtime"=>"7:30pm",
		"color"=>"#D8E5F9",
		"location"=>"Wisconsin Rapids, WI",
		"details"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sagittis viverra imperdiet. Sed euismod molestie. ",
		"link"=>"http://www.klovera.com"
	)
);
echo $cal->showcal();
?>

</body>
</html>