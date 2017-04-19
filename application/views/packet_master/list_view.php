
<table id="example" class="display" cellspacing="0" width="100%">

    <thead bgcolor="#CCCCCC">
  
            <th>Actions</th>
            <th>Packet</th>
            <th>Qty(Kgs.)</th>
            <th>Qty(Kgs.) in bag</th>
    </thead>
    
     <tbody>
	<?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
            <tr id="row<?php echo $content->packetid; ?>">
            	<td>
                <input type="radio" class="mini" name="action" id="chk<?php echo $content->packetid; ?>" value="<?php echo $content->packetid; ?>"/>
                <input type="hidden" name="id_packet<?php echo $content->packetid; ?>" id="id_packet<?php echo $content->packetid; ?>" value="<?php echo $content->packetid; ?>">
                
               </td>
                <td id="packet<?php echo $content->packetid; ?>"><?php echo $content->packet; ?> </td>
                <td id="packQty<?php echo $content->packetid; ?>"><?php echo $content->PacketQty; ?> </td>
                <td id="QtyinBag<?php echo $content->packetid; ?>"><?php echo $content->qtyinBag; ?> </td>
            </tr>
    <?php endforeach; 
     else: ?>
 
    <?php
    endif; 
    ?>
	 </tbody>
</table>
<div id="dialog-confirm-packet" title="Delete packet" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Do you want to remove the packet?</p>
</div>







    
    
