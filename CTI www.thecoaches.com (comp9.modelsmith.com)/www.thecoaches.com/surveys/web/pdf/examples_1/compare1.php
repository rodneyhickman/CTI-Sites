<?php
$conn = mysql_connect("localhost","root","");
mysql_select_db("sidata",$conn);
 
$array = $_REQUEST['dest'];
 
 
/*print_r($array);
for($i=0;$i<count($array);$i++)
{
	$sqlr=mysql_query("select * from registersave where sno='".$array[$i]."'");
	while($rs=mysql_fetch_array($sqlr))
	{
		
	}
}*/
 
//$sqlr=mysql_query("select * from registersave where ")

$html = '
<head>
<style>
table {
	border-collapse: separate;
	border: 2px solid #629DFF;
	padding: 3px;
	
	empty-cells: hide;
	background-color:#FFF;
}
table.outer2 {
	border-collapse: separate;
	border: 4px solid #088000;
	padding: 3px;
	
	empty-cells: hide;
	background-color: yellow;
}
table.outer2 td {
	font-family: Times;
}
table.inner {
	border-collapse: collapse;
	border: 2px solid #000088;
	padding: 3px;
	margin: 5px;
	empty-cells: show;
	background-color:#FFCCFF;
}
td {
	border: 1px solid #008800;
	padding: 0px;
	background-color:#ECFFDF;
}
table.inner td {
	border: 1px solid #000088;
	padding: 0px;
	font-family: monospace;
	font-style: italic;
	font-weight: bold;
	color: #880000;
	background-color:#FFECDF;
}
table.collapsed {
	border-collapse: collapse;
}
table.collapsed td {
	background-color:#EDFCFF;
}


</style>
</head>
<body>
<h1>SHIVAA INFOTECH</h1>
<h2>FOR DETAILS CALL RAM @ 9444018288 / 9940444586</h2>

<table cellSpacing="1" width="100%">
<tbody>';
$html .='<tr>';
$html .='<td>Brand</td>';
for($i=0;$i<count($array);$i++)
{
	$sqlr=mysql_query("select * from registersave where sno='".$array[$i]."'");
	while($rs=mysql_fetch_array($sqlr))
	{ 
		$html .='<td>'.$rs['brand'].'</td>'; 
	}
}
$html .='</tr>';

$html .='<tr>';
$html .='<td>RAM</td>';
for($i=0;$i<count($array);$i++)
{
	$sqlr=mysql_query("select * from registersave where sno='".$array[$i]."'");
	while($rs=mysql_fetch_array($sqlr))
	{ 
		$html .='<td>'.$rs['ram'].'</td>'; 
	}
}
$html .='</tr>';
$html .='<tr>';
$html .='<td>Model</td>';
for($i=0;$i<count($array);$i++)
{
	$sqlr=mysql_query("select * from registersave where sno='".$array[$i]."'");
	while($rs=mysql_fetch_array($sqlr))
	{ 
		$html .='<td>'.$rs['model'].'</td>'; 
	}
}
$html .='</tr>';
$html .='<tr>';
$html .='<td>CPU Model</td>';
for($i=0;$i<count($array);$i++)
{
	$sqlr=mysql_query("select * from registersave where sno='".$array[$i]."'");
	while($rs=mysql_fetch_array($sqlr))
	{ 
		$html .='<td>'.$rs['cpu_model'].'</td>'; 
	}
}
$html .='</tr>';

 
$html .='<tr>';
$html .='<td>Hard Disk</td>';
for($i=0;$i<count($array);$i++)
{
	$sqlr=mysql_query("select * from registersave where sno='".$array[$i]."'");
	while($rs=mysql_fetch_array($sqlr))
	{ 
		$html .='<td>'.$rs['hdd'].'</td>'; 
	}
}
$html .='</tr>';

$html .='<tr>';
$html .='<td>Screen Size </td>';
for($i=0;$i<count($array);$i++)
{
	$sqlr=mysql_query("select * from registersave where sno='".$array[$i]."'");
	while($rs=mysql_fetch_array($sqlr))
	{ 
		$html .='<td>'.$rs['screen'].'</td>'; 
	}
}
$html .='</tr>';

$html .='<tr>';
$html .='<td>Processer </td>';
for($i=0;$i<count($array);$i++)
{
	$sqlr=mysql_query("select * from registersave where sno='".$array[$i]."'");
	while($rs=mysql_fetch_array($sqlr))
	{ 
		$html .='<td>'.$rs['cpu_type'].'</td>'; 
	}
}
$html .='</tr>';


$html .='<tr>';
$html .='<td>SKU </td>';
for($i=0;$i<count($array);$i++)
{
	$sqlr=mysql_query("select * from registersave where sno='".$array[$i]."'");
	while($rs=mysql_fetch_array($sqlr))
	{ 
		$html .='<td>'.$rs['skuno'].'</td>'; 
	}
}
$html .='</tr>';

$html .='<tr>';
$html .='<td>Price </td>';
for($i=0;$i<count($array);$i++)
{
	$sqlr=mysql_query("select * from registersave where sno='".$array[$i]."'");
	while($rs=mysql_fetch_array($sqlr))
	{ 
		$html .='<td>'.number_format($rs['offer']).'</td>'; 
	}
}
$html .='</tr>';



 
 
$html .='</tbody></table>

 

</body>
';

//==============================================================
//==============================================================
//==============================================================
include("../mpdf.php");

$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html);

$mpdf->Output();
exit;


?>