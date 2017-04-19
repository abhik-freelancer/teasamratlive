
<table id="example" class="display" cellspacing="0" width="100%">

    <thead bgcolor="#CCCCCC">
            <th>Action</th>
            <th>Product</th>
            <th>Product Desc</th>
            <th>Packet</th>
            <th>Qty (kgs.)</th>
    </thead>
    
     <tbody>
	<?php 
        if($bodycontent)  : 
                foreach ($bodycontent as $content) : ?>
    
            <tr id="row<?php echo $content->IdProduct; ?>" class="row<?php echo $content->IdProduct;?>">
            	<td>
                <input type="radio" class="mini" name="action" id="chk<?php echo $content->IdProduct; ?>" value="<?php echo $content->IdProduct; ?>"/>
                <input type="hidden" name="id_packets" id="id_packets<?php echo $content->IdProduct;?>" value="<?php echo $content->packetIds; ?>">
                </td>
                <td id="product<?php echo $content->IdProduct;?>"><?php echo $content->product; ?> </td>
                <td id="productdesc<?php echo $content->IdProduct;?>"><?php echo $content->productdesc; ?> </td>
                <td><?php echo $content->pakets; ?> </td>
                <td><?php echo $content->packetQtys; ?> </td>
            </tr>
    <?php endforeach; 
     else: ?>
 
    <?php
    endif; 
    ?>
	 </tbody>
</table>
<div id="dialog-confirm" title="Delete product" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Do you want to remove the product?</p>
</div>







    
    
