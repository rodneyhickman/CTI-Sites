<?php
/*$conn = mysql_connect("localhost","root","");
mysql_select_db("stjohn",$conn); */
$conn = mysql_connect("localhost","stjohnog_newdb","w%[J8ITU+}f0");
mysql_select_db("stjohnog_newdb",$conn);
include "notoword.php";

$updateqry= "UPDATE mk_invoice SET invoice_amt='".$_REQUEST['invoice_amount']."' WHERE `invoice_id` =".$_REQUEST['invoice_id'];
$pass_insert = mysql_query($updateqry) or die(mysql_error());
$invoiceno=$_REQUEST['invoice_id'];

$sd=mysql_query("select * from mk_invoice  WHERE `invoice_id` =".$_REQUEST['invoice_id']) or die(mysql_error());
$rs1=mysql_fetch_array($sd) or die();
$invoice_date=date('d-m-Y',$rs1['invoice_date']);

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
				
				$branch_nname =$rst2['branch_nname'];
				$branch_info =$rst2['branch_info'];
				$branch_tel =$rst2['branch_tel'];
				$branch_mobile =$rst2['branch_mobile'];
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
@font-face {
    font-family: "olde_englishregular";
    src: url("fontcap/oldeenglish-webfont.eot");
    src: url("fontcap/oldeenglish-webfont.eot?#iefix") format("embedded-opentype"),
         url("fontcap/oldeenglish-webfont.woff") format("woff"),
         url("fontcap/oldeenglish-webfont.ttf") format("truetype");
    font-weight: normal;
    font-style: normal;

}
body {margin-top: 0px;margin-left: 0px; font-family: "olde_englishregular";}
 
.list {
    border-collapse: collapse;
    border-left: 0px solid #DDDDDD;
    border-top: 0px solid #DDDDDD;
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
    border-right: 0px solid #DDDDDD;
}

.nicebox{  border-bottom: 1px solid #DDDDDD;
    border-right: 1px solid #DDDDDD;
	border-left: 1px solid #DDDDDD;
	border-top: 1px solid #DDDDDD;border-collapse: collapse; 
	
	border-radius: 20px ;
-moz-border-radius: 20px ;
	
	}
.clsmain{

border-radius: 20px ;

border: 2px solid;
border-color:#989BA5;
	}	
	
	
