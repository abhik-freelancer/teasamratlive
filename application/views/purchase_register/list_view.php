<table id="example" class="display no-wrap" cellspacing="0" width="auto" border="0">
    
<thead>
    
    <th>Invoice No</th>
    <th>Invoice Dt</th>
    <th>Vendor</th>
     <th>Sale No</th>
    <!-- <th>Sale Dt</th>-->
    <th>Total Bags</th>
    <th>Total Kgs</th>
    <th>Tea Value</th>
    <th>Brokerage</th>
    <th>TB Charge</th>
    <th>Service Tax</th>
    <th>TAX</th>
    <th>Stamp</th>
    <th>TOTAL</th>
</thead>
<tbody>

    <?php
    if ($search_purchase_register) {
        foreach ($search_purchase_register as $row) {
		   /*
		   echo "<pre>";
           print_r($row);
		   echo "</pre>";*/
            ?>
            <tr>
                <td><?php echo $row['purchase_invoice_number'];?></td>
                <td><?php echo date("d-m-Y",strtotime($row['purchase_invoice_date']));?></td>
                <td><?php echo $row['vendor_name'];?></td>
                <td align="right"><?php echo $row['sale_number'];?></td>
                <td align="right"><?php echo $row['bagDtl']['actualBag'];?></td>
                <td align="right"><?php echo $row['bagDtl']['totalkgs'];?></td>
                <td align="right"><?php echo $row['purchaseDtl']['teaValue'];?></td>
                <td align="right"><?php echo $row['purchaseDtl']['totalBrokerage'];?></td>
                <td align="right"><?php  if($row['purchaseDtl']['totalTBCharges']==0){echo number_format(0,2);}else{ echo $row['purchaseDtl']['totalTBCharges'];}?></td>
                <td align="right"><?php echo $row['purchaseDtl']['serviceTaxAmt'];?></td>
                <td>
					<?php
					if($row['purchaseDtl']['rate_type']=="V"){echo "VAT";}
					if($row['purchaseDtl']['rate_type']=="C"){echo "CST";}
					?>:<br>
					<?php echo $row['purchaseDtl']['totalTaxAmt'];?> 
				</td>
                <td align="right"><?php echo $row['purchaseDtl']['totalStamp'];?></td>
                <td align="right"><?php echo $row['total'];?></td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td>No data found....!!!</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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












    
    
