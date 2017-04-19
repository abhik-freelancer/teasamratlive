<script src="<?php echo base_url(); ?>application/assets/js/doreceived.js"></script> 

 <h1><font color="#5cb85c">Stock update</font></h1>

 <div id="adddiv">

  <section id="loginBox" style="width:600px;">
      <form id="frmgoodsRcv" name="frmgoodsRcv" method="post" action="<?php echo base_url(); ?>doproductrecv"  >
      <table>
          <tr>
              <td>Transporter :&nbsp;</td>
              <td>
                  <select id="drpTransporter" name="drpTransporter">
                      <option id="0">Select</option>
                      <?php if($bodycontent['transporterlist']){
                         
                          foreach($bodycontent['transporterlist'] as $rows){?>
                      <option value="<?php echo $rows->id; ?>" <?php if($rows->id==$bodycontent['selected_transporter']){echo("selected=selected");}?>><?php echo($rows->name);?></option>
                      
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
    
  <span class="buttondiv"><div class="save" id="trnsporterdo" align="center"> Show </div></span>
  </section>
  
 </div>
  
 <div id="popupdiv"  style="<?php if($bodycontent['doRcvTransList']){echo("display:block;");}else{echo("display:none;");}?>" title="Detail">
     <table id="doRcvTable" class="display" cellspacing="0" width="100%">
         
     <thead bgcolor="#a6a6a6">
        <th>Sl.</th>
        <th>Garden</th>
        <th>Do.Number</th>
        <th>Invoice</th>
        <th>Grade</th>
        <th>Net</th>
       
        <th>Challan</th>
        <th>Challan Dt.</th>
        <th>Location</th>
        <th>Stock</th>
        <th>Action</th>
        
    </thead>
    
    <tbody>
         
                                 <?php if($bodycontent['doRcvTransList']){
                                     $sl=0;  
                                     foreach ($bodycontent['doRcvTransList'] as $content){
                                           $sl=$sl+1;
                                           ?>
                                            <tr>
                                                <td>   
                                                    <input type="hidden" id="purDtlId<?php echo($sl);?>" name="purDtlId" value="<?php echo($content->purchaseDTLsId);?>"/>
                                                    <input type="hidden" id="dotransportaionid" name="dotransportaionid" value="<?php echo($content->doTransIds);?>"/>
                                                    <?php echo($sl);?>
                                                </td>

                                                <td>
                                                   <?php echo($content->garden_name); ?>
                                                </td>
                                                
                                                <td>
                                                    <span style="color:#360; font-size:12px ; font-weight:bold"><?php echo($content->do);?></span>
                                                </td>
                                                
                                                
                                                <td>
                                                   <?php echo($content->invoice_number); ?>
                                                </td>
                                                <td>
                                                    <?php echo($content->grade);?>
                                                </td>
                                                
                                                <td>
                                                    <?php echo($content->total_weight);?>
                                                </td>
                                                
                                                
                                                <td>
                                                    <input  size="8" type="text" id="txtChallan<?php echo($sl);?>" name="txtChallan" value="<?php echo($content->chalanNumber); ?>" />  
                                                    
                                                    </td>
                                                 <td>
                                                   <input type="text" class="datepicker" id="challan<?php echo($sl);?>" name="challan" value="<?php echo($content->chalanDate);?>" size="8"/> 
                                                 </td>
                                                 
                                                 <td>
                                                     <select id="loaction<?php echo($sl); ?>" name="loaction<?php echo($sl); ?>" >
                                                         <option value="0">Select</option>
                                                         <?php foreach ($bodycontent['location'] as $rowlocation){ ?>
                                                         <option value="<?php echo($rowlocation->lid); ?>"<?php if($rowlocation->lid==$content->locationId){?>selected="selected" <?php }?>>
                                                             <?php echo($rowlocation->location."-".$rowlocation->warehousename);?>
                                                         </option>
                                                         <?php } ?>
                                                     </select>
                                                 </td>
                                                 
                                                 <td>
                                                     <input type="checkbox" name="chkStock"  id="chkStock<?php echo($sl);?>" value="<?php echo($content->in_Stock); ?>" 
                                                         <?php if($content->in_Stock=='Y'){echo("checked=checked");}else{echo("");} ?>/>
                                                     <!--<img src="<?php echo base_url(); ?>application/assets/images/update_ajax.gif" id="loading<?php echo($sl);?>" 
                                                          style="display:none"/>-->
                                                 </td>
                                                 
                                                 
                                                 
                                                 <td>
                                                     
                                                     <input type="button" class="styled-button-10" value="update" 
                                                            onclick="updateRecvDo(<?php echo($content->doTransIds);?>,<?php echo($sl);?>);" />
                                                 </td>
                                                
                                            </tr>
                                 <?php 
                                       
                                       }
                                       
                                       }
                                 ?>
    </tbody>                                              
    </table>
     <div id="dialog-message" title="Update" style="display:none;">
                <p>
                <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
                Stock updated successfully...
                </p>
    </div>
	
	<div id="dialog-shortage-message" title="Stock" style="display:none;">
                <p>
                <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
                <p>Already stock physically updated</p>
				<p>You can't change</p>
                </p>
    </div>
	
	

 </div>