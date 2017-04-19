$(document).ready(function(){
    
$( ".legal-menu"+$('#advancepayment').val() ).addClass( " collapse in " );
$( ".customeradvanceadjustment").addClass( " active " );  
    
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
    //.datepicker("setDate", "0");
     $("#customer").customselect();
	 $("#saleBill").customselect();
    
    
  $('#customer').change(function(){
        var customerAccId=$('#customer').val()||0;
        $.ajax({
        url: basepath+'customeradvanceadjustment/getAdvanceVoucher',
        data: {
            customerAccId: customerAccId
        },
        type: "post",
        dataType: "html",
        success: function (data) {
            
            $('#advancevchResult').html(data);
        },
        error: function (xhr, status) {
            alert("Sorry, there was a problem!");
        },
        complete: function (xhr, status) {
            //$('#showresults').slideDown('slow')
        }
      });
    //get purchase bill
    $.ajax({
        url: basepath+'customeradvanceadjustment/addCustomerBill',
        data: {
            customerAccId: customerAccId
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
    
    
    $(document).on('change','#advanceVoucher',function(){
      var advanceId = $('#advanceVoucher').val()||0;
      $.ajax({
        url: basepath+'customeradvanceadjustment/getAdvanceAmountById',
        data: { advanceId: advanceId},
        type: "post",
        dataType: "json",
        success: function (data) {
           //advanceamount
           var amount= parseFloat(data.advamount).toFixed(2);
           console.log(amount);
           $('#advanceamount').val(amount);
        },
        error: function (xhr, status) {
            alert("Sorry, there was a problem!");
        },
        complete: function (xhr, status) {
            //$('#showresults').slideDown('slow')
        }
    });
   });
   
    $(document).on('change','#saleBill',function(){
      var customerBillMasterId = $('#saleBill').val()||0;
      var customerAdjustmentId = $('#txtCustomerAdjustmentId').val()||0;
      $.ajax({
        url: basepath+'customeradvanceadjustment/getUnpaidtBillAmount',
        data: { customerBillMasterId: customerBillMasterId,customerAdjustmentId:customerAdjustmentId},
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
   
   
    //$('#myTable > tbody:last-child').append('<tr>...</tr><tr>...</tr>');
   $('.add').click(function(){
    // amountComparisonValidaion();
      var bill=$('#saleBill option:selected').text();
      var customerBillMasterId = $('#saleBill').val();
      var billDate = $('#billDate').val();
      var amount = parseFloat($('#billAmount').val()||0).toFixed(2);
      var adjusted = parseFloat($('#adjustedAmount').val()||0).toFixed(2);
      //alert(adjusted);
      
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
               var totalAdjustment = parseFloat(calculateTotalAdjustment());
               
               $('#totalAdjustedAmount').val(totalAdjustment.toFixed(2));
               DeductionOfAdvacneOnRowDelete(adjusted);
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
         var totalAdjustment = parseFloat(calculateTotalAdjustment());
         $('#totalAdjustedAmount').val(totalAdjustment.toFixed(2));
        var additionAmount = parseFloat($.trim($(this).closest('tr').find('td:eq(3)').html()));
        additionOfAdvanceOnRowDelete(additionAmount);
    });
    
    
     $('#saveCustomerAdjustMent').click(function(){
      
       var adjustmentId = $('#txtCustomerAdjustmentId').val()||0;
       var refno=$('#txtRefNO').val();
       var dateofadjstment=$('#dateofadjustment').val();
       var customerAccountId = $('#customer').val();
       var advanceVoucherId =$('#advanceVoucher').val();
       var totalAdjustedAmount=$('#totalAdjustedAmount').val();
       var details = createDetails();
       
     
       if(validation()){
           $.ajax({
                type: 'POST',
                url: basepath + "customeradvanceadjustment/SaveAdjustment",
                data: {
                    "adjustmentId":adjustmentId,
                    "refno":refno,
                    "dateofadjstment":dateofadjstment,
                    "customerAccountId":customerAccountId,
                    "advanceVoucherId":advanceVoucherId,
                    "totalAdjustment":totalAdjustedAmount,
                    "details":details
                },
             

                success: function (data) {
                    if (data == 1) {
                      
                        alert('Data successfully saved..');
                           window.location.href = basepath + 'customeradvanceadjustment';
                        //to do
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

function validation(){
    var referenceno= $('#txtRefNO').val();
  //  alert(referenceno);
    var adjustmentDate = $('#dateofadjustment').val();
    var customer = $('#customer').val(); 
    var advancevoucher = $('#advanceVoucher').val();
    var advance = $('#advanceamount').val()||0;
    var totalAdjust = $('#totalAdjustedAmount').val()||0;
    
    var tempTotalAdjust = parseFloat(calculateTotalAdjustment().toFixed(2));
    var sumofAll =parseFloat(tempTotalAdjust + advance);
    
  /*  alert("Temp Total Adjust"+tempTotalAdjust);
    alert("Sum Of all"+sumofAll);*/
   // exit;
    
    if(referenceno==""){return false;}
    if(adjustmentDate==""){return false;}
    if(customer==""){return false;}
    if(advancevoucher==""){return false;}
    if(totalAdjust==0){return false;}
    
    
    if(totalAdjust!=0){
        if(advance<0){
            return false;
        }else{
            return true;
        }
    }else{
        return false;
    }
   
    
  /*  if(sumofAll!=0){
        if(sumofAll<tempTotalAdjust){
            return false;
        }else{
            return true;
        }
        
    }else{
        return false;
    }*/
    
    
    return true;
}

function additionOfAdvanceOnRowDelete(values){
    var advanceAmount = $("#advanceamount").val()||0;
    var total = parseFloat(advanceAmount) + parseFloat(values);
     $("#advanceamount").val(total);
}
function DeductionOfAdvacneOnRowDelete(values){
    
    var advanceAmount = $("#advanceamount").val()||0;
    var total = parseFloat(advanceAmount) - parseFloat(values);
     $("#advanceamount").val(total);
}


function clearDetails(){
     //var bill=$('#purchaseBill option:selected').text();
     $('#saleBill option[value=""]').attr('selected','selected');
     $('#saleBill').val("");
     $('#billDate').val("");
      $('#billAmount').val("");
      $('#adjustedAmount').val("");
      return false;
}

function rowValidation(){
     var customerBillMasterId = $('#saleBill').val();
     var adjustedAmount = parseFloat($('#adjustedAmount').val()||0);
     var advanceAmount = $('#advanceamount').val()||0;
     var unreceiptAmt = parseFloat($("#billAmount").val()||0);
    
     var tempTotalAdjust = parseFloat(calculateTotalAdjustment());
     var sumofAll =parseFloat(tempTotalAdjust + advanceAmount);
     
   //  alert(tempTotalAdjust);
   //  alert(sumofAll);
     
     if(unreceiptAmt==0){return false;}
     if(adjustedAmount==0){return false;}
     if(customerBillMasterId!=""){
         if(BillExist(customerBillMasterId)){
            return false;
         }
    }else{
        return false;
    }
    
    if(unreceiptAmt!=0){
        if(adjustedAmount!=0){
            if(adjustedAmount<=unreceiptAmt){
                return true;
            }else{return false;}
        }else{return false;}
    }else{
        return false;
    }
    
    
  /*  if(sumofAll!=0){
        if(sumofAll<tempTotalAdjust){
            return false;
        }else{
            return true;
        }
        
    }else{
        return false;
    }
    */
   
    
   
   
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

function calculateTotalAdjustment(){
    var totalAdjustment=0;
    var adjustedAmount=0;
    $("#billAdjustTable tr:gt(0)").each(function () {
            var this_row = $(this);
            // vendorBillMasterId = $.trim(this_row.find('td:eq(0)').children('input').val());//td:eq(0) means first td of this row
             adjustedAmount = parseFloat($.trim(this_row.find('td:eq(3)').html()));
           
            totalAdjustment = parseFloat(totalAdjustment + adjustedAmount);
            
        });
        return totalAdjustment;
}


function createDetails(){
    //var rowCount = $('#billAdjustTable tr').length;
    //console.log(rowCount+" :AAAA");
    
     var DetailJSON = { adjustmentDetails: [] };
        
        var customerBillMasterId = 0;
        var adjustedAmount =0;
       

        $("#billAdjustTable tr:gt(0)").each(function () {
            var this_row = $(this);
             customerBillMasterId = $.trim(this_row.find('td:eq(0)').children('input').val());//td:eq(0) means first td of this row
             adjustedAmount = parseFloat($.trim(this_row.find('td:eq(3)').html()));
           
            if(customerBillMasterId!=""){
            DetailJSON.adjustmentDetails.push({
                 "customerBillMasterId": customerBillMasterId,
                 "adjustedAmount":adjustedAmount
             });
            }
            
        });
        return DetailJSON;
}
