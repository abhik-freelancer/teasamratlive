$(document).ready(function() {
   
    $(".legal-menu" + $('#transactionmenu').val()).addClass(" collapse in ");
    $(".generalvoucher").addClass(" active ");


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
    
     $("#addnewDtlDiv").click(function() {
       divSerialNumber = divSerialNumber + 1;
      //  var accounttag = $("#paymentmode").val();
      //   var ammount = $("#amount").val();
       
       
        $.ajax({
            url: basepath + "generalvoucher/createDetails",
            type: 'post',
            data: {divSerialNumber: divSerialNumber},
            success: function(data) {
                $(".groupvoucherDtl").append(data);
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
   
    
      $(document).on('click', ".del", function() {
        var netId = $(this).attr('id');
        var detailIdarr = netId.split('_');
        var master_id = detailIdarr[1];
        var detail_id = detailIdarr[2];

        //console.log("divID :"+master_id+"-"+detail_id);
        var div_identification_id = "#generalVoucher_"+master_id+"_"+detail_id;
        $(div_identification_id).empty();
        // getTotalDebit();
         // getTotalCredit();
          globalFunction();
     
    });
    
     $(document).on('change', ".paymentmode", function() {
        var paymentMode = $("#paymentmode").val();
          var amount = $("#amount").val();
        
            if(paymentMode=='RC'){
               // alert("Rc");
               $("#totalDebit").val(amount);
                $("#totalCredit").val('0');
            }
            else{
                //alert("PAy");
                  $("#totalCredit").val(amount);
                   $("#totalDebit").val('0');
            }
      
     });
   
      $(document).on('keyup', ".amount", function() {
       var amount = $("#amount").val();
       var paymentmode = $("#paymentmode").val();
            if(paymentmode=='RC'){
                $("#totalDebit").val(amount);
                 $("#totalCredit").val('0');
            }
            else{
                 $("#totalCredit").val(amount);
                 $("#totalDebit").val('0');
            }
             globalFunction();
      });
      
      $(document).on('keyup', ".amountDtl", function() {
          globalFunction();
       
      });
        $(document).on('blur', ".amountDtl", function() {
          globalFunction();
       
      });
       $(document).on('change', ".debitcredit", function() {
            globalFunction();
            var rowId=$(this).attr('id');
            var DrCrvalue=$(this).val();
            getDebitCrediteComparison(DrCrvalue,rowId);
       });
      
  
  $(document).on('keyup', '.amount', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });
        
$(document).on('keyup', '.amountDtl', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });

$("#generalVoucher").click(function(){
   // alert("");
    if(getVoucherMasterValidation()){
        if(detailvalidation()){
            if(getDebitCreditEqualValidation()){
           var formData = $("#frmVoucher").serialize();
           var mode=$("#txtModeOfoperation").val();
           var voucherMasterId = $("#voucherMasterId").val();//sale bill id for add and edit.
         
           
           formData = decodeURI(formData);
           $.ajax({
            url: basepath + "generalvoucher/saveData",
            type: 'post',
            data: {formDatas: formData,mode:mode,voucherMasterId:voucherMasterId},
            success: function(data) {
                if(data==1){
                     $( "#save_voucher_detail_data" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                    // window.location.href = basepath + 'generalvoucher';
                                                    $( this ).dialog( "close" );
                                                     $( "#show_voucher_no" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                        Ok: function() {
                                                             window.location.href = basepath + 'generalvoucher';
                                                            $( this ).dialog( "close" );
                                                        }
                                                      }
                                                    });
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
        }
    }else{
        
    }
});

   
   });
  
  
  
   /************************--------------------------USER DEFINED FUNCTION------------------------**********************/
   function globalFunction(){
       getTotalDebit();
       getTotalCredit();
   }
   
function detailvalidation (){
     if(!getDetailDbCrValidation()){
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
    
      if(!getDetailAccountHeadValidation()){
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
     if(!getDetailAmountValidation()){
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
 

function getTotalAmt(){
   // var debitCreditAmt={}
    var debitCreditSum = {};
    var amount=0;
    var debitDtlTotal=0;
    var creditDtlTotal=0;
    var tag=0;
    var table= '#voucherDtl tr';
    $(table).each(
        function() {
          
          tag=$(this).find('.debitcredit').val();
          console.log("tag"+tag);
          if(tag=='Cr'){
              var amt = $(this).find('.amountDtl').val()||0;
              creditDtlTotal = creditDtlTotal + parseFloat(amt);
          }
          if(tag=='Dr'){
              var amt = $(this).find('.amountDtl').val()||0;
              debitDtlTotal = debitDtlTotal + parseFloat(amt);
          }
          if(tag==0){creditDtlTotal=0;debitDtlTotal=0;}
         
        }
        
      );
      
    debitCreditSum ={'totalCredit':creditDtlTotal,'totalDebit':debitDtlTotal};
      //console.log('debitCreditSum:'+debitCreditSum.totalCredit+"**"+debitCreditSum.totalDebit);
     
      return debitCreditSum;
}

/*
 * 
 * @param {type} DrCrtag
 * @param {type} rowId
 * @returns {undefined}
 * @date 05-03-2016
 * @author Suman Da
 */

function getDebitCrediteComparison(DrCrtag,rowId){
    var idArray = rowId.split("_");
    var AmtactualId='amountDtl'+'_'+idArray[1]+'_'+idArray[2];
    var totalDebit=$('#totalDebit').val();
    var totalCredit=$('#totalCredit').val();
    var differenceDebit=totalDebit-totalCredit;
    var differenceCredit=totalCredit-totalDebit;
    
    if(DrCrtag=="Dr"){
       if(differenceDebit>0){
           $('#'+AmtactualId).val(0);
       }else{
            $('#'+AmtactualId).val(differenceCredit);
       }
    }
    else{
        if(differenceDebit>0){
            $('#'+AmtactualId).val(differenceDebit);
        }
        else{
            $('#'+AmtactualId).val(0);
       }
    }
    getTotalDebit();
    getTotalCredit();
}



function getTotalDebit(){
       var totalDetailAmount=0;
       var totalDebitAmount =0;
       var debitAmt=0;
       
       var paymentmode=$("#paymentmode").val();
       if(paymentmode=="RC"){
            debitAmt=parseFloat($('#amount').val());
       }else{
           debitAmt=0;
       }
       
       //debitAmt=parseFloat($('#amount').val());
       
       totalDetailAmount=getTotalAmt().totalDebit;
       console.log('DetailAmount:'+totalDetailAmount);
       
       totalDebitAmount=parseFloat(debitAmt+totalDetailAmount);
       
        $("#totalDebit").val(totalDebitAmount);
       
     

 }
 function getTotalCredit(){
       var totalDetailAmount=0;
       var totalCreditAmount =0;
       var creditAmt=0;
       
       var paymentmode=$("#paymentmode").val();
       if(paymentmode=="PY"){
            creditAmt=parseFloat($('#amount').val());
       }else{
           creditAmt=0;
       }
       
     //  creditAmt=parseFloat($('#amount').val());
       
       totalDetailAmount=getTotalAmt().totalCredit;
       console.log('TotalCreditAmount:'+totalDetailAmount);
       
       totalCreditAmount=parseFloat(creditAmt+totalDetailAmount);
       
        $("#totalCredit").val(totalCreditAmount);
       
     

 }
 
 

 
 function getVoucherMasterValidation(){
    // var voucherNo = $("#voucherNo").val();
     var voucherDate = $("#voucherDate").val();
     var amount = $("#amount").val();
     var branch = $("#branchid").val();
    
   /*  if(voucherNo==""){
         $("#voucherNo").addClass('glowing-border');
         return false;
     }*/
      if(voucherDate==""){
         $("#voucherDate").addClass('glowing-border');
         return false;
     }
     if(amount==""){
         $("#amount").addClass('glowing-border');
         return false;
     }
     if(branch=="0"){
          $("#branchid").addClass('glowing-border');
          return false;
     }
     else{
         return true;
     }
 }
 
 function getDebitCreditEqualValidation(){
     var totalDebit = $("#totalDebit").val();
     var totalCredit = $("#totalCredit").val();
     
     if(totalDebit!=totalCredit){
         alert("Summation of Debit & Credit must be equal");
         return false;
     }
     else{
         return true;
     }
 }
 function getDetailDbCrValidation(){
    
    var selectedType;
    var flag=0;
     $('select[name^="debitcredit"]').each(function() {
         
        selectedType = $(this).val();
       //console.log(selectedproduct);
        if(selectedType=='0'){
            flag=1;
        }
        
    });
    if(flag==1){
        return false;
    }else{
            return true;  
    }
 }
 
  function getDetailAccountHeadValidation(){
    
    var accountHead;
    var flag=0;
     $('select[name^="acHead"]').each(function() {
         
        accountHead = $(this).val();
       //console.log(selectedproduct);
        if(accountHead=='0'){
            flag=1;
        }
        
    });
    if(flag==1){
        return false;
    }else{
            return true;  
    }
 }

 
 
 function getDetailAmountValidation(){
      var flag=0;
      //var amountDtl=0;
      $('input[name^="amountDtl"]').each(function() {
         
         //amountDtl = parseFloat(($(this).val() == ""||0? "" : $(this).val()));
          var amt = $(this).val() == ""||0? "" : $(this).val();
       //console.log(selectedproduct);
        if(amt==""){
            flag=1;
        }
        
    });
    if(flag==1){
        return false;
    }else{
            return true;  
    }
 }
 function deleterecord(id){
                   // alert(id);
                    var a = confirm("Do you want to Delete");
                    if(a==true){
			var basepath =  $("#basepath").val();
			$.ajax({
			type: "POST",
			url:  basepath+"generalvoucher/delete",
			data: {id: id},
			success: function(data)
				{
				window.location.href = basepath+'generalvoucher';
				}

     	});
    }
    else{
        return false;
    }
   
    
}

 
 
  

  