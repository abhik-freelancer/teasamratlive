<script src="<?php echo base_url(); ?>application/assets/js/rawmaterialProdWiseReg.js"></script>
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />

<style>
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
</style>


<h1><font color="#5cb85c" style="font-size:26px;">Raw Material Register - Product Wise</font></h1>

<div id="adddiv">
    <form id="frmRawMatReg" method="post" action="<?php echo base_url(); ?>rawmaterialproductwise/getProductWiseRawMaterialRegister"  target="_blank">
<section id="loginBox" style="width:600px;">
    <table cellspacing="10" cellpadding="0" class="tablespace" style="border-spacing: 12px;">
        <tr>
            <td scope="row" >Start Date </td>
            <td><input type="text" class="datepicker textStyle" id="startdate" name="startdate" /></td>
        </tr>
        <tr>
            <td scope="row" >End Date  </td>
            <td><input type="text" class="datepicker textStyle" id="enddate" name="enddate"/></td>
        </tr>
        <tr>
            <td>Raw Material Product</td>
            <td>
				<select name="rawmaterial" id="rawmaterial" class="selectedStyle custom-select">
                    <option value="0">select</option>
					<?php foreach ($header['rawmaterial'] as $content) : ?>
                 	<option  value="<?php echo $content['id']; ?>"><?php echo $content['product_description']; ?></option>
    				 <?php endforeach; ?>
                </select>
            </td>
        </tr>
		<tr>
			<td></td>
			<td><p id="selectRawmatProd" style="color:red;display:none;">Please select Raw Material Product</p></td>
		</tr>
    </table>
    <br/>
       
              <span class="buttondiv"><div class="save" id="print_rawmaterial_register" align="center"  style="cursor:pointer;"> Print </div></span>
    
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
