 <select id="saleBill" name="saleBill" style="width:300px;" class="selectStyle custom-select">
     <option value="" >--Select--</option>
        <?php
         foreach ($invoices as $rows){
        ?>
        <option value="<?php echo($rows["customerbillmasterid"]);?>">
        <?php echo($rows["InvoiceNumber"]) ?>
        </option>
        <?php 
         }
        ?>
 </select>

<script>
    $(document).ready(function(){
        $("#saleBill").customselect();
        
    });
      
</script>
    
    
