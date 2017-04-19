
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
            url: basepath + "rawmaterialpurchase/createDetails",
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
            url: basepath + "rawmaterialpurchase/saveData",
            type: 'post',
            data: {formDatas: formData,mode:mode,rawmatpurchaseMastId:rawmatpurchaseMastId},
            success: function(data) {
               if(data){
                    $("#rawmaterial_save_dialg").dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                     window.location.href = basepath + 'rawmaterialpurchase';
                                                    $( this ).dialog( "close" );
                                                    
                                                }
                                              }
                                            });
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
        
        var exciseId=$(this).val();
       
        $.ajax({
            url :  basepath + "rawmaterialpurchase/get_exciserate_rate",
            type: "POST",
            data : {exciseId:exciseId},
            success: function(data)
            {
               $("#exciseAmt").val(data);                //data - response from server
            },
            error: function (e)
            {
                 console.log(e.message);
            }
        });    
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
        var div_identification_id = "#rawmaterialDetails_"+master_id+"_"+detail_id;
        $(div_identification_id).empty();
        
        getAmount(master_id, detail_id);
        callAllTotalFunction();

    });


$(document).on('keyup', '.rate', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });

$(document).on('keyup', '.pacQty', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });





});

//******************************User Defined Function for rawmaterialPurchase ******************************//
function callAllTotalFunction() {
   
    getTotalQty();
    getTotalAmount();
   getTaxAmount();
   getGrandTotal()

}

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

function getTaxAmount() {
    var TaxRate = 0;
    var totalAmount = 0;
    var TaxAmount = 0;
    var exciseAmt=0;
    var allAmount=0;
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
    exciseAmt=parseFloat($("#exciseAmt").val()==""?0:$("#exciseAmt").val());
    totalAmount = parseFloat(getTotalAmount());
    allAmount=parseFloat(totalAmount+exciseAmt);
    TaxAmount=parseFloat(allAmount * TaxRate)/100;
    $("#txtTaxAmount").val(TaxAmount.toFixed(2));

    return TaxAmount;
}

function getGrandTotal(){
    var totalAmount=0;
   
   
    var taxAmount =0;
    var roundoff =0;
    var exciseAmt=0;
    var grandTotal =0 ;
    
    totalAmount = parseFloat(getTotalAmount());
   
    taxAmount = parseFloat(getTaxAmount());
    exciseAmt=parseFloat($("#exciseAmt").val()==""?0:$("#exciseAmt").val());
    roundoff = parseFloat($("#txtRoundOff").val()==""?0:$("#txtRoundOff").val());

   
    
    grandTotal = parseFloat((totalAmount)+(exciseAmt)+(taxAmount)+(roundoff));
    
    $("#txtInvoiceValue").val(grandTotal.toFixed(2));
    return grandTotal;
    
    
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