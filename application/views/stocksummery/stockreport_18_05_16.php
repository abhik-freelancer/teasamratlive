<!--<!DOCTYPE html>
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
		padding:2px;
                font-size:10px;
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

     
</style>

      <!--  <script>
            $(document).ready(function() {
                $("#printbtn").click(function() {
                    window.print();

                });
            });


        </script>-

    </head>

    <body>

        <!--<table>
            <tr>

                <td align="right" border="1">
                    <img src="<?php echo base_url(); ?>application/assets/images/Print.png" alt="Print" title="Print" style="cursor: pointer;cursor: hand;" id="printbtn"/>
                </td>
            </tr>
        </table>-

        <div id="page-wrap">


          
            <div style="padding:8px 0px 8px 0px"></div>

            <table class="demo" width="100%">
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

                            
                           <!-- <td><?php echo $rows['Group'];?></td>-->
                            <td width="8%"><?php echo $rows['Location']; ?></td>
                            <td><?php echo $rows['Garden']; ?></td>
                            <td ><?php echo $rows['Invoice']; ?></td>
                            <td ><?php echo $rows['Grade']; ?></td>
                            <td><?php echo $rows['lot']?></td>
                            <td><?php echo $rows['SaleNo']?></td>
                            <td align="right"><?php echo number_format($rows['Numberofbags'], 2); ?></td>
                            <td align="right"><?php echo number_format($rows['NetKg'], 2); ?></td>
                            <td align="right"><?php echo number_format($rows['NetBags'], 2); ?></td>
                            <td align="right"><?php echo number_format($rows['costOfTea'], 2); ?></td>
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
                        <td style="word-wrap: break-word;"><b>Group Total</b></td>

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
                    <td style="word-wrap: break-word;"><b>Grand Total</b> </td>

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
          
