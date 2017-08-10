
$(document).ready(function() {
    $(".legal-menu" + $('#transactionmenu').val()).addClass(" collapse in ");
    $(".rawmaterialpurchase").addClass(" active ");
    
    

    var basepath = $("#basepath").val();
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;
    var divSerialNumber = 0;

    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
    });
 $("#vendor").customselect();

    $("#addnewDtlDiv").click(function() {
        divSerialNumber = divSerialNumber + 1;
        $.ajax({
            url: basepath + "gstservicepurchase/gstcreateDetails",
            type: 'post',
            data: {divSerialNumber: divSerialNumber},
            success: function(data) {
                $(".rawmaterialDtlview").append(data);
            },
            complete: function() {
                // $("#stock_loader").hide();
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });
    });
   
   $("#saveRawMaterial").click(function(){

      if(getValidation()){
            if(detailvalidation()){
        
           var formData = $("#frmRawMaterial").serialize();
           var mode=$("#txtModeOfoperation").val();
           var rawmatpurchaseMastId = $("#rawmatPurcMastid").val();
         //  var basepath = $("#basepath").val();
           
           formData = decodeURI(formData);
           $.ajax({
            url: basepath + "gstservicepurchase/GSTsaveData",
            type: 'post',
            data: {formDatas: formData,mode:mode,rawmatpurchaseMastId:rawmatpurchaseMastId},
            success: function(data) {
               if(data==1){
                    $("#rawmaterial_save_dialg").dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                     window.location.href = basepath + 'gstservicepurchase';
                                                    $( this ).dialog( "close" );
                                                    
                                                }
                                              }
                                            });
                }else{
                    alert("Something going wrong in save..");
                }
               
            },
             complete: function(data) {
               
                 
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });
         
            }
            else{
                
            }
      }else{
          
      }
       
   });




    $(document).on('keyup', ".pacQty", function() {
        var packetId = $(this).attr('id');
        var detailIdarr = packetId.split('_');
        var master_id = detailIdarr[1];
        var detail_id = detailIdarr[2];

        getAmount(master_id, detail_id);
        callAllTotalFunction();
       
    });

  


    $(document).on('keyup', ".rate", function() {
        var netId = $(this).attr('id');
        var detailIdarr = netId.split('_');
        var master_id = detailIdarr[1];
        var detail_id = detailIdarr[2];

        getAmount(master_id, detail_id);
        callAllTotalFunction();

    });

    $(document).on('change', ".productlist", function() {
        
        var productId=$(this).val();
        
        
        var id = $(this).attr('id');
        var detailIdarr = id.split('_');
        var master_id = detailIdarr[1];
        var detail_id = detailIdarr[2];
        var txtRateId="#txtDetailRate_"+master_id+"_"+detail_id;
        $.ajax({
            url :  basepath + "rawmaterialpurchase/get_product_rate",
            type: "POST",
            data : {productId:productId},
            success: function(data)
            {
               $(txtRateId).val(data);                //data - response from server
            },
            error: function (e)
            {
                 console.log(e.message);
            }
        });    
    });
    
    $(document).on('change', ".excise", function() {
         // var exciseId=$(this).val();
           calculateExcise();
      
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
    
     $("#excise").change(function(){
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

    $(document).on('click', ".del", function() {
        var netId = $(this).attr('id');
        var detailIdarr = netId.split('_');
        var master_id = detailIdarr[1];
        var detail_id = detailIdarr[2];

        //console.log("divID :"+master_id+"-"+detail_id);
        var div_identification_id = "#rawmaterialDetails_"+master_id+"_"+detail_id;
        $(div_identification_id).empty();
        
        getAmount(master_id, detail_id);
        callAllTotalFunction();

    });


$(document).on('keyup', '.rate', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        }
        var selectorid = $(this).attr("id");
        var arr = selectorid.toString().split("_");
        resetGstTax(arr[1],arr[2]);

    });

$(document).on('keyup', '.pacQty', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 
        var selectorid = $(this).attr("id");
        var arr = selectorid.toString().split("_");
        resetGstTax(arr[1],arr[2]);

    });

$(document).on('blur','.discamount',function(){
    
    var selectorId = $(this).attr("id");
    getTaxableamount($(this).val(),selectorId);
    callAllTotalFunction();
    
       
    
});

// GST event 
$(document).on('change','.cgst',function(){
    console.log($(this).attr("id"));
    var cgstRateId = $(this).val();
    var amt = getGSTTaxAmount(cgstRateId,$(this).attr("id"),"CGST");
    var arr = $(this).attr("id").toString().split("_");
    var masterId =arr[1];
    var detailId = arr[2]; 
    var str2 = ("#cgstAmt"+"_"+masterId+"_"+detailId);
    $(str2).val(amt.toFixed(2));
    //getTotalCGST();
    callAllTotalFunction();
});

//sgst
$(document).on('change','.sgst',function(){
    console.log($(this).attr("id"));
    var sgstRateId = $(this).val();
    var amt = getGSTTaxAmount(sgstRateId,$(this).attr("id"),"SGST");
    var arr = $(this).attr("id").toString().split("_");
    var masterId =arr[1];
    var detailId = arr[2]; 
    var str2 = ("#sgstAmt"+"_"+masterId+"_"+detailId);
    $(str2).val(amt.toFixed(2));
    //getTotalSGST();
    callAllTotalFunction();
});

//IGST
$(document).on('change','.igst',function(){
    console.log($(this).attr("id"));
    var igstRateId = $(this).val();
    var amt = getGSTTaxAmount(igstRateId,$(this).attr("id"),"IGST");
    var arr = $(this).attr("id").toString().split("_");
    var masterId =arr[1];
    var detailId = arr[2]; 
    var str2 = ("#igstAmt"+"_"+masterId+"_"+detailId);
    $(str2).val(amt.toFixed(2));
       // getTotalIGST();
       callAllTotalFunction();
});





});

