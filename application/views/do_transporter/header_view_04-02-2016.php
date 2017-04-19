<script src="<?php echo base_url(); ?>application/assets/js/dototransporter.js"></script> 

 <h1><font color="#5cb85c">Do To Transporter</font></h1>

 <div id="adddiv">

  <section id="loginBox" style="width:600px;">
      <form id="frmTransporter" name="frmTransporter" method="post" action="<?php echo base_url(); ?>deliveryordertotransp"  >
      
          <table>
              <tr>
                  <td>
                     Already sent:&nbsp;
                  </td>
                  <td>
                      <input type="checkbox" id="chksent" name="chksent" value="Y" <?php if($bodycontent['isSentToTrans']=='Y'){echo("checked='checked'");}?>/>
                  </td>
              </tr>
          </table>
      </form>
    
  <span class="buttondiv"><div class="save" id="showdo" align="center"> Show </div></span>
  </section>
  
 </div>
  
 <div id="popupdiv"  style="<?php if($bodycontent['doList']){echo("display:block;");}else{echo("display:none;");}?>" title="Detail">
    <div id="loaderDiv" name="loaderDiv" style="display:none;padding-left: 300px;">
        <img src="<?php echo base_url(); ?>application/assets/images/update_ajax.gif"/>
    </div>
     <table id="do_to_trans" class="display compact" cellspacing="0" width="100%">
         
     <thead bgcolor="#a6a6a6">
        <th style="font-size:12px">Sl.</th>
        <!--<th>Do.Number<br/>Do.Date</th>-->
        <th style="font-size:12px">DO</th>
        <th style="font-size:12px">Date</th>
       <!-- <th>Purchase/<br/>Date</th>-->
        <th style="font-size:12px">Sale</th>
        <th style="font-size:12px">Invoice No</th>
        <th style="font-size:12px">Garden</th>
        <th style="font-size:12px">Warehouse</th>
        <th style="font-size:12px">Area</th>
        <th style="font-size:12px">Grade</th>
        <th style="font-size:12px">Qty.</th>
        <th style="font-size:12px">Transporter</th>
        <th style="font-size:12px">Transportation Dt.</th>
        <th style="font-size:12px">Sent</th>
        
        <th>Action</th>
        
    </thead>
    
    <tbody>        
         
                                 <?php if($bodycontent['doList']){
                                     $sl=0;  
                                     foreach ($bodycontent['doList'] as $content){
                                           $sl=$sl+1;
                                           ?>
   
                                            <tr>
                                                <td style="font-size:12px">   
                                                    <input type="hidden" id="purDtlId<?php echo($sl);?>" name="purDtlId" value="<?php echo($content->pDtlId);?>"/>
                                                    <input type="hidden" id="dotransportaionid" name="dotransportaionid" value="<?php echo($content->dotransportaionid);?>"/>
                                                    <input type="hidden" id="pMstId<?php echo($sl);?>" name="pMstId" value="<?php echo($content->pMstId); ?>"/>
                                                    <input type="hidden" id="pfromWhere<?php echo($sl);?>" name="pfromWhere" value="<?php echo($content->from_where);?>"/>
                                                    
                                                      <?php echo($sl);?>
                                                </td>
                                                <td style="font-size:12px">
                                                    <span style="color:#360; font-size:12px ; font-weight:bold"><?php echo($content->do);?></span>
                                                    <input type="hidden" id='txt_do<?php echo($sl);?>' name='txt_do' value="<?php echo($content->do);?>" size="8"/>
                                                </td>
                                                <td style="font-size:12px">
                                                    <span style="color:#360; font-size:12px ; font-weight:bold"><?php echo($content->doRealisationDate);?></span>
                                                    <input type="hidden"  size="8"  id='do_reli_date<?php echo($sl);?>' name="do_reli_date" value="<?php echo($content->doRealisationDate);?>"/>
                                                </td>
                                              
                                                <td style="font-size:12px">
                                                    <?php echo($content->sale_number);?>
                                                </td>
                                                
                                                <td style="font-size:12px">
                                                    <?php echo($content->invoice_number);?>
                                                </td>
                                                
                                                <td style="font-size:12px">
                                                    <?php echo($content->garden_name);?>
                                                </td>
                                               
                                                 <td style="font-size:12px">
                                                    <?php echo($content->WarehouseName);?>
                                                </td>
                                                
                                                <td style="font-size:12px">
                                                    <?php echo($content->area);?>
                                                </td>
                                                
                                                <td style="font-size:12px">
                                                    <?php echo($content->grade);?>
                                                </td>
                                               
                                                <td style="font-size:12px">
                                                    <?php echo($content->total_weight);?>
                                                </td>
                                                
                                                <td style="font-size:12px">
                                                    <?php if($content->in_Stock!='Y'){?>
                                                    <select style="width:100px;" id='drpTransporter<?php echo($sl);?>' name="drpTransporter" class="drpTransporter">
                                                        <option value="0">Select</option>
                                                        <?php
                                                            foreach($bodycontent['transporter'] as $rows){
                                                        ?>
                                                            <option value="<?php echo($rows->id)?>"<?php if($rows->id==$content->transporterId){echo("selected=selected");} ?>><?php echo($rows->name); ?></option>
                                                        
                                                            <?php } ?>
                                                    </select>
                                                    <?php }else{
                                                            echo($content->name);
                                                        
                                                        ?>
                                                       <?php 
                                                        } 
                                                        ?>
                                                </td>
                                                    <td style="font-size:12px">
                                                        <?php if($content->in_Stock!='Y'){?>
                                                        <input type="text" class="datepicker" id="transDt<?php echo($sl);?>" name="transDt" value="<?php echo($content->transportdate);?>" size="8"/>
                                                        <?php }else{ 
                                                                    echo($content->transportdate);
                                                            ?>
                                                        <?php }?>
                                                    </td>
                                                 <td style="font-size:12px">
                                                     
                                                     <input type="checkbox" name="chkSent" class="chkSent" id="chkSent<?php echo($sl);?>" value="1" 
                                                         <?php if($content->sentStatus=='Y'){echo("checked=checked");}else{echo("");} ?>
                                                            <?php if($content->in_Stock=='Y'){echo("DISABLED");}?>
                                                            />
                                                 </td>
                                                 <td>
                                                     <?php 
                                                     $trns_doId= $content->dotransportaionid;
                                                     if($content->dotransportaionid==''){
                                                       $trns_doId=""  ;
                                                     }else{
                                                         $trns_doId= $content->dotransportaionid;
                                                     }
                                                     ?>
                                                     
                                                     <?php if($content->in_Stock!='Y'){?>
                                                     
                                                     <input type="button" class="styled-button-10" value="update" 
                                                            onclick="updateTransDo(<?php echo(($content->dotransportaionid==''?"''":$content->dotransportaionid));?>,<?php echo($sl);?>);" />
                                                     <?php }else{ ?>
                                                       
                                                     <img src="<?php echo base_url(); ?>application/assets/images/Warehouse-icon.png" title="Received"/>
                                                     <?php } ?>
                                                 
                                                 </td>
                                                
                                            </tr>
                                 <?php 
                                       
                                       }
                                       
                                       }
                                 ?>
    </tbody>                                              
    </table>

   <!-- modal dialog--div-->
<div id="dialog-check-fields" title="Purchase Detail" style="display:none;">
  <p>All Fields are mandetory</p>
</div>  
     
     
     
     
 </div>