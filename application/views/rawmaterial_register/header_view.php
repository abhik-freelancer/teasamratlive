<script src="<?php echo base_url(); ?>application/assets/js/rawmaterialregister.js"></script>
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
    font-size: 9px;
    
}
.custom-select input {
    width: 280px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 9px;
}
</style>


<h1><font color="#5cb85c" style="font-size:26px;">Raw Material Register</font></h1>

<div id="adddiv">
     <form id="frmRawMatReg" method="post" action="<?php echo base_url(); ?>rawmaterialregister/getRawMaterialRegistPrint"  target="_blank">
 <section id="loginBox" style="width:850px;">
     <table cellspacing="4" cellpadding="0" class="tablespace" >
                   
                    <tr>
                        <td scope="row" >Start Date <span style="color:red;">*</span></td>
                        <td><input type="text" class="datepicker textStyle" id="startdate" name="startdate" /></td>
                    
                     <td scope="row" >End Date <span style="color:red;">*</span> </td>
                    <td><input type="text" class="datepicker textStyle" id="enddate" name="enddate"/></td>
                   </tr>
                   <tr>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                   </tr>
                   <tr>
                       <td>Vendor</td>
                       <td>
                           <select name="vendor" id="vendor" class="selectedStyle custom-select">
                             <option value="0">select</option>
                                 <?php foreach ($header['vendor'] as $content) : ?>
                 			<option  value="<?php echo $content->vid; ?>"><?php echo $content->vendor_name; ?></option>
    				 <?php endforeach; ?>
                          </select>
                       </td>
                   </tr>
                   </table>
                   <br/>
                   <span class="buttondiv"><div class="save" id="rawmatpurchase_register" align="center" style="cursor:pointer;">Show Raw Material Register</div></span><br>
                 <!-- <span class="buttondiv"><div class="save" id="print_rawmaterial_register" align="center"  style="cursor:pointer;"> Print </div></span>-->
                <p style="margin-top:15px;text-align:center; color:red;">* Fields are mandetory</p>
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
