<script src="<?php echo base_url(); ?>application/assets/js/GSTservicePurchase.js"></script>
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
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #CCFFCC;
}
#addnewDtlDiv{
    cursor:pointer;
}
.textStyle{
    border:1px solid green;
    border-radius:5px;
    width:250px;
}
.selectStyle{
    border-top:1px solid green;
    border-left:1px solid green;
    border-bottom:1px solid green;
    border-radius:5px;
}
.textstyleBottom{
     border:1px solid green;
    border-radius:5px;
    width:150px;
}
.custom-select {
    position: relative;
    width: 250px;
    height:25px;
    line-height:10px;
  font-size: 9px;
  border:1px solid green;
  border-radius:5px ;
    
 
}
.custom-select a {
  display: block;
  width: 250px;
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
.custom-select div ul li:hover{
    background:#6C8E68;
    transition:.5s;
    color:#fff;
}

.custom-select input {
    width: 235px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 9px;
}
</style>

<?php if($header['mode']=="Add"){?>
<h2><font color="#5cb85c">Add Service Purchase(GST)</font></h2>
<?php }else{?>
<h2><font color="#5cb85c">Edit Service Purchase (GST)</font></h2>
<?php }?>

 <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2">
       
    </div>
    <div class="col-md-2">
         <a href="<?php echo base_url(); ?>gstservicepurchase/gstServicePurchaseAdd" class="btn btn-info" role="button">Add new</a>
        <a href="<?php echo base_url(); ?>gstservicepurchase" class="btn btn-info" role="button">List</a>
    </div>
    
 </div>

<form id="frmRawMaterial" name="frmRawMaterial" method="post">
<section id="loginBox" style="height: 350px;">
<table width="100%" border="0">
 <tr>
    
    <td>
        <input type="hidden" id="txtModeOfoperation" name="txtModeOfoperation" value="<?php echo($header['mode']);?>"/>
        <input type="hidden" id="rawmatPurcMastid" name="rawmatPurcMastid" value="<?php echo($header['rowmaterialmasterid']); ?>"/>
     </td>
    <td>&nbsp;</td>
 </tr>
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
    <td><label>Invoice No.</label>&nbsp;</td>
    <td><input type="text"  id="invoiceno" name="invoiceno" class="textStyle" value="<?php echo $bodycontent['rawpurchaseMaster']['invoice_no'];?>"/></td>
    <td>&nbsp;</td>
    <td><label>Invoice Date</label>&nbsp;</td>
    <td><input type="text" name="invoicedate" id="invoicedate" class="datepicker textStyle" value="<?php //echo $bodycontent['rawpurchaseMaster']['Invoicedate'];
    if($bodycontent['rawpurchaseMaster']['Invoicedate']){echo $bodycontent['rawpurchaseMaster']['Invoicedate'];}else{echo date('d-m-Y');}
    ?>" /></td>
  </tr>
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
    <td><label>Challan No.</label>&nbsp;</td>
    <td><input type="text"  id="challanno" name="challanno" class="textStyle" value="<?php echo $bodycontent['rawpurchaseMaster']['challan_no'];?>"/></td>
    <td>&nbsp;</td>
    <td><label>Challan Date</label>&nbsp;</td>
    <td>
    	 <input type="text" name="challandate" id="challandate" class="datepicker textStyle" value="<?php echo $bodycontent['rawpurchaseMaster']['ChalanDt'];?>" />
    </td>
  </tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr>
    <td><label>Order No.</label>&nbsp;</td>
    <td><input type="text" id="orderno" name="orderno" class="textStyle" value="<?php echo $bodycontent['rawpurchaseMaster']['order_no'];?>"/></td>
    <td>&nbsp;</td>
    <td><label>Order Date</label>&nbsp;</td>
    <td>
    	 <input type="text" name="orderdate" id="orderdate" class="datepicker textStyle" value="<?php echo $bodycontent['rawpurchaseMaster']['OrderDt'];?>" />
    </td>
  </tr>
   <tr><td colspan="5">&nbsp;</td></tr>
 
   <!---
   <tr>
    <td><label>Excise Invoice No.</label>&nbsp;</td>
    <td><input type="text" id="exciseinvno" name="exciseinvno" class="textStyle" value="<?php echo $bodycontent['rawpurchaseMaster']['excise_invoice_no'];?>"/></td>
    <td>&nbsp;</td>
    <td><label>Excise Date</label>&nbsp;</td>
    <td>
    	 <input type="text" name="excisedate" id="excisedate" class="datepicker textStyle" value="<?php echo $bodycontent['rawpurchaseMaster']['ExciseDt'];?>" />
    </td>
  </tr>
  -->
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr>
    <td><label>Vendor</label>&nbsp;</td>
    <td>
        <select name="vendor" id="vendor" class="custom-select ">
            <option value="0">Select Vendor Name</option>
            <?php foreach ($header['vendor'] as $content) : ?>
                            <option value="<?php echo $content->vid; ?>" <?php if($bodycontent['rawpurchaseMaster']['vendor_id']==$content->vid){echo("selected");}else{echo('');} ?>><?php echo $content->vendor_name; ?></option>
                        <?php endforeach; ?>
        </select>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
  			<td colspan="8">
            	<span class="buttondiv">
          				<div class="save" id="addnewDtlDiv" align="center">Add Details</div>
      			</span>
            </td>
  </tr>
</table>
</section>
<!--detail data will be added here -->

             
<section id="loginBox" class="rawmaterialDtlview">
    <?php if($bodycontent['rawpurchaseDetail']){
    
     foreach ($bodycontent['rawpurchaseDetail'] as $content){
    ?>
    
    <div id="rawmaterialDetails_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>" class="rawmaterialdetails">
           <table class="table table-condensed table-bordered">
               <tbody>
                        <tr class="success">
                        <td>
                        <input type="text" name="txtHSNNumber[]"  
                               id="txtHSNNumber_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>" 
                               class="hsn" placeholder="HSN" 
                               value="<?php echo($content['HSN']);?>"
                               style="width:100px;"/>
                        </td>
                        <td>       
                            
                        <select name="productlist[]" id="productlist_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>" style="width:175px;"> 
                        <option value="0">Select Product</option>
                        <?php foreach($header['productlist'] as $rows){?>
                        <option value="<?php echo($rows['productid']);?>" <?php if($content['productid']==$rows['productid']){echo("selected");}else{echo('');} ?>>
                            <?php echo($rows['productdescript']);?>
                        </option>
                        <?php } ?>
                        </select>
                        </td>
                       
                        <td><input type="text" class="pacQty" id="txtDetailQuantity_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>" name="txtDetailQuantity[]" value="<?php echo($content['quantity']);?>" placeholder="Quantity(Kg)" onkeyup="checkNumeric(this);"/></td>
                        <td ><input type="text" class="rate" id="txtDetailRate_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>" name="txtDetailRate[]" value="<?php echo($content['rate']);?>" placeholder="Rate" onkeyup="checkNumeric(this);"/></td>
                        <td ><input type="text" class="amount" id="txtDetailAmount_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>" name="txtDetailAmount[]" value="<?php echo($content['amount']);?>" placeholder="Amount" readonly/></td>
                        
                         <td>
                            <input type="text" class="discamount" 
                                   id="txtDiscount_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>"
                                   value="<?php echo($content['gstdiscount']);?>"
                                   name="txtDiscount[]" placeholder="Discount" style="width:100px;" />
                        </td>
                        
                        <td>
                            <input type="text" class="taxableamount" 
                                   id="txtTaxableAmt_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>"
                                   value="<?php echo($content['gstTaxableamount']);?>"
                                   name="txtTaxableAmt[]" placeholder="Taxable" style="width:100px;"/>
                        </td>
                        </tr>
                        
                         <tr class="danger">
                         <td>
                            <!--cgstrate-->
                            <select name="cgst[]" id="cgst_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>" style="width:100px;" class="cgst"> 
                                <option value="0">CGST</option>
                                <?php foreach ($header['cgstrate'] as $rows) { ?>
                                    <option value="<?php echo($rows['id']); ?>" <?php echo($rows['id']==$content['cgstRateId']?"selected":""); ?>>
                                        <?php echo($rows['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            
                            
                        </td>
                        <td>
                            <input type="text" id="cgstAmt_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>" 
                                   name="cgstAmt[]" style="width: 90px;" class="cgstAmt" value="<?php echo($content['cgstamt']);?>">
                        </td>
                        <td>
                            <select name="sgst[]" id="sgst_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>" style="width:100px;" class="sgst"> 
                                <option value="0">SGST</option>
                                <?php foreach ($header['sgstrate'] as $rows) { ?>
                                    <option value="<?php echo($rows['id']); ?>" <?php echo($rows['id']==$content['sgstRateId']?"selected":""); ?>>
                                        <?php echo($rows['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            
                        </td>
                        <td>
                            <input type="text" id="sgstAmt_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>" 
                                   name="sgstAmt[]" style="width: 90px;" 
                                   value="<?php echo($content['sgstamt']);?>"
                                   class="sgstAmt">
                        </td>
                        
                        <td >
                            <select name="igst[]" id="igst_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>" style="width:100px;" class="igst"> 
                                <option value="0">IGST</option>
                                <?php foreach ($header['igstrate'] as $rows) { ?>
                                    <option value="<?php echo($rows['id']); ?>" <?php echo($rows['id']==$content['igstRateId']?"selected":""); ?>>
                                        <?php echo($rows['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                           
                        </td>
                        <td>
                             <input type="text" id="igstAmt_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>"
                                   name="igstAmt[]" style="width: 90px;" 
                                   value="<?php echo($content['igstamt']);?>"
                                   class="igstAmt">
                        </td>
                        
                        
                        <td>
                            
                            <select name="account[]" id="account_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>" style="width:175px;" class="accountlist"> 
                                <option value="0">Service account</option>
                                <?php foreach ($header["serviceaccount"] as $rows) { ?>
                                    <option value="<?php echo($rows->amid); ?>" <?php echo($rows->amid==$content['serviceaccountId']?"selected":""); ?>>
                                        <?php echo($rows->account_name); ?>
                                    </option>
                                <?php } ?>
                             </select>
                            <img class="del" src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" title="Delete" style="cursor: pointer; cursor: hand;" 
                                 id="del_<?php echo($content['rawPurchMastid']);?>_<?php echo($content['rawPurDtlId']); ?>" />
                        </td>
                        <!--GST rates-->
                            
                        </tr>
               </tbody>   
                        
            </table>
    </div>
<?php }
}
?>
</section>


<div id="rawmaterial_save_dialg"  style="display:none" title="Raw Material Purchase">
    <span>Data successfully save.</span>
</div>

<div id="rawmaterial_save_dialg_detail" style="display:none" title="Raw Material Purchase">
    <span>Invalid row in detail..</span>
</div>





<!--detail data will be added here -->
<section id="loginBox" style="width: 690px; height: 260px;">
<table width="100%" border="0"   class="table-condensed">
    
 <tr>
    <td>Total Amount</td>
    <td>
        <input type="text" id="txtTotalAmount" 
               class="textstyleBottom" name="txtTotalAmount" 
               value="<?php echo  $bodycontent['rawpurchaseMaster']['item_amount']?>" readonly=""/>
    </td>
    <td>CGST</td>
    <td>
        <input type="text" id="txtTotalCGST" name="txtTotalCGST" class="textstyleBottom" 
               value="<?php echo  $bodycontent['rawpurchaseMaster']['totalCGST']?>" readonly="readonly" />
    </td>
  </tr>
  
  <tr>
      <td>Discount</td>
      <td>
          <input type="text" id="txtDiscountAmount" name="txtDiscountAmount" class="textstyleBottom" 
                 value="<?php echo  $bodycontent['rawpurchaseMaster']['GST_Discountamount']?>" readonly="readonly"/>
       </td>
        <td>SGST</td>
      <td>
          <input type="text" id="txtTotalSGST" name="txtTotalSGST" 
                  value="<?php echo  $bodycontent['rawpurchaseMaster']['totalSGST']?>" readonly="readonly" class="textstyleBottom"/></td>
    
    
  </tr>

  <tr>
    <td>
        Taxable
    </td>
    <td>
        <input type="text" id="txtTaxAmount" name="txtTaxAmount" class="textstyleBottom" 
               value="<?php echo  $bodycontent['rawpurchaseMaster']['GST_Taxableamount']?>"/>	
    </td>
    <td>IGST</td>
    <td>
        <input type="text" id="txtTotalIGST" 
               name="txtTotalIGST" value="<?php echo($bodycontent['rawpurchaseMaster']['totalIGST']); ?>" 
               readonly="readonly" class="textstyleBottom"/>
    </td>
  </tr>
  
  <tr>
    <td>
         Tax(GST) Incl. 
    </td>
    <td>
        <input type="text" class="textstyleBottom" id="txtTotalIncldTaxAmt" name="txtTotalIncldTaxAmt" 
                           value="<?php echo($bodycontent['rawpurchaseMaster']['GST_Totalgstincluded']); ?>"/>	
    </td>
    <td></td>
    <td>
        
    </td>
  </tr>
  
  
  
  
  
 
  
  <tr>
    <td>Invoice Value</td>
    <td><input type="text" id="txtInvoiceValue" name="txtInvoiceValue" class="textstyleBottom" value="<?php echo  $bodycontent['rawpurchaseMaster']['invoice_value']?>"/></td>
    <td></td>
    <td></td>
  </tr>
  
  
</table>


</section>

<span class="buttondiv">
<div class="save" id="saveRawMaterial" align="center">Save</div>
 <div id="stock_loader" style="display:none; margin-left:450px;">
         <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" />
 </div>
</span>
</form>

