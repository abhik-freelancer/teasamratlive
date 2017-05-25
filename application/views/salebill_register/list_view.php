<table id="example" class="display no-wrap" cellspacing="0" width="auto" border="0">
    
<thead>
    
    <th>Customer Name</th>
    <th>Salebill No</th>
    <th>Salebill Dt</th>
   <!-- <th>Due Dt</th> -->
    <th align="right">Quantity</th>
    <th align="right">Tax Amount</th>
    <th align="right">Discount Amount</th>
    <th align="right">Total Amount</th>
    <th align="right">Grand Total</th>
 
   
   
</thead>
<tbody>

    <?php
    if ($get_salebill_register) {
        foreach ($get_salebill_register as $row) {
           
            ?>
            <tr>
                
                <td><input type="hidden" name="salebillMastrId" value="<?php echo "salebillmasterId--".$row['salebillID']."--".$row['saleType'];?>" />
                    <?php echo $row['customerName'];?></td>
                <td><?php echo $row['saleBillNo'];?></td>
                <td><?php echo date('d-m-Y',strtotime($row['saleBillDate']));?></td>
               <!-- <td><?php echo $row['DueDt'];?></td>-->
                <td>
				<!--
                    <table width="100%" align="left">
                        <tr>
                            <th>product</th>
                            <th>PackingBox</th>
                            <th>Net</th>
                            <th>Rate</th>
                            <th>Qty(Kg)</th>
                        </tr>
                        
                    <?php foreach($row['salebilldetail'] as $detail){?>
                        <tr>
                              <td><?php echo $detail['finalProduct'];?></td>
                              <td><?php echo $detail['packingbox'];?></td>
                              <td><?php echo $detail['packingnet'];?></td>
                              <td><?php echo $detail['rate'];?></td>
                              <td><?php echo $detail['quantity'];?></td>
                        </tr>
                    <?php } ?>
                    </table> -->
					<?php echo $row['totalQty'];?>
                </td>
                <td><?php $taxType = $row['taxType'];
                    if($taxType=='V'){
                        echo "VAT : ". $row['taxAmount'];
                    }
                    if($taxType=='C'){
                         echo "CST : ". $row['taxAmount'];
                    }
                   
                ?></td>
                <td align="right"><?php echo $row['discountAmount'];?></td>
                <td align="right"><?php echo $row['totalAmount'];?></td>
                <td align="right"><?php echo $row['grandTotalAmt'];?></td>
            </tr>
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
          
          
            
            
         </tr>
    <?php } ?>
</tbody>
</table>

<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>application/assets/js/jquery.dataTables.min.js"></script>
<script>
$( document ).ready(function() {
    $("#example").DataTable();
});
</script>












    
    
