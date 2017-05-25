$(document).ready(function(){
$( ".legal-menu"+$('#reportmenu').val() ).addClass( " collapse in " );
$( ".rawmaterialproductwise").addClass( " active " );
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
       // minDate: mindate,
       // maxDate: maxDate
    });

    $("#rawmaterial").customselect();
   
    $("#print_rawmaterial_register").click(function(){
         
		var rawamtID = $("#rawmaterial").val();
		
		if(rawamtID==0)
		{
		   $("#selectRawmatProd").css("display","block");
		   return false;
		}
		else
		{
			$("#selectRawmatProd").css("display","none");
			$("#frmRawMatReg").submit();
		}
    });
    
});