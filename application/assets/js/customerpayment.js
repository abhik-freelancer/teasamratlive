$(document).ready(function(){
    
    $( ".legal-menu"+$('#advancepayment').val() ).addClass( " collapse in " );
    $( ".customerpayment").addClass( " active " );  

    
    
   var basepath = $("#basepath").val();
    
    $(document).on("click",".paymentDetails",function(){
        
       var customerPaymentId = $(this).attr("id");
        $.ajax({
                type: 'POST',
                url: basepath + "customerpayment/getDetailsOfInvoice",
                data: {
                    "customerPaymentId":customerPaymentId,
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