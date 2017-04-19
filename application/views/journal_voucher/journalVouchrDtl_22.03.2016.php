
 
<div id="generalVoucher_0_<?php echo($divnumber); ?>" class="generalVoucher">
            <table width="100%" class="gridtable voucherDtl" id="voucherDtl">
                        <tr>
                        <td width="10%">
                            <select name="debitcredit[]" id="debitcredit_0_<?php echo($divnumber); ?>"  class="debitcredit selectStyle" > 
                                <option value="0">Select</option>
                                <option value="Dr">Dr</option>
                                <option value="Cr">Cr</option>
                            </select>
                        </td>
                        <td width="40%"> 
                            <select name="acHead[]" id="acHead_0_<?php echo($divnumber); ?>" style="" class="acHead selectStyle"> 
                                <option value="0">Select</option>
                                <?php foreach($accounthead as $row){?>
                                <option value="<?php echo $row['acountId'];?>"><?php echo $row['account_name']?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td width="30%">
                             <select name="subledger[]" id="subledger_0_<?php echo($divnumber); ?>" style="" class="subledger selectStyle"> 
                                <option value="0">Select</option>
                                <?php foreach($subledger as $row){?>
                                <option value="<?php echo $row['subledgerid'];?>"><?php echo $row['subledger']?></option>
                                <?php }?>
                                
                            </select>
                        </td>
                        <td>
                            <input type="text" name="amountDtl[]" id="amountDtl_0_<?php echo($divnumber); ?>" class="amountDtl textStyle" placeholder="Amount" style="height:25px;text-align:right;" onkeyup="checkNumeric(this);"/>
                        </td>
                        <td width="10%">
                            <img class="del" src="<?php echo base_url(); ?>application/assets/images/delete-ab.png" title="Delete" style="cursor: pointer; cursor: hand;" 
                                 id="del_0_<?php echo($divnumber); ?>" />
                        </td>
                        </tr>
            </table>
    </div>


<script>


    




</script>