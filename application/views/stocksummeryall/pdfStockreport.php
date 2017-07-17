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
		padding:5px;
		background:#F0F0F0;
		font-family:Verdana, Geneva, sans-serif;
		font-size:14px;
		font-weight:bold;
	}
	.demo td {
		border:1px solid #C0C0C0;
		padding:5px;
		font-family:Verdana, Geneva, sans-serif;
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
                font-family:Verdana, Geneva, sans-serif; 
                font-size:13px; font-weight:bold;
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
        <table>
            <tr>

                <td align="right" border="1">
                    <img src="<?php echo base_url(); ?>application/assets/images/Print.png" alt="Print" title="Print" style="cursor: pointer;cursor: hand;" id="printbtn"/>
                </td>
            </tr>
        </table>

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
                    
                    <th>Location</th>
                    <th>Garden</th>
                    <th>Invoice</th>
                    <th>Grade</th>
                    <th>Lot</th>
                    <th>Sale No</th>
                    <th>Stock In Bags</th>
                    <th>Net Kgs.</th>
                    <th>Stock In Kgs</th>
                    <th>Cost Of Tea</th>
                    <th>Amount (Rs.)</th>
                </tr>


                <?php
                $grandQty = 0;
                 $grandTotalAmount = 0;
                
                    if($stock){
                        
                    $lnCont = 1;
                    $totalAmt = 0 ;
                    $totalStockInKgs = 0;
              
                    foreach ($stock as $rows) {
                        $totalAmt=$totalAmt+$rows['amount'];
                        $totalStockInKgs = $totalStockInKgs+$rows['NetBags'];
                        ?>

                        <tr>
                            
                            <td><?php echo $rows['Location']; ?></td>
                            <td><?php echo $lnCont.$rows['Garden']; ?></td>
                            <td><?php echo $rows['Invoice']; ?></td>
                            <td><?php echo $rows['Grade']; ?></td>
                            <td><?php echo $rows['lot']?></td>
                            <td><?php echo $rows['SaleNo']?></td>
                            <td align="right"><?php echo number_format($rows['Numberofbags'], 2); ?></td>
                            <td align="right"><?php echo number_format($rows['NetKg'], 2); ?></td>
                            <td align="right"><?php echo number_format($rows['NetBags'], 2); ?></td>
                            <td align="right"><?php echo number_format($rows['costOfTea'], 2); ?></td>
                            <td align="right"><?php echo number_format($rows['amount'], 2); ?></td>
                        </tr>
                        
                        <?php  // $totalAmt=$totalAmt+$rows['amount'];
                               // $totalStockInKgs = $totalStockInKgs+$rows['NetBags'];
                        
                        $lnCont = $lnCont+1;
                        
                            if($lnCont>30){ ?>
                         <tr>
                             <td>Total</td>
                            <td colspan="8" align="right"><?php echo $totalStockInKgs; ?></td>
                            <td colspan="2" align="right"><?php echo $totalAmt; ?></td>
                        </tr>
                       
                         </table>
                        <div class="break"></div>
                            <?php $lnCont=1;?>
                            
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
                    <th>Location</th>
                    <th>Garden</th>
                    <th>Invoice</th>
                    <th>Grade</th>
                    <th>Lot</th>
                    <th>Sale No</th>
                    <th>Stock In Bags</th>
                    <th>Net Kgs.</th>
                    <th>Stock In Kgs</th>
                    <th>Cost Of Tea</th>
                    <th>Amount (Rs.)</th>
                </tr>
                 
                
                <tr>
                   <td>Total</td>
                   <td colspan="8" align="right"><?php echo $totalStockInKgs; ?></td>
                   <td colspan="2" align="right"><?php echo $totalAmt; ?></td>
                </tr>
                        
                        
                            <?php }?>

                        <?php
                       
                       $grandQty = $grandQty + $rows['NetBags'];
                        $grandTotalAmount = $grandTotalAmount +$rows['amount'];
                        $count++;
                    }
                    ?>
                   
    <?php 
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
                    <td align="right"><b><?php echo number_format($grandQty, 2); ?></b></td>
                    <td>&nbsp;</td>
                    <td align="right"><b><?php echo number_format($grandTotalAmount, 2); ?></b></td>

                </tr> 



            </table>

        </div>

    </body>

</html>