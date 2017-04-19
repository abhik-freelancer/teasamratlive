/* 
 * for adding StockTransferIN
 * 13/05/2015
 * 
 */

$(document).ready(function() {
    $( ".legal-menu"+$('#transactionmenu').val() ).addClass( " collapse in " );
    $( ".stocktransferin").addClass( " active " );
    
    var basepath = $("#basepath").val();
    var sampleBagRow = 1;
    var divNumber = 1;
    //var purchaseType ='';


    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;



    $("#startdate").val(mindate);
    $("#enddate").val(maxDate);
        $("#vendor").customselect();

    

  /*@date for invoice,saledate,promptdate
 * @date 14-01-2016
 * @author Mithilesh
 */   
  
  
    
      
   
     //purchase type check.
     
    $("#addnewDtlDiv").click(function() {
        
        $.ajax({
            url: basepath + "stocktransferin/createDetails",
            type: 'post',
            data: {divNumber: divNumber
            },
            success: function(data) {
                $("#detailDiv").append(data);

            },
            complete: function() {
            },
            error: function(e) {
                //called when there is an error
                //console.log(e.message);
            }
        });
        divNumber++;
    });


    $(document).on('click', ".plus", function() {
        var id_img = $(this).attr("id");
        var divno = id_img.split('_');
        var idnum = divno[1];
        $("#dtlDiv_" + idnum).toggle();
    });
    $(document).on('click',".divdel",function(){
        var id_img = $(this).attr("id");
        var divno = id_img.split('_');
        var idnum = divno[1];
        $("#purchaseDtl_" + idnum).remove();
        DtlGlobalFunction(idnum);
    });
    /**
     * //adding new sample bag
     */

    $(document).on('click', ".samplebag", function() {
        var Dtlid = $(this).attr('id');
        var divno = Dtlid.split('_');
        var idnum = divno[1];
        //alert(purDtlid);
        var tableId = "#sampleBag_" + idnum + " tr:last";
        //alert(tableId);
        var newRow = '<tr id="row_' + idnum + '_' + sampleBagRow + '">' +
                '<td>' +
                '<input type="hidden" id="txtSampleBagid_' + idnum + '_0" name="txtSampleBagid[]" value=""/>' +
                '<input type="hidden" id="txtSampleBagTypeId_' + idnum + '_0" name="txtSampleBagTypeId" value="2"/>' +
                '<img src="' + basepath + 'application/assets/images/delete-ab.png" title="Delete" alt="Delete" class="removeRow" id="' + idnum + '_' + sampleBagRow + '" style="cursor: pointer; cursor: hand;"/>' +
                '</td>' +
                '<td>' +
                '<input type="text" id="txtNumOfSampleBag_' + idnum + '_0" name="txtNumOfSampleBag_' + idnum + '[]" class="txtNumOfSampleBag" value=""/>[Bags]</td>' +
                '<td>' +
                '<input type="text" id="txtNumOfSampleNet_' + idnum + '_0" name="txtNumOfSampleNet_' + idnum + '[]" class="txtNumOfSampleNet" value=""/>[Kgs/bag]</td>' +
                '<td><input type="text" id="txtNumOfSampleChess_' + idnum + '_0" name="txtNumOfSampleChess_' + idnum + '[]" class="txtNumOfSampleChess" value=""/></td>' +
                '</tr>';


        $(tableId).after(newRow);
        sampleBagRow++;

    
       $(document).on('click', ".removeRow", function() {
          
            var delRowId = $(this).attr('id');
            var rowNumber = "#row_" + delRowId;
            var priceid = $(this).attr('id');
            var purDtlId = priceid.split('_');
            var purchase_dtl_id = purDtlId[0];
            $(rowNumber).remove();
            
            DtlGlobalFunction(purchase_dtl_id);
        
            
            

        });
    });
    //adding new sample bag

    $(document).on('focus', '.datepicker', function() {
        $('.datepicker').datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: mindate,
            maxDate: maxDate
        });
    });





  
    //form control event//


   

    $(document).on('focus', ".price", function() {

        $('.price').keyup(function() {
            var priceid = $(this).attr('id');
            var purDtlId = priceid.split('_');
            var purchase_dtl_id = purDtlId[1];
            console.log("price :" + purchase_dtl_id);
           DtlGlobalFunction(purchase_dtl_id);

        });


    });
  //  transCost
  //  getTransCost
  
   

    //Normal bag event handler//

    $(document).on('focus', ".txtNumOfNormalBag", function() {

        $('.txtNumOfNormalBag').keyup(function() {
            var NumOfNormalBagId = $(this).attr('id');
            var purDtlId = NumOfNormalBagId.split('_');
            var purchase_dtl_id = purDtlId[1];
            
            DtlGlobalFunction(purchase_dtl_id);

        });

    });


    $(document).on('focus', ".txtNumOfNormalNet", function() {
        $('.txtNumOfNormalNet').keyup(function() {
            var NumOfNormalNetId = $(this).attr('id');
            var purDtlId = NumOfNormalNetId.split('_');
            var purchase_dtl_id = purDtlId[1];
            
            DtlGlobalFunction(purchase_dtl_id);

        });
    });
    //Normal bag event handler//

    //***************************Samplebag Event*******************************//
    $(document).on('focus', ".txtNumOfSampleBag", function() {
        $('.txtNumOfSampleBag').keyup(function() {
            var NumOfSampleBagId = $(this).attr('id');
            var purDtlId = NumOfSampleBagId.split('_');
            var purchase_dtl_id = purDtlId[1];
            
           DtlGlobalFunction(purchase_dtl_id);
         

        });
    });

    $(document).on('focus', ".txtNumOfSampleNet", function() {
        $(".txtNumOfSampleNet").keyup(function() {
            var NumOfSampleNetId = $(this).attr('id');
            var purDtlId = NumOfSampleNetId.split('_');
            var purchase_dtl_id = purDtlId[1];
            
            DtlGlobalFunction(purchase_dtl_id);
            

        });
    });


    //***************************Samplebag Event*******************************// 



   


   
    
    $("#txtOtherCharges").change(function(){
        allTotalOfCost() ; //call for other charges
        
    });
    
    /*@date 14-01-2016
     * @author Mithilesh
     * 
     */
    /* $("#txtTotalBags").change(function(){
        totalNoOfBags() ; //call for other charges
        
    });*/
    $("#txtRoundOff").change(function(){
        allTotalOfCost() ; //call for other charges
    });

