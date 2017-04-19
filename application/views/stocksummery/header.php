<!DOCTYPE html>
<html>

    <head>
        <meta charset='UTF-8'>

        <title>Stock Summery</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/ReportStyle.css">
       <script src="<?php echo base_url(); ?>application/assets/lib/jquery-1.11.1.min.js" type="text/javascript"></script>
        
       <style>
	.demo {
		border:1px solid #C0C0C0;
		border-collapse:collapse;
		padding:5px;
	}
	.demo th {
		border:1px solid #C0C0C0;
		padding:5px;
		background:#F0F0F0;
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;
		font-weight:bold;
	}
	.demo td {
		border:1px solid #C0C0C0;
		padding:5px;
		font-family:Verdana, Geneva, sans-serif;
		font-size:11px;		
		
	}
        .small_demo {
		border:1px solid;
		padding:2px;
	}
	.small_demo td {
		//border:1px solid;
		padding:2px;
                width: auto;
                font-family:Verdana, Geneva, sans-serif; 
                font-size:11px; font-weight:bold;
	}
        
        
	.headerdemo {
		border:1px solid #C0C0C0;
		padding:2px;
	}
	
	.headerdemo td {
		//border:1px solid #C0C0C0;
		padding:2px;
	}
</style>

    </head>

    <body>
              <div id="page-wrap">

            <table width="100%" class="">
               
                <tr>
                    <td align="left">
                        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                            <?php echo($company); ?> <br/>
                            <?php echo($companylocation) ?>
                        </span>
                    </td>
                    <td align=right>
                         <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                             Print Date : &nbsp;<?php echo($printDate); ?>
                         </span>
                    </td>
                </tr>
               
                <tr>
                    <!--<td colspan="2">Closing stock summery for the period of &nbsp; (<?php echo($dateRange); ?>)</td>-->
                    <td colspan="2">
                        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:500;">
                        Closing stock summery as on &nbsp;<?php echo($printDate); ?>
                        </span>
                    </td>
                </tr>
            </table>
            <div style="padding:8px 0px 8px 0px"></div>

            <table class="demo" width="100%">
             
                <tr>
                 <th>Group</th>
                    <th>Location</th>
                    <th>Garden</th>
                    <th>Invoice</th>
                    <th>Grade</th>
                    <th>Lot</th>
                    <th>Sale No</th>
                    <th>Stock In Bags</th>
                    <th>Net Kgs.</th>
                    <th>Stock In Kgs</th>
                    <th>Cost Of Tea</th>
                    <th>Amount (Rs.)</th>

                </tr>


       
        
        

   

