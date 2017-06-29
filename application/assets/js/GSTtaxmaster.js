/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    $( ".legal-menu"+$('#transactionmenu').val() ).addClass( " collapse in " );
    $( ".GSTtaxinvoice").addClass( "active " );  
    var basepath = $("#basepath").val(); 
    
    
       $("#gstrate").keydown(function (event) {


        if (event.shiftKey == true) {
            event.preventDefault();
        }

        if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                (event.keyCode >= 96 && event.keyCode <= 105) ||
                event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190||event.keyCode==110) {

        } else {
            event.preventDefault();
        }

        if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
            event.preventDefault();
        //if a decimal has been added, disable the "."-button

    });
    
    $(".gstSave").click(function(){
        var gstId = $("#gstId").val()||0;
        var  GstDescription =$("#gstDesc").val()||"";
        var  gstType = $("#gsttype").val()||"";
        var  gstRate = $("#gstrate").val()||0;
        var  gstAccountId = $("#account").val()||0;
        var  gstUsedFor = $("#gstFor").val()||"";
       if(validate()){ 
       $.ajax({
            type: "POST",
            url: basepath + "GSTmaster/saveGSTData",
            dataType: "json",
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            data: {gstId:gstId,gstDesc:GstDescription,gsttype:gstType,gstrate:gstRate,account: gstAccountId,gstFor:gstUsedFor},
            success: function (result) {
                if (result.status==1) {
                    window.location = basepath + "GSTmaster";
                } else if (result.status == 0) {
                    alert("Data successfully not saved");
                    
                } else if (result.status == 3) {
                    window.location=basepath+"login";

                } 
                
            }, error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                alert(msg);
            }
        });
    }else{
        alert("All fields are mandatory");
        return false;
    }
    });
    
});

function validate(){
        var  GstDescription =$("#gstDesc").val()||"";
        var  gstType = $("#gsttype").val()||"";
        var  gstRate = $("#gstrate").val()||"";
        var  gstAccountId = $("#account").val()||"";
        var  gstUsedFor = $("#gstFor").val()||"";
        
        if(GstDescription==""){return false;}
        if(gstType==""){return false;}
        if(gstRate==""){return false;}
        if(gstAccountId==""){return false;}
        if(gstUsedFor==""){return false;}
    
    return true;
}