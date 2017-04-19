<html>
    <head>
        <title>Purchase Register</title>
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
            <tr><td align="center"><b>Purchase Register</b></td></tr>
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
        
        <table width="100%" class="demo">
        <tr >
            <th>Invoice No</th>
            <th>Invoice Dt</th>
            <th>Vendor</th>
             <th>Sale</th>
            <!-- <th>Sale Dt</th>-->
             <th>Total<br>(Bgs.)</th>
             <th>Total<br>(Kgs.)</th>
            <th>Tea Value</th>
            <th>Brokerage</th>
            <th>TB charge</th>
            <th>Service Tax</th>
            <th>TAX</th>
            <th>Stamp</th>
            <th>TOTAL</th>
        </tr>

            <?php
                
            $lncount=1;
            $totalAmt = 0;
            $grandTotal = 0;
            
            if ($search_purchase_register) {
                foreach ($search_purchase_register as $row) {
                      $totalAmt = $totalAmt+$row->total; 
                    ?>
                    <tr>
                        <td> <?php  echo $row->purchase_invoice_number;?></td>
                        <td><?php echo date("d-m-Y",strtotime($row->purchase_invoice_date));?></td>
                        <td> <?php echo $row->vendor_name;?></td>
                        <td> <?php  echo $row->sale_number;?></td>
                        <td align="right"><?php echo $row->totalbags;?></td>
                        <td align="right"><?php echo $row->totalkgs;?></td>
                        <td align="right"><?php echo $row->tea_value;?></td>
                        <td align="right"><?php echo $row->brokerage;?></td>
                        <td align="right"><?php if($row->totalTbCharges==0){echo number_format(0,2);}else{ echo $row->totalTbCharges;}?></td>
                        <td align="right"><?php echo $row->service_tax;?></td>
                        <td><?php echo $row->tax_type;?>:<?php echo $row->tax;?> </td>
                        <td align="right"><?php echo $row->stamp;?></td>
                        <td align="right"><?php echo $row->total;?></td>
                    </tr>
                    <?php 
                        $grandTotal = $grandTotal + $row->total; 
                        $lncount = $lncount+1;
                        if($lncount>18){
                    ?>
                    <tr>
                        <td><b>Total</b></td>
                        <td colspan="11" align="right"><?php echo number_format($totalAmt,2);?></td>
                    </tr>
                  
                    </table>
                    <div class="break"></div>
                    <?php $lncount=1; ?>
                    <table width="100%">
                        <tr><td align="center"><b>Purchase Register</b></td></tr>
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
                    <table width="100%" class="demo">
          <tr>
             <th>Invoice No</th>
             <th>Invoice Dt</th>
             <th>Vendor</th>
             <th>Sale</th>
             <th>Total<br>(Bgs.)</th>
             <th>Total<br>(Kgs.)</th>
             <th>Tea Value</th>
             <th>Brokerage</th>
             <th>TB charge</th>
             <th>Service Tax</th>
             <th>TAX</th>
             <th>Stamp</th>
             <th>TOTAL</th>
          </tr>
                    
                    
                    
                        <?php } ?>
                    <?php
                    
                    
                }
            } else {
                ?>
                <tr>
                    <td colspan="13" align="center">No data found....!!!</td>
                </tr>
            <?php } ?>

                 <tr>
                     <td colspan="12" align="left"><b>Grand Total</b></td>
                     <td align="right"><?php echo number_format($grandTotal,2); ?></td>
                 </tr>
        </table>
                
    </body>
</html>