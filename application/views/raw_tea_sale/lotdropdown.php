<select style=" width: 200px;" id="dropdown-lot">
				<option value="0">--Select Lot--</option>
                <?php 
				if($lot){
				foreach($lot as $row){?>
								<option value="<?php echo($row['lot']); ?>"> <?php echo($row['lotnumber']); ?> </option>
				<?php 
					}
				}
				?>
</select>
<img src="<?php echo base_url(); ?>application/assets/images/small-loader.gif" id="imgLot" style="display:none"/>