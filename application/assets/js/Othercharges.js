/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    
    var basepath = $("#basepath").val(); 
    
    

    
    $(".othrschrgsave").click(function(){
        var Id = $("#othrgsId").val()||0;
        var  desc =$("#othrgs").val()||"";
        var  code = $("#othrgscode").val()||"";
        var  gstAccountId = $("#account").val()||0;
       
       if(validate()){ 
       $.ajax({
            type: "POST",
            url: basepath + "Othercharges/saveData",
            dataType: "json",
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            data: {Id:Id,desc:desc,code:code,account: gstAccountId},
            success: function (result) {
                if (result.status==1) {
                    window.location = basepath + "Othercharges";
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
         var  desc =$("#othrgs").val()||"";
        var  code = $("#othrgscode").val()||"";
        var  gstAccountId = $("#account").val()||0;
        
        if(desc==""){return false;}
        if(code==""){return false;}
        
        if(gstAccountId==""){return false;}
       
    
    return true;
}