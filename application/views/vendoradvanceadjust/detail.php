 <select id="purchaseBill" name="purchaseBill" style="width:300px;" class="selectStyle custom-select">
     <option value="" >--Select--</option>
        <?php
         foreach ($invoices as $rows){
        ?>
        <option value="<?php echo($rows["vendorBillMasterId"]);?>">
        <?php echo($rows["InvoiceNumber"]) ?>
        </option>
        <?php 
         }
        ?>
 </select>
    
<script>
    $(document).ready(function(){
        $("#purchaseBill").customselect();
        
    });
      
</script>