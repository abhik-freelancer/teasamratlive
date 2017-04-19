$(document).ready(function(){
    
    $(".legal-menu" + $('#mastermenu').val()).addClass(" collapse in ");
    $(".unitmaster").addClass(" active ");
        
         var basepath = $("#basepath").val();

    $("#saveUnitMaster").click(function(){
       // var UnitName = $("#unitmaster").val();
       // var formData = $("#UnitMaster").serialize();
      if(validation()){
           var formData = $("#UnitMaster").serialize();
           var mode=$("#txtModeOfoperation").val();
           var unitId = $("#unitId").val();
       
               formData = decodeURI(formData);
                $.ajax({
                     url: basepath + "unitmaster/SaveData",
                     type: 'post',
                     data: {mode:mode,unitId:unitId,formDatas:formData},
                      success: function(data) {
                          if(data==1){
                                //  alert('Data Saved successfully');
                                //    window.location.href = basepath +'unitmaster';
                                 $( "#unit_save_dilg" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                     window.location.href = basepath + 'unitmaster';
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
                // alert('Enter Unit Name');
              // return false;
               $( "#unit_validate_error" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                    // window.location.href = basepath + 'subledger';
                                                    $( this ).dialog( "close" );
                                                }
                                              }
                                            });
        }
    
});

});
 function validation(){
       var UnitName = $("#unitmaster").val();
       if(UnitName==""){
         $("#unitmaster").addClass("glowing-border");
        return false;
       }
       else{
           return true;
       }
   }