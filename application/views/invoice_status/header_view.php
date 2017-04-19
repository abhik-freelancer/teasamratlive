<script src="<?php echo base_url(); ?>application/assets/js/invoiceStatus.js"></script> 


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
table.purchaseinv tr {
    border:0px solid red;
    padding-bottom:5px;
}

</style>
<!-- Table goes in the document BODY -->


<h2><font color="#5cb85c">Invoice Status</font></h2>
<form action="" method="post" id="frmInvoiceStatus">

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
<div id="dialog-for-id-in-table" title="Blending" style="display:none;">
       <span> This combination already in table. </span>
</div>

<!--details will be added here-->

<section id="loginBox" >
 
    
    <div id="dialog-for-no-stock" title="Blending" style="display:none;">
       <span> 
           <img src="<?php echo base_url(); ?>application/assets/images/out-of-stock.png" />
           Data Not Found. </span>
    </div>
    <!--
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
    -->
    
</section>


    
</form>

