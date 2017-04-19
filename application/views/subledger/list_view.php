

 <h1><font color="#5cb85c" style="font-size:22px;">Subledger</font></h1>
 
<div class="stats">
  <p class="stat"><a href="<?php echo base_url(); ?>subledger/addSubledger" class="showtooltip" title="add"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
  <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
</div>

 
 <table id="example" class="display" cellspacing="0" width="100%">
     <thead>
     <th>Subledger</th>
     <th>Action</th>
     </thead>
     <tbody>
         <?php foreach ($bodycontent['subledgerlist'] as $row){?>
         <tr>
             <td width="95%"><?php echo $row['subledger']; ?></td>
             <td>
                  <a href="<?php echo base_url(); ?>subledger/addSubledger/id/<?php echo($row['subledgerid']); ?>" class="showtooltip" title="Edit">
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editunitmaster" title="" alt=""/>
                 </a>
             </td>
         </tr>
         <?php } ?>
         
     </tbody>
         
 </table>
 
 