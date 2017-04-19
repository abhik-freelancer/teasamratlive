<script src="<?php echo base_url(); ?>application/assets/js/vendoradjustmentAdd.js"></script>
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
</style>
<div class="stats">
 
   
    <p class="stat">
        <a href="<?php echo base_url(); ?>vendoradvanceadjustment"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/>
        </a>
    </p>
    
</div>
<?php if($header['mode']=="Add"){?>
<h2><font color="#5cb85c">Add vendor advance adjustment</font></h2>
<?php }else{?>
<h2><font color="#5cb85c">Edit vendor advance adjustment</font></h2>
<?php } ?>




<section id="loginBox" style="height: 170px;">
    <table width="90%" >
  <tr>
    <td>Ref.No.&nbsp;</td>
    <td><input type="text" name="txtRefNo" id="txtRefNO" class="textStyle"/></td>
    <td>Date&nbsp;</td>
    <td><input type="text" name="dateofadjustment" id="dateofadjustment" class="textStyle datepicker"/></td>
  </tr>
  
  <tr>
      <td colspan="4">&nbsp;</td>
  
  </tr>
  <tr>
    <td>Vendor&nbsp;</td>
            <td>
                <select name="vendor" id="vendor" class="selectStyle">
                    <option value="">--Select--</option>
         <?php 
                                
                                
                                  foreach ($header['vendors'] as $rows) {?>
                                      
                                <option value="<?php echo($rows["vendoraccountId"]); ?>" 
                                        <?php if($rows["vendoraccountId"]==$bodycontent['vendoradvancement']['vendorId'])
                                            {echo('selected');}else{echo('');} ?>> <?php echo($rows["name"]); ?>  </option>
                                
                                <?php
                                  }
                                ?>
        </select>
            </td>
    <td>Advance voucher&nbsp;</td>
    <td>
        <div id="advancevchResult">
            
        </div>
        
    </td>
  </tr>
  <tr>
      <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>Advance</td>
    <td><input type="text" id="advanceamount" name="advanceamount" class="textStyle" readonly="readonly"/></td>
    <td>Total</td>
    <td><input type="text" id="totalAdjustedAmount" name="totalAdjustedAmount" class="textStyle" readonly="readonly"/></td>
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
                    <select id="purchaseBill" name="purchaseBill" style="width:300px;" class="selectStyle">
                            <option>--Select--</option>
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
                <img class="add" src="<?php echo base_url(); ?>application/assets/images/add_new.png" title="Add" style="cursor: pointer;" />
                                 
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
    </ul>
</div>
<div id="dialog-validation" title="Adjustment Entry" style="display:none;">
   <span style="font-size: 15px;color: #e13300">Following validation has failed..</span>
    <ul>
        <li><span style="color: #e13300;font-size: 12px;" >Reference number is mandatory.</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Date of adjustment is mandatory.</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Vendor is mandatory...</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Advance voucher is mandatory..</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Advance  is mandatory..</span></li>
        <li><span style="color: #e13300 ;font-size: 12px;" >Atleast one bill should be adjusted.</span></li>
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
       
    </table>
</section>
<section>
    <span class="buttondiv"  style="width:600px;"><div class="save" id="saveVendorAdjustMent" align="center">Save</div></span>
</section>
