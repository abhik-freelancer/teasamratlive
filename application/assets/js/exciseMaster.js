$(document).ready(function(){
    

  $(".legal-menu" + $('#mastermenu').val()).addClass(" collapse in ");
    $(".excisemaster").addClass(" active ");
	
 
         var basepath = $("#basepath").val();

    $("#saveexciseMaster").click(function(){
       // var UnitName = $("#unitmaster").val();
       // var formData = $("#UnitMaster").serialize();
      if(validation()){
           var formData = $("#ecciseMaster").serialize();
           var mode=$("#txtModeOfoperation").val();
           var excisemasterid = $("#excisemasterid").val();
       
               formData = decodeURI(formData);
                $.ajax({
                     url: basepath + "excisemaster/SaveData",
                     type: 'post',
                     data: {mode:mode,excisemasterid:excisemasterid,formDatas:formData},
                      success: function(data) {
                          if(data==1){
                                //  alert('Data Saved successfully');
                                //    window.location.href = basepath +'unitmaster';
                                 $( "#unit_save_dilg" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                     window.location.href = basepath + 'excisemaster';
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

$(document).on('keyup', '.rate', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });

});
 function validation(){
      
       var rate=$("#rate").val();
      
       if(rate==""){
            $("#rate").addClass("glowing-border");
        return false;
       }
       
       else{
           return true;
       }
   }