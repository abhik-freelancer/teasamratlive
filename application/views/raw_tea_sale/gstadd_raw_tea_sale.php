<script src="<?php echo base_url(); ?>application/assets/js/gstaddRawTeaSale.js"></script> 
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />

<!-- Table goes in the document BODY -->

<style>
 .custom-select {
    position: relative;
    width: 238px;
    height:25px;
    line-height:10px;
    font-size: 9px;
    
 
}
.custom-select a {
  display: block;
  width: 238px;
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
    width: 221px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 9px;
}
</style>
    
<h2><font color="#5cb85c">Add Garden Tea(Sale)</font></h2>
<form action="" method="post" id="frmAddRawsaleTea">
<div id="purchaseMaster" align="center">
<table class="masterTable" width="80%" align="center">
  <tr>
    <td colspan="4">&nbsp;
    <!-- Mode of operation and blending Id-->
    <input type="hidden" name="txtModeOfOperation" id="modeofoperation" value="<?php echo($header['mode']);?>"/>
    <input type="hidden" name="txtrawTeaSaleMastId" id="txtrawTeaSaleMastId" value="<?php echo ($header['rawteasaleMastId']);?>"/>
    
    </td>
  </tr>
   <tr>
       <td width="10%">Invoice No</td>
       <td width="20%">
           <input type="text" name="invoice_no" id="invoice_no" class="invoice_no" value="" style="width:240px;" disabled="disable" />
       </td>
       <td width="10%">Sale Date</td>
       <td width="20%"><input type="text" class="datepicker" name="saleDt" id="saleDt" value=""/></td>
        
   </tr>
   <tr>
      <td width="10%">Customer</td>
        <td width="20%">
            <select name="customer" id="customer" class='custom-select'> 
                <option value="0">Select</option>
                <?php foreach ($header['customerlist'] as $content) : ?>
                <option value="<?php echo $content->vid; ?>"><?php echo $content->customer_name; ?></option>
                <?php endforeach; ?>
            </select>
             <div id="customer_err" style="margin-left: 245px;margin-top:-18px;display:none;"><img src="<?php echo base_url(); ?>application/assets/images/vendor_validation.gif" /></div>
        </td>
        <td width="20%">Vehichle No</td>
        <td width="20%"><input type="text" name="vehichleno" id="vehichleno" /></td>
   </tr>
  <tr>
      <td>Place of supply</td>
      <td><input type="text" id="txtplaceofsupply" name="txtplaceofsupply" value="" style="width:240px;"/></td>
      <td>&nbsp;</td>      <td>&nbsp;</td>

  </tr>
</table>
    
</div>
    <div style="padding-top: 25px;padding-bottom: 25px;"></div>
<div class="well well-large">
<table width="100%" border="0">
  <tr>
    <td>
        <select style=" width: 200px;" id="dropdown-garden">
            <option value="0">--Select Garden--</option>
            <?php foreach ($header['garden'] as $content){ ?>
            <option value="<?php echo($content->id); ?>"> <?php echo($content->garden_name) ?></option>
            <?php } ?>
        </select>
    </td>
    <td>
        <div id="drpInvoice">
        
             <select style=" width: 200px;" id="dropdown-invoice">
                <option value="0">--Select Invoice--</option>
             </select>
            <img src="<?php echo base_url(); ?>application/assets/images/small-loader.gif" id="imgInvoice" style="display:none"/>
         </div> 
        
    </td>
    <td>
        <div id="drpLot">
            <select style=" width: 200px;" id="dropdown-lot">
            <option value="ALL">--Select Lot--</option>
            </select>
            <img src="<?php echo base_url(); ?>application/assets/images/small-loader.gif" id="imgLot" style="display:none"/>
        </div>    
    </td>
    <td>
        <div id="drpGrade">
            <select style=" width: 200px;" id="dropdown-grade">
             <option value="0">--Select Grade--</option>
            </select>
            <img src="<?php echo base_url(); ?>application/assets/images/small-loader.gif" id="imgGrade" style="display:none"/>
        </div>    
    </td>
    
    <td> <img src="<?php echo base_url(); ?>application/assets/images/view.png" title="Show" id="viewStock" style=" cursor: pointer;"/></td>
  </tr>
