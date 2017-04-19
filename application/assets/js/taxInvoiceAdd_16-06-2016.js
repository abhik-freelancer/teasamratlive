/**
 *@add blending [addBlendingJS.js]
 *@08/09/2015 
 */
$(document).ready(function() {
    $(".legal-menu" + $('#transactionmenu').val()).addClass(" collapse in ");
    $(".finishproduct").addClass(" active ");

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
    
    /*added by mithilesh on 09-03-2016*/
 $("#saleBillDate").change(function(){
     var saleBilldate = $("#saleBillDate").val();
     $("#taxInvoiceDate").val(saleBilldate);
 });/*----end--*/

    $("#addnewDtlDiv").click(function() {
        divSerialNumber = divSerialNumber + 1;
        $.ajax({
            url: basepath + "taxinvoice/createDetails",
            type: 'post',
            data: {divSerialNumber: divSerialNumber},
            success: function(data) {
                $(".salebillDtl").append(data);
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
   
   $("#saveSaleBill").click(function(){
      
      if(getValidation()){
          
          if(detailvalidation ()){
           var formData = $("#frmSaleBill").serialize();
           var mode=$("#txtModeOfoperation").val();
           var SaleBillId = $("#hdSalebillid").val();//sale bill id for add and edit.
           $('#stock_loader').show();
           $('#saveSaleBill').hide();
           
           formData = decodeURI(formData);
           $.ajax({
            url: basepath + "taxinvoice/saveData",
            type: 'post',
            data: {formDatas: formData,mode:mode,salebillid:SaleBillId},
            success: function(data) {
                if(data==1){
                                        $( "#sale_bil_save_dilg" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                     window.location.href = basepath + 'taxinvoice';
                                                    $( this ).dialog( "close" );
                                                }
                                              }
                                            });
                           }else{
                                        $( "#salebil_error_save_dilg" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                  $( this ).dialog( "close" );
                                                }
                                              }
                                            });
                           }
            },
            complete: function(data) {
                 $("#stock_loader").hide();
                 $('#saveSaleBill').show();
                 
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });
          }
          
      }else{
          
           $( "#salebil_detail_validation_fail" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                  $( this ).dialog( "close" );
                                                }
                                              }
                                            });
      }
       
   });




    $(document).on('keyup', ".packet", function() {
        var packetId = $(this).attr('id');
        var detailIdarr = packetId.split('_');
        var master_id = detailIdarr[1];
        var detail_id = detailIdarr[2];

        getQuantity(master_id, detail_id);
        getAmount(master_id, detail_id);
        callAllTotalFunction();
    });

    $(document).on('keyup', ".net", function() {
        var netId = $(this).attr('id');
        var detailIdarr = netId.split('_');
        var master_id = detailIdarr[1];
        var detail_id = detailIdarr[2];

        getQuantity(master_id, detail_id);
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

    $(document).on('change', ".finalProduct", function() {
        
        var productPacketId=$(this).val();
        
        
        var id = $(this).attr('id');
        var detailIdarr = id.split('_');
        var master_id = detailIdarr[1];
        var detail_id = detailIdarr[2];
        var txtRateId="#txtDetailRate_"+master_id+"_"+detail_id;
        var txtNetId="#txtDetailNet_"+master_id+"_"+detail_id;
        $.ajax({
            url :  basepath + "taxinvoice/get_final_product_rate",
            type: "POST",
            dataType:'json',
            data : {productId:productPacketId},
            success: function(data)
            {
               
                $(txtRateId).val(data.sale_rate);
                $(txtNetId).val(data.net_kgs);
                getAmount(master_id, detail_id);
                callAllTotalFunction();
                //data - response from server
            },
            error: function (e)
            {
                 console.log(e.message);
            }
        });    
    });


    $("#txtDiscountPercentage").keyup(function() {
        callAllTotalFunction();
    });

    $("#txtDeliveryChg").keyup(function() {
        callAllTotalFunction();
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
        var div_identification_id = "#salebillDetails_"+master_id+"_"+detail_id;
        $(div_identification_id).empty();
        
       // getAmount(master_id, detail_id);
        callAllTotalFunction();

    });


$(document).on('keyup', '.rate', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });

$(document).on('keyup', '.net', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });

$(document).on('keyup', '.packet', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });




});

