<?php
/*$conn = mysql_connect("localhost","root","");
mysql_select_db("stjohn",$conn); */
 $conn = mysql_connect("localhost","stjohnog_newdb","w%[J8ITU+}f0");
mysql_select_db("stjohnog_newdb",$conn); 

include "notoword.php";

$updateqry= "UPDATE mk_invoice SET invoice_amt='".$_REQUEST['invoice_amount']."' WHERE `invoice_id` =".$_REQUEST['invoice_id'];
$pass_insert = mysql_query($updateqry) or die(mysql_error());
$invoiceno=$_REQUEST['invoice_id'];

$gets=mysql_query("select * from mk_users where user_id='".$_REQUEST['user_id']."'") or die(mysql_error()); 
$po=mysql_fetch_array($gets);
$staddress=$po['caddress'];
$companyname=$po['companyname'];
$emailid= $po['useremail'];
 

$invoice_id= $_REQUEST['invoice_id'];

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

 
/*$name1= $_REQUEST['name1'];
$address= $_REQUEST['address'];
$phoneno= $_REQUEST['phoneno'];
$emailid= $_REQUEST['emailid'];
$bdesc= $_REQUEST['bdesc'];*/

 
$variable_from_file = $invoice_id;

$html = '
<head>
<style>
body {margin-top: 0px;margin-left: 0px;font-family: Calibri;}
 
.list {
    border-collapse: collapse;
    border-left: 1px solid #DDDDDD;
    border-top: 1px solid #DDDDDD;
    margin-bottom: 20px;
    width: 100%;
}
.list {
    border-collapse: collapse;
}
.list .left {
    padding: 7px;
    text-align: left;
}
.list thead td a, .list thead td {
    color: #222222;
    font-weight: bold;
    text-decoration: none;
}
.list thead td {
    background-color: #EFEFEF;
    padding: 0 5px;
}
.list td {
    border-bottom: 1px solid #DDDDDD;
    border-right: 1px solid #DDDDDD;
}

.nicebox{  border-bottom: 1px solid #DDDDDD;
    border-right: 1px solid #DDDDDD;
	border-left: 1px solid #DDDDDD;
	border-top: 1px solid #DDDDDD;border-collapse: collapse; 
	
	border-radius: 20px ;
-moz-border-radius: 20px ;
	
	}
</style>
</head>
<body>
<DIV id="page_1">
<table width="100%" border="0" class="nicebox">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="14%" align="left"><img src="http://stjohn.org.in/admin/deptlogo/'.$dept_logo.'" width="150" height="150" /></td>
        <td width="80%" align="center" valign="top">'.nl2br($set_address).'</td>
        <td width="6%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="78%" valign="top">To,<br>M/s,'.$companyname.'<br>'.nl2br($staddress).'</td>
        <td width="22%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td colspan="2" align="center"><strong>BILL</strong></td>
            </tr>
          <tr>
            <td width="20%">No</td>
            <td width="80%">'.$invoice_id.'</td>
          </tr>
          <tr>
            <td>Date</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"> <table id="multinputs" class="list"  width="100%" >
             
              <tr>
               
                <td width="41%" class="left" align="center">Contents</td>
                <td width="7%" align="center" > Qty </td>
                <td width="11%" class="right" align="center"> Amount </td>
                 <td width="40%" class="right" align="center"> Total Amount </td>
              </tr>';
			  $rsql=mysql_query("select * from mk_invoice_desc where invoice_id='".$_REQUEST['invoice_id']."' order by invoice_did asc") or die(mysql_error());

		  $sno=1;

		  $totalamount=0;

		  while($rs=mysql_fetch_array($rsql))

		  {
 			$totalamount=$rs['tamount']+$totalamount;
		  
$html .='<tr> 	 
	<td class="left">'.nl2br($rs['invoice_desc']).'</td>	<td  align="center">'.$rs['qty'].'</td>
	    <td class="right" align="right">'.$rs['amount'].'</td>
         <td class="right" align="right">'.$rs['tamount'].'</td>
	    </tr>';
        }  
		

