/**
*@add blending [addBlendingJS.js]
*@08/09/2015 
*/
$(document).ready(function(){
    
 $( ".legal-menu"+$('#transactionmenu').val() ).addClass( " collapse in " );
$( ".blending").addClass( " active " );   
    
    
    
 var basepath = $("#basepath").val();           
 $(".viewBlend").click(function(){
        var blendId=$(this).attr('id');
        var DtlId = blendId.split('_');
        var bl_id =DtlId[1]; 
        
         $.ajax(
                 {
                            type: 'POST',
                            dataType : 'html',
                            url: basepath + "blending/detailView",
                            data: {blendId:bl_id},
                            success: function(data) {
                                $("#dtlRslt").html(data);
                                
                                 $("#blend-Detail").dialog({
                                                        resizable: false,
                                                        height: 250,
                                                        width:500,
                                                        modal: true,
                                                        buttons: {
                                                            "Ok": function() {
                                                                
                                                                $(this).dialog("close");
                                                            }
                                                        }
                                                    });
                            },
                            complete: function() {
                            },
                            error: function(e) {
                                //called when there is an error
                                console.log(e.message);
                            }
                        });
        
 });
})
// document load

