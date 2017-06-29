<script src="<?php echo base_url(); ?>application/assets/js/addStockOutpurchase.js"></script>

 <h1><font color="#5cb85c" style="font-size:24px;">Stock Transfer(Out) List</font></h1>
 <div class="stats">
 
        <p class="stat"><a href="<?php echo base_url(); ?>stocktransferout/addStockTransferOut" class="showtooltip" title="add"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
    <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
</div>

  
 <div id="popupdiv">
     
<table id="example" class="display" cellspacing="0" width="100%">

    <thead bgcolor="#CCCCCC">

            <th>Refrence No</th>
            <th>Transfer Date</th>
            <th>Customer</th>
            <th>Stock Out Bag</th>
            <th>Total Stock Out(Kgs.)</th>
            <th>Action</th>
    </thead>
    
     <tbody>
	<?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
         <tr>

             <td><?php echo($content->refrence_number);?></td>
             <td><?php echo($content->TransferDt);?></td>
             <td><?php echo($content->customer_name);?></td>
             <td align="right"><?php echo($content->stock_outBags);?></td>
             <td align="right"><?php echo($content->totalStockOutKgs);?></td>
             <td>
                 <a href="<?php echo base_url(); ?>stocktransferout/addStockTransferOut/id/<?php echo($content->StockOutmastId); ?>" class="showtooltip" title="Edit">
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editBlend" title="" alt=""/>
                 </a>
                 
                  <img src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" id="deleteOpInv" title="" alt="" onclick="deleterecord(<?php echo ($content->StockOutmastId);?>)"/>
                 
                <!-- <img src="<?php echo base_url(); ?>application/assets/images/short.png" id="viewBlend_<?php echo($content->id); ?>"  class="viewBlend" title="Detail" style="cursor: pointer; cursor: hand;"/>
                 <img src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" id="delBlend" title="Delete" alt="Delete"/>
                 <a href="<?php echo base_url(); ?>blending/printBlendSheet/blendId/<?php echo($content->id); ?>" class="showtooltip" title="Print" target="_blank">
                 <img src="<?php echo base_url(); ?>application/assets/images/print_sheet.png" id="prnBlendSheet"  title="Print" alt="Print"/>
                 </a>-->
                 
             </td>
         </tr>
    <?php endforeach; 
     else: ?>
         <tr> 
             <td>&nbsp;</td>
             <td> &nbsp;</td>
             <td> No</td>
             <td> Data Found..</td>
             <td> &nbsp;</td>
             <td> &nbsp;</td>
            
         
         </tr>
    <?php
    endif; 
    ?>
	 </tbody>
</table>
<div id="dialog-confirm" title="Delete product" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Do you want to remove the product?</p>
</div>

     
<div id="blend-Detail" title="Details" style="display: none;">
    <div id="dtlRslt"></div>
</div>

 </div>