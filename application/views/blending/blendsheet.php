<!DOCTYPE html>
<html>

    <head>
        <meta charset='UTF-8'>

        <title>Blend Sheet</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/ReportStyle.css">
       <script src="<?php echo base_url(); ?>application/assets/lib/jquery-1.11.1.min.js" type="text/javascript"></script>
        

        <script>
            $(document).ready(function() {
                $("#printbtn").click(function() {
                    window.print();

                });
            });


        </script>

        <style type="text/css">
@media print {
    #printbtn {
        visbility :  hidden;
    }
}
</style>
        
</head>

<body>
       
<div id="page-wrap">

    <div class="">
        
    </div>
    

<table width="100%">
    
    
    <tr>
      <td width="10%" align="right">
        <img src="<?php echo base_url(); ?>application/assets/images/Print.png" alt="Print" title="Print" style="cursor: pointer;cursor: hand;" id="printbtn"/>
    </td>
  </tr>
  <tr>
   
    <td width="100%" align="center">
        <table>
            <tr>
               
                <tr><td align="center"><span style="font-family:Verdana, Geneva, sans-serif;font-size:16px"><?php echo($headerview['Company']); ?></span></td></tr>
                <tr><td><span style="font-family:Verdana, Geneva, sans-serif;font-size:16px"><?php echo($headerview['CompanyLoc']); ?></span></td></tr>
                <tr><td align="center"><span style="font-family:Verdana, Geneva, sans-serif;font-size:18px">BLEND SHEET</span></td></tr>
        </table>
    </td>
    
    
  </tr>
  
  
  
  
</table>
    
    
    
   <table width="100%" border="0">
      
        <tr>
        <td width="30%"><span style="font-family:Verdana, Geneva, sans-serif;font-size:16px">Product:&nbsp;</span><?php echo($headerview['product']);?></td> 
            <td width="70%" align="right">
                <table width="50%" align="right">
                    <tr>
                        <td align="left" width="50%"><span style="font-family:Verdana, Geneva, sans-serif;font-size:16px">Refrence No.</span></td>
                        <td align="center">:</td>
                        <td align="left"><?php echo($headerview['blendRef']);?></td>
                    </tr>
                    <tr>
                        <td align="left" width="50%"><span style="font-family:Verdana, Geneva, sans-serif;font-size:16px">Blending Date</span></td>
                        <td align="center">:</td>
                        <td align="left"><?php echo($headerview['blendDate']);?></td>
                    </tr>
                </table>
                
            </td> 
        </tr>
    </table>

            
            
            
            
            
            
            
            
    <div style="padding:8px 0px 8px 0px; font-family: arial;">
        Dear Sir,
        Please Blend the undernoted Teas on our A/C and lift them after blending ,into the old bags ready for packing.Packing instruction shall follow soon.
    </div>
            <div class="CSSTableGenerator">
            <table width="100%" >
                <tr>
                    <td width="4%">SL</td>
                    <td>Location</td>
                    <td>Lot</td>
                    <td>Garden</td>
                    <td>Invoice</td>
                    <td>Grade</td>
                    <td>Group</td>
                    <td>Packing Bag</td>
                    <td>Net in Kg(s)</td>
                    <td>Quantity in Kg(s)</td>
                   

                </tr>


                <?php
               
		if($dtlview){
                    $totalBag=0;
                    $totalQty=0;
                    $j=1;
                foreach ($dtlview as $key => $value) { ;
                    $noofbag = $value['PackingBag'];
                    if($noofbag==0){echo "";}else{
                           
                        ?>

                        <tr>
                            <!--<td><?php echo $value['SL']; ?></td>-->
                           <td width="4%"><?php echo $j++; ?></td>
                            <td><?php echo $value['Location']; ?></td>
                            <td><?php echo $value['Lot']; ?></td>
                            <td><?php echo $value['Garden']; ?></td>
                            <td><?php echo $value['Invoice']; ?></td>
                            <td><?php echo $value['Grade']; ?></td>
                            <td><?php echo $value['Group']; ?></td>
                            <td align="right"><?php echo $value['PackingBag']; ?></td>
                            <td align="right"><?php echo $value['QtyKgs']; ?></td>
                            <td align="right"><?php echo $value['BlendQty']; ?></td>
                         </tr>
               
                        <?php
                        $totalBag= $totalBag + $value['PackingBag'];
                        $totalQty = $totalQty + $value['BlendQty'];
                        }
                }
                    }
                    ?>

                         <tr>
                            <td><span style="font-family:Verdana, Geneva, sans-serif;font-size:18px; ">Total:</span></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="right"><span style="font-family:Verdana, Geneva, sans-serif;font-size:18px ;border:solid 1px; "><?php echo $totalBag; ?></span></td>
                            <td align="right">&nbsp;</td>
                            <td align="right"><span style="font-family:Verdana, Geneva, sans-serif;font-size:18px; border:solid 1px;"><?php echo (number_format($totalQty,2));?></span></td>
                         </tr>
                         
                         <tr>
                             <td colspan="10" align="center">
                                <!-- <b>Average cost of blending (Rs.) : <?php echo $headerview['avgblendCost'];?></b>-->
                             </td>
                          
                         </tr>


            </table>
                </div>
        </div>
    <table width="100%"style="padding-top: 10px;">
       <!-- <tr>
            <td>Yours Faithfully</td>
            <td align="right">For TAX INVOICE CUM CHALLAN</td>
        </tr>-->
         <tr>
            <td></td>
            <td align="right">&nbsp;</td>
        </tr>
        <tr>
            <td></td>
            <td align="right">Authorised Signatory</td>
        </tr>
    </table>
    </body>

</html>