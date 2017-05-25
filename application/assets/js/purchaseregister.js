$(document).ready(function(){
$( ".legal-menu"+$('#reportmenu').val() ).addClass( " collapse in " );
//$( ".purchaseregister").addClass( " active " );
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
        minDate: mindate,
        maxDate: maxDate
    });
    
    $("#vendor").customselect();
    $("#saleno").customselect();
    $("#group").customselect();
    
	
    

   // $("#startdate").val(mindate);
  //  $("#enddate").val(maxDate);
/*
    $("#saledate").change(function() {

        var saledate = $("#saledate").val().split("-");
        var sale = saledate[1] + '/' + saledate[0] + '/' + saledate[2];
        dtNextWeek = new Date(sale);
        dtNextWeek.setDate(dtNextWeek.getDate() + 14);
        var month = dtNextWeek.getMonth() + parseFloat(1);
        if (month < 9)
        {
            month = '0' + month;
        }

        var promtdate = dtNextWeek.getDate() + '-' + month + '-' + dtNextWeek.getFullYear();
        $('#promtdate').val(promtdate);
    });*/
    
    
    
    
     $("#purchase_register").click(function() {
       

        var vendor = $("#vendor option:selected").val();
        var startdate = $('#startdate').val();
       
        var enddate = $('#enddate').val();
      //  var group= $('#group option:selected').val();
        var saleno= $('#saleno option:selected').val();
        var purchasetype= $('#purchasetype option:selected').val();
        var purchasearea = $('#auctionArea option:selected').val();
        
         if(startdate==""){
            alert("Enter Start Date");
            return false;
        }
         if(enddate==""){
            alert("Enter End Date");
            return false;
        }
          
        else{
             $("#loader").show();
         $("#details").css("display", "block"); 
         
        $.ajax({
            type: "POST",
            url: basepath + "purchaseregister/getlistpurchaseregister",
            data: {vendor: vendor, startdate: startdate, enddate: enddate,
             saleno: saleno,purchasetype:purchasetype,purchasearea:purchasearea},
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
    
    
    
   /* $("#purchase_register_print").click(function() {
       

        var vendor = $("#vendor option:selected").val();
        var startdate = $('#startdate').val();
       
        var enddate = $('#enddate').val();
        var saleno= $('#saleno option:selected').val();
        var purchasetype= $('#purchasetype option:selected').val();
        var purchasearea = $('#auctionArea option:selected').val();
        
         if(startdate==""){
            alert("Enter Start Date");
            return false;
        }
         if(enddate==""){
            alert("Enter End Date");
            return false;
        }
          
        else{
             $("#loader").show();
         $("#details").css("display", "block"); 
         
        $.ajax({
            type: "POST",
            url: basepath + "purchaseregister/getPurchaseRegisterPrint",
            data: {vendor: vendor, startdate: startdate, enddate: enddate,
             saleno: saleno, purchasetype:purchasetype,purchasearea:purchasearea},
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
   

    });*/
    
    
    $("#purchase_register_print").click(function(){
        $("#frmpurchaseRegister").submit();
    });
	
	 $("#purchasereg_new_print").click(function(){
        $("#frmNewpurchaseReg").submit();
    });
    
    
    
});