<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tax Invoice Cum Challan</title>

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
		font-size:9px;
		font-weight:bold;
	}
	.demo td {
		border:1px solid #323232;
		padding:5px;
		//font-family:Verdana, Geneva, sans-serif;
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
			<td><?php echo $companyinfo->gst_number; ?></td>
		</tr>
		<tr>
			<td width="20%">Name</td>
			<td><?php echo $companyinfo->company_name; ?></td>
		</tr>
		<tr>
			<td width="20%">Address</td>
			<td><?php echo $companyinfo->location; ?></td>
		</tr>
		<tr>
			<td width="20%">Serial No of Invoice</td>
			<td><?php echo($headerview['SaleBillNo']); ?></td>
		</tr>
		<tr>
			<td width="20%">Date of Invoice</td>
			<td><?php echo($headerview['SaleBillDate']); ?></td>
		</tr>
		<tr>
			<td width="20%">Place Of Supply</td>
			<td><?php echo($headerview['GST_placeofsupply']); ?></td>
		</tr>
		<tr>
			<td width="20%">Vehichle No</td>
			<td><?php echo($headerview['vehichleno']); ?></td>
		</tr>
		<tr>
			<td width="20%">Transporter</td>
			<td><?php echo($headerview['transporterName']); ?></td>
		</tr>
		<tr>
			<td width="20%">Transporter Address</td>
			<td><?php echo($headerview['transporterAddrs']); ?></td>
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
						<td><?php echo($headerview['custStatename']); ?></td>
					</tr>
					<tr>
						<td>State Code </td>
						<td><?php echo(""); ?></td>
					</tr>
					 <tr>
						<td>GISTIN/Unique ID </td>
						<td><?php echo($headerview['customerGSTNo']); ?></td>
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
						<td><?php echo($headerview['custStatename']); ?></td>
					</tr>
					<tr>
						<td>State Code </td>
						<td><?php echo(""); ?></td>
					</tr>
					 <tr>
						<td>GISTIN/Unique ID </td>
						<td><?php echo($headerview['customerGSTNo']); ?></td>
					</tr>
				</table>
            </td>
        </tr>
    </table>

 

 

<table width="100%" border="0" class="demo" style="border-top:0;">
    <tr>
        <th width="">Description of Goods</th>
        <th>HSN</th>
		<th>Packing</th>
        <th>Qty</th>
        <th>Rate</th>
        <th>Amount</th>
		<th>Discount</th>
		<th>Taxable<br>Value</th>
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
		$totalDiscount+= $value['Discount'];
		$totalTaxable+= $value['Taxableamount'];
		$totalCGST+= $value['cgstamount'];
		$totalSGST+= $value['sgstamount'];
		$totalIGST+= $value['igstamount'];
		
		?>
        <tr>
            <td ><?php echo($value['ProductDescription']);?></td>
            <td><?php echo($value['HSN']);?></td>
            <td align="right"><?php echo($value['Packet']);?> X <?php echo(number_format($value['PacketNet']));?></td>
            <td align="right"><?php echo($value['Quantity']);?></td>
            <td align="right"><?php echo($value['Rate']);?></td>
            <td align="right"><?php echo($value['Amount']);?></td>
            <td align="right"><?php echo($value['Discount']);?></td>
            <td align="right"><?php echo($value['Taxableamount']);?></td>
            <td align="right" >
				<table  width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;">
					<tr>
						<td style="border:none;"><?php if($value['cgstRate']==0){echo "";}else{echo $value['cgstRate']."%" ;}?></td>
						<td style="border:none;"><?php echo($value['cgstamount']);?></td>
					</tr>
				</table>
			</td>
			
			<td align="right">
				<table  width="100%" border="0" >
					<tr>
						<td style="border:none;"><?php if($value['sgstRate']==0){echo "";}else{echo $value['sgstRate']."%" ;}?></td>
						<td style="border:none;"><?php echo($value['sgstamount']);?></td>
					</tr>
				</table>
			</td>
			
			<td align="right">
				<table  width="100%" border="0" >
					<tr>
						<td style="border:none;"><?php if($value['igstRate']==0){echo "";}else{echo $value['igstRate']."%";}?></td>
						<td style="border:none;"><?php echo($value['igstamount']);?></td>
					</tr>
				</table>
			</td>

        </tr>
    <?php  $lnCount = $lnCount+1; ?>
    <?php if($lnCount>25){?>
    
</table> <!--- END TABLE-->
    
    <div class="break"></div>
    <?php $lnCount=1; ?>
    
	    <table width="100%" border="0" align="left" style="font-size:1mm !important">
        <tr>
            <td width="25%"></td>
            <td width="42%" align="center"> <span style="font-family: sans-serif; font-size:9px; font-weight:bold;">TAX INVOICE CUM CHALLAN</span></td>
            <td width="30%" align="right"><span style="font-family: 'Open Sans',helvetica,arial,sans-serif; font-size:9px; "> ORIGINAL BUYER'S COPY / SELLER'S COPY / TRANSPORTER'S COPY</span></td>
        </tr>
	</table>
	
	<table width="100%" class="headerdemo" border="0" align="" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">
		<tr>
			<td width="20%">GSTIN</td>
			<td><?php echo $companyinfo->gst_number; ?></td>
		</tr>
		<tr>
			<td width="20%">Name</td>
			<td><?php echo $companyinfo->company_name; ?></td>
		</tr>
		<tr>
			<td width="20%">Address</td>
			<td><?php echo $companyinfo->location; ?></td>
		</tr>
		<tr>
			<td width="20%">Serial No of Invoice</td>
			<td><?php echo($headerview['SaleBillNo']); ?></td>
		</tr>
		<tr>
			<td width="20%">Date of Invoice</td>
			<td><?php echo($headerview['SaleBillDate']); ?></td>
		</tr>
	</table>
   
  
   
   
    <table width="100%" class="headerdemo" style="border-top:0;border-bottom:0;font-family:Verdana, Geneva, sans-serif; font-size:10px !important;">
	
		<tr style="font-size:20px;">
			<td >Details of Receiver (Billed to)</td>
			<td >Details of Consignee (Shipped to)</td>
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
						<td><?php echo($headerview['custStatename']); ?></td>
					</tr>
					<tr>
						<td>State Code </td>
						<td><?php echo(""); ?></td>
					</tr>
					 <tr>
						<td>GISTIN/Unique ID </td>
						<td><?php echo($headerview['customerGSTNo']); ?></td>
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
						<td><?php echo($headerview['custStatename']); ?></td>
					</tr>
					<tr>
						<td>State Code </td>
						<td><?php echo(""); ?></td>
					</tr>
					 <tr>
						<td>GISTIN/Unique ID </td>
						<td><?php echo($headerview['customerGSTNo']); ?></td>
					</tr>
				</table>
            </td>
        </tr>
    </table>

 

 

<table width="100%" border="0" class="demo" style="border-top:0;">
    <tr>
        <th >Description of Goods</th>
        <th>HSN</th>
		<th>Packing</th>
        <th>Qty</th>
        <th>Rate</th>
        <th>Amount</th>
		<th>Discount</th>
		<th>Taxable<br>Value</th>
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


	
	

	<!-- Before--> 
    
    <?php } ?>
    
    
        <?php } ?>
            <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><b><?php echo round($headerview['TotalPacket']); ?></b></td>
        <td align="right"><b><?php echo(number_format($headerview['TotalQty'],2)); ?></b></td>
        <td>&nbsp;</td>
        <td align="right"><b><?php echo(number_format($headerview['TotalAmount'],2)); ?></b></td>
        <td align="right"><b><?php echo(number_format($totalDiscount,2)); ?></b></td>
        <td align="right"><b><?php echo(number_format($totalTaxable,2)); ?></b></td>
		<td>
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td style="border:none;">&nbsp;</td>
					 <td align="right" style="border:none;"><b><?php echo(number_format($totalCGST,2)); ?></b></td>
				</tr>
			</table>
		</td>
		<td>
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td style="border:none;">&nbsp;</td>
					 <td style="border:none;" align="right"><b><?php echo(number_format($totalSGST,2)); ?></b></td>
				</tr>
			</table>
		</td>
		<td>
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td style="border:none;">&nbsp;</td>
					 <td style="border:none;" align="right"><b><?php echo(number_format($totalIGST,2)); ?></b></td>
				</tr>
			</table>
		</td>
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
</table>

<div style="padding:0px 0"></div>
<table width="100%" class="headerdemo" border="0" style="border-top:0;font-size:11px;" cellspacing="8" cellpadding="0">
 
	<tr style="height:25px;">
		<td width="50%">Declaration : </td>
		<td width="50%">Signature</td>
	</tr>
	
	<tr>
		<td width="50%">We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.</td>
		<td width="50%">Name of the Signatory</td>
	</tr>
	
	<tr>
		<td width="50%"></td>
		<td width="50%">Designation / Status</td>
	</tr>
 

</table>

</body>
</html>
