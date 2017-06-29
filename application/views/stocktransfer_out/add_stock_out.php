<script src="<?php echo base_url(); ?>application/assets/js/addStockOutpurchase.js"></script> 
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


<h2><font color="#5cb85c">Add Stock Transfer(OUT)</font></h2>
<form action="" method="post" id="frmAddStockOut">
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
        <td>Ref. No:</td>
        <td><input type="text" name="refrence_no" id="refrence_no" value=""/> </td>
        <td>Transfer Date</td>
        <td><input type="text" class="datepicker" name="transferDt" id="transferDt" value="" style="width:200px;"/></td>
    </tr>
                              
   
  <tr>
    <td>CN No.</td>
    <td><input type="text"  id="cnNo" name="cnNo" value=""/></td>
    <td>Customer</td>
    <td>
    	<select name="customer" id="customer" class='custom-select' >
            <option value="0">Select</option>
            <?php foreach ($header['customer'] as $content) : ?>
                <option value="<?php echo $content->vid; ?>"><?php echo $content->customer_name; ?></option>
            <?php endforeach; ?>

         </select> 
        <div id="vendor_err" style="margin-left:210px;margin-top:-21px;display:none;"><img src="<?php echo base_url(); ?>application/assets/images/vendor_validation.gif" /></div>
    </td>
    
  </tr>
  
  
  <tr>
      
  <td colspan="4">

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
<div id="dialog-for-id-in-table" title="Stock Transfer(OUT)" style="display:none;">
       <span> This combination already in table. </span>
</div>
    
<!--details will be added here-->

<section id="loginBox">
    <div id="dialog-for-no-stock" title="Stock Transfer(OUT)" style="display:none;">
       <span> 
           <img src="<?php echo base_url(); ?>application/assets/images/out-of-stock.png" />
           Out of stock. </span>
    </div>
    
    <div id="dialog-for-noDtl" title="Stock Transfer(OUT)" style="display:none;">
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
            <td>Total Stock(Out) Bag</td>
            <td><input type="text" id="txtTotalstockOutBag" name="txtTotalstockOutBag" style="text-align: right;" readonly="" value=""/></td>
            
           <td>Total price</td>
            <td><input type="text" id="txtTotalStockPrice" name="txtTotalStockPrice" style="text-align: right;" readonly="" value=""/></td>
            
            <td>Total Stock(Out) (Kgs)</td>
            <td><input type="text" id="txtTotalstockOutKgs" name="txtTotalstockOutKgs" style="text-align: right;" readonly="" value=""/></td>
            
          
        </tr>
    </table>
</section>
    

    
    
    
   <div id="dialog-new-save" title="Stock Transfer(OUT)" style="display:none;">
       <span> Data save successfully..</span>
   </div>
   <div id="dialog-error-save" title="Stock Transfer(OUT)" style="display:none;">
       <span> Error in save..</span>
   </div> 
   <div id="dialog-validation-save" title="Stock Transfer(OUT)" style="display:none;">
       <span> Validation Fail..</span>
   </div>  
    
<!-- Details HTML dynamically added here-->



<span class="buttondiv">
          <div class="save" id="saveStockOut" align="center" style="display:block;">Save</div>
</span>
     
</form>

