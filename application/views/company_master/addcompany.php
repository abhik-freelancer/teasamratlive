<script src="<?php echo base_url(); ?>application/assets/js/company.js"></script>


<h2><font color="#5cb85c">Add Company</font></h2>
<form id="frmCompany" name="frmCompany" method="post" action="<?php echo base_url(); ?>companymaster/updateData">
    <input type="hidden" name="company_hiden_id" value="<?php echo $bodycontent['company_data']->id; ?>" >
<section id="loginBox">
    
<table width="100%" border="0">
  <tr>
    <td><label>Name.</label>&nbsp;</td>
    <td>
        <input type="text" id="name" name="name" style="width:380px;" placeholder="Name" required="required" value="<?php echo $bodycontent['company_data']->company_name; ?>" />      
    </td>
    <td>&nbsp;</td>
    <td><label>Vat No.</label>&nbsp;</td>
    <td><input type="text"  id="txtVatNo" name="txtVatNo" value="" placeholder="Vat No" value="<?php echo $bodycontent['company_data']->vat_number; ?>" /></td>    
  </tr>
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
      <td rowspan="3"><label>Address:</label>&nbsp;</td>
      <td rowspan="3"><textarea cols="42" rows="3" id="address" name="address" placeholder="Address"><?php echo $bodycontent['company_data']->location; ?></textarea></td>
    <td>&nbsp;</td>
    <td><label>CST No.</label>&nbsp;</td>
    <td><input type="text" name="taxCstNo" id="taxCstNo" class="datepicker" value="<?php echo $bodycontent['company_data']->cst_number; ?>" /></td>
  </tr>
  <tr><td colspan="3">&nbsp;</td></tr>
  <tr>
    <td>&nbsp;</td>
    <td><label>GST No</label>&nbsp;</td>
    <td><input type="text"  id="txtGstNo" name="txtGstNo" value="<?php echo $bodycontent['company_data']->gst_number; ?>" class="datepicker" /></td>    
  </tr>
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
    <td><label>State:</label>&nbsp;</td>
    <td><select name="state" id="state" style="width: 190px">
        <?php foreach ($bodycontent['states'] as $content) : ?>
             <option value="<?php echo $content->id; ?>" <?php if($content->id == $bodycontent['data'][0]->state_id): ?> selected="selected"  <?php endif; ?> ><?php echo $content->state_name; ?></option>
        <?php endforeach; ?>
        </select>
    </td>    
    <td>&nbsp;</td>
    <td><label>PAN No.</label>&nbsp;</td>
    <td><input type="text"  id="txtPanNo" name="txtPanNo" value="<?php echo $bodycontent['company_data']->pan_number; ?>" class="datepicker" /></td>    
  </tr>
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
    <td><label>Pin No.</label>&nbsp;</td>
    <td><input type="text"  id="txtPinNo" name="txtPinNo" value="<?php echo $bodycontent['company_data']->pin_number; ?>" class="datepicker" /></td>    
    <td>&nbsp;</td>
    <td><label>Bill Tag:</label>&nbsp;</td>
    <td><input type="text"  id="txtBillTag" name="txtBillTag" value="<?php echo $bodycontent['company_data']->bill_tag; ?>" class="datepicker" /></td>    
  </tr>
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
  			<td colspan="5">
            	<span class="buttondiv">
          				<div class="save" id="addnew" align="center">Add Details</div>
      			</span>
            </td>
  </tr>
</table>
</section>
<!--detail data will be added here -->


</form>

