
$(document).ready(function(){
       $( ".legal-menu"+$('#mismenu').val() ).addClass( " collapse in " );
$( ".invoicestatus").addClass( " active " ); 
    
 var basepath = $("#basepath").val();
 $("#dropdown-garden").change(function() {
        var selectedgarden = $("#dropdown-garden").val();
       $("#dropdown-garden").removeClass("glowing-border");
       
       $("#dropdown-invoice").val('0');
       $("#dropdown-lot").val('0');
       $("#dropdown-grade").val('0');
       
        $("#imgInvoice").show();
        $.ajax({
            url: basepath + "invoicestatus/showInvoice",
            type: 'post',
            data: {garden: selectedgarden},
            success: function(data) {
                $("#drpInvoice").html(data);
            },
            complete: function() {
                $("#imgInvoice").hide();
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });
    });
    

     $(document).on('change', "#dropdown-invoice", function() {
        var selectedgarden = $("#dropdown-garden").val();
        var invoice = $("#dropdown-invoice").val();
        
        $("#dropdown-lot").val('0');
       $("#dropdown-grade").val('0');
      
        $("#dropdown-invoice").removeClass("glowing-border");
        $("#imgLot").show();
        $.ajax({
            url: basepath + "invoicestatus/showLotNumber",
            type: 'post',
            data: {garden: selectedgarden, invoice: invoice},
            success: function(data) {
                $("#drpLot").html(data);
            },
            complete: function() {
                $("#imgLot").hide();
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });
        
    });
     

//invoice dropdown change
//lot dropdown change
    $(document).on('change', "#dropdown-lot", function() {
        var selectedgarden = $("#dropdown-garden").val();
        var invoice = $("#dropdown-invoice").val();
        var lot = $("#dropdown-lot").val();
        
          $("#dropdown-grade").val('0');
        
        $("#dropdown-lot").removeClass("glowing-border");
        $("#imgGrade").show();
        $.ajax({
            url: basepath + "invoicestatus/showGrade",
            type: 'post',
            data: {garden: selectedgarden, invoice: invoice, lot: lot},
            success: function(data) {
                $("#drpGrade").html(data);
            },
            complete: function() {
                $("#imgGrade").hide();
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });

    });
        $(document).on('change', "#dropdown-grade", function() {
        $("#dropdown-grade").removeClass("glowing-border");
    });

    
   $("#viewStock").click(function() {

        if (showViewValidation())
        {
           
            var garden = $("#dropdown-garden").val();
            var invoice = $("#dropdown-invoice").val();
            var lot = $("#dropdown-lot").val();
            var grade = $("#dropdown-grade").val();
           // var purchaseId = getPurchaseId();
           // console.log("viewStock-"+purchaseId);
           // console.log(purExistInTable(purchaseId));
           
               // $("#loginBox").html();
                $("#stock_loader").show();
                $.ajax({
                    url: basepath + "invoicestatus/showTeaStock",
                    type: 'post',
                    data: {gardenId: garden, invoiceNum: invoice, lotNum: lot, grade: grade},
                    success: function(data) {
                                                if(data!=0){
                                                     $("#loginBox").empty();
                                                    $("#loginBox").append(data);
                                             }else{
                                                  //$("#loginBox").html();
                                                 //alert("no data--dialog-for-no-stock");
                                                $("#stock_loader").hide();
                                                  $("#dialog-for-no-stock").dialog({
                                                            resizable: false,
                                                            height: 140,
                                                            modal: true,
                                                            buttons: {
                                                                "Ok": function() {
                                                                    $(this).dialog("close");
                                                                     window.location.href = basepath+'invoicestatus';
                                                                    
                                                                }
                                                            }
                                                        });
                                             }
                    },
                    complete: function() {
                        $("#stock_loader").hide();
                    },
                    error: function(e) {
                        //called when there is an error
                        console.log(e.message);
                    }
                });
            } 
         else {
            return false;
        }
    });
    
$(".viewBlend").click(function(){
        var blendId=$(this).attr('id');
        var DtlId = blendId.split('_');
        var bagDtlId =DtlId[1]; 
       // var bl_DtlId=DtlId[1]; 
        
       // alert(bl_mastId);
       // alert(bagDtlId);
        
       $.ajax(
                 {
                            type: 'POST',
                            dataType : 'html',
                            url: basepath + "invoicestatus/detailView",
                            data: {bagDtlId:bagDtlId},
                            success: function(data) {
                                $("#dtlRslt").html(data);
                                
                                 $("#blend-Detail").dialog({
                                                        resizable: false,
                                                        height: 300,
                                                        width:600,
                                                        modal: true,
                                                        buttons: {
                                                            "Ok": function() {
                                                                
                                                                $(this).dialog("close");
                                                            }
                                                        }
                                                    });
                            },
                            complete: function() {
                            },
                            error: function(e) {
                                //called when there is an error
                                console.log(e.message);
                            }
                        });
        
 });


});
    
   
   function showViewValidation(){
       var garden = $("#dropdown-garden").val();
       var invoice = $("#dropdown-invoice").val();
       var lot = $("#dropdown-lot").val();
       var grade = $("#dropdown-grade").val();
            if (garden == 0) {
            $("#dropdown-garden").addClass("glowing-border");
            return false;
            }
            if (invoice == 0) {
                $("#dropdown-invoice").addClass("glowing-border");
                return false;
            }
            if (lot == 0) {
                $("#dropdown-lot").addClass("glowing-border");
                return false;
            }
            if (grade == 0) {
                $("#dropdown-grade").addClass("glowing-border");
                return false;
            }
        return true;
       } 
    function showBlendingDtl(id){
       var blendDtlId = id;
      // alert(blendDtlId);
    }
