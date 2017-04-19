
<style type="text/css">
table.tftable {font-size:12px;color:#333333;width:100%;border-width: 1px;border-color: #bcaf91;border-collapse: collapse;}
table.tftable th {font-size:12px;background-color:#ded0b0;border-width: 1px;padding: 8px;border-style: solid;border-color: #bcaf91;text-align:left;}
table.tftable tr {background-color:#ffffff;}
table.tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #bcaf91;}
</style>

<div style="overflow: auto; height: 300px; padding:5px 2px 2px 2px;">
    <table id="tfhover" class="tftable" border="1">
        
        <tr><th>Invoice</th><th>Date</th><th>Bill amount</th><th>Paid</th></tr>
        
        <?php foreach($invoicedetails as $data) {?>
        <tr>
            <td>
                <?php echo($data["pInvoiceNumber"]);?>
            </td>
            <td>
                <?php echo($data["pInvoiceDate"]);?>
            </td>
            
            <td>
                <?php echo($data["pAmount"]);?>
            </td>
            
             <td>
                <?php echo($data["paidAmount"]);?>
            </td>
            
        </tr>
        <?php 
        }
        ?>
    </table>
</div>



