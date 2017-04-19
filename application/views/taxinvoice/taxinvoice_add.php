<script src="<?php echo base_url(); ?>application/assets/js/taxInvoiceAdd.js"></script>
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


<?php if($header['mode']=="Add"){?>
<h2><font color="#5cb85c">Add Sale Bill</font></h2>
<?php }else{?>
<h2><font color="#5cb85c">Edit Sale Bill</font></h2>
<?php } ?>

<form id="frmSaleBill" name="frmSaleBill" method="post">
<section id="loginBox" style="height: 330px;">
<table width="100%" border="0" align="center" >
    
   
    
    
  <tr>
    <td><label>Sale Bill No.</label>&nbsp;</td>
    <td>
        <input type="hidden" id="txtModeOfoperation" name="txtModeOfoperation" value="<?php echo($header['mode']);?>"/>
        <input type="hidden" id="hdSalebillid" name="hdSalebillid" value="<?php echo($header['salebillno']); ?>"/>
        <input type="hidden" id="hdvoucherMastid" name="hdvoucherMastid" value="<?php echo($bodycontent['taxInvoiceMaster']['voucher_master_id']); ?>"/>
        <input type="text"  id="txtSaleBillNo" name="txtSaleBillNo" class="salebillNo" disabled="disable" 
               value="<?php echo($bodycontent['taxInvoiceMaster']['saleBillNo']); ?>" style="width:300px;"/>
    </td>
  </tr>
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
      <td>
          Last Sale Bill No :
      </td>
      <td><span class="label label-success"><?php echo($header['lastSalebillNo']['lastsalebillno']); ?></span></td>
  </tr>
   <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
      <td><label>Date</label>&nbsp;</td>
    <td><input type="text" name="saleBillDate" id="saleBillDate" class="datepicker" value="<?php 
    if($bodycontent['taxInvoiceMaster']['salebilldate']){ echo($bodycontent['taxInvoiceMaster']['salebilldate']);}else{echo date('d-m-Y');}
  
    
    ?>"  style="width:300px;"/></td>
  </tr>
  
  
  <tr><td colspan="5">&nbsp;</td></tr>
  
  
   <tr>
        <td><label>Customer</label>&nbsp;</td>
        <td>
            <select id="customer" name="customer" class="customer custom-select" style="width:300px;">
                    <option value="0">Select</option>
                <?php foreach($header['customer'] as $rows){?>
                    <option value="<?php echo($rows['customerId']); ?>" <?php if($bodycontent['taxInvoiceMaster']['customerid']==$rows['customerId']){echo('selected');}else{echo('');} ?>><?php echo($rows['name']); ?></option>
                <?php } ?>
            </select>
        </td>
       
        <td><input type="hidden" name="creditdays" id="creditdays" value="" /></td>
        <td></td>
    </tr>
    
    
    <tr><td colspan="5">&nbsp;</td></tr>
  
  <!--<tr>
    <td><label>Tax Invoice No.</label>&nbsp;</td>
    <td><input type="text"  id="txtTaxInvoiceNo" name="txtTaxInvoiceNo" value="<?php echo($bodycontent['taxInvoiceMaster']['taxinvoice']); ?>" readonly=""/></td>
    <td>&nbsp;</td>
    <td><label>Date</label>&nbsp;</td>
    <td><input type="text" name="taxInvoiceDate" id="taxInvoiceDate" class="datepicker" value="<?php echo($bodycontent['taxInvoiceMaster']['taxinvoicedate']); ?>" /></td>
  </tr>-->
  
  

  
  <tr>
    <td><label>Due Date</label>&nbsp;</td>
    <td><input type="text"  id="txtDueDate" name="txtDueDate" value="<?php echo($bodycontent['taxInvoiceMaster']['duedate']); ?>" class="datepicker"  style="width:300px;"/></td>
    
    
  </tr>
  
    <tr><td colspan="5">&nbsp;</td></tr>
 
   
  <tr>
    <td><label>Vehichle No:</label>&nbsp;</td>
    <td><input type="text"  id="vehichleno" name="vehichleno" value="<?php echo($bodycontent['taxInvoiceMaster']['vehichleno']); ?>"  style="width:300px;"/></td>
   
  </tr>
  
  
  <tr><td colspan="5">&nbsp;</td></tr>
  
  <tr>
    <td colspan="5">
      <span class="buttondiv"><div class="save" id="addnewDtlDiv" align="center">Add Details</div></span>
    </td>
  </tr>
