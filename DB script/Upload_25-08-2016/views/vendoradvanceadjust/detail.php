 <select id="purchaseBill" name="purchaseBill" style="width:300px;" class="selectStyle">
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
    
