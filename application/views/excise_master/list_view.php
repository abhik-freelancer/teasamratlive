

 <h1><font color="#5cb85c" style="font-size:22px;">Excise Master</font></h1>
 
<div class="stats">
  <p class="stat"><a href="<?php echo base_url(); ?>excisemaster/addExcisemaster" class="showtooltip" title="add"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
  <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
</div>

 
 <table id="example" class="display" cellspacing="0" width="100%">
     <thead>
     <th>Description</th>
     <th>Rate</th>
     <th >Action</th>
     </thead>
     <tbody>
         <?php foreach ($bodycontent['excisemasterlist'] as $row){?>
         <tr>
             <td width="40%"><?php echo $row['description']; ?></td>
             <td width="40%"><?php echo $row['rate'];?></td>
            
             <td width="10%">
                  <a href="<?php echo base_url(); ?>excisemaster/addExcisemaster/id/<?php echo($row['id']); ?>" class="showtooltip" title="Edit">
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editunitmaster" title="" alt=""/>
                 </a>
             </td>
         </tr>
         <?php } ?>
         
     </tbody>
         
 </table>
