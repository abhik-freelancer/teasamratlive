<script src="<?php echo base_url(); ?>application/assets/js/openingbalance_invoice.js"></script> 


<style type="text/css">
    table.gridtable {
        font-family: verdana,arial,sans-serif;
        font-size:11px;
        color:#003399;
        border-width: 1px;
        border-color: #666666;
        border-collapse: collapse;
    }
    table.gridtable th {
        border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #666666;
        background-color: #dedede;
    }
    table.gridtable td {
        border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #666666;
        background-color: #CCFFCC;
    }
</style>


<h2><font color="#5cb85c">Opening Balance - Invoice</font></h2>


<form role="form" method="post" name="openingblnc" id="openingblnc">
    <section id="loginBox" style="width:600px;">

        <input type="hidden" id="txtModeOfoperation" name="txtModeOfoperation" value="<?php echo($header['mode']); ?>"/>
        <input type="hidden" id="prMastId" name="prMastId" value="<?php echo($header['prMastId']); ?>"/>
        <input type="hidden" id="pInvDtlId" name="pInvDtlId" value="<?php echo $bodycontent['openingInvMstr']['pInvDtlId'];?>" />

        <lable for="err" id="err" style="color:#F30;font-weight: bold"></lable>
        <br/>
        <label for="group" >Group
            <br/>
            <select name="group" id="group"  style="width:200px;">
                <option value="0">Select Group</option>
                <?php foreach ($header['teagroup'] as $teaGrp) { ;?>
                    <option value="<?php echo($teaGrp->id); ?>"<?php if ($bodycontent['openingInvMstr']['teagroup_master_id'] == $teaGrp->id) {
                    echo ('selected');
                } else {
                    echo ('');
                } ?>><?php echo($teaGrp->group_code); ?></option>
<?php } ?>

            </select>

        </label>

        <label for="location">Location
            <br/>
            <select name="location" id="location" 
                    style="width:200px;">
                <option value="0">Select</option>
<?php foreach ($header['location'] as $location) { ?>
                    <option value="<?php echo($location->lid); ?>"<?php if ($bodycontent['openingInvMstr']['location_id'] == $location->lid) {
        echo ('selected');
    } else {
        echo ('');
    } ?>><?php echo($location->location); ?></option>
                <?php } ?>
            </select>
        </label>
        <br>
        <br>
        <label for="garden" >Garden
            <br/>
            <select name="garden" id="garden" style="width:200px;">
                <option value="0">Select</option>
<?php foreach ($header['garden'] as $garden) { ?>
                    <option value="<?php echo($garden->id); ?>"<?php if ($bodycontent['openingInvMstr']['garden_id'] == $garden->id) {
        echo ('selected');
    } else {
        echo ('');
    } ?>><?php echo($garden->garden_name); ?></option>
<?php } ?>
            </select>
        </label>


        <label for="grade">Grade
            <br/>
            <select id="grade" name="grade" style="width:200px;">
                <option value="0">Select Grade</option>