</table>
    
</div>
<!-- massage for exist id in table-->
<div id="dialog-for-id-in-table" title="Raw Tea Sale" style="display:none;">
       <span> This combination already in table. </span>
</div>
    
<!--details will be added here-->

<section id="loginBox">
    <div id="dialog-for-no-stock" title="Raw Tea Sale" style="display:none;">
       <span> 
           <img src="<?php echo base_url(); ?>application/assets/images/out-of-stock.png" />
           Out of stock. </span>
    </div>
    
    <div id="dialog-for-noDtl" title="Raw Tea Sale" style="display:none;">
       <span> 
           Please select data for sale.
       </span>
    </div>
    
        <div id='stockDiv' >
              <div id="stock_loader" style="display:none; margin-left:450px;">
              <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" />
              </div>
        </div>
    
</section>
 <section id="loginBox">
   <table width="100%" border="0"   class="table-condensed">
  <tr>
    <td>Total Sale Bag</td>
    <td><input type="text" id="txtTotalSaleBag" name="txtTotalSaleBag" value="" style="text-align:right;"/></td>
    <td>CGST</td>
    <td><input type="text" id="txtTotalCGST" name="txtTotalCGST"  value="" style="text-align:right;"/> </td>
  </tr>
  <tr>
    <td>Total Sale(Kgs)</td>
    <td><input type="text" id="txtSaleOutKgs" name="txtSaleOutKgs" value="" style="text-align:right;"/></td>
    <td>SGST</td>
    <td><input type="text" id="txtTotalSGST" name="txtTotalSGST"  value="" style="text-align:right;"/></td>
  </tr>
  
  <tr>
    <td>Total Amount</td>
    <td><input type="text" id="txtTotalSalePrice" name="txtTotalSalePrice" value="" style="text-align:right;"/></td>
    <td>IGST</td>
    <td><input type="text" id="txtTotalIGST" name="txtTotalIGST"  value="" style="text-align:right;"/></td>
  </tr>
  <tr>
    <td>Discount</td>
    <td><input type="text" id="txtDiscountAmount" name="txtDiscountAmount" value="" style="text-align:right;"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td>Taxable Amount</td>
      <td><input type="text" id="txtGstTaxableAmt" name="txtGstTaxableAmt" value="" style="text-align:right;"/></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
  </tr>
  <tr>
      <td>Tax(GST)Incl.</td>
      <td><input type="text" id="txtTotalIncldTaxAmt" name="txtTotalIncldTaxAmt" value="" style="text-align:right;"/></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
  </tr>
  
  
  
  <tr>
    <td>Round off</td>
    <td><input type="text" id="txtRoundOff" name="txtRoundOff" value="" style="text-align:right;"/></td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  
  <tr>
    <td>Total</td>
    <td><input type="text" id="txtGrandTotal" name="txtGrandTotal" value="" style="text-align:right;"/></td>
    <td></td>
    <td></td>
  </tr>
  
  
</table>
</section>
    

    
    
    
   <div id="dialog-new-save" title="Raw Tea Sale" style="display:none;">
       <span> Data save successfully..</span>
   </div>
   <div id="dialog-error-save" title="Raw Tea Sale" style="display:none;">
       <span> Error in save..</span>
   </div> 
   <div id="dialog-validation-save" title="Raw Tea Sale" style="display:none;">
       <span> Validation Fail..</span>
   </div>  
<div id="check_rawtea_invoiceno"  style="display:none" title="Raw Tea Sale">
    <span>This Invoice No already exist</span>
</div>
    
<!-- Details HTML dynamically added here-->



<span class="buttondiv">
          <div class="save" id="saveRawsaleTea" align="center" style="display:block;">Save</div>
</span>
     
</form>

