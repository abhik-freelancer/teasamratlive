<!-- Table goes in the document BODY -->
<?php if($groupStock){ ?>
<div id="stockDetail_<?php echo($divnumber);?>">
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
        <td width="5%">Stock Out Bag</td>
        <td width="5%">Stock Out Cost</td>
        <td width="5%">Kgs</td>
        <td width="5%"><img src="<?php echo base_url(); ?>application/assets/images/del_ab.png" title="Delete" id="delTable" onclick="deleteTable(<?php echo($divnumber);?>);" style=" cursor: pointer;"/></td>
    </tr>
    <?php foreach ($groupStock as $rows){ ?>
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
            <td align="right">
                <?php echo($rows['kgperbag']);?>
                 <input type="hidden" id="hdnetBag_<?php echo($rows['PbagDtlId']);?>" name="hdnetBag" value="<?php echo($rows['kgperbag']); ?>"/>
            
            </td>
            <td align="right">
                <?php  echo($rows['pricePerBag']);?>
                <input type="hidden" id="hdpriceperbag_<?php echo($rows['PbagDtlId']);?>" name="hdpriceperbag" value="<?php echo($rows['pricePerBag']);?>"/>
            </td>
            <td align="right">
                <?php echo($rows['NetBags']);?>
            </td>
            <td align="center">
                <input type="text" id="txtused_<?php echo($rows['PbagDtlId']); ?>" name="txtused[]" class="usedBag" 
                       style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" value="" onkeypress="checkNumeric(this);"/>
            </td>
            <!--blended cost-->
           <td>
                <input type="text" id="txtBlendedPrice_<?php echo($rows['PbagDtlId']); ?>" name="txtBlendedPrice[]" value="" disabled="disabled"
                      style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" />
            </td>
            <!--blended cost-->
            <td align="right" colspan="2">
                <input type="text" id="txtBlendKg_<?php echo($rows['PbagDtlId']); ?>" name="txtBlendKg[]" disabled="disabled" value="" style="border: 1px solid #008000; color: #480091; width: 90px;border-radius:5px; text-align: right;"/>
            </td>
        </tr>
    <?php }?>
    
</table>
    <div style="padding-top: 10px;"></div>
</div>

<?php } ?>
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


