<script src="<?php echo base_url(); ?>application/assets/js/purchaseinvoice.js"></script>

 <h2><font color="#5cb85c">Manage Purchase Invoice</font></h2>
 <form role="form" method="post" name="addpurchaseinvoice" id="addpurchaseinvoice" action="<?php echo base_url(); ?>purchaseinvoice/savedata" method="post">

  <section id="loginBox" style="width:800px;">
     <table cellspacing="4" cellpadding="0" class="tablespace" border="0">
                   
         <tr>
             <td>Purchase Type</td>
             <td colspan="4">
                 <select id="purchasetype" name="purchasetype">
                     <option value="AS">Auction Sell</option>
                     <option value="PS">Private Sell</option>
                     <option value="SB">Seller to Buyers</option>
                 </select>
             </td>
         </tr>
         
                    <tr>
                        <td scope="row">Invoice Number</td>
                        <td><input type="text" name="taxinvoice" id="taxinvoice"/></td>
                        <td/>
                        <td scope="row">Sale Number</td>
                        <td><input type="text" name="salenumber" id="salenumber"/></td>
                   </tr>
                   
                    <tr>
                    <td scope="row" >Invoice Date</td>
                    <td><input type="text" class="datepicker" id="taxinvoicedate" name="taxinvoicedate"/></td>
                    <td/>
                     <td scope="row" >Sale Date</td>
                    <td><input type="text" class="datepicker" id="saledate" name="saledate"/></td>
                   </tr>
                   
                    <tr>
                    <td scope="row">Vendor</td>
                    <td>
                    <select name="vendor" id="vendor" style="width: 190px">
                    <option value="0">select</option>
                    <?php foreach ($header['vendor'] as $content) : ?>
                 			<option value="<?php echo $content->vid; ?>"><?php echo $content->vendor_name; ?></option>
    				 <?php endforeach; ?>
                    
                    </select>
                    </td>
                    <td/>
                     <td scope="row" >Promt Date</td>
                    <td><input type="text" class="datepicker" id="promtdate" name="promtdate"/></td>
                    </tr>
                   </table>
                   <br/>
                 <span class="buttondiv"><div class="save" id="gotodetail" align="center">Click for Details</div></span>
           </section>
         
         		<div id="detailpurchaseinvoice" style="display:none;" title="Fill up in detail" align="left">
                 
                  <table cellspacing="4" cellpadding="0" class="tablespace" width="100%" style=" margin-left: 2cm;" id="popupwindow">
                  	<tr>
                    	<td>
                        	  <table class="tablespace" >
                                       <tr>
                                        <td scope="row">LOT</td>
                                        <td><input type="text" id="lot" name="lot" tabindex="1" /></td>
                                        <td/>
                                       </tr>
                                       <tr>
                                        <td scope="row">DO</td>
                                        <td><input type="text" id="do" name="do" tabindex="2" /></td>
                                       </tr>
                                       <tr>
                                        <td scope="row">DO Date</td>
                                        <td><input type="text" class="datepicker" id="dodate" tabindex="3" name="dodate"/></td>
                                       </tr>
                                       <tr>
                                        <td scope="row">Group :</td>
                                        <td>
                                        	<div id="teagrouperr">
                                                    <select name="teagroup" id="teagroup" style="width: 190px" tabindex="4">
                                            <option value="">select</option>
                                            <?php foreach ($header['teagroup'] as $content) : ?>
                                                    <option value="<?php echo $content->id; ?>"><?php echo $content->group_code; ?></option>
                                             <?php endforeach; ?>
                                            
                                            </select>
                                             </div>
                                        </td>
                                       </tr>
                                        <tr>
                                        <td scope="row">Invoice</td>
                                        <td><input type="text" id="invoice" name="invoice" tabindex="5"/></td>
                                       </tr>
                                         <tr>
                                        <td scope="row">Garden</td>
                                       
                                        <td><div id="gardenerr"><select name="garden" id="garden" style="width: 190px" tabindex="6">
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
                                                 <select name="warehouse" id="warehouse" style="width: 190px" tabindex="7">
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
                                                  <select name="grade" id="grade" style="width: 190px" tabindex="8">
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
                                            <td scope="row" >Brokerage</td>
                                            <td><input type="text" id="brok" name="brok" tabindex="13"/></td>
                                            <tr/>
                                      	                                           
                                           <tr>
                                            <td scope="row" >Chest</td>
                                            <td><input type="text" id="chfrom" name="chfrom" tabindex="14"/> <input tabindex="15" type="text" id="chto" name="chto"/></td>
                                            <tr/>
                                            
                                           <tr>
                                            <td scope="row" >GP No</td>
                                            <td><input type="text" id="gpno" name="gpno" tabindex="16"/></td>
                                           <tr/>
                                            <tr>
                                            <td scope="row" >GP Date</td>
                                            <td><input type="text" class="datepicker" id="date" tabindex="17" name="date"/></td>
                                            <tr/>
                                            <tr>
                                            
                                         
                                      </table>
                        </td>
                    </tr>
                    <tr>
                    	<td>
                        				  <table class="tablespace" >
                                         
                                            <tr>
                                            <td scope="row" >Package</td>
                                            <td><input type="text" id="package" tabindex="9" name="package" onkeyup="checkNumeric(this)"/></td>
                                            <tr/>
                                            <tr>
                                            
                                             <td scope="row" >Stamp</td>
                                            <td><input type="text" id="stamp" name="stamp" tabindex="10"/></td>
                                            <tr/>
                                            
                                             <td scope="row" >Net</td>
                                            <td><input type="text" id="net" name="net" tabindex="11" onkeyup="checkDecimal(this)"/></td>
                                            <tr/>
                                            <tr>
                                             <td scope="row" >Gross</td>
                                            <td><input type="text" id="gross" name="gross" tabindex="12"/></td>
                                            <tr/>
                                           
                                           
                                           </table>
                        </td>
                        <td>
                        					<table class="tablespace" >
                                            	<tr>
                                            <td scope="row" valign="top">Sample &nbsp;<a href="javascript:void(0)" >
                                                    <img src="<?php echo base_url(); ?>application/assets/images/add_sample.jpg" height="18" width="18" id="addsample"/></a>
                                                <input type="hidden" name="samplecount" id="samplecount" value=""/></td>
                                            <td id="addsamplehere"></td>
                                            <tr/>
                                             <tr>
                                            <td scope="row" >Price</td>
                                            <td><input type="text" id="price" name="price" tabindex="18"/></td>
                                            <tr/>
                                             <tr>
                                             <tr>
                                                 <td><input type="radio" name="type" value="V" class="call" checked="checked" tabindex="19">VAT</td>
                                                 <td><input type="radio" name="type" value="C"  class="call" tabindex="19">CST</td>
                                              </tr>
                                            <tr>
                                            <td scope="row" id="selectionlable">VAT Rate</td>
                                            <td>
                                            <span id="currentvatrate">
                                                <select id="optionrate" name="optionrate"  class="optionrate" tabindex="20"><option value="0">Select a rate</option>
                                                    <?php foreach($bodycontent['vatrate'] as $value): ?>
                                                     	<option value="<?php echo $value->id ?>"><?php echo $value->vat_rate ?></option>';
                                                   
                                            		<?php endforeach; ?>
                                                    </select>
                                            </span>
                                                <span> <input type="text" id="taxrate" name="taxrate" readonly="readonly" tabindex="21"/></span>
                                           </td>
                                            <tr/>
                                            
                                            <td scope="row" >Service Tax</td>
                                            <td>
                                             <select id="optionstax" name="optionstax"><option value="0">Select a rate</option>
                                                    <?php foreach($bodycontent['servicetax'] as $value): ?>
                                                     	<option value="<?php echo $value->id ?>"><?php echo $value->tax_rate ?></option>';
                                                   
                                            		<?php endforeach; ?>
                                             </select>
                                                <input type="text" id="stax" name="stax" readonly="readonly" tabindex="22"/></td>
                                            <tr/>
                                          
                                            </table>
                        </td>
                     </tr>
                  </table>
                  
                 
 </div>

 
 <input type="hidden" id="countdetail" name="countdetail" value="0" /> 
