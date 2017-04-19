 
$(document).ready(function() {

          /*    $( ".legal-menu"+$('#reportmenu').val() ).addClass( " collapse in " );
		$( ".trialbalancedetail").addClass( " active " );
		$(".scmenu3").removeClass("collapse");
    */
   // var basepath = $("#basepath").val();
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;
   

    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
    });
    
      $("#account").customselect();
   
    //Print sale tax register
     $("#showtrialbalancepdf").click(function(){
        var fromdate = $("#fromdate").val();
        var todate = $("#todate").val();
        var account = $("#account").val();
        
        if(fromdate==""){
             $("#fromdate").addClass("glowing-border");
             $("#todate").removeClass("glowing-border");
             $("#account").removeClass("glowing-border");
             return false;
        }
         if(todate==""){
             $("#todate").addClass("glowing-border");
             $("#fromdate").removeClass("glowing-border");
             $("#account").removeClass("glowing-border");
             return false;
        }
         if(account=="0"){
            $("#account_err").css("display","block");
             return false;
        }
        
        
        else{
            if(account!="0"){
             $("#account_err").css("display","none");
        }
             $("#generalledgerreport").submit();
        }
       
        
    });
    
    
});
    
     
    

   
 




  
  

