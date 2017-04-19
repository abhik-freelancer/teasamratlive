<select id="advanceVoucher" name="advanceVoucher" class="selectStyle" style="width:200px;">
    <option value="">-Select-</option>
    <?php
        foreach ($advancevoucher as $rows){
            ?>
    <option value="<?php echo($rows["advanceId"]);?>"><?php echo($rows["voucher"]);?></option>
    
    <?php
        }
    ?>
</select>