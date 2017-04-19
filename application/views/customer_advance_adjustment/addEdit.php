<script src="<?php echo base_url(); ?>application/assets/js/customeradvanceadjust.js"></script>
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />
<style>
.textStyle{
    border:1px solid green;
    border-radius:5px;
}
.selectStyle{
    border-top:1px solid green;
    border-left:1px solid green;
    border-bottom:1px solid green;
    border-radius:5px;
}
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
	padding: 5px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 5px;
	border-style: solid;
	border-color: #666666;
	background-color: #CCFFCC;
}


 .custom-select {
    position: relative;
   width: 363px;
    height:25px;
    line-height:10px;
  font-size: 9px;
  border:1px solid green;
  border-radius:5px;
    
 
}
.custom-select a {
  display: block;
  width: 363px;
  height: 25px;
  padding: 8px 6px;
  color: #000;
  text-decoration: none;
  cursor: pointer;
  font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 12px;
}
.custom-select div ul li.active {
    display: block;
    cursor: pointer;
    font-size: 11px;
}


.custom-select input {
    width: 330px;
    font-family: "Open Sans",helvetica,arial,sans-serif;
    font-size: 11px;
    height: 34px;
}
</style>
<div class="stats">
 
   
    <p class="stat">
        <a href="<?php echo base_url(); ?>customeradvanceadjustment"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/>
        </a>
    </p>
    
</div>
<?php if($header['mode']=="Add"){?>
<h2><font color="#5cb85c">Add customer advance adjustment</font></h2>
<?php }else{?>
<h2><font color="#5cb85c">Edit customer advance adjustment</font></h2>
<?php } ?>




<section id="loginBox" style="height: 170px;">
    <table width="90%" >
  <tr>
    <td>Ref.No.&nbsp;</td>
    <td>
        <input type="hidden" name="txtCustomerAdjustmentId" id="txtCustomerAdjustmentId" value="<?php echo($bodycontent['customeradjustment']['AdjustmentId']); ?>"/>
        <input type="text" name="txtRefNo" id="txtRefNO" class="textStyle" value="<?php echo($bodycontent["customeradjustment"]["AdjustmentRefNo"]) ?>"/>
    </td>
    <td>Date&nbsp;</td>
    <td><input type="text" name="dateofadjustment" id="dateofadjustment" class="textStyle datepicker" value="<?php echo($bodycontent["customeradjustment"]["DateOfAdjustment"]) ?>"/></td>
  </tr>
  
  <tr>
      <td colspan="4">&nbsp;</td>
  
  </tr>
  <tr>
    <td>Customer&nbsp;</td>
            <td>
                <select id="customer" name="customer" class="selectStyle custom-select" <?php if ($bodycontent['customeradjustment']['AdjustmentId']){echo("disabled='disabled'");} ?>>
                    <option value="">Select</option>
                    <?php 
                        foreach ($header['customerAccList'] as $rows) {?>
                            <option value="<?php echo($rows["account_master_id"]); ?>"  <?php if ($rows["account_master_id"] == $bodycontent['customeradjustment']['customerAccId']) {
                            echo('selected');
                        } else {
                            echo('');
                        }
                        ?>>
                        <?php echo($rows["account_name"]); ?>  
                            </option>
                            <?php
                                  }
                                ?>
                                
                 </select>
           </td>
    <td>Advance voucher&nbsp;</td>
    <td>
       <div id="advancevchResult">
            <?php
                if ($bodycontent['customeradjustment']['AdjustmentId']) {
                ?>

                <select id="advanceVoucher" name="advanceVoucher" class="selectStyle" style="width:200px;">
                    <option value="">-Select-</option>
                         <?php
                    foreach ($bodycontent['advancevoucher'] as $rows) {
                         ?>
                    <option value="<?php echo($rows["advanceId"]); ?>"  
                        <?php if($bodycontent['customeradjustment']['advanceMasterId']==$rows["advanceId"]){echo("selected='selected'");} ?> ><?php echo($rows["voucher"]); ?>
                    </option>
                <?php } ?>
                </select>


            <?php } ?>

        </div>
    </td>
  </tr>
  <tr>
      <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>Advance</td>
    <td><input type="text" id="advanceamount" name="advanceamount" class="textStyle" readonly="readonly"  value="<?php echo($bodycontent['remaining']) ?>"/></td>
    <td>Total</td>
    <td><input type="text" id="totalAdjustedAmount" name="totalAdjustedAmount" class="textStyle" readonly="readonly" 
               value="<?php echo($bodycontent['customeradjustment']['TotalAmountAdjusted']); ?>"/></td>
  </tr>
   
    <tr>
      <td colspan="4">&nbsp;</td>
  </tr>
  
  
