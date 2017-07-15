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
            <tr><td align="center"><b>Salebill Register</b></td></tr>
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

                <th style="font-size:12px;">Customer Name</th>
                <th style="font-size:12px;">Salebill No</th>
                <th style="font-size:12px;">Salebill Dt</th>
                <th style="font-size:12px;">Quantity</th>
                <th style="font-size:12px;">Tax Amount</th>
                <th style="font-size:12px;">Discount Amount</th>
                <th style="font-size:12px;">Total Amount</th>
                <th style="font-size:12px;">Grand Total</th>



            </tr>


            <?php
			$grandTotalAmt = 0;
			$totalAmountSum = 0;
			$totalDiscountSum = 0;
			$totalTaxSum = 0;
			$totalQtySum = 0;
            if ($resultSalebill) {
                $lnCount = 1;
                $grandTotalAmt = 0;
				
                foreach ($resultSalebill as $row) {
					
					$totalQtySum = $totalQtySum+$row['totalQty'];
					$totalTaxSum = $totalTaxSum+$row['taxAmount'];
					$totalDiscountSum = $totalDiscountSum+$row['discountAmount'];
					$totalAmountSum = $totalAmountSum+$row['totalAmount'];
					$grandTotalAmt = $grandTotalAmt+$row['grandTotalAmt'];
                    ?>
                    <tr>
						<td style="font-size:11px;"><input type="hidden" name="salebillMastrId" value="<?php echo "salebillmasterId--" . $row['salebillID']."--".$row['saleType']; ?>" /><?php echo $row['customerName']; ?></td>
                        <td style="font-size:11px;"><?php echo $row['saleBillNo']; ?></td>
                        <td style="font-size:11px;"><?php echo date('d-m-Y',strtotime($row['saleBillDate'])); ?></td>
                        <td style="font-size:11px;" align="right"><?php echo $row['totalQty']; ?></td>
                        <td style="font-size:11px;" align="right"><?php
                                $taxType = $row['taxType'];
                                if ($taxType == 'V') {
                                    echo "VAT : <br>" . $row['taxAmount'];
                                }
								
                                if ($taxType == 'C') {
                                    echo "CST : <br>" . $row['taxAmount'];
                                }
                                ?>
						</td>
                        <td style="font-size:11px;" align="right"><?php echo $row['discountAmount']; ?></td>
                        <td style="font-size:11px;" align="right"><?php echo $row['totalAmount']; ?></td>
                        <td style="font-size:11px;" align="right"><?php echo $row['grandTotalAmt']; ?></td>
                    </tr>
                    <?php $lnCount = $lnCount+1;?>
                    <?php if($lnCount>24){?>
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
											<th style="font-size:12px;">Customer Name</th>
                                            <th style="font-size:12px;">Salebill No</th>
                                            <th style="font-size:12px;">Salebill Dt</th>
                                            <th style="font-size:12px;">Quantity</th>
                                            <th style="font-size:12px;">Tax Amount</th>
                                            <th style="font-size:12px;">Discount Amount</th>
                                            <th style="font-size:12px;">Total Amount</th>
                                            <th style="font-size:12px;">Grand Total</th>
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
                    <td>No data found....!!!</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>



                </tr>
            <?php } ?>
			<tr>
				<td colspan="3" style="font-size:12px;font-weight:bold;">Grand Total </td>
				<td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalQtySum ,2); ?></td>
				<td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalTaxSum,2); ?></td>
				<td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalDiscountSum,2); ?></td>
				<td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($totalAmountSum,2); ?></td>
				<td style="font-size:12px;font-weight:bold;" align="right"><?php echo number_format($grandTotalAmt,2); ?></td>
			</tr>
        </table>
		
		


    </body>
</html>