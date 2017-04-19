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
        <td>Invoice</td>
        <td>Group</td>
        <td>Grade</td>
        <td>Garden</td>
        <td>Bag(s)</td>
        <td>kgs/bag</td>
        
    </tr>
    <?php foreach ($dtlview as $rows){ ?>
        <tr>
            <td>
                <?php echo($rows->invoice_number); ?>
            </td>
            <td><?php echo($rows->group_code); ?></td>
            <td><?php echo($rows->grade); ?></td>
            <td><?php echo($rows->garden_name); ?></td>
            <td align="right">
                <?php echo($rows->number_of_blended_bag);?>
            </td>
            <td align="right"><?php echo($rows->qty_of_bag);?></td>
           
        </tr>
    <?php }?>
    
</table>
    
</section>



