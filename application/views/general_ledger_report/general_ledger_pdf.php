<html>
    <head>
        <title>General Ledger</title>
        <style>
            .demo {
		border:0px solid #C0C0C0;
		border-collapse:collapse;
		padding:5px;
	}
        .demo th {
		border:0px solid #C0C0C0;
		padding:4px;
		background:#F0F0F0;
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;
		font-weight:bold;
	}
	.demo td {
		border:0px solid #C0C0C0;
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
        <table width="100%" class="">
               <tr>
                   <td align="center"><span style="font-family:Verdana, Geneva, sans-serif; font-size:13px; font-weight:bold;"><?php echo $accountname;?></span></td>
               </tr>
        </table>
        
        
       <table width="100%">
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
               <th>Date</th>
               <th>&nbsp;</th>
               <th>Particulars</th>
               <th>Voucher Type</th>
               <th>Voucher No./<br>Invoice No</th>
               <th>Debit</th>
               <th>Credit</th>
           </tr>
           
           <?php  if ($generalledger) {
                $totalDebit = 0;
                $totalCredit =0;
                
               
               foreach($generalledger as $general_ledger){ ?>
           <tr>
               <td>
                   <?php if($general_ledger['account']=="Opening Balance")
                   {echo " ";}
                   else{
                       echo date('d-m-Y',strtotime($general_ledger['voucherdate']));
                       
                   }?>
               </td>
               <td><?php echo $general_ledger['accounttag'];?></td>
               <td><strong><?php echo $general_ledger['account'];?></strong><br><?php echo $general_ledger['narration'];?></td>
               <td><?php echo $general_ledger['transtype'];?></td>
               <td><?php echo $general_ledger['vouchernumber'];?></td>
               <td align="right"><?php if($general_ledger['debitamt']==0){echo "";}else{echo number_format($general_ledger['debitamt'],2);}?></td>
               <td align="right"><?php if($general_ledger['creditamt']==0){echo "";}else{echo number_format($general_ledger['creditamt'],2);}?></td>
           </tr>
           
           
                   
             
            <?php  
            $totalDebit = $totalDebit+$general_ledger['debitamt'];
            $totalCredit = $totalCredit+$general_ledger['creditamt'];
            $differenceAmt = $totalDebit-$totalCredit;
            $absdifferenceAmt=abs($differenceAmt);
            if($differenceAmt>0){
                $lastbalance = $totalDebit;
                
            }else{
                $lastbalance = $totalCredit;
            }
            
            
            if($differenceAmt>0){
                $tag = "Dr";
            }
            elseif ($differenceAmt==0) {
            $tag="";
             }
            else{
                $tag="Cr";
            }
            
               } }
           ?>
           <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td align="right" style="border-bottom:1px solid #CCC;border-top:1px solid #CCC;"> <?php if($totalDebit==0){echo "";}else{echo number_format($totalDebit,2);}?></td>
               <td align="right" style="border-bottom:1px solid #CCC;border-top:1px solid #CCC;"> <?php if($totalCredit==0){echo "";}else{echo number_format($totalCredit,2);}?></td>
           </tr>
           
           <tr>
               <td>&nbsp;</td>
               <td><?php echo $tag;?></td>
               <td>Closing Balance</td>
               
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <?php 
                        if($tag=="Dr"){ 
                           
               ?>
               <td align="right" style="border-bottom:1px solid #CCC;"><?php echo "";?></td>
                       
               <td align="right" style="border-bottom:1px solid #CCC;"> <?php echo number_format($absdifferenceAmt,2);?></td>
                        <?php } else{
                            
                            ?>
                <td align="right" style="border-bottom:1px solid #CCC;"> <?php echo number_format($absdifferenceAmt,2);?></td>
                <td align="right" style="border-bottom:1px solid #CCC;"><?php echo "";?></td>
                        <?php } ?>
           
               
           </tr>
<?php 
        
      
?>
           <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               
               <td>&nbsp;</td>
               <td>&nbsp;</td>

               <td align="right" style="border-bottom:1px solid #CCC;"><?php echo number_format($lastbalance,2);?></td>
                       
               <td align="right" style="border-bottom:1px solid #CCC;"> <?php echo number_format($lastbalance,2);?></td>
                        
           
               
           </tr>
       </table>
                
    </body>
</html>