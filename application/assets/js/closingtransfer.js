/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    
    $( ".legal-menu"+$('#Utilitymenu').val() ).addClass( " collapse in " );
    $( ".accountclosingtransfer").addClass( " active " );
     var basepath = $("#basepath").val();
     
    $("#transfer").click(function () {
        var fromYearId = $("#currentyearid").val();
        var toYearId = $("#nextyearid").val();
        $("#loader").show();
        $.ajax({
            type: "POST",
            url: basepath + 'accountclosingtransfer/transferclosing',
            dataType: "html",
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            data: {fromYearId:fromYearId,toYearId:toYearId},
            success: function (result) {
                $("#datadiv").html(result);
                $("#loader").hide();
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

    });
    

});