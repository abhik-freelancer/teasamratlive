
$(document).ready(function () {
    $( ".legal-menu"+$('#advancepayment').val() ).addClass( " collapse in " );
    $( ".customerpayment").addClass( " active " );   
    
    var basepath = $("#basepath").val();
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;

    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate

    })
          //  .datepicker("setDate", "0");
    $('.chqdt').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
});

 $("#customer").customselect();

 $('.txtamounttobecredited').keypress(function(event){
       return isNumber(event, this);
    });
    
    
    
 $('.payment').keypress(function(event){
       return isNumber(event, this);
    });  
    
     //get sale bill list
    $("#customer").change(function () {
        var customerAccountId=$('#customer').val()||0;
        $.ajax({
            url: basepath + 'customerpayment/getSaleBillList',
            data: {
                customerAccountId: customerAccountId
            },
            type: "post",
            dataType: "html",
            success: function (data) {

                $('#billList').html(data);
            },
            error: function (xhr, status) {
                alert("Sorry, there was a problem!");
            },
            complete: function (xhr, status) {
                //$('#showresults').slideDown('slow')
            }
        });
    });
    
    
    //getting bill details
     $(document).on('change','#saleBill',function(){
      var customerPaymentid = $('#customerPaymentId').val()||0;
      var customerBillMasterId = $('#saleBill').val()||0;
      $.ajax({
        url: basepath+'customerpayment/getUnpaidtBillAmount',
        data: { customerBillMasterId: customerBillMasterId,customerPaymentid:customerPaymentid},
        type: "post",
        dataType: "json",
        success: function (data) {
           //advanceamount
           var amount= parseFloat(data.unpaidAmt).toFixed(2);
           console.log(amount);
           $('#billAmount').val(amount);
        },
        error: function (xhr, status) {
            alert("Sorry, there was a problem!");
        },
        complete: function (xhr, status) {
            //$('#showresults').slideDown('slow')
        }
    });
      
      
      //others data
      $.ajax({
        url: basepath+'customeradvanceadjustment/getBillDateAndOthers',
        data: { customerBillMasterId: customerBillMasterId},
        type: "post",
        dataType: "json",
        success: function (data) {
           //advanceamount
           var BillDate= data.billDate;
           var customerBillMasterId = data.customerBillMasterId;
           var invoicemasterId = data.invoiceMasterId;
           //parseFloat(data.unpaidAmt).toFixed(2)
           console.log(BillDate);
           $('#billDate').val(BillDate);
        },
        error: function (xhr, status) {
            alert("Sorry, there was a problem!");
        },
        complete: function (xhr, status) {
            //$('#showresults').slideDown('slow')
        }
    });
   });
   
    $('.add').click(function(){
      var bill=$('#saleBill option:selected').text();
      var customerBillMasterId = $('#saleBill').val();
      var billDate = $('#billDate').val();
      var amount = parseFloat($('#billAmount').val()||0).toFixed(2);
      var adjusted = parseFloat($('#paidAmount').val()||0).toFixed(2);
      
      var row="<tr>"+
              "<td>"+bill+"<input type='hidden' name='customerBillMasterId' value='"+customerBillMasterId+"'/></td>"+
              "<td style='text-align: center'>"+billDate+"</td>"+
              "<td style='text-align:right'>"+amount+"</td>"+
              "<td style='text-align:right'>"+adjusted+"</td>"+
              "<td style='text-align:right'>"+
              "<img src='"+basepath+"application/assets/images/delete-ab.png"+"' alt='del' class='rowDel' style='cursor: pointer;' /></td>"
              +"</tr>"
      if(rowValidation()){
                $('#billAdjustTable').append(row);
               clearDetails();
               var totalPayment =parseFloat( calculateTotalPayment().toFixed(2));
               $('#paymentAmount').val(totalPayment);
        }else{
                    $( "#dialog-Row_validation" ).dialog({
                        modal: true,
                        width: 500,
                        buttons: {
                          Ok: function() {
                            $( this ).dialog( "close" );
                          }
                        }
                      });
            }
   });

$("#billAdjustTable").on('click', '.rowDel', function () {
        $(this).closest('tr').remove();
    });


