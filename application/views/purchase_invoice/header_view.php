
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<script src="<?php echo base_url(); ?>application/assets/js/purchaseinvoice.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />


  <style>

.custom-select {
    position: relative;
    width: 250px;
    height:25px;
   // line-height:10px;
   
 
}
.custom-select a {
  display: block;
  width: 250px;
  height: 20px;
  padding: 2px 10px;
  color: #000;
  text-decoration: none;
  cursor: pointer;
  font-size:11px;
   font-family: "Open Sans",helvetica,arial,sans-serif;
    
}
.custom-select div ul li.active {
    display: block;
    cursor: pointer;
    font-size: 9px;
}


.custom-select input {
    width: 250px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 9px;
}
  </style>

 <h1><font color="#5cb85c">List of Purchase Invoice(s)</font></h1>
 <div class="stats">
 
    <p class="stat"><a href="<?php echo base_url(); ?>purchaseinvoice/addPurchaseInvoice" class="showtooltip" title="add"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
     <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" hieght="40" width="40" id="edit" style="visibility: hidden;"/></a></p>
      <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/delete.png" hieght="30" width="30" id="del" style="visibility: hidden;"/></a></p>
     <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
	</div>
 <div class="ui-widget">
 <div id="adddiv" >

  <section id="loginBox" style="width:640px;font-size:14px;">
     <table cellspacing="4" cellpadding="0" class="tablespace" >
                   
                    <tr>
                    <td scope="row" >Start Date</td>
                    <td><input type="text" class="datepicker" id="startdate" name="startdate"/></td>
                    <td/>
                     <td scope="row" >End Date</td>
                    <td><input type="text" class="datepicker" id="enddate" name="enddate"/></td>
                   </tr>
                   
                    <tr>
                    <td scope="row">Vendor</td>
                    <td>
                       
                    <select name="vendor" id="vendor" class='custom-select' >
                    <option value="0" >Select</option>
                    <?php foreach ($header['vendor'] as $content) : ?>
                 			<option  <?php if(($content->selected) == 'Y') :  ?> selected="selected" <?php endif; ?> value="<?php echo $content->id; ?>"><?php echo $content->vendor_name; ?></option>
    				 <?php endforeach; ?>
                    </select>
                      
                    </td>
                    <td/>
                     
                    </tr>
                   </table>
                   <br/>
                 <span class="buttondiv"><div class="save" id="showinvoice" align="center">Show Invoice</div></span>
           </section>
        
		
  
 </div>
 </div>
  
 <div id="popupdiv"  style="display:none; overflow:scroll; width:400px;height:400px;" title="Detail">

 </div>

