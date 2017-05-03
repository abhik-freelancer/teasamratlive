$(document).ready(function(){
$( ".legal-menu"+$('#reportmenu').val() ).addClass( " collapse in " );
$( ".finishproductstock").addClass( " active " );
});

$(function() {
     var basepath = $("#basepath").val();
		 $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
       // minDate: mindate,
       // maxDate: maxDate
		});
	$("#finish_prd_btn_pdf").click(function(){
        $("#frmFinishPrdStock").submit();
    });
    
    
    
});