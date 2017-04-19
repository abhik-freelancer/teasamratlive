<script src="<?php echo base_url(); ?>application/assets/js/purchaseregister.js"></script>
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />

<style type="text/css">
    
   .custom-select {
    position: relative;
    width: 190px;
    height:25px;
    line-height:10px;
    font-size: 9px;
    
 
}
.custom-select a {
  display: block;
  width: 190px;
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
    font-size: 9px;
   
}
.custom-select input {
    width: 180px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 9px;
}
    
</style>


<h1 style="font-size:26px;"><font color="#5cb85c">Purchase Register</font></h1>
<div id="adddiv">
    
   <form id="frmpurchaseRegister" method="post" action="<?php echo base_url(); ?>purchaseregister/getPurchaseRegisterPrint"  target="_blank">
 <section id="loginBox" style="width:650px;">
     <table cellspacing="" cellpadding="0" class="tablespace" >
                   
                    <tr>
                        <td scope="row" >Start Date <span style="color:red;">*</span></td>
                        <td><input type="text" class="datepicker" id="startdate" name="startdate"/></td>
                    <td/>
                     <td scope="row" >End Date <span style="color:red;">*</span> </td>
                    <td><input type="text" class="datepicker" id="enddate" name="enddate"/></td>
                   </tr>
                    
                   <tr>
                    <td scope="row">Vendor </td>
                    <td>
                       
                    <select name="vendor" id="vendor" class="custom-select">
                    <option value="0">Select</option>
                    <?php foreach ($header['vendor'] as $content) : ?>
                 			<option  value="<?php echo $content->vid; ?>"><?php echo $content->vendor_name; ?></option>
    				 <?php endforeach; ?>
                    
                    </select>
                    </td>
                    </tr>
                    
                     <!--  11/01/2016-->
                    <tr>
                        <td scope="row">Sale No</td> 
                       <td>
                            <select name="saleno" id="saleno" class="custom-select">
                    <option value="0">Select</option>
                    <?php foreach ($header['salenumber'] as $content) : ?>
                    <option value="<?php echo $content->sale_number;?>"> <?php echo $content->sale_number; ?></option>
    				 <?php endforeach; ?>
                   
                    </select>
                       </td>  
                    </tr>
                    <tr>
                        <td scope="row">Purchase Type</td>
                       
                            <td>
                    <select id="purchasetype" name="purchasetype" style="width: 190px">
                        <option value="AS" <?php if($bodycontent['purchaseMaster']->from_where=='AS'){echo("selected");}else{echo("");}?>>Auction</option>
                        <option value="PS" <?php if($bodycontent['purchaseMaster']->from_where=='PS'){echo("selected");}else{echo("");}?>>Auction private</option>
                        <option value="SB" <?php if($bodycontent['purchaseMaster']->from_where=='SB'){echo("selected");}else{echo("");}?>>Private purchase</option>
                    </select>
    </td>
                      
                    </tr>
                    <tr>
                        <td scope="row">Purchase Area</td>
                       <td>
                           <select id="auctionArea" name="auctionArea" style="width: 190px">
                          <option value="0">Select Area</option>
                          <?php foreach($header['auctionarea'] as $content){?>
                          <option value="<?php echo($content->aucAreaid); ?>" <?php if($bodycontent['purchaseMaster']->auctionareaid==$content->aucAreaid){echo('selected');}?>> 
                              <?php echo($content->auctionarea); ?> </option>             
                          <?php }?>
                </select>
                        </td>
                    </tr>
                    
                   </table>
                   <br/>
                 <span class="buttondiv"><div class="save" id="purchase_register" align="center" style="cursor:pointer;">Show Purchase Register</div></span>
                 <br>
                 <span class="buttondiv"><div class="save" id="purchase_register_print" align="center" style="cursor:pointer;">Print</div></span>
                 <p style="margin-top:15px;text-align:center; color:red;">* Fields are mandetory.</p>
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
