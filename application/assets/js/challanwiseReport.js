$(document).ready(function(){
$( ".legal-menu"+$('#reportmenu').val() ).addClass( " collapse in " );
$( ".challanwisereport").addClass( " active " );
});


$(function(){
    var basepath =  $("#basepath").val();
    
      $("#challanno").customselect(); 
    
         
         
         
   $("#transporterid").change(function() {
        var transporterId = $("#transporterid").val();
       //alert(transporterId);
        
        $.ajax({
            url: basepath + "challanwisereport/getchallanno",
            type: 'post',
            data: {transporterid: transporterId},
            success: function(data) {
                $("#challan-drop").html(data);
            },
            complete: function() {
               
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });
    });




  /*
   * @date 19-01-2016
   * @author Mithilesh
   */
    
    $("#viewchallanReport").click(function(){
        
        if(validationDetails()){
        
        var basepath =  $("#basepath").val();
        var chalanno = $("#challanno").val();
        
        if(chalanno!="ALL"){
             $("#challanerror").css("display","none");
        }
        
        var transporterid = $("#transporterid option:selected").val();
       $("#details").css("display", "block"); 
          $("#loader").show();
        $.ajax({
            type: "POST",
            url: basepath + "challanwisereport/listchallanwisereport",
            data: {transporterid:transporterid,chalanno:chalanno},
            dataType: 'html',
            success: function(data) {
                $('#details').html(data);
             
            },
          complete:function(){
                 $("#loader").hide();
                        
            },
            error: function(e) {
               console.log(e.message);
            }

        });
        
        }
        else{
            $("#dialog-validation-save").dialog({
                resizable: false,
                height: 140,
                modal: true,
                buttons: {
                "Ok": function() {
                    $(this).dialog("close");
                     
                    }
                }
             }); 
        }
    });
    
      
      $("#pdfchallanReport").click(function(){
        
        if(validationDetails()){
              $("#frmChallanwisereport").submit();
          }else{
               $("#dialog-validation-save").dialog({
                resizable: false,
                height: 140,
                modal: true,
                buttons: {
                "Ok": function() {
                    $(this).dialog("close");
                     
                    }
                }
             }); 
          }
         });
         
         
         
         
      
      /* $("#pdfchallanReport").click(function(){
        var transporterid = $("#transporterid option:selected").val();
        var challanno = $("#challanno option:selected").val();
       /* alert(transporterid);
        
        
          window.open(basepath+"challanwisereport/getchallanwisereportPdf/"+transporterid+"/challanno/"+challanno);
       });*/
   
    
    });
    
    
    function validationDetails() {
    if(!transportervalidation()){return false;}
    if(!challannovalidation()){return false;}
    return true;
}

    function transportervalidation(){
      
        if($("#transporterid option:selected").val()=="0"){
                 $("#transporterid").addClass("glowing-border");
                 return false;
        }
        return true;
    }
    
    function challannovalidation(){
    if($('#challanno').val()=="ALL"){
       // $("#vendor").addClass("glowing-border");
        $("#challanerror").css("display","block");
        return false;
    }
    return true;
}
    
    

