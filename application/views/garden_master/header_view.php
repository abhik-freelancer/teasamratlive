 <script src="<?php echo base_url(); ?>application/assets/js/gardenmaster.js"></script>
 <div style="display:none" id="gardenadddiv">

     
      <section id="loginBox" style="width:500px;">
      <form role="form" method="post" name="addgarden" id="addgarden">
      			
				  <label for="name">Garden name :
                  <br/>
                 <input type="text" id="gardenname" name="gardenname" required="required" />
                 </label>
                
                   <label for="address">Address:
                    <br/>
                  <textarea cols="30" rows="3" id="gardenaddress" name="gardenaddress"></textarea>
                 </label>
				  <span class="buttondiv"></span>
         </form>
         </section>

  
 </div>

 <div class="stats">
 
    <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="30" width="30" onclick="openADD()"/></a></p>
     <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" hieght="40" width="40" id="gardenedit" style="visibility: hidden;"/></a></p>
      <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/delete.png" hieght="30" width="30" id="gardendel" style="visibility: hidden;"/></a></p>
     <p class="stat"><a href="<?php echo base_url(); ?>home"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
	</div>
 <h1><font color="#5cb85c">List of Gardens</font></h1>

 


 

                    