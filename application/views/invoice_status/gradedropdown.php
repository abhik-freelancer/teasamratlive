<select style=" width: 200px;" id="dropdown-grade">
				<option value="0">--Select grade--</option>
                <?php 
				if($grade){
				foreach($grade as $row){?>
								<option value="<?php echo($row['gradeid']); ?>"> <?php echo($row['grade']); ?> </option>
				<?php 
					}
				}
				?>
</select>
<img src="<?php echo base_url(); ?>application/assets/images/small-loader.gif" id="imgGrade" style="display:none"/>