 <script src="<?php echo base_url(); ?>application/assets/js/productmaster.js"></script>

 <script>
       
    </script>

 
 <div style="display:none" id="adddiv">

   
      <section id="loginBox" style="width:500px;">
      <form role="form" method="post" name="frmaddproduct" id="frmaddproduct">
      			
		<lable for="err" id="err" style="color:#F30;font-weight: bold"></lable>
                  <br/>
                  <label for="product">Product:
                  <br/>
                  <input type="text" id="product" name="product" />
                 </label>
                  
                   <br/>
                  <label for="prodDesc">Product Desc:
                  <br/>
                  <textarea id="productdesc" name="productdesc"></textarea>
                  
                 </label>
                  
                
                 <br/>
                    <label for="drp_packet">Packet:
                        <br/>
                        <select name="drp_packet" id="drp_packet" multiple="multiple" style="width:450px;">
                     
                         <?php foreach ($header['packet'] as $content) : ?>
                                <option value="<?php echo $content->packetid; ?>"><?php echo $content->packet; ?></option>
                         <?php endforeach; ?>
                    </select>
                        <input type="hidden" id="packets" name="packets" value=""/>
                    </label>
                    
                  <br/>
                  <br/>
				 <span class="buttondiv"></span>
         </form>
         </section>
        

  
 </div>

 <div class="stats">
 
    <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="30" width="30" id="addproduct"/></a></p>
     <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" hieght="40" width="40" id="edit" style="visibility: hidden;"/></a></p>
     <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/delete.png" hieght="30" width="30" id="del" style="visibility: hidden;"/></a></p>
     <p class="stat"><a href="<?php echo base_url(); ?>home"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
	</div>
 <h1><font color="#5cb85c">List of Product</font></h1>

 


 

                    