<script src="<?php echo base_url(); ?>application/assets/js/purchaseinvoice.js"></script>

<h2><font color="#5cb85c">Manage Purchase Invoice</font></h2>
<form role="form" method="post" name="addpurchaseinvoice" id="addpurchaseinvoice" action="<?php echo base_url(); ?>purchaseinvoice/update/invoice/<?php echo $bodycontent['invoiceid']; ?>" method="post">

    <section id="loginBox" style="width:800px;">
        <table cellspacing="4" cellpadding="0" class="tablespace" border='0'>
            <tr>
             <td>Purchase Type</td>
             <td>
                 <select id="purchasetype" name="purchasetype">
                     <option value="AS" <?php if (($bodycontent['saveddata'][0]->from_where) == 'AS'): ?>selected="selected" <?php endif; ?>>Auction</option>
                     <option value="PS" <?php if (($bodycontent['saveddata'][0]->from_where) == 'PS'): ?>selected="selected" <?php endif; ?>>Auction Purchase</option>
                     <option value="SB" <?php if (($bodycontent['saveddata'][0]->from_where) == 'SB'): ?>selected="selected" <?php endif; ?>>Private purchase</option>
                 </select>
             </td>
             <td>
              &nbsp;
             </td>
             <td>Area</td>
             <td>
             <select id="auctionArea" name="auctionArea">
                          <option value="0">Select</option>
                          <?php foreach($header['auctionarea'] as $content){?>
                          <option value="<?php echo($content->aucAreaid); ?>"<?php if($bodycontent['saveddata'][0]->auctionareaid==$content->aucAreaid){echo("selected=selected");}?>> <?php echo($content->auctionarea); ?> </option>             
                          <?php }?>
                    </select>
             
             </td>
         </tr>
            <tr>
                <td scope="row">Invoice Number</td>
                <td><input type="text" name="taxinvoice" id="taxinvoice" value="<?php echo $bodycontent['saveddata'][0]->purchase_invoice_number; ?>"/></td>
                <td/>
                <td scope="row">Sale Number</td>
                <td><input type="text" name="salenumber" id="salenumber" value="<?php echo $bodycontent['saveddata'][0]->sale_number; ?>"/></td>
            </tr>

            <tr>
                <td scope="row" >Invoice Date</td>
                <td><input type="text" class="datepicker" id="taxinvoicedate" name="taxinvoicedate" value="<?php echo date("d-m-Y", strtotime($bodycontent['saveddata'][0]->purchase_invoice_date)); ?>"/></td>
                <td/>
                <td scope="row" >Sale Date</td>
                <td><input type="text" class="datepicker" id="saledate" name="saledate" value="<?php echo date("d-m-Y", strtotime($bodycontent['saveddata'][0]->sale_date)); ?>"/></td>
            </tr>

            <tr>
                <td scope="row">Vendor</td>
                <td>
                    <select name="vendor" id="vendor" style="width: 190px">
                        <option value="0">select</option>
                        <?php foreach ($header['vendor'] as $content) : ?>
                            <option value="<?php echo $content->vid; ?>" <?php if (($bodycontent['saveddata'][0]->vendor_id) == $content->vid): ?>selected="selected" <?php endif; ?> ><?php echo $content->vendor_name; ?></option>
                        <?php endforeach; ?>

                    </select>
                </td>
                <td/>
                <td scope="row" >Promt Date</td>
                <td><input type="text" class="datepicker" id="promtdate" name="promtdate" value="<?php echo date("d-m-Y", strtotime($bodycontent['saveddata'][0]->promt_date)); ?>"/></td>
            </tr>
        </table>
        <br/>
        <span class="buttondiv"><!--<div class="save" id="gotodetail" align="center">Click to add new record</div>--></span>
    </section>

    <div id="detailpurchaseinvoice" style="display:none;" title="Fill up in detail" align="left">

        <table cellspacing="4" cellpadding="0" class="tablespace" width="100%" style="" id="popupwindow" border="0">
            <tr>
                <td>
                    <table class="tablespace" >
                        <tr>
                            <td scope="row">LOT</td>
                            <td><input type="text" id="lot" name="lot"  /></td>
                            <td/>
                        </tr>
                        <tr>
                            <td scope="row">DO</td>
                            <td><input type="text" id="do" name="do" /></td>
                        </tr>
                        <!--DO Date-->
                         <tr>
                                        <td scope="row">DO Date</td>
                                        <td><input type="text" class="datepicker" id="dodate" tabindex="3" name="dodate"/></td>
                         </tr>
                         <!--DO Date-->
                        <tr>
                            <td scope="row">Group :</td>
                            <td>
                                <div id="teagrouperr">
                                    <select name="teagroup" id="teagroup" style="width: 190px">
                                        <option value="0">select</option>
                                        <?php foreach ($header['teagroup'] as $content) : ?>
                                            <option value="<?php echo $content->id; ?>"><?php echo $content->group_code; ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                            </td>
                        </tr>
                        
                         <!-- Location for Private Purchase (SB)-->
                                       
                                       <tr>
                                        <td scope="row">Location :</td>
                                        <td>
                                        <div id="location">
                                          <select name="stockLocation" id="stockLocation" style="width: 190px" tabindex="4">
                                            <option value="0">Select</option>
                                            <?php foreach ($header['location'] as $content) : ?>
                                                    <option value="<?php echo $content->lid; ?>"><?php echo ($content->location."-".$content->warehousename); ?></option>
                                             <?php endforeach; ?>
                                            
                                          </select>
                                        </div>
                                        </td>
                                       </tr>
                         <!-- Location -->
                        
                        <tr>
                            <td scope="row">Invoice</td>
                            <td><input type="text" id="invoice" name="invoice"/></td>
                        </tr>
                        <tr>
                            <td scope="row">Garden</td>
                            <td><div id="gardenerr">
                                    <select name="garden" id="garden" style="width: 190px">
                                        <option value="0">select</option>
                                        <?php foreach ($header['garden'] as $content) : ?>
                                            <option value="<?php echo $content->id; ?>"><?php echo $content->garden_name; ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">Warehouse</td>
                            <td>
                                <div id="wareerr">
                                    <select name="warehouse" id="warehouse" style="width: 190px">
                                        <option value="0">select</option>
                                        <?php foreach ($header['warehouse'] as $content) : ?>
                                            <option value="<?php echo $content->id; ?>"><?php echo $content->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">Grade</td>
                            <td>
                                <div id="gradeerr">
                                    <select name="grade" id="grade" style="width: 190px">
                                        <option value="0">select</option>
                                        <?php foreach ($header['grade'] as $content) : ?>
                                            <option value="<?php echo $content->id; ?>"><?php echo $content->grade; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>


                    </table>
                </td>
                <td>
                    <table class="tablespace" >
                   		<tr>
                            <td scope="row" >Stamp</td>
                            <td><input type="text" id="stamp" name="stamp"/></td>
                        </tr>
                        <tr>
                            <td scope="row" >Gross</td>
                            <td><input type="text" id="gross" name="gross"/></td>
                        </tr>
                        <tr>
                            <td scope="row" >Brokerage</td>
                            <td><input type="text" id="brok" name="brok"/></td>
                        </tr>                                       
                        

                        <tr>
                            <td scope="row" >GP No</td>
                            <td><input type="text" id="gpno" name="gpno"/></td>
                        </tr>
                        <tr>
                            <td scope="row" >GP Date</td>
                            <td><input type="text" class="datepicker" id="date" name="date"/></td>
                        </tr>
                         <tr>
                            <td scope="row" >Price</td>
                            <td><input type="text" id="price" name="price"/></td>
                         </tr>


                    </table>
                </td>
            </tr>
            <tr>
               
                <td colspan="2">
                    <table class="tablespace"  width="100%">
                        <tr>
                            <td scope="row" valign="top">Bags &nbsp;
                                <a href="javascript:void(0)" >
                                    <img src="<?php echo base_url(); ?>application/assets/images/add_sample.jpg" height="18" width="18" id="addsample"/>
                                </a>
                                <input type="hidden" name="samplecount" id="samplecount" value=""/></td>
                            <td>
                            		<div id="addsamplehere" style="max-height: 150px; overflow-y: scroll;display: none;">

                                    </div>
                            
                            </td>
                        <tr/>
                       
                        <tr>
                        <tr>
                            <td><input type="radio" name="type" value="V" class="call" checked="checked">VAT</td>
                            <td><input type="radio" name="type" value="C"  class="call">CST</td>
                        </tr>
                        <tr>
                            <td scope="row" id="selectionlable">VAT Rate</td>

                            <td>
                                <span id="currentvatrate">
                                    <select id="optionrate" name="optionrate" class="optionrate" onchange="calculateCurrentVatratetotal();"><option value="0">Select</option>
                                        <?php foreach ($bodycontent['vatrate'] as $value): ?>
                                            <option value="<?php echo $value->id ?>"><?php echo $value->vat_rate ?></option>';

                                        <?php endforeach; ?>
                                    </select>
                                </span>
                                <span id="currentcstrate" style="display:none;">
                                    <select id="optionrate" name="optionrate" class="optionrate" onchange="calculateCurrentVatratetotal();"><option value="0">Select</option>
                                        <?php foreach ($bodycontent['cstrate'] as $value): ?>
                                            <option value="<?php echo $value->id ?>"><?php echo $value->cst_rate ?></option>';

                                        <?php endforeach; ?>
                                    </select>
                                </span>
                                <span> <input type="text" id="taxrate" name="taxrate" readonly="readonly"/></span>
                            </td>

                        <tr/>

                        <td scope="row" >Service Tax</td>
                        <td>
                            <select id="optionstax" name="optionstax" class="optionstax">
                                <option value="0">Select</option>
                                <?php foreach ($bodycontent['servicetax'] as $value): ?>
                                    <option value="<?php echo $value->id ?>"><?php echo $value->tax_rate ?></option>';

                                <?php endforeach; ?>
                            </select>
                            <input type="text" id="stax" name="stax" readonly="readonly"/></td>
                </td>
            <tr/>

        </table>
        </td>
        </tr>
        </table>


    </div>


    <input type="hidden" id="countdetail" name="countdetail" value="0" /> 
    <input type="hidden" id="voucherid" name="voucherid" value="<?php echo $bodycontent['saveddata'][0]->voucher_master_id ?>" /> 
   <!-- <input type="hidden" id="servicetaxrate" name="servicetaxrate" value="<?php echo $bodycontent['servicetax'] ?>" /> -->
   <!-- <input type="hidden" id="vatrate" name="vatrate" value="<?php echo $bodycontent['vatrate'] ?>" /> 
    --> 
 <div class="editPurcDtl">
    <table  width="100%"  id="example2"  frame="box">

        <tr>
        <td>LOT/DO/Date</td>
        <td>Invoice Number</td>
        <td>Garden/Warehouse/Group</td>
        <td>Grade</td>
        <td>GP No/Date</td>
        <td>Stamp</td>
        <td>Bag/Net/Type/Chest</td>
        <td>Gross/Brokerage</td>
        <td>Total Wt.<br/>Tax</td>
        <td>Price<br/>Service tax</td>
        <td>Value<br/>Total</td>
        <td></td>
        <tr>

        <tbody id="mybody">
            <?php
            foreach ($bodycontent['saveddata'] as $detaildata) {
                ?>
                <tr  id="detailtr<?php echo $detaildata->id; ?>" >

                    <td>
                        <span id="lot<?php echo $detaildata->id; ?>"><?php echo $detaildata->lot; ?></span>
                        <input type="hidden" name="detailtableid[]" id="detailtableid<?php echo $detaildata->id; ?>" value="<?php echo $detaildata->id; ?>" />
                        <input type="hidden" name="detaillot[]" value="<?php echo $detaildata->lot; ?>" />
                        <br/>
                        <span id="do<?php echo $detaildata->id; ?>"><?php echo $detaildata->do; ?></span>
                        <input type="hidden" name="detaildo[]" value="<?php echo $detaildata->do; ?>" />
                        <br/>
                        <span id="dodate<?php echo $detaildata->id; ?>">
                            <?php 
                            if($detaildata->doRealisationDate!=''||$detaildata->doRealisationDate!=NULL){
                            echo( date('d-m-Y',strtotime($detaildata->doRealisationDate))); 
                            }
                           ?>
                        </span>
                        <input type="hidden" id="detailDoRelDate" name="detaildodate[]" value="<?php echo($detaildata->doRealisationDate);?>"/>
                        <!-- Edit Allow or not -->
                        <input type="hidden" id="hdeditable<?php echo $detaildata->id; ?>" name="hdeditable<?php echo $detaildata->id; ?>"  value="<?php echo($detaildata->IS_EDIT);?>"/>
                        <!-- Edit Allow or not -->
                        
                    </td>
                    <td>
                        <span id="invoice<?php echo $detaildata->id; ?>"><?php echo $detaildata->invoice_number; ?></span>
                        <input type="hidden" name="detailinvoice[]" value="<?php echo $detaildata->invoice_number; ?>" />
                    </td>
                    <td>
                        <span id="garden<?php echo $detaildata->id; ?>"><?php echo $detaildata->garden_name; ?></span>
                        <input type="hidden" id="detailgardenid<?php echo $detaildata->id; ?>" name="detailgardenid[]" value="<?php echo $detaildata->garden_id; ?>"/>
                        <br/>
                        <!--for loaction SB-->
                        <?php if($detaildata->from_where!='SB'){?>
                        <span id="warehouse<?php echo $detaildata->id; ?>"><?php echo $detaildata->name; ?></span>
                        <input type="hidden"  id="detailwarehouseid<?php echo $detaildata->id; ?>" name="detailwarehouseid[]" value="<?php echo $detaildata->warehouse_id; ?>"/>
                        <?php }else{ ?>
                        
                        <span id="locationId<?php echo $detaildata->locationid; ?>"><?php echo $detaildata->location; ?></span>
                        <input type="hidden"  id="detailLocationid<?php echo $detaildata->id; ?>" name="detailLocationid[]" value="<?php echo $detaildata->locationid; ?>"/>
                        
                        
                        <?php }?>
                        <br/>
                        <span id="teagroup<?php echo $detaildata->id; ?>"><?php echo $detaildata->teagroupcode; ?></span>
                        <input type="hidden"  id="detailteagroupid<?php echo $detaildata->id; ?>" name="detailteagroupid[]" value="<?php echo $detaildata->teagroupid; ?>"/>
                    </td>
                    <td>
                        <span id="grade<?php echo $detaildata->id; ?>"><?php echo $detaildata->grade; ?></span>
                        <input type="hidden"  id="detailgradeid<?php echo $detaildata->id; ?>" name="detailgradeid[]" value="<?php echo $detaildata->grade_id; ?>"/>
                    </td>
                    <td>
                        <span id="gpnumber<?php echo $detaildata->id; ?>"><?php echo $detaildata->gp_number; ?></span>
                        <input type="hidden"  name="detailgpno[]" value="<?php echo $detaildata->gp_number; ?>"/>
                        <br/>
                        <span id="gpdate<?php echo $detaildata->id; ?>">
                            <?php 
                                if($detaildata->date!=''||$detaildata->date!=NULL){echo date("d-m-Y", strtotime($detaildata->date));}
                            ?>
                        </span>
                        <input type='hidden' name='detaildate[]' value='<?php echo $detaildata->date; ?>'/>
                    </td>
                    <td>
                        
                        <span id="stamp<?php echo $detaildata->id; ?>"><?php echo $detaildata->stamp; ?></span>
                        <input type="hidden"  name="detailstamp[]" value="<?php echo $detaildata->stamp; ?>"/>
                       
                    </td>
                    <td>
                        
                       <!-- data fething from bag Details 25/06/2015-->
                       <?php
                        	$bagTypeName =  $detaildata->BagTypes;
                        	$numberOfBags =   $detaildata->NumbersOfBags;
                        	$qtyOfBags = $detaildata->BgKgs;
                        	$chestSerial = $detaildata->chest;
                        	$bagDetailsId = $detaildata->BagDTlID;
                        	$selectedBagId = $detaildata->selectedBagId;
                        	
                        	if($bagDetailsId!=""){
                        		$numberOfBagsRowsArray = explode(',', $bagDetailsId); 
                        		$numberOfBagsRowsInTable =count($numberOfBagsRowsArray);
                        	}else{
                        		$numberOfBagsRowsInTable =0;
                        	}
                        	?>
                        	<table>
                        	
								<tr>
								<td>
								<input type="hidden" id="hdNumberOfBagsRow<?php echo $detaildata->id; ?>" value="<?php echo($numberOfBagsRowsInTable); ?>"/>
								<span id="sample<?php echo $detaildata->id; ?>"><?php echo str_replace(",", "<br>", $numberOfBags);?></span>
								<input type="hidden" id="detailsamplename<?php echo $detaildata->id; ?>" name="detailsamplename[]" value="<?php echo str_replace(",", "*", $numberOfBags) ?>"/>
								</td>
								<td>=></td>
								<td>
									<span id="samplenet<?php echo $detaildata->id; ?>"><?php echo str_replace(",", "<br>", $qtyOfBags); ?></span>
									<input type="hidden" id="detailsamplenet<?php echo $detaildata->id;?>" name="detailsamplenet[]" value="<?php echo str_replace(",", "*", $qtyOfBags); ?>"/>
								</td>
								<td>
									<span id="bagType<?php echo $detaildata->id; ?>"><?php echo str_replace(",", "<br>", $bagTypeName); ?></span>
									<input name="bagtypeIds[]" id ="bagtypeIds<?php echo $detaildata->id;?>" value="<?php echo str_replace(",", "*", $selectedBagId); ?>" type="hidden">
								</td>
								<td>
									<span id="chest<?php echo $detaildata->id; ?>"><?php echo str_replace("~", "<br>", $chestSerial); ?></span>
									<input name="chestvalues[]" id="chestvalues<?php echo $detaildata->id; ?>" value="<?php echo str_replace("~", "*", $chestSerial); ?>" type="hidden"></td>
								</tr>
							
							</table>
                        	
                        	
                        	
               <!-- data fething from bag Details -->         	
                        	
                        	
                        	
                        	
                        
                    </td>
                    <td>
                        <span id="gross<?php echo $detaildata->id; ?>"><?php echo $detaildata->gross; ?></span>
                        <input type="hidden"  name="detailgross[]" value="<?php echo $detaildata->gross; ?>"/>
                        <br/>
                        <span id="brokerage<?php echo $detaildata->id; ?>"><?php echo $detaildata->brokerage; ?></span>
                        <input type="hidden"  name="detaillistbrokerage[]" value="<?php echo $detaildata->brokerage; ?>"/>
                    </td>
                    <td>
                        <span id="tweigh<?php echo $detaildata->id; ?>"><?php echo $detaildata->total_weight; ?></span>
                        <input type="hidden" name="detaillisttweight[]" value="<?php echo $detaildata->total_weight; ?>"/>
                        <br/>
                        <span id="vat<?php echo $detaildata->id; ?>">
                            <?php
                            if ($detaildata->rate_type == 'V'):
                                $type = 'VAT';
                            else:
                                $type = 'CST';
                            endif
                            ?>

                            <?php echo $type . ' => ' . $detaildata->rate_type_value; ?> 
                        </span>
                        <input type="hidden"  name="rate_type[]" id="ratetype<?php echo $detaildata->id; ?>" class="ratetype" value="<?php echo $detaildata->rate_type; ?>"/>
                        <input type="hidden"  name="rate_type_id[]" id="ratetypeid<?php echo $detaildata->id; ?>" class="ratetypeid" value="<?php echo $detaildata->rate_type_id; ?>"/>
                        <input type="hidden"  name="detailvat[]" id="ratetypevalue<?php echo $detaildata->id; ?>"  class="ratetypevalue" value="<?php echo $detaildata->rate_type_value; ?>"/>
                        <input type="hidden" class="fieldvatrate" name="fieldvatrate[]" value="<?php if ($detaildata->rate_type == 'V') {
                            echo $detaildata->rate_type_value;
                        } ?>"/>
                        <input type="hidden" class="fieldcstrate" name="fieldcstrate[]" value="<?php if ($detaildata->rate_type == 'C') {
                            echo $detaildata->rate_type_value;
                        } ?>"/>
                    </td>


                    <td>
                        <span id="price<?php echo $detaildata->id; ?>"><?php echo $detaildata->price; ?></span>
                        <input type="hidden"  name="detailprice[]" value="<?php echo $detaildata->price; ?>"/>
                        <br/>
                        <span id="stax<?php echo $detaildata->id; ?>"><?php echo $detaildata->service_tax; ?></span>
                        <input type="hidden"  name="detailstax[]" class="detailstax" value="<?php echo $detaildata->service_tax; ?>"/>
                        <input type="hidden"  name="stax_id[]" id="servicetaxid<?php echo $detaildata->id; ?>" value="<?php echo $detaildata->service_tax_id; ?>"/>
                    </td>
                    <td>
                        <span id="value<?php echo $detaildata->id; ?>"><?php echo $detaildata->value_cost; ?>
                            <input type="hidden"  name="detailvalue[]" value="<?php echo $detaildata->value_cost; ?>"/>
                        </span>
                        <br/>
                        <span id="total<?php echo $detaildata->id; ?>"><?php echo $detaildata->total_value; ?></span>
                        <input type="hidden"  name="detaillisttotal[]" value="<?php echo $detaildata->total_value; ?>"/>
                        
                        <!--hidden for checking send to transporter or not 01/07/2015 -->
                        
                        <input type="hidden" name="detailsDoSentStatus[]" id="detailsDoSentStatus" value="<?php echo($detaildata->sent_trans); ?>"/>
                        
                        <!-- hidden for checking send to transporter or not 01/07/2015 -->       
                    </td>
                    <td>
                        <?php if($detaildata->sent_trans!='Y'){?>
                        <img src="<?php echo base_url(); ?>application/assets/images/delete.png" height='18' width='18' onclick='deleterowdb("detailtr",<?php echo $detaildata->id; ?>)'/>
                        <img src="<?php echo base_url(); ?>application/assets/images/edit.jpg" height='20' width='20' onclick='editrow("detailtr",<?php echo $detaildata->id; ?>)'/>
                        <?php } ?>
                    </td>
                </tr>
                <?php
            }
            ?>

        </tbody>


    </table>
 </div>
