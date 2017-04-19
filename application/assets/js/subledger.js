$(document).ready(function(){
    
   $(".legal-menu" + $('#mastermenu').val()).addClass(" collapse in ");
    $(".subledger").addClass(" active ");
        
         var basepath = $("#basepath").val();

    $("#saveSubLedger").click(function(){
      
      if(validation()){
           var formData = $("#subledger").serialize();
           var mode=$("#txtModeOfoperation").val();
           var subledgerId = $("#subLedgerId").val();
       
               formData = decodeURI(formData);
                $.ajax({
                     url: basepath + "subledger/SaveData",
                     type: 'post',
                     data: {mode:mode,subLedgerid:subledgerId,formDatas:formData},
                      success: function(data) {
                          if(data==1){
                              
                              
                                //alert('Data Saved successfully');
                               // window.location.href = basepath +'subledger';
                                $( "#ledger_save_dilg" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                     window.location.href = basepath + 'subledger';
                                                    $( this ).dialog( "close" );
                                                }
                                              }
                                            });
                          }
                         
                           
                      },
                      complete: function() {
                
                    },
                     error: function(e) {
                
                console.log(e.message);
                     }
                });
                
        }
        else{
            
            $( "#ledger_validate_error" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                    // window.location.href = basepath + 'subledger';
                                                    $( this ).dialog( "close" );
                                                }
                                              }
                                            });
                //alert('Enter Subledger');
              //  return false;
        }
            
           
});

});
 function validation(){
       var SubLedger = $("#subLedger").val();
       if(SubLedger==""){
         $("#subLedger").addClass("glowing-border");
        return false;
       }
       else{
           return true;
       }
   }