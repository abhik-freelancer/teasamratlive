<script src="<?php echo base_url(); ?>application/assets/js/openingbalance_invoice.js"></script> 

 <h1><font color="#5cb85c" style="font-size:22px;">Opening Balance Invoice List</font></h1>
 <div class="stats">
 
    <p class="stat"><a href="<?php echo base_url(); ?>openingbalance/addOpeningInvoiceBlnc" class="showtooltip" title="add"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
    <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
</div>

  
 <div id="popupdiv">
     
<table id="example" class="display" cellspacing="0" width="100%">
    <?php 
      /*  echo "<pre>";
            print_r($bodycontent['openingInvlist']);
        echo "</pre>";*/
    ?>
    <thead bgcolor="#CCCCCC">
<!--            <th>Blend No.</th>-->
            <th style="display:none;">DtlId</th>
            <th>Invoice No</th>
            <th>Invoice date</th>
            <th>Garden</th>
            <th>Location</th>
            <th>Lot No</th>
            <th>sale No</th>
            <th>Total Kgs.</th>
            <th>Tea value</th>
            <th>Action</th>
    </thead>
    
     <tbody>
	
       <?php 
        if($bodycontent['openingInvlist'])  : 
                foreach ($bodycontent['openingInvlist'] as $content) : ?>
    
         <tr>
             <td style="display:none;"><?php echo ($content['pinvDtlId']);?></td>
             <td><?php echo ($content['invoice_number']);?></td>
             <td><?php echo ($content['invoice_date']);?></td>
             <td><?php echo ($content['garden_name']);?></td>
             <td><?php echo ($content['location']);?></td>
             <td><?php echo ($content['lot']);?></td>
             <td><?php echo ($content['sale_number']);?></td>
             <td><?php echo ($content['total_weight']);?></td>
             <td><?php echo ($content['total_value']);?></td>
             <td>
                 <!--<a href="<?php echo base_url(); ?>openingbalance/addOpeningInvoiceBlnc/id/<?php echo ($content['pMastId']);?>" class="showtooltip" title="Edit" >
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editBlend" title="" alt=""/>
                 </a>-->
                 
               
                  <img src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" id="deleteOpInv" title="" alt="" onclick="deleterecord(<?php echo ($content['pMastId']);?>)"/>
                
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