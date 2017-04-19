<script src="<?php echo base_url(); ?>application/assets/js/invoiceStatus.js"></script> 
<section id="loginbox">
  <?php if($mastData){?>
    <h5>Invoice No : <?php  echo ($mastData['purchase_invoice_number']);?> </h5>
    <h5>Vendor Name : <?php  echo ($mastData['vendor_name']);?> </h5>
   <?php } ?>
    
    
</section>
<br><br>


<div id="popupdiv">
     
<table  class="CSSTableGenerator">

 
             
            <td width="25%">Type Of Bag</td>
            <td width="20%">No of Bags</td>
            <td width="20%">Net</td>
            <td width="20%">Blended Bag</td>
            <td width="15%">Bags In Stock</td>
          
            
 
    
     
	<?php 
        if($groupStock)  : 
                foreach ($groupStock as $content) : ?>
    
         <tr>
            
             <td><?php echo($content['bagtype']);?></td>
             <td align="right"><?php echo($content['ActualBags']);?></td>
             <td align="right"><?php echo($content['net']);?></td>
             
             <td align="right">
                  <?php if(($content['number_of_blended_bag'])){?>
                <img src="<?php echo base_url(); ?>application/assets/images/short.png" id="viewBlend_<?php  echo($content['bagDtlId']); ?>"  class="viewBlend" title="Detail" style="cursor: pointer; cursor: hand;"/>
                <?php echo($content['number_of_blended_bag']);?>
                  <?php };?>
             </td>
             
             <td align="right"><?php echo($content['bagInstock']);?></td>
             
         </tr>
    <?php endforeach; 
     else: ?>
         <tr> 
             <td>&nbsp;</td>
             <td> &nbsp;</td>
             <td> No</td>
             <td> Data Found..</td>
          </tr>
    <?php
    endif; 
    ?>
	
</table>
 
    <div id="blend-Detail" title="Details" style="display: none;">
    <div id="dtlRslt"></div>
</div>
</div>