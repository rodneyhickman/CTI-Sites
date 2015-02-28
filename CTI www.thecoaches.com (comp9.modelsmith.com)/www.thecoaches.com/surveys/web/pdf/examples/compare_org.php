<?php
$conn = mysql_connect("localhost","root","");
mysql_select_db("stjohn",$conn);
include "notoword.php";
$tr_id = $_REQUEST['tr_id'];
 
 $sqlr=mysql_query("select * from mk_training where tr_id='".$tr_id."'");
	while($cnt12=mysql_fetch_array($sqlr))
	{		
				$tr_name=$cnt12['tr_name'];
				$noofcan =$cnt12['noofcan'];
				$mdescription =$cnt12['mdescription'];
			 
}



$html = '
<head>
<style>
body {margin-top: 0px;margin-left: 0px;font-family: Calibri;}


</style>
</head>
<body>
<DIV id="page_1">
<table border="0">
  <tr>
    <td align="center"><span class="ArialTxtBlack"><img src="http://greencrmlive.com/invoice/images/sgt.png" width="800" height="100" /></span></td>
  </tr>
  <tr>
    <td><table width="70%"  border="0" align="center" cellpadding="3" cellspacing="0" class="read"  >
      
      <tr>
        <td colspan="2" align="left" valign="top" ><div style="border:1px solid #000;"></div></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="top"  ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="read">
          <tr>
            <td width="75%" valign="top">To:<br />'.nl2br($toaddress).'</td>
            <td width="25%" valign="top">BILL No:'.$_REQUEST['invoice_id'].'<br />
              Date:'.date('d-m-Y',$invoice_date).'</td>
          </tr>
          </table></td>
        </tr>
      <tr valign="top">
        <td colspan="2" align="left"  ><div style="border:1px solid #000;"></div></td>
        </tr>
      <tr valign="top">
        <td colspan="2" align="left"  ><table width="100%" border="0" cellpadding="3" cellspacing="0" class="read">
          <tr>
            <td width="75%">Movement :'.nl2br($movement).'</td>
            <td width="25%">Vessel Name :'.nl2br($vessel_name).'</td>
            </tr>
          <tr>
            <td>From :'.nl2br($from_add).'</td>
            <td>Agent name :'.nl2br($agent_name).'</td>
            </tr>
          <tr>
            <td>To :'.nl2br($from_to).'</td>
            <td>Containers :'.nl2br($containers).'</td>
            </tr>
          <tr>
            <td>Bringing back :'.nl2br($bringingback).'</td>
            <td align="right">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
       
      <tr valign="top">
        <td colspan="2" align="left"  ><div style="border:1px solid #000;"></div></td>
        </tr>
      <tr valign="top">
        <td colspan="2" align="left"  ><table width="100%" border="0" cellpadding="3" cellspacing="0" class="read">
          <tr>
            <td width="4%" valign="top" bgcolor="#383F6B">Sno</td>
            <td width="24%" valign="top" bgcolor="#383F6B">PARTICULARS</td>
            <td width="24%" valign="top" bgcolor="#383F6B">No.of Cotainers</td>
            <td width="19%" valign="top" bgcolor="#383F6B">RATE</td>
            <td width="29%" valign="top" bgcolor="#383F6B">AMOUNT<br />
              Rs. P.</td>
            </tr>';
            
            $rsql=mysql_query("select * from mk_invoice_part where invoice_id=$invoice_id order by pinvoice_id desc") or die();
		  $sno=1;
		  $totalamount=0;
		  while($rs=mysql_fetch_array($rsql))
		  {
		   
$html .='<tr>
            <td colspan="5"><div style="border:1px solid #000;"></div></td>
            </tr>
          <tr>
            <td>'.$sno.'</td>
            <td>'.$rs['paricular'].'</td>
            <td>'.$rs['nocon'].'</td>
            <td>'.$rs['conrate'].'</td>
            <td>'.$rs['tamount'].'</td>
            </tr>';
         
		  $totalamount=$rs['tamount']+$totalamount;
		  $sno++;
		  }  
$html .='<tr>
            <td colspan="5"><div style="border:1px solid #000;"></div></td>
            </tr>
          <tr>
            <td colspan="3"><strong>Rupees: '.convertNumber($totalamount).'</strong></td>
            <td align="right"><strong>Total</strong></td>
            <td><strong>'.$totalamount.'</strong></td>
            </tr>            
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</DIV>

 

</body>
';

//==============================================================
//==============================================================
//==============================================================
include("../mpdf.php");

$mpdf=new mPDF(); 

$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

?>