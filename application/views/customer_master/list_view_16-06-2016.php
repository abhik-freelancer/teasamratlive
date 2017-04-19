<input type="hidden" name="selid" id="selid" value=""/>
<table id="example" class="display" cellspacing="0" width="100%">

	<thead>
    <th>Actions</th>
    <th>Customer Name</th>
    <th>Telephone</th>
    <th>Address</th>
    <th>Opening Balance</th>
   
    </thead>
    
     <tbody>
	<?php 
        if($bodycontent['master'])  : 
                foreach ($bodycontent['master'] as $content) : ?>
    
            <tr id="row<?php echo $content->vid; ?>">
            	<td><input type="radio" class="mini" name="action" id="<?php echo $content->vid; ?>" value="<?php echo $content->vid ?>"/>
                <input type="hidden" name="aom<?php echo $content->vid; ?>" id="aom<?php echo $content->vid; ?>" value="<?php echo $content->aomid ?>"/>
                 <input type="hidden" name="am<?php echo $content->vid; ?>" id="am<?php echo $content->vid; ?>" value="<?php echo $content->amid ?>"/>
  				</td>
                <td id="accname<?php echo $content->vid; ?>"><?php echo $content->customer_name; ?> </td>
                <td id="accname<?php echo $content->vid; ?>"><?php echo $content->telephone; ?> </td>
               
                 <td id="address<?php echo $content->vid; ?>"><?php echo $content->address; ?> <br/><?php if($content->pin_number > 0): echo $content->pin_number; endif;?>&nbsp;<?php echo $content->state_name; ?></td>
                <td id="openbal<?php echo $content->vid; ?>"><?php echo $content->opening_balance; ?> </td>
               
            </tr>
    <?php endforeach; 
     else: ?>
     
    <?php
    endif; 
    ?>
	 </tbody>
     
     

   	   <table id="example2" class="display"  style="display:none;" width="100%" cellspacing="0" frame="box" >
        <thead bgcolor="#a6a6a6">
            <tr>
            <th>Bill Number</th>
            <th>Bill Date</th>
            <th>Bill Amount</th>
            <th>Due Amount</th>
          
            </tr>
        </thead>
            <tbody id="mybody" >
            </tbody>
        </table>
  



    
    
