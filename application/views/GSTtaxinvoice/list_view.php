<script src="<?php echo base_url(); ?>application/assets/js/GSTtaxInvoice.js"></script> 

 <h2><font color="#5cb85c">Sale Bill (GST) List</font></h2>
 <div class="stats">
 
    <p class="stat"><a href="<?php echo base_url(); ?>GSTtaxinvoice/addTaxInvoice" class="showtooltip" title="add">
    <img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
    <p class="stat"><a href="<?php echo base_url(); ?>GSTtaxinvoice"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
</div>

  
 <div id="popupdiv">
     
<table id="example" class="display" cellspacing="0" width="100%">

    <thead bgcolor="#CCCCCC">
<!--            <th>Blend No.</th>-->
            <th>Customer Name</th>
            <th>Salebill no.</th>
            <th>Salebill Date</th>
            <th>Packets</th>
            <th>Qty(kgs)</th>
            <th>Amount</th>
            <th>Action</th>
    </thead>
    
     <tbody>
	<?php 
       
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
         <tr>
             <td><?php echo($content['customer_name']);?></td>
             <td><?php echo($content['saleBillNo']);?></td>
             <td><?php echo($content['saleBillDate']);?></td>
             <td><?php echo(number_format($content['numberOfpacket']));?></td>
             <td><?php echo($content['totalQty']);?></td>
             <td><?php echo($content['grandTotal']);?></td>
             <td>
                 <a href="<?php echo base_url(); ?>GSTtaxinvoice/addTaxInvoice/id/<?php echo($content['saleBillMasterId']); ?>" class="showtooltip" title="Edit">
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editTaxInvoice" title="" alt=""/>
                 </a>
                 <!--<img src="<?php echo base_url(); ?>application/assets/images/short.png" id="viewfinishpacket_<?php echo($content['finishProdId']); ?>"  class="viewfinishpacket" title="Detail" style="cursor: pointer; cursor: hand;"/>
                 <img src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" id="delBlend" title="Delete" alt="Delete"/>-->
                 <a href="<?php echo base_url(); ?>GSTtaxinvoice/printSaleBill/taxInvId/<?php echo($content['saleBillMasterId']); ?>" class="showtooltip" title="Print" target="_blank">
                 <img src="<?php echo base_url(); ?>application/assets/images/print_sheet.png" id="prnSaleBill"  title="Print" alt="Print"/>
                 </a>
                 <a href="<?php echo base_url(); ?>GSTtaxinvoice/print_item/taxInvId/<?php echo($content['saleBillMasterId']); ?>" class="showtooltip" title="Pdf" target="_blank">
                 <img src="<?php echo base_url(); ?>application/assets/images/pdf.png" id="prnSaleBill"  title="Pdf" alt="Pdf" width="20" height="20"/>
                 </a>
                
                
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

     
<div id="finish_product-detail" title="Details" style="display: none;">
    <div id="dtlRslt"></div>
</div>

 </div>