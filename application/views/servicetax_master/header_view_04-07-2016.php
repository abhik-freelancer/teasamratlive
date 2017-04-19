 <script src="<?php echo base_url(); ?>application/assets/js/servicetaxmaster.js"></script>
 <div style="display:none" id="adddiv">

    
     
      <section id="loginBox" style="width:500px;">
      <form role="form" method="post" name="addform" id="service_addform">
      			
				  <label for="rate">Tax Rate 
                  <br/>
                  <input type="text" id="rate" name="rate" required="required" />
                  </label>
              		  <br/>
                   <label for="from">From Date
                    <br/>
                   <input type="text" id="from" name="from" class="datepicker" required="required" />
                   </label>
                    <br/>
                   <label for="to">To Date
                    <br/>
                    <input type="text" id="to" name="to" class="datepicker" required="required" />
                     </label>
                    <br/>
                 
				   <span class="buttondiv"></span>
         </form>
         </section>
        
<div id="dialog-save" title="Service Tax">
  <p>Data successfully save..</p>
</div>

  
 </div>

 <div class="stats">
 
    <p class="stat"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="30" width="30" onclick="" id="add_service"/></p>
     <p class="stat"><a href="#" ><img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" hieght="40" width="40" id="edit" style="visibility: hidden;"/></a></p>
      <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/delete.png" hieght="30" width="30" id="del" style="visibility: hidden;"/></a></p>
     <p class="stat"><a href="<?php echo base_url(); ?>home"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
	</div>
 <h1><font color="#5cb85c">List of Service Tax</font></h1>

 


 

                    