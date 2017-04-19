
<table id="example" class="display" cellspacing="0" width="100%">

    <thead bgcolor="#CCCCCC">
  
            <th>Actions</th>
            <th>Auction Area</th>
            <th>Transportation Cost</th>
            
    </thead>
    
     <tbody>
	<?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
            <tr id="row<?php echo $content->aucAreaid; ?>">
            	<td>
                <input type="radio" class="mini" name="action" id="chk<?php echo $content->aucAreaid; ?>" value="<?php echo $content->aucAreaid; ?>"/>
                <input type="hidden" name="id_auc_area<?php echo $content->aucAreaid; ?>" id="id_packet<?php echo $content->aucAreaid; ?>" value="<?php echo $content->aucAreaid; ?>">
                
               </td>
                <td id="auc_area<?php echo $content->aucAreaid; ?>"><?php echo $content->auctionarea; ?> </td>
                <td id="trans_cost<?php echo $content->aucAreaid; ?>"><?php echo $content->transcost; ?></td>
                
            </tr>
    <?php endforeach; 
     else: ?>
 
    <?php
    endif; 
    ?>
	 </tbody>
</table>
<div id="dialog-confirm-aucArea" title="Delete packet" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Do you want to remove the auction area?</p>
</div>







    
    
