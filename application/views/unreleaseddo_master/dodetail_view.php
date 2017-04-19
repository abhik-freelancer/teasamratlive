
 <script type="text/javascript">
 $(function(){
			$('.datepicker').datepicker({
				dateFormat: 'dd-mm-yy',
				minDate: '01-04-2000'
			}); 
			
			/* submitting the form*/
			
			$("#savedpage").click(function(){
			 $("#spinner").show();
	    	 $("#unreleasedo").submit();
			});
			
			
});
</script>
<form name="unreleasedo" id="unreleasedo" method="post" action="<?php echo base_url(); ?>unreleaseddo/savedata">
 <section id="loginBox" style="width:600px;">
  <table width="100%">
                   <tr>
                   		<td><b>Vendor </b><span id="vendor"><?php if (count($data) > 0): echo $data[0]->vendor_name; endif; ?></span></td>
                   		<td><b>Year </b><span id="year"><?php  if (count($data) > 0): echo date('Y', strtotime($data[0]->invoiceyear)); endif;?></span></td>
                   </tr>
                   
       </table>
 </section> 
 
 <input type="hidden" name="masterid" id="masterid" value="<?php if (count($data) > 0): echo $data[0]->masterid; endif; ?>">
 
 <table border="0" width="100%" id="example2" style="padding-bottom:1em;">
 
 <thead bgcolor="#CFDBC5" style="font-family:\'Times New Roman\', Times, serif"><th>Invoice Number</th><th>LOT</th><th>DO</th><th>DO Date</th></thead>
  <?php
  if(count($data) > 0) :
	 foreach($data as $record)
	 {	 	
	?>

<tr  style="border-bottom:1pt solid black;">
<td><input type="hidden" name="unreleaseddoid[]" id="unreleaseddoid<?php echo $record->invoice_number; ?>" value="<?php echo $record->unreleaseddoid;?>" />
<?php echo $record->invoice_number; ?></td>
<td><?php echo $record->lot; ?></td>
<td><input type="text" name="donumber[]" id="donumber<?php echo $record->invoice_number; ?>" value="<?php echo $record->do;?>" /></td>
<td><input type="text" name="dodate[]"  id="dodate<?php echo $record->invoice_number; ?>" class="datepicker" value="<?php if($record->do_date != ''): echo date("d-m-Y", strtotime($record->do_date));  endif;?>" />
<input type="hidden" name="dodatehide[]" id="dodatehide<?php echo $record->invoice_number; ?>" value="<?php if($record->do_date != ''): echo $record->do_date; endif;?>"/>
</td>
</tr>

 <?php
     }
	 ?>
<tr><td colspan="4">&nbsp;</td></tr>
<tr><td colspan="4"><span class="buttondiv"><div class="save" id="savedpage" align="center">SAVE</div></span></td></tr>	 
	 <?php else:
	 ?>
	 <tr  style="border-bottom:1pt solid black; text-align:center;"><td colspan="4">No Records Found</td></tr>
  	<?php
  	endif; 
	 ?>
	 </table>
      </form>