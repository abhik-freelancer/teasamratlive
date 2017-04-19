
<table id="example" class="display" cellspacing="0" width="100%">

    <thead bgcolor="#CCCCCC">
  
            <th>Actions</th>
            <th>Location</th>
            <th>Warehouse</th>
    </thead>
    
     <tbody>
	<?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
            <tr id="row<?php echo $content->lid; ?>">
            	<td>
                <input type="radio" class="mini" name="action" id="chk<?php echo $content->lid; ?>" value="<?php echo $content->lid; ?>"/>
                <input type="hidden" name="id_location<?php echo $content->lid; ?>" id="id_location<?php echo $content->lid; ?>" value="<?php echo $content->lid; ?>">
                <input type="hidden" name="id_warehouse<?php echo $content->lid; ?>" id="id_warehouse<?php echo $content->lid; ?>" value="<?php echo $content->whid; ?>">
               </td>
                <td id="location<?php echo $content->lid; ?>"><?php echo $content->location; ?> </td>
                <td id="warehouse<?php echo $content->lid; ?>"><?php echo $content->warehousename; ?> </td>
            </tr>
    <?php endforeach; 
     else: ?>
 
    <?php
    endif; 
    ?>
	 </tbody>
</table>







    
    
