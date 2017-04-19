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
    <td>Ref. No.</td>
    <td>
<!--        <input type="text" id="txtBlendingNo" name="txtBlendingNo" value=""/>-->
        <input type="text" id="txtBlendingRef" name="txtBlendingRef" value=""/>	
    </td>
    <td></td>
    <td>
<!--    	<input type="text" id="txtBlendingRef" name="txtBlendingRef" value=""/>	-->
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
<!--      <span class="buttondiv">
          <div class="save" id="showStockData" align="center">Add Details</div>
      </span>-->
  </td>
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
            <option value="0">--Select Lot--</option>
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
<div id="dialog-for-id-in-table" title="Blending" style="display:none;">
       <span> This combination already in table. </span>
</div>
    
<!--details will be added here-->

<section id="loginBox">
    <div id="dialog-for-no-stock" title="Blending" style="display:none;">
       <span> 
           <img src="<?php echo base_url(); ?>application/assets/images/out-of-stock.png" />
           Out of stock. </span>
    </div>
    
    <div id="dialog-for-noDtl" title="Blending" style="display:none;">
       <span> 
           Please select data for blended.
       </span>
    </div>
    
        <div id='stockDiv' >
              <div id="stock_loader" style="display:none; margin-left:450px;">
              <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" />
              </div>
        </div>
    
</section>
 <section id="loginBox">
    <table width="100%">
        <tr>
            <td>Total Blended Bag</td>
            <td><input type="text" id="txtTotalBlendPckt" name="txtTotalBlendPckt" style="text-align: right;" readonly="" value=""/></td>
            
            <!--<td>Blended price</td>
            <td><input type="text" id="txtTotalBlendPrice" name="txtTotalBlendPrice" style="text-align: right;" readonly="" value=""/></td>-->
            
            <td>Total Blended (Kgs)</td>
            <td><input type="text" id="txtTotalBlendKgs" name="txtTotalBlendKgs" style="text-align: right;" readonly="" value=""/></td>
            
          
        </tr>
        
        <tr>
            <td>Blending Cost</td>
            <td><input type="text" id="txtTotalBlendPrice" name="txtTotalBlendPrice" style="text-align: right;" readonly="" value=""/></td>
            
            <td>Average Cost</td>
            <td><input type="text" id="txtTotalAvgPrice" name="txtTotalAvgPrice" style="text-align: right;" readonly="" value=""/></td>
        </tr>
        
    </table>
</section>
    

    
    
    
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



<span class="buttondiv">
          <div class="save" id="saveBlend" align="center">Save</div>
      </span>
     
</form>

