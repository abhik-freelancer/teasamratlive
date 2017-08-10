<h2><font color="#5cb85c">(GST) Service purchase</font></h2>
 
 <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2">
       
    </div>
    <div class="col-md-2">
         <a href="<?php echo base_url(); ?>gstservicepurchase/gstServicePurchaseAdd" class="btn btn-info" role="button">Add new</a>
        <a href="<?php echo base_url(); ?>gstservicepurchase" class="btn btn-info" role="button">List</a>
    </div>
    
 </div>
 <div class="row">
     <div class="col-lg-12">
         &nbsp;
     </div>
 </div>

  
<div class="container-fluid">
    <table class="table table-bordered table-condensed" id="example">

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
                 <a href="<?php echo base_url(); ?>gstservicepurchase/gstServicePurchaseAdd/id/<?php echo($content['rawMatPurchMastId']); ?>" class="showtooltip" title="Edit">
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
</div>
     

