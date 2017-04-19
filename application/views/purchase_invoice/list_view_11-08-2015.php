
<table id="example" class="display" cellspacing="0" width="auto" border="0">

<thead>
    <th> Action</th>
    <th>Invoice No</th>
    <th>Invoice Dt</th>
    <th>Vendor</th>
    <th>Sale No</th>
    <th>Sale Dt</th>
    <th>Tea Value</th>
    <th>Brokerage</th>
    <th>Service Tax</th>
    <th>TAX</th>
    <th>Stamp</th>
    <th>TOTAL</th>
</thead>
     <tbody>
    
         
         <?php 
		
            if(count($bodycontent) > 0)  : 
                    foreach ($bodycontent as $content) : ?>
        
                <tr id="row<?php echo $content->id; ?>">
                     <td>
                     <a href="<?php echo base_url(); ?>purchaseinvoice/edit/invoice/<?php echo $content->id; ?>" class="opendetail showtooltip" title="edit" id="<?php echo $content->id; ?>"><img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" height="18" width="18" /></a>
                     <a href="javascript:void(0)" class="opendetail showtooltip" id="<?php echo $content->id; ?>" title="click for details"><img src="<?php echo base_url(); ?>application/assets/images/up_arrow.jpg" height="18" width="18" /></a>
                     <a href="javascript:deleteSalertobuyer(<?php echo $content->id; ?>)" class="showtooltip" id="<?php echo $content->id; ?>" title="delete"><img src="<?php echo base_url(); ?>application/assets/images/delete.png" height="18" width="18" /></a>
                    </td>
                    <td><?php echo $content->purchase_invoice_number; ?> </td>
                    <td><?php echo $content->purchase_invoice_date; ?> </td>
                    <td><?php echo $content->vendor_name; ?> </td>
                    <td><?php echo $content->sale_number; ?> </td>
                    <td><?php echo $content->saledate; ?> </td>
                   
                    <td><?php echo $content->tea_value; ?> </td>
                    <td><?php echo $content->brokerage; ?> </td>
                    <td><?php echo $content->service_tax; ?> </td>
                    <td> 
                    	<?php echo $content->tax_type; ?>:<?php echo $content->tax;?> 
                    </td>
                   
                    <td><?php echo $content->stamp; ?></td>
                     <td><?php echo $content->total; ?></td>
                  </tr>
                
        <?php endforeach; 
		 
    else:
?>
  <tr>
    <td> &nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">No </td>
    <td align="right">records</td>
    <td>found..</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>

  <?php  endif; ?>       

     </tbody>
    
</table>
<div id="dialog-confirm_purchase_delete" title="Access denied" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete is not permissable now!!Please contact vendor.</p>
</div>










    
    
