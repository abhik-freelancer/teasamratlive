
<h1><font color="#5cb85c" style="font-size:22px;">Finished Product Opening Stock</font></h1>
 
<div class="stats">
  <p class="stat"><a href="<?php echo base_url(); ?>finishedproductopeningstock/addFinishedPrdctOPStock" class="showtooltip" title="add"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
  <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
</div>

 
 <table id="example" class="display" cellspacing="0" width="100%">
     <thead>
     <th>Product</th>
     <th>Opening Balance</th>
    
     <th>Action</th>
     </thead>
     <tbody>
         <?php foreach ($bodycontent['finishprdOPstock'] as $row){?>
         <tr>
             <td width=""><?php echo $row['finalProduct']; ?></td>
             <td width=""><?php echo $row['opening_balance'];?></td>
           
             <td>
                <a href="<?php echo base_url(); ?>finishedproductopeningstock/addFinishedPrdctOPStock/id/<?php echo($row['id']); ?>" class="showtooltip" title="Edit">
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editunitmaster" title="" alt=""/>
                 </a>
               
             </td>
         </tr>
         <?php } ?>
         
     </tbody>
         
 </table>
