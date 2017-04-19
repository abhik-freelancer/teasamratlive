 <script src="<?php echo base_url(); ?>application/assets/js/groupcategorymaster.js"></script>
 <div style="display:none" id="adddiv">

     
      <section id="loginBox" style="width:500px;">
      <form role="form" method="post" name="addgarden" id="addgarden">
      			
				 <lable for="err" id="err" style="color:#F30;font-weight: bold"></lable>
                  <br/>
                  <label for="group">Group Name:
                  <br/>
                 <select name="group" id="group">
                 	 <option value="0">Select an option</option>
                 	 <?php foreach ($header['group'] as $content) : ?>
                 			<option value="<?php echo $content->id; ?>"><?php echo $content->name; ?></option>
    				 <?php endforeach; ?>
                 </select>
                 </label>
                 <br/>
                 
                   <label for="subgroup">Subgroup Name:
                    <br/>
                     <select name="subgroup" id="subgroup">
                     <option value="0">Select an option</option>
                         <?php foreach ($header['subgroup'] as $content) : ?>
                                <option value="<?php echo $content->id; ?>"><?php echo $content->name; ?></option>
                         <?php endforeach; ?>
                    </select>
                 </label>
                  <br/>
               
				 <span class="buttondiv"></span>
         </form>
         </section>
        

  
 </div>

 <div class="stats">
 
    <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="30" width="30" onclick="openADD()"/></a></p>
     <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" hieght="40" width="40" id="edit" style="visibility: hidden;"/></a></p>
      <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/delete.png" hieght="30" width="30" id="del" style="visibility: hidden;"/></a></p>
     <p class="stat"><a href="<?php echo base_url(); ?>home"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
	</div>
 <h1><font color="#5cb85c">List of Group Category</font></h1>

 


 

                    