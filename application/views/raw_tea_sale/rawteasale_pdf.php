<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RawTea Sale Challan</title>

<style>
	.demo {
		border:1px solid #C0C0C0;
		border-collapse:collapse;
		padding:5px;
	}
	.demo th {
		border:1px solid #C0C0C0;
		padding:5px;
		background:#F0F0F0;
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;
		font-weight:bold;
	}
	.demo td {
		border:1px solid #C0C0C0;
		padding:5px;
		font-family:Verdana, Geneva, sans-serif;
		font-size:11px;		
		
	}
        .small_demo {
		border:1px solid;
		padding:2px;
	}
	.small_demo td {
		//border:1px solid;
		padding:2px;
                width: auto;
                font-family:Verdana, Geneva, sans-serif; 
                font-size:11px; 
	}
        
        
	.headerdemo {
		border:1px solid #C0C0C0;
		padding:2px;
	}
	
	.headerdemo td {
		//border:1px solid #C0C0C0;
		padding:2px;
	}
        .demo_font{
            font-family:Verdana, Geneva, sans-serif;
		font-size:11px;	
        }
        .break{
              page-break-after: always;
        }
</style>
</style>


</head>
    

<body>
   <table width="100%" border="0" align="left" style="font-size:1mm !important">
        <tr>
            <td width="25%"></td>
            <td width="42%" align="center"> <span style="font-family: sans-serif; font-size:9px; font-weight:bold;">TAX INVOICE CUM CHALLAN</span></td>
            <td width="30%" align="right"><span style="font-family: 'Open Sans',helvetica,arial,sans-serif; font-size:9px; "> ORIGINAL BUYER'S COPY / SELLER'S COPY / TRANSPORTER'S COPY</span></td>
        </tr>
       
    </table>
   
    
    <table width="100%"  border="0" align="left" style="font-size:1mm !important">
    
        <tr>
             <td width="25%"></td>
            <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:normal"><?php echo($headerview['Company']); ?></font></td>
            <td width="30%" align="right"></td>
        </tr>
      
         <tr>
             <td width="25%"></td>
            <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; "><?php echo($headerview['CompanyLocation']); ?></font></td>
            <td width="30%" align="right"></td>
        </tr>
       
       
     </table>
    
     <table width="100%" class="headerdemo">
         <tr>
             <td width="40%" valign="top">
                 <font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold"><?php echo($headerview['Customer']); ?></font></br>
             <br>             <font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold"><?php echo($headerview['CustomerAddress']); ?></font></br>  
       
            <table width="60%" class="demo_font" >
                <tr>
                    <td>Vat No.</td>
                    <td>:</td>
                    <td><?php echo($headerview['TinNumber']); ?></td>
                </tr>
                <tr>
                    <td>Pin No. </td>
                     <td>:</td>
                    <td><?php echo($headerview['PinNumber']); ?></td>
                </tr>
                <tr>
                    <td>Phone No. </td>
                     <td>:</td>
                    <td><?php echo($headerview['telephone']); ?></td>
                </tr>
                 <tr>
                    <td>Vehichle No. </td>
                     <td>:</td>
                    <td><?php echo($headerview['vehichleno']); ?></td>
                </tr>
            </table>
             </td>
            <td width="25%" align="center">
                
            </td>
             <td width="30%" align="right">
                <table  width="100%">
                    <tr>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">INVOICE NO</font></td>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">:</font></td>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;"><?php echo($headerview['invoice_no']); ?></td>
                    </tr>
                    
                     <tr>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">DATE</font></td>
                         <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">:</font></td>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;"><?php echo($headerview['SaleDt']); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

 


    <table width="100%" class="demo" >
        <tr>
            <th align="left">Garden</th>
           <th align="left">Invoice</th>
           <th align="left">Group</th>
           <th align="left">Grade</th>
           <th align="right">Net</th>
           <!--<th align="right">Cost Of Tea</th>-->
           <th align="right">Sale Bag</th>
           <th align="right">Total Kgs</th>
           <th align="right">Rate</th>
           <th align="right">Amount</th>
          
        </tr>

