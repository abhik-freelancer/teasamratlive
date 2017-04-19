<script src="<?php echo base_url(); ?>application/assets/js/customer_advance_add.js"></script>
<script src="<?php echo base_url(); ?>application/assets/js/jquery-customselect.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/jquery-customselect.css" />

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
        <a href="<?php echo base_url(); ?>customeradvance"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/>
        </a>
    </p>
    
</div>
<?php if($header['mode']=="Add"){?>
<h2><font color="#5cb85c">Add customer's advance</font></h2>
<?php }else{?>
<h2><font color="#5cb85c">Edit customer's advance</font></h2>
<?php } ?>

<section id="loginBox" style="height: 450px">
 <div id="dialog-new-save" title="Advance for vendor." style="display:none;">
  <p>
    <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
    Data updated successfully .
  </p>
  
</div>
    
<div id="dialog-validationError" title="Validation error" style="display:none;">
    <ul>
        <li><span style="color: #712d2d"> Voucher date are mandatory.</span></li>
        <li><span style="color: #712d2d"> Mode of payment are mandatory.</span></li>
        <li><span style="color: #712d2d"> payment are mandatory.</span></li>
        <li><span style="color: #712d2d"> customer are mandatory.</span></li>
    </ul>
</div>
    
<form id="addcustomeradvance" name="addcustomeradvance" method="post">
    
    
        <table width="80%" border="0" align="center" class="">
            <tr>
                <td>
                   Voucher Dt. :
                </td>
                <td>
                    <input type="hidden" id="mode" name="mode" value="<?php echo($header['mode']);?>">
                    <input type="hidden" id="customeradvanceId" name="customeradvanceId" value="<?Php echo($bodycontent['customeradvance']['advanceId']);?>">
                    <input type="hidden" id="voucherid" name="voucherid" value="<?Php echo($bodycontent['customeradvance']['voucherid']);?>">
                    <input type="text" id="dateofadvance" name="dateofadvance" class="textStyle datepicker" 
                           value="<?php echo($bodycontent['customeradvance']['dateofadvance']); ?>"/>
                </td>
            </tr>
             <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td> Bank/Cash</td>
                <td>
                    <select id="cashorbank" name="cashorbank" class="selectStyle">
                        <option value="">Select</option>
                        <?php 
                                  foreach ($header['CashOrBank'] as $rows) {?>
                        <option value="<?php echo($rows["accountId"]); ?>"
                                 <?php if($bodycontent['customeradvance']['cashorbankId']==$rows["accountId"]){echo('selected');}else{echo('');} ?>
                                > <?php echo($rows["account_name"]); ?>  </option>
                        <?php
                           }
                        ?>
                    </select>
                </td>
            </tr>
            
             <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td>
                   Cheque No.:
                </td>
                <td>
                    <input type="text" id="cheqno" name="cheqno" class="textStyle" value="<?php echo($bodycontent['customeradvance']['cheque_number']);?>"/>
                </td>
            </tr>
            
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            
            <tr>
                <td>
                   Cheque Date.:
                </td>
                <td>
                    <input type="text" id="cheqdt" name="cheqdt" class="textStyle chqDt" value="<?php echo($bodycontent['customeradvance']['cheque_date']);?>"/>
                </td>
            </tr>
            
            
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            
            <tr>
                <td>Payment</td>
                <td><input type="text" name="paymentamount" id="paymentamount" class="textStyle"   value="<?php echo($bodycontent['customeradvance']['advanceamount']);?>"/></td>
            </tr>
            
           <tr>
                <td colspan="3">&nbsp;</td>
            </tr>

            <tr>
                <td>Customer</td>
                        <td>
                             <?php if($header['mode']=="Edit"){ ?> 
                                <input type="hidden" name="customeradvance" id="customeradvance" value="<?php echo $bodycontent['customeradvance']['customeraccountid'];?>" />
                            <?php } ?>
                            <select id="customeradvance" name="customeradvance" class="selectStyle custom-select"  <?php if ($header['mode']=="Edit"){echo("disabled='disabled'");} ?> >
                                <option value="">Select</option>
                                <?php 
                                
                                
                                  foreach ($header['customerAccList'] as $rows) {?>
                                      
                                <option value="<?php echo($rows["account_master_id"]); ?>"
                                        <?php if($rows["account_master_id"]==$bodycontent['customeradvance']['customeraccountid'])
                                            {echo('selected');}else{echo('');} ?>>
                                         <?php echo($rows["account_name"]); ?>  
                                </option>
                                
                                <?php
                                  }
                                ?>
                                
                            </select>
                            
                        </td>
            </tr>
             <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td>Narration</td>
                <td>
                    <textarea style="width:567px;" class="textStyle" rows="" cols="18" name="narration" id="narration"><?php echo($bodycontent['customeradvance']['narration']);?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">
                    <span class="buttondiv"><div class="save" id="saveCustomerAdvance" align="center">Save</div></span>
                </td>
            </tr>
        </table>
    
    
</form>
</section>

