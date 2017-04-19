$(document).ready(function(){
 $(".legal-menu" + $('#mastermenu').val()).addClass(" collapse in ");
    $(".rawmaterial ").addClass(" active ");
        
         var basepath = $("#basepath").val();

    $("#saveRawmaterial").click(function(){
       // var UnitName = $("#unitmaster").val();
       // var formData = $("#UnitMaster").serialize();
      if(validation()){
           var formData = $("#rawMaterial").serialize();
           var mode=$("#txtModeOfoperation").val();
           var rawmaterialid = $("#rawmaterialid").val();
           
       
               formData = decodeURI(formData);
                $.ajax({
                     url: basepath + "rawmaterial/SaveData",
                     type: 'post',
                     data: {mode:mode,rawmaterialid:rawmaterialid,formDatas:formData},
                      success: function(data) {
                          if(data==1){
                                 $( "#raw_material_save" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                     window.location.href = basepath + 'rawmaterial';
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
               $( "#rawmaterial_validate_error" ).dialog({
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
       var UnitId = $("#unitid").val();
       var rate=$("#rate").val();
       if(UnitId=="0"){
         $("#unitid").addClass("glowing-border");
        return false;
       }
      /* if(rate==""){
            $("#rate").addClass("glowing-border");
        return false;
       }*/
       
      
           return true;
      
   }