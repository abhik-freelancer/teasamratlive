

 <h1><font color="#5cb85c" style="font-size:20px;">Raw Material Purchase List(GST)</font></h1>
 <div class="stats">
 
    <p class="stat"><a href="<?php echo base_url(); ?>rawmaterialpurchase/gstAddRawMaterialpurchase" class="showtooltip" title="add">
            <img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
    <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
</div>

  

     
<table id="example" class="display" cellspacing="0" width="100%">

    <thead bgcolor="#CCCCCC">
         
          <th>Invoice No.</th>
          <th>Invoice Date</th>
          <th>Vendor</th>
          <th>Amount</th>
          <th>Action</th>
    </thead>
    
     <tbody>
	<?php 
       
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
         <tr>
            
             <td><?php echo $content['invoice_no'];?>
                 <input type="hidden" name="RawMaterialpurchaseId" value="<?php echo $content['rawMatPurchMastId'];?>" />
             </td>
             <td><?php echo $content['InvoiceDate'];?></td>
             <td><?php echo $content['vendor_name'];?></td>
             <td ><?php echo $content['invoice_value'];?></td>
             <td>
                 <a href="<?php echo base_url(); ?>rawmaterialpurchase/gstAddRawMaterialpurchase/id/<?php echo($content['rawMatPurchMastId']); ?>" class="showtooltip" title="Edit">
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editTaxInvoice" title="" alt=""/>
                 </a>
                
                
             </td>
         </tr>
    <?php endforeach; 
     else: ?>
         <tr> 
           
           
             <td> &nbsp;</td>
             <td> &nbsp;</td>
             <td> &nbsp;</td>
             <td> &nbsp;</td>
             <td> &nbsp;</td>
          
         </tr>
    <?php
    endif; 
    ?>
	 </tbody>
</table>
