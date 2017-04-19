<script src="<?php echo base_url(); ?>application/assets/js/contraVoucher.js"></script>
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
    width:191px;
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
<h1><font color="#5cb85c" style="font-size:22px;">Contra Voucher Add</font></h1>
    <?php }elseif($modeType=="Edit"){?>
<h1><font color="#5cb85c" style="font-size:22px;">Contra Voucher Edit</font></h1>
    <?php }?>

<form id="frmContraVoucher" name="frmContraVoucher" method="post">
<section id="loginBox" style="height:200px;" >
<table width="100%" border="0">
  <tr style="display:none;">
        <td>
            <input type="text" id="txtModeOfoperation" name="txtModeOfoperation" value="<?php echo($header['mode']);?>" readonly=""/>
           <input type="text" id="voucherMasterId" name="voucherMasterId" value="<?php echo($header['voucherMasterId']);?>" readonly=""/>
           <input type="text" id="serialNo" name="serialNo" value="<?php echo($bodycontent['contraVouchermaster']['serial_number']);?>" readonly=""/>
        </td>
        <td style="display:none;">&nbsp;</td>
   </tr>

   <tr>
       <td>Voucher No:</td>
       <td><input type="text" name="voucherNo" id="voucherNo" value="<?php echo $bodycontent['contraVouchermaster']['voucher_number'];?>" class="textStyle" style="width:190px;" readonly=""/></td>
       <td>Voucher Date:</td>
       <td><input type="text" name="voucherDate" id="voucherDate" class="datepicker textStyle" value="<?php //echo $bodycontent['contraVouchermaster']['voucher_date'];
       if($bodycontent['contraVouchermaster']['voucher_date']){echo $bodycontent['contraVouchermaster']['voucher_date'];}else{echo date('d-m-Y');}
       ?>"/></td>
      
   </tr>
   <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
   </tr>
   <tr>
     
       <td>Cheque No:</td>
       <td><input type="text" name="chqNo" id="chqNo" class="textStyle" value="<?php echo $bodycontent['contraVouchermaster']['cheque_number']?>" style="width:190px;"/></td>
       <td>Cheque Date:</td>
       <td><input type="text" name="chqDate" id="chqDate" value="<?php echo $bodycontent['contraVouchermaster']['cheque_date'];?>" class="datepicker textStyle"/></td>
   </tr>
   <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
   </tr>
   <tr>
       
       
       <td>Branch</td>
       <td>
           <select name="branchid" id="branchid" class="unit selectStyle">
               <option value="0">Select</option>
              <?php foreach($header['branchlist'] as $rows){?>
                <option value="<?php echo($rows['id'])?>" <?php if($rows['id']==$bodycontent['contraVouchermaster']['branchid']){echo("selected='selected'");}else{echo('');}?>><?php echo($rows['branch']); ?></option>
            <?php } ?>
           </select>
         </td>
          <td>Narration:</td>
       <td>
           <textarea id="narration" name="narration" cols="18" rows="" class="textStyle"><?php echo $bodycontent['contraVouchermaster']['narration']?></textarea>
       </td>
   </tr>
    <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
   </tr>
   <tr>

 <!--<tr>
  	<td colspan="6">
            <span class="buttondiv"><div class="save" id="addnewDtlDiv" align="center">Add Voucher Details</div></span>
        </td>
  </tr> -->
</table>
  
   
    
