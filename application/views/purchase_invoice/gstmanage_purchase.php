<script src="<?php echo base_url(); ?>application/assets/js/gstpurchaseManageJs.js"></script> 
<!-- CSS goes in the document HEAD or added to your external stylesheet -->
<style type="text/css">
table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#003399;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #CCFFCC;
}
</style>
<!-- Table goes in the document BODY -->


<h2><font color="#5cb85c">Manage Purchase Invoice</font></h2>
<div id="purchaseMaster" align="center">
<table class="masterTable">
  <tr>
    <td colspan="4">&nbsp;
    <!-- Mode of operation and PurchaseMaster Id-->
    <input type="hidden" name="txtModeOfOperation" id="modeofoperation" value="<?php echo($header['mode']);?>"/>
    <input type="hidden" name="txtpmasterId" id="pMasterId" value="<?php echo($bodycontent['purchaseMaster']["id"]);?>"/>
    <input type="hidden" name="voucherMasterId" id="voucherMasterId" value="<?php echo($bodycontent['purchaseMaster']["voucher_master_id"]);?>"/>
    
    </td>
  </tr>
  <tr>
    <td>Purchase</td>
    <td>
                    <select id="purchasetype" name="purchasetype">
                        <option value="AS" <?php if($bodycontent['purchaseMaster']['from_where']=='AS'){echo("selected");}else{echo("");}?>>Auction</option>
                        <option value="PS" <?php if($bodycontent['purchaseMaster']['from_where']=='PS'){echo("selected");}else{echo("");}?>>Auction private</option>
                        <option value="SB" <?php if($bodycontent['purchaseMaster']['from_where']=='SB'){echo("selected");}else{echo("");}?>>Private purchase</option>
                    </select>
    </td>
    <td>Area</td>
    <td>
    		<select id="auctionArea" name="auctionArea">
                          <option value="0">Select</option>
                          <?php foreach($header['auctionarea'] as $content){?>
                          <option value="<?php echo($content->aucAreaid); ?>"
                                   <?php if($bodycontent['purchaseMaster']['auctionareaid']==$content->aucAreaid){echo('selected');}?>> 
                              <?php echo($content->auctionarea); ?> </option>             
                          <?php }?>
                </select>
         <input type="hidden" name="transCostPrice" id="transCostPrice" value="<?php //echo $bodycontent['transCost']['trans_cost'] ?>" />
     </td>
  </tr>
  <tr>
    <td>Invoice</td>
    <td><input type="text" name="taxinvoice" id="taxinvoice" value="<?php echo($bodycontent['purchaseMaster']['purchase_invoice_number']); ?>"/></td>
    <td>Invoice Date</td>
    <td><input type="text" class="datepicker" id="taxinvoicedate" name="taxinvoicedate" 
               value="<?php echo($bodycontent['purchaseMaster']['invoicedate']); ?>"/></td>
  </tr>
  <tr>
    <td>Sale No.</td>
    <td><input type="text" name="salenumber" id="salenumber" value="<?php echo($bodycontent['purchaseMaster']['sale_number']);?>"/></td>
    <td>Sale Date</td>
    <td><input type="text" class="datepicker" id="saledate" name="saledate" 
               value="<?php echo($bodycontent['purchaseMaster']['saledate']);?>"/></td>
  </tr>
  <tr>
    <td>Prompt Date</td>
    <td><input type="text" class="datepicker" id="promtdate" name="promtdate" 
               value="<?php echo($bodycontent['purchaseMaster']['promptDate']);?>"/></td>
    <td>Vendor</td>
    <td> 
    		    <select name="vendor" id="vendor" >
                        <option value="0">select</option>
                        <?php foreach ($header['vendor'] as $content) : ?>
                            <option value="<?php echo $content->vid; ?>"
                                <?php if($content->vid==$bodycontent['purchaseMaster']['vendor_id']){echo("selected='selected'");}else{echo('');}?>>
                                    <?php echo $content->vendor_name; ?></option>
                        <?php endforeach; ?>

                    </select>
    </td>
  </tr>
   <tr>
    <td>CN No.</td>
    <td><input type="text"  id="cnNo" name="cnNo" value="<?php echo($bodycontent['purchaseMaster']['cn_no']);?>"/></td>
    <td><span id="transp_label">Transporter Name</span></td>
    <td> 
    		    <select name="transporterid" id="transporterid" style="width:200px;;">
                        <option value="0">Select</option>
                        <?php foreach ($header['transporterlist'] as $rows) : ?>
                            <option value="<?php echo $rows->id; ?>" 
        <?php if($rows->id==$bodycontent['purchaseMaster']['transporter_id']){echo("selected='selected'");}else{echo('');}?>>
                               <?php echo $rows->name; ?></option>
                        <?php endforeach; ?>

                    </select>
    </td>
  </tr>
  <tr id="challan_block">
      <td>Challan No.</td>
      <td><input type="text" name="challanNo" id="challanNo" value="<?php echo($bodycontent['purchaseMaster']['challan_no']);?>"/></td>
      <td>Challan Date </td>
      <td><input type="text" name="challanDate" id="challanDate" class="datepicker" 
                 value="<?php echo($bodycontent['purchaseMaster']['challanDate']);?>" style="width:200px;"></td>
  </tr>
  <tr>
       <td>
           HSN .
       </td>
       <td>
           <input type="text" name="txtHSN" id="txtHSN"  
                  style="width:200px;" 
                  placeholder="Harmonized System Nomenclature"
                  value="<?php echo($bodycontent['purchaseMaster']['GST_HSN']);?>"
                  >
           
       </td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
   </tr>
  <tr>
  <td colspan="4">
      <span class="buttondiv">
          <div class="save" id="updtMaster" align="center" onclick="updateMasterArea();">Update</div>
      </span>
  </td>
  </tr>
  <tr>
  <td colspan="4">
      <!--<span class="buttondiv">
          <div class="save" id="addnewDtl" align="center">Add Details</div>
      </span>-->
  </td>
  </tr>
