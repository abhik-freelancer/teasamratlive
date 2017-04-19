<script src="<?php echo base_url(); ?>application/assets/js/stockwithtransporter.js"></script> 

<h1 style="font-size:26px;"><font color="#5cb85c">Stock with Transporter</font></h1>

 <div id="adddiv">
 <form id="frmStockWithTrns" method="post" action="<?php echo base_url(); ?>stockwithtransporter/getStockWithTransPrint"  target="_blank">
  <section id="loginBox" style="width:600px;">
    <!--  <form id="frmgoodsRcv" name="frmgoodsRcv" method="post" action="<?php echo base_url(); ?>doproductrecv"  >-->
      <table>
          <tr>
              <td>Transporter :&nbsp;</td>
              <td>
                  <select id="transporterid" name="transporterid">
                      <option value="0" >Select</option>
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
         
     <!-- </form>-->
    
  <span class="buttondiv"><div class="save" id="trnsporter" align="center"> Show </div></span>
  <br>
  <span class="buttondiv"><div class="save" id="stkwithtransporter" align="center"> Print </div></span>
  <br>
  <span class="buttondiv"><div class="save" id="stckwithtransporterPdf" align="center">Pdf</div></span>
  </section>
  
 </div>
 </form>

 
 <div class="">
    
    
     <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" id='loader' style=" position: absolute;
    margin: auto;
    top: 50%;
    left: 0;
    right: 0;
    bottom: 0;display:none;"/>
    
     <div id="details"  style="display:none; width:100%;height:100%;" title="Detail">

 </div>

</div>
