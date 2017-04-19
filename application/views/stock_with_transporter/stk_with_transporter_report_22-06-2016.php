<!DOCTYPE html>



<html>
    <head>
        <head>
        <meta charset='UTF-8'>

        <title>Stock With Transporter</title>

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
        
        <script>
            $(document).ready(function() {
                $("#printbtn").click(function() {
                    window.print();

                });
            });


        </script>

    </head>
    </head>
    <body>
        
        
        <table>
            <tr>

                <td align="right" border="1">
                    <img src="<?php echo base_url(); ?>application/assets/images/Print.png" alt="Print" title="Print" style="cursor: pointer;cursor: hand;" id="printbtn"/>
                </td>
            </tr>
        </table>
        

     
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
            <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:16px; font-weight:bold"><?php echo($company);; ?></font></td>
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

  <table width="100%" class="demo" border="0" >
    
  <thead>
       
      
        <th>Sl No.</th>
        <th>Garden</th>
        <th>Do.Number</th>
        <th>Invoice</th>
        <th>Sale No.</th>
        <th>Grade</th>
        <th>Total Bags</th>
        <th>Net(Kgs.)</th>
        <th>Stock In Kgs</th>
        <th>Rate</th>
        <th>Amount</th>
             
  </thead>
    <tbody >
  <pre>
        <?php //print_r($stock_with_transporter_report);?>
    </pre>
         
                                 <?php 
                                     $grandQty = 0;
                                     $grandTotalAmount = 0;
                                 if($stock_with_transporter_report){
                                     $sl=0;  
                                    
                                   ?>
                                     <?php
                                     foreach ($stock_with_transporter_report as $key=> $content){
                                          $sl=$sl+1;
                                           ?>
                                            <tr>
                                                <td>   
                                                    <input type="hidden" id="purDtlId<?php echo($sl);?>" name="purDtlId" value="<?php echo($content->purchaseDTLsId);?>"/>
                                                    <input type="hidden" id="dotransportaionid" name="dotransportaionid" value="<?php echo($content->doTransIds);?>"/>
                                                    <?php echo($sl);?>
                                                </td>
                                        

                                                <td>
                                                   <?php echo($content->garden_name); ?>
                                                </td>
                                                
                                                <td align="center">
                                                    <?php echo($content->do);?>
                                                </td>
                                                <td>
                                                   <?php echo($content->invoice_number); ?>
                                                </td>
                                                <td>
                                                    <?php echo($content->sale_number);?>
                                                </td>
                                                <td align="center">
                                                    <?php echo($content->grade);?>
                                                </td>
                                                
                                                <td align="right">
                                                     <?php echo($content->totalBags);?>
                                                </td>
                                                <td align="right">
                                                    <?php echo($content->NetKg);?>
                                                </td>
                                                
                                                <td align="right">
                                                    <?php echo($content->total_weight);?>
                                                </td>
                                                <td align="right">
                                                    <?php echo number_format($content->price,2);?>
                                                </td>
                                                <td  align="right">
                                                    <?php echo  number_format($content->amount,2);?>
                                                </td>
                                             
                                                
                                            </tr>
                                 <?php 
                                     $grandTotalAmount = $grandTotalAmount+($content->amount);
                                     $grandQty = $grandQty+$content->total_weight;
                                       }?>
                                            <tr>
                                                <td><strong>Total</strong></td>
                                               
                                                <td colspan="7"align="right"><strong><?php echo number_format($grandQty,2);?></strong></td>
                                                <td colspan="8" align="right"><strong><?php echo number_format($grandTotalAmount,2);?></strong></td>
                                            </tr>
                                       
                                   <?php    
                                       }
                                 ?>
  
    </tbody>
</table>

</body>
</html>