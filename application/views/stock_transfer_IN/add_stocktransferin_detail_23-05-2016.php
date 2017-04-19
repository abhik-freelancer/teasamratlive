<script src="<?php echo base_url(); ?>application/assets/js/addStocktransferDtl.js"></script> 
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


<h2><font color="#5cb85c">Add Purchase Details</font></h2>
<div id="purchaseMaster" align="center">
    <input type="hidden" name="txtPmasterId" id="PmasterId" value="<?php echo($header['pmstId']); ?>"/>
</div>
<div id='detailDiv'>
        <table class="gridtable" width="100%">
                    <tr>
                        <td>Lot</td>
                        <td><input type="text" id="txtLot" name="txtLot" value=""/></td>
                        <td>DO</td>
                        <td><input type="text" id="txtDo" name="txtDo" value=""/></td>
                        <td>Do Date</td>
                        <td><input type="text" id="txtDoDate" name="txtDoDate" class="datepicker" value=""/></td>
                    </tr>
                    
                    <tr>
                        <td>Invoice</td>
                        <td><input type="text" id="txtInvoice" name="txtInvoice" value=""/></td>
                        <td>Gross</td>
                        <td><input type="text" id="txtGross" name="txtGross" value=""/></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    
                 
                     <tr>
                        <td>Price</td>
                        <td>
                            <input type="text" id="txtPrice" name="txtPrice" class="price" value=""/>
                        </td>
                        <td>Group</td>
                        <td>
                           
                            <select id="drpGroup" name="drpgroup">
                                <option value="0">Select</option>    
                                <?php foreach ($header['teagroup'] as $teaGrp){ ?>
                                <option value="<?php echo($teaGrp->id);?>"><?php echo($teaGrp->group_code);?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td>Location</td>
                        <td>
                            <select id="drpLocation" name="drpLocation">
                                <option value="0">Select</option>    
                                <?php foreach ($header['location'] as $location){ ?>
                                <option value="<?php echo($location->lid);?>"><?php echo($location->location);?></option>
                                <?php }?>
                            </select>
                        </td>
                    
                    </tr>
                    <tr>
                        <td>Garden</td>
                        <td>
                            <select id="drpGarden" name="drpGarden">
                                <option value="0">Select</option>    
                                <?php foreach ($header['garden'] as $garden){ ?>
                                <option value="<?php echo($garden->id);?>"><?php echo($garden->garden_name);?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td>Grade</td>
                        <td>
                            <select id="drpGrade" name="drpGrade">
                                <option value="0">Select</option>    
                                <?php foreach ($header['grade'] as $grade){ ?>
                                <option value="<?php echo($grade->id);?>"><?php echo($grade->grade);?></option>
                                <?php }?>
                            </select>
                        </td>
                        
                        <td>Warehouse</td>
                        <td>
                            <select id="drpWarehouse" name="drpWarehouse">
                                <option value="0">Select</option>    
                                <?php foreach ($header['warehouse'] as $warehouse){ ?>
                                <option value="<?php echo($warehouse->id);?>"><?php echo($warehouse->name);?></option>
                                <?php }?>
                            </select>
                        </td>
                    </tr>
                    
                    
                </table >
                <table class="gridtable" width="100%" id="tableNormal">
                    <tr>
                        <td colspan="4" align="center"><strong>Normal</strong></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" id="txtNormalBagid" name="txtNormalBagid" class="normalBagId" value="0"/>
                            <input type="hidden" id="txtNormalBagTypeId" name="txtNormalBagTypeId" value="1"/>
                        </td>
                       
                        <td><input type="text" id="txtNumOfNormalBag" name="txtNumOfNormalBag" class="txtNumOfNormalBag" value="<?php echo($dataContent['normalBag']['no_of_bags']);?>"/>[Bags]</td>
                        <td><input type="text" id="txtNumOfNormalNet" name="txtNumOfNormalNet" class="txtNumOfNormalNet" value="<?php echo($dataContent['normalBag']['net']);?>"/>[Kgs/bag]</td>
                        <td><input type="text" id="txtNumOfNormalChess" name="txtNumOfNormalChess" value=""/></td>
                    </tr>
                </table>
                <table class="gridtable" width="100%" id="sampleBag">
                    <tr>
                        <td colspan="4" align="center">
                            <strong>Sample</strong>
                            <img src="<?php echo base_url(); ?>application/assets/images/add_sample.jpg" id="addSamplebag" class="samplebag" style="cursor: pointer; cursor: hand;"/>
                        </td>
                    </tr>
                </table>
                <table class="gridtable" width="100%">
                        <tr>
                            <td>Total Weight</td>
                            <td><input type="text" readonly="" id="DtltotalWeight" name="DtltotalWeight" value=""/></td>
                            <td>Total Value</td>
                            <td><input type="text" readonly="" id="DtltotalValue" name="DtltotalValue" value=""/></td>
                        </tr>
                       
                </table>
                
                <div style="padding-top: 0.25cm;">
                <table width="100%">
                    <tr>
                        <td align="right" > 
                            <span class="buttondiv">
                                <div class="save" id="updtMaster" align="center" onclick="purchaseDetailsAdd();">Update</div>
                            </span>
                            
                       </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                         <td>
                             &nbsp;
                            
                        </td>
                    </tr>
                </table>
                </div>    
</div>
<!-- modal dialog--div-->
<div id="dialog-Edit" title="Purchase Detail" style="display:none;">
  <p>Data update Successfully..</p>
</div>
<!-- modal dialog--div-->