<div id="dialog-confirm_purDtl_delete" title="Access denied" style="display: none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete is not permissable now!!Please contact vendor.</p>
</div>

    <section id="loginBox" style="width:400px;">
        <table style="margin-left:2%" width="100%" border="0" style="">
            <tr>
                <td scope="row">Tea Value</td>
                <td id="teavalue" name="teavalue" style="text-align:right;"><?php echo $bodycontent['saveddata'][0]->tea_value; ?></td>
            <input type="hidden" name="teavalueinput" id="teavalueinput" value="<?php echo $bodycontent['saveddata'][0]->tea_value; ?>"/>

            </tr>
            <tr>
                <td scope="row">Brokerage</td>
                <td id="totalbrokerage" name="totalbrokerage" style="text-align:right;"><?php echo $bodycontent['saveddata'][0]->tbrokerage; ?></td>
            <input type="hidden" name="brokerageinput" id="brokerageinput" value="<?php echo $bodycontent['saveddata'][0]->tbrokerage; ?>"/>
            </tr>
            <tr>
                <td scope="row">Service Tax</td>
                <td id="servicetax" name="servicetax" style="text-align:right;"><?php echo $bodycontent['saveddata'][0]->tservice_tax; ?></td>
            <input type="hidden" name="servicetaxinput" id="servicetaxinput" value="<?php echo $bodycontent['saveddata'][0]->tservice_tax; ?>"/>
            </tr>
            <tr>
                <td scope="row">Less Chestage Allowance</td>
                <td style="text-align:right;">
                    <input type="text" name="chestallow" id="chestallow" style="text-align:right;" value="<?php echo $bodycontent['saveddata'][0]->chestage_allowance; ?>"/>
                </td>
            </tr>
          <!--  <tr>
              <td><input type="radio" name="type" value="V" class="call" <?php if (($bodycontent['saveddata'][0]->type) == 'V'): ?>checked="checked" <?php endif; ?>>VAT</td>
              <td><input type="radio" name="type" value="C"  class="call"  <?php if (($bodycontent['saveddata'][0]->type) == 'C'): ?>checked="checked" <?php endif; ?>>CST</td>
            </tr>-->
          <!--  <tr id="ratedropdowntr" style="display:none;">
              <td>Select current rate</td>
              <td id="ratedropdown">
                  <select id="optionrate" name="optionrate"><option value="0">Select a rate</option>
            <?php
            foreach ($bodycontent['vatrate'] as $vatdata):
                ?>
                       <option value="<?php echo $vatdata->id; ?>"><?php echo $vatdata->vat_rate; ?></option>
                <?php
            endforeach;
            ?>
                  </select>
             </td>
            </tr>-->
            <tr>
                <td scope="row">Value Added Tax</td>
                <td id="calculatevat" name="calculatevat" style="text-align:right;"><?php echo $bodycontent['saveddata'][0]->total_vat; ?></td>
            <input type="hidden" name="calculatevatinput" id="calculatevatinput" value="<?php echo $bodycontent['saveddata'][0]->total_vat; ?>"/>

            </tr>
            <tr>
                <td scope="row">CST</td>
                <td id="calculatecst" name="calculatecst" style="text-align:right;"><?php echo $bodycontent['saveddata'][0]->total_cst; ?>  </td>
            <input type="hidden" name="calculatecstinput" id="calculatecstinput" value="<?php echo $bodycontent['saveddata'][0]->total_cst; ?>"/>

            </tr>
          <!--  <tr>
              <td scope="row">Used Rate</td>
              <td id="calculatevat" name="calculatevat" ><?php echo $bodycontent['saveddata'][0]->rate_type_value; ?></td>
                <input type="hidden" name="calculatevatinput" id="calculatevatinput" value="<?php echo $bodycontent['saveddata'][0]->rate_type_value; ?>"/>
            </tr>-->
            <!--<tr>
              <td scope="row">Surcharge</td>
              <td>60</td>
            </tr>-->
            <tr>
                <td scope="row">Stamp Charge</td>
                <td>
                    <input type="text" name="stampcharge" id="stampcharge"  style="text-align:right;" value="<?php echo $bodycontent['saveddata'][0]->masterstamp; ?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr/></td>
            </tr>
            <tr>
                <th scope="row">TOTAL</th>
                <td id="total" name="total" style="text-align:right;"><?php echo $bodycontent['saveddata'][0]->total; ?></td>
            <input type="hidden" name="totalinput" id="totalinput" value="<?php echo $bodycontent['saveddata'][0]->total; ?>"/>
            </tr>

        </table>

    </section>

    <span class="buttondiv"><div class="save" id="savedpage" align="center">SAVE</div></span>

</form>