$("#saveCustomerPayment").click(function(){
   var paymentDate = $("#paymentdate").val();
   var debitAccountId = $("#cashorbank").val();
   var chequeNo = $("#chequeno").val()||"";
   var chequeDate = $("#chequedt").val()||"";
   var customerId = $("#customer").val();
   var totalPayment = $("#paymentAmount").val()||0;
   var narration = $("#narration").val()||"";
   var voucherId = $("#voucherId").val()||0;
   var customerbank = $("#depositbank").val()||"";
   var customerbankbranch = $("#branchname").val()||"";
   var details = createDetails();
   
   var customerPaymentId = $("#customerPaymentId").val()||0;
    if(validation()){
        $("#saveCustomerPayment").css("display","none");
        $.ajax({
                type: 'POST',
                url: basepath + "customerpayment/saveCustomerPayment",
                data: {
                    "customerPaymentId":customerPaymentId,
                    "paymentDate":paymentDate,
                    "debitAccountId":debitAccountId,
                    "chequeNo":chequeNo,
                    "chequeDate":chequeDate,
                    "customerId":customerId,
                    "totalPayment":totalPayment,
                    "narration":narration,
                    "voucherId":voucherId,
					"customerbank":customerbank,
					"customerbankbranch":customerbankbranch,
                    "details":details
                },
             
                 dataType:'json',
                success: function (data) {
                    
                    if (data.msg==1) {
                        alert('Data successfully saved .'+data.voucherNumber);
                        //to do
                           window.location.href = basepath + 'customerpayment';
                    }
                    else {
                        alert('Data not properly updated' );
                        $("#saveCustomerPayment").css("display","block");
                        return false;
                    }
                }
            });
       
   }else{
        $( "#dialog-validation" ).dialog({
                        modal: true,
                        width: 500,
                        buttons: {
                          Ok: function() {
                            $( this ).dialog( "close" );
                          }
                        }
                      });
   }
    
});

});


// User Defined function

function clearDetails(){
     //var bill=$('#purchaseBill option:selected').text();
     $('#saleBill option[value=""]').attr('selected','selected');
     $('#saleBill').val("");
     $('#billDate').val("");
     $('#billAmount').val("");
     $('#paidAmount').val("");
      return false;
}

function rowValidation(){
     var customerBillMasterId = $('#saleBill').val();
     var paidAmount = parseFloat($('#paidAmount').val()||0);
     var unpaidBillAmount = parseFloat($('#billAmount').val()||0);
    
     //if(vendorBillMasterId==""){return false;}
    // if(!amountComparisonValidaion()){return false;}
     if(paidAmount==0){return false;}
     if(customerBillMasterId!=""){
         if(BillExist(customerBillMasterId)){
            return false;
         }
    }else{
        return false;
    }
    
    if(unpaidBillAmount>0){
       if(paidAmount!=0){
           if(paidAmount<=unpaidBillAmount){
               return true;
           }else{
               return false;
           }
       }else{
           return false;
       } 
    }
    else{
        return false;
    }

    return true;
}


function BillExist(billmasterId){
    console.log(billmasterId);
    var flag=0;
    
    $("#billAdjustTable tr:gt(0)").each(function () {
            var this_row = $(this);
            var customerBillMasterId = $.trim(this_row.find('td:eq(0)').children('input').val());//td:eq(0) means first td of this row
            if(customerBillMasterId==billmasterId){
                 flag=1;
             }
        });
    if(flag==1){
         return true;
    }else{
        return false;
    }
}

function calculateTotalPayment(){
    var totalPayment=0;
    var paidAmount=0;
    $("#billAdjustTable tr:gt(0)").each(function () {
            var this_row = $(this);
            // vendorBillMasterId = $.trim(this_row.find('td:eq(0)').children('input').val());//td:eq(0) means first td of this row
             paidAmount = parseFloat($.trim(this_row.find('td:eq(3)').html()));
           
            totalPayment = parseFloat(totalPayment + paidAmount);
            
        });
        return totalPayment;
}


function validation(){
   var paymentDate = $("#paymentdate").val();
   var debitAccountId = $("#cashorbank").val();
   var customerId = $("#customer").val();
   var totalPayment = $("#paymentAmount").val()||0;
   var amountcredited = $("#amountcredited").val()||0;
   
    if(paymentDate==""){return false;}
    if(debitAccountId==""){return false;}
    if(customerId==""){return false;}
    if(totalPayment==0){return false;}
   
    if(calculateTotalPayment()!=amountcredited){
        return false;
    }
    return true;
}

function createDetails(){
    //var rowCount = $('#billAdjustTable tr').length;
    //console.log(rowCount+" :AAAA");
    
     var DetailJSON = { adjustmentDetails: [] };
        
        var customerBillMasterId = 0;
        var paidAmount =0;
       

        $("#billAdjustTable tr:gt(0)").each(function () {
            var this_row = $(this);
            customerBillMasterId = $.trim(this_row.find('td:eq(0)').children('input').val());//td:eq(0) means first td of this row
             paidAmount = parseFloat($.trim(this_row.find('td:eq(3)').html()));
           
            if(customerBillMasterId!=""){
            DetailJSON.adjustmentDetails.push({
                 "customerBillMasterId": customerBillMasterId,
                 "paidAmount":paidAmount
             });
            }
            
        });
        
        return DetailJSON;
}


function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    } 