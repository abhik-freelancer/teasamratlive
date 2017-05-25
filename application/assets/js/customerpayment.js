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
	
	
	/*
	$(document).on("click","#deleteCustomerRecpt",function(){
		var id = $(this).val();
	});
    */
    
});



function delCustomerReceipt(id,voucher)
{
	$("#voucher_no-info").text(voucher);
	$("#dialog-confirm-cutomer-receipt").dialog({
        resizable: false,
        height: 140,
        modal: true,
        buttons: {
            "Ok": function() {
				$(this).dialog("close");	
				var basepath = $("#basepath").val();
				$.ajax({
					type: 'POST',
					url: basepath + "customerpayment/deleteCutomerReceipt",
					data:{"customerPaymentId":id},
					dataType:'html',
					success: function (data) 
					{
						if(data==1)
						{
							
							$("#voucher_no-afterdlt").text(voucher);
							$("#dialog-confirm-delete").dialog({
								resizable: false,
								height: 140,
								modal: true,
								buttons: {
								"Ok": function(){
									$(this).dialog("close");	
									location.reload();
									}
								}
							});
							
						}
						else
						{
							alert("There is some problem please try again later.");
						}
					}
				});	
					
					
            },
            Cancel: function() {
				$(this).dialog("close");
			 }
        }
    });
	
	
}

