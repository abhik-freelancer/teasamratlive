
<table id="example" class="display" cellspacing="0" width="100%">

	<thead>
  
    <th>Actions</th>
    <th>Tax Rate</th>
 <!--   <th>From Date</th>
    <th>To Date</th>-->
   
    </thead>
    
     <tbody>
    
	<?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
            <tr id="row<?php echo $content->id; ?>">
               	<td>
                <input type="radio" class="mini" name="action" id="chk<?php echo $content->id; ?>" value="<?php echo $content->id; ?>" 
                 <?php	if(($startyear != $content->yrfrm) && ($endyear != $content->yrto))  :  ?>
                		disabled="true"
                 <?php  endif;  ?>
                /></td>
                <td id="rate<?php echo $content->id; ?>"><?php echo $content->tax_rate; ?></td>
                <!--
                <td id="from<?php echo $content->id; ?>"><?php echo date("d-m-Y", strtotime($content->from_date)); ?></td>
                <td id="to<?php echo $content->id; ?>"><?php echo date("d-m-Y", strtotime($content->to_date)); ?></td>
               -->
            </tr>
    <?php endforeach; 
     else: ?>
   
    <?php
    endif; 
    ?>
	 </tbody>
</table>







    
    
