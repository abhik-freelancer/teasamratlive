<script src="<?php echo base_url(); ?>application/assets/js/addPurchaseJS.js"></script> 
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
</style>
<!-- Table goes in the document BODY -->


<h2><font color="#5cb85c">Add Purchase Invoice</font></h2>
<form action="" method="post" id="frmPurchase">
<div id="purchaseMaster" align="center">
<table class="masterTable">
  <tr>
    <td colspan="4">&nbsp;
    <!-- Mode of operation and PurchaseMaster Id-->
    <input type="hidden" name="txtModeOfOperation" id="modeofoperation" value="<?php echo($header['mode']);?>"/>
    <input type="hidden" name="txtpmasterId" id="pMasterId" value=""/>
    
    </td>
  </tr>
  <tr>
    <td>Purchase</td>
    <td>
                    <select id="purchasetype" name="purchasetype">
                        <option value="AS" <?php if($bodycontent['purchaseMaster']->from_where=='AS'){echo("selected");}else{echo("");}?>>Auction</option>
                        <option value="PS" <?php if($bodycontent['purchaseMaster']->from_where=='PS'){echo("selected");}else{echo("");}?>>Auction private</option>
                        <option value="SB" <?php if($bodycontent['purchaseMaster']->from_where=='SB'){echo("selected");}else{echo("");}?>>Private purchase</option>
                    </select>
    </td>
    <td>Area</td>
    <td>
    		<select id="auctionArea" name="auctionArea">
                          <option value="0">Select</option>
                          <?php foreach($header['auctionarea'] as $content){?>
                          <option value="<?php echo($content->aucAreaid); ?>" <?php if($bodycontent['purchaseMaster']->auctionareaid==$content->aucAreaid){echo('selected');}?>> 
                              <?php echo($content->auctionarea); ?> </option>             
                          <?php }?>
                </select>
     </td>
  </tr>
  <tr>
    <td>Invoice</td>
    <td><input type="text" name="taxinvoice" id="taxinvoice" value="<?php echo($bodycontent['purchaseMaster']->purchase_invoice_number); ?>"/></td>
    <td>Invoice Date</td>
    <td><input type="text" class="datepicker" id="taxinvoicedate" name="taxinvoicedate" value="<?php echo($bodycontent['purchaseMaster']->invoicedate); ?>"/></td>
  </tr>
  <tr>
    <td>Sale No.</td>
    <td><input type="text" name="salenumber" id="salenumber" value="<?php echo($bodycontent['purchaseMaster']->sale_number);?>"/></td>
    <td>Sale Date</td>
    <td><input type="text" class="datepicker" id="saledate" name="saledate" value="<?php echo($bodycontent['purchaseMaster']->saledate);?>"/></td>
  </tr>
  <tr>
    <td>Prompt Date</td>
    <td><input type="text" class="datepicker" id="promtdate" name="promtdate" value="<?php echo($bodycontent['purchaseMaster']->promptDate);?>"/></td>
    <td>Vendor</td>
    <td> 
    		    <select name="vendor" id="vendor" >
                        <option value="0">select</option>
                        <?php foreach ($header['vendor'] as $content) : ?>
                            <option value="<?php echo $content->vid; ?>"
                                <?php if($content->vid==$bodycontent['purchaseMaster']->vendor_id){echo("selected='selected'");}else{echo('');}?>><?php echo $content->vendor_name; ?></option>
                        <?php endforeach; ?>

                    </select>
    </td>
  </tr>
  <tr>
  <td colspan="4">
     <div id="dialog-new-save" title="Purchase Detail" style="display:none;">
            <p>Data successfully saved.</p>
           
     </div>
  </td>
  </tr>
  <tr>
  <td colspan="4">
      <span class="buttondiv">
          <div class="save" id="addnewDtlDiv" align="center">Add Details</div>
      </span>
  </td>
  </tr>
</table>

</div>
<!-- Details HTML dynamically added here-->
<div id='detailDiv' >
      
</div>
<!-- Details HTML dynamically added here-->

<!-- modal dialog--div-->
<div id="dialog-check-invoice" title="Purchase Detail" style="display:none;">
  <p>Invoice No already exist</p>
  
  
</div>
<!-- modal dialog--div-->

<!-- modal dialog--div-->
<div id="dialog-new-add" title="Purchase Detail" style="display:none;">
  <p>Data validation fail!!..</p>
  
  
</div>
<!-- modal dialog--div-->



<div id="purchaseMasterFooter" align="center" style="padding-top: 0.2cm;">
    
    <table class="masterTable" width="50%" >
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Total Bags</td>
            <td><input type="text" id="txtTotalBags" name="txtTotalBags" style="text-align: right;" value="" readonly=""/></td>
        </tr>
        <tr>
            <td>Total Weight(in Kgs.)</td>
            <td><input type="text" id="txtGrandWeight" name="txtGrandWeight" style="text-align: right;" value="" readonly=""/></td>
        </tr>

        <tr>
            <td>Tea value</td>
            <td><input type="text" id="txtTeaValue" name="txtTeaValue" style="text-align: right;" value="" readonly=""/></td>
        </tr>
        <tr>
            <td>Brokerage</td>
            <td><input type="text" id="txtBrokerageTotal" name="txtBrokerageTotal" style="text-align: right;" value="" readonly=""/></td>
        </tr>
        <tr>
            <td>Service Tax</td>
            <td><input type="text" name="txtServiceTax" id="txtServiceTax" value="" style="text-align: right;" value="" readonly=""/></td>
        </tr>
        <tr>
            <td>VAT</td>
            <td><input type="text" name="txtVatTotal" id="txtVatTotal" value="" style="text-align: right;" readonly=""/> </td>
        </tr>
        <tr>
            <td>CST</td>
            <td><input type="text" name="txtCstTotal" id="txtCstTotal" value="" style="text-align: right;" readonly=""/></td>
        </tr>
        <tr>
            <td>Stamp</td>
            <td> <input type="text" name="txtStampTotal" id="txtStampTotal" value="" style="text-align: right;" readonly=""/></td>
        </tr>
        <tr>
            <td>Other Charges</td>
            <td> <input type="text" name="txtOtherCharges" id="txtOtherCharges" value="" style="text-align: right;" /></td>
        </tr>
        <tr>
            <td>Round Off</td>
            <td> <input type="text" name="txtRoundOff" id="txtRoundOff" value="" style="text-align: right;" /></td>
        </tr>
        <tr>
            <td>Total</td>
            <td> <input type="text" id="txtTotalPurchase" name="txtTotalPurchase" value="" style="text-align: right;" readonly=""/> </td>
        </tr>
    </table>
        
</div>
     <span class="buttondiv">
          <div class="save" id="savePurchase" align="center">Save</div>
      </span>
    </form>