// save data on add purchase [02/09/2015]
    $('#savePurchase').click(function() {
        
        if (divNumber == 1) {
            
            $("#dialog-new-add").dialog({
                    resizable: false,
                    height: 140,
                    modal: true,
                    buttons: {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    }
                });
        } else {
            
        if (validationDetails()) {
                
                var formData=$('#frmPurchase').serialize();
                formData = decodeURI(formData);
                //console.log(decodeURI(formData));
                $.ajax(
                        {
                            type: 'POST',
                            dataType : 'json',
                            url: basepath + "stocktransferin/insertNewPurchaseInvoice",
                            data: {formDatas:formData},
                            success: function(data) {
                                
                                if(data==1){
                                     $( "#dialog-new-save" ).dialog({
                                            resizable: false,
                                            height:140,
                                            modal: true,
                                            buttons: {
                                              "Ok": function() {
                                                window.location.href = basepath+'stocktransferin';
                                                $( this ).dialog( "close" );
                                              }
                                            }
                                          });
                                }else{
                                    $("#dialog-error-add").dialog({
                                                        resizable: false,
                                                        height: 140,
                                                        modal: true,
                                                        buttons: {
                                                            "Ok": function() {
                                                                $(this).dialog("close");
                                                            }
                                                        }
                                                    });
                                }
                            },
                            complete: function() {
                            },
                            error: function(e) {
                                //called when there is an error
                                console.log(e.message);
                            }
                        });

            } else {

                $("#dialog-new-add").dialog({
                    resizable: false,
                    height: 140,
                    modal: true,
                    buttons: {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    }
                });
            }
          
            
        }//else confirm
    });

    //document on load
});

/***********************************************************************************************************************/
/*****************************************************User Defined Function 28/08/2015 to do*********************************************/



/**
 * 
 * @param {type} ctlID
 * @returns {Boolean}
 * @description All function in detail section will be call here
 */