<!-- <input type="hidden" id="servicetaxrate" name="servicetaxrate" value="<?php echo $bodycontent['servicetax']?>" />--> 
<!-- <input type="text" id="vatrate" name="vatrate" value="<?php echo $bodycontent['vatrate']?>" /> -->

 
<table class="display" cellspacing="0" width="100%"  id="example2"  frame="box">

	<thead bgcolor="#a6a6a6">
       <th>LOT/DO/Date</th>
       <th>Invoice Number</th>
       <th>Garden/Warehouse/Group</th>
       <th>Grade/Chest</th>
       <th>GP No/Date</th>
       <th>
        Package<br/>
        Stamp/Net
        </th>
        <th>
         Sample
        </th>
        <th>Gross/Brokerage</th>
        <th>Total Wt.<br/>Vat</th>
        <th>Price<br/>Service tax</th>
        <th>Value<br/>Total</th>
        <th></th>
    </thead>
    
     <tbody id="mybody">
    
	</tbody>
    
   <!-- <tr> 
    <td colspan="10"></td>
    <td colspan="2" style="font-weight:bold;">Total Pkgs <span id="tpkgs">1000</span> , <span id="tnet">50 kgs</span></td>
    </tr>-->
</table>

  <section id="loginBox" style="width:400px;">