</table>

</div>

<?php 
	/*echo "<pre>";
	print_r($bodycontent['purchaseDetails']);
	echo "<pre>";*/
?>
<div id="detailDiv" class="accordion">
    <?php 
   
    if($bodycontent['purchaseDetails']){
       
        foreach ($bodycontent['purchaseDetails'] as $dataContent){
        ?>
   <!-- <h6><?php echo("Product Invoice: ".$dataContent['invoice_number']); ?>&nbsp;/&nbsp;<?php echo("Garden: ".$dataContent['garden']); ?></h6> -->
    <h6><?php echo("Product Invoice: ".$dataContent['invoice_number']); ?>/<?php echo("Garden: ".$dataContent['garden']); ?></h6> 
     <div id='purchaseDtl_<?php echo ($dataContent['id']); ?>'>
       
        <table class="gridtable" width="100%">
                    <tr>
                        <td>Lot</td>
                        <td><input type="text" id="txtLot_<?php echo ($dataContent['id']); ?>" name="txtLot[]" value="<?php echo($dataContent['lot']); ?>"/></td>
                        <td>DO</td>
                        <td><input type="text" id="txtDo_<?php echo ($dataContent['id']); ?>" name="txtDo[]" value="<?php echo($dataContent['do']); ?>"/></td>
                        <td>Do Date</td>
                        <td><input type="text" id="txtDoDate_<?php echo ($dataContent['id']); ?>" name="txtDoDate[]" class="datepicker" value="<?php echo($dataContent['doRealisationDate']); ?>"/></td>
                    </tr>
                    
                    <tr>
                        <td>Invoice</td>
                        <td><input type="text" id="txtInvoice_<?php echo ($dataContent['id']); ?>" name="txtInvoice[]" value="<?php echo($dataContent['invoice_number']); ?>"/></td>
                        <td></td>
                        <td></td>
                        <td>Gross</td>
                        <td><input type="text" id="txtGross_<?php echo ($dataContent['id']); ?>" name="txtGross[]" value="<?php echo($dataContent['gross']); ?>"/></td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td></td>
                        <td>GP No.</td>
                        <td><input type="text" id="txtGpnumber_<?php echo ($dataContent['id']); ?>" name="txtGpnumber[]" value="<?php echo($dataContent['gp_number']); ?>"/></td>
                        <td>Gp Date</td>
                        <td><input type="text" id="txtGpDate_<?php echo ($dataContent['id']); ?>" name="txtGpDate[]" class="datepicker" value="<?php echo($dataContent['gpDate']); ?>"/></td>
                    </tr>
                     <tr>
                        <td>Price</td>
                        <td>
                            <input type="text" id="txtPrice_<?php echo ($dataContent['id']); ?>" name="txtPrice[]" class="price" value="<?php echo($dataContent['price']); ?>"/>
                         
                        </td>
                        <td>Group</td>
                        <td>
                           
                            <select id="drpGroup_<?php echo ($dataContent['id']); ?>" name="drpgroup[]">
                                <option value="0">Select</option>    
                                <?php foreach ($header['teagroup'] as $teaGrp){ ?>
                                <option value="<?php echo($teaGrp->id);?>" <?php if($teaGrp->id==$dataContent['teagroup_master_id']){echo("selected='selected'");}else{echo('');} ?>><?php echo($teaGrp->group_code);?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td>Location</td>
                        <td>
                            <select id="drpLocation_<?php echo ($dataContent['id']); ?>"  <?php if($bodycontent['purchaseMaster']->from_where!='SB'){echo('disabled');}else{echo('');}?>  name="drplocation[]">
                                <option value="0">Select</option>    
                                <?php foreach ($header['location'] as $location){ ?>
                                <option value="<?php echo($location->lid);?>"<?php if($location->lid==$dataContent['location_id']){echo("selected='selected'");}else{echo('');} ?>><?php echo($location->location);?></option>
                                <?php }?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Garden</td>
                        <td>
                            <select id="drpGarden_<?php echo ($dataContent['id']); ?>" name="drpGarden[]">
                                <option value="0">Select</option>    
                                <?php foreach ($header['garden'] as $garden){ ?>
                                <option value="<?php echo($garden->id);?>" <?php if($garden->id==$dataContent['garden_id']){echo("selected='selected'");}else{} ?>><?php echo($garden->garden_name);?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td>Grade</td>
                        <td>
                            <select id="drpGrade_<?php echo ($dataContent['id']); ?>" name="drpGrade[]">
                                <option value="0">Select</option>    
                                <?php foreach ($header['grade'] as $grade){ ?>
                                <option value="<?php echo($grade->id);?>" <?php if($grade->id==$dataContent['grade_id']){echo("selected");}else{echo('');} ?>>
                                    <?php echo($grade->grade);?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td>Warehouse</td>
                        <td>
                            <select id="drpWarehouse_<?php echo ($dataContent['id']); ?>" name="drpWarehouse[]">
                                <option value="0">Select</option>    
                                <?php foreach ($header['warehouse'] as $warehouse){ ?>
                                <option value="<?php echo($warehouse->id);?>" <?php if($warehouse->id==$dataContent['warehouse_id']){echo("selected='selected'");}else{echo('');} ?>><?php echo($warehouse->name);?></option>
                                <?php }?>
                            </select>
                        </td>
                    </tr>
                    
                    
                </table >
                <table class="gridtable" width="100%" id="tableNormal_<?php echo($dataContent['id']);?>">
                    <tr>
                        <td colspan="4" align="center"><strong>Normal</strong></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" id="txtNormalBagid_<?php echo($dataContent['id']);?>" name="txtNormalBagid" class="normalBagId" value="<?php echo($dataContent['normalBag']['BagDetailId']);?>"/>
                            <input type="hidden" id="txtNormalBagTypeId_<?php echo($dataContent['id']);?>" name="txtNormalBagTypeId" value="1"/>
                        </td>
                       
                        <td><input type="text" id="txtNumOfNormalBag_<?php echo($dataContent['id']);?>" name="txtNumOfNormalBag[]" class="txtNumOfNormalBag" value="<?php echo($dataContent['normalBag']['no_of_bags']);?>" onkeypress="checkNumeric(this);"/>[Bags]</td>
                        <td><input type="text" id="txtNumOfNormalNet_<?php echo($dataContent['id']);?>" name="txtNumOfNormalNet[]" class="txtNumOfNormalNet" value="<?php echo($dataContent['normalBag']['net']);?>"/>[Kgs/bag]</td>
                        <td><input type="text" id="txtNumOfNormalChess_<?php echo($dataContent['id']);?>" name="txtNumOfNormalChess[]" value="<?php echo($dataContent['normalBag']['chestSerial']);?>"/></td>
                    </tr>
                </table>
                <table class="gridtable" width="100%" id="sampleBag_<?php echo($dataContent['id']);?>">
                    <tr>
                        <td colspan="4" align="center">
                            <strong>Sample</strong>
                            <img src="<?php echo base_url(); ?>application/assets/images/add_sample.jpg" id="<?php echo($dataContent['id']);?>" class="samplebag"/>
                        </td>
                    </tr>
                    <?php foreach($dataContent['sampleBag'] as $sampleBagRows){ ?>
                        <tr>
                            <td>
                            <input type="hidden" id="txtSampleBagid_<?php echo($dataContent['id']."_".$sampleBagRows['BagDetailId']);?>" name="txtSampleBagid" class="sampleBagId" value="<?php echo($sampleBagRows['BagDetailId']);?>"/>
                            <input type="hidden" id="txtSampleBagTypeId_<?php echo($dataContent['id']."_".$sampleBagRows['BagDetailId']);?>" name="txtSampleBagTypeId" value="2"/>
                            </td>
                        <td><input type="text" id="txtNumOfSampleBag_<?php echo($dataContent['id']."_".$sampleBagRows['BagDetailId']);?>" name="txtNumOfSampleBag" class="txtNumOfSampleBag" value="<?php echo($sampleBagRows['no_of_bags']);?>" onkeypress="checkNumeric(this);"/>[Bags]</td>
                        <td><input type="text" id="txtNumOfSampleNet_<?php echo($dataContent['id']."_".$sampleBagRows['BagDetailId']);?>" name="txtNumOfSampleNet" class="txtNumOfSampleNet" value="<?php echo($sampleBagRows['net']);?>"/>[Kgs/bag.]</td>
                        <td><input type="text" id="txtNumOfSampleChess_<?php echo($dataContent['id']."_".$sampleBagRows['BagDetailId']);?>" name="txtNumOfSampleChess" class="txtNumOfSampleChess" value="<?php echo($sampleBagRows['chestSerial']);?>"/></td>
                        </tr>
                    <?php }?>
                </table>
                <table class="gridtable" width="100%">
                    <tr>
                        <td>
                            Tea value
                            <input type="text" readonly="" id="DtltotalValue_<?php echo($dataContent['id']); ?>" 
                                   name="DtltotalValue[]" value="<?php echo($dataContent['gst_teavalue']); ?>" placeholder="Total tea value "/> 
                        </td>
                        <td>
                            Discount
                            <input type="text" class="DtlDiscount" id="DtlDiscountValue_<?php echo($dataContent['id']); ?>" 
                                   name="DtlDiscountValue[]" value="<?php echo($dataContent['gst_discount']); ?>" placeholder="Discount"/> 
                        </td>
                        <td colspan="2">
                            Taxable
                            <input type="text" readonly="" class="txtTaxableAmt" id="DtlTaxableValue_<?php echo($dataContent['id']); ?>" 
                                   name="DtlTaxableValue[]" value="<?php echo($dataContent['gst_taxable']); ?>" placeholder="Taxable"/> 
                        </td>
                    </tr>
                    <!-- GST--->
                    <tr>
                         <td>
                            <!--cgstrate-->
                            <select name="cgst[]" id="cgst_0_<?php echo($dataContent['id']); ?>" style="width:100px;" class="cgst"> 
                                <option value="0">CGST</option>
                                <?php foreach ($header['cgstrate'] as $rows) { ?>
                                    <option value="<?php echo($rows['id']); ?>" <?php if($dataContent['cgst_id']==$rows['id']){echo("selected");} ?>>
                                        <?php echo($rows['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="text" id="cgstAmt_0_<?php echo($dataContent['id']); ?>" 
                                   name="cgstAmt[]" style="width: 90px;" class="cgstAmt" value="<?php echo($dataContent['cgst_amt']); ?>">
                        </td>                   
                        <td>
                            <select name="sgst[]" id="sgst_0_<?php echo($dataContent['id']); ?>" style="width:100px;" class="sgst"> 
                                <option value="0">SGST</option>
                                <?php foreach ($header['sgstrate'] as $rows) { ?>
                                    <option value="<?php echo($rows['id']); ?>" <?php if($dataContent['sgst_id']==$rows['id']){echo("selected");} ?>>
                                        <?php echo($rows['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="text" id="sgstAmt_0_<?php echo($dataContent['id']); ?>" name="sgstAmt[]" style="width: 90px;" 
                                   value="<?php echo($dataContent['sgst_amt']); ?>"
                                   class="sgstAmt">
                            
                        </td>
                        
                        <td colspan="2">
                            <select name="igst[]" id="igst_0_<?php echo($dataContent['id']); ?>" style="width:100px;" class="igst"> 
                                <option value="0">IGST</option>
                                <?php foreach ($header['igstrate'] as $rows) { ?>
                                    <option value="<?php echo($rows['id']); ?>" <?php if($dataContent['igst_id']==$rows['id']){echo("selected");} ?>>
                                        <?php echo($rows['gstDescription']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="text" id="igstAmt_0_<?php echo($dataContent['id']); ?>" name="igstAmt[]"
                                   value="<?php echo($dataContent['igst_amt']); ?>"
                                   style="width: 90px;" class="igstAmt">
                            
                        </td>
                    </tr>
                        <tr>
                        <td>Net amount</td>
                        <td>
                          <input type="text" id="txtdtlnetamount_<?php echo($dataContent['id']);?>" 
                                 name="txtdtlnetamount[]" class="txtdtlnetamount" value="<?php echo($dataContent['gst_netamount']); ?>"/>
                        </td>
                        <td></td>
                        <td></td>
                        </tr>
                        <tr>
                            <td>Total Weight</td>
                            <td><input type="text" class="dtlTotalWght" readonly="" id="DtltotalWeight_<?php echo($dataContent['id']);?>" name="DtltotalWeight[]" value="<?php echo($dataContent['total_weight']); ?>"/></td>
                            <td></td>
                            <td>
                                
                            </td>
                        </tr>
                       <tr>
                            <td>Total Bags</td>
                            <td><input type="text" readonly="" id="DtltotalBags_<?php echo($dataContent['id']);?>" class="dtlTotalBags" name="DtltotalBags[]" value="<?php echo($dataContent['total_bag']); ?>"/></td>
                            <td>Tea Cost/Kg</td>
                            <td><input type="text" readonly="" id="DtlteaCost_<?php echo($dataContent['id']);?>" class="DtlteaCost_" name="DtlteaCost_[]" value="<?php  echo($dataContent['cost_of_tea']);?>"/></td>
                        </tr>
                </table>
                
                
                <table width="100%" >
                    <tr>
                        <td align="right" > 
							
							
							 
                            <?php if($dataContent['editable']=='Y'){ ?>
                            <input class="styled-button-10" value="update" onclick="updatePurDtl(<?php echo ($dataContent['id']); ?>);" type="button">
                            <?php } ?>
                            <input type="hidden" name="PurchaseMasterId" id="PurchaseMasterId_<?php echo ($dataContent['id']);?>" value="<?php echo ($dataContent['purchase_master_id']); ?>"/>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                             <?php if($dataContent['editable']=='Y'){ ?>
                                <input class="styled-button-10" value="Delete" onclick="" type="button">
                             <?php }?>
                        </td>
                    </tr>
                </table>
                
               
            </div>
            
        <?php }
    
        }?>
</div>
<!-- modal dialog--div-->
<div id="dialog-Edit" title="Purchase Detail" style="display:none;">
  <p>Data update Successfully..</p>
</div>
<!-- modal dialog--div-->


<div id="purchaseMasterFooter" align="center" style="padding-top: 0.2cm;">
    
    <table class="masterTable" width="50%" border="2" >
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Total Bags</td>
            <td>
                <input type="text" id="txtTotalBags" name="txtTotalBags" style="text-align: right;" 
                       value="<?php echo($bodycontent['purchaseMaster']['total_bags']); ?>" readonly=""/>
            </td>
        </tr>
        <tr>
            <td>Total Weight(in Kgs.)</td>
            <td>
                <input type="text" id="txtGrandWeight" name="txtGrandWeight" style="text-align: right;" 
                       value="<?php echo($bodycontent['purchaseMaster']['total_kgs']); ?>" readonly=""/></td>
        </tr>

        <tr>
            <td>Tea value</td>
            <td><input type="text" style="text-align: right;" id="txtTeaValue" 
                       name="txtTeaValue" value="<?php echo($bodycontent['purchaseMaster']['tea_value']); ?>"
                       readonly=""/></td>
        </tr>
        <!--gst-->
        <tr>
            <td>Total CGST</td>
            <td>
                <input type="text" id="txtCGSTTotal" name="txtCGSTTotal" style="text-align: right;" 
                       value="<?php echo($bodycontent['purchaseMaster']['GST_totalcgst']); ?>" readonly=""/>
            </td>
        </tr>
        
        <tr>
            <td>Total SGST</td>
            <td><input type="text" id="txtSGSTTotal" name="txtSGSTTotal" style="text-align: right;" 
                       value="<?php echo($bodycontent['purchaseMaster']['GST_totalsgst']); ?>" readonly=""/></td>
        </tr>
         <tr>
            <td>Total IGST</td>
            <td><input type="text" id="txtIGSTTotal" name="txtIGSTTotal" style="text-align: right;" 
                       value="<?php echo($bodycontent['purchaseMaster']['GST_totaligst']); ?>" readonly=""/></td>
        </tr>
        <!--gst-->
        <tr>
            <td>Total(GST Incl.)</td>
            <td> <input type="text" name="txtGSTIncludedAmount" id="txtGSTIncludedAmount" 
                        value="<?php echo($bodycontent['purchaseMaster']['GST_gstincldamt']); ?>" style="text-align: right;" readonly=""/></td>
        </tr>
        
        
        
        <tr>
            <td>Round Off</td>
            <td> 
                <input type="hidden" name="hdRoundOff" id="hdRoundOff" value="<?php echo($bodycontent['purchaseMaster']["round_off"]);?>"/>
                <input type="text" name="txtRoundOff" id="txtRoundOff" value="<?php echo($bodycontent['purchaseMaster']["round_off"]); ?>" style="text-align: right;" />
            </td>
        </tr>
        <!--Other Charges and Round off 30/09/2015-->
        
        
        <tr>
            <td>Total</td>
            <td> <input type="text" id="txtTotalPurchase" name="txtTotalPurchase" style="text-align: right;" 
                        value="<?php echo($bodycontent['purchaseMaster']['total']); ?>" readonly=""/> </td>
        </tr>
        <tr>
            <td align="right">
               
                
               
            </td>
            <td>
                <input class="styled-button-10" value="update" onclick="updateOtherChargesRoundoff(<?php echo($bodycontent['purchaseMaster']['id']);?>);" type="button">
            </td>
            
        </tr>
    </table>
     <div id="othercharges-dialog" style="display: none;"title="Purchase Invoice">
            <p>Other charges and Round off update successfully.</p>
        </div>
        
</div>

