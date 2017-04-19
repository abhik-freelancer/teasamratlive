<script src="<?php echo base_url(); ?>application/assets/js/editBlendingJS.js"></script> 
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
</style>
<!-- Table goes in the document BODY -->


<h2><font color="#5cb85c">Blending::Modify</font></h2>
<form action="" method="post" id="frmEditBlending">
<div id="purchaseMaster" align="center">
<table class="masterTable">
  <tr>
    <td colspan="4">&nbsp;
    <!-- Mode of operation and blending Id-->
    <input type="hidden" name="txtModeOfOperation" id="modeofoperation" value="<?php echo($header['mode']);?>"/>
    <input type="hidden" name="txtblendingId" id="blendingId" value="<?php echo($header['blnid']);?>"/>
    
    </td>
  </tr>
  <tr>
    <td>Ref. No.</td>
    <td>
<!--        <input type="text" id="txtBlendingNo" name="txtBlendingNo" value="<?php echo($bodycontent['blendingMaster']['blendNum']);?>"/>-->
        <input type="text" id="txtBlendingRef" name="txtBlendingRef" value="<?php echo($bodycontent['blendingMaster']['blendRef']);?>"/>
    </td>
    <td></td>
    <td>
    		
     </td>
  </tr>
  <tr>
    <td>Date</td>
    <td><input type="text" name="txtBlendingDt" id="txtBlendingDt" class="datepicker" value="<?php echo($bodycontent['blendingMaster']['blendDate']); ?>"/></td>
    <td>Warehouse</td>
    <td>
        <select id="warehouse" name="drpwarehouse">
            <option value="0">Select</option>
            <?php  foreach($header['warehouse'] as $rows ): ?>
            <option value="<?php echo($rows->id); ?>" <?php if($bodycontent['blendingMaster']['warehouseId']==$rows->id){echo('selected');}else{echo('');}?>> <?php echo($rows->name); ?> </option>
            <?php endforeach;?>
        </select>
    </td>
  </tr>
  <tr>
   
      <td>Product</td>
    <td>
        <select id="product" name="drpproduct">
            <option value="0">Select</option>
            <?php foreach($header['product'] as $content){?>
                    <option value="<?php echo($content->IdProduct) ?>"<?php if($bodycontent['blendingMaster']['productId']==$content->IdProduct){echo('selected');}else{echo('');} ?>><?php echo($content->product); ?></option>
            <?php }?>
        </select>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
   <div id="dialog-new-save" title="Blending" style="display:none;">
       <span> Data save successfully..</span>
   </div>
   <div id="dialog-error-save" title="Blending" style="display:none;">
       <span> Error in save..</span>
   </div> 
   <div id="dialog-validation-save" title="Blending" style="display:none;">
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
         </div> 
        
    </td>
    <td>
        <div id="drpLot">
            <select style=" width: 200px;" id="dropdown-lot">
            <option value="0">--Select Lot--</option>
            </select>
        </div>    
    </td>
    <td>
        <div id="drpGrade">
            <select style=" width: 200px;" id="dropdown-grade">
             <option value="0">--Select Grade--</option>
            </select>
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
        <td width="10%">Stock in Kgs.</td>
        <td width="5%">Blended Bag</td>
        <td width="5%">Blended Cost</td>
        <td width="5%">Kgs</td>
    </tr>
    <?php foreach ($bodycontent['blendedStock'] as $rows){ ?>
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
                <input type="hidden" id="hdTxtBlended_<?php echo($rows['PbagDtlId']);?>" name="txtBlendBag" value="<?php echo($rows['blendedBag']); ?>"/>
                <input type="text" id="txtused_<?php echo($rows['PbagDtlId']); ?>" name="txtused[]" class="usedBag" 
                       style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px; text-align: right;" value="<?php echo($rows['blendedBag']); ?>" onkeypress="checkNumeric(this);"/>
            </td>
            
              <!--blended cost-->
            <td>
                <input type="text" id="txtBlendedPrice_<?php echo($rows['PbagDtlId']); ?>" name="txtBlendedPrice[]" value="<?php echo($rows['blendedCost']); ?>" disabled="disabled"
                      style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" />
            </td>
            <!--blended cost-->
            
            
            <td align="right">
                <input type="text" id="txtBlendKg_<?php echo($rows['PbagDtlId']); ?>" name="txtBlendKg[]" disabled="disabled" value="<?php echo($rows['blendedKgs']); ?>" style="border: 1px solid #008000; color: #480091; width: 90px;border-radius:5px; text-align: right;"/>
            </td>
        </tr>
    <?php }?>
    
</table>
    </div>
        <div style="padding-top: 10px;"></div>
</section>
</div>


<section id="loginBox">
    <table width="100%">
        <tr>
            <td>Total Blended Bag</td>
            <td><input type="text" id="txtTotalBlendPckt" name="txtTotalBlendPckt" style="text-align: right;" readonly="" value="<?php echo($bodycontent['blendingMaster']['blendedBag']);?>"/></td>
            
            <!--<td>Blended price</td>
            <td><input type="text" id="txtTotalBlendPrice" name="txtTotalBlendPrice" style="text-align: right;" readonly="" value="<?php echo($bodycontent['blendingMaster']['blendedprice']);?>"/></td>-->
            
            <td>Total Blended (Kgs)</td>
            <td><input type="text" id="txtTotalBlendKgs" name="txtTotalBlendKgs" style="text-align: right;" readonly="" value="<?php echo($bodycontent['blendingMaster']['blendedKgs']);?>"/></td>
        </tr>
        <tr>
        <td>Blending Cost</td>
        <td><input type="text" id="txtTotalBlendPrice" name="txtTotalBlendPrice" style="text-align: right;" readonly="" value="<?php echo($bodycontent['blendingMaster']['blendedprice']);?>"/></td>
        
        <td>Average Cost</td>
        <td><input type="text" id="txtTotalAvgPrice" name="txtTotalAvgPrice" style="text-align: right;" readonly="" value="<?php echo($bodycontent['blendingMaster']['avgblendCost']);?>"/></td>
        </tr>
    </table>
</section>

<span class="buttondiv">
          <div class="save" id="updateBlend" align="center">Update</div>
      </span>
     
</form>