function DtlGlobalFunction(ctlID){
    TotalWeightPerDtl(ctlID);
    TotalBags(ctlID);
    getTeaCostPerKg(ctlID)
    
    DetailTeaCost(ctlID);
    allTotalOfCost();
    getGrandWeight();
    totalBagNo();
    return false;
}


/**
 * 
 * @param {type} dtlId
 * @returns Total bag weight in Kgs [text:DtltotalWeight]
 */
function TotalWeightPerDtl(dtlId){
    
    var tableId = "#tableNormal_" + dtlId + " tr";
    var sampleTableId = "#sampleBag_" + dtlId + " tr";

    var numOfBags;
    var normalBagQty;
    var numOfSampleBag;
    var sampleBagQty;
    var total_Quantity_normal_bag = 0;
    var total_Quantity_sample_bag = 0;
    var totalQtyOfBags = 0;

    var i = 0;
    var data = {
        numberofSampleBag: [], QtyInSampleBag: [], qty: []
    }

    $(tableId).each(function() {
        numOfBags = ($(this).find(".txtNumOfNormalBag").val() == "" ? 0 : $(this).find(".txtNumOfNormalBag").val());
        normalBagQty = ($(this).find(".txtNumOfNormalNet").val() == "" ? 0 : $(this).find(".txtNumOfNormalNet").val());
    });
    total_Quantity_normal_bag = parseFloat(numOfBags) * parseFloat(normalBagQty);

    //loop through the tr's
    $(sampleTableId).each(function() {

        //look for the fields firstName and lastName in the tr
        //get their values and push into storage   
        if (i != 0) {
            numOfSampleBag = ($(this).find(".txtNumOfSampleBag").val() == "" ? 0 : $(this).find(".txtNumOfSampleBag").val());
            sampleBagQty = ($(this).find(".txtNumOfSampleNet").val() == "" ? 0 : $(this).find(".txtNumOfSampleNet").val());
            data.numberofSampleBag.push(numOfSampleBag);
            data.QtyInSampleBag.push(sampleBagQty);
            data.qty.push(parseFloat(numOfSampleBag) * parseFloat(sampleBagQty));
            total_Quantity_sample_bag = total_Quantity_sample_bag + parseFloat(numOfSampleBag * sampleBagQty);
        }
        i++;

    });

    totalQtyOfBags = total_Quantity_normal_bag + total_Quantity_sample_bag;
    
    $("#DtltotalWeight_" + dtlId).val(totalQtyOfBags);

    //console.log("totalWeight :" + totalQtyOfBags);
   // console.log("id :" + dtlId);

    return totalQtyOfBags;
    
}
/*
 * @date 14-01-2016
 * @author Mithilesh
 */

  function TotalBags(dtlId){
    
    var tableId = "#tableNormal_" + dtlId + " tr";
    var sampleTableId = "#sampleBag_" + dtlId + " tr";

    var numOfBags=0;
   
    var numOfSampleBag=0;
   

    var i = 0;
    var data = {
        numberofSampleBag: []
    }

    $(tableId).each(function() {
        numOfBags_N = ($(this).find(".txtNumOfNormalBag").val() == "" ? 0 : $(this).find(".txtNumOfNormalBag").val());
      
    });
  
   numOfBags = numOfBags + parseInt(numOfBags_N);

    //loop through the tr's
    $(sampleTableId).each(function() {

        
        if (i != 0) {
            numOfSampleBag_N = ($(this).find(".txtNumOfSampleBag").val() == "" ? 0 : $(this).find(".txtNumOfSampleBag").val());
           
            data.numberofSampleBag.push(parseInt(numOfSampleBag));
           
            numOfSampleBag = parseInt(numOfSampleBag_N) + numOfSampleBag;
        }
        i++;

    });

    //totalQtyOfBags = total_Quantity_normal_bag + total_Quantity_sample_bag;
    totalNoOfBag =  numOfBags + numOfSampleBag;
    
    $("#DtltotalBags_" + dtlId).val(totalNoOfBag);

    //console.log("totalBag :" + totalNoOfBag);
   // console.log("id :" + dtlId);
    $("#txtTotalBags").val(totalNoOfBag);
    return totalNoOfBag;
 } 


