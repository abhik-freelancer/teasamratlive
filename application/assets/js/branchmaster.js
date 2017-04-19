$(document).ready(function(){

  $(".legal-menu" + $('#mastermenu').val()).addClass(" collapse in ");
  $(".branchmaster").addClass(" active ");

    var basepath = $("#basepath").val();
    $("#saveBranchmaster").click(function(){
       if(validation()){
           var formData = $("#branchMaster").serialize();
           var mode=$("#txtModeOfoperation").val();
           var branchmasterid = $("#branchmasterid").val();
       
               formData = decodeURI(formData);
                $.ajax({
                     url: basepath + "branchmaster/SaveData",
                     type: 'post',
                     data: {mode:mode,branchmasterid:branchmasterid,formDatas:formData},
                      success: function(data) {
                          if(data==1){
                               
                                $( "#branch_save_dilg" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                     window.location.href = basepath + 'branchmaster';
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
          
               $( "#branch_validate_error" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                   
                                                    $( this ).dialog( "close" );
                                                }
                                              }
                                            });
        }
    
});


});
 function validation(){
      
      var branchname = $("#branchname").val();
      
      if(branchname==""){
      $("#branchname").addClass("glowing-border");
         return false;
      }
       
       else{
           return true;
       }
   }