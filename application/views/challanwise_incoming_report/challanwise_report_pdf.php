<!DOCTYPE html>
<html>
    <head>
    <head>
        <meta charset='UTF-8'>

        <title></title>

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
                padding:5px;
                background:#F0F0F0;
                font-family:Verdana, Geneva, sans-serif;
                font-size:10px;
                font-weight:bold;
            }
            .demo td {
                border:1px solid #C0C0C0;
                padding:5px;
                font-family:Verdana, Geneva, sans-serif;
                font-size:9px;		

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




        <table width="100%">
            <tr>
                <td width="25%"></td>
                <td width="40%" align="center"> <span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;">CHALLAN WISE INCOMING REPORT <br>(&nbsp;<?php echo( $transporterName); ?>)</span></td>
                <td width="20%"></td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="25%"></td>
                <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:16px; font-weight:bold"><?php echo($company); ?></font></td>
                <td width="30%" align="right"></td>
            </tr>
            <tr>
                <td width="25%"></td>
                <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:12px; "><?php echo ($companylocation); ?></font></td>
                <td width="30%" align="right"></td>
            </tr>
            <tr>
                <td width="35%"></td>
                <td width="35%"></td>
                <td align="center" width="20%"><font style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">Date: <?php echo($printDate); ?></font></td>

            </tr>

        </table>


        <table>
            <tr>
                <td align="left"><strong>Challan no : <?php echo $challanno; ?></strong></td>
            </tr>
        </table>
        <table width="100%" class="demo" >

            <tr>
                <th>Sl.</th>
                <th>Garden</th>
                <th>Invoice</th>
                <th>Date</th>
                <th>Invoice</th>
                <th>Do.Number</th>
                <th>Bags</th>
                <th>No.of Bags</th>
                <th>Net(Kgs.)</th>
            </tr>


            <?php
            $grandTotalBag = 0;
            $grandQty = 0;
            $grandTotalAmount = 0;
            $lnCont = 1;
            $totalrowAmt = 0;
            $totalrowQty = 0;
            $totalrowbag = 0;

            if ($challanwisereport_pdf) {
                $sl = 0;
                ?>

                <?php
                foreach ($challanwisereport_pdf as $content) {
                    $sl = $sl + 1;
                    /* $totalrowAmt = $totalrowAmt+$content->amount;
                      $totalrowQty = $totalrowQty + $content->total_weight;
                      $totalrowbag = $totalrowbag + $content->totalBags; */
                    ?>
                    <tr>
                        <td>   

                            <?php echo($sl); ?>
                        </td>

                        <td>
                            <?php echo($content->garden_name); ?>
                        </td>
                        <td>
                            <?php echo($content->purchase_invoice_number); ?>
                        </td>
                        <td>
                            <?php echo($content->purchase_invoice_date); ?>
                        </td>
                        <td>
                            <?php echo($content->invoice_number); ?>
                        </td>

                        <td>
                            <?php echo($content->do); ?>
                        </td>
                        <td >
                            <?php echo($content->bagtype); ?>
                        </td>
                        <td >
                            <?php echo($content->actual_bags); ?>
                        </td>

                        <td>
                            <?php echo($content->net); ?>
                        </td>



                    </tr>
                    <?php $lnCont = $lnCont + 1;
                    if ($lnCont > 30) { ?>

                    </table>
                    <div class="break"></div>
            <?php $lnCont = 1; ?>

                    <table width="100%">
                        <tr>
                            <td width="25%"></td>
                            <td width="40%" align="center"> <span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; font-weight:bold;">STOCK WITH TRANSPORTER&nbsp;(&nbsp;<?php echo( $transporterName); ?>)</span></td>
                            <td width="20%"></td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <td width="25%"></td>
                            <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:16px; font-weight:bold"><?php echo($company); ?></font></td>
                            <td width="30%" align="right"></td>
                        </tr>
                        <tr>
                            <td width="25%"></td>
                            <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:12px; "><?php echo ($companylocation); ?></font></td>
                            <td width="30%" align="right"></td>
                        </tr>
                        <tr>
                            <td width="35%"></td>
                            <td width="35%"></td>
                            <td align="center" width="20%"><font style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">Date: <?php echo($printDate); ?></font></td>

                        </tr>

                    </table>

                    <table width="100%" class="demo" >
                        <tr>
                            <th>Sl.</th>
                            <th>Garden</th>
                            <th>Invoice</th>
                            <th>Date</th>
                            <th>Invoice</th>
                            <th>Do.Number</th>
                            <th>Bags</th>
                            <th>No.of Bags</th>
                            <th>Net(Kgs.)</th>
                        </tr>


                    <?php } ?>

                    <?php
                    //$grandTotalAmount = $grandTotalAmount + ($content->amount);
                    //$grandQty = $grandQty + $content->total_weight;
                    //$grandTotalBag = $grandTotalBag + $content->totalBags;
                }
                ?>


                <?php
            }
            ?>
          <!--<tr>
              <td><b>Grand <br>Total</b></td>
              <td colspan="6" align="right"><b><?php echo number_format($grandTotalBag); ?></b></td>
              <td>&nbsp;</td>
              <td  align="right"><b><?php echo number_format($grandQty, 2); ?></b></td>
              <td>&nbsp;</td>
              <td  align="right"><b><?php echo number_format($grandTotalAmount, 2); ?></b></td>
          </tr>-->

        </table>

    </body>
</html>