/**
 * @method TotalTeaPricePerDtl
 * @returns peice X weight perDetail
 */
function TotalTeaPricePerDtl(purDtlId){
    var price = 0;
    var totalQty = 0;
    var totalTeaPrice = 0;

    totalQty = TotalWeightPerDtl(purDtlId);
    
    price = ($('#txtPrice_' + purDtlId).val() == "" ? 0 : $('#txtPrice_' + purDtlId).val());
    totalTeaPrice = parseFloat(totalQty) * parseFloat(price);
 
    return totalTeaPrice;
}
/*
 * @method DetailTeaCost
 * @param {type} puDtId
 * @returns total per dtl cost
 */
function DetailTeaCost(puDtId){
    var teaPrice =0;
    
    var totalTeaCostInDetail=0;
    
    teaPrice = TotalTeaPricePerDtl(puDtId);
  
    
    
    totalTeaCostInDetail = parseFloat(teaPrice).toFixed(2);
    $("#DtltotalValue_" + puDtId).val(totalTeaCostInDetail);
    
}




/**
 * @method getServiceTax
 * @return {undefined}
 */
function getServiceTax(purchaseDetailId) {
    var brokerageValue = 0;
    var selectedServiceTax = "#drpServiceTax_" + purchaseDetailId + " option:selected";
    var serviceTaxAmount = 0;
    var serviceTaxPercentage = 0;

    brokerageValue = ($('#txtBrokerage_' + purchaseDetailId).val() == '' ? 0 : $('#txtBrokerage_' + purchaseDetailId).val());
    serviceTaxPercentage = ($(selectedServiceTax).text() == 'Select' ? '0' : $(selectedServiceTax).text());
    serviceTaxAmount = ((parseFloat(brokerageValue)) * parseFloat(serviceTaxPercentage)) / 100;
    // console.log(serviceTaxAmount);
    $("#serviceTax_" + purchaseDetailId).val(serviceTaxAmount.toFixed(2));
    return serviceTaxAmount;


}


function getTeaCostPerKg(prdtlId){
    var brokerageValue=0;
    var price = 0 ;
    var transPortCost = 0;
    var totalWeight = 0;
    var serviceTax = 0;
    var totalTeaPrice= 0 ;
    var teaCost = 0;
    var teaCostPrKg = 0;
    
    brokerageValue = ($('#txtBrokerage_' + prdtlId).val() == '' ? 0 : $('#txtBrokerage_' + prdtlId).val());
    transPortCost = ($('#transCost_' + prdtlId).val() == '' ? 0 : $('#transCost_' + prdtlId).val());
    price = ($('#txtPrice_' + prdtlId).val() == "" ? 0 : $('#txtPrice_' + prdtlId).val());
  //  transCost =($('#txtTransCost_' + prdtlId).val() == "" ? 0 : $('#txtTransCost_' + prdtlId).val());
    totalWeight = TotalWeightPerDtl(prdtlId);
        if(totalWeight!=0){
    serviceTax = getServiceTax(prdtlId);
    totalTeaPrice = (parseFloat(totalWeight) * parseFloat(price)) + parseFloat(brokerageValue) + parseFloat(serviceTax);
    teaCost = totalTeaPrice / parseFloat(totalWeight);
    
    teaCostPrKg = teaCost+parseFloat(transPortCost);
    $("#DtlteaCost_" + prdtlId).val(teaCostPrKg.toFixed(2));
        }
        else{
            $("#DtlteaCost_" + prdtlId).val('0.00');
        }
    return teaCostPrKg;
 
    
        
}

///////////////////////////////////////////////////////////////Summation Calculation//////////////////////////////////////

/**
 * @method totalTeaValues
 * @param {null} name description
 * @return {float} description
 * @description totalWeight * totalprice [#tea_value:database] 
 */
