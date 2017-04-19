<script src="<?php echo base_url(); ?>application/assets/js/productSaleRate.js"></script> 

 <h1><font color="#5cb85c">Product's Sale Rate</font></h1>

 
 <div id="popupdiv"  style="" title="Detail">
    <div id="loaderDiv" name="loaderDiv" style="display:none;padding-left: 300px;">
        <img src="<?php echo base_url(); ?>application/assets/images/update_ajax.gif"/>
    </div>
     <div id="dialog-for-id-in-sale-rate-succ" title="Sale Rate" style="display:none;">
       <span> Rate & Nett updated successfully. </span>
    </div>
     <div id="dialog-for-id-in-sale-rate-fail" title="Sale Rate" style="display:none;">
       <span> Rate & Nett can't be updated. Contact Vendor </span>
    </div>
     <table id="saleRate" class="display" cellspacing="0" width="100%">
         
     <thead bgcolor="#a6a6a6">
        <th>Sl.</th>
        <th>Product</th>
        <th>Rate</th>
       <th>Net</th>
        <th>Action</th>
        
    </thead>
    
    <tbody>
             
                                 <?php if($bodycontent){
                                     $sl=0;  
                                     $m=0;
                                     foreach ($bodycontent as $content){
                                           $sl=$sl+1;
                                           ?>
                                            <tr>
                                                <td>   
                                                    <input type="hidden" id="rateId_<?php echo($content['productPacketId']);?>" name="rateId" value="<?php echo($content['productPacketId']);?>"/>
                                                    
                                                      <?php echo($sl);?>
                                                </td>
                                                <td>
                                                    <span style="color:#360; font-size:12px ; font-weight:bold"><?php echo($content['finalproduct']);?></span>
                                                    
                                                </td>
                                                
                                                
                                                <td>
                                                    <input type="text" id="SalerateId_<?php echo($content['productPacketId']);?>" class="salerate"
                                                       style="background-color : #EEEEEE;border: 1px solid #008000;width: 100px;border-radius:5px; text-align: right;"    
                                                       value="<?php echo($content['rate']);?>"/>
                                                </td>
                                                
                                                <td>
                                                    <input type="text" id="SaleNetId_<?php echo($content['productPacketId']);?>" class="Nett"
                                                       style="background-color : #EEEEEE;border: 1px solid #008000;width: 100px;border-radius:5px; text-align: right;"    
                                                       value="<?php echo($content['net']);?>"/>
                                                </td>
                                                
                                                 <td>
                                                     
                                                     <input type="button" class="styled-button-10" value="update" onclick="saveSaleRate(<?php echo($content['productPacketId']);?>)" />
                                                 
                                                 </td>
                                                
                                            </tr>
                                 <?php 
                                       $m=$m+1;
                                       }
                                       
                                       }
                                 ?>
    </tbody>                                              
    </table>

 </div>