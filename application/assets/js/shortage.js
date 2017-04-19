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
        $("#invoice").customselect(); 
    
    $("#shortage").click(function(){
                     $("#frmBagDtls").submit();
                      
   	});
                
    $('.groupOfTexbox').keypress(function (event) {
            
            return isNumber(event, this)

        });   
//**********************Retun short bag section date:06/12/2016**************************//		
$(document).on('click','.returndel',function(){

  var bagdtlid = $(this).attr("id");
  $.ajax({
		url: basepath + "shortageadjustment/returnDelete",
        type: 'post',
        data: {bagdtlid:bagdtlid},
        success: function(data) {
                   if(data==1){
								alert("Redespatched bag remove successfully.")
								location.reload(true);
		  }else{
		  alert("Error occured.")
			
		  }
        } //console.log(e.message);
 		});

});

	 $(document).on('click','.rtrnBtn',function(){
	 
		var bagDetailId= $(this).attr("id");
		//fetch net from bag details
		$.ajax({
			 url: basepath + "shortageadjustment/getNetWeightOfBag",
        type: 'post',
        data: {bagDetailsId:bagDetailId},
        success: function(data) {
                    $("#txtRetNetKg").val(data.net);
					$("#txtRetnoofbags").val(data.noBags);
          
        },
        complete: function(){
         
        },
        error: function(e) {
            //called when there is an error
            //console.log(e.message);
        }		
		
		});
		
		
		    $( "#dialog_return" ).dialog({
								  resizable: false,
								  height: "auto",
								  width: 400,
								  modal: true,
								  buttons: {
									"Save": function() {
										var bagsReturn = $("#txtRetnoofbags").val()||0;
										var netInBag = $("#txtRetNetKg").val()||0;
										var returnChallan = $("#txtRetchallanno").val()||"";
										var returnChallanDate =$("#txtRetchallandate").val()||""; 
										$.ajax({
												
												url: basepath + "shortageadjustment/saveReturn",
												type: 'post',
												data: {bagDetailsId:bagDetailId,bagsReturn:bagsReturn,netInBag:netInBag,returnChallan:returnChallan,returnChallanDate:returnChallanDate},
												success: function(data) {
														if(data==1){
															location.reload(true);
														}else{
															alert("Updation fail");
														}	
												  
												},
												complete: function(){
												 
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
	 
	 });
	 
	 /*************************6/12/2016**************************/
	

});
function openShortage(bagdetail_id,serial){
    var basepath =  $("#basepath").val();
   
       $( "#dialog_shortage" ).dialog({
      resizable: false,
      height:290,
      width:320,
      modal: true,
      buttons: {
        "Save": function() {
            //alert(bagdetail_id);
            
        var noofbags = $("#txtnoofbags").val();
        var shortage =  $("#txtshortage").val(); 
        var challanno = $("#challanno").val();
        var challandate =$("#challandate").val();
        var jNet = "#txtnet_"+serial;
        var parentBagNet = $(jNet).val();
        var jAcutal ="#txtActual_"+serial;
        var parentActualBag = $(jAcutal).val();
        var jPurDtlId = "#purDtlId_"+serial;
        var purchaseDtlId = $(jPurDtlId).val();
        $.ajax({
        url: basepath + "shortageadjustment/addShortage",
        type: 'post',
        data: {bagDtlId:bagdetail_id,noBags:noofbags,shortage:shortage,challanno:challanno,challandate:challandate,pBagNet:parentBagNet,pActualBag:parentActualBag,purchaseDtlId:purchaseDtlId},
        success: function(data) {
                    
            $("#txtnoofbags").val('');
            $("#txtshortage").val(''); 
            $("#challanno").val('');
           // $("#challandate").val('');
        },
        complete: function(){
          $("#txtnoofbags").val('');
          $("#txtshortage").val(''); 
          $("#challanno").val('');
          $("#challandate").val('');
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
           $("#challanno").val('');
           $("#challandate").val('');
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
    
    var jchallanNo="#challanNo_"+Serial;
    var chalanNo = $(jchallanNo).val();
    
    var jchalanDate ="#challanDate_"+Serial;
    var chalandate = $(jchalanDate).val();
    
    $("#txtnoofbags").val(numOfShortBag);
    $("#txtshortage").val(Shortkgs); 
    $("#challanno").val(chalanNo);
    $("#challandate").val(chalandate);
    
    
     $( "#dialog_shortage" ).dialog({
      resizable: false,
      height:290,
      width:320,
      modal: true,
      buttons: {
        "Update": function() {
            
        var noofbags = $("#txtnoofbags").val();
        var shortage =  $("#txtshortage").val(); 
        var challanno = $("#challanno").val();
        var challandate =$("#challandate").val();
       
        var jAcutal ="#txtActual_"+Serial;
        var ShortActualBag = $(jAcutal).val();
        
        var jPurDtlId = "#purDtlId_"+Serial;
        var purchaseDtlId = $(jPurDtlId).val();
        
        var jParentId = "#parentBagId_"+Serial;
        var parentBagId = $(jParentId).val();
        
        $.ajax({
        url: basepath + "shortageadjustment/updateShortage",
        type: 'post',
        data: {bagDtlId:bagDetailId,noBags:noofbags,shortage:shortage,challanno:challanno,challandate:challandate,shortActualBag:ShortActualBag,purchaseDtlId:purchaseDtlId,parentBagId:parentBagId},
        success: function(data) {
                    
            $("#txtnoofbags").val('');
            $("#txtshortage").val(''); 
            $("#challanno").val('');
           $("#challandate").val('');
        },
        complete: function(){
          $("#txtnoofbags").val('');
          $("#txtshortage").val('');  
          $("#challanno").val('');
          $("#challandate").val('');
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
    

  