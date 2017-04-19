 
$(document).ready(function() {

    $(".legal-menu" + $('#transactionmenu').val()).addClass(" collapse in ");
    $(".contravoucher").addClass(" active ");


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
    
    
    $(document).on('keyup', ".debitAmt", function() {
        var debitAmount = $("#debitAmt").val();
        $("#creditAmt").val(debitAmount);
        globalFunction();
       
      });
      $(document).on('blur', ".debitAmt", function() {
        var debitAmount = $("#debitAmt").val();
        $("#creditAmt").val(debitAmount);
        globalFunction();
       
      });
       $(document).on('keyup', ".creditAmt", function() {
         globalFunction();
       
      });
      $(document).on('blur', ".creditAmt", function() {
      
       globalFunction();
       
      });
    
     $("#addnewDtlDiv").click(function() {
        divSerialNumber = divSerialNumber + 1;
        $.ajax({
            url: basepath + "contravoucher/createDetails",
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
    //});
    
     
      $(document).on('click', ".del", function() {
        var netId = $(this).attr('id');
        var detailIdarr = netId.split('_');
        var master_id = detailIdarr[1];
        var detail_id = detailIdarr[2];

        //console.log("divID :"+master_id+"-"+detail_id);
        var div_identification_id = "#generalVoucher_"+master_id+"_"+detail_id;
        $(div_identification_id).empty();
        globalFunction();
     
    });
    

   
 
      $(document).on('keyup', ".amountDtl", function() {
          globalFunction();
       
      });
       $(document).on('change', ".debitcredit", function() {
            globalFunction();
            var rowId=$(this).attr('id');
            var DrCrvalue=$(this).val();
            getDebitCrediteComparison(DrCrvalue,rowId);
       });
      

 $(document).on('keyup', '.debitAmt', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });
 $(document).on('keyup', '.creditAmt', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });
    
    
    
$(document).on('keyup', '.amountDtl', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });
    

$("#contraVoucher").click(function(){
   
    if(getVoucherMasterValidation()){
        if(debitcreditvalid()){
            if(getDebitCreditEqualValidation()){
           var formData = $("#frmContraVoucher").serialize();
           var mode=$("#txtModeOfoperation").val();
           var voucherMasterId = $("#voucherMasterId").val();//sale bill id for add and edit.
         
           
           formData = decodeURI(formData);
           $.ajax({
            url: basepath + "contravoucher/saveData",
            type: 'post',
            data: {formDatas: formData,mode:mode,voucherMasterId:voucherMasterId},
            success: function(data) {
                if(data==1){
                     $( "#save_voucher_detail_data" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                                 $(this).dialog( "close" );
                                                    window.location.href = basepath + 'contravoucher';
                                                     /*$( "#show_voucher_no" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                        Ok: function() {
                                                             
                                                            $( this ).dialog( "close" );
                                                        }
                                                      }
                                                    });*/
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
       // getTotalDebit();
      // getTotalCredit();
       totalDebitAmt();
       totalCreditAmt();
   }
   
   //mithilesh on 26.07.2016
   
   function totalDebitAmt(){
       var debitamt = $("#debitAmt").val();
       $("#totalDebit").val(debitamt);
       
   }
    function totalCreditAmt(){
       var creditAmt = $("#creditAmt").val();
       $("#totalCredit").val(creditAmt);
       
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
   
    var debitCreditSum = {};
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


function getTotalDebit(){
       var totalDetailAmount=0;
       var totalDebitAmount =0;
       var debitAmt=0;
       
     /*  var paymentmode=$("#paymentmode").val();
       if(paymentmode=="RC"){
            debitAmt=parseFloat($('#amount').val());
       }else{
           debitAmt=0;
       }*/
       
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
       
      /* var paymentmode=$("#paymentmode").val();
       if(paymentmode=="PY"){
            creditAmt=parseFloat($('#amount').val());
       }else{
           creditAmt=0;
       }*/
       
     //  creditAmt=parseFloat($('#amount').val());
       
       totalDetailAmount=getTotalAmt().totalCredit;
       console.log('TotalCreditAmount:'+totalDetailAmount);
       
       totalCreditAmount=parseFloat(creditAmt+totalDetailAmount);
       
        $("#totalCredit").val(totalCreditAmount);
       
     

 }
 
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
 
 
 
 function getVoucherMasterValidation(){
    
     var voucherDate = $("#voucherDate").val();
     var branch = $("#branchid").val();
     var chqNo = $("#chqNo").val();
     var chqDate = $("#chqDate").val();
   
      if(voucherDate==""){
         $("#voucherDate").addClass('glowing-border');
         return false;
     }
     if(chqNo==""){
          $("#chqNo").addClass('glowing-border');
         return false;
     }
     if(chqDate==""){
           $("#chqDate").addClass('glowing-border');
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
 
 
 function debitcreditvalid(){
     var debitaccheadc = $("#acheaddebit").val();
     var debitamount = $("#debitAmt").val();
     var creditacchead = $("#acheadcredit").val();
     var creditamount = $("#creditAmt").val();
     
     if(debitaccheadc=="0"){
         $("#acheaddebit").addClass('glowing-border');
         return false;
     }
     if(debitamount==""){
         $("#debitAmt").addClass('glowing-border');
         return false;
     }
      if(creditacchead=="0"){
         $("#acheadcredit").addClass('glowing-border');
         return false;
     }
     if(creditamount==""){
         $("#creditAmt").addClass('glowing-border');
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
			url:  basepath+"contravoucher/delete",
			data: {id: id},
			success: function(data)
				{
				window.location.href = basepath+'contravoucher';
				}

     	});
    }
    else{
        return false;
    }
   
    
}


 
 
  

  