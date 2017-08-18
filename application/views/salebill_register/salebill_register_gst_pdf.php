<html>
    <head>
        <title>Salebill Register</title>
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
                font-size:10pt !important;
                font-weight:bold;
            }
            .demo td {
                border:1px solid #C0C0C0;
                padding:4px;
                font-family:Verdana, Geneva, sans-serif;
                font-size:10pt !important;		

            }
            .break{
                page-break-after: always;
            }
			.th_formt{
				font-size:10px;
			}
        </style>
    </head>
    <body>

        <table width="100%">
            <tr><td align="center"><b>Sales Register</b></td></tr>
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
                        Print Date : &nbsp;<?php echo($printDate); ?>
                    </span>
                </td>
            </tr>
        </table>

        <div style="padding:4px"></div>

        <table  class="demo" width="100%">

            <tr>
				<th style="font-size:12px;">Customer</th>
                <th style="font-size:12px;">Bill No</th>
                <th style="font-size:12px;">Bill Dt</th>
                <th style="font-size:12px;">Qty</th>
                <th style="font-size:12px;">Taxable</th>
				<th style="font-size:12px;">CGST Amt.</th>
				<th style="font-size:12px;">SGST Amt.</th>
				<th style="font-size:12px;">IGST Amt.</th>
				<th style="font-size:12px;">Total GST</th>
				<th style="font-size:12px;">Bill Total</th>
			</tr>


            <?php
			$grandTotalAmt = 0;
			$totalAmountSum = 0;
			$totalDiscountSum = 0;
			$totalTaxable = 0;
			$totalCGSTSum = 0;
			$totalSGSTSum = 0;
			$totalIGSTSum = 0;
			$totalQtySum = 0;
            if ($resultSalebill) {
                $lnCount = 1;
                $grandTotalAmt = 0;
				
                foreach ($resultSalebill as $row) {
					
					$totalQtySum = $totalQtySum+$row['totalQty'];
					$totalCGSTSum = $totalCGSTSum+$row['totalCGST'];
					$totalSGSTSum = $totalSGSTSum+$row['totalSGST'];
					$totalIGSTSum = $totalIGSTSum+$row['totalIGST'];
					$totalDiscountSum = $totalDiscountSum+$row['gstDiscountAmt'];
					$totalTaxable = $totalTaxable+$row['gstTaxableAmt'];
					$totalAmountSum = $totalAmountSum+$row['totalAmount'];
					$grandTotalAmt = $grandTotalAmt+$row['grandTotalAmt'];
                    ?>
                    <tr>
						<td style="font-size:11px;"><input type="hidden" name="salebillMastrId" value="<?php echo "salebillmasterId--" . $row['salebillID']."--".$row['saleType']; ?>" /><?php echo $row['customerName']; ?></td>
                        <td style="font-size:11px;"><?php echo $row['saleBillNo']; ?></td>
                        <td style="font-size:11px;"><?php echo date('d-m-Y',strtotime($row['saleBillDate'])); ?></td>
                        <td align="right"><?php echo $row['totalQty'];?></td>
						<td align="right"><?php echo $row['gstTaxableAmt'];?></td>
						<td align="right"><?php echo $row['totalCGST'];?></td>
						<td align="right"><?php echo $row['totalSGST'];?></td>
						<td align="right"><?php echo $row['totalIGST'];?></td>
						<td align="right"><?php echo $row['totalCGST']+$row['totalSGST']+$row['totalIGST'];?></td>
						<td align="right"><?php echo $row['grandTotalAmt'];?></td>
                    </tr>
                    <?php $lnCount = $lnCount+1;?>
                    <?php if($lnCount>22){?>
                    </table>
                        
                        <div class="break"></div>
                      <?php $lnCount=1; ?>
                        
                        <table width="100%">
                                        <tr><td align="center"><b>Salebill Register</b></td></tr>
                                    </table>

                                    <div style="padding:2px 0 5px 0;"></div>

                                    <table width="100%" class="">
                                        <tr>
                                            <td align="left">
                                                <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                                                    <?php echo($company); ?> <br/>
                                                    <?php echo($companylocation) ?>
                                                </span>
                                            </td>
                                            <td align=right>
                                                <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                                                    Print Date : &nbsp;<?php echo($printDate); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>

                                    <div style="padding:4px"></div>

                                    <table  class="demo" width="100%">

                                    <tr>
										<th style="font-size:12px;">Customer</th>
										<th style="font-size:12px;">Bill No</th>
										<th style="font-size:12px;">Bill Dt</th>
										<th style="font-size:12px;">Qty</th>
										<th style="font-size:12px;">Taxable</th>
										<th style="font-size:12px;">CGST Amt.</th>
										<th style="font-size:12px;">SGST Amt.</th>
										<th style="font-size:12px;">IGST Amt.</th>
										<th style="font-size:12px;">Total GST</th>
										<th style="font-size:12px;">Bill Total</th>
									</tr>

                       <?php }?>
                    
                    
                    
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>No data found....!!!</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
            <?php } ?>
			<tr>
				<td colspan="3" style="font-size:12px;font-weight:bold;">Grand Total </td>
				<td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalQtySum ,2); ?></td>
				<td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalTaxable ,2); ?></td>
				<td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalCGSTSum ,2); ?></td>
				<td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalSGSTSum ,2); ?></td>
				<td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalIGSTSum ,2); ?></td>
				<td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalCGSTSum+$totalSGSTSum+$totalIGSTSum,2); ?></td>
				<td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($grandTotalAmt,2); ?></td>
			</tr>
        </table>
		
		


    </body>
</html>