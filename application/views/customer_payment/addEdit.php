<script src="<?php echo base_url(); ?>application/assets/js/customerPaymentAdd.js"></script>
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
        <a href="<?php echo base_url(); ?>customerpayment">
            <img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/>
        </a>
    </p>
</div>

<?php if($header['mode']=="Add"){?>
<h2><font color="#5cb85c">Add customer's payments</font></h2>
<?php }else{?>
<h2><font color="#5cb85c">Edit customer's payments</font></h2>
<?php } ?>




<section id="loginBox" style="height: 350px;">
  <table width="90%" >
  <tr>
  <input type="hidden" id="customerPaymentId" name="customerPaymentId" value="<?php echo($bodycontent['customerpayment']['customerpaymentid']); ?>"/>
  <input type="hidden" id="voucherId" name="voucherId" value="<?php echo($bodycontent['customerpayment']['voucherId']); ?>"/>
    <td>Voucher.&nbsp;</td>
    <td><input type="text" name="txtPaymentVoucherNo" id="txtPaymentVoucherNo" class="textStyle" disabled="disables"  placeholder="Auto number" 
               value="<?php echo($bodycontent['customerpayment']['voucher_number']); ?>" placeholder="Auto number"/>
              
    </td>
    <td>Date&nbsp;</td>
    <td><input type="text" name="paymentdate" id="paymentdate" class="textStyle datepicker" value="<?php echo($bodycontent['customerpayment']['dateofpayment']); ?>"/></td>
  </tr>
  
  <tr>
      <td colspan="4">&nbsp;</td>
  
  </tr>
  
  <tr>
    <td>Cash/Bank.&nbsp;</td>
    <td>
        <select id="cashorbank" name="cashorbank" class="selectStyle">
                        <option value="">Select</option>
                        <?php 
                                  foreach ($header['CashOrBank'] as $rows) {?>
                        <option value="<?php echo($rows["accountId"]); ?>"
                                <?php if($bodycontent['customerpayment']['debitaccountId']==$rows["accountId"]){echo('selected');}else{echo('');} ?>
                                
                                > <?php echo($rows["account_name"]); ?>  </option>
                        <?php
                           }
                        ?>
        </select>
    </td>
    <td>Cheque&nbsp;</td>
    <td><input type="text" name="chequeno" id="chequeno" class="textStyle " value="<?php echo($bodycontent['customerpayment']['cheque_number']); ?>"/></td>
  </tr>
  
  <tr>
      <td colspan="4">&nbsp;</td>
  </tr>
  
  
  <!-- chq dt and vendor -->
  <tr>
    <td>Cheque Dt.&nbsp;</td>
    <td><input type="text" name="chequedt" id="chequedt" class="textStyle chqdt" value="<?php echo($bodycontent['customerpayment']['cheque_date']); ?>"/></td>
    <td>Customer&nbsp;</td>
    <td>
         <select id="customer" name="customer" class="selectStyle custom-select">
            <option value="">Select</option>
                <?php 
                    foreach ($header['customerAccList'] as $rows) {?>
                    <option value="<?php echo($rows["account_master_id"]); ?>" 
                   <?php if($rows["account_master_id"]==$bodycontent['customerpayment']['customeraccountid'])
                                            {echo('selected');}else{echo('');} ?>
                            >
                        <?php echo($rows["account_name"]); ?>  
                    </option>
                    <?php }?>
                                
        </select>
   </td>
    
  </tr>
   <tr>
      <td colspan="4">&nbsp;</td>
  </tr>
 <tr>
    <td>Bank&nbsp;</td>
    <td>
	<input type="text" name="depositbank" id="depositbank" class="textStyle" 
	value="<?php echo($bodycontent['customerpayment']['customerchqbank']); ?>"/>
	</td>
    <td>Branch&nbsp;</td>
    <td>
       <input type="text" name="branchname" id="branchname"  class="textStyle" value="<?php echo($bodycontent['customerpayment']['customerchqbankbranch']); ?>"/>
   </td>
    
  </tr>
  
  
  
  
  
  
  <tr>
      <td colspan="4">&nbsp;</td>
  </tr>
  
  
  <tr>
    <td>Amount&nbsp;</td>
            <td>
                <input type="text" id="amountcredited" name="amountcredited" class="textStyle txtamounttobecredited"  
                value="<?php echo($bodycontent['customerpayment']['totalreceipt']); ?>" />
            </td>
    <td>Bill amount&nbsp;</td>
    <td>
        <input type="text" id="paymentAmount" name="paymentAmount" class="textStyle" readonly="readonly" disabled="disables" 
                value="<?php echo($bodycontent['customerpayment']['totalreceipt']); ?>"
               />
    </td>
  </tr>
  <tr>
      <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>Narration&nbsp;</td>
    <td colspan="2"><textarea id="narration" name="narration" class="textStyle" cols="18"><?php echo($bodycontent['customerpayment']['narration']); ?></textarea>&nbsp;</td>
    <td>&nbsp;</td>
   </tr>
