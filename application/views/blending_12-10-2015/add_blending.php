<script src="<?php echo base_url(); ?>application/assets/js/addBlendingJS.js"></script> 
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


<h2><font color="#5cb85c">Add blending</font></h2>
<form action="" method="post" id="frmAddBlending">
<div id="purchaseMaster" align="center">
<table class="masterTable">
  <tr>
    <td colspan="4">&nbsp;
    <!-- Mode of operation and blending Id-->
    <input type="hidden" name="txtModeOfOperation" id="modeofoperation" value="<?php echo($header['mode']);?>"/>
    <input type="hidden" name="txtblendingId" id="" value=""/>
    
    </td>
  </tr>
  <tr>
    <td>Blending No.</td>
    <td>
        <input type="text" id="txtBlendingNo" name="txtBlendingNo" value=""/>
    </td>
    <td>Ref. No.</td>
    <td>
    	<input type="text" id="txtBlendingRef" name="txtBlendingRef" value=""/>	
     </td>
  </tr>
  <tr>
    <td>Date</td>
    <td><input type="text" name="txtBlendingDt" id="txtBlendingDt" class="datepicker"/></td>
    <td>Warehouse</td>
    <td>
        <select id="warehouse" name="drpwarehouse">
            <option value="0">Select</option>
            <?php  foreach($header['warehouse'] as $rows ): ?>
            <option value="<?php echo($rows->id); ?>"> <?php echo($rows->name); ?> </option>
            <?php endforeach;?>
        </select>
    </td>
  </tr>
  <tr>
   
      <td>Product</td>
    <td >
        <select id="product" name="drpproduct">
            <option value="0">Select</option>
            <?php foreach($header['product'] as $content){?>
                    <option value="<?php echo($content->IdProduct) ?>"><?php echo($content->product); ?></option>
            <?php }?>
        </select>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
  <td colspan="4">&nbsp;
     
      
  </td>
  </tr>
  <tr>
  <td colspan="4">
      <span class="buttondiv">
          <div class="save" id="showStockData" align="center">Show</div>
      </span>
  </td>
  </tr>
</table>

</div>
   <div id="dialog-new-save" title="Blending" style="display:none;">
       <span> Data save successfully..</span>
   </div>
   <div id="dialog-error-save" title="Blending" style="display:none;">
       <span> Error in save..</span>
   </div> 
   <div id="dialog-validation-save" title="Blending" style="display:none;">
       <span> Validation Fail..</span>
   </div>  
    
<!-- Details HTML dynamically added here-->
<div id='stockDiv' >
      <div id="stock_loader" style="display:none; margin-left:450px;">
      <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" />
      </div>
</div>


<span class="buttondiv">
          <div class="save" id="saveBlend" align="center">Save</div>
      </span>
     
</form>

