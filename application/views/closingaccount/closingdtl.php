<script>
$(document).ready(function(){
    
    $('#example').dataTable( {
                                "order": [],
                                "aoColumnDefs": [
                                    { 'bSortable': false, 'aTargets': [ 0] }
                                    ]
                               
                                
});   
});
</script>


<table id="example" class="display" cellspacing="0" width="100%">

<thead bgcolor="#CCCCCC">

            <th>Account</th>
            <th>Closing</th>
            
    </thead>
    <tbody>
       <?php 
        if($result)  : 
                foreach ($result as $content) : ?>
        <tr>
            <td><?php echo($content['account_name']);?></td>
            <td><?php echo($content['opening_balance']);?></td>
        </tr>
      <?php endforeach; 
     else: ?>
         <tr> 
             <td>No</td>
             <td> data found</td>
         </tr>
    <?php
    endif; 
    ?>
    </tbody>
     </table>