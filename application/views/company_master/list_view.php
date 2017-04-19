<script src="<?php echo base_url(); ?>application/assets/js/company.js"></script> 

 <h1><font color="#5cb85c">Company List</font></h1>
 <div class="stats">
 
    <p class="stat"><a href="<?php echo base_url(); ?>companymaster/addcompany" class="showtooltip" title="add">
            <img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
    <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
</div>

  
 <div id="popupdiv">
     
<table id="example" class="display" cellspacing="0" width="100%">

    <thead bgcolor="#CCCCCC">
            <th>Company Name</th>
            <th>Address</th>
            <th>Pin No.</th>
            <th>Bill Tag</th>
            <th>Action</th>
    </thead>
    
     <tbody>
	<?php 
       
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : 
            ?>
    
         <tr>
             <td><?php echo $content->company_name;?></td>
             <td><?php echo $content->location;?></td>
             <td><?php echo $content->pin_number;?></td>
             <td><?php echo $content->bill_tag;?></td>
             <td><a href="<?php echo base_url(); ?>companymaster/addcompany/id/<?php echo $content->id; ?>" class="showtooltip" title="Edit">
                  <img src="<?php echo base_url(); ?>application/assets/images/edit_ab.png" id="editTaxInvoice" title="" alt=""/>
                 </a>
                 <a href="<?php echo base_url(); ?>companymaster/delete/id/<?php echo $content->id; ?>" class="showtooltip" title="Delete">
                  <img src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" id="editTaxInvoice" title="" alt="" />
                 </a>
             </td>
         </tr>
    <?php endforeach; 
     else: ?>
         <tr> 
             <td>&nbsp;</td>
             <td> &nbsp;</td>
             <td> No</td>
             <td> Data Found..</td>
             <td> &nbsp;</td>
            
         
         </tr>
    <?php
    endif; 
    ?>
	 </tbody>
</table>

 </div>