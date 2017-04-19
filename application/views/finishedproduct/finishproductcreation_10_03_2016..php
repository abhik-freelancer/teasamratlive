
 
<section id="loginbox">
  <table width="100%" border="0">
  <tr>
    <td><label for="mappedproduct">Mapped product :</label>&nbsp;</td>
    <td><input type="text" id="product" name="product" value="<?php echo($mappedProduct);?>" readonly="readonly"/></td>
    <td>&nbsp;</td>
    <td> <label for="blendedqty">Blended Quantity :</label>&nbsp;</td>
    <td><input type="text" id="netblendkg" name="netblendkg" value="<?php echo($blendedQty);?>" readonly="readonly" /></td>
  </tr>
</table>

    <div style="padding-top: 20px;"></div>  


<?php if($packetDtls){ ?>
    
        <table class="CSSTableGenerator" style="width:500px;margin-left:250px;">
            <tr>
               
                <td>Packet</td>
                <td>Packet Qty (kgs) </td>
                <td>No.Of Packet</td>
                <td>kg</td>
            </tr>
            <?php foreach ($packetDtls as $value) {?>
                    
            <tr>
                <td>
                    <?php echo($value['packet']); ?>
                    <input type="hidden" id="hdproductpckt" name="hdproductpckt[]" value="<?php echo($value['productPacketId']);?>"/>
                </td>
                <td align="right">
                    <?php echo($value['packetQtyinKg']); ?>
                    <input type="hidden" id="qtyinpckt_<?php echo($value['productPacketId']); ?>" name="qtyinpckt[]" class="packetkg" 
                            value="<?php echo($value['packetQtyinKg']); ?>"/>
                </td>
                <td> 
                    <input type="text" id="txtpacket_<?php echo($value['productPacketId']);?>" name="txtpacket[]" class="noofpacket" 
                       style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" value="<?php echo($value['numberofpacket']); ?>" onkeypress="checkNumeric(this);"/> 
                </td>
                <td>
                    <input type="text" id="txtPcktKg_<?php echo($value['productPacketId']); ?>" name="txtPcktKg[]" class="packetkg" readonly
                           style="background-color : #EEEEEE;border: 1px solid #008000;width: 50px;border-radius:5px;" value=""/>
                </td>
            </tr>
                
                
           <?php } ?>
            
            
        </table>
    </section>
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