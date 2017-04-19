$(document).ready(function () {
    
    $( ".legal-menu"+$('#advancepayment').val() ).addClass( " collapse in " );
    $( ".vendorpayment").addClass( " active " ); 
    
    var basepath = $("#basepath").val();
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;

    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate,
		onSelect: function(dateText,inst){
			$(".chqdt").val(dateText);
		}

    });
$('.chqdt').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
});

 $("#vendor").customselect();

//txtamounttobecredited
 $('.txtamounttobecredited').keypress(function(event){
       return isNumber(event, this);
    });
 $('.payment').keypress(function(event){
       return isNumber(event, this);
    });  

    //get purchase bill list
    $("#vendor").change(function () {
        var vendorAccountId=$('#vendor').val()||0;
        $.ajax({
            url: basepath + 'vendorpayment/getPurchaseBillList',
            data: {
                vendoraccId: vendorAccountId
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
     $(document).on('change','#purchaseBill',function(){
      var vendorBillMasterId = $('#purchaseBill').val()||0;
      var vendorPaymentId = $("#vendorPaymentId").val() || 0;
      $.ajax({
        url: basepath+'vendorpayment/getUnpaidBillAmount',
        data: { vendorBillMasterId: vendorBillMasterId,vendorPaymentId:vendorPaymentId},
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
        url: basepath+'vendoradvanceadjustment/getBillDateAndOthers',
        data: { vendorBillMasterId: vendorBillMasterId},
        type: "post",
        dataType: "json",
        success: function (data) {
           //advanceamount
           var BillDate= data.billDate;
           var vendorBillMasterId = data.vendorBillMasterId;
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
       
      var bill=$('#purchaseBill option:selected').text();
      var vendorBillMasterId = $('#purchaseBill').val();
      var billDate = $('#billDate').val();
      var amount = parseFloat($('#billAmount').val()||0).toFixed(2);
      var adjusted = parseFloat($('#paidAmount').val()||0).toFixed(2);
      
      var row="<tr>"+
              "<td>"+bill+"<input type='hidden' name='vendorBillMstId' value='"+vendorBillMasterId+"'/></td>"+
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
       
        var paidAmt = parseFloat($.trim($(this).closest('tr').find('td:eq(3)').html()));
        deductionFromTotal(paidAmt);
         $(this).closest('tr').remove();
        
    });

$("#saveVendorPayment").click(function(){
    
   
   var paymentDate = $("#paymentdate").val();
   var creditAccountId = $("#cashorbank").val();
   var chequeNo = $("#chequeno").val()||"";
   var chequeDate = $("#chequedt").val()||"";
   var vendorId = $("#vendor").val();
   var totalPayment = $("#paymentAmount").val()||0;
   var narration = $("#narration").val()||"";
   var voucherId = $("#voucherId").val()||0;
   var details = createDetails();
   
   var vendorPaymentId = $("#vendorPaymentId").val()||0;
    if(validation()){
        $.ajax({
                type: 'POST',
                url: basepath + "vendorpayment/saveVendorPayment",
                data: {
                    "vendorPaymentId":vendorPaymentId,
                    "paymentDate":paymentDate,
                    "creditAccountId":creditAccountId,
                    "chequeNo":chequeNo,
                    "chequeDate":chequeDate,
                    "vendorId":vendorId,
                    "totalPayment":totalPayment,
                    "narration":narration,
                    "voucherId":voucherId,
                    "details":details
                },
             
                 dataType:'json',
                success: function (data) {
                    
                    if (data.msg==1) {
                        alert('Data successfully saved .'+data.voucherNumber);
                        //to do
                           window.location.href = basepath + 'vendorpayment';
                    }
                    else {
                        alert('Data not properly updated' );
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
//user defined function

function deductionFromTotal(values){
    var payment = $("#paymentAmount").val()||0;
    var deductedValues = parseFloat(payment)- parseFloat(values);
    $("#paymentAmount").val(deductedValues.toFixed(2));
}
function clearDetails(){
     //var bill=$('#purchaseBill option:selected').text();
     $('#purchaseBill option[value=""]').attr('selected','selected');
     $('#purchaseBill').val("");
     $('#billDate').val("");
     $('#billAmount').val("");
     $('#paidAmount').val("");
      return false;
}
function rowValidation(){
     var vendorBillMasterId = $('#purchaseBill').val();
     var paidAmount = parseFloat($('#paidAmount').val()||0);
     var unpaidBillAmount = parseFloat($('#billAmount').val()||0);
    
     //if(vendorBillMasterId==""){return false;}
    // if(!amountComparisonValidaion()){return false;}
     if(paidAmount==0){return false;}
     if(vendorBillMasterId!=""){
         if(BillExist(vendorBillMasterId)){
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


// Comparison For Unpaid bill amount and adjusted amount
function amountComparisonValidaion(){
    var unpaidAmt = $("#billAmount").val();
    var paidAmount = $("#paidAmount").val();
    if(paidAmount>unpaidAmt){
       return false;
    }
    else{
        return true;
    }
   
}



function validation(){
   var paymentDate = $("#paymentdate").val();
   var creditAccountId = $("#cashorbank").val();
   var vendorId = $("#vendor").val();
   var totalPayment = $("#paymentAmount").val()||0;
   var amountcredited = $("#amountcredited").val()||0;
   
    if(paymentDate==""){return false;}
    if(creditAccountId==""){return false;}
    if(vendorId==""){return false;}
    if(totalPayment==0){return false;}
   
    if(calculateTotalPayment()!=amountcredited){
        return false;
    }
    return true;
}


function BillExist(billmasterId){
    console.log(billmasterId);
    var flag=0;
    
    $("#billAdjustTable tr:gt(0)").each(function () {
            var this_row = $(this);
            var vendorBillMasterId = $.trim(this_row.find('td:eq(0)').children('input').val());//td:eq(0) means first td of this row
            if(vendorBillMasterId==billmasterId){
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


function createDetails(){
    //var rowCount = $('#billAdjustTable tr').length;
    //console.log(rowCount+" :AAAA");
    
     var DetailJSON = { adjustmentDetails: [] };
        
        var vendorBillMasterId = 0;
        var paidAmount =0;
       

        $("#billAdjustTable tr:gt(0)").each(function () {
            var this_row = $(this);
             vendorBillMasterId = $.trim(this_row.find('td:eq(0)').children('input').val());//td:eq(0) means first td of this row
             paidAmount = parseFloat($.trim(this_row.find('td:eq(3)').html()));
           
            if(vendorBillMasterId!=""){
            DetailJSON.adjustmentDetails.push({
                 "vendorBillMasterId": vendorBillMasterId,
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