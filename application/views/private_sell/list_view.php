
<table id="example" class="display" cellspacing="0" width="80%" border="0">

	<thead>
  
   <th></th>
    <th>Invoice Number</th>
	<th>Invoice Date</th>
    <th>Vendor</th>
    <th>Sale Number</th>
    <th>Sale Date</th>
    <th>Tea Value</th>
    <th>Brokerage</th>
    <th>Service Tax</th>
    <th>Chest Allowance</th>
    <th>Value</th>
    <th>Stamp change</th>
    <th>TOTAL</th>
    
    </thead>
     <tbody>
    
         
         <?php 
		
            if(count($bodycontent) > 0)  : 
                    foreach ($bodycontent as $content) : ?>
        
                <tr id="row<?php echo $content->id; ?>">
                     <td>
                     <a href="<?php echo base_url(); ?>privatesell/edit/invoice/<?php echo $content->id; ?>" class="opendetail showtooltip" title="edit" id="<?php echo $content->id; ?>"><img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" height="18" width="18" /></a>
                     <a href="javascript:void(0)" class="opendetail showtooltip" id="<?php echo $content->id; ?>" title="click for details"><img src="<?php echo base_url(); ?>application/assets/images/up_arrow.jpg" height="18" width="18" /></a>
                     <a href="javascript:deleteSalertobuyer(<?php echo $content->id; ?>)" class="showtooltip" id="<?php echo $content->id; ?>" title="delete"><img src="<?php echo base_url(); ?>application/assets/images/delete.png" height="18" width="18" /></a>
                    </td>
                    <td><?php echo $content->purchase_invoice_number; ?> </td>
                    <td><?php echo $content->purchase_invoice_date; ?> </td>
                    <td><?php echo $content->vendor_name; ?> </td>
                    <td><?php echo $content->sale_number; ?> </td>
                    <td><?php echo $content->sale_date; ?> </td>
                   
                    <td><?php echo $content->tea_value; ?> </td>
                    <td><?php echo $content->brokerage; ?> </td>
                    <td><?php echo $content->service_tax; ?> </td>
                    <td><?php echo $content->chestage_allowance; ?> </td>
                    <td><?php /*if($content->rate_type == 'V'): echo 'VAT';  elseif($content->rate_type == 'C'): echo 'CST';  else: echo ''; endif; */?> 
                    	
						VAT : <?php echo $content->total_vat; ?> <br/>
                        CST : <?php echo $content->total_cst;?> </td>
                   
                    <td><?php echo $content->stamp; ?></td>
                     <td><?php echo $content->total; ?></td>
                  </tr>
                
        <?php endforeach; 
		  endif; 
//     else:
?>
         <!--<tr><td colspan="13" style="text-align:center">No records found</td></tr>-->

     </tbody>
    
</table>










    
    