//******************************User Defined Function for rawmaterialPurchase ******************************//
function resetGstTax(masterId,detailId){
   var disStr = ("#txtDiscount"+"_"+masterId+"_"+detailId);
   $(disStr).val("");
   var taxableStr =("#txtTaxableAmt"+"_"+masterId+"_"+detailId);
   $(taxableStr).val("");
     
    var str1 = ("#cgst"+"_"+masterId+"_"+detailId);
    $(str1).val("0");
    var str2 = ("#cgstAmt"+"_"+masterId+"_"+detailId);
    $(str2).val("");
    
    var str3 = ("#sgst"+"_"+masterId+"_"+detailId);
    $(str3).val("0");
    var str4 = ("#sgstAmt"+"_"+masterId+"_"+detailId);
    $(str4).val("");
    
    var str5 = ("#igst"+"_"+masterId+"_"+detailId);
    $(str5).val("0");
    var str6 = ("#igstAmt"+"_"+masterId+"_"+detailId);
    $(str6).val("");
    callAllTotalFunction();
    
}

/**
 * @author Abik Ghosh<amiabhik@gmail.com>
 * @param {type} gstId
 * @param {type} jQueryId
 * @param {type} type
 * @returns {Number}
 */
function getGSTTaxAmount(gstId,jQueryId,type){
    var gstRateId = gstId;
    var arr = jQueryId.toString().split("_");
    var masterId =arr[1];
    var detailId = arr[2]; 
    var str2 = ("#txtTaxableAmt"+"_"+masterId+"_"+detailId);
    var taxableAmount = $(str2).val()||0;
    var basepath = $("#basepath").val();
    
    var taxAmount = 0;
    //console.log(basepath + "GSTtaxinvoice/getAmount");
    $.ajax({
            url :  basepath + "rawmaterialpurchase/getAmount",
            type: "POST",
            dataType:'json',
            data : {gstId:gstRateId,taxableamount:taxableAmount,type:type},
    success: function(result) {
       
      taxAmount =result.amt ;
    },
    async:false
  });
    
   
   return taxAmount;  
    
}
/**
 * @author Abhik Ghosh<amiabhik@gmail.com>
 * @param {type} values
 * @param {type} selectorId
 * @returns {undefined}
 */
function getTaxableamount(values,selectorId){
    var arr = selectorId.toString().split("_");
    var masterId =arr[1];
    var detailId = arr[2];
    var itemTotalAmt =0;
    var taxableAmount =0;
    
    var str = ("#txtDetailAmount"+"_"+masterId+"_"+detailId);
    itemTotalAmt = $(str).val()||0;
    
    taxableAmount = parseFloat(itemTotalAmt) - parseFloat(values||0);
    var str2 = ("#txtTaxableAmt"+"_"+masterId+"_"+detailId);
    $(str2).val(taxableAmount.toFixed(2));
    
}




