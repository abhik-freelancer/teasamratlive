<script src="<?php echo base_url(); ?>application/assets/js/challanwiseReport.js"></script> 
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />

<style type="text/css">

 .custom-select {
    position: relative;
    width: 280px;
    height:25px;
    line-height:10px;
  font-size: 9px;
  border:1px solid green;
  border-radius:5px;
    
 
}
.custom-select a {
  display: block;
  width: 280px;
  height: 25px;
  padding: 8px 6px;
  color: #000;
  text-decoration: none;
  cursor: pointer;
  font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 12px;
}
.custom-select div ul li.active {
    display: block;
    cursor: pointer;
    font-size: 12px;
}


.custom-select input {
    width: 260px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 12px;
}
</style>

 <h1 style="font-size:26px;"><font color="#5cb85c">Challan Wise Incoming Report</font></h1>

 <div id="adddiv">
 <form id="frmChallanwisereport" method="post" action="<?php echo base_url(); ?>challanwisereport/getchallanwisereportPdf"  target="_blank">
  <section id="loginBox" style="width:600px;">
    <!--  <form id="frmgoodsRcv" name="frmgoodsRcv" method="post" action="<?php echo base_url(); ?>doproductrecv"  >-->
      <table width="90%" style="margin:0 auto;">
          <tr>
              <td>Transporter :&nbsp;</td>
              <td>
                  <select id="transporterid" name="transporterid" style="width:280px;border:1px solid green;border-radius:4px;">
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
          <tr>
              <td>Challan No. :</td>
              <td>
                  <div id="challan-drop">
                    <select id="challanno" name="challanno" class='custom-select'>
                        <option value="ALL">Select</option>
                    </select>
                  </div>
                  <div id="challanerror" style="margin-left:291px;margin-top:-25px;display:none;"><img src="<?php echo base_url(); ?>application/assets/images/vendor_validation.gif" /></div>
              </td>
               
          </tr>
          
          <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
          </tr>
      </table>
         
     <!-- </form>-->
    
  <span class="buttondiv"><div class="save" id="viewchallanReport" align="center"> Show </div></span>
  <br>
  <span class="buttondiv"><div class="save" id="pdfchallanReport" align="center"> Pdf </div></span> 
 
  </section>
  
 </div>
 </form>

     
  <div id="dialog-validation-save" title="Challan Wise Report" style="display:none;">
       <span> Validation Fail.</span>
   </div> 
 
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
