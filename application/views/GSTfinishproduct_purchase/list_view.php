<script src="<?php echo base_url(); ?>application/assets/js/taxInvoice_fprod.js"></script> 

 <h2><font color="#5cb85c">Finish Product Purchase (GST)</font></h2>
 <div class="stats">
 
    <p class="stat"><a href="<?php echo base_url(); ?>GSTfinishproductpurchase/addTaxInvoice" class="showtooltip" title="add">
            <img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
    <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
</div>

  
 <div id="popupdiv">
     
<table id="example" class="display" cellspacing="0" width="100%">

    <thead bgcolor="#CCCCCC">
<!--            <th>Blend No.</th>-->
            <th>Vendor Name</th>
            <th>bill no.</th>
            <th>bill Date</th>
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
             <td><?php echo($content['vendor_name']);?></td>
             <td><?php echo($content['purchasebillno']);?></td>
             <td><?php echo($content['purchasebilldate']);?></td>
             <td><?php echo(number_format($content['totalpacket']));?></td>
             <td><?php echo($content['totalquantity']);?></td>
             <td><?php echo($content['grandtotal']);?></td>
             <td>
                 <a href="<?php echo base_url(); ?>GSTfinishproductpurchase/addTaxInvoice/id/<?php echo($content['id']); ?>" class="showtooltip" title="Edit">
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editTaxInvoice" title="" alt=""/>
                 </a>
                
                 <!--
                 <a href="<?php echo base_url(); ?>finishproductpurchase/printSaleBill/taxInvId/<?php echo($content['id']); ?>" class="showtooltip" title="Print" target="_blank">
                 <img src="<?php echo base_url(); ?>application/assets/images/print_sheet.png" id="prnSaleBill"  title="Print" alt="Print"/>
                 </a>
                 <a href="<?php echo base_url(); ?>finishproductpurchase/print_item/taxInvId/<?php echo($content['saleBillMasterId']); ?>" class="showtooltip" title="Pdf" target="_blank">
                 <img src="<?php echo base_url(); ?>application/assets/images/pdf.png" id="prnSaleBill"  title="Pdf" alt="Pdf" width="20" height="20"/>
                 </a>
                 -->
                
                
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