/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    
$( ".legal-menu"+$('#advancepayment').val() ).addClass( " collapse in " );
$( ".customeradvance").addClass( " active " );  



var basepath = $("#basepath").val();           


    
    
    
});


function delCustomerAdvance(id,voucher)
{
	$("#voucher_no-info").text(voucher);
	$("#dialog-confirm-cusadv").dialog({
        resizable: false,
        height: 140,
        modal: true,
        buttons: {
            "Ok": function() {
				$(this).dialog("close");	
				var basepath = $("#basepath").val();
				$.ajax({
					type: 'POST',
					url: basepath + "customeradvance/delCustomerAdvance",
					data:{"cusadvid":id},
					dataType:'html',
					success: function (data) 
					{
						if(data=="OK")
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
						if(data=="FK")
						{
							//alert("This voucher is used.");
							$("#dialog-used-vouchr").dialog({
								resizable: false,
								height: 140,
								modal: true,
								buttons: {
								"Ok": function(){
									$(this).dialog("close");	
									return false;
									}
								}
							});
							
						}
						if(data=="ERROR")
						{
							alert("There is some problem please try again later.");
							return false;
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