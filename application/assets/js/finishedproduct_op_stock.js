$(document).ready(function(){
 $(".legal-menu" + $('#mastermenu').val()).addClass(" collapse in ");
    $(".finishedproductopeningstock ").addClass(" active ");
        
         var basepath = $("#basepath").val();

   $("#saveFinishedOpStock").click(function(){
       
        var mode=$("#txtModeOfoperation").val(); 
       
        if(mode=="Add"){
            
      if(validation()){
           var formData = $("#finished_prd_op_stck").serialize();
           var mode=$("#txtModeOfoperation").val();
           var finishedPrdctOPStockId = $("#finishedPrdOpstockId").val();
       formData = decodeURI(formData);
                $.ajax({
                     url: basepath + "finishedproductopeningstock/SaveData",
                     type: 'post',
                   
                     data: {mode:mode,finishedPrdctOPStockId:finishedPrdctOPStockId,formDatas:formData},
                      success: function(data) {
                       if(data){
                             $("#finished_prd_OP_stock").dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                    window.location.href = basepath + 'finishedproductopeningstock/addFinishedPrdctOPStock';
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

                    }
    
    if(mode=='Edit'){
            
      if(validation()){
           var formData = $("#finished_prd_op_stck").serialize();
           var mode=$("#txtModeOfoperation").val();
           var finishedPrdctOPStockId = $("#finishedPrdOpstockId").val();
       
               formData = decodeURI(formData);
                $.ajax({
                     url: basepath + "finishedproductopeningstock/SaveData",
                     type: 'post',
                  
                     data: {mode:mode,finishedPrdctOPStockId:finishedPrdctOPStockId,formDatas:formData},
                      success: function(data) {
                       if(data){
                              
                             $( "#finished_prd_OP_stock" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                     window.location.href = basepath + 'finishedproductopeningstock';
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
        
    }
        
    
});


 $(document).on('keyup', '#opening_blnc', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });

    
});
$(document).on("change", "#product_packet",function(){
   
   //alert("H");
  checkFinishedProductExist()
});

function checkFinishedProductExist(){
    var basepath = $("#basepath").val();
    var finishedPrd = $("#product_packet").val();
   
        $.ajax({
            type: "POST",
            url: basepath + "finishedproductopeningstock/checkFinishedPrdExist",
            data: {finishedPrd:finishedPrd},
            dataType: 'html',
            success: function(data) {
               if(data==1){
                     $( "#dialog-check-finishedprd" ).dialog({
                            resizable: false,
                            height:140,
                            modal: true,
                            buttons: {
                            "Ok": function() {
                               $( this ).dialog( "close" );
                                $("#product_packet").val("0");
                                  $( "#product_packet" ).focus();
                                       } 
                                         }
                                        });
                                   }},
                            complete: function() {
                            },
                            error: function(e) {
                                //called when there is an error
                                console.log(e.message);
                            }
            
        
});
}

 function validation(){
       var openingBlnc = $("#opening_blnc").val();
       var product_packet=$("#product_packet").val();
       
        if(openingBlnc==""){
            $("#opening_blnc").addClass("glowing-border");
        return false;
       }
       if(product_packet=="0"){
         $("#product_packet").addClass("glowing-border");
        return false;
       }
      
       
      
           return true;
      
   }