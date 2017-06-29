<script src="<?php echo base_url(); ?>application/assets/js/GSTtaxmaster.js"></script> 

 <h2><font color="#5cb85c">Add GST</font></h2>
 
 <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2">
       
    </div>
    <div class="col-md-2">
         <a href="<?php echo base_url(); ?>GSTmaster/addGST" class="btn btn-info" role="button">Add new</a>
        <a href="<?php echo base_url(); ?>GSTmaster" class="btn btn-info" role="button">List</a>
    </div>
    
 </div>
 <div class="row">
     <div class="col-lg-12">
         &nbsp;
     </div>
 </div>
 <div class="container-fluid">
     <div class="row">
       <div class="col-md-2"></div>
       <div class="col-md-6">
       <div class="panel panel-success">
       <div class="panel-heading">Goods & Services Tax (GST)</div>
       <div class="panel-body">
           <form>
               <div class="form-group">
                   <label for="GST">GST Description</label>
                   <input type="text" class="form-control" id="gstDesc" value="<?php echo($bodycontent['gstdata']['gstDescription']); ?>">
                   <input type="hidden" id="gstId" value="<?php echo($bodycontent['gstdata']['id']); ?>"/>
               </div>
               <div class="form-group">
                   <label for="gstType">Type</label>
                   <select id="gsttype" name="gsttype" class="form-control">
                       <option value="">--Select--</option>
                       <option value="CGST" <?php if($bodycontent['gstdata']['gstType']=="CGST"){echo("selected='selected'");} ?>>CGST</option>
                       <option value="SGST" <?php if($bodycontent['gstdata']['gstType']=="SGST"){echo("selected='selected'");} ?>>SGST</option>
                       <option value="IGST" <?php if($bodycontent['gstdata']['gstType']=="IGST"){echo("selected='selected'");} ?>>IGST</option>
                    </select>
               </div>
               <div class="form-group">
                   <label for="gstRate">Rate</label>
                   <input type="text" class="form-control" id="gstrate" 
                          <?php if($header['mode'] != "Add"){echo("readonly");} ?>
                          value="<?php echo($bodycontent['gstdata']['rate']); ?>">
               </div>
               
               <div class="form-group">
                   <label for="account">Account</label>
                   <select id="account" name="account" class="form-control">
                       <option value="">--Select--</option>
                       <?php  foreach($header['account'] as $rows ){ ?>
                       <option value="<?php echo($rows->amid); ?>"
                           <?php if($bodycontent['gstdata']['accountId']==$rows->amid){echo("selected='selected'");} ?>>
                           <?php echo($rows->account_name); ?>
                       </option>
                       <?php }?>
                   </select>
               </div>
                <div class="form-group">
                   <label for="gstFor">Input/Output</label>
                   <select id="gstFor" name="gstFor" class="form-control">
                       <option value="">--Select--</option>
                       <option value="O"  <?php if($bodycontent['gstdata']['usedfor']=="O"){echo("selected='selected'");} ?>>Output</option>
                       <option value="I"  <?php if($bodycontent['gstdata']['usedfor']=="I"){echo("selected='selected'");} ?>>Input</option>
                       
                    </select>
               </div>
               
               
               <button type="button" class="btn btn-default gstSave">Submit</button>
               <button type="reset" class="btn btn-default">Cancel</button>
           </form> 
           
           
           
       </div>
    </div>
       </div>
       <div class="col-md-4"></div>

     </div>
     
     
     
     
    
 </div>