$html .=' 	 
	<tr>	 
	<td class="left">Total Amount</td>
    <td  >&nbsp;</td>
	    <td class="right"> </td>
         <td class="right" align="right">'.number_format($totalamount,2).'</td>
      </tr>';
	  
	  
  $s_no=1;
		  $ipl=0;
		  $rsqlQ=mysql_query("select * from mk_tax where tax_plan_id='".$_REQUEST['tax_plan_id']."'  order by tax_id asc") or die(mysql_error());
		  while($rsQ=mysql_fetch_array($rsqlQ))

		  {
	   
$html .='<tr>
	  <td class="left"><em>';
	    if($rsQ['tie_with']==0)
		{  
$html .= $rsQ['tax_name'].'of Total amount'; 
} else {   
	   
	  $gtc1=mysql_query("select * from mk_tax where tax_id='".$rsQ['tie_with']."'");
	  $rp1=mysql_fetch_array($gtc1);
$html .= $rsQ['tax_name'].' Of '.$rp1['tax_name'];
	    } 
$html .='</em>
      </td>
	  <td  >&nbsp;</td>
	  <td class="right" align="center">'.$rsQ['tax_rate'].'%</td>
	  <td class="right" align="right">'; 	  
		if($rsQ['tie_with']==0)
		{
			$servicetax=$totalamount*($rsQ['tax_rate']/100);
			$amount1= number_format($servicetax,2);
  				 $html .= $amount1;
		}
		else
		{
			
			$rsqlW=mysql_query("select * from mk_tax where tax_id='".$rsQ['tax_id']."'  order by tax_id asc") or die(mysql_error());
			while($rs1=mysql_fetch_array($rsqlW))
			{										 
			 $tie_with=$rs1['tie_with'];
				
				$rsqlW1=mysql_query("select * from mk_tax where tax_id='".$tie_with."'  order by tax_id asc") or die(mysql_error());
				$rp=mysql_fetch_array($rsqlW1);
				
				$rsqlW2=mysql_query("select * from mk_tax where tax_id='".$rp['tie_with']."'  order by tax_id asc") or die(mysql_error());
				if(mysql_num_rows($rsqlW2))
				{
					while($rp2=mysql_fetch_array($rsqlW2))
					{				
						$rq1=$totalamount*($rp['tax_rate']/100);					 
						  $amount2 = number_format(($rq1*($rs1['tax_rate']/100))*($rp2['tax_rate']/100),2);
						  $html .= $amount2;
						 $Aamount2=$Aamount2+$amount2;
					}
				}
				else
				{
					$rq1=$totalamount*($rp['tax_rate']/100);
					  $amount3 = number_format($rq1*($rs1['tax_rate']/100),2);
					   $html .= $amount3;
					 $Aamount3=$Aamount3+$amount3;
				}
				
			
			}
		   
			   
		}
	$html .= '</td>
	  </tr>';
       $ipl++; } 
	  $invoiceamt=($totalamount+$amount1+$Aamount3+$Aamount2); 
$html .=   '<tr>
		<td class="left">Net Amount:</td>	<td  align="center"> </td>
	    <td class="right" align="right"> </td>
         <td class="right" align="right">'.$invoiceamt.'</td>';
		  
$html .=   ' 
      </tr>
      <tr>
    <td class="left" colspan="4"><strong> Rupees in words:'.ucfirst(convertNumber($totalamount+$amount1+$Aamount3+$Aamount2)).'</strong>
     
   
    </td>
  </tr>';
		
$html .='</table>
			  </td>
  </tr>
  <tr>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">For <strong>HONORARY SECRETARY</strong>,<br><img src="http://stjohn.org.in/admin/branchseal/'.$branch_sseal.'" width="120" height="80" /></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td><font color="#FF0000">Note: This is a Computer generated Bill and hence does not require any Signature.</font></td>
  </tr>
</table>
</DIV>

 

</body>
';

$html1 = utf8_encode($html);
  
include("../mpdf.php");

$mpdf=new mPDF(); 

$mpdf->WriteHTML($html1);
$content = $mpdf->Output('', 'S');

$content = chunk_split(base64_encode($content));
//$mailto = $emailid;
$mailto = $emailid;
$from_name = 'St.John Ambulance';
$from_mail = 'no-reply@stjohn.org.in';
$replyto = 'no-reply@stjohn.org.in';
$uid = md5(uniqid(time())); 
$subject = 'Invoice No: '.$variable_from_file.', created on '.date('d-m-Y');
$message = $sendmessage;
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

 
$mpdf->Output();
exit;

?>