<table style="margin-left:2%" width="100%" border="0" style="text-align:right;">
  <tr>
    <td scope="row">Tea Value</td>
    <td id="teavalue" name="teavalue" style="text-align:right;"></td>
    <input type="hidden" name="teavalueinput" id="teavalueinput" />
  
  </tr>
  <tr>
    <td scope="row">Brokerage</td>
    <td id="totalbrokerage" name="totalbrokerage" style="text-align:right;"></td>
      <input type="hidden" name="brokerageinput" id="brokerageinput" />
  </tr>
  <tr>
    <td scope="row">Service Tax</td>
    <td id="servicetax" name="servicetax" style="text-align:right;"></td>
      <input type="hidden" name="servicetaxinput" id="servicetaxinput" />
  </tr>
  <tr>
    <td scope="row">Less Chestage Allowance</td>
    <td><input type="text" name="chestallow" id="chestallow" style="text-align:right;"/></td>
  </tr>
 <!-- <tr>
    <td><input type="radio" name="type" value="V" class="call">VAT</td>
    <td><input type="radio" name="type" value="C"  class="call">CST</td>
  </tr>-->
<!--   <tr id="ratedropdowntr" style="display:none;">
    <td>Select current rate</td>
    <td id="ratedropdown"></td>
  </tr>-->
  <tr>
    <td scope="row">Value Added Tax</td>
    <td id="calculatevat" name="calculatevat" style="text-align:right;"></td>
      <input type="hidden" name="calculatevatinput" id="calculatevatinput" />
  </tr>
   <tr>
    <td scope="row">CST</td>
    <td id="calculatecst" name="calculatecst" style="text-align:right;"></td>
      <input type="hidden" name="calculatecstinput" id="calculatecstinput" />
  </tr>
  <!--<tr>
    <td scope="row">Surcharge</td>
    <td>60</td>
  </tr>-->
  <tr>
    <td scope="row">Stamp Charge</td>
    <td><input type="text" name="stampcharge" id="stampcharge"  style="text-align:right;" readonly/>
        
    </td>
  </tr>
  <tr>
    <td colspan="2"><hr/></td>
  </tr>
  <tr>
    <th scope="row">TOTAL</th>
    <td id="total" name="total" style="text-align:right;"></td>
      <input type="hidden" name="totalinput" id="totalinput" />
  </tr>
 
</table>

</section>
 
  <span class="buttondiv"><div class="save" id="savedpage" align="center">SAVE</div></span>
    
</form>

 

                    


    
    