function totalTeaValues() {
    
    var totalTeaCost = 0;
    var totalTeaCost=0;
   
    
     $(".dtlTotalWght").each(function() {
        var totalWeightID = $(this).attr('id');
        var purDtlId = totalWeightID.split('_');
        var id = purDtlId[1];
        var total_val = ($("#DtltotalWeight_" + id).val() == '' ? 0 : $("#DtltotalWeight_" + id).val());
        var total_price = ($("#txtPrice_" + id).val() == "" ? 0 : $("#txtPrice_" + id).val());
        totalTeaCost =parseFloat(totalTeaCost+ parseFloat(total_val*total_price));

    });
     
    $("#txtTeaValue").val(totalTeaCost.toFixed(2));

    return totalTeaCost;
}
function totalBrokeragesValue() {
    var totalBrokerage = 0;

    $(".txtBrokerage").each(function() {
        var totalBrokerageID = $(this).attr('id');
        var purDtlId = totalBrokerageID.split('_');
        var id = purDtlId[1];
        var total_brokerage = ($("#txtBrokerage_" + id).val() == '' ? 0 : $("#txtBrokerage_" + id).val());
        totalBrokerage = parseFloat(totalBrokerage + parseFloat(total_brokerage));
        /*if(totalBrokerage!=0)
        {
            $("#txtBrokerageTotal").val(totalBrokerage);
            $("#txtBrokerageTotal").attr("disabled", "disabled");
        }
        else
        {
            $("#txtBrokerageTotal").removeAttr("disabled"); 
            //$("#txtBrokerageTotal").val('');
        }*/
        

    });
     $("#txtBrokerageTotal").val(totalBrokerage);
    return totalBrokerage;


}


/*@method totalNoOfBags
 * @date 14-01-2016
 *@author Mithilesh
 */







function totalSeviceTaxes() {

    var totalService = 0;

    $(".serviceTax").each(function() {
        var totalID = $(this).attr('id');
        var purDtlId = totalID.split('_');
        var id = purDtlId[1];
        var total = ($("#serviceTax_" + id).val() == '' ? 0 : $("#serviceTax_" + id).val());
        totalService = parseFloat(totalService + parseFloat(total));
        /*if(totalService!=0)
        {
            $("#txtServiceTax").val(totalService);
            $("#txtServiceTax").attr("disabled", "disabled");
        }
        else
        {
            $("#txtServiceTax").removeAttr("disabled"); 
        }*/
    });
    $("#txtServiceTax").val(totalService);
    return totalService;

}

function totalVATTaxes() {

    var totalVat = 0;

    $(".clsvat").each(function() {
        var totalID = $(this).attr('id');
        var purDtlId = totalID.split('_');
        var id = purDtlId[1];
        var total = ($("#txtVatAmount_" + id).val() == '' ? 0 : $("#txtVatAmount_" + id).val());
        totalVat = parseFloat(totalVat + parseFloat(total));
        $("#txtVatTotal").val(totalVat);

    });
    return totalVat;

}

function totalCSTAmt() {
    var totalCST = 0;

    $(".clsCst").each(function() {
        var totalID = $(this).attr('id');
        var purDtlId = totalID.split('_');
        var id = purDtlId[1];
        var total = ($("#txtCstAmount_" + id).val() == '' ? 0 : $("#txtCstAmount_" + id).val());
        totalCST = parseFloat(totalCST + parseFloat(total));
        $("#txtCstTotal").val(totalCST);

    });
    return totalCST;

}

function totalStampAmt() {
    var totalStamp = 0;

    $(".clsstamp").each(function() {
        var totalID = $(this).attr('id');
        var purDtlId = totalID.split('_');
        var id = purDtlId[1];
        var total = ($("#txtStamp_" + id).val() == "" ? 0 : $("#txtStamp_" + id).val());
        totalStamp = parseFloat(totalStamp + parseFloat(total));
        $("#txtStampTotal").val(totalStamp);

    });
    return totalStamp;

}

