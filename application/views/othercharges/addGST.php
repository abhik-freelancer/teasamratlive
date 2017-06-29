<script src="<?php echo base_url(); ?>application/assets/js/Othercharges.js"></script> 

 <h2><font color="#5cb85c">Add Othercharges</font></h2>
 
 <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2">
       
    </div>
    <div class="col-md-2">
         
        <a href="<?php echo base_url(); ?>Othercharges" class="btn btn-info" role="button">List</a>
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
       <div class="panel-heading">Othercharges account mapping</div>
       <div class="panel-body">
           <form>
               <div class="form-group">
                   <label for="othrgs">Description</label>
                   <input type="text" class="form-control" id="othrgs" value="<?php echo($bodycontent['gstdata']['description']); ?>"
                          <?php if ($header['mode'] != "Add") {echo("readonly"); }?>>
                   <input type="hidden" id="othrgsId" value="<?php echo($bodycontent['gstdata']['id']); ?>"/>
               </div>
                <div class="form-group">
                   <label for="GST">CODE</label>
                   <input type="text" class="form-control" id="othrgscode" value="<?php echo($bodycontent['gstdata']['code']); ?>"
                          <?php if ($header['mode'] != "Add") {echo("readonly"); }?>>
                   
               </div>
               
               <div class="form-group">
                   <label for="account">Account</label>
                   <select id="account" name="account" class="form-control">
                       <option value="">--Select--</option>
                       <?php  foreach($header['account'] as $rows ){ ?>
                       <option value="<?php echo($rows->amid); ?>"
                           <?php if($bodycontent['gstdata']['accountid']==$rows->amid){echo("selected='selected'");} ?>>
                           <?php echo($rows->account_name); ?>
                       </option>
                       <?php }?>
                   </select>
               </div>
               
               
               
               <button type="button" class="btn btn-default othrschrgsave">Submit</button>
               <button type="reset" class="btn btn-default">Cancel</button>
           </form> 
           
           
           
       </div>
    </div>
       </div>
       <div class="col-md-4"></div>

     </div>
     
     
     
     
    
 </div>
