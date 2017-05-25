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
                font-size:22px;
                font-weight:bold;
            }
            .demo td {
                border:1px solid #C0C0C0;
                padding:6px;
                font-family:Verdana, Geneva, sans-serif;
                font-size:21px;		

            }
            .break{
                page-break-after: always;
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

                <th>Customer Name</th>
                <th>Salebill No</th>
                <th>Salebill Dt</th>
                <th>Due Dt</th>
                <th>Salebill Detail</th>
                <th>Tax Amount</th>
                <th>Discount Amount</th>
                <th>Total Amount</th>
                <th>Grand Total</th>



            </tr>


            <?php
            if ($resultSalebill) {
                $lnCount = 1;
                
                foreach ($resultSalebill as $row) {
                    ?>
                    <tr>

                        <td><input type="hidden" name="salebillMastrId" value="<?php echo "salebillmasterId--" . $row['saleBlMastId']; ?>" />
                            <?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['salebillno']; ?></td>
                        <td><?php echo $row['SaleBlDt']; ?></td>
                        <td><?php echo $row['DueDt']; ?></td>
                        <td >
                            <table width="100%" align="left" style="border:0px;">
                                <tr>
                                    <th>product</th>
                                    <th>PackingBox</th>
                                    <th>Net</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                </tr>

                                <?php foreach ($row['salebilldetail'] as $detail) { ?>
                                    <tr>
                                        <td><?php echo $detail['finalProduct']; ?></td>
                                        <td><?php echo $detail['packingbox']; ?></td>
                                        <td><?php echo $detail['packingnet']; ?></td>
                                        <td><?php echo $detail['rate']; ?></td>
                                        <td><?php echo $detail['quantity']; ?></td>
                                    </tr>
                                    
                                  <?php } ?>
                            </table>
                        </td>
                        <td><?php
                                $taxType = $row['taxrateType'];
                                if ($taxType == 'V') {
                                    echo "VAT : " . $row['taxamount'];
                                }
                                if ($taxType == 'C') {
                                    echo "CST : " . $row['taxamount'];
                                }
                                ?></td>
                        <td><?php echo $row['discountAmount']; ?></td>
                        <td><?php echo $row['totalamount']; ?></td>
                        <td><?php echo $row['grandtotal']; ?></td>
                    </tr>
                    <?php $lnCount = $lnCount+1;?>
                    <?php if($lnCount>1){?>
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

                                            <th>Customer Name</th>
                                            <th>Salebill No</th>
                                            <th>Salebill Dt</th>
                                            <th>Due Dt</th>
                                            <th>Salebill Detail</th>
                                            <th>Tax Amount</th>
                                            <th>Discount Amount</th>
                                            <th>Total Amount</th>
                                            <th>Grand Total</th>



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



                </tr>
            <?php } ?>

        </table>


    </body>
</html>