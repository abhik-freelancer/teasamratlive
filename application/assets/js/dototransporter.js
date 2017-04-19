$(document).ready(function() {

$( ".legal-menu"+$('#transactionmenu').val() ).addClass( " collapse in " );
$( ".deliveryordertotransp").addClass( " active " );


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
     $("#saleno").customselect();
    
 $('#do_to_trans').dataTable( {
                                    "fnDrawCallback":function(){ $('.datepicker').datepicker({
                                                dateFormat: 'dd-mm-yy',
                                                minDate: mindate,
                                                maxDate: maxDate
                                    });},
                                "order": [],
                                "aoColumnDefs": [
                                    { 'bSortable': false, 'aTargets': [ 12,13] }
                                    ],
                               
                                
});   


        
    
  /*  $("#showdo").click(function(){
                       $("#frmTransporter").submit();
                       
			 
		});*/
    
    
    $("#showdo").click(function() {
        
            var sale_no = $("#saleno").val();
          
            var ispending;
            if($("#chkpendingdo").prop('checked')==true){
                ispending = 'Y';
            }
            if($("#chkpendingdo").prop('checked')==false){
                ispending = 'N';
            }
            window.location.href=basepath+'deliveryordertotransp/deliveryordertotransp/saleno/'+sale_no+'/ispending/'+ispending;
    

        
       
        
      

    });
    
 
});


/*
 * @method getValidation
 * @param transpoId,serialId
 * @date 15-01-2016
 * @author Mithilesh
 */

function getValidation(transpoId,serialId){
    var jTransporter = "#drpTransporter"+serialId+" option:selected";
    var transpId = $(jTransporter).val();
      
    var jTransDate = "#transDt"+serialId;
    var tranDate = $(jTransDate).val();
    
    var jIsSent = "#chkSent"+serialId;
    
    if(transpId=="0"){
        $("#drpTransporter"+serialId).addClass("glowing-border");
         $("#transDt"+serialId).removeClass("glowing-border");
         $("#chkSent"+serialId).removeClass("glowing-border");
       //alert("transid first");
        return false;
    }
    if(tranDate==""){
        $("#transDt"+serialId).addClass("glowing-border");
        $("#drpTransporter"+serialId).removeClass("glowing-border");
         $("#chkSent"+serialId).removeClass("glowing-border");
      //alert("transdate");
        return false;
    }
     if($(jIsSent).prop("checked") == false){
            $("#chkSent"+serialId).addClass("glowing-border");
            $("#transDt"+serialId).removeClass("glowing-border");
            $("#drpTransporter"+serialId).removeClass("glowing-border"); 
            return false;
        }
        
    return true;


}



 function updateTransDo(transpoId,Serial){
     
  
        var sale_no = $("#saleno").val();
        var ispending;
        
          if($("#chkpendingdo").prop('checked')==true){
                ispending = 'Y';
            }
            if($("#chkpendingdo").prop('checked')==false){
                ispending = 'N';
            }
       
     
        //exit;
        $("#loaderDiv").hide();
        var basepath = $("#basepath").val();
        var typeofopt='';
        var isSent='';
	var Dotransporterid =transpoId;
	var serialId = Serial;
        
        var jTransporter = "#drpTransporter"+serialId+" option:selected";
        var transpId = $(jTransporter).val();
       
        
        var jPurdtlId = "#purDtlId"+serialId;
        var PurdtlId = $(jPurdtlId).val();
        
        var jPurMsId ="#pMstId"+serialId;
        var PurMsId = $(jPurMsId).val();
        
	var jdo_no= "#txt_do"+serialId;
	var deliveryorder =$(jdo_no).val();
        
	var jdo_date = "#do_reli_date"+serialId;
	var do_date = $(jdo_date).val();
        
        var jTransDate = "#transDt"+serialId;
        var tranDate = $(jTransDate).val();
        
    
        
        var jFromWhere ="#pfromWhere"+serialId;
        var purchaseType = $(jFromWhere).val();
        
        var jIsSent = "#chkSent"+serialId;
        
        
     
        if($(jIsSent).prop("checked") == true){
            isSent = 'Y';
            
        }else{
            isSent = 'N';
        }
        
        
        if(Dotransporterid==''){
             typeofopt="I";
            
        }else{
             typeofopt="U";
        }
        if(getValidation(transpoId,Serial)){
            
      
        
	
    $.ajax({
        url: basepath + "deliveryordertotransp/updateDoTransporter",
        type: 'post',
        data: {donumber: deliveryorder, purInvMst:PurMsId,purchaseDetailsId:PurdtlId,typeof:typeofopt,transporter:transpId,transporterdate:tranDate,isSentTrans:isSent,doTranID:Dotransporterid,purchaseType:purchaseType},
        success: function(data) {
            if(data==1){
               // alert("Saved Sucessfully");
              
                
                 $( "#dialog-check-saved" ).dialog({
                            resizable: false,
                            height:140,
                            modal: true,
                            buttons: {
                            "Ok": function() {
                               $( this ).dialog( "close" );
                               if(typeofopt=="I"){
                                window.location.href=basepath+'deliveryordertotransp/deliveryordertotransp/saleno/'+sale_no+'/ispending/'+ispending;;
                                }else{
                                    
                                      window.location.href = basepath+'deliveryordertotransp/deliveryordertotransp/saleno/'+sale_no+'/ispending/'+ispending;
                                }
                               
                                 } 
                                         }
                                        });
            }
            //called when successful
           // $('#ajaxphp-results').html(data);
         //  $("#loaderDiv").hide();
         // 
        },
        error: function(e) {
            //called when there is an error
            //console.log(e.message);
        }
   
    });
         event.preventDefault();
     }   
     else{
         $( "#dialog-check-fields" ).dialog({
                            resizable: false,
                            height:140,
                            modal: true,
                            buttons: {
                            "Ok": function() {
                               $( this ).dialog( "close" );
                                 } 
                                         }
                                        });
     }
    } 
    