function allTotalOfCost() {
    var finalCostofAllCost=0;
    var teaValuesTotal = 0;
  /*  var finalBrokerage = 0;
    var finalServiceTax = 0;
    var finalVatAmount = 0;
    var finalCstAmount = 0;
    var finalStamp = 0;
    var otherCharges =0;
    var roundOff = 0;*/
    ///
     teaValuesTotal = totalTeaValues();
     /*if(totalBrokeragesValue()==0 || totalBrokeragesValue()=='')
     {
        finalBrokerage =$("#txtBrokerageTotal").val()==""?0:parseFloat($("#txtBrokerageTotal").val());
     }
     else
     {*/
       // finalBrokerage = totalBrokeragesValue();
     /*}*/
     /*if(totalSeviceTaxes()!=0)
     {
        finalServiceTax =$("#txtServiceTax").val()==""?0:parseFloat($("#txtServiceTax").val());
     }
     else
     {*/
         
  //       finalServiceTax = totalSeviceTaxes();
     /*}*/
   /*  finalVatAmount = (totalVATTaxes() == 0 ? 0 : totalVATTaxes());
     finalCstAmount = (totalCSTAmt() == 0 ? 0 : totalCSTAmt());
     finalStamp = totalStampAmt();
     otherCharges = ($("#txtOtherCharges").val()==""?0:parseFloat($("#txtOtherCharges").val()));
     roundOff =($("#txtRoundOff").val()==""?0:parseFloat($("#txtRoundOff").val()));*/
     
     //console.log("otherCharges :"+otherCharges);
    ///
    finalCostofAllCost = parseFloat(teaValuesTotal);
    $("#txtTotalPurchase").val(finalCostofAllCost.toFixed(2));
    return finalCostofAllCost;
}

///////////////////////////////Summation End////////////////////////////



//purchase details validation on adding 

function validationDetails() {
  //  alert('hello');
  //  if(!purTypeValidation()){return false;}
  //  if(!taxInvoiceValidation()){return false;}
  //  if(!invoicedateValidation()){return false;}
  //  if(!vendorValidation()){return false;}
    if(!masterDatavalidation()){return false;}
    
    if(!lotNumberValiadation()){return false;}
    if(!invoicevalidation() ) {return false;}
    if(!pricevaliadtion()){return false;}
    if(!normalBagValiadtion()){return false;}
    if(!normalBagQtyValidation()){return false;}
    if(!gardenValidation()){return false;}
    if(!gradeValidation()){return false;}
    if(!warehouseValidation()){return false;}
    if(!teagroupValidation()){return false;}
    if(!locationValidation()){return false;}
   
    
    return true;
}

/**
  * @method checkPurchaseInvoiceExist
  * @param 
  * @author Mithilesh
  * @date 13/01/2016
  */
 
$(document).on("blur", "#refrence_no",function(){
   
   checkPurchaseInvoiceExist();
});

function checkPurchaseInvoiceExist(){
    var basepath = $("#basepath").val();
    var refrenceNo = $("#refrence_no").val();
   
        $.ajax({
            type: "POST",
            url: basepath + "stocktransferin/checkExistingRefrenceNo",
            data: {refrenceNo:refrenceNo},
            dataType: 'html',
            success: function(data) {
               if(data==1){
                     $( "#dialog-check-invoice" ).dialog({
                            resizable: false,
                            height:140,
                            modal: true,
                            buttons: {
                            "Ok": function() {
                               $( this ).dialog( "close" );
                                $("#refrence_no").val("");
                                  $( "#refrence_no" ).focus();
                                       } 
                                         }
                                        });
                                   }},
                            complete: function() {
                            },
                            error: function(e) {
                                //called when there is an error
                                console.log(e.message);
                            }
            
        
});
}


function masterDatavalidation(){
    if($("#refrence_no").val()==""){
        $("#refrence_no").addClass("glowing-border");
         $("#transferDt").addClass("glowing-border");
           $("#receiptDt").addClass("glowing-border");
        return false;
    }
    if($("#transferDt").val()==""){
        $("#transferDt").addClass("glowing-border");
         $("#refrence_no").removeClass("glowing-border");
           $("#receiptDt").removeClass("glowing-border");
        return false;
    }
    if($("#receiptDt").val()==""){
        $("#receiptDt").addClass("glowing-border");
          $("#transferDt").removeClass("glowing-border");
          $("#refrence_no").removeClass("glowing-border");
        
        return false;
    }
    if($("#vendor").val()==0){
        $("#vendor_err").css("display","block");
        return false;
    }
   
    
    else{
        
        return true;
    }
    
}


