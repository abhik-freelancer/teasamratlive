$(document).ready(function() {
    
$( ".legal-menu"+$('#transactionmenu').val() ).addClass( " collapse in " );
$( ".unreleaseddo").addClass( " active " );

    var basepath = $("#basepath").val();

    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;

    var currentDate = new Date();
    var dtPickerClassId = '';

    
   
    
   /*$(document).on('click', '.datepicker', function() {
        $(this).datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: mindate,
            maxDate: maxDate
        });
   });
    */
   
$('#table').dataTable( {
"fnDrawCallback":function(){ $('.datepicker').datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: mindate,
            maxDate: maxDate
});}
});
    
    

    
    $("#showdo").click(function() {
        $("#frmunrealeased").submit();

    });

});
function updateDoReleased(pdtlId, Serial) {
    var basepath = $("#basepath").val();
    var pdtlIds = pdtlId;
    var serialId = Serial;
    var jdo_no = "#txt_do" + serialId;
    var deliveryorder = $(jdo_no).val();
    var jdo_date = "#do_reli_date" + serialId;
    var do_date = $(jdo_date).val();
    var error = 0;
   

    if (do_date == '')
    {
        error = 1;
        $(jdo_date).addClass("glowing-border");
    }
    if (deliveryorder == '')
    {
        error = 1;
        $(jdo_no).addClass("glowing-border");
    }

    if(error!=1){
         $("#loaderDiv").show();
    $.ajax({
        url: basepath + "unreleaseddo/updateDo",
        type: 'post',
        data: {donumber: deliveryorder, doDate: do_date, purchaseDetailsId: pdtlIds},
        success: function(data) {
           
            $("#loaderDiv").hide();
           
        },
        error: function(e) {
           console.log(e.message);
        }
    });//ajax
    }else{
        alert("Delivery No & Delivery Date is mandatory... ");
    }


}
