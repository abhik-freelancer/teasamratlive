$(document).ready(function(){
    
    $( ".legal-menu"+$('#advancepayment').val() ).addClass( " collapse in " );
    $( ".vendorpayment").addClass( " active " );  

    
    
   var basepath = $("#basepath").val();
    
    $(document).on("click",".paymentDetails",function(){
        
       var vendorPaymentId = $(this).attr("id");
        $.ajax({
                type: 'POST',
                url: basepath + "vendorpayment/getDetailsOfInvoice",
                data: {
                    "vendorpaymentId":vendorPaymentId,
                },
                dataType:'html',
                success: function (data) {
                    
                    //alert(data);
                    $("#detailInvoice").html(data);
                        $( "#dialog-detail-view" ).dialog({
                            modal: true,
                            height:310,
                            width:550,
                            
                            buttons: {
                              Ok: function() {
                                $( this ).dialog( "close" );
                              }
                            }
                          });
                }
            });
        
    });
    
    
});