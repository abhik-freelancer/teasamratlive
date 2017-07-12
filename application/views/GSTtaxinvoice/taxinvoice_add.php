<script src="<?php echo base_url(); ?>application/assets/js/GSTtaxInvoiceAdd.js"></script>
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />

<style type="text/css">
    table.gridtable {
        font-family: verdana,arial,sans-serif;
        font-size:11px;
        color:#003399;
        border-width: 1px;
        border-color: #666666;
        border-collapse: collapse;
    }
    table.gridtable th {
        border-width: 1px;
        padding: 5px;
        border-style: solid;
        border-color: #666666;
        background-color: #dedede;
    }
    table.gridtable td {
        border-width: 1px;
        padding: 5px;
        border-style: solid;
        border-color: #666666;
        background-color: #CCFFCC;
    }
    .custom-select {
        position: relative;
        width: 298px;
        height:25px;
        line-height:10px;
        font-size: 9px;


    }
    .custom-select a {
        display: block;
        width: 298px;
        height: 25px;
        padding: 8px 6px;
        color: #000;
        text-decoration: none;
        cursor: pointer;
        font-family: "Open Sans",helvetica,arial,sans-serif;
        font-size: 9px;
    }
    .custom-select div ul li.active {
        display: block;
        cursor: pointer;
        font-size: 9px;

    }
    .custom-select input {
        width: 275px;
        font-family: "Open Sans",helvetica,arial,sans-serif;
        font-size: 9px;
    }

</style>
<div class="stats">

    <p class="stat"><a href="<?php echo base_url(); ?>GSTtaxinvoice/addTaxInvoice" class="showtooltip" title="add">
            <img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
    <p class="stat"><a href="<?php echo base_url(); ?>GSTtaxinvoice"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>

</div>

<?php if ($header['mode'] == "Add") { ?>
    <h2><font color="#5cb85c">Add Sale Bill [GST]</font></h2>
<?php } else { ?>
    <h2><font color="#5cb85c">Edit Sale Bill[GST]</font></h2>
<?php } ?>

<form id="frmSaleBill" name="frmSaleBill" method="post">
    <section id="loginBox" style="height: 300px;">
        <table width="100%" border="0" align="center" class="gridtable">

            <tr>
                <td><label>Sale Bill No.</label>&nbsp;</td>
                <td>
                    <input type="hidden" id="txtModeOfoperation" name="txtModeOfoperation" value="<?php echo($header['mode']); ?>"/>
                    <input type="hidden" id="hdSalebillid" name="hdSalebillid" value="<?php echo($header['salebillno']); ?>"/>
                    <input type="hidden" id="hdvoucherMastid" name="hdvoucherMastid" value="<?php echo($bodycontent['taxInvoiceMaster']['voucher_master_id']); ?>"/>
                    <input type="text"  id="txtSaleBillNo" name="txtSaleBillNo" class="salebillNo" readonly="readonly" 
                           value="<?php echo($bodycontent['taxInvoiceMaster']['saleBillNo']); ?>" style="width:300px;"/>
                </td>
            </tr>
            <tr>
                <td>Place of supply</td>
                <td><input type="text" name="placeofsupply" id="placeofsupply" value="<?php echo($bodycontent['taxInvoiceMaster']['GST_placeofsupply']); ?>" placeholder="Place of supply"/> </td>
            </tr>

            <tr>
                <td><label>Date</label>&nbsp;</td>
                <td><input type="text" name="saleBillDate" id="saleBillDate" class="datepicker" value="<?php
                    if ($bodycontent['taxInvoiceMaster']['salebilldate']) {
                        echo($bodycontent['taxInvoiceMaster']['salebilldate']);
                    } else {
                        echo date('d-m-Y');
                    }
                    ?>"  style="width:300px;"/></td>
            </tr>





            <tr>
                <td><label>Customer</label>&nbsp;</td>
                <td>
                    <input type="hidden" name="creditdays" id="creditdays" value="" />
                    <select id="customer" name="customer" class="customer custom-select" style="width:300px;">
                        <option value="0">Select</option>
