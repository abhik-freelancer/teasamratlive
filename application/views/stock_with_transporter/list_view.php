<table id="example" class="display no-wrap" cellspacing="0" width="auto" border="0">
    
  <thead bgcolor="#a6a6a6">
        <th>Sl.</th>
        <th>Garden</th>
        <th>Do.Number</th>
        <th>Invoice</th>
        <th>sale No.</th>
        <th>Grade</th>
        <th>Total Bags</th>
        <th>Net(Kgs.)</th>
        <th>Stock In Kgs</th>
        <th>Rate</th>
        <th>Amount</th>
       
       <!-- <th>Challan</th>
        <th>Challan Dt.</th>
        <th>Location</th>
        <th>Stock</th>
        <th>Action</th>-->
        
    </thead>
    <tbody>
   <!-- <pre>
        <?php //print_r($stock_with_transporter);?>
    </pre>-->
         
                                 <?php if($stock_with_transporter){
                                     $sl=0;  
                                     foreach ($stock_with_transporter as $content){
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
                                                
                                                <td>
                                                    <span style="color:#360; font-size:12px ; font-weight:bold"><?php echo($content->do);?></span>
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
                                                
                                                <td align="center">
                                                     <?php echo($content->totalBags);?>
                                                </td>
                                                <td align="center">
                                                    <?php echo($content->NetKg);?>
                                                </td>
                                                
                                                <td align="center">
                                                    <?php echo($content->total_weight);?>
                                                </td>
                                                <td align="center">
                                                    <?php echo number_format($content->price,2);?>
                                                </td>
                                                <td>
                                                    <?php echo  number_format($content->amount,2);?>
                                                </td>
                                             
                                                
                                            </tr>
                                 <?php 
                                       
                                       }
                                       
                                       }
                                 ?>
    </tbody>
</table>

<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>application/assets/js/jquery.dataTables.min.js"></script>
<script>
$( document ).ready(function() {
    $("#example").DataTable();
});
</script>

