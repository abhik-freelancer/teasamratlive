/**
*@
*@08/09/2015 
*/
$(document).ready(function(){
    
$( ".legal-menu"+$('#mastermenu').val() ).addClass( " collapse in " );
$( ".productpacketrate").addClass( " active " );   
    
 $('#saleRate').DataTable();   
 $(document).on('keyup', '.salerate', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        }
        
    });
 })
// document load

function saveSaleRate(id)
{
    var rate_id=id;
 $("#loaderDiv").show();
 var basepath = $("#basepath").val();
 var sale_rate_id="#SalerateId_"+rate_id;
 var rateValue=$(sale_rate_id).val();

var sale_net_id="#SaleNetId_"+rate_id;
 var netValue=$(sale_net_id).val();

    // alert(rateValue);

 $.ajax({
        url: basepath + "productpacketrate/updateSaleRate",
        type: 'post',
        data: {productpacketid: rate_id, saleRate:rateValue,salenet:netValue},
        success: function(data) {
           if(data=="1")
           {
               $("#dialog-for-id-in-sale-rate-succ").dialog({
                                                            resizable: false,
                                                            height: 140,
                                                            modal: true,
                                                            buttons: {
                                                                "Ok": function() {
                                                                     window.location.href = basepath+'productpacketrate';
                                                                    $(this).dialog("close");
                                                                }
                                                            }
                                                        });
           }
           else
           {
                              $("#dialog-for-id-in-sale-rate-fail").dialog({
                                                            resizable: false,
                                                            height: 140,
                                                            modal: true,
                                                            buttons: {
                                                                "Ok": function() {
                                                                    $(this).dialog("close");
                                                                }
                                                            }
                                                        });
           }
          
           $("#loaderDiv").hide();
         },
        error: function(e) {
            //called when there is an error
            //console.log(e.message);
        }
    });
}