
<table id="example" class="display" cellspacing="0" width="100%">

	<thead>
	<th>First Name</th>
    <th>Last Name</th>
    <th>Address</th>
    <th>Email</th>
    <th>Contact Number</th>
    <th>Active Status</th>
    <th>Actions</th>
    </thead>
    
     <tbody>
	<?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
            <tr>
                <td><?php echo $content->First_Name; ?></td>
                <td><?php echo $content->Last_Name; ?></td>
                <td><?php echo $content->Address; ?></td>
                <td><?php echo $content->Email; ?></td>
                <td><?php echo $content->Contact_Number; ?></td>
                 <td><?php echo $content->IS_ACTIVE; ?></td>
                <td></td>
            </tr>
    <?php endforeach; 
     else: ?>
     <tr><td colspan="4">No records found</td></tr>
    <?php
    endif; 
    ?>
	 </tbody>
</table>



    
    
