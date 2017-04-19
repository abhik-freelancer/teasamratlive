$(document).ready(function(){
$( ".legal-menu"+$('#reportmenu').val() ).addClass( " collapse in " );
$( ".salebillregister").addClass( " active " );
});

$(function() {
     var basepath = $("#basepath").val();

    $(".mini").click(function() {


        $('#edit').css('visibility', 'visible');
        $('#del').css('visibility', 'visible');
    });




    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;

    var currentDate = new Date();


    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
       // minDate: mindate,
       // maxDate: maxDate
    });

   
     $("#customer").customselect();
   
   
     $("#salebill_register").click(function() {
       

        var customer = $("#customer option:selected").val();
        var startdate = $('#startdate').val();
       
        var enddate = $('#enddate').val();
        var product = $('#product').val()||0;
        
         if(startdate==""){
           $('#startdate').addClass("glowing-border");
           $('#enddate').removeClass("glowing-border");
            return false;
        }
         if(enddate==""){
          $('#enddate').addClass("glowing-border");
          $('#startdate').removeClass("glowing-border");
            return false;
        }
          
        else{
             $("#loader").show();
         $("#details").css("display", "block"); 
         
        $.ajax({
            type: "POST",
            url: basepath + "salebillregister/getSalebillRegister",
            data: { startdate: startdate, enddate: enddate,
             customer: customer,product:product},
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
   

    });
    
   
   
     $("#print_salebill_register").click(function() {
         
        var startdate = $('#startdate').val();
        var enddate = $('#enddate').val();
      
         if(startdate==""){
           $('#startdate').addClass("glowing-border");
           $('#enddate').removeClass("glowing-border");
            return false;
        }
         if(enddate==""){
          $('#enddate').addClass("glowing-border");
          $('#startdate').removeClass("glowing-border");
            return false;
        }
        else{
       $("#frmSalebillReg").submit();
        }
       
     
    });
    
  
    
    
});

