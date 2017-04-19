<script src="<?php echo base_url(); ?>application/assets/js/vendormaster.js"></script>

 <h2><font color="#5cb85c">Edit vendor</font></h2>
 <form role="form" method="post" name="editvendormaster" id="editvendormaster" action="<?php echo base_url(); ?>vendormaster/modify/vendor/<?php echo $bodycontent['data'][0]->id ?>">

    
      <form role="form" method="post" name="addgarden" id="addgarden">
      <input type="hidden" id="accmasterid" name="accmasterid" value="<?php echo $bodycontent['data'][0]->amid ?>"/>
      <input type="hidden" id="accopenmaster" name="accopenmaster" value="<?php echo $bodycontent['data'][0]->accopenmaster ?>"/>
        <section id="loginBox" style="width:500px;">
      			
				 <lable for="err" id="err" style="color:#F30;font-weight: bold"></lable>
                  <br/>
                  <label for="name">Vendor Name:
                  <br/>
                  <input type="text" id="name" name="name" value="<?php echo $bodycontent['data'][0]->vendor_name ?>" style="width:380px;"/>
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
                    <option value="0">select</option>
                    <?php foreach ($bodycontent['states'] as $content) : ?>
                 			<option value="<?php echo $content->id; ?>" <?php if($content->id == $bodycontent['data'][0]->state_id): ?> selected="selected"  <?php endif; ?>><?php echo $content->state_name; ?></option>
    				 <?php endforeach; ?>
                    
                    </select>
                    </div>
                 </label>
               
                 
                 <label for="txtTelephone">Telephone:
                  <br/>
                  <input type="text" id="txtTelephone" name="txtTelephone" value="<?php echo $bodycontent['data'][0]->telephone ?>"/>
                 </label>
                   <br/> <br/>
          <span class="buttondiv"><div class="save" id="editdetail" align="center">Save</div></span>
        
         </section>
        
       <!-- <table  width="100%" cellspacing="2" >
        <thead bgcolor="#a6a6a6">
        <tr>
        <th width="2%">&nbsp;</th>
        <th>Bill Number</th>
        <th>Bill Date</th>
        <th>Due Date</th>
        <th>Bill Amount</th>
        <th>Due Amount</th>
        <th>Action</th>
       
        </tr>
        </thead>
        <tr bgcolor="#a6a6a6" id="addsection">
        <td  width="2%">&nbsp;</td>
        <td> <input type="text" id="bnumber" name="bnumber"/></td>
        <td> <input type="text" id="bdate" name="bdate" class="datepicker"/></td>
        <td> <input type="text" id="ddate" name="ddate" class="datepicker"/></td>
        <td> <input type="text" id="bamount" name="bamount"/></td>
        <td> <input type="text" id="damount" name="damount"/></td>
        <td>  <a href="javascript:void(0)" class="opendetail showtooltip" title="click for add details" id="adddetail"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" height="18" width="18" /></a> </th>
         </tr>
        </table> 
         <br/>
        <table id="example2" class="display" width="100%" cellspacing="0" frame="box">
        <thead bgcolor="#a6a6a6">
        <tr>
        <th>Bill Number</th>
        <th>Bill Date</th>
        <th>Due Date</th>
        <th>Bill Amount</th>
        <th>Due Amount</th>
        <th>Action</th>
       
        </tr>
        </thead>
        <tbody id="mybody" >
       			
                <?php 
        		if($bodycontent['data'])  : 
                foreach ($bodycontent['data'] as $content) : ?>
    
            <tr id="row<?php echo $content->did; ?>">
            	 	<td> <input type="text" id="bnumber" name="listbnumber[]" style="border: none;" value="<?php echo $content->dbn ?>"/></td>
                    <td> <input type="text" id="bdate" name="listbdate[]" style="border: none;" class="datepicker" value="<?php echo date("d-m-Y", strtotime($content->dbd)) ?>"/></td>
                    <td> <input type="text" id="ddate" name="listddate[]" style="border: none;" class="datepicker" value="<?php echo date("d-m-Y", strtotime($content->ddd)) ?>"/></td>
                    <td> <input type="text" id="bamount" name="listbamount[]" style="border: none;" value="<?php echo number_format($content->dba, 2, '.', '') ?>"/></td>
                    <td> <input type="text" id="damount" name="listdamount[]" style="border: none;" value="<?php echo number_format($content->dda, 2, '.', '') ?>"/></td>
                    <td><a href="javascript:deletedetail(<?php echo $content->did; ?>)" class="opendetail showtooltip" title="delete" id="deletedetail"><img src="<?php echo base_url(); ?>application/assets/images/delete.png" height="18" width="18" /></a></td>
               
            </tr>
				<?php endforeach; 
                 else: ?>
                
                <?php
                endif; 
                ?>
        </tbody>
        </table>-->
      
</form>

 

                    


    
    
