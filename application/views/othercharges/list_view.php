<script src="<?php echo base_url(); ?>application/assets/js/Othercharges.js"></script> 

 <h2><font color="#5cb85c">(Othercharges) List</font></h2>
 
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
    <table class="table table-bordered table-condensed" id="example">
    <thead>
      <tr>
        <th>Description</th>
        <th>Code</th>
        <th>Account</th>
        <th>Action</th>
        
      </tr>
    </thead>
    <tbody>
      <?php foreach ($bodycontent as $row) {?>
            <tr>
             <td><?php echo($row['description']);?></td>
             <td><?php echo($row['code']);?></td>
              <td><?php echo($row['account_name']);?></td>
             <td>
                 <a href="<?php echo base_url(); ?>Othercharges/addGST/id/<?php echo($row['id']); ?>" class="btn btn-info btn-xs" role="button">Edit</a>
                 <a href="#" class="btn btn-danger  btn-xs" role="button">Del</a>
                 
             </td>
            </tr>
        
        
       <?php } ?>
    </tbody>
  </table>
 </div>