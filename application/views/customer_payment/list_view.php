<script src="<?php echo base_url(); ?>application/assets/js/customerpayment.js"></script> 

 <h2><font color="#5cb85c">Customer receipt list</font></h2>
 <div class="stats">
 
    <p class="stat">
        <a href="<?php echo base_url(); ?>customerpayment/addCustomerPayment" class="showtooltip" title="add">
            <img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a>
    </p>
    <p class="stat">
        <a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/>
    </a>
    </p>
    
</div>
 
 <div id="dialog-detail-view" title="Bill details">
 
            <div id="detailInvoice">
     
            </div>
     
 </div>
 
 <div id="popupdiv">
     <table id="example" class="display" cellspacing="0" width="100%">

    <thead bgcolor="#CCCCCC">
<!--            <th>Blend No.</th>-->
            <th>Voucher</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Debit</th>
            <th>Customer</th>
            <th style="text-align:right;">Action</th>
    </thead>
    <tbody>
       <?php 
        if($bodycontent)  : 
		$x = 1;
                foreach ($bodycontent as $content) : 
				
				?>
        <tr>
            <td><?php echo($content['voucher_number']);?></td>
            <td><?php echo($content['dateofpayment']);?></td>
            <td><?php echo($content['totalpaidamount']);?></td>
            <td><?php echo($content['debit_account']);?></td>
            <td><?php echo ($content['customer_name']);?></td>
            <td style="text-align:right;"> 
                <a href="<?php echo base_url(); ?>customerpayment/addCustomerPayment/id/<?php echo($content['customerpaymentid']); ?>" class="showtooltip" title="Edit">
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editTaxInvoice" title="" alt=""/>
                 </a>
				 
				<a href="javascript:;" class="showtooltip" title="Delete" >
                  <img src="<?php echo base_url(); ?>application/assets/images/delete.png" id="deleteCustomerRecpt" title="" alt="" width="20" height="20" onclick="delCustomerReceipt(<?php echo ($content['customerpaymentid']); ?>,'<?php echo $content['voucher_number']; ?>')" />
                </a>
				 
                <!-- 30-03-2017 temporary stop this 
				<img src="<?php echo base_url(); ?>application/assets/images/view_small.png" id="<?php echo($content['customerpaymentid']); ?>" class="paymentDetails" title="view adjust" alt="" style="cursor: pointer;"/>
				-->
                
            </td>

        </tr>
      <?php 
	  $x++;
	  endforeach; 
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
    
 </div>
 
 
 
<div id="dialog-confirm-cutomer-receipt" title="Delete" style="display: none;">
  <p style="padding:8px;">
  Voucher : <span id="voucher_no-info"></span> will be permanently deleted.<br>Do you Want to continue...</p>
</div>


<div id="dialog-confirm-delete" title="Delete" style="display: none;">
  <p style="padding:8px;">
	Voucher : <span id="voucher_no-afterdlt"></span> deleted successfully.
  </p>
</div>






 