</section>
    
    <!-- Add Mode -->
    
    
    <?php if($modeType=="Add"){?>
    <section id="loginBox" style="height:120px;background:#F9F9F9;" >
       <table width="80%" style="margin:0 auto;">
        <tr>
            <td>
                <p style="margin-top:8px;margin-right:17px;color:green;font-weight:bold;font-style:italic;text-shadow:1px 1px 1px #c5c5c5;"> Debit </p>
            </td>
            <td>
                <select name="acheaddebit" id="acheaddebit" style="" class="selectStyle"> 
                    <option value="0">Select A/c name</option>
                        <?php foreach($header['accounthead'] as $row){?>
                    <option value="<?php echo $row['acountId'];?>"><?php echo $row['account_name']?></option>
                    <?php }?>
                </select>
            </td>
             <td>
                <select name="debitsubledger" id="debitsubledger" style="" class="subledger selectStyle"> 
                    <option value="0">Select subledger</option>
                        <?php foreach($header['subledger'] as $row){?>
                                <option value="<?php echo $row['subledgerid'];?>"><?php echo $row['subledger']?></option>
                        <?php }?>
                                
                </select>
            </td>
            <td>
                <input type="text" name="debitAmt" id="debitAmt" class="debitAmt textStyle" placeholder="Debit amount" style="height:25px;text-align:right;" onkeyup="checkNumeric(this);"/>
            </td>
         </tr>
        
        <tr>
            <td>
                <p style="margin-top:8px;margin-right:17px;color:green;font-weight:bold;font-style:italic;text-shadow:1px 1px 1px #c5c5c5;"> Credit </p>
            </td>
            <td>
                <select name="acheadcredit" id="acheadcredit" style="" class="selectStyle"> 
                    <option value="0">Select A/c name</option>
                        <?php foreach($header['accounthead'] as $row){?>
                    <option value="<?php echo $row['acountId'];?>"><?php echo $row['account_name']?></option>
                    <?php }?>
                </select>
            </td>
             <td>
                <select name="creditsubledger" id="creditsubledger" style="" class="subledger selectStyle"> 
                    <option value="0">Select subledger</option>
                        <?php foreach($header['subledger'] as $row){?>
                                <option value="<?php echo $row['subledgerid'];?>"><?php echo $row['subledger']?></option>
                        <?php }?>
                                
                </select>
            </td>
            <td>
                <input type="text" name="creditAmt" id="creditAmt" class="creditAmt textStyle" placeholder="Credit amount" style="height:25px;text-align:right;" onkeyup="checkNumeric(this);"/>
            </td>
        </tr>
    </table>
    </section>
    <?php }?>
    
    
    <!-- Edit Mode -->
    
    
    <?php 
        if($modeType="Edit"){
    ?>
    <?php if($bodycontent['contraVoucherDtl']){?>
      <section id="loginBox" style="height:120px;background:#F9F9F9;"> 
       <table width="80%" style="margin:0 auto;">
           
           <?php if($bodycontent['contraVoucherDtl']['0']['is_debit']=="Y"){ ?>
               
        <tr>
            
            <td>
                <p style="margin-top:8px;margin-right:17px;color:green;font-weight:bold;font-style:italic;"> Debit </p>
                <input type="hidden" value="<?php echo "VouchermasterId ".($bodycontent['contraVoucherDtl']['0']['voucherMastId']); ?>" />
                <input type="hidden" value="<?php echo "VoucherDetailId ".($bodycontent['contraVoucherDtl']['0']['VoucherDtlId']); ?>" />
            </td>
            <td>
                <input type="hidden" value="<?php echo "VouchermasterId ".($bodycontent['contraVoucherDtl']['0']['voucherMastId']); ?>" />
                 <input type="hidden" value="<?php echo "VoucherDetailId ".($bodycontent['contraVoucherDtl']['0']['VoucherDtlId']); ?>" />
                <select name="acheaddebit" id="acheaddebit" style="" class="selectStyle"> 
                    <option value="0">Select A/c name</option>
                        <?php foreach($header['accounthead'] as $row){?>
                    <option value="<?php echo $row['acountId'];?>" <?php if($bodycontent['contraVoucherDtl']['0']['accountId']==$row['acountId']){echo("selected");}else{echo('');} ?>><?php echo $row['account_name']?></option>
                    <?php }?>
                </select>
            </td>
             <td>
                <select name="debitsubledger" id="debitsubledger" style="" class="subledger selectStyle"> 
                    <option value="0">Select subledger</option>
                        <?php foreach($header['subledger'] as $row){?>
                                <option value="<?php echo $row['subledgerid'];?>" <?php if($bodycontent['contraVoucherDtl']['0']['subLedgerId']==$row['subledgerid']){echo("selected");}else{echo('');} ?>><?php echo $row['subledger']?></option>
                        <?php }?>
                                
                </select>
            </td>
            <td>
                <input type="hidden" value="<?php echo "VouchermasterId ".($bodycontent['contraVoucherDtl']['0']['voucherMastId']); ?>" />
                 <input type="hidden" value="<?php echo "VoucherDetailId ".($bodycontent['contraVoucherDtl']['0']['VoucherDtlId']); ?>" />
                <input type="text" name="debitAmt" id="debitAmt" class="debitAmt textStyle" placeholder="Debit amount" style="height:25px;text-align:right;" value="<?php echo ($bodycontent['contraVoucherDtl']['0']['VouchrDtlAmt']);?>" onkeyup="checkNumeric(this);"/>
            </td>
        </tr><?php }  ?>
        
          <?php if($bodycontent['contraVoucherDtl']['1']['is_debit']=="N"){?>  
        <tr>
            <td>
                 <input type="hidden" value="<?php echo "VouchermasterId ".($bodycontent['contraVoucherDtl']['1']['voucherMastId']); ?>" />
                <input type="hidden" value="<?php echo "VoucherDetailId ".($bodycontent['contraVoucherDtl']['1']['VoucherDtlId']); ?>" />
                <p style="margin-top:8px;margin-right:17px;color:green;font-weight:bold;font-style:italic;"> Credit </p>
            </td>
            <td>
                <input type="hidden" value="<?php echo "VouchermasterId ".($bodycontent['contraVoucherDtl']['1']['voucherMastId']); ?>" />
                <input type="hidden" value="<?php echo "VoucherDetailId ".($bodycontent['contraVoucherDtl']['1']['VoucherDtlId']); ?>" />
                
                <select name="acheadcredit" id="acheadcredit" style="" class="selectStyle"> 
                    <option value="0">Select A/c name</option>
                        <?php foreach($header['accounthead'] as $row){?>
                    <option value="<?php echo $row['acountId'];?>" <?php if($bodycontent['contraVoucherDtl']['1']['accountId']==$row['acountId']){echo("selected");}else{echo('');} ?>><?php echo $row['account_name']?></option>
                    <?php }?>
                </select>
            </td>
             <td>
                <select name="creditsubledger" id="creditsubledger" style="" class="subledger selectStyle"> 
                    <option value="0">Select subledger</option>
                        <?php foreach($header['subledger'] as $row){?>
                                <option value="<?php echo $row['subledgerid'];?>" <?php if($bodycontent['contraVoucherDtl']['1']['subLedgerId']==$row['subledgerid']){echo("selected");}else{echo('');} ?>><?php echo $row['subledger']?></option>
                        <?php }?>
                                
                </select>
            </td>
            <td>
                <input type="hidden" value="<?php echo "VouchermasterId ".($bodycontent['contraVoucherDtl']['1']['voucherMastId']); ?>" />
                <input type="hidden" value="<?php echo "VoucherDetailId ".($bodycontent['contraVoucherDtl']['1']['VoucherDtlId']); ?>" />
                
                <input type="text" name="creditAmt" id="creditAmt" class="creditAmt textStyle" placeholder="Credit amount" style="height:25px;text-align:right;" value="<?php echo ($bodycontent['contraVoucherDtl']['1']['VouchrDtlAmt']);?>" onkeyup="checkNumeric(this);"/>
            </td>
        </tr>
          <?php } ?>
    </table>
    </section>
    
        <?php }}?>


    
    
    
    
    
    
    
    
    
