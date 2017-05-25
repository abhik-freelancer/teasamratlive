$(document).ready(function(){
$( ".legal-menu"+$('#reportmenu').val() ).addClass( " collapse in " );
$( ".purchaseregistergroupwise").addClass( " active " );
});

$(function() {
     var basepath = $("#basepath").val();



    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;

    var currentDate = new Date();
		

    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
    });

    $("#group").customselect();
    
	
    $("#grpwise_purchase").click(function(){
		
		var group = $("#group option:selected").val();
		if(group==0)
		{
			$("#selectgrperr").css("display","table-row");
			return false;
		}
		else
		{
		$("#selectgrperr").css("display","none");
        $("#frmpurchaseRegister").submit();
		}
    });
	
	
    
    
});