 <script src="<?php echo base_url(); ?>application/assets/js/accountmaster.js"></script>
 <div style="display:none" id="adddiv">

    
      <section id="loginBox" style="width:500px;">
      <form role="form" method="post" name="addform" id="addform">
      			
				 <lable for="err" id="err" style="color:#F30;font-weight: bold"></lable>
                  <br/>
                  <label for="name">Account Name
                  <br/>
                  <input type="text" id="name" name="name" />
                 </label>
                 <br/>
                
                   <label for="groupname">Group Name
                    <br/>
                     <select name="groupname" id="groupname">
                     <option value="0">Select</option>
                         <?php foreach ($header['groupmastername'] as $content) : ?>
                                <option value="<?php echo $content->gmid; ?>"><?php echo $content->gmname; ?></option>
                         <?php endforeach; ?>
                    </select>
                 </label>
                  <br/>
                 
                 
                  <label for="balance">Opening Balance
                  <br/>
                  <input type="text" id="balance" name="balance" />
                 </label>
                 <br/>
                 <label for="special">Special
                
                  	<input type="checkbox" name="special" id="special" value="Y"> 
                 </label>
                 <br/>
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
 <h1><font color="#5cb85c">List of Accounts</font></h1>

 


 

                    