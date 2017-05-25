<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PURCHASE REGISTER</title>

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
                font-size:11px; font-weight:bold;
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
</style>



</head>
<body>

 <table width="100%" class="" style="border:1px solid #FFF;">
        <tr>
           <td  align="center"> <span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;">PURCHASE REGISTER<br> For Period <?php echo $forperiod; ?><br><?php echo $vendor_name;?></span></td>
        </tr>
		<tr >
			<td align="right"><span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;">Date : <?php echo date("d-m-Y");?></span></td>
		</tr>
    </table>
<table >
	<tr>
		<td><span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;"><?php echo $company; ?></span></td>
	</tr>
	<tr>
		<td><span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;"><?php echo $companylocation; ?></span></td>
	</tr>
</table>

<table width="100%" class="demo" style="margin-top:10px;">
	<tr>
		<th>#</th>
		<th align="left">Bill No</th>
		<th align="left">Bill Date</th>
		<th align="left">Vendor</th>
		<th align="right">Amount</th>
	</tr>
	<?php 
	$totalRoundOff = 0;
	$totalAmount = 0;
		if($purchaseRegister):
		$totalRoundOff = 0;
		$totalAmount = 0;
		$i=1;
		foreach($purchaseRegister as $purchase_reg):
		$totalRoundOff = $totalRoundOff+$purchase_reg['roundOff'];
		$totalAmount = $totalAmount+$purchase_reg['totalAmount'];
	?>	
	<tr>
		<td><?php echo $i++;?></td>
		<td><?php echo $purchase_reg['invoiceNumber']; ?></td>
		<td><?php echo date('d-m-Y',strtotime($purchase_reg['invoiceDate'])); ?></td>
		<td><?php echo $purchase_reg['vendorName']; ?></td>
		<td align="right"><?php echo $purchase_reg['totalAmount']; ?></td>
		
	</tr>	
		
	<?php	
		endforeach;
		endif;
	?>
	<tr>
		<td colspan="4">Total</td>
		<td align="right" style="font-weight:bold;"><?php echo $totalAmount; ?></td>
	</tr>
</table>

<div align="right" style="margin-top:20px;">
 <table width="40%" class="small_demo">
	<tr>
		<td>Total Brokerage</td>
		<td align="right"><?php echo $getPurchaseRegSumData['totalBrokerage'];?></td>
	</tr>
	<tr>
		<td>Total Excise</td>
		<td align="right"><?php echo $getPurchaseRegSumData['totalExciseAmt'];?></td>
	</tr>
	<tr>
		<td>Total Discount</td>
		<td align="right"><?php echo $getPurchaseRegSumData['totalDiscAmt'];?></td>
	</tr>
	<tr>
		<td>Total RoundOff</td>
		<td align="right"><?php echo number_format($totalRoundOff,2);?></td>
	</tr>
	<tr> 
		  <td>
			<?php foreach($getPurchaseRegSumData['toatlVAT'] as $vat_dtl){?>
				<tr>
					<td align="left">VAT @<?php echo floatval($vat_dtl['vat_rate']); ?> %</td>
					<td align="right"><?php echo $vat_dtl['vatAmount']; ?></td>
				</tr>
			<?php } ?>
		  </td>
	</tr>
	<tr>
		
		<td>
			<?php 
				if($getPurchaseRegSumData['totalCST'])
				foreach($getPurchaseRegSumData['totalCST'] as $cst_dtl){?>
					<tr>
						<td align="left">CST @<?php echo floatval($cst_dtl['cst_rate']); ?> %</td>
						<td align="right"><?php echo $cst_dtl['cstAmount']; ?></td>
					</tr>
			<?php } ?>
		</td>
	</tr>

	
</table>
</div>

</body>
</html>