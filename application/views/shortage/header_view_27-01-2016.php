<script src="<?php echo base_url(); ?>application/assets/js/shortage.js"></script> 

 <h1><font color="#5cb85c">Short Adjustment</font></h1>

 <div id="adddiv">

  <section id="loginBox" style="width:600px;">
      <form id="frmBagDtls" name="frmBagDtls" method="post" action="<?php echo base_url(); ?>shortageadjustment"  >
      <table>
          <tr>
              <td>Purchase :&nbsp;</td>
              <td>
                  <select id="invoice" name="invoice">
                      
                      <option value="0">Select</option>
                     <?php if($bodycontent['purchaseInvoice']){ 
                         foreach($bodycontent['purchaseInvoice'] as $content){
                         ?>
                            
                                <option value="<?php echo($content->id); ?>" <?php if($content->id==$bodycontent['selected_inpoice']){echo("selected=selected");} ?>><?php echo($content->purchase_invoice_number); ?></option>
                      
                      <?php } }?>
                  </select>
              </td>
          </tr>
          
           <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
          </tr>
          
          
          
          
          <tr>
              <td>Transporter :&nbsp;</td>
              <td>
                  <select id="drpTransporter" name="drpTransporter">
                      <option value="0">Select</option>
                      <?php if($bodycontent['transporterlist']){ 
     foreach ($bodycontent['transporterlist'] as $content) {
                      ?>
                      <option value="<?php echo($content->id) ?>" <?php if($content->id==$bodycontent['selected_transporter']){echo("selected=selected");} ?>><?php echo($content->name); ?></option>
                     
                      <?php 
                         }
                      }
                      ?>
                  </select>
              </td>
          </tr>
          
          <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
          </tr>
      </table>
         
      </form>
    
  <span class="buttondiv"><div class="save" id="shortage" align="center"> Show </div></span>
  </section>
  
 </div>
 
 
 <div id="popupdiv"  style="<?php if($bodycontent['invoiceBagDtls']){echo("display:block;");}else{echo("display:none;");}?>" title="Detail">
     <table id="example" class="display" cellspacing="0" width="100%">
         
     <thead bgcolor="#a6a6a6">
        <th>Sl.</th>
        <th>Invoice</th>
        <th>Do.No</th>
        <th>Bag</th>
        <th>No.Of Bags</th>
        <th>Actual Bags</th>
        <th>Net</th>
        <th>Action</th>
        
    </thead>
    <?php    
    $serial =1;
    foreach ($bodycontent['invoiceBagDtls'] as $content)
        {?>
    <tr>
        <td>
            <?php echo($serial);?>
            <input type="hidden" id="purDtlId_<?php echo($serial);?>" value="<?php echo($content->pDtlId);?>"/>
            <input type="hidden" id="purMst_<?php echo($serial);?>" value="<?php echo($content->pMstId);?>"/>
            <input type="hidden" id="purBagDtl_<?php echo($serial);?>" value="<?php echo($content->pBagDtlId);?>"/>
            
            <input type="hidden" id="parentBagId_<?php echo($serial);?>" value="<?php echo($content->parent_bag_id);?>"/>
            
        </td>
         <td><?php echo($content->invoice_number);?></td>
          <td><?php echo($content->do);?></td>
           <td><?php echo($content->bagtype); ?></td>
            <td>
                <?php echo($content->no_of_bags); ?>
                <input type="hidden" id="noShortBag_<?php echo($serial);?>" value="<?php echo($content->no_of_bags); ?>"/>
            </td>
             <td>
                 <?php echo($content->actual_bags); ?>
                 <input type="hidden" id="txtActual_<?php echo($serial);?>" value="<?php echo($content->actual_bags); ?>"/>
             </td>
              <td>
                  <?php echo($content->net); ?>
                  <input type="hidden" id="txtnet_<?php echo($serial); ?>" value="<?php echo($content->net); ?>"/>
                  <input type="hidden" id="txtShortKgs_<?php echo($serial); ?>" value="<?php echo($content->shortkg);?>"/>
              </td>
              <td>
                  <?php if($content->bagtypeid!=3){ ?>
                  <img onclick="openShortage(<?php echo $content->pBagDtlId ?>,<?php echo($serial);?>);" src="<?php echo base_url(); ?>application/assets/images/short.png" title="Short" style="cursor: pointer; cursor: hand;"/>
                  <?php }else{ ?>
                  <img onclick="updateShortage(<?php echo $content->pBagDtlId ?>,<?php echo($serial);?>);" src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" title="Edit" style="cursor: pointer; cursor: hand;"/>
                  <img onclick="deleteShortage(<?php echo ($content->pBagDtlId);?>,<?php echo($serial);?>);" src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" title="Delete" style="cursor: pointer; cursor: hand;"/>
                  <?php } ?>
              </td>
    </tr>
    <?php 
        $serial++;
        }
        ?>
    
   
    </table>
    
	

 </div>
 <div id="dialog_shortage" title="Shortage" style="display:none;">
     <table cellspacing="4" width="100%" style="margin-left:5px; margin-top:5px;">
         <tr>
             <td>No.of Bags</td>
             <td><input type="text" id="txtnoofbags" value="" class="groupOfTexbox"/></td>
         </tr>
         <tr>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
         </tr>
         <tr>
             <td>short(Kgs.)</td>
             <td><input type="text" id="txtshortage" value="" class="groupOfTexbox"/></td>
         </tr>
         
     </table>
     
</div>
 
 <div id="dialog-confirm-shortage" title="Delete" style="display:none;">
  <p> These items will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>
 
 
