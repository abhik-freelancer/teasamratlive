 <script src="<?php echo base_url(); ?>application/assets/js/grademaster.js"></script>
 <div style="display:none" id="gradediv">

    
      <section id="loginBox" style="width:500px;">
      <form role="form" method="post" name="addgrade" id="addgrade">
      			
				  <label for="name">Grade :
                  <br/>
                 <input type="text" id="grade" name="grade" required="required" />
                 </label>
                
				  <span class="buttondiv"></span>
         </form>
         </section>

  
 </div>

 <div class="stats">
 
    <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="30" width="30" onclick="openADD()"/></a></p>
     <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" hieght="40" width="40" id="gradeedit" style="visibility: hidden;"/></a></p>
      <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/delete.png" hieght="30" width="30" id="gradedel" style="visibility: hidden;"/></a></p>
     <p class="stat"><a href="<?php echo base_url(); ?>home"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
	</div>
 <h1><font color="#5cb85c">List of Grades</font></h1>

 


 

                    