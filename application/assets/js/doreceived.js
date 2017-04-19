$(document).ready(function() {
$( ".legal-menu"+$('#transactionmenu').val() ).addClass( " collapse in " );
$( ".doproductrecv").addClass( " active " );
     

    var basepath =  $("#basepath").val();
    
   
    
         var session_strt_date = $('#startyear').val();
	 var session_end_date = $('#endyear').val();
	 var mindate = '01-04-'+session_strt_date;
	 var maxDate = '31-03-'+session_end_date ;
	 
	 var currentDate = new Date();
         var dtPickerClassId = '';
         
         
        /* $('.datepicker').each(function(){
                $(this).datepicker({
	 	dateFormat: 'dd-mm-yy', 
		minDate: mindate,
		maxDate: maxDate
		});
});*/

$('#doRcvTable').dataTable( {
"fnDrawCallback":function(){ $('.datepicker').datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: mindate,
            maxDate: maxDate
});}
});   
        
    
    $("#trnsporterdo").click(function(){
                       $("#frmgoodsRcv").submit();
			
		});
                
    
	 
	

});
function updateRecvDo(transDoRecvId,Serial){
       
    // var load = "#loading"+Serial;
        // $(load).show();
        var basepath = $("#basepath").val();
        var jShortageKg ="#txtShortKg"+Serial;
       //var shortage = $(jShortageKg).val();
        var jChallan = "#txtChallan"+Serial;
        var challan = $(jChallan).val();
        var jChallanDt = "#challan"+Serial;
        var ChallanDt = $(jChallanDt).val();
        var jLocationId = "#loaction"+Serial;
        var LocationId = $(jLocationId).val();
		var jPurDtl = "#purDtlId"+Serial;
		var purchaseDtl = $(jPurDtl).val();
        
        var jIsStock = "#chkStock"+Serial;
        if($(jIsStock).prop("checked") == true){
            isStock = 'Y';
            
        }else{
            isStock = 'N';
            $(jShortageKg).val('');
            $(jChallan).val('');
            $(jChallanDt).val('');
            $(jLocationId).val('0');
        }
	//alert();

    $.ajax({
        url: basepath + "doproductrecv/updateDoReceived",
        type: 'post',
        data: {Challan:challan,ChallanDate:ChallanDt,trnsDo:transDoRecvId,IsStk:isStock,location:LocationId,purDtlId:purchaseDtl},
        success: function(data) {
            if(data==2){
			
			 $( "#dialog-shortage-message" ).dialog({
                                    modal: true,
                                    height: 250,
                                    width: 300,
                                    buttons: {
                                    Ok: function() {
									location.reload(true);
                                    $( this ).dialog( "close" );
                                    }
                                    }
                                    });
			
			 
			}else{
			
			 $( "#dialog-message" ).dialog({
                                    modal: true,
                                    height: 250,
                                    width: 300,
                                    buttons: {
                                    Ok: function() {
                                    $( this ).dialog( "close" );
                                    }
                                    }
                                    });
			
			 	
			}
        },
        
        complete: function(){
         
          
        },
        error: function(e) {
            //called when there is an error
            //console.log(e.message);
        }
    });
}

/*
$(function() {
$( "#dialog-message" ).dialog({
modal: true,
buttons: {
Ok: function() {
$( this ).dialog( "close" );
}
}
});
});*/
