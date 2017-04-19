<select style=" width: 200px;" id="dropdown-invoice">
				<option value="0">--Select Invoice--</option>
                <?php 
				if($invoice){
				foreach($invoice as $row){?>
					<option value="<?php echo($row['invoice']); ?>"> <?php echo($row['invoice']); ?> </option>
				<?php }
				}
				?>
				
</select>
<img src="<?php echo base_url(); ?>application/assets/images/small-loader.gif" id="imgInvoice" style="display:none"/>