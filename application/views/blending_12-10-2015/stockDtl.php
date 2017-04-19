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

<section id="loginBox" style="overflow-y: scroll;">
    <div >
    <table class="CSSTableGenerator" >
    <tr>
        <td width="10%">Invoice</td>
        <td width="10%">Group</td>
        <td width="10%">Grade</td>
        <td width="5%">Garden</td>
        <td width="5%">Bag in Stock</td>
        <td width="10%">net(Kgs)</td>
        <td width="10%">Stock in Kgs.</td>
        <td width="5%">Blended Bag</td>
        <td width="10%">Kgs</td>
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
                <?php echo($rows['NetBags']);?>
               
            
            </td>
            <td align="center">
                <input type="text" id="txtused_<?php echo($rows['PbagDtlId']); ?>" name="txtused[]" class="usedBag" 
                       style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" value="" onkeypress="checkNumeric(this);"/>
            </td>
            <td align="right">
                <input type="text" id="txtBlendKg_<?php echo($rows['PbagDtlId']); ?>" name="txtBlendKg[]" disabled="disabled" value="" style="border: 1px solid #008000; color: #480091; width: 90px;border-radius:5px; text-align: right;"/>
            </td>
        </tr>
    <?php }?>
    
</table>
    </div>
</section>
<section id="loginBox">
    <table width="100%">
        <tr>
            <td>Total Blended Bag</td>
            <td><input type="text" id="txtTotalBlendPckt" name="txtTotalBlendPckt" style="text-align: right;" disabled="disabled" value="<?php  echo($header['TotalPacket']);  ?>"/></td>
            <td>Total Blended (Kgs)</td>
            <td><input type="text" id="txtTotalBlendKgs" name="txtTotalBlendKgs" style="text-align: right;" disabled="disabled" value="<?php echo($header['TotalBlendedKgs']);  ?>"/></td>
        </tr>
    </table>
</section>
<script>
 $( document ).ready(function() {
   
   
   
   
}); 

 function getTotalBlendedBag() {
    var totalBlendedBag = 0;
    //var i=1;
    $('input[name^="txtused"]').each(function() {
        var bag = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalBlendedBag =parseFloat(totalBlendedBag + bag);
        //console.log("totalBlendedBag "+i+":"+bag);
        //i++;
    });
    
    $("#txtTotalBlendPckt").val((totalBlendedBag).toFixed(2));
    return false;
}
function getTotalBlendedWeight(){
    var totalBlendKg =0 ;
     $('input[name^="txtBlendKg"]').each(function() {
        var bagKg = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalBlendKg =parseFloat(totalBlendKg + bagKg);
    });
    $("#txtTotalBlendKgs").val((totalBlendKg).toFixed(2));
    return false;
    
}   
    
    
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


