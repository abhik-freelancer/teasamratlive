
<table id="example" class="display" cellspacing="0" width="100%">

	<thead>
  
    <th>Actions</th>
	<th>Garde</th>
 
   
    </thead>
    
     <tbody>
	<?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
            <tr id="row<?php echo $content->id; ?>">
            	<td><input type="radio" class="mini" name="gradeid" id="chk<?php echo $content->id; ?>" value="<?php echo $content->id; ?>"/></td>
                <td id="name<?php echo $content->id; ?>"><?php echo $content->grade; ?></td>
               
               
            </tr>
    <?php endforeach; 
     else: ?>
    
    <?php
    endif; 
    ?>
	 </tbody>
</table>







    
    
