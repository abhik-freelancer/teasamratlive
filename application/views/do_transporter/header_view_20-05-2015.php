<script src="<?php echo base_url(); ?>application/assets/js/dototransporter.js"></script> 

 <h1><font color="#5cb85c">Do To Transporter</font></h1>
<!--
 <div class="stats">
 
    <p class="stat"><a href="<?php echo base_url(); ?>purchaseinvoice" class="showtooltip" title="add"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
     <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" hieght="40" width="40" id="edit" style="visibility: hidden;"/></a></p>
      <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/delete.png" hieght="30" width="30" id="del" style="visibility: hidden;"/></a></p>
     <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
	</div>
-->
 <div id="adddiv">

  <section id="loginBox" style="width:600px;">
      <form id="frmTransporter" name="frmTransporter" method="post" action="<?php echo base_url(); ?>deliveryordertotransp"  >
      <!--<table>
          <tr>
              <td>Purchase Invoice :&nbsp;</td>
              <td>
                  <select id="drppurchase" name="drppurchase">
                      <option id="0">Select</option>
                      <?php if($bodycontent['purchase']){
                         
                          foreach($bodycontent['purchase'] as $rows){?>
                      <option value="<?php echo $rows->id; ?>" <?php if($rows->id==$bodycontent['purchaseId']){echo("selected=selected");}?>><?php echo($rows->purchase_invoice_number);?></option>
                      
                         <?php
                             }
                          }
                          ?>
                  </select>
              </td>
          </tr>
          <tr>
              <td>Pending :&nbsp;</td>
              <td></td>
          </tr>
          <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
          </tr>
      </table>-->
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
     <table id="example" class="display" cellspacing="0" width="100%">
         
     <thead bgcolor="#a6a6a6">
        <th>Sl.</th>
        <th>Do.Number<br/>Do.Date</th>
        <th>Purchase/<br/>Date</th>
        <th>Sale / <br/>Invoice No. </th>
        <th>Grade</th>
        <th>Package</th>
        <th>Qty.</th>
        <th>Transporter</th>
        <th>Transportation Dt.</th>
        <th>Sent</th>
        
        <th>Action</th>
        
    </thead>
    
    <tbody>
         
                                 <?php if($bodycontent['doList']){
                                     $sl=0;  
                                     foreach ($bodycontent['doList'] as $content){
                                           $sl=$sl+1;
                                           ?>
                                            <tr>
                                                <td>   
                                                    <input type="hidden" id="purDtlId<?php echo($sl);?>" name="purDtlId" value="<?php echo($content->pDtlId);?>"/>
                                                    <input type="hidden" id="dotransportaionid" name="dotransportaionid" value="<?php echo($content->dotransportaionid);?>"/>
                                                    <input type="hidden" id="pMstId<?php echo($sl);?>" name="pMstId" value="<?php echo($content->pMstId); ?>"/>
                                                    <input type="hidden" id="pfromWhere<?php echo($sl);?>" name="pfromWhere" value="<?php echo($content->from_where);?>"/>
                                                    
                                                      <?php echo($sl);?>
                                                </td>
                                                <td>
                                                    <span style="color:#360; font-size:12px ; font-weight:bold"><?php echo($content->do);?></span>
                                                    <br/>
                                                    <br/>
                                                    <span style="color:#360; font-size:12px ; font-weight:bold"><?php echo($content->doRealisationDate);?></span>
                                                    
                                                    
                                                    <input type="hidden" id='txt_do<?php echo($sl);?>' name='txt_do' value="<?php echo($content->do);?>" size="8"/>
                                                    <input type="hidden"  size="8"  id='do_reli_date<?php echo($sl);?>' name="do_reli_date" value="<?php echo($content->doRealisationDate);?>"/>
                                                    
                                                </td>
                                                
                                                
                                                <td>
                                                   <?php echo($content->purchase_invoice_number); ?>
                                                    <br/>
                                                     <?php echo($content->PurchaseInvoiceDate);?>
                                                </td>
                                                
                                                <td>
                                                    <?php echo($content->sale_number);?>
                                                    <br/>
                                                    <?php echo($content->invoice_number);?>
                                                </td>
                                                
                                                <td>
                                                    <?php echo($content->grade);?>
                                                </td>
                                                <td>
                                                    <?php echo($content->package);?>
                                                </td>
                                                <td>
                                                    <?php echo($content->total_weight);?>
                                                </td>
                                                
                                                <td>
                                                    <?php if($content->in_Stock!='Y'){?>
                                                    <select style="width:100px;" id='drpTransporter<?php echo($sl);?>' name="drpTransporter">
                                                        <option value="0">Select</option>
                                                        <?php
                                                            foreach($bodycontent['transporter'] as $rows){
                                                        ?>
                                                            <option value="<?php echo($rows->id)?>"<?php if($rows->id==$content->transporterId){echo("selected=selected;");} ?>><?php echo($rows->name); ?></option>
                                                        
                                                            <?php } ?>
                                                    </select>
                                                    <?php }else{
                                                            echo($content->name);
                                                        
                                                        ?>
                                                       <?php 
                                                        } 
                                                        ?>
                                                </td>
                                                    <td>
                                                        <?php if($content->in_Stock!='Y'){?>
                                                        <input type="text" class="datepicker" id="transDt<?php echo($sl);?>" name="transDt" value="<?php echo($content->transportdate);?>" size="8"/>
                                                        <?php }else{ 
                                                                    echo($content->transportdate);
                                                            ?>
                                                        <?php }?>
                                                    </td>
                                                 <td>
                                                     
                                                     <input type="checkbox" name="chkSent" id="chkSent<?php echo($sl);?>" value="1" 
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

 </div>