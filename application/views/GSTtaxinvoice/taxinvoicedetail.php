<style type="text/css">
table.gridtable td {
padding: 5px;
}
table.gridtable th {
padding: 5px;
}
</style>
 
<div id="salebillDetails_0_<?php echo($divnumber); ?>" class="taxinvoicedetails">
            <table width="100%" class="gridtable">
                        <tr>
                            <td width="5%">
                                <input type="text" name="txtHSNNumber[]"  id="txtHSNNumber_0_<?php echo($divnumber); ?>" class="hsn" placeholder="HSN" style="width:50px;"/>
                            </td>
                        <td width="10%">
                            <select name="finalproduct[]" id="finalproduct_0_<?php echo($divnumber); ?>" style="width:250px;" class="finalProduct"> 
                        <option value="0">Select Product</option>
                        <?php foreach($finalproduct as $rows){?>
                        <option value="<?php echo($rows['productPacketId']);?>">
                            <?php echo($rows['finalproduct']);?>
                        </option>
                        <?php } ?>
                        </select>
                        </td>
                        <td width="5%">
                        <input type="text" class="packet" id="txtDetailPacket_0_<?php echo($divnumber); ?>" name="txtDetailPacket[]" value="" placeholder="Packet"  style="width:50px;"/></td>
                        <td width="5%"><input type="text" class="net" id="txtDetailNet_0_<?php echo($divnumber); ?>" name="txtDetailNet[]" value="" placeholder="Net(Kg)"  style="width:50px;"/></td>
                        <td width="5%"><input type="text" class="pacQty" id="txtDetailQuantity_0_<?php echo($divnumber); ?>" name="txtDetailQuantity[]"  placeholder="Quantity(Kg)" readonly style="width:100px;"/></td>
                        <td width="5%"><input type="text" class="rate" id="txtDetailRate_0_<?php echo($divnumber); ?>" name="txtDetailRate[]" placeholder="Rate" style="width:50px;"/></td>
                        <td width="5%"><input type="text" class="amount" id="txtDetailAmount_0_<?php echo($divnumber); ?>" name="txtDetailAmount[]" placeholder="Amount" readonly style="width:140px;"/></td>
                        <td width="5%">
                            <input type="text" class="discount" id="txtDiscount_0_<?php echo($divnumber); ?>" name="txtDiscount[]" placeholder="Discount"  style="width:100px;"/>
                        </td>
                        <td width="5%">
                            <input type="text" class="taxableamount" id="txtTaxableAmt_0_<?php echo($divnumber); ?>" name="txtTaxableAmt[]" placeholder="Taxable" readonly="" style="width:100px;"/>
                        </td>
                        
                        <td>
                            <img class="del" src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" title="Delete" style="cursor: pointer; cursor: hand;" 
                                 id="del_0_<?php echo($divnumber); ?>" />
                        </td>
                        </tr>
                        <tr>
                         
                            
                        </td>
                        <td>
                               <td>
                            <!--cgstrate-->
                            <select name="cgst[]" id="cgst_0_<?php echo($divnumber); ?>" style="width:100px;" class="cgst"> 
                                <option value="0">CGST</option>
                                <?php foreach ($cgstrate as $rows) { ?>
                                    <option value="<?php echo($rows['id']); ?>">
                                        <?php echo($rows['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="text" id="cgstAmt_0_<?php echo($divnumber); ?>" name="cgstAmt[]" style="width: 90px;" class="cgstAmt">
                            
                        </td>
                        <td colspan="3">
                            <select name="sgst[]" id="sgst_0_<?php echo($divnumber); ?>" style="width:100px;" class="sgst"> 
                                <option value="0">SGST</option>
                                <?php foreach ($sgstrate as $rows) { ?>
                                    <option value="<?php echo($rows['id']); ?>">
                                        <?php echo($rows['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="text" id="sgstAmt_0_<?php echo($divnumber); ?>" name="sgstAmt[]" style="width: 90px;" class="sgstAmt">
                        </td>
                        
                        <td colspan="2">
                            <select name="igst[]" id="igst_0_<?php echo($divnumber); ?>" style="width:100px;" class="igst"> 
                                <option value="0">IGST</option>
                                <?php foreach ($igstrate as $rows) { ?>
                                    <option value="<?php echo($rows['id']); ?>">
                                        <?php echo($rows['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="text" id="igstAmt_0_<?php echo($divnumber); ?>" name="igstAmt[]" style="width: 90px;" class="igstAmt">
                        </td>
                        
                        <td></td>
                        <td></td>
                        <td></td>

                        </tr>
            </table>
    </div>


<script>


    




</script>