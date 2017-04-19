<!-- CSS goes in the document HEAD or added to your external stylesheet -->
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
<!-- Table goes in the document BODY -->

<section id="loginBox" >
    
    <table class="CSSTableGenerator" >
    <tr>
       
        <td>Refrence No</td>
        <td>Transfer Date</td>
        <td>StockOut Bag</td>
        <td>Net</td>
       
        
    </tr>
    
    
  
    <?php foreach ($stockDtlView as $rows){ ?>
        <tr>
            <td> <?php echo($rows['refrence_number']); ?> </td>
            <td><?php echo($rows['transferDt']); ?></td>
            <td align="right"><?php echo($rows['StockOutBags']); ?></td>
            <td align="right"><?php echo($rows['qty_stockout_kg']); ?></td>
        </tr>
    <?php }?>
    
    
</table>
    
</section>



