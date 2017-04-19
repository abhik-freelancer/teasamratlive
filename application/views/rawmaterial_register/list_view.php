<table id="example" class="display no-wrap" cellspacing="0" width="auto" border="0">
    
<thead>
    
    <th>Invoice No.</th>
    <th>Invoice Date</th>
    <th>Vendor Name</th>
    <th>Detail</th>
    <th>Tax Amount</th>
    <th>Excise Amount</th>
    <th>Item Amount</th>
    <th>Invoice Value</th>
 
   
   
</thead>
<tbody>

    <?php
    if ($rawmaterialpurchase_register) {
        foreach ($rawmaterialpurchase_register as $row) {
           
            ?>
            <tr>
                <td>
                    <input type="hidden" name="raw_material_purchase_mastId" value="<?php echo $row['rawMatMastId'];?>" />
                    <?php echo $row['invoice_no'];?>
                </td>
                <td><?php echo $row['invoiceDt'];?></td>
                <td><?php echo $row['vendor_name'];?></td>
           
                <td>
                   <table width="100%" align="left">
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Amount</th>
                        </tr>
                        
                    <?php foreach($row['rawMtPurchaseDtl'] as $detail){?>
                        <tr>
                              <td><?php echo $detail['product_description'];?></td>
                              <td><?php echo $detail['quantity'];?></td>
                              <td><?php echo $detail['rate'];?></td>
                              <td><?php echo $detail['amount'];?></td>
                             
                        </tr>
                    <?php } ?>
                    </table>
                </td>
                <td><?php $taxType = $row['taxrateType'];
                    if($taxType=='V'){
                        echo "VAT : ". $row['taxamount'];
                    }
                    if($taxType=='C'){
                         echo "CST : ". $row['taxamount'];
                    }
                   
                ?></td>
                <td><?php echo $row['excise_amount'];?></td>
                <td><?php echo $row['item_amount'];?></td>
                <td><?php echo $row['invoice_value'];?></td>
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












    
    
