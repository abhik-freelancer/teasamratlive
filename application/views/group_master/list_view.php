
<table id="example" class="display" cellspacing="0" width="100%">

	<thead>
  
    <th>Actions</th>
	<th>Group Name</th>
    <th>Category Name</th>
    <th>Sub Category Name</th>
   
    </thead>
    
     <tbody>
	<?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
            <tr id="row<?php echo $content->gmid; ?>">
            	<td><input type="radio" class="mini" name="action" id="chk<?php echo $content->gmid; ?>" value="<?php echo $content->gmid; ?>" <?php if($content->is_special == 'Y'): ?> disabled="disabled" <?php endif; ?>/>
              
                <input type="hidden" name="category<?php echo $content->gmid; ?>" id="category<?php echo $content->gmid; ?>" value="<?php echo $content->cid; ?>">
               </td>
                <td id="groupmastername<?php echo $content->gmid; ?>"><?php echo $content->gmname; ?> </td>
                <td id="categoryname<?php echo $content->gmid; ?>"><?php echo $content->gname; ?> </td>
                <td id="subcategoryname<?php echo $content->gmid; ?>"><?php echo $content->sgname; ?> </td>
                <input type="hidden" name="specialval" id="specialval<?php echo $content->gmid; ?>" value="<?php echo $content->is_special ?>"/>
               
               
            </tr>
    <?php endforeach; 
     else: ?>
 
    <?php
    endif; 
    ?>
	 </tbody>
</table>







    
    
