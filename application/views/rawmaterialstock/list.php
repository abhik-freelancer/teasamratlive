 <script src="<?php echo base_url(); ?>application/assets/js/rawmaterialstock.js"></script> 
<h1><font color="#5cb85c" style="font-size:22px;">Rawmaterial Stock as on</font></h1>
 
<div class="stats">
  <!--<p class="stat"><a href="<?php echo base_url(); ?>rawmaterial/addRawMaterial" class="showtooltip" title="add"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
  <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>-->
    
</div>


 <table id="example" class="display" cellspacing="0" width="100%">
     <thead>
     <th align="left" style="text-align: left;">Rawmaterial</th>
     <th align="left" style="text-align: left;">Uom</th>
	 <th align="right" style="text-align: right;">Opening Stock</th>
	 <th align="right" style="text-align: right;">Purchase</th>
     <th align="right" style="text-align: right;">Stock(In)</th>
     <th align="right" style="text-align: right;">Stock(Out)</th>
     <th align="right" style="text-align: right;">Stock</th>
     </thead>
     <tbody>
         <?php foreach ($bodycontent['rawmaterialStock'] as $row){?>
         <tr>
             <td width=""><?php echo $row['rawmaterial']; ?></td>
             <td width=""><?php echo $row['unit'];?></td>
             <td width="" align="right"><?php echo $row['opStock'];?></td>
             <td width="" align="right"><?php echo $row['purchaseStock'];?></td>
             <td width="" align="right"><?php echo $row['StockIn'];?></td>
             <td width="" align="right"><?php echo $row['StockOut'];?></td>
             <td align="right"> <?php echo $row['CuurentStock'];?> </td>
         </tr>
         <?php } ?>
         
     </tbody>
         
 </table>
