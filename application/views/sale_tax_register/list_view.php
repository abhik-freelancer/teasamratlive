

      
   <table id="example" class="display" cellspacing="0" width="100%;" border="0" >
         
     <thead bgcolor="#a6a6a6">
         <tr>
            <!--<th align="right">Tax Category</th>
            <th align="right">Gross Sales</th>
            <th align="right">Taxable</th>
            <th align="right">Tax</th>
            <th align="right">With Tax</th>
            <th align="right">Others</th>--->
            
            
             <td align="left"><b>Tax Category</b></td>
             <td align="right"><b>Gross Sales</b></td>
             <td align="right"><b>Taxable</b></td>
             <td align="right"><b>Tax</b></td>
             <td align="right"><b>With Tax</b></td>
             <td align="right"><b>Others</b></td>
           
         </tr>
        
    </thead>
    
    <tbody>
      
        
          <?php 
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
            <td align="right"><?php echo number_format($totalOthers,2);?></td>
        </tr>     
         <?php } ?>
        
        
         <?php 
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
            <td align="right"><?php echo number_format($VatINtotalOthers,2);?></td>
        </tr>     
        
           <?php } ?>
       
        
        
    </tbody>                                              
    </table>

<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>application/assets/js/jquery.dataTables.min.js"></script>
<script>
$( document ).ready(function() {
    $("#example").DataTable();
});
</script>
     

