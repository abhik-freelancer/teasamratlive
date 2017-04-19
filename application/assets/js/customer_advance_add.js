$(document).ready(function(){
    
$( ".legal-menu"+$('#advancepayment').val() ).addClass( " collapse in " );
$( ".customeradvance").addClass( " active " );  
    
    var basepath = $("#basepath").val();
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;
    
     $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
        
    });
    //chqDt
     $('.chqDt').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
        
    });
    
     $("#customeradvance").customselect();
    
    $('#paymentamount').keypress(function(event){
       return isNumber(event, this);
    })
   
    $('#saveCustomerAdvance').click(function(){
        
        if(getValidation()){
            
              var formData = $("#addcustomeradvance").serialize();
              var modeop= $('#mode').val();
              formData = decodeURI(formData);
              console.log(formData);
              $("#saveCustomerAdvance").css("display","none");
              $.ajax(
                    {
                        type: 'POST',
                        dataType: 'json',
                        url: basepath + "customeradvance/saveCustomerAdvance",
                        data: {formDatas: formData,mode:modeop},
                        success: function(data) {

                            if (data == 1) {
                                $("#dialog-new-save").dialog({
                                    resizable: false,
                                    height: 140,
                                    modal: true,
                                    buttons: {
                                        "Ok": function() {
                                            window.location.href = basepath +'customeradvance';
                                            $(this).dialog("close");
                                        }
                                    }
                                });
                            } else {
                                $("#dialog-error-save").dialog({
                                    resizable: false,
                                    height: 140,
                                    modal: true,
                                    buttons: {
                                        "Ok": function() {
                                            $(this).dialog("close");
                                             $("#saveCustomerAdvance").css("display","block");
                                        }
                                    }
                                });
                            }
                        },
                        complete: function() {
                        },
                        error: function(e) {
                            //called when there is an error
                            console.log(e.message);
                        }
                    });
            
        }else{
            $("#dialog-validationError").dialog({
                                    resizable: false,
                                    height: 200,
                                    width:400,
                                    modal: true,
                                    buttons: {
                                        "Ok": function() {
                                              $(this).dialog("close");
                                        }
                                    }
                                });
            
            
        }
        
        
    });
    
    
});
//----------------------------------------------------------//
function getValidation(){
    var voucherDate = $("#dateofadvance").val();
    var cashorbank=$("#cashorbank").val();
    var paymentamount =$('#paymentamount').val();
    var customer = $('#customeradvance').val();
    if(voucherDate==""){ return false;}
    if(cashorbank==""){return false;}
    if(paymentamount==""){return false;}
    if(customer==""){return false;}
    
    return true;
    
}
function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }    
