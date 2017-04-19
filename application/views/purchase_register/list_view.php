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
           
            ?>
            <tr>
                <td><?php echo $row->purchase_invoice_number;?></td>
                <td><?php echo date("d-m-Y",strtotime($row->purchase_invoice_date));?></td>
                <td><?php echo $row->vendor_name;?></td>
                <td align="right"><?php echo $row->sale_number;?></td>
                <td align="right"><?php echo $row->totalbags;?></td>
                <td align="right"><?php echo $row->totalkgs;?></td>
                <td align="right"><?php echo $row->tea_value;?></td>
                <td align="right"><?php echo $row->brokerage;?></td>
                <td align="right"><?php  if($row->totalTbCharges==0){echo number_format(0,2);}else{ echo $row->totalTbCharges;}?></td>
                <td align="right"><?php echo $row->service_tax;?></td>
                <td><?php echo $row->tax_type;?>:<?php echo $row->tax;?> </td>
                <td align="right"><?php echo $row->stamp;?></td>
                <td align="right"><?php echo $row->total;?></td>
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












    
    