function callAllTotalFunction() {
   
    getTotalQty();
    getTotalAmount();
    getGSTSummation();
    totalDiscountAmount();
    getTaxAmount();
    totalTaxIncludedAmount();
    getGrandTotal();

}

function totalDiscountAmount(){
       var totalDiscountamount=0;
       $(".discamount").each(function(){
           totalDiscountamount = totalDiscountamount + parseFloat($(this).val()||0);
       });
       $("#txtDiscountAmount").val(totalDiscountamount.toFixed(2)); 
       return totalDiscountamount;
     
    }
function getGSTSummation(){
    var cgstamount =0;
    $(".cgstAmt").each(function(){
        cgstamount = cgstamount + parseFloat($(this).val()||0);
    });
    $("#txtTotalCGST").val(cgstamount.toFixed(2));
    
    var sgstamount = 0;
    $(".sgstAmt").each(function(){
        sgstamount = sgstamount + parseFloat($(this).val()||0);
    });
    $("#txtTotalSGST").val(sgstamount.toFixed(2));
    
    var igstamount = 0;
    $(".igstAmt").each(function(){
        igstamount = igstamount + parseFloat($(this).val()||0);
    });
    $("#txtTotalIGST").val(igstamount.toFixed(2));
    
}  

function totalTaxIncludedAmount(){
    var taxableAmount = $("#txtTaxAmount").val()||0;
    var cgstamount =  $("#txtTotalCGST").val()||0;
    var sgstamount = $("#txtTotalSGST").val()||0;
    var igstamount = $("#txtTotalIGST").val()||0;
    
    var totalTaxIncludedAmount = parseFloat(taxableAmount)+ parseFloat(cgstamount) + parseFloat(sgstamount) + parseFloat(igstamount);
    $("#txtTotalIncldTaxAmt").val(totalTaxIncludedAmount.toFixed(2));
    console.log("totalTaxIncludedAmount :"+totalTaxIncludedAmount);
    return totalTaxIncludedAmount;
    
}



/*

function getExciseRate() {
     var exciseId=$(".excise").val()||0;
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
 
var xData = $.xResponse(basepath + "rawmaterialpurchase/get_exciserate_rate", {exciseId: exciseId}); 
// see response in console
console.log(xData);
return xData;
}

*/



function detailvalidation (){

      if(!getProductValidation()){
        $( "#rawmaterial_save_dialg_detail" ).dialog({
                            modal: true,
                               buttons: {
                           Ok: function() {
                             $( this ).dialog( "close" );
                           }
                         }
                       }); 
        return false;
     }
     if(!getServiceAccountValidation()){
         
          $( "#rawmaterial_save_dialg_detail" ).dialog({
                            modal: true,
                               buttons: {
                           Ok: function() {
                             $( this ).dialog( "close" );
                           }
                         }
                       }); 
            return false;           
     }
     if(!getQtyValidation()){
        $( "#rawmaterial_save_dialg_detail" ).dialog({
                            modal: true,
                               buttons: {
                           Ok: function() {
                             $( this ).dialog( "close" );
                           }
                         }
                       }); 
        return false;
     }
      if(!getRateValidation()){
        $( "#rawmaterial_save_dialg_detail" ).dialog({
                            modal: true,
                               buttons: {
                           Ok: function() {
                             $( this ).dialog( "close" );
                           }
                         }
                       }); 
        return false;
     }
     return true;
    
}
/*
function getExciseAmt(){
        var exciseRate=0;
        var itemamount=0;
        var exciseamt=0;
        var exciamtresult=0;
        
        itemamount=parseFloat($("#txtTotalAmount").val());
       
        exciseRate=parseFloat($("#exiceRate").val());
       
       exciseamt=parseFloat(itemamount * exciseRate);
       exciamtresult=parseFloat(exciseamt/100);
       // exciseamt=parseFloat((itemamount*exciseRate)/100);
       // alert(exciamtresult);
        $("#exciseAmt").val(exciamtresult.toFixed(2));
       // alert(exciseamt);
        return exciamtresult;
}
*/

/**
 * @function getAmount
 * @param {type} masterId
 * @param {type} detailId
 * @returns {getAmount.amount|Number}
 */