.Clsheadtxt{font-family: "olde_englishregular";font-weight: bold; }
.Clsbt_br{ border-bottom:1px solid #989BA5;
}
.cls_bill{border-left:1px solid #989BA5; float:left;}
</style>
</head>
<body>
<DIV id="page_1">

<div class="clsmain">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="14%" align="left"><img src="http://stjohn.org.in/admin/deptlogo/'.$dept_logo.'" /></td>
        <td width="62%" align="center" valign="top">
          <table width="95%" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td class="Clsheadtxt" align="center">'.nl2br($branch_nname).'</td>
            </tr>
            <tr>
              <td align="center">'.nl2br($branch_info).'</td>
            </tr>
            <tr>
              <td align="center">'.nl2br($set_address).'</td>
            </tr>
        </table></td>
        <td width="24%" valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="17%" valign="top">Tel :</td>
            <td width="83%" valign="top">'.nl2br($branch_tel).'</td>
          </tr>
          <tr>
            <td valign="top">Cell :</td>
            <td valign="top">'.nl2br($branch_mobile).'</td>
          </tr>
        </table></td>
      </tr>
    </table>
	<div class="Clsbt_br"></div>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="78%" valign="top">To,<br>M/s,'.$companyname.'<br>'.nl2br($staddress).'</td>
        <td width="22%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td colspan="2" align="center" bgcolor="#3C5ADB" style="color:#fff;"><strong>BILL</strong></td>
            </tr>
          <tr>
            <td width="20%">No</td>
            <td width="80%">'.$invoice_id.'</td>
          </tr>
          <tr>
            <td>Date </td>
            <td>'.$invoice_date.'</td>
          </tr>
        </table></td>
      </tr>
    </table>
	<div class="Clsbt_br"></div>
	
	<table width="100%" border="0" class="nicebox">
  
  
  <tr>
    <td valign="top"> <table id="multinputs" class="list"  width="100%" >
             
              <tr>
                <td width="5%" align="center" > Sno </td>
                <td width="41%" class="left" align="center">Contents</td>
                <td width="7%" align="center" > Qty </td>
                <td width="11%" class="right" align="center"> Amount </td>
                 <td width="40%" class="right" align="right"> Total Amount </td>
              </tr>';
			  $rsql=mysql_query("select * from mk_invoice_desc where invoice_id='".$_REQUEST['invoice_id']."' order by invoice_did asc") or die(mysql_error());

		  $sno=1;

		  $totalamount=0;
$s_no=1;
		  while($rs=mysql_fetch_array($rsql))

		  {
 			$totalamount=$rs['tamount']+$totalamount;
		  
$html .='<tr> 	 <td class="left">'.$s_no.'</td>
	<td class="left">'.nl2br($rs['invoice_desc']).'</td>	<td  align="center">'.$rs['qty'].'</td>
	    <td class="right" align="right">'.$rs['amount'].'</td>
         <td class="right" align="right">'.$rs['tamount'].'</td>
	    </tr>';
		$s_no++;
        }  
		

$html .=' 	 
	<tr>	 <td  >&nbsp;</td>
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
	   
$html .='<tr> <td  >&nbsp;</td>
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
			$amount2= number_format($servicetax,2);
			$amount1= $servicetax;
  				 $html .= $amount2;
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
$html .=   '<tr><td  >&nbsp;</td>
		<td class="left">Net Amount:</td>	<td  align="center"> </td>
	    <td class="right" align="right"> </td>
         <td class="right" align="right">'.number_format($invoiceamt,2).'</td>';
		  
$html .=   ' 
      </tr>
      <tr>
    <td class="left" colspan="5"><strong> Rupees in words:'.ucfirst(convertNumber($totalamount+$amount1+$Aamount3+$Aamount2)).'</strong>   
    </td>
  </tr>';
		
$html .='</table>
			  </td>
  </tr>
</table>

 <table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="55%" valign="top"  align="left" style="border:none;">N.B. : Payment should be made by crossed cheque or DD drawn in favour of St.John Ambulance, Chennai - 600 050.</td>
    <td width="45%" align="right">For <strong>HONORARY SECRETARY</strong>,<br><img src="http://stjohn.org.in/admin/branchseal/'.$branch_sseal.'" width="120" height="80" /></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><font color="#FF0000">Note: This is a Computer generated Bill and hence does not require any Signature.</font></td>
  </tr>
</table>

	
</div>

 
</DIV>

 

</body>
';

$html1 = utf8_encode($html);
  
include("../mpdf.php");

$mpdf=new mPDF(); 

$mpdf->WriteHTML($html1);
$content = $mpdf->Output('', 'S');

$content = chunk_split(base64_encode($content));
$mailto = $emailid;
//$mailto = "parimayamax@gmail.com";
$from_name = 'St.John';
$from_mail = 'no-reply@stjohn.org.in';
$replyto = 'no-reply@stjohn.org.in';
$uid = md5(uniqid(time())); 
$subject = 'St. John Invoice No: '.$variable_from_file.', created on '.date('d-m-Y');
$message = $sendmessage;
$filename = 'St. John Invoice '.$variable_from_file.'.pdf';

$message="Dear Sir/Mam,\r\n\r\n Please find the Attchment of Your Invoice PDF, The Amount is INR.".number_format($invoiceamt,2)." (".ucfirst(convertNumber($totalamount+$amount1+$Aamount3+$Aamount2)).") \r\n\r\n";
$message .="N.B. : Payment should be made by crossed cheque or DD drawn in favour of St.John Ambulance, Chennai - 600 050.\r\n\r\n";
$message .="Note: This is a Computer generated Bill and hence does not require any Signature.\r\n\r\n";
$message .="--\r\nThanks & Regards,\r\nSt.John.";

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
//$is_sent = @mail($mailto, $subject, "", $header);
$is_sent = @mail($mailto, $subject, $message, $header);

 
$mpdf->Output();
exit;

?>