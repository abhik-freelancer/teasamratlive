<script src="<?php echo base_url(); ?>application/assets/js/unreleaseddo.js"></script> 

<h1><font color="#5cb85c">DO Receipt</font></h1>
<!--
 <div class="stats">
 
    <p class="stat"><a href="<?php echo base_url(); ?>purchaseinvoice" class="showtooltip" title="add"><img src="<?php echo base_url(); ?>application/assets/images/add.jpg" hieght="38" width="38" /></a></p>
     <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" hieght="40" width="40" id="edit" style="visibility: hidden;"/></a></p>
      <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/delete.png" hieght="30" width="30" id="del" style="visibility: hidden;"/></a></p>
     <p class="stat"><a href="#"><img src="<?php echo base_url(); ?>application/assets/images/home.jpg" hieght="30" width="30"/></a></p>
    
        </div>
-->
<div id="adddiv">

    <section id="loginBox" style="width:600px;">
        <form id="frmunrealeased" name="frmunrealeased" method="post" action="<?php echo base_url(); ?>unreleaseddo"  >
        <!--<table>
            <tr>
                <td>Purchase Invoice :&nbsp;</td>
                <td>
                    <select id="drppurchase" name="drppurchase">
                        <option id="0">Select</option>
            <?php if ($bodycontent['purchase']) {

                foreach ($bodycontent['purchase'] as $rows) {
                    ?>
                                <option value="<?php echo $rows->id; ?>" <?php if ($rows->id == $bodycontent['purchaseId']) {
                echo("selected=selected");
            } ?>><?php echo($rows->purchase_invoice_number); ?></option>
                                
                    <?php
                }
            }
            ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Pending :&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>-->
            <table>
                <tr>
                    <td>
                        Only Pending :&nbsp;
                    </td>
                    <td>
                        <input type="checkbox" id="chkpendingdo" name="chkpendingdo" value="Y" <?php if ($bodycontent['isPending'] == 'Y') {
                echo("checked='checked'");
            } ?>/>
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
    <table id="example" class="display" cellspacing="0" width="100%">

        <thead bgcolor="#a6a6a6">
        <th>Sl.</th>
        <th>Do.Number<br/>Do.Date</th>
        <th>Purchase</th>
        <th>Date</th>
        <th>Sale No.</th>
        <th>Invoice No.</th>
        <th>Grade</th>
        <th>Package</th>
        <th>Qty.</th>
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
                            <input type="hidden" id="purDtlId" name="purDtlId" value="<?php echo($content->pDtlId); ?>"/>
                            <input type="hidden" id="pMstId" name="pMstId" value="<?php echo($content->pMstId); ?>"/>

                            <?php echo($sl); ?>
                        </td>
                        <td>
                            <?php if($content->sentStatus!='Y'){ ?>
                            <input type="text" id='txt_do<?php echo($sl); ?>' name='txt_do<?php echo($sl); ?>' value="<?php echo($content->do); ?>" size="8"/>
                            <br/> <br/>
                            <input type="text"  size="8" class='datepicker' id='do_reli_date<?php echo($sl); ?>' name="do_reli_date" value="<?php echo($content->doRealisationDate); ?>"/>
                            <?php }else{?>
                            <?php echo($content->do); ?> <br/> <br/>
                            <?php echo($content->doRealisationDate); ?>
                             <?php }?>
                        </td>


                        <td>
                            <?php echo($content->purchase_invoice_number); ?>
                        </td>
                        <td>
                            <?php echo($content->PurchaseInvoiceDate); ?>
                        </td>

                        <td>
        <?php echo($content->sale_number); ?>
                        </td>
                        <td>
        <?php echo($content->invoice_number); ?>
                        </td>
                        <td>
        <?php echo($content->grade); ?>
                        </td>
                        <td>
                    <?php echo($content->package); ?>
                        </td>
                        <td>
                    <?php echo($content->total_weight); ?>
                        </td>
                        <td>
                            <?php if($content->sentStatus!='Y'){ ?>
                            <input type="button" class="styled-button-10" value="update" onclick="updateDoReleased(<?php echo($content->pDtlId); ?>,<?php echo($sl); ?>);"/>
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