function getAmount(masterId, detailId) {
    var amount = 0;
    var rate = 0;
    var quantity = 0;
    rate = parseFloat($("#txtDetailRate_" + masterId + "_" + detailId).val() == "" ? 0 : $("#txtDetailRate_" + masterId + "_" + detailId).val());
    quantity = parseFloat($("#txtDetailQuantity_" + masterId + "_" + detailId).val() == "" ? 0 : $("#txtDetailQuantity_" + masterId + "_" + detailId).val());

    amount = parseFloat(rate * quantity);

    $("#txtDetailAmount_" + masterId + "_" + detailId).val(amount.toFixed(2));

    return amount.toFixed(2);
}

function getTotalQty() {
    var totalQty = 0;
    var net = 0;

    $('input[name^="txtDetailQuantity"]').each(function() {
        net = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalQty = parseFloat(totalQty + net);
        //console.log("totalBlendedBag "+i+":"+bag);
        //i++;
    });
    $("#txtTotalQty").val(totalQty.toFixed(2));
    return totalQty;

}
function getTotalAmount() {
    var totalAmount = 0;
    var amount = 0;
    $('input[name^="txtDetailAmount"]').each(function() {
        amount = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalAmount = parseFloat(totalAmount + amount);
        //console.log("totalBlendedBag "+i+":"+bag);
        //i++;
    });
    $("#txtTotalAmount").val(totalAmount.toFixed(2));
    return totalAmount.toFixed(2);

}

function getTaxAmount() {
  
    var taxableamount =0;
    $(".taxableamount").each(function(){
        
        taxableamount = taxableamount + parseFloat($(this).val()||0);
    });
    $("#txtTaxAmount").val(taxableamount.toFixed(2))
    return taxableamount.toFixed(2);
}
/**
 * @get grand total
 * @returns {decimal}
 */
function getGrandTotal(){
    var totalGSTIncludedamount=0;
   
    var roundoff=0;
    var grandTotal = 0;
    
    //roundoff = parseFloat($("#txtRoundOff").val()==""?0:$("#txtRoundOff").val());
    
    totalGSTIncludedamount = parseFloat(totalTaxIncludedAmount());
    grandTotal = (parseFloat(totalGSTIncludedamount) + roundoff);
    
    $("#txtInvoiceValue").val(grandTotal.toFixed(2));
    return grandTotal.toFixed(2);
  
}



function getProductValidation (){
    
    var selectedproduct;
    var flag=0;
     $('select[name^="productlist"]').each(function() {
         
        selectedproduct = parseFloat(($(this).val() == 0 ? 0 : $(this).val()));
       //console.log(selectedproduct);
        if(selectedproduct==0){
            flag=1;
        }
        
    });
    if(flag==1){
        return false;
    }else{
            return true;  
    }
 }
 
 function getServiceAccountValidation(){
     
    var selectedproduct;
    var flag=0;
     $('select[name^="account"]').each(function() {
         
        selectedproduct = parseFloat(($(this).val() == 0 ? 0 : $(this).val()));
       //console.log(selectedproduct);
        if(selectedproduct==0){
            flag=1;
        }
        
    });
    if(flag==1){
        return false;
    }else{
            return true;  
    }
     
     
 }
 
 
 
 function getQtyValidation(){
      var flag=0;
      $('input[name^="txtDetailQuantity"]').each(function() {
         
      
        var quantity = ($(this).val() == ""||0.00? "" : $(this).val());
      // console.log("not a number"+quantity);
        if(quantity==""){
            flag=1;
        }
        
    });
    if(flag==1){
        return false;
    }else{
            return true;  
    }
 }
  function getRateValidation(){
      var flag=0;
      $('input[name^="txtDetailRate"]').each(function() {
         
        var rate = ($(this).val() == ""||0.00? "" : $(this).val());
      // console.log(rate);
        if(rate==""){
            flag=1;
        }
        
    });
    if(flag==1){
        return false;
    }else{
            return true;  
    }
 }

/*
 * master Validation
 * @returns {Boolean}
 */

function getValidation(){
    var invoiceNo = $("#invoiceno").val();
    var invoicedate = $("#invoicedate").val();
    var vendor = $("#vendor").val();
    
   if(invoiceNo==""){
        $("#invoiceno").addClass("glowing-border");
         return false;
   }
   if(invoicedate==""){
        $("#invoicedate").addClass("glowing-border");
         return false;
   }
   if(vendor==0){
    $(".custom-select").addClass("glowing-border");
         return false;
   }
    
   else{
       return true;
   }
}