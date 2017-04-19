<script src="<?php echo base_url(); ?>application/assets/js/addFinishProduct.js"></script> 

<h2><font color="#5cb85c">Add Finish Product</font></h2>
<form id="frmFinishedProduct" name="frmFinishedProduct" method="post">
<!-- Packing Date & Ware House ID -->
<section  id="loginBox" style="width: 600px; height: 150px;">
    <table width="100%" border="0">
        <tr>
            <td>Date</td>
            <td><input type="text" name="txtPackingDt" id="txtPackingDt" class="datepicker" value="<?php echo date('d-m-Y');?>"/></td>
            <td>&nbsp;</td>
            <td>Warehouse</td>
            <td>
                <select id="warehouse" name="drpwarehouse">
                    <option value="0">Select</option>
                    <?php foreach ($header['warehouse'] as $rows): ?>
                        <option value="<?php echo($rows->id); ?>"> <?php echo($rows->name); ?> </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5" align="center">
                <label for="blendingref">Blending Ref. No.</label>
                <select style="width: 200px;" id="dropdownblendref" name="dropdownblendref">
                    <option value="0">Select</option>
                    <?php foreach ($header['blendref'] as $rows) { ?>
                        <option value="<?php echo($rows->id); ?>"><?php echo($rows->blending_ref); ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>

    </table>


</section>
<div id="dialog-blendkg" title="Finish product" style="display:none;">
       <span> 
           <img src="<?php echo base_url(); ?>application/assets/images/warning-512.png" />
           Blend quantity do not match with ,packed quantity.<p>Do you want to save ?</p>
       </span>
</div>
 <div id="dialog-new-save" title="Finish product" style="display:none;">
       <span> Data save successfully..</span>
   </div>
   <div id="dialog-error-save" title="Finish product" style="display:none;">
       <span> Error in save..</span>
   </div> 
 <div id="dialog-validation-save" title="Finish product" style="display:none;">
       <span> Validation Fail..</span>
   </div>  
<!--packet detail area-->
<section class="finished_product" id="loginBox" style="display: none;">
    <div id="stock_loader" style="display:none; margin-left:450px;">
        <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" />
    </div>

</section>
<!--packet detail area-->

<span class="buttondiv">
          <div class="save" id="save_finish_product" align="center">Save</div>
</span>
</form>
