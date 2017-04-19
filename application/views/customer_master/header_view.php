 <script src="<?php echo base_url(); ?>application/assets/js/customermaster.js"></script>
 <div style="display:none" id="adddiv">

     
      <section id="loginBox" style="width:500px;">
      <form role="form" method="post" name="addgarden" id="addgarden">
      			
				 <lable for="err" id="err" style="color:#F30;font-weight: bold"></lable>
                  <br/>
                  <label for="name">Vendor Name:
                  <br/>
                  <input type="text" id="name" name="name" />
                 </label>
                 <br/>
                
                   <label for="address">Vendor Address:
                    <br/>
                    <textarea cols="30" rows="3" id="address" name="address"></textarea>
                 </label>
                  <br/>
                 
                 
                  <label for="balance">Opening Balance:
                  <br/>
                  <input type="text" id="balance" name="balance" />
                 </label>
                 <br/>
                   <span class="buttondiv"></span>
         </form>
         </section>
        

  
 </div>

 <div class="stats">
 
    <p class="stat"><a class="showtooltip" title="add" href="<?php echo base_url(); ?>customermaster/addpage"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="30" width="30"/></a></p>
    <p class="stat"><a  title="edit" href="#" class="editmaster"><img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" hieght="40" width="40" id="edit" style="visibility: hidden;"/></a></p>
    <p class="stat"><a  title="delete" href="#" class="delmaster"><img src="<?php echo base_url(); ?>application/assets/images/delete.png" hieght="30" width="30" id="del" style="visibility: hidden;"/></a></p>
    
    <p class="stat"><a  title="show details" href="#" class="detailopenmaster"><img src="<?php echo base_url(); ?>application/assets/images/up_arrow.jpg" hieght="30" width="30" id="opendiv" style="visibility: hidden;"/></a></p>
    <p class="stat"><a href="<?php echo base_url(); ?>home"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
	</div>
 <h1><font color="#5cb85c">List of Customer</font></h1>

 


 

                    