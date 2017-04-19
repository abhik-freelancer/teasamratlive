<script src="<?php echo base_url(); ?>application/assets/js/privatesell.js"></script> 

 <h1><font color="#5cb85c">List of Private Sell(s)</font></h1>
 <div class="stats">
 
    <p class="stat"><a href="<?php echo base_url(); ?>privatesell" class="showtooltip" title="add"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
     <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" hieght="40" width="40" id="edit" style="visibility: hidden;"/></a></p>
      <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/delete.png" hieght="30" width="30" id="del" style="visibility: hidden;"/></a></p>
     <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
	</div>
 <div id="adddiv">

  <section id="loginBox" style="width:600px;">
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
                    <select name="vendor" id="vendor" style="width: 190px">
                    <option value="0">select</option>
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
  
 <div id="popupdiv"  style="display:none;" title="Detail">

 </div>