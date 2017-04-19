 <script src="<?php echo base_url(); ?>application/assets/js/rawmaterialstock.js"></script> 
<h1><font color="#5cb85c" style="font-size:22px;">Rawmaterial Stock as on</font></h1>
 
<div class="stats">
  <!--<p class="stat"><a href="<?php echo base_url(); ?>rawmaterial/addRawMaterial" class="showtooltip" title="add"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
  <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>-->
    
</div>


 <table id="example" class="display" cellspacing="0" width="100%">
     <thead>
     <th>Rawmaterial</th>
     <th>Uom</th>
     <th>Stock(In)</th>
     <th>Stock(Out)</th>
     <th>Stock</th>
     </thead>
     <tbody>
         <?php foreach ($bodycontent['rawmaterialStock'] as $row){?>
         <tr>
             <td width=""><?php echo $row['rawmaterial']; ?></td>
             <td width=""><?php echo $row['unit'];?></td>
             <td width=""><?php echo $row['StockIn'];?></td>
             <td width=""><?php echo $row['StockOut'];?></td>
             <td> <?php echo $row['CuurentStock'];?> </td>
         </tr>
         <?php } ?>
         
     </tbody>
         
 </table>