</table>

</section>
<section id="loginBox">
    <table >
        <tr>
            <td style="padding:0 15px 0 15px;">
                <div id="billList">
                    <select id="saleBill" name="saleBill" style="width:300px;" class="selectStyle">
                            <option>--Select--</option>
                            <?php if($bodycontent['customerpayment']['customerpaymentid']) {
                                foreach ($bodycontent["invoices"] as $rows) {
                             ?>
                                <option value="<?php echo($rows["customerbillmasterid"]);?>">
                                <?php echo($rows["InvoiceNumber"]) ?>
                                </option>
                             
                         
                         <?php 
                                }
                             } ?>
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
                <input type="text" id="paidAmount" name="paidAmount"  placeholder="Amount to be paid" style="text-align: right"  class="textStyle payment"/>
            </td>
            <td>
                <img class="add" src="<?php echo base_url(); ?>application/assets/images/add_new.png" title="Add" style="cursor: pointer;" />
                                 
            </td>
        </tr>
    </table>
    
</section>
<div id="dialog-Row_validation" title="Billpayment" style="display:none;">
    <span style="font-size: 15px;color: #e13300">Following validation has failed..</span>
    <ul>
        <li><span style="color: #e13300;font-size: 12px;" >Bill number is mandatory.</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >payment amount is mandatory.</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Bill number is duplicated .</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Bill amount should be greater than zero..</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Amount to be paid should not greater than unpaid bill amount.</span></li>
    </ul>
</div>
<div id="dialog-validation" title="Billpayment Entry" style="display:none;">
   <span style="font-size: 15px;color: #e13300">Following validation has failed..</span>
    <ul>
        <li><span style="color: #e13300 ;font-size: 12px;" >Date of voucher is mandatory.</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Vendor is mandatory...</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Credit account is mandatory.</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Please add detail section.</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Debit amount and Credit amount should be same.</span></li>
    </ul>
</div>
<section id="loginBox">
    <table id="billAdjustTable" width="60%" class="gridtable" align="center">
     <thead style="background-color:gray;">
            <tr> 
                <th>Bill</th>
                <th style="text-align: center">Bill Dt.</th>
                <th style="text-align: right;">Amount</th>
                <th style="text-align: right;">Payment</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead> 
        
        <?php  if($bodycontent["customerPaymentDtl"]){
      foreach ($bodycontent["customerPaymentDtl"] as $value) {
            ?>
               <tr>
              <td><?php echo($value["billNo"]); ?><input type='hidden' name='customerBillMstId' value='<?php echo($value["customerBillMaster"]); ?>'/></td>
              <td style='text-align: center'><?php echo($value["BillDate"]); ?></td>
              <td style='text-align:right'><?php echo($value["BillAmount"]); ?></td>
              <td style='text-align:right'><?php echo($value["paidAmount"]); ?></td>
              <td style='text-align:right'>
              <img src='<?php echo base_url(); ?>application/assets/images/delete-ab.png' alt='del' class='rowDel' style='cursor: pointer;' /></td>
              </tr>
        
        <?php } }?>
       
    </table>
</section>
<section>
    <span class="buttondiv"  style="width:600px;"><div class="save" id="saveCustomerPayment" align="center">Save</div></span>
</section>
