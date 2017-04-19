<script src="<?php echo base_url(); ?>application/assets/js/general_ledgerReport.js"></script> 
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />

<style>
    #frmsaletaxregister{
       // color:green;
       font-size:14px;
    }
    .form_style{
        width:358px;
        border:1px solid green;
        border-radius:4px ;
    }
    .select_styl{
        width:200px;
        border:1px solid green;
         border-radius:4px ;
    }
    .custom-select {
    position: relative;
   width: 363px;
    height:25px;
    line-height:10px;
  font-size: 9px;
  border:1px solid green;
  border-radius:5px;
    
 
}
.custom-select a {
  display: block;
  width: 363px;
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
    font-size: 11px;
}


.custom-select input {
    width: 330px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 11px;
    height: 34px;
}
   
</style>




 <h1><font color="#5cb85c" style="font-size:28px;">General Ledger Report</font></h1>

 <div id="adddiv">

  <section id="loginBox" style="width:600px;border-radius:10px;">
      <form id="generalledgerreport" name="generalledgerreport" method="post" action="<?php echo base_url(); ?>generalledgerreport/pdfGeneralLedger"  target="_blank">
      <table width="90%" align="center">
          <tr> 
              <td>From Date </td>
              <td>:&nbsp;</td>
              <td> <input type="text" name="fromdate" class="datepicker form_style" id="fromdate" autocomplete="off"/> </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
              <td>To Date</td>
              <td>:&nbsp;</td>
              <td> <input type="text" name="todate" id="todate" class="datepicker form_style" autocomplete="off"/> </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
               <td>Account</td>
               <td>:&nbsp;</td>
               <td>
                    <select id="account" name="account" class='custom-select'>
                        <option value="0">Select</option>
                        <?php if($bodycontent["accountList"]){
                              foreach ($bodycontent["accountList"] as $row){
                        ?>
                         <option value="<?php echo($row['accId']);?>" > <?php echo($row['accname']); ?> </option>
                        <?php 
                            }
                          }
                         ?>
                   </select>
                   <div id="account_err" style="margin-left: 374px;margin-top: -25px;display:none;"><img src="<?php echo base_url(); ?>application/assets/images/vendor_validation.gif" /></div>
               </td>
           </tr>
           
          <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
          </tr>
      </table>
         
      </form>
    
 <!-- <span class="buttondiv"><div class="save" id="showsaletaxregister" align="center" style="cursor:pointer;"> Show </div></span> -->
  
  <br>
  
   <span class="buttondiv"><div class="save" id="showtrialbalancepdf" align="center" style="cursor:pointer;"> Pdf </div></span> 
  </section>
  
 </div>
 
 
 <!---------------------Voucher Listing Area-------------------------->
 
 
 
 <div class="vouchrlistTabl" id="vouchrlistTabl">
    
    
     <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" id='loader' style=" position: absolute;
    margin: auto;
    top: 50%;
    left: 0;
    right: 0;
    bottom: 0;display:none;"/>
    
     <div id="details"  style="display:none; width:100%;height:100%;" title="Detail">

 </div>

</div>
 
 