/*function purTypeValidation(){
    if($("#purchasetype").val()==""){
        $("#purchasetype").addClass("glowing-border");
        return false;
    }
    return true;
}
function taxInvoiceValidation(){
    if($("#taxinvoice").val()==""){
        $("#taxinvoice").addClass("glowing-border");
        return false;
    }
    return true;
}
function invoicedateValidation(){
    if($("#taxinvoicedate").val()==""){
        $("#taxinvoicedate").addClass("glowing-border");
        return false;
    }
    return true;
}
function vendorValidation(){
    if($('#vendor').val()==0){
        $("#vendor").addClass("glowing-border");
        return false;
    }
    return true;
}*/
function lotNumberValiadation(){

     var error = 0;
    $('.lotNumber').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#txtLot_' + id).val() == '' ? '' : $('#txtLot_' + id).val());

        if (inv == '') {
            $("#txtLot_" + id).addClass("glowing-border");
           // alert('Select Lot No :'+id);
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
    
}

function invoicevalidation() {
    var error = 0;
    $('.invoice').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#txtInvoice_' + id).val() == '' ? '' : $('#txtInvoice_' + id).val());

        if (inv == '') {
            $("#txtInvoice_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
}

function pricevaliadtion(){
    var error = 0;
    $('.price').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#txtPrice_' + id).val() == '' ? '' : $('#txtPrice_' + id).val());

        if (inv == '') {
            $("#txtPrice_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
}
function normalBagValiadtion(){
    var error = 0;
    $('.txtNumOfNormalBag').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#txtNumOfNormalBag_' + id).val() == '' ? '' : $('#txtNumOfNormalBag_' + id).val());

        if (inv == '') {
            $("#txtNumOfNormalBag_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
}
function normalBagQtyValidation(){
    var error = 0;
    $('.txtNumOfNormalNet').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#txtNumOfNormalNet_' + id).val() == '' ? '' : $('#txtNumOfNormalNet_' + id).val());

        if (inv == '') {
            $("#txtNumOfNormalNet_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
}

function gardenValidation(){
    
     var error = 0;
    $('.garden').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#drpGarden_' + id).val() == 0 ? 0 : $('#drpGarden_' + id).val());

        if (inv == 0) {
            $("#drpGarden_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
    
    
}

function gradeValidation(){
    
     var error = 0;
    $('.grade').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#drpGrade_' + id).val() == 0 ? 0 : $('#drpGrade_' + id).val());

        if (inv == 0) {
            $("#drpGrade_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
    
    
}

function warehouseValidation(){
    
    var error = 0;
    $('.wrhouse').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#drpWarehouse_' + id).val() == 0 ? 0 : $('#drpWarehouse_' + id).val());

        if (inv == 0) {
            $("#drpWarehouse_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
    
    
}
function teagroupValidation(){
    
    
    var error = 0;
    $('.teagroup').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#drpGroup_' + id).val() == 0 ? 0 : $('#drpGroup_' + id).val());

        if (inv == 0) {
            $("#drpGroup_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
}
/**
 * only for 'SB' ,location validation.
 * 
 */

function locationValidation(){
    
    
    var error = 0;
    $('.location').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#drpLocation_' + id).val() == 0 ? 0 : $('#drpLocation_' + id).val());

        if (inv == 0) {
            $("#drpLocation_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
    
   
}


function getGrandWeight()
{
   var totalGrandWeight=0;
   $(".dtlTotalWght").each(function() {
        var totalID = $(this).attr('id');
        var purDtlId = totalID.split('_');
        var id = purDtlId[1];
        var total = ($("#DtltotalWeight_" + id).val() == "" ? 0 : $("#DtltotalWeight_" + id).val());
        totalGrandWeight = parseFloat(totalGrandWeight + parseFloat(total));
        $("#txtGrandWeight").val(totalGrandWeight);

   });
    return totalGrandWeight;
}

/*
 * @method totalBagNo()
 * @date 16-01-2016
 * 
 */
function totalBagNo()
{
   var totalAllBag=0;
   $(".dtlTotalBags").each(function() {
        var totalID = $(this).attr('id');
        var purDtlId = totalID.split('_');
        var id = purDtlId[1];
        var total = ($("#DtltotalBags_" + id).val() == "" ? 0 : $("#DtltotalBags_" + id).val());
         totalAllBag = parseInt(total) + totalAllBag;
        $("#txtTotalBags").val(totalAllBag);
        //console.log(totalAllBag);

   });
    return totalAllBag;
}
