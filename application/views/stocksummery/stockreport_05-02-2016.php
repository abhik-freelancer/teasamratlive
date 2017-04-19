<!DOCTYPE html>
<html>

    <head>
        <meta charset='UTF-8'>

        <title>Stock Summery</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/ReportStyle.css">
       <script src="<?php echo base_url(); ?>application/assets/lib/jquery-1.11.1.min.js" type="text/javascript"></script>
        

        <script>
            $(document).ready(function() {
                $("#printbtn").click(function() {
                    window.print();

                });
            });


        </script>

    </head>

    <body>
        <table>
            <tr>

                <td align="right" border="1">
                    <img src="<?php echo base_url(); ?>application/assets/images/Print.png" alt="Print" title="Print" style="cursor: pointer;cursor: hand;" id="printbtn"/>
                </td>
            </tr>
        </table>

        <div id="page-wrap">


            <table width="100%" class="CSSTableGenerator">
                <tr>
                    <td>
                        
                    </td>
                    
                    <td></td>
                </tr>
                <tr>
                    <td align="left">
                        <?php echo($company); ?> <br/>
                        <?php echo($companylocation) ?>
                    </td>
                    <td align=right>
                        Print Date : &nbsp;<?php echo($printDate); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Closing stock summery for the period of &nbsp; (<?php echo($dateRange); ?>)</td>
                </tr>
            </table>
            <div style="padding:8px 0px 8px 0px"></div>

            <table class="CSSTableGenerator">
             <!-- <tr>
                    <td>Group</td>
                    <td>Garden</td>
                    <td>Grade</td>
                    <td>Invoice</td>
                    <td>Location</td>
                    <td>Stock In Bags</td>
                    <td>Stock In Kgs</td>
                    <td>Rate</td>
                    <td>Amount (Rs.)</td>

                </tr>-->
                <tr>
                 <td>Group</td>
                    <td>Location</td>
                    <td>Garden</td>
                    <td>Invoice</td>
                    <td>Grade</td>
                    <td>Lot</td>
                    <td>Sale No</td>
                    <td>Stock In Bags</td>
                    <td>Net Kgs.</td>
                    <td>Stock In Kgs</td>
                    <td>Rate</td>
                    <td>Amount (Rs.)</td>

                </tr>


                <?php
                $grandQty = 0;
                $grandTotalAmount = 0;
				if($stock){
                foreach ($stock as $key => $value) {
                    $groupAmount = 0;
                    $groupQty = 0;
                    $count = 1;
                    foreach ($value as $rows) {
                        ?>

                        <tr>
                            <td>
                                <?php
                                if ($count == 1) {
                                    echo $key;
                                } else {
                                    echo '';
                                }
                                ?>
                            </td>

                           <!-- <td><?php echo $rows['Garden']; ?></td>
                            <td><?php echo $rows['Grade']; ?></td>
                            <td><?php echo $rows['Invoice']; ?></td>
                            <td><?php echo $rows['Location']; ?></td>
                            <td align="right"><?php echo number_format($rows['Numberofbags'], 2); ?></td>
                            <td align="right"><?php echo number_format($rows['NetBags'], 2); ?></td>
                            <td align="right"><?php echo number_format($rows['Rate'], 2); ?></td>
                            <td align="right"><?php echo number_format($rows['amount'], 2); ?></td>-->
                            
                           <!-- <td><?php echo $rows['Group'];?></td>-->
                            <td><?php echo $rows['Location']; ?></td>
                            <td><?php echo $rows['Garden']; ?></td>
                            <td><?php echo $rows['Invoice']; ?></td>
                            <td><?php echo $rows['Grade']; ?></td>
                            <td><?php echo $rows['lot']?></td>
                            <td><?php echo $rows['SaleNo']?></td>
                            <td align="right"><?php echo number_format($rows['Numberofbags'], 2); ?></td>
                            <td align="right"><?php echo number_format($rows['NetKg'], 2); ?></td>
                            <td align="right"><?php echo number_format($rows['NetBags'], 2); ?></td>
                            <td align="right"><?php echo number_format($rows['Rate'], 2); ?></td>
                            <td align="right"><?php echo number_format($rows['amount'], 2); ?></td>
                          

                        </tr>



                        <?php
                        $groupAmount = $groupAmount + $rows['amount'];
                        $groupQty = $groupQty + $rows['NetBags'];
                        $grandQty = $grandQty + $rows['NetBags'];
                        $grandTotalAmount = $grandTotalAmount +$rows['amount'];
                        $count++;
                    }
                    ?>
                    <tr>
                        <td><b>Group Total</b></td>

                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right"><b><?php echo number_format($groupQty, 2); ?></b></td>
                        <td>&nbsp;</td>
                        <td align="right"><b><?php echo number_format($groupAmount, 2); ?></b></td>

                    </tr>
    <?php }
	}
?>
                <tr>
                    <td><b>Grand Total</b> </td>

                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right"><b><?php echo number_format($grandQty, 2); ?></b></td>
                    <td>&nbsp;</td>
                    <td align="right"><b><?php echo number_format($grandTotalAmount, 2); ?></b></td>

                </tr>



            </table>

        </div>

    </body>

</html>