//******************************User Defined Function for salebill ******************************//
function getValidation(){
    var saleBillNo =$("#txtSaleBillNo").val();
    var saleBillDate = $("#saleBillDate").val();
    var customerId = $("#customer").val();
    var rate = $("input[type='radio'][name='rateType']:checked");
    
    var vat =0;
    var cst =0;
    
  // if(saleBillNo==''){$("#txtSaleBillNo").addClass('glowing-border');return false;}
   if(saleBillDate==''){$("#saleBillDate").addClass('glowing-border');return false;}
   if(customerId==0){$("#customer").addClass('glowing-border');return false;}
   if(getNumberofDetails()<=0){
          return false;
   }
    
    
    if (rate.length > 0) {
           var  rateType = rate.val();
            if(rateType=="V"){
                vat=$("#vat").val();
                if(vat==0){
                    $("#vat").addClass("glowing-border");
                    return false;
                }
            }else{
                cst=$("#cst").val();
                
                if(cst==0){
                    $("#cst").addClass("glowing-border");
                    return false;
                }
                
            }
        }
    
    
   
    
    
    return true;
}



function detailvalidation (){
     if(!getProductValidation()){
        $( "#salebil_detail_error" ).dialog({
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
        $( "#salebil_detail_error" ).dialog({
                            modal: true,
                               buttons: {
                           Ok: function() {
                             $( this ).dialog( "close" );
                           }
                         }
                       }); 
        return false;
     }
     if(!getAmountValidation()){
        $( "#salebil_detail_error" ).dialog({
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
/*******/
function getNumberofDetails(){
    var numberofDetails=0;
    $('section.salebillDtl').each(
        function() {
          numberofDetails=(($(this).find('.taxinvoicedetails')).length);
        }
      );
      return numberofDetails;
}


function getProductValidation (){
    
    var selectedproduct;
    var flag=0;
     $('select[name^="finalproduct"]').each(function() {
         
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
         
        var qty = parseFloat(($(this).val() == ""||0.00? "" : $(this).val()));
       //console.log(selectedproduct);
        if(qty==""){
            flag=1;
        }
        
    });
    if(flag==1){
        return false;
    }else{
            return true;  
    }
 }
 function getAmountValidation(){
      var flag=0;
      $('input[name^="txtDetailAmount"]').each(function() {
         
        var amount = parseFloat(($(this).val() == "" || 0.00? "" : $(this).val()));
       //console.log(selectedproduct);
        if(amount==""){
            flag=1;
        }
        
    });
    if(flag==1){
        return false;
    }else{
            return true;  
    }
 }
 
 
 

/**
 * @function getQuantity
 * @param {type} masterId
 * @param {type} detailId
 * @returns {int}
 */

function getQuantity(masterId, detailId) {
    var Qauntity = 0;
    var numberofpacket = 0;
    var netinpacket = 0;

    numberofpacket = parseFloat($("#txtDetailPacket_" + masterId + "_" + detailId).val() == "" ? 0 : $("#txtDetailPacket_" + masterId + "_" + detailId).val());
    netinpacket = parseFloat($("#txtDetailNet_" + masterId + "_" + detailId).val() == "" ? 0 : $("#txtDetailNet_" + masterId + "_" + detailId).val());

    Qauntity = parseFloat(numberofpacket * netinpacket);

    $("#txtDetailQuantity_" + masterId + "_" + detailId).val(Qauntity.toFixed(2));
    return Qauntity;
}
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

    return amount;
}

////////////////////////////Total Calculation/////////////////////////////
function callAllTotalFunction() {
    getTotalPacket();
    getTotalQty();
    getTotalAmount();
    getDiscountAmount();
    getTaxAmount();
    getGrandTotal();

}

function getTotalPacket() {
    var totalPacket = 0;
    var packet = 0;

    $('input[name^="txtDetailPacket"]').each(function() {
        var qty = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalPacket = parseFloat(totalPacket + qty);
        //console.log("totalBlendedBag "+i+":"+bag);
        //i++;
    });
    $("#txtTotalPacket").val(totalPacket.toFixed(2));
    return totalPacket;
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
    return totalAmount;

}

function getDiscountAmount() {
    var totalamount = 0;
    var discountRate = 0;
    var discountAmount = 0;
    totalamount = parseFloat(getTotalAmount());
    discountRate = parseFloat($("#txtDiscountPercentage").val() == "" ? 0 : $("#txtDiscountPercentage").val());

    discountAmount = parseFloat((totalamount * discountRate) / 100);

    $("#txtDiscountAmount").val(discountAmount.toFixed(2));

    return discountAmount;

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

    return TaxAmount;
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
    return grandTotal;
    
    
}





//******************************User Defined Function for salebill ******************************//    











///////////////////old/////////////////////





        