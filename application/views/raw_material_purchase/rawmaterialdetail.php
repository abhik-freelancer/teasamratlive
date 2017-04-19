
 
<div id="rawmaterialDetails_0_<?php echo($divnumber); ?>" class="rawmaterialdetails">
            <table width="100%" class="gridtable">
                        <tr>
                        <td width="40%">
                            <select name="productlist[]" id="productlist_0_<?php echo($divnumber); ?>" style="width:320px;" class="productlist"> 
                        <option value="0">Select Product</option>
                       <?php foreach($productlist as $rows){?>
                        <option value="<?php echo($rows['productid']);?>">
                            <?php echo($rows['productdescript']);?>
                        </option>
                        <?php } ?>
                        </select>
                        </td>
                       
                       
                        <td width="10%"><input type="text" class="pacQty" id="txtDetailQuantity_0_<?php echo($divnumber); ?>" name="txtDetailQuantity[]"  placeholder="Quantity(Kg)" onkeyup="checkNumeric(this);"/></td>
                        <td width="10%"><input type="text" class="rate" id="txtDetailRate_0_<?php echo($divnumber); ?>" name="txtDetailRate[]" placeholder="Rate" onkeyup="checkNumeric(this);"/></td>
                        <td width="10%"><input type="text" class="amount" id="txtDetailAmount_0_<?php echo($divnumber); ?>" name="txtDetailAmount[]" placeholder="Amount" readonly/></td>
                        <td width="10%">
                            <img class="del" src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" title="Delete" style="cursor: pointer; cursor: hand;" 
                                 id="del_0_<?php echo($divnumber); ?>" />
                        </td>
                        </tr>
            </table>
    </div>


<script>


    




</script>