/**
 *@14/05/2016 
 */
$(document).ready(function() {
    
   $( ".legal-menu"+$('#transactionmenu').val() ).addClass( " collapse in " );
    $( ".rawteasale").addClass( " active " );
    

    var basepath = $("#basepath").val();
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;
    var divSerialNumber =0;

    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
    });

      $("#customer").customselect();


    $("#viewStock").click(function() {

        if (showViewValidation())
        {
           
            var garden = $("#dropdown-garden").val();
            var invoice = $("#dropdown-invoice").val();
            var lot = $("#dropdown-lot").val();
            var grade = $("#dropdown-grade").val();
            var purchaseId = getPurchaseId();
            console.log("viewStock-"+purchaseId);
            console.log(purExistInTable(purchaseId));
            if (purExistInTable(purchaseId)) {
                divSerialNumber = divSerialNumber + 1;
                $("#stock_loader").show();
                $.ajax({
                    url: basepath + "rawteasale/showStockIn",
                    type: 'post',
                    data: {gardenId: garden, invoiceNum: invoice, lotNum: lot, grade: grade, divSerialNumber:divSerialNumber},
                    success: function(data) {
                                                if(data!=0){
                                                 $("#loginBox").append(data);
                                             }else{
                                                 //alert("no data--dialog-for-no-stock");
                                                 $("#stock_loader").hide();
                                                  $("#dialog-for-no-stock").dialog({
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
                        $("#stock_loader").hide();
                    },
                    error: function(e) {
                        //called when there is an error
                        console.log(e.message);
                    }
                });
            } else {
                //alert("already in table--dialog-for-id-in-table");
                                   $("#dialog-for-id-in-table").dialog({
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
        } else {
            return false;
        }
    });


    //garden drop down change event


    $("#dropdown-garden").change(function() {
        var selectedgarden = $("#dropdown-garden").val();
        $("#dropdown-garden").removeClass("glowing-border");
        $("#imgInvoice").show();
        $.ajax({
            url: basepath + "rawteasale/showInvoice",
            type: 'post',
            data: {garden: selectedgarden},
            success: function(data) {
                $("#drpInvoice").html(data);
            },
            complete: function() {
                $("#imgInvoice").hide();
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });
    });

    //garden drop down change event
//invoice dropdown change
    $(document).on('change', "#dropdown-invoice", function() {
        var selectedgarden = $("#dropdown-garden").val();
        var invoice = $("#dropdown-invoice").val();
        $("#dropdown-invoice").removeClass("glowing-border");
        $("#imgLot").show();
        $.ajax({
            url: basepath + "rawteasale/showLotNumber",
            type: 'post',
            data: {garden: selectedgarden, invoice: invoice},
            success: function(data) {
                $("#drpLot").html(data);
            },
            complete: function() {
                $("#imgLot").hide();
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });

    });

//invoice dropdown change
//lot dropdown change
    $(document).on('change', "#dropdown-lot", function() {
        var selectedgarden = $("#dropdown-garden").val();
        var invoice = $("#dropdown-invoice").val();
        var lot = $("#dropdown-lot").val();
        $("#dropdown-lot").removeClass("glowing-border");
        $("#imgGrade").show();
        $.ajax({
            url: basepath + "rawteasale/showGrade",
            type: 'post',
            data: {garden: selectedgarden, invoice: invoice, lot: lot},
            success: function(data) {
                $("#drpGrade").html(data);
            },
            complete: function() {
                $("#imgGrade").hide();
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });

    });


//lot dropdown change

    $(document).on('change', "#dropdown-grade", function() {
        $("#dropdown-grade").removeClass("glowing-border");
    });


 $(document).on('blur', ".usedBag", function() {
        var bagId = $(this).attr('id');
        var DtlId = bagId.split('_');
        var dtl_id = DtlId[1];
        //console.log("no of smplebag :"+dtl_id);
        
        if (!getValidation(dtl_id)) {
             $(this).val(0);
             $(this).addClass("glowing-border");
            getStockoutKgs(dtl_id);
            stockOutPrice(dtl_id);
            callAllTotalFunction();
            
         
        } else {
           
             getStockoutKgs(dtl_id);
             stockOutPrice(dtl_id);
             callAllTotalFunction();
             
          
        }
    });
    
     $(document).on('blur', ".rate", function() {
        var bagId = $(this).attr('id');
        var DtlId = bagId.split('_');
        var dtl_id = DtlId[1];
        //console.log("no of smplebag :"+dtl_id);
        if (getValidation(dtl_id)) {
            getStockoutKgs(dtl_id);
            stockOutPrice(dtl_id);
            
            
            callAllTotalFunction();
            
          

        } else {
            $(this).val(0);
            $(this).addClass("glowing-border");
             getStockoutKgs(dtl_id);
             stockOutPrice(dtl_id);
             
             callAllTotalFunction();
            
        }
    });
   

    $(document).on('focus', ".usedBag", function() {
        $(this).removeClass("glowing-border");
        $(this).select();
    });
    
    
    $('input[name="rateType"]:radio').click(function() {
        
        var rateType ="";
        var rate = $("input[type='radio'][name='rateType']:checked");

        if (rate.length > 0) {
             rateType = rate.val();
            if(rateType=="V"){
                $("#divVat").css("display", "block");
                $("#divCst").css("display", "none");
            }else{
                $("#divVat").css("display", "none");
                $("#divCst").css("display", "block");
            }
        }

         callAllTotalFunction();
    });
    
    $("#txtDiscountPercentage").keyup(function() {
        callAllTotalFunction();
    });

    $("#txtDeliveryChg").keyup(function() {
        callAllTotalFunction();
    });
    
    
   $("#vat").change(function(){
        callAllTotalFunction();
   });
   
    $("#cst").change(function(){
        callAllTotalFunction();
   });
   
   $("#txtRoundOff").keyup(function(){
        callAllTotalFunction() ;
   });
    

 $("#updateRawTeaSale").click(function() {

        if (!validation()) {

            $("#dialog-validation-save").dialog({
                resizable: false,
                height: 140,
                modal: true,
                buttons: {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                }
            });


            return false;
        } else {
            var formData = $("#frmEditRawTeaSale").serialize();
            formData = decodeURI(formData);
            $.ajax(
                    {
                        type: 'POST',
                        dataType: 'json',
                        url: basepath + "rawteasale/updateRawTeaSale",
                        data: {formDatas: formData},
                        success: function(data) {

                            if (data == 1) {
                                $("#dialog-new-save").dialog({
                                    resizable: false,
                                    height: 140,
                                    modal: true,
                                    buttons: {
                                        "Ok": function() {
                                            window.location.href = basepath + 'rawteasale';
                                            $(this).dialog("close");
                                        }
                                    }
                                });
                            } else {
                                $("#dialog-error-save").dialog({
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
        }

    });
    
      $(document).on('keyup', '.rate', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });


})
// document load
function showViewValidation() {
    var garden = $("#dropdown-garden").val();
    var invoice = $("#dropdown-invoice").val();
    var lot = $("#dropdown-lot").val();
    var grade = $("#dropdown-grade").val();

    if (garden == 0) {
        $("#dropdown-garden").addClass("glowing-border");
        return false;
    }
    if (invoice == 0) {
        $("#dropdown-invoice").addClass("glowing-border");
        return false;
    }
    if (lot == 'ALL') {
        $("#dropdown-lot").addClass("glowing-border");
        return false;
    }
    if (grade == 0) {
        $("#dropdown-grade").addClass("glowing-border");
        return false;
    }
    return true;
}

function getPurchaseId() {
    var garden = $("#dropdown-garden").val();
    var invoice = $("#dropdown-invoice").val();
    var lot = $("#dropdown-lot").val();
    var grade = $("#dropdown-grade").val();
    var basepath = $("#basepath").val();

$.extend({
    xResponse: function(url, data) {
        // local var
        var theResponse = null;
        // jQuery ajax
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: "html",
            async: false,
            success: function(respText) {
                theResponse = respText;
            }
        });
        // Return the response text
        return theResponse;
    }
});
 
var xData = $.xResponse(basepath + "rawteasale/purchaseExist", {gardenId: garden, invoiceNum: invoice, lotNum: lot, grade: grade}); 
// see response in console
console.log(xData);
return xData;
}


function purExistInTable(id) {
var flag=0;
    $('input[name="txtpurchaseDtl[]"]').each(function() {
        //alert($(this).val());
        console.log("id--:" + $(this).val());
        if ($(this).val() == id) {
           flag=1;
        }
    });
    if(flag==1){
       return false; 
    }
    else{
       return true; 
    }
    
}


function getValidation(dtlId) {
    var numberofBag = parseInt($("#NumberOfBags_" + dtlId).val());
    var blendBag = ($("#txtused_" + dtlId).val() == "" ? 0 : parseInt($("#txtused_" + dtlId).val()));
    //console.log("nu "+numberofBag+":"+blendBag);
    if (blendBag > numberofBag) {
        return false;
    } else {
        return true;
    }
}

/*function getValidation(dtlId) {
    var numberofBag = parseInt($("#NumberOfBags_" + dtlId).val());
    var hiddenBlendedBag = parseInt($("#hdTxtBlended_" + dtlId).val() == "" ? 0 : parseInt($("#hdTxtBlended_" + dtlId).val()));
    var stockQuantity = parseInt(numberofBag + hiddenBlendedBag);
    var blendBag = ($("#txtused_" + dtlId).val() == "" ? 0 : parseInt($("#txtused_" + dtlId).val()));
    //console.log("nu "+numberofBag+":"+blendBag);
    if (blendBag > stockQuantity) {
        $("#dialog-out-stock").dialog({
            resizable: false,
            height: 140,
            modal: true,
            buttons: {
                "Ok": function() {
                    $(this).dialog("close");
                }
            }
        });

        return false;
    } else {
        return true;
    }
}*/

function getValidation(dtlId) {
    var numberofBag = parseInt($("#NumberOfBags_" + dtlId).val());
    var hiddenBlendedBag = parseInt($("#hdTxtBlended_" + dtlId).val() == "" ? 0 : parseInt($("#hdTxtBlended_" + dtlId).val()));
    var stockQuantity = parseInt(numberofBag + hiddenBlendedBag);
    var blendBag = ($("#txtused_" + dtlId).val() == "" ? 0 : parseInt($("#txtused_" + dtlId).val()));
    //console.log("nu "+numberofBag+":"+blendBag);
    if (blendBag > stockQuantity) {
        $("#dialog-out-stock").dialog({
            resizable: false,
            height: 140,
            modal: true,
            buttons: {
                "Ok": function() {
                    $(this).dialog("close");
                }
            }
        });

        return false;
    } else {
        return true;
    }
}


function validation() {

    if (!rawteasaleDateValidation()) {
        return false;
    }
    if (!customerValidation()) {
        return false;
    }
    
   if(!blendDtlValidation()){
        $("#dialog-for-noDtl").dialog({
                                    resizable: false,
                                    height: 140,
                                    modal: true,
                                    buttons: {
                                        "Ok": function() {
                                            
                                            $(this).dialog("close");
                                        }
                                    }
                                });
        return false;
    }
    
    return true;
}


function customerValidation(){
    var customer = $("#customer").val();
    if(customer=="0"){
        $("#customer_err").css("display","block");
        return false;
    }
    else{
        return true;
    }
    
}

/**
 * 
 * @returns {undefined}
 */
function blendDtlValidation(){
    var totalBlend=0;
    totalBlend =$('input[name="txtpurchaseDtl[]"]').length;
    if(totalBlend>0){
        return true;
    }else{
        return false;
    }
}

function rawteasaleDateValidation() {
    var saleDt = $("#saleDt").val();
    if (saleDt == "") {
        $("#saleDt").addClass("glowing-border");
        return false;
    }
    return true;
}


function getStockoutKgs(dtlId) {
    var blendedKgs = 0;
    var netInBag = parseFloat($("#hdnetBag_" + dtlId).val() == "" ? 0 : $("#hdnetBag_" + dtlId).val());
    var blendedBag = parseFloat($("#txtused_" + dtlId).val() == "" ? 0 : ($("#txtused_" + dtlId).val()));
    blendedKgs = parseFloat(netInBag * blendedBag).toFixed(2);
    //console.log("bl: "+blendedKgs);
    $("#txtBlendKg_" + dtlId).val(blendedKgs);


}
function stockOutPrice(id){
    var sale_price=0;
    /*var rate = $("#hdpriceperbag_"+id).val();*/
    var rate = ($("#txtrate_"+id).val()==""?0:$("#txtrate_"+id).val());
   // var usedBag = ($("#txtused_"+id).val()==""?0:$("#txtused_"+id).val());
    var saleKg = ($("#txtBlendKg_"+id).val()==""?0:$("#txtBlendKg_"+id).val());
    
    sale_price = parseFloat(rate) * parseFloat(saleKg);
    
    $("#txtBlendedPrice_"+id).val(sale_price.toFixed(2));
    console.log(sale_price);
    return true;
}
function deleteTable(divnumber){
    var div = "#stockDetail_"+divnumber;
    if(divnumber!=""){
        $(div).remove();
        
        callAllTotalFunction();
        
       /* getTotalSaleOutBag();
        getTotalSalePrice();
        getTotalSaleOutKgs();
        //getAverageBlendedPrice();*/
    }
}


///******************************** Total Calculation  *******************************///


function callAllTotalFunction() {
    getTotalSaleOutBag();
    getTotalSaleOutKgs();
    getTotalSalePrice();
    getDiscountAmount();
    getTaxAmount();
    getGrandTotal();

}

function getTotalSaleOutBag(){
    var totalSaleBag=0;
    
     $('input[name^="txtused"]').each(function() {
        var bag = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalSaleBag =parseFloat(totalSaleBag + bag);
        //console.log("totalBlendedBag "+i+":"+bag);
        //i++;
    });
     $("#txtTotalSaleBag").val((totalSaleBag));
   // return false;
   return totalSaleBag;
    
}
function getTotalSalePrice(){
    
    var totalSalePrice=0;
    
     $('input[name^="txtBlendedPrice"]').each(function() {
        var bag = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalSalePrice =parseFloat(totalSalePrice + bag);
        //console.log("totalBlendedBag "+i+":"+bag);
        //i++;
    });
     $("#txtTotalSalePrice").val((totalSalePrice).toFixed(2));
    //return false;
    return totalSalePrice.toFixed(2);
}
function getTotalSaleOutKgs(){
    
    var totalsaleOutKgs=0;
    
     $('input[name^="txtBlendKg"]').each(function() {
        var bag = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalsaleOutKgs =parseFloat(totalsaleOutKgs + bag);
        //console.log("totalBlendedBag "+i+":"+bag);
        //i++;
    });
     $("#txtSaleOutKgs").val((totalsaleOutKgs).toFixed(2));
   // return false;
   return totalsaleOutKgs.toFixed(2);
}



function getTotalAmount() {
    var totalAmount = 0;
    var amount = 0;
    $('input[name^="txtBlendedPrice"]').each(function() {
        amount = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalAmount = parseFloat(totalAmount + amount);
        //console.log("totalBlendedBag "+i+":"+bag);
        //i++;
    });
   // $("#txtTotalAmount").val(totalAmount.toFixed(2));
    return totalAmount.toFixed(2);

}

function getDiscountAmount() {
    var totalamount = 0;
    var discountRate = 0;
    var discountAmount = 0;
    totalamount = parseFloat(getTotalAmount());
    discountRate = parseFloat($("#txtDiscountPercentage").val() == "" ? 0 : $("#txtDiscountPercentage").val());

    discountAmount = parseFloat((totalamount * discountRate) / 100);

    $("#txtDiscountAmount").val(discountAmount.toFixed(2));

    return discountAmount.toFixed(2);

}


/**
 * @name getTaxAmount
 * @returns {undefined}
 * @description vatrate or cstrate on tax
 */
function getTaxAmount() {
    var TaxRate = 0;
    var discountAmount = 0;
    var deliveryChgs=0;
    var amountAfterDiscount = 0;
    var totalAmount = 0;
    var TaxAmount = 0;
    var rateType = "";
    var rate = $("input[type='radio'][name='rateType']:checked");

    if (rate.length > 0) {
        rateType = rate.val();
    }
    if (rateType == "V") {
        TaxRate =parseFloat($("#vat option:selected").text()=='Select'?0:$("#vat option:selected").text());
    } else {
        TaxRate =parseFloat($("#cst option:selected").text()=='Select'?0:$("#cst option:selected").text());
    }
    deliveryChgs=parseFloat($("#txtDeliveryChg").val()==""?0:$("#txtDeliveryChg").val());
    totalAmount = parseFloat(getTotalAmount());
    discountAmount = parseFloat(getDiscountAmount());
    amountAfterDiscount = parseFloat(totalAmount - discountAmount + deliveryChgs);
    TaxAmount = parseFloat((amountAfterDiscount * TaxRate) / 100);

    $("#txtTaxAmount").val(TaxAmount.toFixed(2));

    return TaxAmount.toFixed(2);
}



function getGrandTotal(){
    var totalAmount=0;
    var discountAmount=0;
    var deliveryChgs=0;
    var taxAmount =0;
    var roundoff =0;
    var grandTotal =0 ;
    
    totalAmount = parseFloat(getTotalAmount());
    discountAmount =parseFloat(getDiscountAmount());
    taxAmount = parseFloat(getTaxAmount());
    roundoff = parseFloat($("#txtRoundOff").val()==""?0:$("#txtRoundOff").val());

    deliveryChgs=parseFloat($("#txtDeliveryChg").val()==""?0:$("#txtDeliveryChg").val());
    
    grandTotal = parseFloat(((totalAmount - discountAmount + deliveryChgs)+ taxAmount)+(roundoff));
    
    $("#txtGrandTotal").val(grandTotal.toFixed(2));
    return grandTotal.toFixed(2);
    
    
}



function deleterecord(id)
		{
                    var a = confirm("Do you want to Delete");
                    if(a==true){
			var basepath =  $("#basepath").val();
			$.ajax({
			type: "POST",
			url:  basepath+"stocktransferout/delete",
			data: {id: id},
			success: function(data)
				{
				window.location.href = basepath+'stocktransferout';
				}

     	});
    }
    else{
        return false;
    }
   
    
}       