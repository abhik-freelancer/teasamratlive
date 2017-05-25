<html>
    <head>
        <title>Rawmaterial Register - Product Wise</title>
        <style>
            .demo {
                border:1px solid #C0C0C0;
                border-collapse:collapse;
                padding:5px;
            }
            .demo th {
                border:1px solid #C0C0C0;
                padding:4px;
                background:#F0F0F0;
                font-family:Verdana, Geneva, sans-serif;
                font-size:8pt !important;
                font-weight:bold;
            }
            .demo td {
                border:1px solid #C0C0C0;
                padding:4px;
                font-family:Verdana, Geneva, sans-serif;
                font-size:8pt !important;		

            }
            .break{
                page-break-after: always;
            }
			.th_formt{
				font-size:8px;
			}
        </style>
    </head>
    <body>

    <table width="100%">
        <tr><td align="center"><b>Rawmaterial Register - Product Wise</b></td></tr>
    </table>

    <div style="padding:2px 0 5px 0;"></div>

    <table width="100%" class="">
        <tr>
            <td align="left">
                <span style="font-family:Verdana, Geneva, sans-serif; font-size:10pt; font-weight:bold;">
                    <?php echo($company); ?> <br/>
                    <?php echo($companylocation) ?>
                </span>
            </td>
            <td align="right">
                <span style="font-family:Verdana, Geneva, sans-serif; font-size:10pt; font-weight:bold;">
                Print Date : &nbsp;<?php echo(date("d-m-Y")); ?>
                </span>
            </td>
        </tr>
    </table>
	
    <div style="padding:4px"></div>
	<div style="font-size:12px;font-weight:bold;">
		Product : <?php echo($rawmaterialProduct['product_description']); ?><br>
		<?php echo $forPeriod; ?>
	</div>
	<div style="padding:4px"></div>
	<table class="demo" width="100%">
		<tr>
			<th style="font-size:10px;" align="left">Invoice No</th>
			<th style="font-size:10px;" align="left">Invoice Date</th>
			<th style="font-size:10px;" align="left">Vendor</th>
			<th style="font-size:10px;" align="right">Quantity</th>
			<th style="font-size:10px;" align="right">Rate</th>
			<th style="font-size:10px;" align="right">Amount</th>
		</tr>
		
		<?php
		
		$totalqty = 0;
		$totalAmount = 0;
		if($rawmaterialProductWisePDF)
		{
			  $lnCount = 1;
			foreach($rawmaterialProductWisePDF as $rowMatData)
			{ 
			$totalqty = $totalqty+$rowMatData['quantity'];
			$totalAmount = $totalAmount+$rowMatData['amount'];
			?>
		<tr>
			<td style="font-size:10px;"><?php echo $rowMatData['invoice_no']; ?></td>
			<td style="font-size:10px;"><?php echo date("d-m-Y",strtotime($rowMatData['invoice_date'])); ?></td>
			<td style="font-size:10px;"><?php echo $rowMatData['vendor']; ?></td>
			<td style="font-size:10px;" align="right"><?php echo $rowMatData['quantity']; ?></td>
			<td style="font-size:10px;" align="right"><?php echo $rowMatData['rate']; ?></td>
			<td style="font-size:10px;" align="right"><?php echo $rowMatData['amount']; ?></td>
		</tr>
		<?php
			$lnCount=$lnCount+1;
			if($lnCount>20){ ?>
			
			</table>
			<div class="break"></div>
            <?php $lnCount=1; ?>
			
			<table width="100%">
				<tr><td align="center"><b>Rawmaterial Register - Product Wise</b></td></tr>
			</table>
			<div style="padding:2px 0 5px 0;"></div>
			<table width="100%" class="">
				<tr>
					<td align="left">
						<span style="font-family:Verdana, Geneva, sans-serif; font-size:10pt; font-weight:bold;">
							<?php echo($company); ?> <br/>
							<?php echo($companylocation) ?>
						</span>
					</td>
					<td align="right">
						<span style="font-family:Verdana, Geneva, sans-serif; font-size:10pt; font-weight:bold;">
						Print Date : &nbsp;<?php echo(date("d-m-Y")); ?>
						</span>
					</td>
				</tr>
			</table>
			<div style="padding:4px"></div>
			<div style="font-size:12px;font-weight:bold;">
				Product : <?php echo($rawmaterialProduct['product_description']); ?><br>
				<?php echo $forPeriod; ?>
			</div>
			<div style="padding:4px"></div>
			<table class="demo" width="100%">
				<tr>
					<th style="font-size:10px;" align="left">Invoice No</th>
					<th style="font-size:10px;" align="left">Invoice Date</th>
					<th style="font-size:10px;" align="left">Vendor</th>
					<th style="font-size:10px;" align="right">Quantity</th>
					<th style="font-size:10px;" align="right">Rate</th>
					<th style="font-size:10px;" align="right">Amount</th>
				</tr>
			
			
			<?php 
		    }
			
			}
		?>
		<tr>
			<td colspan="3" style="font-weight:bold;">Grand Total</td>
			<td align="right" style="font-weight:bold;"><?php echo number_format($totalqty,2); ?></td>
			<td>&nbsp;</td>
			<td align="right" style="font-weight:bold;"><?php echo number_format($totalAmount,2); ?></td>
		</tr>
			
		<?php
		}
		else{
		?>
		<tr>
			<td colspan="6" align="center">No records found...</td>
			
		</tr>
		<?php 
		}
		?>
		
	</table>

		
		


    </body>
</html>