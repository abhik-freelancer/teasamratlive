<div id="rawmaterialDetails_0_<?php echo($divnumber); ?>" class="rawmaterialdetails">
    <table class="table table-condensed table-bordered">

        <tbody>
            <tr class="success">
                <td><input type="text" name="txtHSNNumber[]"  id="txtHSNNumber_0_<?php echo($divnumber); ?>" class="hsn" placeholder="HSN" style="width:100px;"/></td>
                <td>
                    <select name="productlist[]" id="productlist_0_<?php echo($divnumber); ?>" style="width:175px;" class="productlist"> 
                        <option value="0">Select Services</option>
                        <?php foreach ($productlist as $rows) { ?>
                            <option value="<?php echo($rows['productid']); ?>">
                                <?php echo($rows['productdescript']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <input type="text" class="pacQty"  id="txtDetailQuantity_0_<?php echo($divnumber); ?>"  name="txtDetailQuantity[]"  placeholder="Quantity(Kg)" onkeyup="checkNumeric(this);" style="width:100px;"/>
                </td>
                <td>
                    <input type="text" class="rate" id="txtDetailRate_0_<?php echo($divnumber); ?>" 
                           name="txtDetailRate[]" placeholder="Rate" style="width:100px;"
                           onkeyup="checkNumeric(this);"/>
                </td>
                <td>
                    <input type="text" class="amount" 
                           id="txtDetailAmount_0_<?php echo($divnumber); ?>" 
                           name="txtDetailAmount[]" placeholder="Amount" style="width:100px;"
                           readonly/>
                </td>
                <td>
                    <input type="text" class="discamount" 
                           id="txtDiscount_0_<?php echo($divnumber); ?>"
                           name="txtDiscount[]" placeholder="Discount" style="width:100px;" />
                </td>
                <td>
                    <input type="text" class="taxableamount" id="txtTaxableAmt_0_<?php echo($divnumber); ?>"
                           name="txtTaxableAmt[]" placeholder="Taxable" style="width:100px;"/>
                </td>

            </tr>
            <tr class="danger">
                <td>
                    <select name="cgst[]" id="cgst_0_<?php echo($divnumber); ?>" style="width:100px;" class="cgst"> 
                        <option value="0">CGST</option>
                        <?php foreach ($cgstrate as $rows) { ?>
                            <option value="<?php echo($rows['id']); ?>">
                                <?php echo($rows['gstDescription']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <input type="text" id="cgstAmt_0_<?php echo($divnumber); ?>" name="cgstAmt[]" style="width: 90px;" class="cgstAmt">
                </td>
                <td>
                    <select name="sgst[]" id="sgst_0_<?php echo($divnumber); ?>" style="width:100px;" class="sgst"> 
                        <option value="0">SGST</option>
                        <?php foreach ($sgstrate as $rows) { ?>
                            <option value="<?php echo($rows['id']); ?>">
                                <?php echo($rows['gstDescription']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <input type="text" id="sgstAmt_0_<?php echo($divnumber); ?>" name="sgstAmt[]" style="width: 90px;" class="sgstAmt">
                </td>
                <td>
                    <select name="igst[]" id="igst_0_<?php echo($divnumber); ?>" style="width:100px;" class="igst"> 
                        <option value="0">IGST</option>
                        <?php foreach ($igstrate as $rows) { ?>
                            <option value="<?php echo($rows['id']); ?>">
                                <?php echo($rows['gstDescription']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <input type="text" id="igstAmt_0_<?php echo($divnumber); ?>" name="igstAmt[]" style="width: 90px;" class="igstAmt">
                </td>
                
                <!--Service accountid-->
                <td>
                    <select name="account[]" id="account_0_<?php echo($divnumber); ?>" style="width:175px;" class="accountlist"> 
                        <option value="0">Service account</option>
                        <?php foreach ($serviceaccount as $rows) { ?>
                            <option value="<?php echo($rows->amid); ?>">
                                <?php echo($rows->account_name); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <img class="del" src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" title="Delete" 
                         style="cursor: pointer; cursor: hand;"   id="del_0_<?php echo($divnumber); ?>" />
                </td>



            </tr>
        </tbody>
    </table>
</div>


