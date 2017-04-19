
<table id="example" class="display" cellspacing="0" width="100%">

	<thead>
  
    <th>Actions</th>
    <th>Name</th>
    <th>Address</th>
    <th>Phone</th>
    <th>PIN</th>
   
    </thead>
    
     <tbody>
	<?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
            <tr id="row<?php echo $content->id; ?>">
            	<td><input type="radio" class="mini" name="action" id="chk<?php echo $content->id; ?>" value="<?php echo $content->id; ?>"/></td>
                <td id="name<?php echo $content->id; ?>"><?php echo $content->name; ?></td>
                <td id="area<?php echo $content->id; ?>"><?php echo $content->address; ?></td>
                <td id="phone<?php echo $content->id; ?>"><?php echo $content->Phone; ?></td>
                <td id="pin<?php echo $content->id; ?>"><?php echo $content->pin; ?></td>
               
            </tr>
    <?php endforeach; 
     else: ?>
    
    <?php
    endif; 
    ?>
	 </tbody>
</table>







    
    
