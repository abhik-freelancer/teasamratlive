$(document).ready(function() {
    $( ".legal-menu"+$('#reportmenu').val() ).addClass( " collapse in " );
    $( ".stocksummery").addClass( " active " );

    var basepath = $("#basepath").val();

    $("#stkreport").click(function() {
        
        
       
        var group_id =$("#group_code option:selected").val();
        var fromPrice = $("#fromPrice").val();
        var toPrice = $("#toPrice").val();
        
      /* if(fromPrice>toPrice){
           alert("Error in price range");
           return false;
       }*/
        
        $("#popupdiv").show("clip", 500); 
        $.ajax({
            url: basepath + "stocksummery/getStock",
            type: 'post',
            data: {groupId:group_id,fromPrice:fromPrice,toPrice:toPrice},
            dataType: 'html',
            success: function(data) {
                $('#popupdiv').html(data);
            },
            complete: function() {
            },
            error: function(e) {
               console.log(e.message);
            }
        });
    

    });
    
    
$(document).on('keyup', '#fromPrice', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });

$(document).on('keyup', '#toPrice', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });

    
    $("#stkreportPrint").click(function() {
         var group_id =$("#group_code option:selected").val();
        var fromPrice = $("#fromPrice").val();
        var toPrice = $("#toPrice").val();
        
       if(fromPrice>toPrice){
           alert("Error in price range");
           return false;
       }
        else{
       $("#frmStock").submit();
        }
       
     
    });
    
  $("#stkreportPrint").click(function(){
    $.ajax({url:basepath+'stocksummery/getPdfheaderView',
        success:function(data){
            
     // $("#div").html(data);
    }});
  });

});
