
<div id="bagDetail_0_<?php echo($divnumber); ?>" class="opening_invoice_detail">
            <table width="100%" class="gridtable">
                        <tr>
                        <td width="30%">
                            <select name="bagtype[]" id="bagtype_0_<?php echo($divnumber); ?>" style="width:200px;" class="bagtype"> 
                                <option value="0">Bag Type</option>
                               <?php foreach ($bagType as $bagtype){?>
                                   <option value="<?php echo($bagtype->bagid);?>"><?php echo($bagtype->bagtype)?></option>
                               <?php } ?>
                        </select>
                        </td>
                        <td width="20%">
                            <input type="text" class="noofbag" id="txtnoofbag_0_<?php echo($divnumber); ?>" name="txtnoofbag[]" value="" placeholder="No Of Bag" style="text-align:center; "/></td>
                        <td width="20%"><input type="text" class="net" id="txtDetailNet_0_<?php echo($divnumber); ?>" name="txtDetailNet[]" value="" placeholder="Net" /></td>
                        
                        
                        
                        <td width="10%">
                            <img class="del" src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" title="Delete" style="cursor: pointer; cursor: hand;" 
                                 id="del_0_<?php echo($divnumber); ?>" />
                        </td>
                        </tr>
            </table>
    </div>

