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
 
 
  $('#exampleTable').dataTable( {
        "aoColumns": [
            null,
            { "sType": "date-uk" },
            null,
            null,
            null
        ]
    });
 
 
 
});



// For Date Sorting
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
"date-uk-pre": function ( a ) {
    var ukDatea = a.split('-');
    return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
},

"date-uk-asc": function ( a, b ) {
    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
},

"date-uk-desc": function ( a, b ) {
    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
}
} );







// document load

