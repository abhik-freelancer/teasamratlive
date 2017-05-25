<script src="<?php echo base_url(); ?>application/assets/js/customeradvance.js"></script> 

 <h2><font color="#5cb85c">Customer advance list</font></h2>
 <div class="stats">
 
    <p class="stat">
        <a href="<?php echo base_url(); ?>customeradvance/addEdit" class="showtooltip" title="add">
            <img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a>
    </p>
    <p class="stat">
        <a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/>
        </a>
    </p>
    
</div>
 <div id="popupdiv">
     <table id="example" class="display" cellspacing="0" width="100%">

    <thead bgcolor="#CCCCCC">
<!--            <th>Blend No.</th>-->
            <th>Voucher</th>
            <th>Advance Date</th>
            <th>Advance Amount</th>
            <th>Customer</th>
            <th style="text-align:right;">Action</th>
    </thead>
    <tbody>
       <?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
        <tr>
            <td><?php echo($content['voucher_number']);?></td>
            <td><?php echo($content['advanceDate']);?></td>
            <td><?php echo($content['advanceAmount']);?></td>
            <td><?php echo($content['account_name']);?></td>
            <td style="text-align:right;">
                 <?php if($content['editable']!=0) {?>
                <a href="<?php echo base_url(); ?>customeradvance/addEdit/id/<?php echo($content['advanceId']); ?>" class="showtooltip" title="Edit">
                
                    <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editCustomerAdvance" title="" alt=""/>
                
                </a>
				
				
				<a href="javascript:;" class="showtooltip" title="Delete" >
                  <img src="<?php echo base_url(); ?>application/assets/images/delete.png" id="deleteCustomer" title="" alt="" width="20" height="20" onclick="delCustomerAdvance(<?php echo ($content['advanceId']); ?>,'<?php echo $content['voucher_number']; ?>')" />
                </a>
				
                <?php } ?>
                
             
                
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
             
            
         
         </tr>
    <?php
    endif; 
    ?>
    </tbody>
     </table>
    
 </div>
 
 
 
 
  
<div id="dialog-confirm-cusadv" title="Delete" style="display: none;">
  <p style="padding:8px; font-size:13px;">
  Voucher : <span id="voucher_no-info" style="font-weight:700;color:red;"></span> will be permanently deleted.<br>Do you Want to continue...</p>
</div>


<div id="dialog-confirm-delete" title="Delete" style="display: none;">
  <p style="padding:8px;font-size:13px;">
	Voucher : <span id="voucher_no-afterdlt" style="font-weight:700;color:red;"></span> deleted successfully.
  </p>
</div>


<div id="dialog-used-vouchr" title="Delete" style="display: none;">
  <p style="padding:8px;font-size:13px;">
	This Voucher is used.
  </p>
</div>


