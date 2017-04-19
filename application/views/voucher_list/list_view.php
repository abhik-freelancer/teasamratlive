

      
   <table id="example" class="display" cellspacing="0" width="100%;" border="0" >
         
     <thead bgcolor="#a6a6a6">
         <tr>
        <th>Sl.</th>
        <th>Voucher No.</th>
        <th>Voucher Date</th>
        <th>Narration</th>
        <th>Voucher<br>Type</th>
        <th>Voucher Detail</th>
        <th>Action</th>
         </tr>
        
    </thead>
    
    <tbody>
           <?php if($voucherlist){
               $j=1;
               foreach($voucherlist as $content){?>
        <tr>
                <td><?php echo $j++;?></td>
                <td><?php echo $content['voucher_number']?></td>
                <td><?php echo $content['VoucherDate']?></td>
                <td><?php echo $content['narration']?></td>
                <td>
                    <?php $purType= $content['transaction_type'];
                            if($purType=="PR"){
                                echo "Purchase";
                            }
                            if($purType=="CN"){
                                echo "Contra";
                            }
                            if($purType=="GV"){
                                echo "General";
                            }
                            if($purType=="JV"){
                                echo "Journal";
                            }
                             if($purType=="SL"){
                                echo "Sale";
                            }
                    ?>
                    
                
                </td>
                <td>
                    <table width="100%">
                     
                    <tr>
                         <th>A/C Description </th>
                         <th>Amount</th>
                         <th>Dr/Cr</th>
                     </tr>
                     <?php if($content['voucherDtl']){
                         foreach($content['voucherDtl'] as $value){
                         ?>
                     
                     <tr>
                         <td><?php echo $value->account_name;?></td>
                         <td><?php echo $value->voucher_amount;?></td>
                         
                          <td><?php $dbCr= $value->drCr;if($dbCr=="Y"){echo "Dr";}else{echo "Cr";}?></td>
                     
                     </tr>
                    
                     <?php }}?>
                 </table>
                    
                </td>
                <td>
                    
                      <!--Purchase  Edit -->
                    <?php  if($content['transaction_type']=="PR"){?>
                    <!-- <a href="<?php echo base_url(); ?>contravoucher/addContraVoucher/id/<?php echo $content['id']; ?>" class="showtooltip" title="edit" id="<?php echo $content['id']; ?>">
                     <img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" height="18" width="18" /></a>-->
                   <?php } ?>
                    
                    <!--Contra Voucher Edit -->
                  <?php  if($content['transaction_type']=="CN"){?>
                     <a href="<?php echo base_url(); ?>contravoucher/addContraVoucher/id/<?php echo $content['id']; ?>" class="showtooltip" title="edit" id="<?php echo $content['id']; ?>">
                     <img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" height="18" width="18" /></a>
                   <?php } ?>
                    
                    <!--Journal Voucher Edit -->
                    <?php  if($content['transaction_type']=="JV"){?>
                     <a href="<?php echo base_url(); ?>journalvoucher/addJournleVoucher/id/<?php echo $content['id']; ?>" class="showtooltip" title="edit" id="<?php echo $content['id']; ?>">
                     <img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" height="18" width="18" /></a>
                   <?php } ?>
                    
                      <!--General Voucher Edit -->
                    <?php  if($content['transaction_type']=="GV"){?>
                     <a href="<?php echo base_url(); ?>generalvoucher/addGeneralVoucher/id/<?php echo $content['id']; ?>" class="showtooltip" title="edit" id="<?php echo $content['id']; ?>">
                     <img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" height="18" width="18" /></a>
                   <?php } ?>
                    
                </td>
                
        </tr>
        
               <?php }
           }else{?>
                
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>No Data</td>
              <td>Found;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
        
           <?php } ?>
        
         
    </tbody>                                              
    </table>

<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>application/assets/js/jquery.dataTables.min.js"></script>
<script>
$( document ).ready(function() {
    $("#example").DataTable();
});
</script>
     

