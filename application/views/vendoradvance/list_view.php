<script src="<?php echo base_url(); ?>application/assets/js/vendoradvance.js"></script> 

 <h2><font color="#5cb85c">Vendor advance payment list</font></h2>
 <div class="stats">
 
    <p class="stat">
        <a href="<?php echo base_url(); ?>vendoradvance/addEditAdvance" class="showtooltip" title="add">
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
            <th>Vendor</th>
            <th>Action</th>
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
            <td>
                <?php if($content['editable']!=0) {?>
                <a href="<?php echo base_url(); ?>vendoradvance/addEditAdvance/id/<?php echo($content['advanceId']); ?>" class="showtooltip" title="Edit">
                
                    <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editTaxInvoice" title="" alt=""/>
                
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
