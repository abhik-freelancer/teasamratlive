 
$(document).ready(function() {

    /*$(".legal-menu" + $('#transactionmenu').val()).addClass(" collapse in ");
    $(".journalvoucher").addClass(" active ");*/
    
    $( ".legal-menu"+$('#mastermenu').val() ).addClass( " collapse in " );
		$( ".voucherlist").addClass( " active " );
		$(".scmenu3").removeClass("collapse");


    var basepath = $("#basepath").val();
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;
   

    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
    });
    
    
   $("#showvoucherlist").click(function(){
        var purchasetype = $("#purchasetype").val();
        var fromdate = $("#fromdate").val();
        var todate = $("#todate").val();
        
        if(fromdate==""){
             $("#fromdate").addClass("glowing-border");
                $("#todate").removeClass("glowing-border");
             return false;
        }
         if(todate==""){
             $("#todate").addClass("glowing-border");
              $("#fromdate").removeClass("glowing-border");
             return false;
        }
        else{
         $("#loader").show();
          $("#details").css("display", "block"); 
             $.ajax({
            url: basepath + "voucherlist/showvoucherList",
            type: 'post',
            dataType:'html',
            data: {fromdate:fromdate,todate:todate,purchasetype:purchasetype},
             success: function(data) {
                $('#details').html(data);
             
            },
            complete: function(data) {
                $("#loader").hide();
                 
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });
     }
        
    });
  
    
  /*  $("#showvoucherlist").click(function(){
                       $("#frmvoucherlist").submit();
			
		});*/
                
    
    
    
});
    
     
    

   
 




  
  

