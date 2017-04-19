<script src="<?php echo base_url(); ?>application/assets/js/voucherlisting.js"></script> 

<style>
    #frmvoucherlist{
       // color:green;
       font-size:14px;
    }
    .form_style{
        width:200px;
        border:1px solid green;
        border-radius:4px ;
    }
    .select_styl{
        width:200px;
        border:1px solid green;
         border-radius:4px ;
    }
   
</style>




 <h1><font color="#5cb85c" style="font-size:28px;">Voucher List</font></h1>

 <div id="adddiv">

  <section id="loginBox" style="width:600px;border-radius:10px;">
      <form id="frmvoucherlist" name="frmvoucherlist" method="post" action="<?php echo base_url(); ?>voucherlist"  >
      <table width="70%" align="center">
          <tr> 
              <td>From Date </td>
              <td>:&nbsp;</td>
              <td> <input type="text" name="fromdate" class="datepicker form_style" id="fromdate" /> </td>
           </tr>
           <tr><td>&nbsp;</td></tr>
           <tr>
              <td>To Date</td>
              <td>:&nbsp;</td>
              <td> <input type="text" name="todate" id="todate" class="datepicker form_style"/> </td>
           </tr>
           <tr><td>&nbsp;</td></tr>
            <tr>
                <td>Transaction Type </td>   <td>:&nbsp;</td>
              <td> 
                  <select id="purchasetype" name="purchasetype"  class="select_styl">
                      <option value="ALL">Select</option>
                      <option value="PR">Purchase</option>
                      <option value="GV">General</option>
                      <option value="JV">Journal</option>
                      <option value="CN">Contra</option>
                      <option value="SL">Sale</option>
                      <option value="RS">Tea Sale</option>
                  </select> 
              </td>
           </tr>
          
          <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
          </tr>
      </table>
         
      </form>
    
  <span class="buttondiv"><div class="save" id="showvoucherlist" align="center" style="cursor:pointer;"> Show </div></span>
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
 
 