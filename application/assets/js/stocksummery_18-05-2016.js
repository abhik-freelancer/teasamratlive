$(document).ready(function() {
    $( ".legal-menu"+$('#reportmenu').val() ).addClass( " collapse in " );
    $( ".stocksummery").addClass( " active " );

    var basepath = $("#basepath").val();

    $("#stkreport").click(function() {
       
        var group_id =$("#group_code option:selected").val();
        $("#popupdiv").show("clip", 500); 
        $.ajax({
            url: basepath + "stocksummery/getStock",
            type: 'post',
            data: {groupId:group_id},
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
    
      $("#stkreportPrint").click(function() {
      
        $("#frmStock").submit();
    

    });
    
    
    


});
