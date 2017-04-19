<html>
    <head>
        <title>Creditors Outstanding</title>
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
       
        <table width="100%" class="">
               <tr>
                   <td align="center">
                        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                            <?php echo($company); ?> <br/>
                            <?php echo($companylocation) ?>
                        </span>
                    </td>
                </tr>
        </table>
       <table width="100%">
           <tr><td align="center"><span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">Creditors Outstanding List</span></td></tr>
            <tr><td align="center"><span style="font-size:12px;">(<?php echo $fromDate." To ".$toDate?>)</span></td></tr>
        </table>
        
        <div style="padding:2px 0 5px 0;"></div>
        
       <table width="100%">
           <tr>
               <td width="50%" align="left">
                   <table >
                        <tr>
                            <td align="left"><span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">Print Date : <?php echo date('d-m-Y');?></span></td>
                        </tr>
                    </table>
               </td>
               <td width="35%" align="right">
                   <table>
                        <tr>
                            <td align="center"><span style="font-size:12px;"><b>Accounting Year</b><br></span></td>
                        </tr>
                        <tr>
                            <td align="center"><span style="font-size:12px;">(<?php echo date("d-m-Y",strtotime($accounting_period['start_date'])). " To ".date("d-m-Y",strtotime($accounting_period['end_date']));?>)</span></td>
                        </tr>
                   </table>
               </td>
           </tr>
        </table>
        
        
        
        <div style="padding:4px"></div>
        
       
        <div style="padding:4px"></div>
       
       <table width="100%" class="demo">
           <tr>
               <th align="left">Account</th>
               <th align="right">Opening</th>
               <th align="right">Debit</th>
               <th align="right">Credit</th>
               <th align="right">Balance</th>
               <th>&nbsp;</th>
           </tr>
           
           <?php 
           
                $lncount=1;
                $totalOpening = 0;
                $totalDebit = 0;
                $totalCredit =0;
                $totalBalance = 0;
                
                /*---Page Total--*/
                $pTotalOpening = 0;
                $pTotalDebit = 0;
                $pTotalCredit=0;
                $pTotalBlnc=0;
                
           if ($creditorsoutstanding){
               foreach($creditorsoutstanding as $creditor_due){
                    $pTotalOpening+=$creditor_due['opening'];
                    $pTotalDebit+=$creditor_due['debitAmt'];
                    $pTotalCredit+=$creditor_due['creditAmt'];
                    $pTotalBlnc+=$creditor_due['balance'];
                   
                   ?>
           <tr>
               <td align="left"><?php echo $creditor_due['accountname'];?></td>
               <td align="right"><?php if($creditor_due['opening']==0){echo "";}else{ echo number_format($creditor_due['opening'],2);}?></td>
               <td align="right"><?php if($creditor_due['debitAmt']==0){echo "";}else{echo number_format($creditor_due['debitAmt'],2);}?></td>
               <td align="right"><?php if($creditor_due['creditAmt']==0){echo "";}else{echo number_format($creditor_due['creditAmt'],2);}?></td>
               <td align="right"><?php echo number_format($creditor_due['balance'],2);?></td>
               <td align="left"><?php echo $creditor_due['balancetag'];?></td>
           </tr>
           <?php 
                 $lncount = $lncount+1;
                 if($lncount>32){?>
           
           <tr>
               <td align="left">Page Total</td>
               <td align="right"><?php if($pTotalOpening==0){echo "";}else{echo number_format($pTotalOpening,2);}?></td>
               <td align="right"><?php if($pTotalDebit==0){echo "";}else{echo number_format($pTotalDebit,2);}?></td>
               <td align="right"><?php if($pTotalCredit==0){echo "";}else{echo number_format($pTotalCredit,2);}?></td>
               <td align="right"><?php echo number_format($pTotalBlnc,2);?></td>
               <td>&nbsp;</td>
           </tr>
           </table>
            <div class="break"></div>
            <?php $lncount=1; ?>
             <table width="100%" class="">
               <tr>
                   <td align="center">
                        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                            <?php echo($company); ?> <br/>
                            <?php echo($companylocation) ?>
                        </span>
                    </td>
                </tr>
        </table>
        <table width="100%">
           <tr><td align="center"><span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">Creditors Outstanding List</span></td></tr>
            <tr><td align="center"><span style="font-size:12px;">(<?php echo $fromDate." To ".$toDate?>)</span></td></tr>
        </table>
        <div style="padding:2px 0 5px 0;"></div>
        <table width="100%">
           <tr>
               <td width="50%" align="left">
                   <table >
                        <tr>
                            <td align="left"><span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">Print Date : <?php echo date('d-m-Y');?></span></td>
                        </tr>
                    </table>
               </td>
               <td width="35%" align="right">
                   <table>
                        <tr>
                            <td align="center"><span style="font-size:12px;"><b>Accounting Year</b><br></span></td>
                        </tr>
                        <tr>
                            <td align="center"><span style="font-size:12px;">(<?php echo date("d-m-Y",strtotime($accounting_period['start_date'])). " To ".date("d-m-Y",strtotime($accounting_period['end_date']));?>)</span></td>
                        </tr>
                   </table>
               </td>
           </tr>
        </table>
        <div style="padding:4px"></div>
        <table width="100%" class="demo">
           <tr>
               <th align="left">Account</th>
               <th align="right">Opening</th>
               <th align="right">Debit</th>
               <th align="right">Credit</th>
               <th align="right">Balance</th>
               <th>&nbsp;</th>
           </tr>
           <?php } ?>
           
           
                   
             
            <?php  
            $totalOpening = $totalOpening+$creditor_due['opening'];
            $totalDebit = $totalDebit+$creditor_due['debitAmt'];
            $totalCredit = $totalCredit+$creditor_due['creditAmt'];
            $totalBalance = $totalBalance+$creditor_due['balance'];
               }
               }
           ?>
           <tr>
               <td style="font-weight:bold;">Grand Total</td>
               <td align="right" style="font-weight:bold;"><?php if($totalOpening==0){echo "";}else{echo number_format($totalOpening,2);} ?></td>
               <td align="right" style="font-weight:bold;"><?php if($totalDebit==0){echo "";}else{echo number_format($totalDebit,2);} ?></td>
               <td align="right" style="font-weight:bold;"><?php if($totalCredit==0){echo "";}else{echo number_format($totalCredit,2);} ?></td>
               <td align="right" style="font-weight:bold;"><?php echo number_format($totalBalance,2); ?></td>
               <td>&nbsp;</td>
           </tr>
 
       
       </table>
                
    </body>
</html>