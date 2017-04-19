<script src="<?php echo base_url(); ?>application/assets/js/unreleaseddo.js"></script> 
<h1><font color="#5cb85c">DO Receipt</font></h1>

<div id="adddiv">

    <section id="loginBox" style="width:600px;">
        <form id="frmunrealeased" name="frmunrealeased" method="post"  >
            <table>
                <tr>
                    <td>
                        Only Pending :&nbsp;
                    </td>
                   <td>
                      
                       
                     <?php 
                        if($bodycontent['status']=='Y'){ ?>
                            
                       <input type="checkbox" id="chkpendingdo" name="chkpendingdo" <?php if ($bodycontent['status'] == 'Y') {echo("checked='checked'");} ?>/>
                       
                    <?php  } ?>  
                       
                     <?php 
                         if($bodycontent['status']==''){ ?>
                   
                       <input type="checkbox" id="chkpendingdo" name="chkpendingdo" <?php if ($bodycontent['status'] == '') {echo("");} ?> />
                         <?php } ?>
                 
                  <!--<input type="checkbox" id="chkpendingdo" name="chkpendingdo" value="Y" <?php if ($bodycontent['isPending'] == 'Y') {echo("checked='checked'");} ?>/>-->
                  
                  
                  
                 
                       
                    </td>
                </tr>
            </table>
        </form>

        <span class="buttondiv"><div class="save" id="showdo" align="center"> Show </div></span>
    </section>

</div>

<div id="popupdiv"  style="<?php if ($bodycontent['doList']) {
                echo("display:block;");
            } else {
                echo("display:none;");
            } ?>" title="Detail">
    
    <div id="loaderDiv" name="loaderDiv" style="display:none;padding-left: 300px;">
        <img src="<?php echo base_url(); ?>application/assets/images/update_ajax.gif"/>
    </div>
    
    <table id="table" class="display" cellspacing="0" width="100%">

        <thead bgcolor="#a6a6a6">
        <th>Sl.</th>
        <th>Garden</th>
        <th>Do.Number<br/>Do.Date</th>
        <th>Purchase</th>
        <th>Date</th>
        <th>Sale No.</th>
        <th>Invoice No.</th>
        <th>Grade</th>
        <th>Bags</th>
        <th>Qty(Kgs.)</th>
        <th>Action</th>

        </thead>

        <tbody>

                    <?php
                    if ($bodycontent['doList']) {
                        $sl = 0;
                        foreach ($bodycontent['doList'] as $content) {
                            $sl = $sl + 1;
                            ?>
                    <tr>
                        <td>   
                            <input type="hidden" id="purDtlId" name="purDtlId" value="<?php echo($content['pDtlId']); ?>"/>
                            <input type="hidden" id="pMstId" name="pMstId" value="<?php echo($content['pMstId']); ?>"/>

                            <?php echo($sl); ?>
                        </td>
                        <td>   
                            <?php echo($content['garden']); ?>
                        </td>

                        <td>
                            <?php if($content['sentStatus']!='Y'){ ?>
                            <input type="text" id='txt_do<?php echo($sl); ?>' name='txt_do<?php echo($sl); ?>' value="<?php echo($content['do']); ?>" size="8"/>
                            <br/> <br/>
                            <input type="text"  size="8" class='datepicker' id='do_reli_date<?php echo($sl); ?>' name="do_reli_date" value="<?php //echo($content['doRealisationDate']);
                            if($content['doRealisationDate']){echo $content['doRealisationDate'];}else{echo date('d-m-Y');}
                            ?>"/>
                            <?php }else{?>
                            <?php echo($content['do']); ?> <br/> <br/>
                            <?php echo($content['doRealisationDate']); ?>
                             <?php }?>
                        </td>


                        <td>
                        <?php echo($content['purchase_invoice_number']); ?>
                        </td>
                        <td>
                            <?php echo($content['PurchaseInvoiceDate']); ?>
                        </td>

                        <td>
                            <?php echo($content['sale_number']); ?>
                        </td>
                        <td>
                            <?php echo($content['invoice_number']); ?>
                        </td>
                        <td>
                            <?php echo($content['grade']); ?>
                        </td>
                        <td>
                          
                            <table>
                                <?php if($content['Bags']){ 
                                    $totalNewWeight = 0;
                                    
                                    foreach($content['Bags'] as $value){
                                        $totalNewWeight = $totalNewWeight + ($value->no_of_bags * $value->net);
                                    ?>
                                
                                    <tr>
                                        <td><?php echo($value->bagtype);?></td>
                                        <td><?php echo($value->no_of_bags);?></td>
                                        <td>X</td>
                                        <td><?php echo($value->net);?></td>
                                    </tr>
                                    <?php 
                                    
                                    }
                                    
                                    } 
                                    ?>
                            </table>
                        </td>
                        <td>
                            <?php echo($totalNewWeight); ?>
                        </td>
                        <td>
                            <?php if($content['sentStatus']!='Y'){ ?>
                            <input type="button" class="styled-button-10" value="update" onclick="updateDoReleased(<?php echo($content['pDtlId']); ?>,<?php echo($sl); ?>);"/>
                            <?php }else{?>
                            <img src="<?php echo base_url(); ?>application/assets/images/car_transport_truck.jpg" title="Already sent to transporter"/>
                            <?php }?>
                        </td>

                    </tr>
        <?php
    }
}
?>
        </tbody>                                              
    </table>

</div>