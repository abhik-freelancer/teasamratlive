<script src="<?php echo base_url(); ?>application/assets/js/creditorsOutstandingJS.js"></script> 


<style>
    #frmsaletaxregister{
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




 <h1><font color="#5cb85c" style="font-size:28px;">Creditors Outstanding</font></h1>

 <div id="adddiv">

  <section id="loginBox" style="width:600px;border-radius:10px;">
      <form id="creditorsoutstanding" name="creditorsoutstanding" method="post" action="<?php echo base_url(); ?>creditorsoutstanding/pdfCreditorsOutstanding"  target="_blank">
      <table width="70%" align="center">
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
         
      </table>
         
      </form>
    
 <!-- <span class="buttondiv"><div class="save" id="showsaletaxregister" align="center" style="cursor:pointer;"> Show </div></span> -->
  
  <br>
  
   <span class="buttondiv"><div class="save" id="showcreditoroutstanding" align="center" style="cursor:pointer;"> Pdf </div></span> 
  </section>
  
 </div>
 

 
 