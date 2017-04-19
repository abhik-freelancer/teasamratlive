<table id="example" class="display no-wrap" cellspacing="0" width="auto" border="0">
    
  <thead bgcolor="#a6a6a6">
        <th>Sl.</th>
        <th>Garden</th>
        <th>Invoice</th>
		<th>Date</th>
        <th>Invoice</th>
		<th>Do.Number</th>
		<th>Bags</th>
        <th>No.of Bags</th>
        <th>Net(Kgs.)</th>
       
       
     
    </thead>
    <tbody>
   
         
                                 <?php if($challanwisereport){
                                     $sl=0;  
                                     
                                      foreach ($challanwisereport as $content){
                                           $sl=$sl+1;
                                           ?>
       
                                            <tr>
                                                <td>   
                                                   
                                                    <?php echo($sl);?>
                                                </td>

                                                <td>
                                                   <?php echo($content->garden_name); ?>
                                                </td>
                                                <td>
                                                   <?php echo($content->purchase_invoice_number); ?>
                                                </td>
												<td>
                                                   <?php echo($content->purchase_invoice_date); ?>
                                                </td>
												<td>
                                                   <?php echo($content->invoice_number); ?>
                                                </td>
                                                
                                                <td>
                                                    <?php echo($content->do);?>
                                                </td>
                                                <td align="center">
                                                     <?php echo($content->bagtype);?>
                                                </td>
                                                <td align="center">
                                                    <?php echo($content->actual_bags);?>
                                                </td>
                                                
                                                <td align="center">
                                                    <?php echo($content->net);?>
                                                </td>
                                               
                                             
                                                
                                            </tr>
                                 <?php 
                                       
                                       }
                                       
                                       }
                                 ?>
    </tbody>
</table>

<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>application/assets/js/jquery.dataTables.min.js"></script>
<script>
$( document ).ready(function() {
    $("#example").DataTable();
});
</script>

