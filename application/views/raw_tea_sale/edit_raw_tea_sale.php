<script src="<?php echo base_url(); ?>application/assets/js/editRawTeaSale.js"></script> 
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />
<!-- CSS goes in the document HEAD or added to your external stylesheet -->


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
.roundedCorner { width:100px;height:50px;
border: solid 1px #555;
background-color: #eed; 
box-shadow: 0 0 10px rgba(0,0,0,0.6);
-moz-box-shadow: 0 0 10px rgba(0,0,0,0.6);
-webkit-box-shadow: 0 0 10px rgba(0,0,0,0.6);
-o-box-shadow: 0 0 10px rgba(0,0,0,0.6);
}

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
<!-- Table goes in the document BODY -->


<h2><font color="#5cb85c">Garden Tea Sale :: Modify</font></h2>
<form action="" method="post" id="frmEditRawTeaSale">
<div id="purchaseMaster" align="center">
<table class="masterTable" width="80%" align="center">
  <tr>
    <td colspan="4">&nbsp;
    <!-- Mode of operation and blending Id-->
    <input type="hidden" name="txtModeOfOperation" id="modeofoperation" value="<?php echo($header['mode']);?>"/>
    <input type="hidden" name="txtrawTeaSaleMastId" id="txtrawTeaSaleMastId" value="<?php echo ($header['rawteasaleMastId']);?>"/>
    <input type="hidden" name="txthdVoucherMastId" id="txthdVoucherMastId" value="<?php echo $bodycontent['rawteasaleMastData']['voucher_master_id'];?>"/>
    
    </td>
  </tr>
 
  <tr>
        <td width="10%">Invoice No</td>
        <td width="20%"><input type="text" name="invoice_no" id="invoice_no" style="width:240px;" 
                               value="<?php echo $bodycontent['rawteasaleMastData']['invoice_no']?>" readonly="readonly"/></td>
       <td width="10%">Sale Date</td>
       <td width="20%" ><input type="text" class="datepicker" name="saleDt" id="saleDt" value="<?php echo $bodycontent['rawteasaleMastData']['saleDate']?>"/></td>
        
   </tr>
   <tr>
      <td width="10%">Customer</td>
        <td width="20%">
            <select name="customer" id="customer" class='custom-select'> 
                <option value="0">Select</option>
                <?php foreach ($header['customerlist'] as $content) : ?>
                <option value="<?php echo $content->vid; ?>" <?php if($bodycontent['rawteasaleMastData']['customer_id']==$content->vid){echo('selected');}else{echo('');}?>>
                    <?php echo $content->customer_name; ?></option>
                <?php endforeach; ?>

            </select>
             <div id="customer_err" style="margin-left: 245px;margin-top:-18px;display:none;"><img src="<?php echo base_url(); ?>application/assets/images/vendor_validation.gif" /></div>
        </td>
        <td width="20%">Vehichle No</td>
        <td width="20%"><input type="text" name="vehichleno" id="vehichleno" value="<?php echo $bodycontent['rawteasaleMastData']['vehichleno']?>"/></td>
   </tr>
  
  
  <tr>
  <td colspan="4">
     
      &nbsp;
  </td>
  </tr>
  <tr>
  <td colspan="4">
     
  </td>
  </tr>
</table>

</div>
   <div id="dialog-new-save" title="Raw Tea Sale" style="display:none;">
       <span> Data save successfully..</span>
   </div>
   <div id="dialog-error-save" title="Raw Tea Sale" style="display:none;">
       <span> Error in save..</span>
   </div> 
   <div id="dialog-validation-save" title="Raw Tea Sale" style="display:none;">
       <span> Validation Fail..</span>
   </div>  
    
<!-- add new combination for blending -->
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



<!-- new combination for blending end-->
    
<!-- Details HTML dynamically added here-->
<div id='stockDiv'>
   
    <section id="loginBox"  class="blendDtl" style="overflow-y: scroll;">
       
        <div id="dialog-out-stock" title="Out of Stock" style="display:none;">
            <span> <img src="<?php echo base_url(); ?>application/assets/images/error-AB.png"/> &nbsp;Stock not available.</span>
        </div> 
        
    <div>
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
       
    </tr>
    <?php foreach ($bodycontent['rawteasaleDtlData'] as $rows){ ?>
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
            <td align="right"><?php echo($rows['kgperbag']);?></td>
            
            <td align="right">
                <?php echo($rows['pricePerBag']);?>
                <input type="hidden" id="hdpriceperbag_<?php echo($rows['PbagDtlId']);?>" name="hdpriceperbag" value="<?php echo($rows['pricePerBag']);?>"/>
            
            </td><!-- rate-->
            
            <td align="right">
                <?php echo($rows['NetBags']);?>
                <input type="hidden" id="hdnetBag_<?php echo($rows['PbagDtlId']);?>" name="hdnetBag" value="<?php echo($rows['kgperbag']); ?>"/>
            </td>
            
            <td align="center">
                <input type="hidden" id="hdTxtBlended_<?php echo($rows['PbagDtlId']);?>" name="txtBlendBag" value="<?php echo($rows['saleBagNo']); ?>"/>
                <input type="text" id="txtused_<?php echo($rows['PbagDtlId']); ?>" name="txtused[]" class="usedBag" 
                       style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px; text-align: right;" value="<?php echo($rows['saleBagNo']); ?>" onkeypress="checkNumeric(this);"/>
            </td>
            
             <td align="right">
                <input type="text" id="txtBlendKg_<?php echo($rows['PbagDtlId']); ?>" name="txtBlendKg[]" disabled="disabled" value="<?php echo($rows['saleKgs']); ?>" style="border: 1px solid #008000; color: #480091; width: 70px;border-radius:5px; text-align: right;"/>
            </td>
            
            <td align="center">
                <input type="hidden" id="hdTxtrate_<?php echo($rows['PbagDtlId']);?>" name="txtRate" value="<?php echo($rows['rate']); ?>"/>
                <input type="text" id="txtrate_<?php echo($rows['PbagDtlId']); ?>" name="txtrate[]" class="rate" 
                       style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px; text-align: right;" value="<?php echo($rows['rate']); ?>" onkeypress="checkNumeric(this);"/>
            </td>
            
              <!--blended cost-->
           <td>
                <input type="text" id="txtBlendedPrice_<?php echo($rows['PbagDtlId']); ?>" name="txtBlendedPrice[]" value="<?php echo($rows['saleCost']); ?>" disabled="disabled"
                      style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" />
            </td>
            <!--blended cost-->
            
            
           
        </tr>
    <?php }?>
    
