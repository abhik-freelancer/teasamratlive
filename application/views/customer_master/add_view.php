<script src="<?php echo base_url(); ?>application/assets/js/customermaster.js"></script>

 <h2><font color="#5cb85c">Add customer</font></h2>
 <form class="form-horizontal" method="post" name="addcustomer" id="addcustomer" action="<?php echo base_url(); ?>customermaster/add">
  <div class="form-group">
    <label class="control-label col-sm-2" for="name">Customer Name:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="name" placeholder="Enter customer name" name="name">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="tin">VAT:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="tin" name="tin" placeholder="Enter VAT">
    </div>
  </div>
	
  <div class="form-group">
    <label class="control-label col-sm-2" for="cst">CST:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="cst" name="cst" placeholder="Enter CST">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="pan">PAN:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="pan" name="pan" placeholder="Enter PAN">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="servicetax">Service Tax:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="servicetax" name="servicetax" placeholder="Enter Service Tax">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="gst">GST :</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="gst" name="gst" placeholder="Enter GST">
    </div>
  </div>
 
 <div class="form-group">
    <label class="control-label col-sm-2" for="obal">Opening :</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="obal" name="obal" placeholder="Enter Opening">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="address">Address :</label>
    <div class="col-sm-6">
		<textarea id="address" name="address" class="form-control" rows="3"> </textarea>
	</div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="state">Sate :</label>
    <div class="col-sm-6">
      <select class="form-control" name="state" id="state">
					<option value=0>--Select--</option>
					<?php foreach ($bodycontent as $content) : ?>
                 			<option value="<?php echo $content->id; ?>"><?php echo $content->state_name; ?></option>
    				 <?php endforeach; ?>
	  </select>
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="txtTelephone">Opening :</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="txtTelephone" name="txtTelephone" placeholder="Enter phone">
    </div>
  </div>
 
  
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Pin :</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="pin" name="pin" placeholder="Enter PIN">
    </div>
  </div>
 
 
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <button type="submit" class="btn btn-success" id="save">Submit</button>
    </div>
  </div>
</form>
 

                    


    
    
