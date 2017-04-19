<script src="<?php echo base_url(); ?>application/assets/js/editFinishProduct.js"></script> 

<h2><font color="#5cb85c">Edit Finish Product</font></h2>
<form id="frmFinishedProduct" name="frmFinishedProduct" method="post">
<!-- Packing Date & Ware House ID -->
<section  id="loginBox" style="width: 690px; height: 150px;">
    <table width="100%" border="0">
        <tr>
            <td>Date</td>
            <td><input type="text" name="txtPackingDt" id="txtPackingDt" class="datepicker" value="<?php echo($bodycontent['finishProductMaster']['packingdate']); ?>"/></td>
            <td>&nbsp; <input type="hidden" id="finishproductId" name="finishproductId" value="<?php echo($bodycontent['finishProductMaster']['finishproductid']); ?>"</td>
            <td>Warehouse</td>
            <td>
                <select id="warehouse" name="drpwarehouse">
                    <option value="0">Select</option>
                    <?php foreach ($header['warehouse'] as $rows): ?>
                        <option value="<?php echo($rows->id); ?>" 
                            <?php if($rows->id==$bodycontent['finishProductMaster']['warehouseId']){echo('selected="selected"');} ?>> <?php echo($rows->name); ?> </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <label for="blendingref">Blending Ref. No.</label>
            </td>
            <td>
                
                <input type="text" id="txtBlendRef" name="txtBlendRef" value="<?php echo($bodycontent['finishProductMaster']['blendref']) ?>" readonly />
                <input type="hidden" id="hdblendno" name="hdblendno" value="<?php echo($bodycontent['finishProductMaster']['blendid']); ?>"
            </td>
             <td>&nbsp;</td>
            <td>
                <label>Product</label>
            </td>
            <td>
                
                <input type="text" name="txtProduct" id="txtProduct" value="<?php echo($bodycontent['finishProductMaster']['mapedproduct']);?>" readonly/>
                <input type="hidden" name="txtProductId" id="txtProductId" value="<?php echo($bodycontent['finishProductMaster']['productid']);?>"/>
            </td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td>Blended Qty</td>
            <td><input type="text" id="netblendkg" name="netblendkg" value="<?php echo($bodycontent['finishProductMaster']['blendedStock']);?>" readonly="readonly" />
                <input type="hidden" id="blendQty" name="blendQty" value="<?php echo($bodycontent['finishProductMaster']['blendQty']); ?>"/>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        

    </table>
</section>



 
<section  id="loginBox" style="width: 690px; height: 200px;">

<?php if($bodycontent['finishProductDetails']){ ?>
    
        <table class="CSSTableGenerator" width="100%">
            <tr>
               
                <td>Packet</td>
                <td>Weight(Kgs)</td>
                <td>Qty in bag(Kgs)</td>
                <td>No.Of Packet</td>
                <td>Quantity(Kgs)</td>
            </tr>
			<?php 
				$totalPacketsInBlnd = 0;
				$totalconsumedKgs = 0;
			?>
            <?php foreach ($bodycontent['finishProductDetails'] as $value) {?>
                    
            <tr>
                <td>
                    <?php echo($value['Packet']); ?>
                    <input type="hidden" id="hdproductpckt" name="hdproductpckt[]" value="<?php echo($value['productpacketid']);?>"/>
                </td>
                <td align="right">
                    <?php echo($value['PacketWeight']); ?>
                    <input type="hidden" id="qtyinpckt_<?php echo($value['productpacketid']); ?>" name="qtyinpckt[]" class="packetkg" 
                            value="<?php echo($value['PacketWeight']); ?>"/>
                </td>
                <td align="right">
                    <?php echo($value['qtyinBag']); ?>
                    <input type="hidden" id="qtyinbag_<?php echo($value['productpacketid']); ?>" name="qtyinbag[]" class="qtyinbag" 
                            value="<?php echo($value['qtyinBag']); ?>"/>
                </td>
                <td> 
                    <input type="text" id="txtpacket_<?php echo($value['productpacketid']);?>" name="txtpacket[]" class="noofpacket" 
                       style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" value="<?php echo($value['numofpkt']); ?>" onkeypress="checkNumeric(this);"/> 
                </td>
                
                <td>
                    <input type="text" id="txtPcktKg_<?php echo($value['productpacketid']); ?>" name="txtPcktKg[]" class="packetkg" readonly
                           style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" value="<?php echo($value['qtyofpkt']);?>"/>
                </td>
            </tr>
                
                
           <?php 
			$totalPacketsInBlnd = $totalPacketsInBlnd + $value['numofpkt'];
			$totalconsumedKgs = $totalconsumedKgs + $value['qtyofpkt'];
		   } 
		   ?>
            
            
        </table>
		<table>
		<tr> <td colspan="3"> &nbsp;</td></tr>
		<tr>
		<td>Consumed packet&nbsp;</td>
		<td><input type="text" class="totpkt" value="<?php echo($totalPacketsInBlnd) ?>" readonly></td>
		<td> Consumed Kgs&nbsp;</td>
		<td> <input type="text" class="totkgs" value="<?php echo($totalconsumedKgs); ?>" readonly></td>
		</tr>
		</table>
		
    </section>
<?php } ?>
<div id="dialog-blendkg" title="Finish product" style="display:none;">
       <span> 
           <img src="<?php echo base_url(); ?>application/assets/images/warning-512.png" />
           Blend quantity do not match with ,packed quantity.<p>Do you want to save ?</p>
       </span>
</div>
 <div id="dialog-new-save" title="Finish product" style="display:none;">
       <span> Data save successfully..</span>
   </div>
   <div id="dialog-error-save" title="Finish product" style="display:none;">
       <span> Error in save..</span>
   </div> 
 <div id="dialog-validation-save" title="Finish product" style="display:none;">
       <span> Validation Fail..</span>
   </div>  


<script>
function checkNumeric(obj)
{

    var regex = new RegExp(/^[0-9]+$/);

    if (obj.value.match(regex))
    {
        return true;
    }
    obj.value = "";
    return false;

}
</script>




<span class="buttondiv">
          <div class="save" id="update_finish_product" align="center">Update</div>
</span>
</form>


