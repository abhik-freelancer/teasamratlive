<script src="<?php echo base_url(); ?>application/assets/js/vendoradvanceadjust.js"></script> 

 <h2><font color="#5cb85c">Vendor adjustment payment list</font></h2>
 <div class="stats">
 
    <p class="stat">
        <a href="<?php echo base_url(); ?>vendoradvanceadjustment/addEditAdjustment" class="showtooltip" title="add">
            <img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a>
    </p>
    <p class="stat">
        <a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/>
    </a>
    </p>
    
</div>
 <div id="dialog-detail-view" title="Bill details" >
 
            <div id="detailInvoice">
     
            </div>
     
 </div>


 <div id="popupdiv">
     <table id="example" class="display" cellspacing="0" width="100%">

    <thead bgcolor="#CCCCCC">
<!--            <th>Blend No.</th>-->
            <th>RefNo</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Vendor</th>
            <th>Action</th>
    </thead>
    <tbody>
       <?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
        <tr>
            <td><?php echo($content['AdjustmentRefNo']);?></td>
            <td><?php echo($content['DateOfAdjustment']);?></td>
            <td><?php echo($content['TotalAmountAdjusted']);?></td>
            <td><?php echo($content['vendor_name']);?></td>
            <td> 
                <a href="<?php echo base_url(); ?>vendoradvanceadjustment/addEditAdjustment/id/<?php echo($content['AdjustmentId']); ?>" class="showtooltip" title="Edit">
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editvendoradjust" title="Edit" alt="Edit"/>
                </a>
                <img src="<?php echo base_url(); ?>application/assets/images/view_small.png" id="<?php echo($content['AdjustmentId']); ?>" title="view adjust" alt="" style="cursor: pointer;" class="paymentDetails" />
                
                <a href="<?php echo base_url(); ?>vendoradvanceadjustment/delete/id/<?php echo($content['AdjustmentId']); ?>"
                   class="showtooltip" title="Delete" onclick="return confirm('Are you sure to delete?')">
                  <img src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" id="editvendoradjust" title="Edit" alt="Edit"/>
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
             
            
         
         </tr>
    <?php
    endif; 
    ?>
    </tbody>
     </table>
    
 </div>