<?php 
        $lnCount = 1;
    
    foreach ($dtlview as $value ){ ?>
       <?php  if($value['num_of_sale_bag']!=0){ ?>
<tr>
              
                <td align="left"><?php echo ($value['garden_name']);?></td>
                <td align="left"><?php echo($value['invoice_number']);?></td>
                <td align="left"><?php echo($value['group_code']);?></td>
                <td align="left"><?php echo($value['grade']);?></td>
                <td align="right"><?php echo($value['net']);?></td>
               <!-- <td align="right"><?php echo($value['cost_of_tea']);?></td>-->
                <td align="right"><?php echo($value['num_of_sale_bag']);?></td>
                <td align="right"><?php echo number_format(($value['totalDtlkgs']),2);?></td>
                <td align="right"><?php echo($value['rate']);?></td>
                <td align="right"><?php echo number_format(($value['amount']),2);?></td>
        
</tr>
       <?php } $lnCount = $lnCount+1;
       if($lnCount>25){?>
        </table>
    <div class="break"></div>
    <?php $lnCount = 1;?>

    
     <table width="100%" border="0" align="left" style="font-size:1mm !important">
        <tr>
            <td width="25%"></td>
            <td width="42%" align="center"> <span style="font-family: sans-serif; font-size:9px; font-weight:bold;">TAX INVOICE CUM CHALLAN</span></td>
            <td width="30%" align="right"><span style="font-family: 'Open Sans',helvetica,arial,sans-serif; font-size:9px; "> ORIGINAL BUYER'S COPY / SELLER'S COPY / TRANSPORTER'S COPY</span></td>
        </tr>
       
    </table>
   
    
    <table width="100%"  border="0" align="left" style="font-size:1mm !important">
    
        <tr>
             <td width="25%"></td>
            <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:normal"><?php echo($headerview['Company']); ?></font></td>
            <td width="30%" align="right"></td>
        </tr>
      
         <tr>
             <td width="25%"></td>
            <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; "><?php echo($headerview['CompanyLocation']); ?></font></td>
            <td width="30%" align="right"></td>
        </tr>
       
       
     </table>
    
     <table width="100%" class="headerdemo">
         <tr>
             <td width="40%" valign="top">
                 <font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold"><?php echo($headerview['Customer']); ?></font></br>
             <br>             <font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold"><?php echo($headerview['CustomerAddress']); ?></font></br>  
       
            <table width="60%" class="demo_font" >
                <tr>
                    <td>Vat No.</td>
                    <td>:</td>
                    <td><?php echo($headerview['TinNumber']); ?></td>
                </tr>
                <tr>
                    <td>Pin No. </td>
                     <td>:</td>
                    <td><?php echo($headerview['PinNumber']); ?></td>
                </tr>
                <tr>
                    <td>Phone No. </td>
                     <td>:</td>
                    <td><?php echo($headerview['telephone']); ?></td>
                </tr>
                 <tr>
                    <td>Vehichle No. </td>
                     <td>:</td>
                    <td><?php echo($headerview['vehichleno']); ?></td>
                </tr>
            </table>
             </td>
            <td width="25%" align="center">
                
            </td>
             <td width="30%" align="right">
                <table  width="100%">
                    <tr>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">INVOICE NO</font></td>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">:</font></td>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;"><?php echo($headerview['invoice_no']); ?></td>
                    </tr>
                    
                     <tr>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">DATE</font></td>
                         <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">:</font></td>
                        <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px;"><?php echo($headerview['SaleDt']); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

  <table width="100%" class="demo" >
        <tr>
            <th align="left">Garden</th>
           <th align="left">Invoice</th>
           <th align="left">Group</th>
           <th align="left">Grade</th>
           <th align="right">Net</th>
          <!-- <th align="right">Cost Of Tea</th>-->
           <th align="right">Sale Bag</th>
           <th align="right">Total Kgs</th>
           <th align="right">Rate</th>
           <th align="right">Amount</th>
          
        </tr>

     <?php } ?>
       
       
      
        
        
<?php } ?>
        

 
        <tr>
            <th colspan="6" align="right"><?php echo round($headerview['TotalSaleBag']); ?></th>
            <th colspan="1" align="right"><?php echo ($headerview['TotalSaleQty']); ?></th>
            <th colspan="1">&nbsp;</th>
            <th colspan="1" align="right"><?php echo ($headerview['TotalAmount']); ?></th>
            
        </tr>
        
        
</table>
    
       <div style="padding:10px 0px;"></div>    
    
<div align="right">
     <table width="40%" class="small_demo" align="right">
    <tr>
      <td>Discount</td>
      <td>@<?php echo($headerview['DiscountRate']); ?>  %</td>
      <td align="right"><?php echo($headerview['DiscountAmount']); ?></td>
    </tr>

    <tr>
      <td>Delivery Chgs.</td>
      <td>&nbsp;</td>
      <td align="right"><?php echo($headerview['DeliveryChgs']); ?></td>
    </tr>
        
    <tr>
      <td><?php echo(($headerview['TaxRateType']=="V"?"VAT":"CST")); ?></td>
      <td>&nbsp;</td>
      <td align="right"><?php echo($headerview['TaxAmount']); ?></td>
    </tr>
    <tr>
      <td>Round Off</td>
      <td>&nbsp;</td>
      <td align="right"><?php echo($headerview['RoundOff']); ?></td>
    </tr>
  </table>
</div>
    
    
    <div style="padding:10px 0px;"></div>    
    
<table width="100%" class="demo">
   
    <tr>
        <td align="left"><img src="<?php echo base_url();?>/application/assets/images/rupees.png" width="12" height="12"/> <?php echo($amountinword); ?>&nbsp;ONLY
    </td>
    <td>Total :<td>
    <td align="right"><?php echo($headerview['GrandTotal']); ?></td>
    </tr>
  
  <tr>
    <td>Interest @12% per annum will be charged on overdue bills</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" class="demo">
  <tr>
      <td width="30%"><b>W.B.V.A.T - 19470546064  C.S.T -19470546258</b></td>
    <td width="70%"><div align="right">For <?php echo($headerview['Company']); ?></div></td>
  </tr>
  <tr>
    <td><div align="justify">We hereby certify that food mentioned in this invoice is warrented to 
    	be the nature and quality it purports to be
    </div></td>
      <td align="right" valign="bottom">Authourised Signatory</td>
  </tr>
</table>


</body>
</html>
