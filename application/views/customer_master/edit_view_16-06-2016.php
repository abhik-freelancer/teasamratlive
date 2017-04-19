<script src="<?php echo base_url(); ?>application/assets/js/customermaster.js"></script>

 <h2><font color="#5cb85c">Edit customer</font></h2>
 <form role="form" method="post" name="editcustomer" id="editcustomer" action="<?php echo base_url(); ?>customermaster/modify/customer/<?php echo $bodycontent['data'][0]->id ?>">

    
    
      <input type="hidden" id="accmasterid" name="accmasterid" value="<?php echo $bodycontent['data'][0]->amid ?>"/>
      <input type="hidden" id="accopenmaster" name="accopenmaster" value="<?php echo $bodycontent['data'][0]->accopenmaster ?>"/>
        <section id="loginBox" style="width:500px;">
      			
				 <lable for="err" id="err" style="color:#F30;font-weight: bold"></lable>
                  <br/>
                  <label for="name">Customer Name:
                  <br/>
                  <input type="text" id="name" name="name" value="<?php echo $bodycontent['data'][0]->customer_name ?>" style="width:380px;"/>
                 </label>
                 <br/>
                <label for="tin">TIN no:
                    <br/>
                     <input type="text" id="tin" name="tin" value="<?php echo $bodycontent['data'][0]->tin_number ?>"/>
                 </label>
                 
                  <label for="cst">CST no:
                    <br/>
                    <input type="text" id="cst" name="cst" value="<?php echo $bodycontent['data'][0]->cst_number ?>"/>
                 </label>
                  <br/>
                  <label for="pan">PAN Number:
                    <br/>
                     <input type="text" id="pan" name="pan" value="<?php echo $bodycontent['data'][0]->pan_number ?>"/>
                 </label>
                  
                   <label for="servicetax">Service Tax Number:
                    <br/>
                     <input type="text" id="servicetax" name="servicetax" value="<?php echo $bodycontent['data'][0]->service_tax_number ?>"/>
                 </label>
                 
                   <label for="gst">GST Number:
                    <br/>
                     <input type="text" id="gst" name="gst" value="<?php echo $bodycontent['data'][0]->GST_Number ?>"/>
                 </label>
                
                 <label for="obal">Opening Balance:
                  <br/>
                  <input type="text" id="obal" name="obal" value="<?php echo $bodycontent['data'][0]->openblnce ?>"/>
                 </label>
                 <br/>
                   <label for="address">Vendor Address:
                    <br/>
                    <textarea cols="42" rows="3" id="address" name="address"><?php echo trim($bodycontent['data'][0]->address) ?></textarea>
                 </label>
                  <br/>
                  <label for="pin">Pin Number:
                    <br/>
                     <input type="text" id="pin" name="pin" value="<?php echo $bodycontent['data'][0]->pin_number ?>"/>
                 </label>
               
                 
                 <label for="state">State:
                    <br/>
                     <div id="stateerr">
                     <select name="state" id="state" style="width: 190px">
                   
                    <?php foreach ($bodycontent['states'] as $content) : ?>
                 			<option value="<?php echo $content->id; ?>" <?php if($content->id == $bodycontent['data'][0]->state_id): ?> selected="selected"  <?php endif; ?>><?php echo $content->state_name; ?></option>
    				 <?php endforeach; ?>
                    
                    </select>
                    </div>
                 </label>
               
                 
                 <label for="Telephone">
                  <br/>
                  <input type="text" id="txtTelephone" name="txtTelephone" value="<?php echo trim($bodycontent['data'][0]->telephone); ?>" />
                 </label>
                   <br/> <br/>
          <span class="buttondiv"><div class="save" id="editdetail" align="center">Save</div></span>
        
         </section>
 </form>
    

 

                    


    
    
