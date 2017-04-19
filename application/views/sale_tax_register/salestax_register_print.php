<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sale Tax Register</title>

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
        .demo_font{
            font-family:Verdana, Geneva, sans-serif;
		font-size:11px;	
        }
</style>
</head>
    

<body>

    <pre>
        <?php // print_r($company); ?>
    </pre>
    
    <table width="100%" align="center">
        <tr>
            <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:16px; font-weight:bold">SALES TAX REGISTER</font></td>
        </tr>
        <tr>
            <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:16px; font-weight:bold"><?php echo($company); ?></font></td>
        </tr>
        <!--<tr>
            <td align="center"><font style="font-family:Verdana, Geneva, sans-serif; font-size:16px; font-weight:normal"><?php echo($companylocation); ?></font></td>
        </tr>-->
    </table>    
    
    <div style="padding:8px 0px;"></div>
    
    
    
    <table class="" width="100%">
        <tr>
            <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:13px; font-weight:normal"> Date: <?php echo date('d-m-Y',  strtotime($fromDate));?> to <?php echo date('d-m-Y', strtotime($toDate));?></font></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:13px; font-weight:normal"><b>Sales Tax Output</b></font></td>
        </tr>
    </table>
    
     <table class="demo" width="100%">
         

         <tr>
            <th align="left">Tax Category</th>
            <th align="right">Gross Sales</th>
            <th align="right">Taxable</th>
            <th align="right">Tax</th>
            <th align="right">With Tax</th>
            <th align="right">Exempted</th>
            <th align="right">Others</th>
           
         </tr>
        

    

          <?php 
          
          
          
          $grndTotalGrossSaleTaxOut = 0;
          $grndTotalTaxableTaxOut = 0;
          $grndTotalTaxAmtOut = 0;
          $grndTotalWithTaxOut = 0;
          $grndTotalOthersTaxOut = 0;
          
          
          
          $txInvGrossSale=0;
          $rwTgrossSale = 0;
          $TotalGrossSale=0;
          
          $txInvTaxable=0;
          $rwTeaTaxable=0;
          $TotalTaxableAmt=0;
          
          $txInvTaxAmt=0;
          $rwTeaTaxAmt=0;
          $totalTaxAmt=0;
          
           $txInvWithTax =0;
           $rwTeaWithTaxt = 0;
           $totalWithtaxAmt = 0;
           
           $txInvOthers = 0;
           $rwTeaOthers = 0;
           $totalOthers = 0;
          
          foreach($salestaxregister as $content){
              
              if($content['vatrate']==""){
                  echo (" ");
              }else{
              
              
            //Gross sales
            $txInvGrossSale = $content['salebillData']['GrossSale'];
            $rwTgrossSale = $content['rawteasaleData']['rawGrossSale'];
            $TotalGrossSale = $txInvGrossSale+$rwTgrossSale;
         
            //Taxable
            $txInvTaxable =  $content['salebillData']['taxable'];
            $rwTeaTaxable = $content['rawteasaleData']['rawtaxable'];
                $TotalTaxableAmt = $txInvTaxable+$rwTeaTaxable;
            
            //Tax
            $txInvTaxAmt = $content['salebillData']['taxamount'];
            $rwTeaTaxAmt = $content['rawteasaleData']['rawtaxamount'];
                $totalTaxAmt = $txInvTaxAmt+$rwTeaTaxAmt;
            
            //With Tax
            $txInvWithTax = $content['salebillData']['withTax'];
            $rwTeaWithTaxt = $content['rawteasaleData']['rawwithTax'];
                $totalWithtaxAmt = $txInvWithTax+$rwTeaWithTaxt;
             
             // Others
            $txInvOthers = $content['salebillData']['roundOff'];
            $rwTeaOthers = $content['rawteasaleData']['rawroundOff'];
                $totalOthers = $txInvOthers+$rwTeaOthers;
             
             ?>
        <tr>
            <td>Vat : <?php echo $content['vatrate'];?> %</td>
            <td align="right"><?php echo number_format($TotalGrossSale,2);?> </td>
            <td align="right"><?php echo number_format($TotalTaxableAmt,2);?> </td>
            <td align="right"><?php echo number_format($totalTaxAmt,2);?></td>
            <td align="right"><?php echo number_format($totalWithtaxAmt,2);?></td>
            <td align="right"><?php echo ("0.00")?></td>
            <td align="right"><?php echo number_format($totalOthers,2);?></td>
        </tr>     
           
        
        
         <?php
           $grndTotalGrossSaleTaxOut = $grndTotalGrossSaleTaxOut+$TotalGrossSale;
           $grndTotalTaxableTaxOut = $grndTotalTaxableTaxOut+$TotalTaxableAmt;
           $grndTotalTaxAmtOut = $grndTotalTaxAmtOut+$totalTaxAmt;
           $grndTotalWithTaxOut = $grndTotalWithTaxOut+$totalWithtaxAmt;
           $grndTotalOthersTaxOut = $grndTotalOthersTaxOut+$totalOthers;
         
         
          }
          
              }
         
         ?>
        
         <tr>
             <td><b>Grand Total</b></td>
             <td align="right"><b><?php echo number_format($grndTotalGrossSaleTaxOut,2);?></b></td>
             <td align="right"><b><?php echo number_format($grndTotalTaxableTaxOut,2);?></b></td>
             <td align="right"><b><?php echo number_format($grndTotalTaxAmtOut,2);?></b></td>
             <td align="right"><b><?php echo number_format($grndTotalWithTaxOut,2);?></b></td>
             <td align="right"><?php echo ("0.00")?></td>
             <td align="right"><b><?php echo number_format($grndTotalOthersTaxOut,2);?></b></td>
         </tr>
         
                                           
    </table>
    
    <div style="padding:10px 0px;"></div>
    
    
   <table class="" width="100%">
       <tr>
           <td><font style="font-family:Verdana, Geneva, sans-serif; font-size:13px; font-weight:normal"><b>Tax Input</b></font></td>
        </tr>
    </table>
    
    <table class="demo" width="100%">
        
         <tr>
            <th align="left">Tax Category</th>
            <th align="right">Gross Purchase</th>
            <th align="right">Taxable</th>
            <th align="right">Tax</th>
            <th align="right">With Tax</th>
            <th align="right">Exempted</th>
            <th align="right">Others</th>
           
         </tr>
        
        
        <?php
        
         $grndTotalGrossSaleTaxInput = 0;
         $grndTotalTaxableTaxInput = 0;
         $grndTotalTaxAmtInput = 0;
         $grndTotalWithTaxInput = 0;
         $grndTotalOthersTaxInput = 0;
        
        
        
         $purchInvGrossSale=0;
          $rwMaterialTgrossSale = 0;
          $VatINTotalGrossSale=0;
          
          $purchaseInvTaxable=0;
          $rwMaterialTeaTaxable=0;
          $VatINTotalTaxableAmt=0;
          
          $purchInvTaxAmt=0;
          $rawmaterialTeaTaxAmt=0;
          $VatINtotalTaxAmt=0;
          
           $purchaseInvWithTax =0;
           $rwMaterialTeaWithTaxt = 0;
           $VatINtotalWithtaxAmt = 0;
           
           $purchaseInvOthers = 0;
           $rawmaterialTeaOthers = 0;
           $VatINtotalOthers = 0;
           
           
           foreach($inputtaxregister as $vatinput){
               
            if($vatinput['vatrate']==""){
                echo (" ");
            }else{   
               
                //Gross sales
            $purchInvGrossSale = $vatinput['purchaseInvoiceInput']['purchseInvGross'];
            $rwMaterialTgrossSale = $vatinput['rawpurchMaterialInput']['rawmaterailGross'];
            $VatINTotalGrossSale = $purchInvGrossSale+$rwMaterialTgrossSale;
         
            //Taxable
            $purchaseInvTaxable =  $vatinput['purchaseInvoiceInput']['purchTaxable'];
            $rwMaterialTeaTaxable = $vatinput['rawpurchMaterialInput']['rawMaterialTaxable'];
                $VatINTotalTaxableAmt = $purchaseInvTaxable+$rwMaterialTeaTaxable;
            
            //Tax
            $purchInvTaxAmt = $vatinput['purchaseInvoiceInput']['purTaxamount'];
            $rawmaterialTeaTaxAmt = $vatinput['rawpurchMaterialInput']['rawMaterialTaxamount'];
                $VatINtotalTaxAmt = $purchInvTaxAmt+$rawmaterialTeaTaxAmt;
            
            //With Tax
            $purchaseInvWithTax = $vatinput['purchaseInvoiceInput']['purchaseWithTax'];
            $rwMaterialTeaWithTaxt = $vatinput['rawpurchMaterialInput']['purchaseWithTax'];
                $VatINtotalWithtaxAmt = $purchaseInvWithTax+$rwMaterialTeaWithTaxt;
             
             // Others
            $purchaseInvOthers = $vatinput['purchaseInvoiceInput']['purchaseOthers'];
            $rawmaterialTeaOthers = $vatinput['rawpurchMaterialInput']['purchaseOthers'];
                $VatINtotalOthers = $purchaseInvOthers+$rawmaterialTeaOthers;
        
        ?>
        
           <tr>
            <td>Vat : <?php echo $vatinput['vatrate'];?>%</td>
            <td align="right"><?php echo number_format($VatINTotalGrossSale,2);?> </td>
            <td align="right"><?php echo number_format($VatINTotalTaxableAmt,2);?> </td>
            <td align="right"><?php echo number_format($VatINtotalTaxAmt,2);?></td>
            <td align="right"><?php echo number_format($VatINtotalWithtaxAmt,2);?></td>
            <td align="right"><?php echo ("0.00");?></td>
            <td align="right"><?php echo number_format($VatINtotalOthers,2);?></td>
        </tr>     
        
           <?php 
           
         $grndTotalGrossSaleTaxInput = $grndTotalGrossSaleTaxInput+$VatINTotalGrossSale;
         $grndTotalTaxableTaxInput = $grndTotalTaxableTaxInput+$VatINTotalTaxableAmt;
         $grndTotalTaxAmtInput = $grndTotalTaxAmtInput+$VatINtotalTaxAmt;
         $grndTotalWithTaxInput = $grndTotalWithTaxInput+$VatINtotalWithtaxAmt;
         $grndTotalOthersTaxInput = $grndTotalOthersTaxInput+$VatINtotalOthers;
           
           
           } }?>
        
         <tr>
             <td><b>Grand Total</b></td>
             <td align="right"><b><?php echo number_format($grndTotalGrossSaleTaxInput,2);?></b></td>
             <td align="right"><b><?php echo number_format($grndTotalTaxableTaxInput,2);?></b></td>
             <td align="right"><b><?php echo number_format($grndTotalTaxAmtInput,2);?></b></td>
             <td align="right"><b><?php echo number_format($grndTotalWithTaxInput,2);?></b></td>
             <td align="right"><b><?php echo ("0.00");?></b></td>
             <td align="right"><b><?php echo number_format($grndTotalOthersTaxInput,2);?></b></td>
         </tr>
        
    </table>
    


</body>
</html>
