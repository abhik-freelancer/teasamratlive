<script src="<?php echo base_url(); ?>application/assets/js/purchaseregisterGroupwise.js"></script>
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />

<style type="text/css">
  .textStyle{
        width:310px;
        border:1px solid green;
        border-radius:5px;
       // margin-right:13%;
        
    }
    .selectedStyle{
          width:310px;
        border:1px solid green;
        border-radius:5px;
    }
    
   .custom-select {
    position: relative;
    width: 308px;
    height:25px;
    line-height:10px;
    font-size: 9px;
    border:1px solid green;
    border-radius:5px;
    
    
 
}
.custom-select a {
  display: block;
  width: 308px;
  height: 25px;
  padding: 8px 6px;
  color: #000;
  text-decoration: none;
  cursor: pointer;
  font-family: "Open Sans",helvetica,arial,sans-serif;
  font-size: 13px;
}
.custom-select div ul li.active {
    display: block;
    cursor: pointer;
    font-size: 12px;
    
}
.custom-select input {
    width: 280px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 9px;
}

#frmpurchaseRegister table tr td,#frmpurchaseRegister table tr th 
{

    padding: 3px;

}

</style>


<h1 style="font-size:26px;"><font color="#5cb85c">Purchase Register - Group Wise</font></h1>
<div id="adddiv">
    

<form id="frmpurchaseRegister" method="post" action="<?php echo base_url(); ?>purchaseregistergroupwise/getPurchaseRegisterPrintGroupWise"  target="_blank">
  <section id="loginBox" style="width:600px;">
    <table cellspacing="10" cellpadding="10" class="tablespace" >
      <tr>
        <td scope="row" >Start Date </td>
        <td>
          <input type="text" class="datepicker textStyle" id="startdate" name="startdate"/>
        </td>
        <td/>
      </tr>
      <tr>
        <td scope="row" >End Date </td>
        <td>
          <input type="text" class="datepicker textStyle" id="enddate" name="enddate"/>
        </td>
      </tr>
    <tr>
        <td scope="row">Group 
        </td>
        <td>
          <select name="group" id="group" class="textStyle custom-select">
            <option value="0">Select
            </option>
            <?php foreach ($header['teagroup'] as $content) : ?>
            <option  value="<?php echo $content->id; ?>">
              <?php echo $content->group_code; ?>
            </option>
            <?php endforeach; ?>
          </select>
        </td>
    </tr> 
	<tr >
		<td>&nbsp;</td>
		<td id="selectgrperr" style="display:none;"><p style="color:red;">Please select group</p></td>
	</tr>
     
    </table>
    <br/>
	<!--
   <span class="buttondiv">
      <div class="save" id="purchase_register" align="center" style="cursor:pointer;">Show 
      </div>
    </span> 
    <br> -->
    <span class="buttondiv">
      <div class="save" id="grpwise_purchase" align="center" style="cursor:pointer;">Print
      </div>
    </span>
  
  </section>
</form>
		
  
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
