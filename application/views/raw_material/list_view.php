

 <h1><font color="#5cb85c" style="font-size:22px;">Rawmaterial Master</font></h1>
 
<div class="stats">
  <p class="stat"><a href="<?php echo base_url(); ?>rawmaterial/addRawMaterial" class="showtooltip" title="add"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
  <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
</div>

 
 <table class="table table-bordered table-condensed" id="example">
     <thead>
     <th>Unit Name</th>
     <th>Product Description</th>
     <th>Purchase Rate</th>
      <th>Opening Stk.</th>
     <th>Action</th>
     </thead>
     <tbody>
         <?php foreach ($bodycontent['rawmateriallist'] as $row){?>
         <tr>
             <td width=""><?php echo $row['unitName']; ?></td>
             <td width=""><?php echo $row['product_description'];?></td>
             <td width=""><?php echo $row['purchase_rate'];?></td>
             <td width=""><?php echo $row['opening'];?></td>
             <td>
                  <a href="<?php echo base_url(); ?>rawmaterial/addRawMaterial/id/<?php echo($row['id']); ?>" class="showtooltip" title="Edit">
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editunitmaster" title="" alt=""/>
                 </a>
             </td>
         </tr>
         <?php } ?>
         
     </tbody>
         
 </table>
