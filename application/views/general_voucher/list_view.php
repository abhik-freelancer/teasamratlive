<script src="<?php echo base_url(); ?>application/assets/js/generalVoucher.js"></script>
 <h1><font color="#5cb85c" style="font-size:22px;">General Voucher(s)</font></h1>
 

<div class="stats">
  <p class="stat"><a href="<?php echo base_url(); ?>generalvoucher/addGeneralVoucher" class="showtooltip" title="add"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
  <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
</div>

 <!--<pre>
     <?php 
     print_r($bodycontent['voucherlisting']);
     ;?>
 </pre>-->
 <table id="example" class="display" cellspacing="0" width="100%">
     
     <thead>
     <th style="display:none;">VoucherMasterId</th>
    <!-- <th style="display:none;">VoucherDtlId</th>-->
     <th>Voucher Date</th>
     <th>Voucher No.</th>
     <th>Paid to</th>
     <th>Voucher Type</th>
     <th>Account Details</th>
     <th width="">Action</th>
     </thead>
     
     <tbody>
         <?php foreach ($bodycontent['voucherlisting'] as $row){?>
         <tr>
             <td style="display:none;">VoucherMasterId<?php echo $row['voucherMasterId'];?></td>
            <!-- <td style="display:none;"><?php echo $row['voucherDtlId'];?></td>-->
             <td><?php echo $row['VoucherDate']; ?></td>
             <td><?php echo $row['voucher_number']; ?></td>
             <td><?php echo $row['paid_to']?></td>
             <td><?php $chkVouchType= $row['vouchertype'];if($chkVouchType=="RC"){echo "Receipt";}else{echo "Payment";} ?></td>
             <td>
                 <table width="100%">
                     
                    <tr>
                         <th>A/C </th>
                         <th>Amount</th>
                         <th>Dr/Cr</th>
                     </tr>
                     <?php if($row['accountDtl']){
                         foreach($row['accountDtl'] as $value){
                         ?>
                     
                     <tr>
                         <td style="word-wrap: break-word;"><?php echo $value->account_name;?></td>
                         <td><?php echo $value->voucher_amount;?></td>
                         
                          <td><?php $dbCr= $value->drCr;if($dbCr=="Y"){echo "Dr";}else{echo "Cr";}?></td>
                     
                     </tr>
                     <?php }}?>
                 </table>
             </td>
             <td>
                 <a href="<?php echo base_url(); ?>generalvoucher/addGeneralVoucher/id/<?php echo($row['voucherMasterId']); ?>" class="showtooltip" title="Edit">
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editTaxInvoice" title="" alt=""/>
                 </a>
				 <img src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" id="deleteContraVoucher" title="Delete" alt="Delete" onclick="deleterecord(<?php echo($row['voucherMasterId'])?>);" style="cursor:pointer;"/>
             </td>
            
         </tr>
         <?php } ?>
         
     </tbody>
         
 </table>
