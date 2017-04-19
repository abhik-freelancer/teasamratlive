/**
 *@add blending [addBlendingJS.js]
 *@08/09/2015 
 */
$(document).ready(function() {

    var basepath = $("#basepath").val();
    var divSerialNumber=0;
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;

    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
    });




    $(document).on('blur', ".usedBag", function() {
        var bagId = $(this).attr('id');
        var DtlId = bagId.split('_');
        var dtl_id = DtlId[1];

        if (!getValidation(dtl_id)) {
            $(this).val(0);
            $(this).addClass("glowing-border");
            getBlendedKgs(dtl_id);
            blendePrice(dtl_id);
            
            getTotalBlendedBag();
            getTotalBlendedPrice();
            getTotalBlendedWeight();
            getAverageBlendedPrice();

        }
        else {
            getBlendedKgs(dtl_id);
            blendePrice(dtl_id);
            getTotalBlendedBag();
            getTotalBlendedPrice();
            getTotalBlendedWeight();
            getAverageBlendedPrice();

        }
    });

    $(document).on('focus', ".usedBag", function() {
        $(this).removeClass("glowing-border");
        $(this).select();
    });
    //area for search drop down event-11/10/2015
    //garden drop down change event
    $("#dropdown-garden").change(function() {
        var selectedgarden = $("#dropdown-garden").val();
        $("#dropdown-garden").removeClass("glowing-border");
        $.ajax({
            url: basepath + "stocktransferout/showInvoice",
            type: 'post',
            data: {garden: selectedgarden},
            success: function(data) {
                $("#drpInvoice").html(data);
            },
            complete: function() {
                //$("#stock_loader").hide();
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });
    });
    //garden dropdown
    
    //invoice dropdown change
    $(document).on('change', "#dropdown-invoice", function() {
        var selectedgarden = $("#dropdown-garden").val();
        var invoice = $("#dropdown-invoice").val();
        $("#dropdown-invoice").removeClass("glowing-border");
        $.ajax({
            url: basepath + "stocktransferout/showLotNumber",
            type: 'post',
            data: {garden: selectedgarden, invoice: invoice},
            success: function(data) {
                $("#drpLot").html(data);
            },
            complete: function() {
                //$("#stock_loader").hide();
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
        $.ajax({
            url: basepath + "stocktransferout/showGrade",
            type: 'post',
            data: {garden: selectedgarden, invoice: invoice, lot: lot},
            success: function(data) {
                $("#drpGrade").html(data);
            },
            complete: function() {
                //$("#stock_loader").hide();
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

  //area for search event drop down -11/10/2015
  
   $("#viewStock").click(function() {

        if (showViewValidation())
        {
           
            var garden = $("#dropdown-garden").val();
            var invoice = $("#dropdown-invoice").val();
            var lot = $("#dropdown-lot").val();
            var grade = $("#dropdown-grade").val();
            var purchaseId = getPurchaseId();
            //console.log("viewStock-"+purchaseId);
           // console.log(purExistInTable(purchaseId));
            if (purExistInTable(purchaseId)) {
                divSerialNumber = divSerialNumber + 1;
                $("#stock_loader").show();
                $.ajax({
                    url: basepath + "stocktransferout/showStockIn",
                    type: 'post',
                    data: {gardenId: garden, invoiceNum: invoice, lotNum: lot, grade: grade, divSerialNumber:divSerialNumber},
                    success: function(data) {
                        $(".blendDtl").append(data);
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
/////view stock end//////////////////////////
    $("#updateBlend").click(function() {

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
            var formData = $("#frmEditStockOut").serialize();
            formData = decodeURI(formData);
            $.ajax(
                    {
                        type: 'POST',
                        dataType: 'json',
                        url: basepath + "stocktransferout/updateStockTransferOut",
                        data: {formDatas: formData},
                        success: function(data) {

                            if (data == 1) {
                                $("#dialog-new-save").dialog({
                                    resizable: false,
                                    height: 140,
                                    modal: true,
                                    buttons: {
                                        "Ok": function() {
                                            window.location.href = basepath + 'stocktransferout';
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
 
var xData = $.xResponse(basepath + "blending/purchaseExist", {gardenId: garden, invoiceNum: invoice, lotNum: lot, grade: grade}); 
// see response in console
console.log(xData);
return xData;
}

/////////////////////////
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

    if (!RefrenceNoValidation()) {
        return false;
    }
    if (!transferDateValidation()) {
        return false;
    }
    if (!vendorValidation()) {
        return false;
    }
     return true;
}

function RefrenceNoValidation() {
    var refrenceNo = $("#refrence_no").val();
    if (refrenceNo == "") {
        $("#refrence_no").addClass("glowing-border");
        return false;
    }
    return true;
}

function transferDateValidation() {
    var transferDt = $("#transferDt").val();
    if (transferDt == "") {
        $("#transferDt").addClass("glowing-border");
        return false;
    }
    return true;
}
function vendorValidation() {
    var vendor = $("#vendor").val();
    if (vendor == "0") {
        $("#vendor_err").css("display","block");
        return false;
    }
    return true;
}

function getBlendedKgs(dtlId) {
    var blendedKgs = 0;
    var netInBag = parseFloat($("#hdnetBag_" + dtlId).val() == "" ? 0 : $("#hdnetBag_" + dtlId).val());
    var blendedBag = parseFloat($("#txtused_" + dtlId).val() == "" ? 0 : ($("#txtused_" + dtlId).val()));
    blendedKgs = parseFloat(netInBag * blendedBag).toFixed(2);
    //console.log("bl: "+blendedKgs);
    $("#txtBlendKg_" + dtlId).val(blendedKgs);


}
function blendePrice(id){
    var blended_price=0;
    var rate = $("#hdpriceperbag_"+id).val();
    var usedBag = ($("#txtused_"+id).val()==""?0:$("#txtused_"+id).val());
    
    blended_price = parseFloat(rate) * parseFloat(usedBag);
    
    $("#txtBlendedPrice_"+id).val(blended_price);
    console.log(blended_price);
    return true;
}



function getTotalBlendedBag() {
    var totalBlendedBag = 0;
    //var i=1;
    $('input[name^="txtused"]').each(function() {
        var bag = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalBlendedBag =parseFloat(totalBlendedBag + bag);
        //console.log("totalBlendedBag "+i+":"+bag);
        //i++;
    });
    
    $("#txtTotalstockOutBag").val((totalBlendedBag).toFixed(2));
    //return false;
    return totalBlendedBag;
}
function getTotalBlendedPrice(){
    
    var totalBlendedPrice=0;
    
     $('input[name^="txtBlendedPrice"]').each(function() {
        var bag = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalBlendedPrice =parseFloat(totalBlendedPrice + bag);
        //console.log("totalBlendedBag "+i+":"+bag);
        //i++;
    });
     $("#txtTotalStockPrice").val((totalBlendedPrice).toFixed(2));
   // return false;
   return totalBlendedPrice;
}


function getTotalBlendedWeight(){
    var totalBlendKg =0 ;
     $('input[name^="txtBlendKg"]').each(function() {
        var bagKg = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalBlendKg =parseFloat(totalBlendKg + bagKg);
    });
    $("#txtTotalstockOutKgs").val((totalBlendKg).toFixed(2));
    return false;
    
}

function getAverageBlendedPrice(){
   var totalBlendedPrice = 0;
    var totalBlendedBags = 0;
    var avgBlendedPrice = 0;
    
     totalBlendedPrice= getTotalBlendedPrice();
     totalBlendedBags = getTotalBlendedBag();
     if(totalBlendedBags!=0){
      avgBlendedPrice = (totalBlendedPrice)/(totalBlendedBags);
     
     
  
       $("#txtTotalAvgPrice").val((avgBlendedPrice).toFixed(2));
   }
   else{
       $("#txtTotalAvgPrice").val('0.00');
   }
   
       return false;
    
    
     
}

function deleteTable(divnumber){
    var div = "#stockDetail_"+divnumber;
    if(divnumber!=""){
        $(div).remove();
    }
    getTotalBlendedPrice();
    getTotalBlendedBag();
    getTotalBlendedWeight();
    getAverageBlendedPrice();
}

/**
 * @method checkNumeric
 * @param {type} obj
 * @returns {Boolean}
 * @description Check input value int or not.
 */
function checkNumeric(obj)
{
    var regex = new RegExp(/^[0-9]+$/);
    if (obj.value.match(regex))
    {
        return true;
    }
    obj.value = "";
    return false;
}


///*********************************


        