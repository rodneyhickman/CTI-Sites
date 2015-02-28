<?php
$conn = mysql_connect("localhost","stjohnog_newdb","w%[J8ITU+}f0");
mysql_select_db("stjohnog_newdb",$conn);
/*$conn = mysql_connect("localhost","stjohnog_newdb","w%[J8ITU+}f0");
mysql_select_db("stjohnog_newdb",$conn);*/
include "notoword.php";
$tr_id = $_REQUEST['tr_id'];
$dept_id = $_REQUEST['dept_id'];
$branch_id = $_REQUEST['branch_id'];

$set_id= 1;
 $sqlr=mysql_query("select * from mk_training where tr_id='".$tr_id."'");
	while($cnt12=mysql_fetch_array($sqlr))
	{		
				$tr_name=$cnt12['tr_name'];
				$noofcan =$cnt12['noofcan'];
				$mdescription =$cnt12['mdescription'];
				$mtext=nl2br($cnt12['mtext']);
			 
}

$sqlr_ads=mysql_query("select * from mk_ads where ads_status='1'");
	while($cnt12_ads=mysql_fetch_array($sqlr_ads))
	{		
				$ads_name=$cnt12_ads['ads_name'];
				 
			 
}


$sqlr1=mysql_query("select * from mk_dept where dept_id='".$dept_id."'");
while($rst=mysql_fetch_array($sqlr1))
{		
				$dept_name=$rst['dept_name'];
				$dept_logo =$rst['dept_logo'];			 
			 
}
$sqlr2=mysql_query("select * from mk_branch where branch_id='".$branch_id."'");
while($rst2=mysql_fetch_array($sqlr2))
{		
				$set_address=$rst2['branch_address'];
				$branch_name =$rst2['branch_name'];
				$branch_sseal =$rst2['branch_sseal'];
				$branch_seal =$rst2['branch_seal'];
}

 
$name1= $_REQUEST['name1'];
$address= $_REQUEST['address'];
$phoneno= $_REQUEST['phoneno'];
$emailid= $_REQUEST['emailid'];
$bdesc= $_REQUEST['bdesc'];

$count = intval(file_get_contents('../count.txt'));
file_put_contents('../count.txt', ++$count);
$variable_from_file = (int)file_get_contents('../count.txt');

$html = '
<head>
<style>
body {margin-top: 0px;margin-left: 0px;font-family: Calibri;}


</style>
</head>
<body>
<DIV id="page_1">
<table width="100%" border="0" cellpadding="0" cellspacing="3">
   <tr>
    <td width="49%" valign="top"><img src="http://stjohn.org.in/admin/deptlogo/'.$dept_logo.'" width="150" height="150" /></td>
    <td width="51%" valign="top">'.nl2br($set_address).'</td>
    
    
  </tr>
  
  <tr>
    <td colspan="2">Training Name - '.$tr_name.'</td>
  </tr>
   <tr>
    <td colspan="2"><strong>Quote No - '.$variable_from_file.'</strong></td>
  </tr>
  
  <tr>
    <td colspan="2"><strong>Dear '.$name1.',</strong></td>
  </tr>
  <tr>
    <td colspan="2">'.nl2br($address).',</td>
  </tr>
  <tr>
    <td colspan="2">Phone No:'.$phoneno.',</td>
  </tr>
  <tr>
    <td colspan="2">Quotation For '.$tr_name.', the details are listed below</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0">
      <tr>
        <td align="left" valign="top">'.$mtext.'</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="1">
      <tr>
        <td colspan="2" align="center"  bgcolor="#727F87"><strong color="#FFF">Course Fees Details</strong></td>
        </tr>';
		
			$rsql=mysql_query("select * from mk_train_desc where tr_id=$tr_id and is_head_cost='1' order by tr_desc_id asc") or die();
		  $sno=1;
		  $totalamount1=0;
		  while($rs=mysql_fetch_array($rsql))
		  {
		$totalamount1=$rs['tr_cost']*$noofcan;
		$html .='<tr>
			<td width="52%">'.$rs['tr_description'].'  - Rs.'.$rs['tr_cost'].' / Head * '.$noofcan.'</td>
			<td width="48%" align="right">Rs '.number_format(($rs['tr_cost']*$noofcan),2).'</td>
		  </tr>';
	  
		  } 
		 
		 $rsql=mysql_query("select * from mk_train_desc where tr_id=$tr_id and is_head_cost='0'  order by tr_desc_id asc") or die();
		  $sno=1;
		  $totalamount=0;
		  while($rs=mysql_fetch_array($rsql))
		  {
		
		$html .='<tr>
			<td width="52%">'.$rs['tr_description'].'</td>
			<td width="48%" align="right">Rs '.number_format($rs['tr_cost'],2).'</td>
		  </tr>';
	  
	    $totalamount=$rs['tr_cost']+$totalamount;
		  $sno++;
		  } 
		 $ttol= $totalamount+$totalamount1;
	  $html .='<tr>
			<td width="52%">Total Cost</td>
			<td width="48%" align="right">Rs '.number_format($ttol,2).'</td>
		  </tr>';
		$html .=' <tr>
        <td colspan="2" >Amount in words:'.ucfirst(convertNumber($ttol)).' only.</td>
      </tr>';  
		  
    $html .='</table></td>
  </tr>
 <tr>
        <td colspan="3" align="center" bgcolor="#FFFF00">Terms and Conditions</td>
      </tr>
      <tr>
        <td colspan="3" >'.nl2br($mdescription).'</td>
      </tr>
	  
	   <tr>
        <td colspan="3" ><font color="#FF0000">Note: This is a Computer generated Bill and hence does not require any Signature.</font></td>
      </tr>
	 
    </table></td>
	
  </tr>
  
  <tr>
    <td><img src="http://stjohn.org.in/admin/adimages/'.$ads_name.'" /></td>
</tr>
</table>
</DIV>

 

</body>
';

$html1 = utf8_encode($html);
//==============================================================
//==============================================================
//==============================================================
include("../mpdf.php");

$mpdf=new mPDF(); 

$mpdf->WriteHTML($html1);
$content = $mpdf->Output('', 'S');

$content = chunk_split(base64_encode($content));
$mailto = $emailid;
$from_name = 'St.John Ambulance';
$from_mail = 'no-reply@stjohn.org.in';
$replyto = 'no-reply@stjohn.org.in';
$uid = md5(uniqid(time())); 
$subject = 'New Quote No: '.$variable_from_file.', created on '.date('d-m-Y');
$message = $bdesc;
$filename = 'yourquote.pdf';

$header = "From: ".$from_name." <".$from_mail.">\r\n";
$header .= "Reply-To: ".$replyto."\r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
$header .= "This is a multi-part message in MIME format.\r\n";
$header .= "--".$uid."\r\n";
$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$header .= $message."\r\n\r\n";
$header .= "--".$uid."\r\n";
$header .= "Content-Type: application/pdf; name=\"".$filename."\"\r\n";
$header .= "Content-Transfer-Encoding: base64\r\n";
$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
$header .= $content."\r\n\r\n";
$header .= "--".$uid."--";
$is_sent = @mail($mailto, $subject, "", $header);

// You can now optionally also send it to the browser
$mpdf->Output();
exit;

?>