<table>
	<tr id="sampletr"><td><input type="text" name="packtno[]" id="packtno"/></td><td>&nbsp;</td><td><input type="text" name="packtvalue[]" id="packtvalue" class="packtvaluenet" /><img src="<?php echo base_url(); ?>application/assets/images/delete.png" id="sampleimg" height="15" width="15"></td></tr>
</table>
<script>

$('.packtvaluenet').change(function(){
			calculateCurrentVatratetotal();
		});
</script>