<?php foreach ($header['customer'] as $rows) { ?>
                            <option value="<?php echo($rows['customerId']); ?>" <?php if ($bodycontent['taxInvoiceMaster']['customerid'] == $rows['customerId']) {
        echo('selected');
    } else {
        echo('');
    } ?>><?php echo($rows['name']); ?></option>
<?php } ?>
                    </select>
                </td>
            </tr>
        <tr>
                <td><label>Due Date</label>&nbsp;</td>
                <td><input type="text"  id="txtDueDate" name="txtDueDate" value="<?php echo($bodycontent['taxInvoiceMaster']['duedate']); ?>" class="datepicker"  style="width:300px;"/></td>


            </tr>




            <tr>
                <td><label>Vehichle No:</label>&nbsp;</td>
                <td><input type="text"  id="vehichleno" name="vehichleno" value="<?php echo($bodycontent['taxInvoiceMaster']['vehichleno']); ?>"  style="width:300px;"/></td>

            </tr>
			

            <tr>
                
                <td colspan="2" style="text-align: center">
                    <button type="button" class="btn btn-primary save" id="addnewDtlDiv">Add Details</button>
                </td>

            </tr>
        </table>
    </section>
    <!--detail data will be added here -->


    <section id="loginBox" class="salebillDtl">