</table>
    </div>
        <div style="padding-top: 10px;"></div>
</section>
</div>


 <section id="loginBox">
   <table width="100%" border="0"   class="table-condensed">
  <tr>
    <td>Total Sale Bag</td>
    <td><input type="text" id="txtTotalSaleBag" name="txtTotalSaleBag" value="<?php echo $bodycontent['rawteasaleMastData']['total_sale_bag']?>" style="text-align:right;"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Total Sale(Kgs)</td>
    <td><input type="text" id="txtSaleOutKgs" name="txtSaleOutKgs" value="<?php echo $bodycontent['rawteasaleMastData']['total_sale_qty']?>" style="text-align:right;"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>Total Amount</td>
    <td><input type="text" id="txtTotalSalePrice" name="txtTotalSalePrice" value="<?php echo $bodycontent['rawteasaleMastData']['totalamount']?>" style="text-align:right;"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Discount</td>
    <td><input type="text" name="txtDiscountPercentage" id="txtDiscountPercentage" value="<?php echo $bodycontent['rawteasaleMastData']['discountRate']?>" style="text-align:right;"/>(%) </td>
    <td>Amount</td>
    <td><input type="text" id="txtDiscountAmount" name="txtDiscountAmount" value="<?php echo $bodycontent['rawteasaleMastData']['discountAmount']?>" style="text-align:right;"/></td>
  </tr>

  <tr>
    <td>Delivery Chgs</td>
    <td><input type="text" name="txtDeliveryChg" id="txtDeliveryChg" value="<?php echo $bodycontent['rawteasaleMastData']['deliverychgs']?>" style="text-align:right;"/></td>
    <td></td>
    <td></td>
  </tr>

  <tr>
    <td>
        [Vat]<input type="radio" name="rateType" <?php if($header['mode']=='Add'){echo("checked=checked");} ?> id="rateType" value="V" <?php if($bodycontent['rawteasaleMastData']['taxrateType']=='V'){echo("checked=checked");} ?>>
        [CST]<input type="radio" name="rateType"  id="rateType" value="C" <?php if($bodycontent['rawteasaleMastData']['taxrateType']=='C'){echo("checked=checked");} ?>> 
    </td>
    <td>
        <div id="divVat" <?php if($header['mode']=='Add'){echo('style="display:block"');} ?>  <?php if($bodycontent['rawteasaleMastData']['taxrateType']=='V'){echo('style="display:block"');}else{echo('style="display:none"');}?>>
        	 <select id="vat" name="vat">
	            	<option value="0">Select</option>
                        <?php foreach ($header['vatpercentage'] as $rows){ ?>
                        <option value="<?php echo($rows->id); ?>" <?php if($bodycontent['rawteasaleMastData']['taxrateTypeId']==$rows->id){echo('selected');}else{echo('');}?>> <?php echo($rows->vat_rate); ?></option>
                        <?php } ?>
                </select>
        </div>
        <div id="divCst" <?php if($bodycontent['rawteasaleMastData']['taxrateType']=='C'){echo('style="display:block"');}else{echo('style="display:none"');}?>>
        	 <select name="cst" id="cst">
            	<option value="0">Select</option>
                <?php foreach ($header['cstRate'] as $rows){ ?>
                        <option value="<?php echo($rows->id); ?>" <?php if($bodycontent['rawteasaleMastData']['taxrateTypeId']==$rows->id){echo('selected');}else{echo('');}?>> <?php echo($rows->cst_rate); ?></option>
                <?php } ?>
                
            </select>
        </div>	
    </td>
    <td>Tax Amount</td>
    <td><input type="text" id="txtTaxAmount" name="txtTaxAmount" value="<?php echo $bodycontent['rawteasaleMastData']['taxamount']?>" style="text-align:right;"/></td>
  </tr>
  
  <tr>
    <td>Round off</td>
    <td><input type="text" id="txtRoundOff" name="txtRoundOff" value="<?php echo $bodycontent['rawteasaleMastData']['roundoff']?>" style="text-align:right;"/></td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  
  <tr>
    <td>Total</td>
    <td><input type="text" id="txtGrandTotal" name="txtGrandTotal" value="<?php echo $bodycontent['rawteasaleMastData']['grandtotal']?>" style="text-align:right;"/></td>
    <td></td>
    <td></td>
  </tr>
  
  
</table>
</section>

<span class="buttondiv">
          <div class="save" id="updateRawTeaSale" align="center">Update</div>
      </span>
     
</form>

