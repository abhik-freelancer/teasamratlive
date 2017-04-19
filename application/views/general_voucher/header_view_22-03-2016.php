<script src="<?php echo base_url(); ?>application/assets/js/generalVoucher.js"></script>
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
#narration{
    resize:none;
}
#addnewDtlDiv{
    cursor:pointer;
}
.debitcredit{
    width:80px;
    height:25px;
}
.unit{
    width:110px;
}
.subledger{
   width:250px; 
    height:25px;
}
.acHead{
     width:330px; 
      height:25px;
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
</style>
<!--
<pre>
    <?php 
        echo print_r($bodycontent);
    ?>
</pre>-->

<?php 
    $modeType=$header['mode'];
    if($modeType=='Add'){?>
<h1><font color="#5cb85c" style="font-size:22px;">General Voucher Add</font></h1>
    <?php }elseif($modeType=="Edit"){?>
<h1><font color="#5cb85c" style="font-size:22px;">General Voucher Edit</font></h1>
    <?php }?>

<form id="frmVoucher" name="frmVoucher" method="post">
<section id="loginBox" style="height:300px;">
<table width="100%" border="0">
  <tr style="display:none;">
        <td>
            <input type="text" id="txtModeOfoperation" name="txtModeOfoperation" value="<?php echo($header['mode']);?>" readonly=""/>
           <input type="text" id="voucherMasterId" name="voucherMasterId" value="<?php echo($header['voucherMasterId']);?>" readonly=""/>
           <input type="hidden" id="serialNo" name="serialNo" value="<?php echo($bodycontent['generalVouchermaster']['serial_number']);?>" readonly=""/>
        </td>
        <td style="display:none;">&nbsp;</td>
   </tr>

   <tr>
       <td>Voucher No:</td>
       <td><input type="text" name="voucherNo" id="voucherNo" value="<?php echo $bodycontent['generalVouchermaster']['voucher_number'];?>" class="textStyle" readonly=""/></td>
       <td>Voucher Date:</td>
       <td><input type="text" name="voucherDate" id="voucherDate" class="datepicker textStyle" value="<?php echo $bodycontent['generalVouchermaster']['voucher_date'];?>" /></td>
       <td>Receipt/Payment:</td>
       <td>
           <select name="paymentmode" id="paymentmode" class="paymentmode selectStyle" style="width:100px;">
               <!--<option value="0">Select</option>-->
               <option value="RC" <?php if($bodycontent['generalVouchermaster']['vouchertype']=='RC'){echo('selected');}else{echo('');} ?>>Receipt</option>
               <option value="PY" <?php if($bodycontent['generalVouchermaster']['vouchertype']=='PY'){echo('selected');}else{echo('');} ?>>Payment</option>
           </select>
           
       </td>
   </tr>
   <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
   </tr>
   <tr>
       <td>Paid To:</td>
       <td><input type="text" name="paidto" id="paidto" class="textStyle" value="<?php echo $bodycontent['generalVouchermaster']['paid_to']?>" /></td>
       <td>Bank/Cash:</td>
       <td>
           <select name="paymentType" id="paymentType" class="paymentType selectStyle" style="width:190px;">
              <!-- <option value="0">Select</option>-->
              <?php foreach($header['groupMastername'] as $rows){?>
              <option value="<?php echo $rows['accountId'];?>" <?php if($bodycontent['generalVouchermaster']['accountId']== $rows['accountId']){echo('selected');}else{echo('');} ?>><?php echo $rows['account_name'];?></option>
              <?php }?>
               
           </select>
       </td>
       <td>Cheque No:</td>
       <td><input type="text" name="chqNo" id="chqNo" class="textStyle" value="<?php echo $bodycontent['generalVouchermaster']['cheque_number']?>" style="width:100px;"/></td>
   </tr>
   <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
   </tr>
   <tr>
       <td>Cheque Date:</td>
       <td><input type="text" name="chqDate" id="chqDate" value="<?php echo $bodycontent['generalVouchermaster']['cheque_date']?>" class="datepicker textStyle"/></td>
       <td>Amount:</td>
       <td><input type="text" name="amount" id="amount" class="amount textStyle" value="<?php echo $bodycontent['generalVouchermaster']['voucher_amount']?>" onkeyup="checkNumeric(this);" style="text-align:right;"/></td>
       <td>Unit</td>
       <td>
           <select name="unitid" id="unitid" class="unit selectStyle">
               <option value="0">Select</option>
              <?php foreach($header['unitlist'] as $rows){?>
                <option value="<?php echo($rows['unitid'])?>" <?php if($bodycontent['generalVouchermaster']['unitid']== $rows['unitid']){echo('selected');}else{echo('');} ?>><?php echo($rows['unitName']); ?></option>
            <?php } ?>
           </select>
           
           
           
       </td>
   </tr>
    <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
   </tr>
   <tr>
       <td>Narration:</td>
       <td>
           <textarea id="narration" name="narration" cols="18" rows="" class="textStyle"><?php echo $bodycontent['generalVouchermaster']['narration']?></textarea>
       </td>
   </tr>
      <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
   </tr>
 <tr>
  	<td colspan="6">
            <span class="buttondiv"><div class="save" id="addnewDtlDiv" align="center">Add Voucher Details</div></span>
        </td>
  </tr>
</table>
</section>
<!--detail data will be added here -->


             
<section id="loginBox" class="groupvoucherDtl">
    <?php if($bodycontent['generalVoucherDtl']){
    
     foreach ($bodycontent['generalVoucherDtl'] as $content){
    ?>
    
    <div id="generalVoucher_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" class="generalVoucher">
            <table width="100%" class="gridtable voucherDtl" id="voucherDtl">
                        <tr>
                        <td width="10%">
                            <select name="debitcredit[]" id="debitcredit_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" style="" class="debitcredit selectStyle"> 
                                <option value="0">Select</option>
                                <option value="Dr" <?php if($content['is_debit']=='Y'){echo('selected');}else{echo('');} ?>>Dr</option>
                                <option value="Cr" <?php if($content['is_debit']=='N'){echo('selected');}else{echo('');} ?>>Cr</option>
                            </select>
                        </td>
                        <td width="40%"> 
                            <select name="acHead[]" id="acHead_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" style="" class="acHead selectStyle"> 
                                <option value="0">Select</option>
                                <?php foreach($header['accounthead'] as $row){?>
                                <option value="<?php echo $row['acountId'];?>" <?php if($content['accountId']==$row['acountId']){echo("selected");}else{echo('');} ?>><?php echo $row['account_name']?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td width="30%">
                             <select name="subledger[]" id="subledger_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" style="" class="subledger selectStyle"> 
                                <option value="0">Select</option>
                                <?php foreach($header['subledger'] as $row){?>
                                <option value="<?php echo $row['subledgerid'];?>" <?php if($content['subLedgerId']==$row['subledgerid']){echo("selected");}else{echo('');} ?>><?php echo $row['subledger']?></option>
                                <?php }?>
                                
                            </select>
                        </td>
                        <td>
                            <input type="text" name="amountDtl[]" id="amountDtl_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" value="<?php echo($content['VouchrDtlAmt']);?>" class="amountDtl textStyle" placeholder="Amount" style="height:25px;text-align:right;" onkeyup="checkNumeric(this);"/>
                        </td>
                        <td width="10%">
                            <img class="del" src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" title="Delete" style="cursor: pointer; cursor: hand;" 
                                 id="del_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" />
                        </td>
                        </tr>
            </table>
    </div>
    <?php }
}
?>
</section>
<div id="salebil_detail_error" style="display:none" title="generalVoucher">
    <span>Invalid row in detail..</span>
</div>


<div id="save_voucher_detail_data"  style="display:none" title="generalVoucher">
    <span>Data successfully saved.</span>   
</div>
<div id="show_voucher_no"  style="display:none" title="generalVoucher">
    <span>Voucher Number:<?php echo($header['Voucherno']);?> </span>   
</div>
<!--
<div id="salebil_error_save_dilg" style="display:none" title="Taxinvoice">
    <span>Fail to save the data.</span>
</div>


<div id="salebil_detail_validation_fail" style="display:none" title="Taxinvoice">
    <span>Validation Fail..</span>
</div>
-->


<!--detail data will be added here -->
<section id="loginBox" style="width: 650px; height: 100px;">
<table width="100%" border="0"   class="table-condensed">
    <tr>
        <td>Total Debit</td>
        <td><input type="text" name="totalDebit" id="totalDebit" class="textStyle" value="<?php echo number_format($bodycontent['totalDbtAmt']['totalDebtAmt'],2); ?>" style="text-align:right;" readonly=""</td>
   
     
        <td>Total Credit</td>
        <td><input type="text" name="totalCredit" id="totalCredit" class="textStyle" value="<?php echo number_format($bodycontent['totalCreditAmt']['totalCreditAmt'],2); ?>" style="text-align:right;" readonly=""</td>
    </tr>
    
</table>


</section>

<span class="buttondiv">
<div class="save" id="generalVoucher" align="center">Save</div>
 <div id="stock_loader" style="display:none; margin-left:450px;">
         <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" />
 </div>
</span>
</form>

