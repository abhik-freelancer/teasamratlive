
<table id="example" class="display" cellspacing="0" width="100%">

	<thead>
  
    <th>Actions</th>
	<th>Group Name</th>
    <th>Sub Group Name</th>
   
    </thead>
    
     <tbody>
	<?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
            <tr id="row<?php echo $content->id; ?>">
            	<td><input type="radio" class="mini" name="action" id="chk<?php echo $content->id; ?>" value="<?php echo $content->id; ?>"/>
                <input type="hidden" name="groupid<?php echo $content->id; ?>" id="groupid<?php echo $content->id; ?>" value="<?php echo $content->gid; ?>">
                <input type="hidden" name="subgroupid<?php echo $content->id; ?>" id="subgroupid<?php echo $content->id; ?>" value="<?php echo $content->sgid; ?>">
                </td>
                <td id="group<?php echo $content->id; ?>"><?php echo $content->gname; ?> </td>
                <td id="subgroup<?php echo $content->id; ?>"><?php echo $content->sgname; ?> </td>
               
            </tr>
    <?php endforeach; 
     else: ?>
     
    <?php
    endif; 
    ?>
	 </tbody>
</table>







    
    