<?php foreach ($header['grade'] as $grade) { ?>
                    <option value="<?php echo($grade->id); ?>"<?php if ($bodycontent['openingInvMstr']['grade_id'] == $grade->id) {
        echo ('selected');
    } else {
        echo ('');
    } ?>><?php echo($grade->grade); ?></option>
<?php } ?>
            </select>
        </label>
        <br>
        <br/>
        <label for="invoice">Invoice
            <br/>
            <input type="invoice" id="invoice" name="invoice" value="<?php echo $bodycontent['openingInvMstr']['invoice_number']; ?>" style="width:200px;"/>
        </label>


        <label for="saleno">Sale No
            <br/>
            <input type="text" id="saleno" name="saleno" value="<?php echo $bodycontent['openingInvMstr']['sale_number'] ?>" style="width:200px;"/>
        </label>
        <br>
        <br>
        <label for="rate">Rate
            <br/>
            <input type="text" id="rate" class="rate" name="rate" value="<?php echo $bodycontent['openingInvMstr']['price'] ?>" onkeyup="checkNumeric(this);" style="width:200px;"/>
        </label>
        
        <label for="lot">Lot No
            <br/>
            <input type="text" id="lot" name="lot" value="<?php echo $bodycontent['openingInvMstr']['lot'] ?>" style="width:200px;"/>
        </label>
        <br/>
        <!-- <label for="lot">Cost Of Tea
            <br/>
            <input type="text" id="costoftea" name="costoftea" value="<?php //echo $bodycontent['openingInvMstr']['lot'] ?>" style="width:200px;"/>
        </label>-->
        </br>
      
       <fieldset>
           <legend><span style="font-size:14px;">Normal Bag</span></legend>
             <input type="text" name="noofNormalBag" class="noofNormalBag" id="noofNormalBag" placeholder="No Of Bag" value="<?php echo $bodycontent['openingInvMstr']['no_of_bags'] ;?>" onkeyup="checkNumeric(this);"/>
             <input type="text" name="net" class="net" id="net" placeholder="Net" value="<?php echo $bodycontent['openingInvMstr']['net'] ;?>" onkeyup="checkNumeric(this);"/>
       </fieldset>
          
        <br/>
        <span class="buttondiv"  ><div class="save" id="AddDetail" align="center">Add Detail</div></span>


    </section>

<div id="opening_save_dilg"  style="display:none" title="openingInvoice">
    <span>Data successfully save.</span>
</div>
<div id="opening_error_save_dilg" style="display:none" title="openingInvoice">
    <span>Fail to save the data.</span>
</div>


<div id="opening_detail_validation_fail" style="display:none" title="openingInvoice">
    <span>Validation Fail..</span>
</div>




    <div id="showAddDetail" class="showAddDetail">
 
<?php
if ($bodycontent['openingBagDtl']) {

    foreach ($bodycontent['openingBagDtl'] as $content) {
        ?>
                    <div id="bagDetail_<?php echo ($content['pMtId']); ?>_<?php echo ($content['bgDtlId']); ?>" class="opening_invoice_detail">
                        <table width="100%" class="gridtable">
                            <tr>
                                <td width="30%">
                                    <select name="bagtype[]" id="bagtype_<?php echo ($content['pMtId']); ?>_<?php echo ($content['bgDtlId']); ?>" style="width:200px;"> 
                                        <option value="0">Bag Type</option>
                                        <?php foreach ($header['bagType'] as $bagtype) { ?>
                                         <option value="<?php echo($bagtype->bagid);?>"<?php if ($content['bagtypeid'] == $bagtype->bagid) {
                                                echo ('selected');
                                            } else {
                                                echo ('');
                                            } ?>><?php echo($bagtype->bagtype) ?></option>
                                                <?php } ?>
                                         </select>
                                </td>
                                <td width="20%">
                                    <input type="hidden" name="bgDtlId[]" id="bgDtlId" value="<?php echo ($content['bgDtlId']);?>" />
                                    <input type="text" class="noofbag" id="txtnoofbag_<?php echo ($content['pMtId']); ?>_<?php echo ($content['bgDtlId']); ?>" name="txtnoofbag[]" value="<?php echo ($content['no_of_bags']); ?>" placeholder="No Of Bag"/>
                                </td>
                                <td width="20%">
                                    <!--<input type="hidden" name="bgDtlId[]" id="bgDtlId" value="<?php echo ($content['bgDtlId']);?>" />-->
                                    <input type="text" class="net" id="txtDetailNet_<?php echo ($content['pMtId']); ?>_<?php echo ($content['bgDtlId']); ?>" name="txtDetailNet[]" value="<?php echo ($content['net']); ?>" placeholder="Net"/>
                                </td>
                                <td width="10%">
                                    <img class="del" src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" title="Delete" style="cursor: pointer; cursor: hand;" 
                                         id="del_<?php echo ($content['pMtId']) ;?>_<?php echo ($content['bgDtlId']) ;?>" />
                                </td>
                            </tr>
                        </table>
                    </div>
    <?php
    }
}
?>
       
    </div>

    <br><br>
    <span class="buttondiv"  style="width:600px;"><div class="save" id="saveopeningDtl" align="center">Save</div></span>
</form>












