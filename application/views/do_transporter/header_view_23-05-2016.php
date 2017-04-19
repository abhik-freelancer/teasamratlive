<script src="<?php echo base_url(); ?>application/assets/js/dototransporter.js"></script> 
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />
<style type="text/css">
    .textStyle{
    border:1px solid green;
    border-radius:5px;
    width:150px;
}
input[type=checkbox]
{

  -ms-transform: scale(1.2); /* IE */
  -moz-transform: scale(1.2); /* FF */
  -webkit-transform: scale(1.2); /* Safari and Chrome */
  -o-transform: scale(1.2); /* Opera */
  padding: 5px;

}
 .custom-select {
    position: relative;
    width: 180px;
    height:25px;
    line-height:10px;
  font-size: 9px;
  border:1px solid green;
  border-radius:5px;
    
 
}
.custom-select a {
  display: block;
  width: 180px;
  height: 25px;
  padding: 8px 6px;
  color: #000;
  text-decoration: none;
  cursor: pointer;
  font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 9px;
}
.custom-select div ul li.active {
    display: block;
    cursor: pointer;
    font-size: 9px;
}


.custom-select input {
    width: 165px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 9px;
}
</style>
 <h1><font color="#5cb85c">Do To Transporter</font></h1>
 <section id="loginBox" style="width:300px;">
      <form id="frmTransporter" name="frmTransporter" method="post" >
      
          <table>
              <!--
              <tr>
                  <td>
                      &nbsp;
                  </td>
                  <td>
                 <input type="checkbox" id="chksent" name="chksent" value="Y"  <?php if($bodycontent['isSentToTrans']=='Y'){echo('checked');}?>/>&nbsp; <label>Pending</label>
                 </td>
              </tr>-->
              
              
              <tr>
                  <td>Sale No</td>
                  <td>&nbsp;&nbsp;&nbsp;</td>
                  <td><input type="text" name="saleno" id="saleno" value="<?php echo $header['saleno']?>" class="textStyle"/>
                     <!-- <select name="saleno" id="saleno" class='custom-select' >
                          <option value="ALL">Select Sale No</option>
                          <?php foreach($header['sale_no'] as $row){?>
                          <option value="<?php echo $row->sale_number; ?>" <?php if($header['saleno']== $row->sale_number){echo("selected='selected'");}else{echo('');}?>><?php echo $row->sale_number; ?></option>
                          <?php }?>
                      </select>-->
                         
                  </td>
              </tr>
              <tr>
                   <td>&nbsp;&nbsp;&nbsp;</td>
                    <td>&nbsp;&nbsp;&nbsp;</td>
                     <td>&nbsp;&nbsp;&nbsp;</td>
              </tr>
              <tr>
                  <td>Pending</td>
                    <td>&nbsp;&nbsp;&nbsp;</td>
              <td>
                  <!-- <input type="checkbox" id="chksent" name="chksent" value="Y" style="border:1px solid green;" <?php if($bodycontent['isSentToTrans']=='Y'){echo('checked');}?>/>-->
                   <?php 
                        if($bodycontent['isSentToTrans']=='Y'){ ?>
                            
                       <input type="checkbox" id="chkpendingdo" name="chkpendingdo" <?php if ($bodycontent['isSentToTrans'] == 'Y') {echo("checked='checked'");} ?>/>
                       
                    <?php  } ?>  
                       
                     <?php 
                         if($bodycontent['isSentToTrans']==''){ ?>
                   
                       <input type="checkbox" id="chkpendingdo" name="chkpendingdo" <?php if ($bodycontent['isSentToTrans'] == '') {echo("");} ?> />
                         <?php } ?>
                 
              </td>
              </tr>
               <tr>
                   <td>&nbsp;&nbsp;&nbsp;</td>
                    <td>&nbsp;&nbsp;&nbsp;</td>
                     <td>&nbsp;&nbsp;&nbsp;</td>
              </tr>
          </table>
      </form>
    
  <span class="buttondiv"><div class="save" id="showdo" align="center"> Show </div></span>
  </section>
 
    
 <div id="popupdiv"  style="<?php if($bodycontent['doList']){echo("display:block;");}else{echo("display:none;");}?>" title="Detail">
     
    <div id="loaderDiv" name="loaderDiv" style="display:none;padding-left: 300px;">
        <img src="<?php echo base_url(); ?>application/assets/images/update_ajax.gif"/>
    </div>
     
    
     <table id="do_to_trans" class="display compact" cellspacing="0" width="100%">
         
     <thead bgcolor="#a6a6a6">
        <th style="font-size:12px">Sl.</th>
        <!--<th>Do.Number<br/>Do.Date</th>-->.
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
                                                        <input type="text" class="datepicker" id="transDt<?php echo($sl);?>" name="transDt" value="<?php //echo($content->transportdate);
                                                            if($content->transportdate){echo($content->transportdate);}else{echo date('d-m-Y');}
                                                        ?>" size="8"/>
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

<div id="dialog-check-saved" title="Purchase Detail" style="display:none;">
  <p>Saved Successfully</p>
</div>  
     
     
     
     
 </div>
 
