$(document).ready(function(){
    var basepath = $("#basepath").val();
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;
    
      $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
        
    }).datepicker("setDate", "0");
    
    
    
    
    $('#vendor').change(function(){
        var vendorAccountId=$('#vendor').val()||0;
        $.ajax({
        url: basepath+'vendoradvanceadjustment/getAdvanceVoucher',
        data: {
            vendoraccId: vendorAccountId
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
        url: basepath+'vendoradvanceadjustment/addPurchaseBill',
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
    
   $(document).on('change','#advanceVoucher',function(){
      var advanceId = $('#advanceVoucher').val()||0;
      $.ajax({
        url: basepath+'vendoradvanceadjustment/getAdvanceAmountById',
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
   //purchaseBill
   $(document).on('change','#purchaseBill',function(){
      var vendorBillMasterId = $('#purchaseBill').val()||0;
      $.ajax({
        url: basepath+'vendoradvanceadjustment/getUnpaidBillAmount',
        data: { vendorBillMasterId: vendorBillMasterId},
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
   
   
   //$('#myTable > tbody:last-child').append('<tr>...</tr><tr>...</tr>');
   $('.add').click(function(){
       
      var bill=$('#purchaseBill option:selected').text();
      var vendorBillMasterId = $('#purchaseBill').val();
      var billDate = $('#billDate').val();
      var amount = parseFloat($('#billAmount').val()||0).toFixed(2);
      var adjusted = parseFloat($('#adjustedAmount').val()||0).toFixed(2);
      
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
               var totalAdjustment = calculateTotalAdjustment();
               $('#totalAdjustedAmount').val(totalAdjustment).toFixed(2);
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
   
   
   //+basepath+"application/assets/images/add_new.png"+
   
   $("#billAdjustTable").on('click', '.rowDel', function () {
        $(this).closest('tr').remove();
    });
    
    
    $('#saveVendorAdjustMent').click(function(){
       //console.log(createDetails());
       var refno=$('#txtRefNO').val();
       var dateofadjstment=$('#dateofadjustment').val();
       var vendorAccountId = $('#vendor').val();
       var advanceVoucherId =$('#advanceVoucher').val();
       var totalAdjustedAmount=$('#totalAdjustedAmount').val();
       var details = createDetails();
       
     
       if(validation()){
           $.ajax({
                type: 'POST',
                url: basepath + "vendoradvanceadjustment/SaveAdjustment",
                data: {
                    "refno":refno,
                    "dateofadjstment":dateofadjstment,
                    "vendorAccountId":vendorAccountId,
                    "advanceVoucherId":advanceVoucherId,
                    "totalAdjustment":totalAdjustedAmount,
                    "details":details
                },
             

                success: function (data) {
                    if (data == 1) {
                      
                        alert('Data successfully saved..');
                           window.location.href = basepath + 'vendoradvanceadjustment';
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
function clearDetails(){
     //var bill=$('#purchaseBill option:selected').text();
     $('#purchaseBill option[value=""]').attr('selected','selected');
     $('#purchaseBill').val("");
     $('#billDate').val("");
      $('#billAmount').val("");
      $('#adjustedAmount').val("");
      return false;
}
function validation(){
    var referenceno= $('#txtRefNO').val();
    var adjustmentDate = $('#dateofadjustment').val();
    var vendor = $('#vendor').val();
    var advancevoucher = $('#advanceVoucher').val();
    var advance = $('#advanceamount').val()||0;
    var totalAdjust = $('#totalAdjustedAmount').val()||0;
    if(referenceno==""){return false;}
    if(adjustmentDate==""){return false;}
    if(vendor==""){return false;}
    if(advancevoucher==""){return false;}
    if(advance==0){return false;}
    if(totalAdjust==0){return false;}
    
    return true;
}
function rowValidation(){
     var vendorBillMasterId = $('#purchaseBill').val();
     var adjustedAmount = $('#adjustedAmount').val()||0;
     var advanceAmount = $('#advanceamount').val()||0;
     //if(vendorBillMasterId==""){return false;}
     if(adjustedAmount==0){return false;}
     if(vendorBillMasterId!=""){
         if(BillExist(vendorBillMasterId)){
            return false;
         }
    }else{
        return false;
    }
    if(advanceAmount>0){
        return true;
    }else{
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
        
        var vendorBillMasterId = 0;
        var adjustedAmount =0;
       

        $("#billAdjustTable tr:gt(0)").each(function () {
            var this_row = $(this);
             vendorBillMasterId = $.trim(this_row.find('td:eq(0)').children('input').val());//td:eq(0) means first td of this row
             adjustedAmount = parseFloat($.trim(this_row.find('td:eq(3)').html()));
           
            if(vendorBillMasterId!=""){
            DetailJSON.adjustmentDetails.push({
                 "vendorBillMasterId": vendorBillMasterId,
                 "adjustedAmount":adjustedAmount
             });
            }
            
        });
        return DetailJSON;
}
//var thisMonthid = $(this).parent().parent().children('[id=MonthId]').children('input').val();