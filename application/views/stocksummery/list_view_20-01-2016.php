
<table id="example" class="display" cellspacing="0" width="100%" border="0">

<thead>
    
    <th>Garden</th>
    <th>Invoice</th>
    <th>Group</th>
    <th>Grade</th>
    <th>Location</th>
    <th>Stock in Bags</th>
    <th>Stock In Kgs</th>
    <th>Rate</th>
    <th>Amount</th>
 </thead>
     <tbody>
    
         
         <?php 
		
            if(count($stock) > 0)  : 
                    foreach ($stock as $content) : ?>
        
                <tr id="row<?php echo ($content['PbagDtlId']); ?>">
                  
                        
                    <td>
                     <?php echo($content['Garden']); ?>
                    </td>
                    <td><?php echo $content['Invoice']; ?> </td>
                      <td>
                        <?php echo("<font style='font-family:Verdana, Geneva, sans-serif ; font-size:14px; font-weight:bold'>Group -> </font>".$content['Group']); ?> 
                    </td>
                    <td><?php echo $content['Grade']; ?> </td>
                    <td><?php echo $content['Location']; ?> </td>
                    <td  align="right"><?php echo number_format($content['Numberofbags'],2); ?> </td>
                    <td align="right"><?php echo number_format($content['NetBags'],2); ?> </td>
                   
                    <td align="right"><?php echo number_format($content['Rate'],2); ?> </td>
                    <td align="right"><?php echo number_format($content['amount'],2); ?> </td>
                  </tr>
                
        <?php endforeach; 
		  endif; 
//     else:
?>
         <!--<tr><td colspan="13" style="text-align:center">No records found</td></tr>-->

     </tbody>
    
</table>
<script>

$(document).ready(function() {
    var table = $('#example').DataTable({
        "columnDefs": [
            { "visible": false, "targets": 2 }
        ],
        "order": [[ 2, 'asc' ]],
        "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(2, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="5">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    } );
 
    // Order by the grouping
    $('#example tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
            table.order( [ 2, 'desc' ] ).draw();
        }
        else {
            table.order( [ 2, 'asc' ] ).draw();
        }
    } );
} );
</script>










    
    
