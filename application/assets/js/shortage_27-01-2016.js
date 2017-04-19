$(document).ready(function() {
    
     

    var basepath =  $("#basepath").val();
    
   
    
         var session_strt_date = $('#startyear').val();
	 var session_end_date = $('#endyear').val();
	 var mindate = '01-04-'+session_strt_date;
	 var maxDate = '31-03-'+session_end_date ;
	 
	 var currentDate = new Date();
         var dtPickerClassId = '';
         
         
         $('.datepicker').each(function(){
                $(this).datepicker({
	 	dateFormat: 'dd-mm-yy', 
		minDate: mindate,
		maxDate: maxDate
		});
});
        
    
    $("#shortage").click(function(){
                     $("#frmBagDtls").submit();
                      
   	});
                
    $('.groupOfTexbox').keypress(function (event) {
            
            return isNumber(event, this)

        });        
	 
	

});
function openShortage(bagdetail_id,serial){
    var basepath =  $("#basepath").val();
   
       $( "#dialog_shortage" ).dialog({
      resizable: false,
      height:200,
      modal: true,
      buttons: {
        "Save": function() {
            //alert(bagdetail_id);
            
        var noofbags = $("#txtnoofbags").val();
        var shortage =  $("#txtshortage").val(); 
        var jNet = "#txtnet_"+serial;
        var parentBagNet = $(jNet).val();
        var jAcutal ="#txtActual_"+serial;
        var parentActualBag = $(jAcutal).val();
        var jPurDtlId = "#purDtlId_"+serial;
        var purchaseDtlId = $(jPurDtlId).val();
        $.ajax({
        url: basepath + "shortageadjustment/addShortage",
        type: 'post',
        data: {bagDtlId:bagdetail_id,noBags:noofbags,shortage:shortage,pBagNet:parentBagNet,pActualBag:parentActualBag,purchaseDtlId:purchaseDtlId},
        success: function(data) {
                    
            $("#txtnoofbags").val('');
            $("#txtshortage").val(''); 
        },
        complete: function(){
          $("#txtnoofbags").val('');
          $("#txtshortage").val('');    
         location.reload(true);
          //window.location.href = basepath+'shortageadjustment';
        },
        error: function(e) {
            //called when there is an error
            //console.log(e.message);
        }
    });
             
     $( this ).dialog( "close" );
        },
        Cancel: function() {
           $("#txtnoofbags").val('');
           $("#txtshortage").val('');   
          $( this ).dialog( "close" );
        }
      }
    });
}

function updateShortage(bagDetailId,Serial){
    
     var basepath =  $("#basepath").val();
    
    
    var jShortKgs="#txtShortKgs_"+Serial;
    var Shortkgs= $(jShortKgs).val();
    
    var jnoShortBag="#noShortBag_"+Serial;
    var numOfShortBag =$(jnoShortBag).val();
    
    $("#txtnoofbags").val(numOfShortBag);
    $("#txtshortage").val(Shortkgs); 
    
    
     $( "#dialog_shortage" ).dialog({
      resizable: false,
      height:200,
      modal: true,
      buttons: {
        "Update": function() {
            
        var noofbags = $("#txtnoofbags").val();
        var shortage =  $("#txtshortage").val(); 
       
        var jAcutal ="#txtActual_"+Serial;
        var ShortActualBag = $(jAcutal).val();
        
        var jPurDtlId = "#purDtlId_"+Serial;
        var purchaseDtlId = $(jPurDtlId).val();
        
        var jParentId = "#parentBagId_"+Serial;
        var parentBagId = $(jParentId).val();
        
        $.ajax({
        url: basepath + "shortageadjustment/updateShortage",
        type: 'post',
        data: {bagDtlId:bagDetailId,noBags:noofbags,shortage:shortage,shortActualBag:ShortActualBag,purchaseDtlId:purchaseDtlId,parentBagId:parentBagId},
        success: function(data) {
                    
            $("#txtnoofbags").val('');
            $("#txtshortage").val(''); 
        },
        complete: function(){
          $("#txtnoofbags").val('');
          $("#txtshortage").val('');    
         location.reload(true);
          //window.location.href = basepath+'shortageadjustment';
        },
        error: function(e) {
            //called when there is an error
            //console.log(e.message);
        }
    });
            
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });
}

function deleteShortage(bagDtlId,serial){
    
     var basepath =  $("#basepath").val();
    
    var jNumberOfshortBag = "#noShortBag_"+serial;
    var NumberOfshortBag =$(jNumberOfshortBag).val();
    var jparentbagid = "#parentBagId_"+serial;
    var parentBagId = $(jparentbagid).val();
   
     $( "#dialog-confirm-shortage" ).dialog({
      resizable: false,
      height:140,
      modal: true,
      buttons: {
        "Delete ": function() {
                                            $.ajax({
                                                    url: basepath + "shortageadjustment/deleteShortage",
                                                    type: 'post',
                                                    data: {bagDtlId:bagDtlId,noBags:NumberOfshortBag,parentBagId:parentBagId},
                                       success: function(data) {


                                       },
                                       complete: function(){
                                        location.reload(true);
                                        },
                                       error: function(e) {
                                           //called when there is an error
                                           //console.log(e.message);
                                       }
                                   });
           $(this).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });
    
}
function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode;

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57)&&(charCode != 8))
            return false;

        return true;
    }    
    

  