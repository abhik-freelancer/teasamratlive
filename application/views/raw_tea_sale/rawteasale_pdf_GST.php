<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RawTea Sale Challan</title>

<style>
	.demo {
		border:1px solid #323232;
		border-collapse:collapse;
		padding:5px;
	}
	.demo th {
		border:1px solid #323232;
		padding:5px;
		background:#F0F0F0;
		//font-family:Verdana, Geneva, sans-serif;
		font-size:12px;
		font-weight:bold;
	}
	.demo td {
		border:1px solid #323232;
		padding:5px;
		//font-family:Verdana, Geneva, sans-serif;
		font-size:13px;		
		
	}
        .small_demo {
		border:1px solid;
		padding:2px;
	}
	.small_demo td {
		//border:1px solid;
		padding:2px;
                width: auto;
               // font-family:Verdana, Geneva, sans-serif; 
                font-size:9px; font-weight:normal;
	}
        
        
	.headerdemo {
		border:1px solid #323232;
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
	<table width="100%" border="0" align="left" style="font-size:1.1mm !important">
        <tr>
            <td width="25%"></td>
            <td width="42%" align="center"> <span style="font-family: sans-serif; font-size:9px; font-weight:bold;">TAX INVOICE</span></td>
            <td width="30%" align="right"><span style="font-family: 'Open Sans',helvetica,arial,sans-serif; font-size:9px; "> ORIGINAL BUYER'S COPY / SELLER'S COPY / TRANSPORTER'S COPY</span></td>
        </tr>
	</table>
	
	<table width="100%" class="headerdemo" border="0" align="" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">
		<tr>
			<td width="20%">GSTIN</td>
			<td><?php echo $headerview['compGSTNo']; ?></td>
		</tr>
		<tr>
			<td width="20%">Name</td>
			<td><?php echo $headerview['Company'];  ?></td>
		</tr>
		<tr>
			<td width="20%">Address</td>
			<td><?php echo $headerview['CompanyLocation']; ?></td>
		</tr>
		<tr>
			<td width="20%">Serial No of Invoice</td>
			<td><?php echo($headerview['invoice_no']); ?></td>
		</tr>
		<tr>
			<td width="20%">Date of Invoice</td>
			<td><?php echo($headerview['SaleDt']); ?></td>
		</tr>
		<tr>
			<td width="20%">Vehichle No</td>
			<td><?php echo($headerview['vehichleno']); ?></td>
		</tr>
	</table>
	
	    <table width="100%" class="headerdemo" style="border-top:0;border-bottom:0;font-family:Verdana, Geneva, sans-serif; font-size:10px !important;">
	
		<tr style="font-size:20px;bordre:1px solid #323232;">
			<td width="50%" style="border-bottom:1px solid #323232;border-right:0px solid #323232;">Details of Receiver (Billed to)</td>
			<td width="50%" style="border-bottom:1px solid #323232;border-left:0px solid #323232;">Details of Consignee (Shipped to)</td>
		</tr>
	
        <tr style="font-size:20px;">
            <td width="46%" valign="top" style="font-family:Verdana, Geneva, sans-serif; ">
				<table width="100%" class="" >
					<tr>
						<td>Name</td>
						<td><?php echo($headerview['Customer']); ?></td>
					</tr>
					<tr>
						<td>Address </td>
						<td><?php echo($headerview['CustomerAddress']); ?></td>
					</tr>
					<tr>
						<td>State </td>
						<td><?php echo($headerview['state_name']); ?></td>
					</tr>
					<tr>
						<td>State Code </td>
						<td><?php echo(""); ?></td>
					</tr>
					 <tr>
						<td>GISTIN/Unique ID </td>
						<td><?php echo($headerview['CustomerGSTNo']); ?></td>
					</tr>
				</table>
            </td>
           
			
			 <td width="46%" valign="top" style="font-family:Verdana, Geneva, sans-serif; ">
				<table width="100%" class="" >
					<tr>
						<td>Name</td>
						<td><?php echo($headerview['Customer']); ?></td>
					</tr>
					<tr>
						<td>Address </td>
						<td><?php echo($headerview['CustomerAddress']); ?></td>
					</tr>
					<tr>
						<td>State </td>
						<td><?php echo($headerview['state_name']); ?></td>
					</tr>
					<tr>
						<td>State Code </td>
						<td><?php echo(""); ?></td>
					</tr>
					 <tr>
						<td>GISTIN/Unique ID </td>
						<td><?php echo($headerview['CustomerGSTNo']); ?></td>
					</tr>
				</table>
            </td>
        </tr>
    </table>
   

    <table width="100%" class="demo" >
        <tr>
		   <th align="left">HSN</th>
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
		   <th align="right">Discount</th>
		   <th align="right">Taxable</th>
		   <th style="">
			<table  width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;">
				<tr style="border:none;">
					<th colspan="2" align="center" style="border:none;">CGST</th>
				</tr>
				<tr style="border:1px solid #323232;">
					<th style="border:none;">Rate</th>
					<th style="border:none;">Amt.</th>
				</tr>
			</table>
		</th>
		<th>
			<table  width="100%" border="0" border="0" cellspacing="0" cellpadding="0">
				<tr style="border:none;">
					<th colspan="2" align="center" style="border:none;">SGST</th>
				</tr>
				<tr style="border:none;">
					<th style="border:none;">Rate</th>
					<th style="border:none;">Amt.</th>
				</tr>
			</table>
		</th>
		<th>
			<table width="100%" border="0" border="0" cellspacing="0" cellpadding="0">
				<tr style="border:none;">
					<th colspan="2" align="center" style="border:none;">IGST</th>
				</tr>
				<tr>
					<th style="border:none;">Rate</th>
					<th style="border:none;">Amt.</th>
				</tr>
			</table>
		</th>
          
        </tr>

<?php 
    $lnCount = 1;
    
	$totalDiscount = 0;
	$totalTaxable = 0;
	$totalCGST = 0;
	$totalSGST = 0;
	$totalIGST = 0;
	
    foreach ($dtlview as $value ){ 
    
	$totalDiscount+= $value['gstdiscount'];
	$totalTaxable+= $value['gstTaxableamount'];
	$totalCGST+= $value['cgstAmt'];
	$totalSGST+= $value['sgstAmt'];
	$totalIGST+= $value['igstAmt'];	
		
		
		if($value['num_of_sale_bag']!=0){ 
		
		?>
<tr>
              
                <td align="left"><?php echo ($value['hsn_no']);?></td>
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
                <td align="right"><?php echo number_format(($value['gstdiscount']),2);?></td>
                <td align="right"><?php echo number_format(($value['gstTaxableamount']),2);?></td>
                 <td align="right" >
				<table  width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;">
					<tr>
						<td style="border:none;"><?php if($value['cgstRate']==0){echo "";}else{echo $value['cgstRate']."%" ;}?></td>
						<td style="border:none;"><?php if($value['cgstAmt']>0){echo $value['cgstAmt'];}else{echo "";}?></td>
					</tr>
				</table>
			</td>
			
			<td align="right">
				<table  width="100%" border="0" >
					<tr>
						<td style="border:none;"><?php if($value['sgstRate']==0){echo "";}else{echo $value['sgstRate']."%" ;}?></td>
						<td style="border:none;"><?php if($value['sgstAmt']>0){echo $value['sgstAmt'];}else{echo "";}?></td>
					</tr>
				</table>
			</td>
			
			<td align="right">
				<table  width="100%" border="0" >
					<tr>
						<td style="border:none;"><?php if($value['igstRate']==0){echo "";}else{echo $value['igstRate']."%";}?></td>
						<td style="border:none;"><?php if($value['igstAmt']>0){echo $value['igstAmt'];}else{echo "";}?></td>
					</tr>
				</table>
			</td>

        
</tr>
       <?php } $lnCount = $lnCount+1;
       if($lnCount>25){?>
        </table>
    <div class="break"></div>
    <?php $lnCount = 1;?>

    
		<table width="100%" border="0" align="left" style="font-size:1.1mm !important">
        <tr>
            <td width="25%"></td>
            <td width="42%" align="center"> <span style="font-family: sans-serif; font-size:9px; font-weight:bold;">TAX INVOICE</span></td>
            <td width="30%" align="right"><span style="font-family: 'Open Sans',helvetica,arial,sans-serif; font-size:9px; "> ORIGINAL BUYER'S COPY / SELLER'S COPY / TRANSPORTER'S COPY</span></td>
        </tr>
	</table>
	
	<table width="100%" class="headerdemo" border="0" align="" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">
		<tr>
			<td width="20%">GSTIN</td>
			<td><?php echo $headerview['compGSTNo']; ?></td>
		</tr>
		<tr>
			<td width="20%">Name</td>
			<td><?php echo $headerview['Company'];  ?></td>
		</tr>
		<tr>
			<td width="20%">Address</td>
			<td><?php echo $headerview['CompanyLocation']; ?></td>
		</tr>
		<tr>
			<td width="20%">Serial No of Invoice</td>
			<td><?php echo($headerview['invoice_no']); ?></td>
		</tr>
		<tr>
			<td width="20%">Date of Invoice</td>
			<td><?php echo($headerview['SaleDt']); ?></td>
		</tr>
	</table>
	
	    <table width="100%" class="headerdemo" style="border-top:0;border-bottom:0;font-family:Verdana, Geneva, sans-serif; font-size:10px !important;">
	
		<tr style="font-size:20px;bordre:1px solid #323232;">
			<td width="50%" style="border-bottom:1px solid #323232;border-right:0px solid #323232;">Details of Receiver (Billed to)</td>
			<td width="50%" style="border-bottom:1px solid #323232;border-left:0px solid #323232;">Details of Consignee (Shipped to)</td>
		</tr>
	
        <tr style="font-size:20px;">
            <td width="46%" valign="top" style="font-family:Verdana, Geneva, sans-serif; ">
				<table width="100%" class="" >
					<tr>
						<td>Name</td>
						<td><?php echo($headerview['Customer']); ?></td>
					</tr>
					<tr>
						<td>Address </td>
						<td><?php echo($headerview['CustomerAddress']); ?></td>
					</tr>
					<tr>
						<td>State </td>
						<td><?php echo($headerview['state_name']); ?></td>
					</tr>
					<tr>
						<td>State Code </td>
						<td><?php echo(""); ?></td>
					</tr>
					 <tr>
						<td>GISTIN/Unique ID </td>
						<td><?php echo($headerview['CustomerGSTNo']); ?></td>
					</tr>
				</table>
            </td>
           
			
			 <td width="46%" valign="top" style="font-family:Verdana, Geneva, sans-serif; ">
				<table width="100%" class="" >
					<tr>
						<td>Name</td>
						<td><?php echo($headerview['Customer']); ?></td>
					</tr>
					<tr>
						<td>Address </td>
						<td><?php echo($headerview['CustomerAddress']); ?></td>
					</tr>
					<tr>
						<td>State </td>
						<td><?php echo($headerview['state_name']); ?></td>
					</tr>
					<tr>
						<td>State Code </td>
						<td><?php echo(""); ?></td>
					</tr>
					 <tr>
						<td>GISTIN/Unique ID </td>
						<td><?php echo($headerview['CustomerGSTNo']); ?></td>
					</tr>
				</table>
            </td>
        </tr>
    </table>
   

    <table width="100%" class="demo" >
        <tr>
		   <th align="left">HSN</th>
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
		   <th align="right">Discount</th>
		   <th align="right">Taxable</th>
		   <th style="">
			<table  width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;">
				<tr style="border:none;">
					<th colspan="2" align="center" style="border:none;">CGST</th>
				</tr>
				<tr style="border:1px solid #323232;">
					<th style="border:none;">Rate</th>
					<th style="border:none;">Amt.</th>
				</tr>
			</table>
		</th>
		<th>
			<table  width="100%" border="0" border="0" cellspacing="0" cellpadding="0">
				<tr style="border:none;">
					<th colspan="2" align="center" style="border:none;">SGST</th>
				</tr>
				<tr style="border:none;">
					<th style="border:none;">Rate</th>
					<th style="border:none;">Amt.</th>
				</tr>
			</table>
		</th>
		<th>
			<table width="100%" border="0" border="0" cellspacing="0" cellpadding="0">
				<tr style="border:none;">
					<th colspan="2" align="center" style="border:none;">IGST</th>
				</tr>
				<tr>
					<th style="border:none;">Rate</th>
					<th style="border:none;">Amt.</th>
				</tr>
			</table>
		</th>
          
        </tr>
	
	
	
	
	

     <?php } ?>
       
       
      
        
        
<?php } ?>
        

 
        <tr>
            <th colspan="6" align="left"><?php echo "Total"; ?></th>
            <th align="right"><?php echo round($headerview['TotalSaleBag']); ?></th>
            <th align="right"><?php echo ($headerview['TotalSaleQty']); ?></th>
            <th>&nbsp;</th>
            <th align="right"><?php echo number_format($headerview['TotalAmount'],2); ?></th>
            <th align="right"><?php echo number_format($totalDiscount,2); ?></th>
            <th align="right"><?php echo number_format($totalTaxable,2); ?></th>
			<th>
				<table width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<th style="border:none;">&nbsp;</th>
						 <th align="right" style="border:none;"><?php echo(number_format($totalCGST,2)); ?></th>
					</tr>
				</table>
			</th>
			<th>
				<table width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<th style="border:none;">&nbsp;</th>
						 <th style="border:none;" align="right"><?php echo(number_format($totalSGST,2)); ?></th>
					</tr>
				</table>
			</th>
			<th>
				<table width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<th style="border:none;">&nbsp;</th>
						 <th style="border:none;" align="right"><?php echo(number_format($totalIGST,2)); ?></th>
					</tr>
				</table>
			</th>
        </tr>
        
        
</table>

<table width="100%" class="headerdemo" style="border-top:0;font-family:Verdana, Geneva, sans-serif; font-size:11px; ">
	<tr>
		<td>Total Invoice Value (In figure)</td>
		<td><?php echo($headerview['GrandTotal']); ?> /-</td>
	</tr>
	<tr>
		<td>Total Invoice Value (In Words)</td>
		<td> <?php echo($amountinword); ?>&nbsp;ONLY</td>
	</tr>
	<tr>
    <td>Interest @12% per annum will be charged on overdue bills</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="100%" class="headerdemo" border="0" style="border-top:0;font-size:11px;" cellspacing="8" cellpadding="0">
 
	<tr style="height:25px;">
		<td width="50%">Declaration : </td>
		<td width="50%">Signature</td>
	</tr>
	
	<tr>
		<td width="50%">We hereby certify that food mentioned in this invoice is warrented to 
    	be the nature and quality it purports to be</td>
		<td width="50%">Name of the Signatory</td>
	</tr>
	
	<tr>
		<td width="50%"></td>
		<td width="50%">Designation / Status</td>
	</tr>
 

</table>

<!--
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
</table>-->


</body>
</html>
