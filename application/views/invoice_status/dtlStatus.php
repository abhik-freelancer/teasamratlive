<script src="<?php echo base_url(); ?>application/assets/js/invoiceStatus.js"></script> 
<section id="loginbox">
  <!--<?php if($mastData){?>
    <h5>Invoice No : <?php  echo ($mastData['purchase_invoice_number']);?> </h5>
    <h5>Vendor Name : <?php  echo ($mastData['vendor_name']);?> </h5>
   <?php } ?>-->
   <table width="50%">
       <tr>
           <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">Invoice No.</font></td>
           <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">:</font></td>
           <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:normal"><?php  echo ($mastData['purchase_invoice_number']);?></font></td>
       </tr>
        <tr>
            <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">Vendor Name</font></td>
            <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">:</font></td>
            <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:normal"><?php  echo ($mastData['vendor_name']);?></font></td>
       </tr>
       <tr>
           <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">Sent To</font></td>
            <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">:</font></td>
            <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:normal"><?php  echo ($mastData['transporterName']);?></font></td>
       </tr>
       <tr>
           <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">Stock Status</font></td>
            <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">:</font></td>
            <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:normal">
                <?php  
                $checkStock= $mastData['instock'];
                if($checkStock=='N'){
                    $stockStatus="Not in Stock";
                }
                if($checkStock=="Y"){
                    $stockStatus="In Stock";
                }
                      echo $stockStatus;  ?>
                </font></td>
       </tr>
       <tr>
           <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">Send Status</font></td>
            <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">:</font></td>
            <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:normal">
                <?php  
                $checkSend= $mastData['isSent'];
                if($checkSend=='N'){
                    $sendStatus="Pending";
                }
                if($checkSend=="Y"){
                    $sendStatus="Send to ".$mastData['transporterName'];
                }
                      echo $sendStatus;  ?>
                </font></td>
       </tr>
       <tr>
           <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">Challan Date</font></td>
            <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:bold">:</font></td>
            <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:11px; font-weight:normal"><?php  echo ($mastData['ChallanDt']);?></font></td>
       </tr>
   </table>
       
    
    
</section>
<br><br>


<div id="popupdiv">
     
<table  class="CSSTableGenerator">

 
             
            <td width="10%">Type Of Bag</td>
            <td width="10%">No of Bags</td>
            <td width="10%">Net</td>
            <td width="15%">Blended Bag</td>
            <td width="15%">StockOut Bag</td>
            <td width="15%">Sale Bag</td>
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
              <td align="right">
                  <?php if(($content['number_of_stockout_bag'])){?>
                <img src="<?php echo base_url(); ?>application/assets/images/short.png" id="viewStockOutDtl_<?php  echo($content['bagDtlId']); ?>"  class="viewStockOutDtl" title="StockOut Detail" style="cursor: pointer; cursor: hand;"/>
                <?php echo($content['number_of_stockout_bag']);?>
                  <?php };?>
             </td>
             <td align="right">
                  <?php if(($content['number_of_SaleBag'])){?>
                <img src="<?php echo base_url(); ?>application/assets/images/short.png" id="viewSaleOutDtl_<?php  echo($content['bagDtlId']); ?>"  class="viewSaleOutDtl" title="Detail" style="cursor: pointer; cursor: hand;"/>
                <?php echo($content['number_of_SaleBag']);?>
                  <?php };?>
             </td>
             
             <td align="right"><?php 
             
             if($content['net']==0){
                  $stockValue = 0;
                 
             }
             else{
                 $stockValue=$content['bagInstock'];
             }
             
             
             $chkStock=$content['in_Stock'];
             if($chkStock=='N'){
                 echo '0';
             }
             if($chkStock=='Y'){
                 echo $stockValue;
             }
             
             ?></td>
             
         </tr>
    <?php endforeach; 
     else: ?>
         <tr> 
             <td>&nbsp;</td>
             <td> &nbsp;</td>
             <td> </td>
             <td> </td>
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
    
   <!-- <div id="StockOut-Detail" title="Details" style="display: none;">
    <div id="dtlRslt"></div>
    </div>
    -->
    
</div>