</table>
</section>
<!--detail data will be added here -->

             
<section id="loginBox" class="salebillDtl">
<?php if($bodycontent['taxInvoiceDetail']){
    
     foreach ($bodycontent['taxInvoiceDetail'] as $content){
    ?>
    
    <div id="salebillDetails_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" class="taxinvoicedetails">
            <table width="100%" class="gridtable">
                        <tr>
                        <td width="30%">
                        <select name="finalproduct[]" id="finalproduct_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" style="width:200px;"> 
                        <option value="0">Select Product</option>
                        <?php foreach($header['finalproduct'] as $rows){?>
                        <option value="<?php echo($rows['productPacketId']);?>" <?php if($content['productpacketid']==$rows['productPacketId']){echo("selected");}else{echo('');} ?>>
                            <?php echo($rows['finalproduct']);?>
                        </option>
                        <?php } ?>
                        </select>
                        </td>
                        <td width="10%">
                            <input type="text" class="packet" id="txtDetailPacket_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" name="txtDetailPacket[]" value="<?php echo($content['packingbox']);?>" placeholder="Packet"/></td>
                        <td width="10%"><input type="text" class="net" id="txtDetailNet_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" name="txtDetailNet[]" value="<?php echo($content['packingnet']);?>" placeholder="Net(Kg)"/></td>
                        <td width="10%"><input type="text" class="pacQty" id="txtDetailQuantity_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" name="txtDetailQuantity[]" value="<?php echo($content['quantity']);?>" placeholder="Quantity(Kg)" readonly/></td>
                        <td width="10%"><input type="text" class="rate" id="txtDetailRate_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" name="txtDetailRate[]" value="<?php echo($content['rate']);?>" placeholder="Rate"/></td>
                        <td width="10%"><input type="text" class="amount" id="txtDetailAmount_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" name="txtDetailAmount[]" value="<?php echo($content['amount']);?>" placeholder="Amount" readonly/></td>
                        <td width="20%">
                            <img class="del" src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" title="Delete" style="cursor: pointer; cursor: hand;" 
                                 id="del_<?php echo($content['salebillmasterid']);?>_<?php echo($content['saleBillDetailId']); ?>" />
                        </td>
                        </tr>
            </table>
    </div>
<?php }
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
<section id="loginBox" style="width: 690px; height: 320px;">
<table width="100%" border="0"   class="table-condensed">
  <tr>
    <td>Total Packet</td>
    <td><input type="text" id="txtTotalPacket" name="txtTotalPacket" value="<?php echo($bodycontent['taxInvoiceMaster']['totalpacket']); ?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Total Quantity</td>
    <td><input type="text" id="txtTotalQty" name="txtTotalQty" value="<?php echo($bodycontent['taxInvoiceMaster']['totalquantity']); ?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>Total Amount</td>
    <td><input type="text" id="txtTotalAmount" name="txtTotalAmount" value="<?php echo($bodycontent['taxInvoiceMaster']['totalamount']); ?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Discount</td>
    <td><input type="text" name="txtDiscountPercentage" id="txtDiscountPercentage" value="<?php echo($bodycontent['taxInvoiceMaster']['discountRate']); ?>" />(%) </td>
    <td>Amount</td>
    <td><input type="text" id="txtDiscountAmount" name="txtDiscountAmount" value="<?php echo($bodycontent['taxInvoiceMaster']['discountAmount']); ?>"/></td>
  </tr>

  <tr>
    <td>Delivery Chgs</td>
    <td><input type="text" name="txtDeliveryChg" id="txtDeliveryChg" value="<?php echo($bodycontent['taxInvoiceMaster']['deliveryChgs']); ?>" /></td>
    <td></td>
    <td></td>
  </tr>

  <tr>
    <td>
        [Vat]<input type="radio" name="rateType" <?php if($header['mode']=='Add'){echo("checked=checked");} ?> id="rateType" value="V" <?php if($bodycontent['taxInvoiceMaster']['taxrateType']=='V'){echo("checked=checked");} ?>>
        [CST]<input type="radio" name="rateType"  id="rateType" value="C" <?php if($bodycontent['taxInvoiceMaster']['taxrateType']=='C'){echo("checked=checked");} ?>> 
    </td>
    <td>
        <div id="divVat" <?php if($header['mode']=='Add'){echo('style="display:block"');} ?>  <?php if($bodycontent['taxInvoiceMaster']['taxrateType']=='V'){echo('style="display:block"');}else{echo('style="display:none"');}?>>
        	Vat <select id="vat" name="vat">
	            	<option value="0">Select</option>
                        <?php foreach ($header['vatpercentage'] as $rows){ ?>
                        <option value="<?php echo($rows->id); ?>" <?php if($bodycontent['taxInvoiceMaster']['taxrateTypeId']==$rows->id){echo('selected');}else{echo('');}?>> <?php echo($rows->vat_rate); ?></option>
                        <?php } ?>
                </select>
        </div>
        <div id="divCst" <?php if($bodycontent['taxInvoiceMaster']['taxrateType']=='C'){echo('style="display:block"');}else{echo('style="display:none"');}?>>
        	CST <select name="cst" id="cst">
            	<option value="0">Select</option>
                <?php foreach ($header['cstRate'] as $rows){ ?>
                        <option value="<?php echo($rows->id); ?>"<?php if($bodycontent['taxInvoiceMaster']['taxrateTypeId']==$rows->id){echo('selected');}else{echo('');}?>> <?php echo($rows->cst_rate); ?></option>
                <?php } ?>
                
            </select>
        </div>	
    </td>
    <td>Tax Amount</td>
    <td><input type="text" id="txtTaxAmount" name="txtTaxAmount" value="<?php echo($bodycontent['taxInvoiceMaster']['taxamount']); ?>"/></td>
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

