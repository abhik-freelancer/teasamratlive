<html>
    <head>
        <title>Trial Balance</title>
        <style>
            .demo {
		border:1px solid #C0C0C0;
		border-collapse:collapse;
		padding:5px;
	}
        .demo th {
		border:1px solid #C0C0C0;
		padding:4px;
		background:#F0F0F0;
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;
		font-weight:bold;
	}
	.demo td {
		border:1px solid #C0C0C0;
		padding:6px;
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;		
		
	}
        .table_head{
            height:45px;
            border:none;
        }
        .break{
            page-break-after: always;
        }
        </style>
    </head>
    <body>
       
        
       <table width="100%">
            <tr><td align="center"><b>Trial Balance</b><br><span style="font-size:12px;">(<?php echo $fromDate." To ".$toDate?>)</span></td></tr>
        </table>
        
        <div style="padding:2px 0 5px 0;"></div>
       
        
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
                             Print Date : &nbsp;<?php echo date('d-m-Y'); ?>
                         </span>
                    </td>
                </tr>
        </table>
        
        <div style="padding:4px"></div>
        
       
       <table width="100%" class="demo">
           <tr class="table_head">
               <th colspan="4" align="right">Transaction during the year</th>
               <th colspan="2" align="right">Closing during the year</th>
           </tr>
        <tr>
            <tr>
                <th>Account</th>
                <th>Opening</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Debit</th>
                <th>Credit</th>
            </tr>
        </tr>

            <?php
                
            $lncount=1;
            
            $totalOpening=0;
            $totalDebt=0;
            $totalCredit=0;
            $totalClosingDebit=0;
            $totalClosingCredit=0;
            
            $pageTotalOpening = 0;
            $pageTotalDebit = 0;
            $pageTotalCredit = 0;
            $pageTotalClosingDebit= 0;
            $pageTotalClosingCredit = 0;
            
            
            if ($trialbalance) {
                foreach ($trialbalance as $trial_blnc) {
                      $pageTotalOpening = $pageTotalOpening+$trial_blnc['opening'];
                      $pageTotalDebit = $pageTotalDebit+$trial_blnc['debit']; 
                      $pageTotalCredit = $pageTotalCredit+$trial_blnc['credit']; 
                      $pageTotalClosingDebit = $pageTotalClosingDebit+$trial_blnc['closingDebit']; 
                      $pageTotalClosingCredit = $pageTotalClosingCredit+$trial_blnc['closingCredit']; 
                      
                    ?>
                     <tr>
                        <td width="30%"><?php echo $trial_blnc['account'];?></td>
                        <td><?php if($trial_blnc['opening']==0){echo " ";}else{echo  $trial_blnc['opening'];}?></td>
                        <td align="right"><?php if($trial_blnc['debit']==0){echo "";}else{echo $trial_blnc['debit'];}?></td>
                        <td align="right"><?php if($trial_blnc['credit']==0){echo "";}else{echo $trial_blnc['credit'];}?></td>
                        <td align="right"><?php if($trial_blnc['closingDebit']==0){echo "";}else{echo $trial_blnc['closingDebit'];} ?></td>
                        <td align="right"><?php if($trial_blnc['closingCredit']==0){echo "";}else{echo $trial_blnc['closingCredit'];}?></td>

                    </tr> 
                    <?php 
                      $totalOpening = $totalOpening+$trial_blnc['opening'];
                      $totalDebt = $totalDebt+$trial_blnc['debit'];
                      $totalCredit = $totalCredit+$trial_blnc['credit'];
                      $totalClosingDebit = $totalClosingDebit+$trial_blnc['closingDebit'];
                      $totalClosingCredit = $totalClosingCredit+$trial_blnc['closingCredit'];
                      
                        $lncount = $lncount+1;
                        if($lncount>25){
                    ?>
                    <tr>
                        <td align="left"><b>Page Total</b></td>
                        <td align="right"><?php echo number_format($pageTotalOpening,2);?></td>
                        <td align="right"><?php echo number_format($pageTotalDebit,2);?></td>
                        <td align="right"><?php echo number_format($pageTotalCredit,2);?></td>
                        <td align="right"><?php echo number_format($totalClosingDebit,2);?></td>
                        <td align="right"><?php echo number_format($totalClosingCredit,2);?></td>
                    </tr>
                  
                    </table>
                    <div class="break"></div>
                    <?php $lncount=1; ?>
                    <table width="100%">
                        <tr><td align="center"><b>Trial Balance</b><br><span style="font-size:12px;">(<?php echo $fromDate." To ".$toDate?>)</span></td></tr>
                    </table>

                    <div style="padding:2px 0 5px 0;"></div>
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
                                     Print Date : &nbsp;<?php echo date('d-m-Y'); ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" class="demo">
          <tr>
                <th>Account</th>
                <th>Opening</th>
                <th>Debit </th>
                <th>Credit</th>
                <th>Closing Debit</th>
                <th>Closing Credit</th>
            </tr>
                    
            <?php } ?>
            <?php
            }
            } else {
                ?>
                <tr>
                    <td colspan="3" align="center">No data found....!!!</td>
                </tr>
            <?php } ?>
                
                <tr style="border:1px solid #000;">
                    <td align="left"><strong>Total</strong></td>
                    <td align="right"><strong><?php echo number_format($totalOpening,2);?></strong></td>
                    <td align="right"><strong><?php echo number_format($totalDebt,2);?></strong></td>
                    <td align="right"><strong><?php echo number_format($totalCredit,2);?></strong></td>
                    <td align="right"><strong><?php echo number_format($totalClosingDebit,2);?></strong></td>
                    <td align="right"><strong><?php echo number_format($totalClosingCredit,2);?></strong></td>
                </tr>

                
        </table>
                
    </body>
</html>