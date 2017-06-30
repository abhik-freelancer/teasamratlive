<script src="<?php echo base_url(); ?>application/assets/js/GSTtaxmaster.js"></script> 

 <h2><font color="#5cb85c">(GST) List</font></h2>
 
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
    <table class="table table-bordered table-condensed" id="example">
    <thead>
      <tr>
        <th>Description</th>
        <th>Type</th>
        <th>Rate</th>
        <th>Used</th>
        <th>Action</th>
        
      </tr>
    </thead>
    <tbody>
      <?php foreach ($bodycontent as $row) {?>
            <tr>
             <td><?php echo($row['gstDescription']);?></td>
             <td><?php echo($row['gstType']);?></td>
             <td><?php echo($row['rate']);?></td>
             <td><?php if($row['usedfor']=="O"){echo("OutPut");}else{echo("InPut");}?></td>
             <td>
                 <a href="<?php echo base_url(); ?>GSTmaster/addGST/id/<?php echo($row['id']); ?>" class="btn btn-info btn-xs" role="button">Edit</a>
                 <a href="#" class="btn btn-danger  btn-xs" role="button">Del</a>
                 
             </td>
            </tr>
        
        
       <?php } ?>
    </tbody>
  </table>
 </div>