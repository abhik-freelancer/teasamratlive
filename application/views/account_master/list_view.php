
<table id="example" class="display" cellspacing="0" width="100%">

	<thead>
  
    <th>Actions</th>
    <th>Account Name</th>
	<th>Group Name</th>
    <th>Opening Balance</th>
    
   
    </thead>
    
     <tbody>
	<?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
            <tr id="row<?php echo $content->amid; ?>">
            	<td>
                <input type="radio" class="mini" name="action" id="chk<?php echo $content->amid; ?>" value="<?php echo $content->amid ?>" <?php if($content->is_special == 'Y'): ?> disabled="disabled" <?php endif; ?>/>
                <input type="hidden" name="groupid" id="groupid<?php echo $content->amid; ?>" value="<?php echo $content->group_master_id ?>"/>
                <input type="hidden" name="accblnceid" id="accblnceid<?php echo $content->amid; ?>" value="<?php echo $content->aomid ?>"/>
                
                </td>
                <td id="accname<?php echo $content->amid; ?>"><?php echo $content->account_name; ?> </td>
                <td id="groupname<?php echo $content->amid; ?>"><?php echo $content->group_name; ?> </td>
                <td id="openbal<?php echo $content->amid; ?>"><?php if($content->opening_balance==""){echo "0.00";}else{echo $content->opening_balance;} ?> </td>
                <input type="hidden" name="specialval" id="specialval<?php echo $content->amid; ?>" value="<?php echo $content->is_special ?>"/>
               
            </tr>
    <?php endforeach; 
     else: ?>
    
    <?php
    endif; 
    ?>
	 </tbody>
</table>







    
    
