<table id="example" class="display no-wrap" cellspacing="0" width="auto" border="0">
    
<thead>
    
    <th>Customer </th>
    <th>Bill No</th>
    <th>Bill Dt</th>
    <th align="right">Qty</th>
    <th align="right">Taxable</th>
	<th align="right">CGST Amt.</th>
	<th align="right">SGST Amt.</th>
	<th align="right">IGST Amt.</th>
    <th align="right">Total GST</th>
    <th align="right">Bill Total</th>
 
   
   
</thead>
<tbody>

    <?php
    if ($get_salebill_register) {
        foreach ($get_salebill_register as $row) {
           
            ?>
            <tr>
                
                <td>
					<input type="hidden" name="salebillMastrId" value="<?php echo "salebillmasterId--".$row['salebillID']."--".$row['saleType'];?>" />
                    <?php echo $row['customerName'];?>
				</td>
                <td><?php echo $row['saleBillNo'];?></td>
                <td><?php echo date('d-m-Y',strtotime($row['saleBillDate']));?></td>
				<td align="right"><?php echo $row['totalQty'];?></td>
                <td align="right"><?php echo $row['gstTaxableAmt'];?></td>
				<td align="right"><?php echo $row['totalCGST'];?></td>
				<td align="right"><?php echo $row['totalSGST'];?></td>
				<td align="right"><?php echo $row['totalIGST'];?></td>
                <td align="right"><?php echo $row['totalCGST']+$row['totalSGST']+$row['totalIGST'];?></td>
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












    
    