<!--detail data will be added here -->
<!--             
<section id="loginBox" class="groupvoucherDtl" style="display:none;">
    
    <?php if($bodycontent['contraVoucherDtl']){
    
     foreach ($bodycontent['contraVoucherDtl'] as $content){
    ?>
    
    <div id="generalVoucher_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" class="generalVoucher">
            <table width="100%" class="gridtable voucherDtl" id="voucherDtl">
                        <tr>
                        <td width="10%">
                            <select name="debitcredit[]" id="debitcredit_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" style="" class="debitcredit selectStyle"> 
                                <option value="0">A/c Tag</option>
                                <option value="Dr" <?php if($content['is_debit']=='Y'){echo('selected');}else{echo('');} ?>>Dr</option>
                                <option value="Cr" <?php if($content['is_debit']=='N'){echo('selected');}else{echo('');} ?>>Cr</option>
                            </select>
                        </td>
                        <td width="40%"> 
                            <select name="acHead[]" id="acHead_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" style="" class="acHead selectStyle"> 
                                <option value="0">Select A/c Name</option>
                                <?php foreach($header['accounthead'] as $row){?>
                                <option value="<?php echo $row['acountId'];?>" <?php if($content['accountId']==$row['acountId']){echo("selected");}else{echo('');} ?>><?php echo $row['account_name']?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td width="30%">
                             <select name="subledger[]" id="subledger_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" style="" class="subledger selectStyle"> 
                                <option value="0">Select Subledger</option>
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
</section>-->















<div id="salebil_detail_error" style="display:none" title="contraVoucher">
    <span>Invalid row in detail..</span>
</div>


<div id="save_voucher_detail_data"  style="display:none" title="contraVoucher">
    <span>Data successfully saved.</span>   
</div>
<div id="show_voucher_no"  style="display:none" title="contraVoucher">
    <span>Voucher Number:<?php echo($header['Voucherno']);?> </span>   
</div>



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
<div class="save" id="contraVoucher" align="center">Save</div>
 <div id="stock_loader" style="display:none; margin-left:450px;">
         <img src="<?php echo base_url(); ?>application/assets/images/loading.gif" />
 </div>
</span>
</form>