</table>

</section>
<section id="loginBox">
    <table >
        <tr>
            <td style="padding:0 15px 0 15px;">
                <div id="billList">
                    <select id="saleBill" name="saleBill" style="width:300px;" class="selectStyle custom-select">
                            <option>--Select--</option>
                             <?php if($bodycontent['customeradjustment']['AdjustmentId']){
                             
                            foreach ($bodycontent["invoiceList"] as $rows) {
                             ?>
                                <option value="<?php echo($rows["customerbillmasterid"]);?>">
                                <?php echo($rows["InvoiceNumber"]) ?>
                                </option>
                             
                         
                         <?php 
                                }
                         
                             }?>
                    
                    </select>
                </div>   
            </td>
            <td style="padding:0 15px 0 15px;">
                <input type="text" id="billDate" name="billDate" readonly="readonly" placeholder="Date of Bill" style="text-align: right" class="textStyle"/>
            </td>
            
            <td style="padding:0 15px 0 15px;">
                <input type="text" id="billAmount" name="billAmount" readonly="readonly" placeholder="Unpaid bill amount" style="text-align: right" class="textStyle"/>
            </td>
            
            <td style="padding:0 15px 0 15px;">
                <input type="text" id="adjustedAmount" name="adjustedAmount"  placeholder="Amount to be adjusted" style="text-align: right"  class="textStyle"/>
            </td>
            <td>
                <img class="add" id="add" src="<?php echo base_url(); ?>application/assets/images/add_new.png" title="Add" style="cursor: pointer;" />
                                
            </td>
        </tr>
    </table>
    
</section>
<div id="dialog-Row_validation" title="Adjustment" style="display:none;">
    <span style="font-size: 15px;color: #e13300">Following validation has failed..</span>
    <ul>
        <li><span style="color: #e13300;font-size: 12px;" >Bill number is mandatory.</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Adjustment amount is mandatory.</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Bill number is duplicated .</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Advance amount should be greater than zero..</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Adjusted amount should not greater than unpaid bill amount.</span></li>
    </ul>
</div>
<div id="dialog-validation" title="Adjustment Entry" style="display:none;">
   <span style="font-size: 15px;color: #e13300">Following validation has failed..</span>
    <ul>
        <li><span style="color: #e13300;font-size: 12px;" >Reference number is mandatory.</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Date of adjustment is mandatory.</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Customer is mandatory...</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Advance voucher is mandatory..</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Advance  is mandatory..</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Atleast one bill should be adjusted.</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Adjusted amount should not greater than advance amount.</span></li>
        
    </ul>
</div>
<section id="loginBox">
    <table id="billAdjustTable" width="60%" class="gridtable" align="center">
     <thead style="background-color:gray;">
            <tr> 
                <th>Bill</th>
                <th style="text-align: center">Bill Dt.</th>
                <th style="text-align: right;">Amount</th>
                <th style="text-align: right;">Adjust</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead> 
        
        <tbody>
            <?php
            if ($bodycontent["customerAdjstDtl"]) {

                foreach ($bodycontent["customerAdjstDtl"] as $value) {

                    //echo($value["vendAdjstDtlId"]);
                    ?>

                    <tr>
                        <td><?php echo($value["invoiceNo"]); ?><input type='hidden' name=<?php echo($value["customerBillMasterId"]); ?> value="<?php echo($value["customerBillMasterId"]); ?>"/></td>
                        <td style='text-align: center'><?php echo($value["BillDate"]); ?></td>
                        <td style='text-align:right'><?php echo($value["BillAmount"]); ?></td>
                        <td style='text-align:right'><?php echo($value["adjustedAmount"]); ?></td>
                        <td style='text-align:right'>
                            <img src='<?php echo base_url(); ?>application/assets/images/delete-ab.png' alt='del' class='rowDel' style='cursor: pointer;' /></td>
                    </tr>


    <?php }
}
?>
     </tbody>
       
    </table>
</section>
<section>
    <span class="buttondiv"  style="width:600px;"><div class="save" id="saveCustomerAdjustMent" align="center">Save</div></span>
</section>
