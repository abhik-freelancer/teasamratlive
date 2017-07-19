<script src="<?php echo base_url(); ?>application/assets/js/purchaseinvoicelst.js"></script> 

 <h2><font color="#5cb85c">Purchase list(GST)</font></h2>
 
 <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2">
       
    </div>
    <div class="col-md-2">
         <a href="<?php echo base_url(); ?>gstpurchaseinvoice/addPurchaseInvoice" class="btn btn-info" role="button">Add new</a>
        <a href="<?php echo base_url(); ?>gstpurchaseinvoice" class="btn btn-info" role="button">List</a>
    </div>
    
 </div>
 <div class="row">
     <div class="col-lg-12">
         &nbsp;
     </div>
 </div>

  
 <div class="container-fluid">
    <table class="table table-bordered table-condensed" id="example">
    <thead>
      <tr>
        <th>Invoice</th>
        <th>Date</th>
        <th>Vendor</th>
        <th>Sale</th>
        <th>Type</th>
        <th>Bag</th>
        <th>Qty(Kg)</th>
        <th>Tea value</th>
        <th>Amount</th>
        <th>Action</th>
        
      </tr>
    </thead>
    <tbody>
      <?php foreach ($bodycontent as $row) {?>
            <tr>
             <td><?php echo($row['purchase_invoice_number']);?></td>
             <td><?php echo($row['purchase_invoice_date']);?></td>
             <td><?php echo($row['vendor_name']);?></td>
             <td><?php echo($row['sale_number']);?></td>
             <td><?php echo($row['purchaseType']);?></td>
             <td><?php echo($row['total_bags']);?></td>
             <td><?php echo($row['total_kgs']);?></td>
             <td><?php echo($row['tea_value']);?></td>
             <td><?php echo($row['total']);?></td>
             <td>
                 <a href="<?php echo base_url(); ?>gstpurchaseinvoice/addPurchaseInvoice/id/<?php echo($row['id'])?>" class="btn btn-info btn-xs" role="button">Edit</a>
                 <a href="#" class="btn btn-danger  btn-xs" role="button">Del</a>
                 
             </td>
            </tr>
        
        
       <?php } ?>
    </tbody>
  </table>
 </div>