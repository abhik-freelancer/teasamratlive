/**
*@add blending [addBlendingJS.js]
*@08/09/2015 
*/
$(document).ready(function(){
    
$( ".legal-menu"+$('#transactionmenu').val() ).addClass( " collapse in " );
$( ".companymaster").addClass( " active " );   
    
    
    
 var basepath = $("#basepath").val();           

   
   
    $("#addnew").click(function() {

        $("#spinner").show();
        $("#frmCompany").submit();

    });


 
 
});
// document load

