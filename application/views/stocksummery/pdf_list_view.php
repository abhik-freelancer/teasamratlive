<!DOCTYPE html>
<html>

    <head>
        <meta charset='UTF-8'>

        <title>Stock Summery</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/ReportStyle.css">
        <script src="<?php echo base_url(); ?>application/assets/lib/jquery-1.11.1.min.js" type="text/javascript"></script>

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
            .break{
                page-break-after: always;
            }
        </style>
    </head>



    <body>

        <div id="page-wrap">     

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
                <tr>
                    <!--<td colspan="2">Closing stock summery for the period of &nbsp; (<?php echo($dateRange); ?>)</td>-->
                    <td colspan="2">
                        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:500;">
                            Closing stock summery as on &nbsp;<?php echo($printDate); ?>
                        </span>
                    </td>
                </tr>
            </table>
            <div style="padding:8px 0px 8px 0px"></div>


            <table class="demo" width="100%">

                <tr>
                    <th>Group</th>
                    <th>Location</th>
                    <th>Garden</th>
                    <th>Invoice</th>
                    <th>Grade</th>
                    <th>Sale</th>
                    <th>Stock<br>(Bgs.)</th>
                    <th>Net Kgs</th>
                    <th>Stock<br>(Kgs.)</th>
                    <th>Cost</th>
                    <th>Amount</th>
                </tr>


                <?php
                $lnCont = 1;
                $flag = 1;
                $group = "";
                $grandQty = 0;
                $grandTotalAmount = 0;

                if (count($stock) > 0) :

                    $groupAmount = 0;
                    $groupQty = 0;

                    $totalRowAmt = 0;
                    $totalStockInKgs = 0;

                    foreach ($stock as $content) :
                        $totalRowAmt = $totalRowAmt + $content['amount'];
                        $totalStockInKgs = $totalStockInKgs + $content['NetBags'];
                        ?>

                        <?php if ($group != $content['Group'] && $flag != 1) { ?>
                            <tr>
                                <td >
                                    <b> Group <br>Total </b>
                                </td>
                                <td colspan="8" align="right"><?php echo number_format($groupQty, 2); ?></td>
                                <td colspan="2" align="right"><?php echo number_format($groupAmount, 2); ?></td>
                                <?php
                                $groupAmount = 0;
                                $groupQty = 0;
                                ?>
                            </tr>

                        <?php } ?>



                        <tr id="row<?php echo ($content['PbagDtlId']); ?>">
                            <td align="left"><?php if ($group != $content['Group']) echo($content['Group']); ?> </td>
                            <td align="left"><?php echo $content['Location']; ?> </td> 
                            <td align="left" width="15%"> <?php echo($content['Garden']); ?> </td>
                            <td align="left"><?php echo $content['Invoice']; ?></td>
                            <td align="left"><?php echo $content['Grade']; ?> </td>
                            <td align="left"><?php echo $content['SaleNo']; ?> </td>
                            <td  align="right" width="10%"><?php echo number_format($content['Numberofbags']); ?> </td>
                            <td  align="right"><?php echo number_format($content['NetKg'], 3); ?> </td>
                            <td align="right" width="10%"><?php echo number_format($content['NetBags'], 2); ?> </td>
                            <td align="right" width="10%"><?php echo number_format($content['costOfTea'], 2); ?> </td>
                            <td align="right" width="10%"><?php echo number_format($content['amount'], 2); ?> </td>
                        </tr>

                        <?php
                        $lnCont = $lnCont + 1;

                        if ($lnCont > 28) {
                            ?>
                            <tr>
                                <td>Total</td>
                                <td colspan="8" align="right"><?php echo number_format($totalStockInKgs, 2); ?></td>
                                <td colspan="2" align="right"><?php echo number_format($totalRowAmt, 2); ?></td>
                            </tr>
                        </table>


                        <div class="break"></div>
                        <?php $lnCont = 1; ?>

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
                            <tr>
                                <!--<td colspan="2">Closing stock summery for the period of &nbsp; (<?php echo($dateRange); ?>)</td>-->
                                <td colspan="2">
                                    <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:500;">
                                        Closing stock summery as on &nbsp;<?php echo($printDate); ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <div style="padding:8px 0px 8px 0px"></div>
                        <table class="demo" width="100%">

                            <tr>
                                <th>Group</th>
                                <th>Location</th>
                                <th>Garden</th>
                                <th>Invoice</th>
                                <th>Grade</th>
                                <th>Sale</th>
                                <th>Stock<br>(Bgs.)</th>
                                <th>Net Kgs</th>
                                <th>Stock<br>(Kgs.)</th>
                                <th>Cost</th>
                                <th>Amount</th>
                            </tr>

                        <?php } ?>

                        <?php
                        $group = $content['Group'];
                        $groupAmount = $groupAmount + $content['amount'];
                        $groupQty = $groupQty + $content['NetBags'];

                        $grandQty = $grandQty + $content['NetBags'];
                        $grandTotalAmount = $grandTotalAmount + $content['amount'];

                        $flag = $flag + 1;
                        ?>
                    <?php endforeach; ?>

                    <tr>
                        <td >
                            <b> Group <br> Total </b>
                        </td>
                        <td colspan="8" align="right"><?php echo number_format($groupQty, 2); ?></td>
                        <td colspan="2" align="right"><?php echo number_format($groupAmount, 2); ?></td>
                        <?php
                        $groupAmount = 0;
                        $groupQty = 0;
                        ?>
                    </tr>
                    <tr style="border:1px solid #CCC;">
                        <td><b>Grand <br>Total</b></td>
                        <td colspan="8" align="right"><?php echo number_format($grandQty, 2); ?></td>
                        <td colspan="2" align="right"><?php echo number_format($grandTotalAmount, 2); ?></td>
                    </tr>

                <?php endif; ?>


            </table>


        </div>
    </body>
</html>