<?php
if ($bodycontent['taxInvoiceDetail']) {

    foreach ($bodycontent['taxInvoiceDetail'] as $content) {
        ?>

                <div id="salebillDetails_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" class="taxinvoicedetails">
                    <table width="100%" class="gridtable">
                        <tr>
                            <td>
                                <input type="text" name="txtHSNNumber[]" 
                                       id="txtHSNNumber_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" 
                                       class="hsn" placeholder="HSN"  value="<?php echo($content['HSN']); ?>" style="width:50px;"/>
                            </td>    
                            <td width="30%">
                                <select name="finalproduct[]" id="finalproduct_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" style="width:250px;"> 
                                    <option value="0">Select Product</option>
        <?php foreach ($header['finalproduct'] as $rows) { ?>
                                        <option value="<?php echo($rows['productPacketId']); ?>" <?php if ($content['productpacketid'] == $rows['productPacketId']) {
                echo("selected");
            } else {
                echo('');
            } ?>>
            <?php echo($rows['finalproduct']); ?>
                                        </option>
        <?php } ?>
                                </select>
                            </td>
                            <td width="10%">
                                <input type="text" class="packet" style="width:50px;" id="txtDetailPacket_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" name="txtDetailPacket[]" value="<?php echo($content['packingbox']); ?>" placeholder="Packet"/></td>
                            <td width="10%">
                                <input type="text" class="net" style="width:50px;" id="txtDetailNet_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" name="txtDetailNet[]" value="<?php echo($content['packingnet']); ?>" placeholder="Net(Kg)"/>
                            </td>
                            <td width="10%">
                                <input type="text" style="width:100px;" class="pacQty" id="txtDetailQuantity_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" name="txtDetailQuantity[]" value="<?php echo($content['quantity']); ?>" placeholder="Quantity(Kg)" readonly/>
                            </td>
                            <td width="10%">
                                <input type="text" style="width:50px;" class="rate" id="txtDetailRate_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" name="txtDetailRate[]" value="<?php echo($content['rate']); ?>" placeholder="Rate"/>
                            </td>
                            <td width="10%">
                                <input type="text" style="width:140px;" class="amount" id="txtDetailAmount_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" name="txtDetailAmount[]" value="<?php echo($content['amount']); ?>" placeholder="Amount" readonly/>
                            </td>



                            <!--GST SECTION added -->
                            <td width="5%">
                                <input type="text" class="discount" id="txtDiscount_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" 
                                       name="txtDiscount[]" 
                                       value="<?php echo($content['discount']); ?>"
                                       placeholder="Discount"  style="width:100px;"/>
                            </td>
                            <td width="5%">
                                <input type="text" class="taxableamount"
                                       id="txtTaxableAmt_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" 
                                       name="txtTaxableAmt[]"
                                       value="<?php echo($content['taxableamount']); ?>"
                                       placeholder="Taxable" readonly="" style="width:100px;"/>
                            </td>



                            <td width="20%">
                                <img class="del" src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" title="Delete" style="cursor: pointer; cursor: hand;" 
                                     id="del_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td></td>


                            <td>
                                <!--cgstrate-->
                                <select name="cgst[]" id="cgst_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" style="width:100px;" class="cgst"> 
                                    <option value="0">CGST</option>
                                    <?php foreach ($header["cgstrate"] as $rows) { ?>
                                        <option value="<?php echo($rows['id']); ?>" <?php if ($content['cgstrateid'] == $rows['id']) {
                                echo("selected");
                            } else {
                                echo('');
                            } ?>>
            <?php echo($rows['gstDescription']); ?>
                                        </option>
        <?php } ?>
                                </select>
                                <input type="text" id="cgstAmt_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" 
                                       name="cgstAmt[]" style="width: 90px;" class="cgstAmt"
                                       value="<?php echo($content['cgstamount']); ?>" readonly />

                            </td>
                            <td colspan="3">
                                <select name="sgst[]" id="sgst_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" style="width:100px;" class="sgst"> 
                                    <option value="0">SGST</option>
                                    <?php foreach ($header["sgstrate"] as $rows) { ?>
                                        <option value="<?php echo($rows['id']); ?>" <?php if ($content['sgstrateid'] == $rows['id']) {
                                echo("selected");
                            } else {
                                echo('');
                            } ?> >
            <?php echo($rows['gstDescription']); ?>
                                        </option>
        <?php } ?>
                                </select>
                                <input type="text" id="sgstAmt_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" 
                                       name="sgstAmt[]" style="width: 90px;" class="sgstAmt" value="<?php echo($content['sgstamount']); ?>" readonly />
                            </td>

                            <td colspan="2">
                                <select name="igst[]" id="igst_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" style="width:100px;" class="igst"> 
                                    <option value="0">IGST</option>
        <?php foreach ($header["igstrate"] as $rows) { ?>
                                        <option value="<?php echo($rows['id']); ?>" 
            <?php if ($content['igstrateid'] == $rows['id']) {
                echo("selected");
            } else {
                echo('');
            } ?>>
            <?php echo($rows['gstDescription']); ?>
                                        </option>
        <?php } ?>
                                </select>
                                <input type="text" id="igstAmt_<?php echo($content['salebillmasterid']); ?>_<?php echo($content['saleBillDetailId']); ?>" 
                                       name="igstAmt[]" style="width: 90px;" value="<?php echo($content['igstamount']); ?>" class="igstAmt" readonly >
                            </td>

                            <td></td>
                            <td></td>
                            <td></td>

                        </tr>
                    </table>
                </div>
    <?php
    }
}
?>
    </section>

    <div id="sale_bil_save_dilg"  style="display:none" title="Taxinvoice">
        <span>Data successfully save.</span>
    </div>
    <div id="check_salebill_no"  style="display:none" title="Taxinvoice">
        <span>This Salebill No already exist</span>
    </div>

    <div id="salebil_error_save_dilg" style="display:none" title="Taxinvoice">
        <span>Fail to save the data.</span>
    </div>

    <div id="salebil_detail_error" style="display:none" title="Taxinvoice">
        <span>Invalid row in detail..</span>
    </div>
    <div id="salebil_detail_validation_fail" style="display:none" title="Taxinvoice">
        <span>Validation Fail..</span>
    </div>



    <!--detail data will be added here -->
    <section id="loginBox" style="width: 690px; height: 400px;">
        <table width="100%" border="0"   class="gridtable">
            <tr>
                <td>Total Packet</td>
                <td><input type="text" style="background-color: #dedede" id="txtTotalPacket" 
                           name="txtTotalPacket" value="<?php echo($bodycontent['taxInvoiceMaster']['totalpacket']); ?>" readonly="readonly"/></td>
                <td>CGST</td>
                <td><input type="text" id="txtTotalCGST" name="txtTotalCGST" value="<?php echo($bodycontent['taxInvoiceMaster']['totalCGST']); ?>" readonly="readonly" /></td>
            </tr>
            <tr>
                <td>Total Quantity</td>
                <td><input type="text" style="background-color: #dedede" id="txtTotalQty" readonly="readonly" name="txtTotalQty"
                           value="<?php echo($bodycontent['taxInvoiceMaster']['totalquantity']); ?>"/></td>
                <td>SGST</td>
                <td><input type="text" id="txtTotalSGST" name="txtTotalSGST" value="<?php echo($bodycontent['taxInvoiceMaster']['totalSGST']); ?>" readonly="readonly"/></td>
            </tr>

            <tr>
                <td>Total Amount</td>
                <td><input type="text" style="background-color: #dedede" readonly="readonly" id="txtTotalAmount" name="txtTotalAmount" value="<?php echo($bodycontent['taxInvoiceMaster']['totalamount']); ?>"/></td>
                <td>IGST</td>
                <td><input type="text" id="txtTotalIGST" name="txtTotalIGST" value="<?php echo($bodycontent['taxInvoiceMaster']['totalIGST']); ?>" readonly="readonly"/></td>
            </tr>
            <tr>
              <!--<td>Discount</td>
              <td><input type="text" name="txtDiscountPercentage" id="txtDiscountPercentage" value="<?php echo($bodycontent['taxInvoiceMaster']['discountRate']); ?>" />(%) </td>-->

                <td><label>Discount amount</label></td>
                <td><input type="text" id="txtDiscountAmount" name="txtDiscountAmount" style="background-color: #dedede"
                           value="<?php echo($bodycontent['taxInvoiceMaster']['GST_Discountamount']); ?>" readonly="readonly"/></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td>Taxable amount</td>
                <td><input type="text" name="txtTaxableAmount" style="background-color: #dedede" readonly="readonly" id="txtTaxableAmount" 
                           value="<?php echo($bodycontent['taxInvoiceMaster']['GST_Taxableamount']); ?>" /></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>

                    Total(Incl.GST)
                </td>
                <td>
                    <input type="text" id="txtTotalIncldTaxAmt" name="txtTotalIncldTaxAmt" 
                           value="<?php echo($bodycontent['taxInvoiceMaster']['GST_Totalgstincluded']); ?>"/>

                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Freight</td>
                <td><input type="text" id="txtFreight" name="txtFreight" value="<?php echo($bodycontent['taxInvoiceMaster']['GST_Freightamount']); ?>"/></td>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td>Insurance</td>
                <td><input type="text" id="txtInsurance" name="txtInsurance" value="<?php echo($bodycontent['taxInvoiceMaster']['GST_Insuranceamount']); ?>"/></td>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td>P & F charges</td>
                <td><input type="text" id="txtPckFrw" name="txtPckFrw" value="<?php echo($bodycontent['taxInvoiceMaster']['GST_PFamount']); ?>"/></td>
                <td>&nbsp;</td>
                <td></td>
            </tr>



            <tr>
                <td>Round off</td>
                <td><input type="text" id="txtRoundOff" name="txtRoundOff" value="<?php echo($bodycontent['taxInvoiceMaster']['roundoff']); ?>"/></td>
                <td>&nbsp;</td>
                <td></td>
            </tr>

            <tr>
                <td>Total</td>
                <td><input type="text" id="txtGrandTotal" name="txtGrandTotal" value="<?php echo($bodycontent['taxInvoiceMaster']['grandtotal']); ?>"/></td>
                <td></td>
                <td></td>
            </tr>


        </table>


    </section>

    <span class="buttondiv">
        <div class="save" id="saveSaleBill" align="center">Save</div>
        <div id="stock_loader" style="display:none; margin-left:450px;">
            <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" />
        </div>
    </span>
</form>

