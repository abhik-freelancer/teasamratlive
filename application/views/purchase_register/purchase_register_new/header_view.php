<script src="<?php echo base_url(); ?>application/assets/js/purchaseregister.js"></script>
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />

<style type="text/css">
    
   .custom-select {
    position: relative;
    width: 460px;
    height:25px;
    line-height:10px;
    font-size: 9px;
    
 
}
.custom-select a {
  display: block;
  width: 428px;
  height: 25px;
  padding: 8px 6px;
  color: #000;
  text-decoration: none;
  cursor: pointer;
  font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 14px;
	 outline: 0;
}
.custom-select div ul li.active {
    display: block;
    cursor: pointer;
    font-size: 13px;
   
}
.custom-select input {
    width: 428px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 9px;
}
    
</style>


<h1 style="font-size:26px;"><font color="#5cb85c">Purchase Register - All</font></h1>
<div id="adddiv">
   <form id="frmNewpurchaseReg" method="post" action="<?php echo base_url(); ?>purchaseregnew/getPurchaseRegister"  target="_blank">
<section id="loginBox" style="width:650px;">
    <table cellspacing="" cellpadding="0" class="tablespace" >
        <tr>
            <td scope="row" >Start Date <span style="color:red;">*</span></td>
            <td><input type="text" class="datepicker" id="startdate" name="startdate" value="<?php echo date('d-m-Y',strtotime($header['startDt']));?>" /></td>
            <td scope="row" >End Date <span style="color:red;">*</span> </td>
            <td><input type="text" class="datepicker" id="enddate" name="enddate" value="<?php echo date("d-m-Y");?>"/></td>
        </tr>
        <tr>
            <td scope="row">Vendor </td>
            <td colspan="3">
                <select name="vendor" id="vendor" class="custom-select">
					<option value="0">Select</option>
					<?php foreach ($header['vendor'] as $content) : ?>
					<option  value="<?php echo $content->vid; ?>"><?php echo $content->vendor_name; ?></option>
					<?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>
    <br/>
    <span class="buttondiv"><div class="save" id="purchasereg_new_print" align="center" style="cursor:pointer;">Print</div></span>
</section>
    </form>
</div>
  

