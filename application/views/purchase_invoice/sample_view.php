<table class="CSSTableGenerator">
    <tr id="sampletr">
        <td>
            <select id="drpBagtype" name="drpBagtype[]">
               <?php foreach($bagtype as  $content){?>
                <?php if($content->bagid!=3){?>
                <option value="<?php echo($content->bagid) ?>"><?php echo($content->bagtype);?></option>
               <?php }}?>
            </select>
        </td>
        <td>
            <input type="text" name="packtno[]" id="packtno" placeholder="Number of bags" class=".noofbags" onkeypress="checkNumeric(this);"/>
        </td>
       
        <td>
            <input type="text" name="packtvalue[]" id="packtvalue" class="packtvaluenet"  placeholder="Net in Kgs" onkeypress="checkDecimal(this);"/>
            
        </td>
        <td>
            <textarea id="chestSerial" name="chestSerial[]" placeholder="chest serial"></textarea>
        </td>
        <td><img src="<?php echo base_url(); ?>application/assets/images/delete.png" id="sampleimg" height="15" width="15"></td>
    </tr>
</table>








<script>
$('.noofbags').change(function() {
    calculateCurrentVatratetotal();
});

    $('.packtvaluenet').change(function() {
        calculateCurrentVatratetotal();
    });
</script>