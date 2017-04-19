<script src="<?php echo base_url(); ?>application/assets/js/addStockINpurchase.js"></script> 
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
 .custom-select {
    position: relative;
    width: 200px;
    height:25px;
    line-height:10px;
  font-size: 9px;
    
 
}
.custom-select a {
  display: block;
  width: 200px;
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
    width: 165px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 9px;
}
</style>
<!-- Table goes in the document BODY -->


<h2><font color="#5cb85c">Add Stock Transfer(IN)</font></h2>

<form action="" method="post" id="frmPurchase">
<div id="purchaseMaster" align="center" class="ui-widget">
<table class="masterTable">
  <tr>
    <td colspan="4">&nbsp;
    <!-- Mode of operation and PurchaseMaster Id-->
    <input type="hidden" name="txtModeOfOperation" id="modeofoperation" value="<?php echo($header['mode']);?>"/>
    <input type="hidden" name="txtpmasterId" id="pMasterId" value=""/>
    
    </td>
  </tr>
 
 
    <tr>
        <td>Ref. No:</td>
        <td><input type="text" name="refrence_no" id="refrence_no" value=""/> </td>
        <td>Transfer Date</td>
        <td><input type="text" class="datepicker" name="transferDt" id="transferDt" value="" /></td>
    </tr>
                              
   
  <tr>
    <td>Receipt Date</td>
    <td><input type="text" class="datepicker" id="receiptDt" name="receiptDt" value=""/></td>
    <td>Vendor</td>
    <td>
    	<select name="vendor" id="vendor" class='custom-select' >
            <option value="0">Select</option>
            <?php foreach ($header['vendor'] as $content) : ?>
                <option value="<?php echo $content->vid; ?>"
                <?php if($content->vid==$bodycontent['purchaseMaster']->vendor_id){echo("selected='selected'");}else{echo('');}?>><?php echo $content->vendor_name; ?></option>
                <?php endforeach; ?>

         </select> 
        <div id="vendor_err" style="margin-left:210px;margin-top:-21px;display:none;"><img src="<?php echo base_url(); ?>application/assets/images/vendor_validation.gif" /></div>
    </td>
  </tr>
   
  <tr>
    <td>Challan No</td>
    <td><input type="text" id="challanNo" name="challanNo"/></td>
    <td>Transporter Name</td>
    <td>
         <select name="transporterid" id="transporterid" style="width:200px;;">
              <option value="0">Select</option>
                <?php foreach ($header['transporterlist'] as $rows) : ?>
                    <option value="<?php echo $rows->id; ?>">
                        <?php echo $rows->name; ?></option>
                    <?php endforeach; ?>

        </select>
    </td>
  </tr>
  
    <tr>
    <td>CN No.</td>
    <td><input type="text"  id="cnNo" name="cnNo" value=""/></td>
    <td>&nbsp;</td>
    <td><input type="hidden" name="purchasetype" id="purchasetype" value="STI" /></td>
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
  <p>Refrence No already exist</p>
  
  
</div>
<!-- modal dialog--div-->

<!-- modal dialog--div-->
<div id="dialog-new-add" title="Purchase Detail" style="display:none;">
  <p>Data validation fail!!..</p>
  
  
</div>
<!-- modal dialog--div-->
<div id="dialog-new-error" title="Purchase Detail" style="display:none;">
  <p>Erro !!..</p>
  
  
</div>
<!-- modal dialog--div-->



<div id="purchaseMasterFooter" align="center" style="padding-top: 0.2cm;">
    
    <table class="masterTable" width="50%" >
        <tr>
            <td colspan="2"></td>
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
            <td>Total</td>
            <td> <input type="text" id="txtTotalPurchase" name="txtTotalPurchase" value="" style="text-align: right;" readonly=""/> </td>
        </tr>
    </table>
        
</div>
     <span class="buttondiv">
          <div class="save" id="savePurchase" align="center">Save</div>
      </span>
    </form>

