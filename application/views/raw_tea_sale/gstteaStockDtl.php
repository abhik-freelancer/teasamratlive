<!-- Table goes in the document BODY -->
<?php if($groupStock){ ?>
<div id="stockDetail_<?php echo($divnumber);?>">
    <table class="CSSTableGenerator" >
    <tr>
        <td width="10%">Invoice</td>
        <td width="10%">Group</td>
        <td width="10%">Grade</td>
        <td width="5%">Garden</td>
        <td width="5%">Bag in Stock</td>
        <td width="5%">net(Kgs)</td>
        <td width="5%">Cost Of Tea</td>
        <td width="5%">Stock in Kgs.</td>
        <td width="5%">No of Sale bag</td>
        <td width="5%">Kgs</td>
        <td width="5%">Rate</td>
        <td width="5%">Amount</td>
        <td width="5%">Discount</td>
        <td>Amount
            <img src="<?php echo base_url(); ?>application/assets/images/error-AB.png" title="Delete" id="delTable" 
                 onclick="deleteTable(<?php echo($divnumber);?>);" style=" cursor: pointer;"/>
        </td>
    </tr>
    <?php foreach ($groupStock as $rows){ ?>
        <tr>
            <td>
                <?php echo($rows['Invoice']); ?>
                <input type="hidden" id="BagDtlId_<?php echo($rows['PbagDtlId']); ?>" name="txtBagDtlId[]" value="<?php echo($rows['PbagDtlId']); ?>"/>
                <input type="hidden" id="purDtlId" name="txtpurchaseDtl[]" value="<?php echo($rows['purchaseDtl']);?>"/>
                <input type="hidden" id="txtnetinBag" name="txtnetinBag[]" value="<?php echo($rows['BagNet']); ?>"/>
            </td>
            <td><?php echo($rows['Group']); ?></td>
            <td><?php echo($rows['Grade']); ?></td>
            <td><?php echo($rows['Garden']); ?></td>
            <td align="right">
                <?php echo($rows['Numberofbags']);?>
                <input type="hidden" id="NumberOfBags_<?php echo($rows['PbagDtlId']); ?>" name="txtNumberOfBags[]" value="<?php echo($rows['Numberofbags']);?>"/>
            
            </td>
            <td align="right">
                <?php echo($rows['kgperbag']);?>
                 <input type="hidden" id="hdnetBag_<?php echo($rows['PbagDtlId']);?>" name="hdnetBag" value="<?php echo($rows['kgperbag']); ?>"/>
            
            </td>
            <td align="right">
                <?php  echo($rows['pricePerBag']);?>
                <input type="hidden" id="hdpriceperbag_<?php echo($rows['PbagDtlId']);?>" name="hdpriceperbag" value="<?php echo($rows['pricePerBag']);?>"/>
            </td>
            <td align="right">
                <?php echo($rows['NetBags']);?>
            </td>
            <td align="center">
                <input type="text" id="txtused_<?php echo($rows['PbagDtlId']); ?>" name="txtused[]" class="usedBag" 
                       style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" value="" onkeypress="checkNumeric(this);"/>
            </td>
            
             <td align="right" >
                <input type="text" id="txtBlendKg_<?php echo($rows['PbagDtlId']); ?>" name="txtBlendKg[]" disabled="disabled" value="" style="border: 1px solid #008000; color: #480091; width: 70px;border-radius:5px; text-align: right;"/>
            </td>       
            
            <!--blended cost-->
            <td align="center">
                <input type="text" id="txtrate_<?php echo($rows['PbagDtlId']);?>" name="txtrate[]"  class="rate"
                       style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" value="" onkeypress="checkNumeric(this);"/>
            </td>
           <td>
                <input type="text" id="txtBlendedPrice_<?php echo($rows['PbagDtlId']); ?>" name="txtBlendedPrice[]" value="" disabled="disabled"
                      style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;width:90px;" />
           </td>
           <td>
               <input type="text" id="txtdiscount_<?php echo($rows['PbagDtlId']); ?>" name="txtdiscount[]" value="" onkeypress="checkNumeric(this);"
                      class="discount"  style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;width:90px;" placeholder="discount" />
           </td>
           <td>
               <input type="text" id="txtTotalRowAmt_<?php echo($rows['PbagDtlId']); ?>" name="txtTotalRowAmt[]" value="" placeholder="amount"
                      style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;width:90px;" disabled="disabled"/>
           </td>
           
            
            <!--blended cost-->
           
        </tr>
        <tr>
            <td colspan="2">
                <!--cgst rate-->
                <select name="cgst[]" id="cgst_<?php echo($rows['PbagDtlId']); ?>" style="width:100px;" class="cgst"> 
                                <option value="0">CGST</option>
                                <?php foreach ($cgstrate as $row) { ?>
                                    <option value="<?php echo($row['id']); ?>">
                                        <?php echo($row['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                </select>
                <input type="text"  id="cgstAmt_<?php echo($rows['PbagDtlId']); ?>" name="cgstAmt[]" style="width: 50px;" class="cgstAmt">
            </td>            
            
            <td colspan="2">
                <select name="sgst[]" id="sgst_<?php echo($rows['PbagDtlId']); ?>" style="width:100px;" class="sgst"> 
                                <option value="0">SGST</option>
                                <?php foreach ($sgstrate as $row) { ?>
                                    <option value="<?php echo($row['id']); ?>">
                                        <?php echo($row['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                </select>
                <input type="text" id="sgstAmt_<?php echo($rows['PbagDtlId']); ?>" name="sgstAmt[]" style="width: 50px;" class="sgstAmt">
            </td>
            
            <td colspan="10">
                <select name="igst[]" id="igst_<?php echo($rows['PbagDtlId']); ?>" style="width:100px;" class="igst"> 
                                <option value="0">IGST</option>
                                <?php foreach ($igstrate as $row) { ?>
                                    <option value="<?php echo($row['id']); ?>">
                                        <?php echo($row['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                </select>
                 <input type="text" id="igstAmt_<?php echo($rows['PbagDtlId']); ?>" name="igstAmt[]" style="width: 50px;" class="igstAmt">
            </td>
            
            
            

            

        </tr>
    <?php }?>
    
</table>
    <div style="padding-top: 10px;"></div>
</div>

<?php } ?>
<script>
 
function checkNumeric(obj)
{
     if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

}

</script>


