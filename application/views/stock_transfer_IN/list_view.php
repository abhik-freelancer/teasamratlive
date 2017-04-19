<script src="<?php echo base_url(); ?>application/assets/js/addStockINpurchase.js"></script> 
 <h1><font color="#5cb85c" style="font-size:22px;">Stock Transfer(IN) List</font></h1>
 <div class="stats">
 
    <p class="stat"><a href="<?php echo base_url(); ?>stocktransferin/addPurchaseInvoice" class="showtooltip" title="add"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
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
            <th style="display:none;">PurMasterId</th>
            <th>Refrence No.</th>
            <th>Transfer Dt</th>
            <th>Receipt Dt</th>
            <th>Vendor</th>
          <!--  <th>Bag Detail</th>-->
            <th>Total Bags</th>
            <th>Total Kgs</th>
            <th>Tea Value</th>
           <th>Action</th>
    </thead>
    
     <tbody>
	
       <?php 
        if($bodycontent['stockTransferIn'])  : 
                foreach ($bodycontent['stockTransferIn'] as $content) : ?>
    
         <tr>
             <td style="display:none;"><?php echo "MaterId-".($content['pMastId'])."/"."PurchaseDtlId - ".($content['purDtlId']);?></td>
             <td><?php echo ($content['refrenceNo']);?></td>

             <td><?php echo ($content['transferDt']);?></td>
             <td><?php echo ($content['receiptDt']);?></td>
             <td><?php echo ($content['vendor_name']);?></td>
             <!-- <td>
                <table>
                     <tr>
                         <td>BagType</td>
                         <td>No of Bag</td>
                         <td>Net</td>
                     </tr>
                     <?php foreach($content['bagdtl'] as $bagDtl){ ?>
                     <tr>
                         <td><?php echo $bagDtl['bagtype'];?></td>
                         <td><?php echo $bagDtl['no_of_bags'];?></td>
                         <td><?php echo $bagDtl['net'];?></td>
                     </tr>
                     <?php }?>
                 </table>
             </td>-->
             <td><?php echo ($content['total_bags']); ?></td>
             <td><?php echo ($content['totalkgs']); ?></td>
             <td><?php echo ($content['tea_value']);?></td>
             
             <td>
               <a href="<?php echo base_url(); ?>stocktransferin/addPurchaseInvoice/id/<?php echo $content['pMastId']; ?>" 
			   class="showtooltip" title="edit" id="<?php echo $content['pMastId']; ?>">
                         <img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" height="18" width="18" />
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
                         <td> &nbsp;</td>
                         <td> &nbsp;</td>
                         

                     </tr>
                <?php
                endif; 
                ?>


	 </tbody>
</table>



 </div>