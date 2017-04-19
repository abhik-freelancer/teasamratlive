$(document).ready(function() {
    $(".legal-menu" + $('#mastermenu').val()).addClass(" collapse in ");
    $(".openingbalance ").addClass(" active ");
    var basepath = $("#basepath").val();


    var divSerialNumber = 0;
    $("#AddDetail").click(function() {
     
        divSerialNumber = divSerialNumber + 1;
        $.ajax({
            url: basepath + "openingbalance/createDetails",
            type: 'post',
            data: {divSerialNumber: divSerialNumber},
            success: function(data) {
                $(".showAddDetail").append(data);
            },
            complete: function() {
                // $("#stock_loader").hide();
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });

       

    });
     $(document).on('click', ".del", function() {

           // alert('Del');
            var netId = $(this).attr('id');
            var detailIdarr = netId.split('_');
            var master_id = detailIdarr[1];
            var detail_id = detailIdarr[2];
            //var bagdetail_id = detailIdarr[3];

            //console.log("divID :"+master_id+"-"+detail_id);
            var div_identification_id = "#bagDetail_" + master_id + "_" + detail_id;
            //alert(div_identification_id);
            $(div_identification_id).empty();
        });
        
        

   $("#saveopeningDtl").click(function(){
      
     
        // var basepath=("#basepath");
          if(checkOpInvValidation ()){
           var formData = $("#openingblnc").serialize();
           var mode=$("#txtModeOfoperation").val();
           var prMastId = $("#prMastId").val();
           $('#stock_loader').show();
          $('#saveopeningDtl').hide();
           
           formData = decodeURI(formData);
           $.ajax({
            url: basepath + "openingbalance/saveData",
            type: 'post',
            data: {formDatas: formData,mode:mode,prMastId:prMastId},
            success: function(data) {
                //  window.location.href = basepath + 'openingbalance';
                if(data){
                                        $("#opening_save_dilg" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                     window.location.href = basepath + 'openingbalance';
                                                    $( this ).dialog( "close" );
                                                }
                                              }
                                            });
                           }/*else{
                                        $( "#opening_error_save_dilg" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                  $( this ).dialog( "close" );
                                                }
                                              }
                                            });
                           }
                          */
                
            },
            complete: function(data) {
                 $("#stock_loader").hide();
                 $('#saveopeningDtl').show();
                 
            },
            error: function(e) {
                //called when there is an error
                console.log(e.message);
            }
        });
          }
          
      else{
          
           $( "#opening_detail_validation_fail" ).dialog({
                                                 modal: true,
                                                    buttons: {
                                                Ok: function() {
                                                  $( this ).dialog( "close" );
                                                }
                                              }
                                            });
      }
       
   });

function checkOpInvValidation(){
   
   var group = $("#group").val();
   var location = $("#location").val();
   var garden = $("#garden").val();
   var grade = $("#grade").val();
   var invoice = $("#invoice").val();
   var saleno = $("#saleno").val();
   var rate = $("#rate").val();
   var noofNormalBag = $("#noofNormalBag").val();
   var net = $("#net").val();
   
        if(group=="0"){
          $("#group").addClass("glowing-border");
          
            $("#location").removeClass("glowing-border");
            $("#garden").removeClass("glowing-border");
            $("#grade").removeClass("glowing-border");
            $("#invoice").removeClass("glowing-border");
            $("#saleno").removeClass("glowing-border");
            $("#rate").removeClass("glowing-border");
            $("#noofNormalBag").removeClass("glowing-border");
            $("#net").removeClass("glowing-border");
            return false;
        }
        if(location=="0"){
            $("#location").addClass("glowing-border");
            
            $("#group").removeClass("glowing-border");
            $("#garden").removeClass("glowing-border");
            $("#grade").removeClass("glowing-border");
            $("#invoice").removeClass("glowing-border");
            $("#saleno").removeClass("glowing-border");
            $("#rate").removeClass("glowing-border");
            $("#noofNormalBag").removeClass("glowing-border");
            $("#net").removeClass("glowing-border");
            return false;
        }
        if(garden=="0"){
             $("#garden").addClass("glowing-border");
         
            $("#location").removeClass("glowing-border");
            $("#group").removeClass("glowing-border");
            $("#grade").removeClass("glowing-border");
            $("#invoice").removeClass("glowing-border");
            $("#saleno").removeClass("glowing-border");
            $("#rate").removeClass("glowing-border");
            $("#noofNormalBag").removeClass("glowing-border");
            $("#net").removeClass("glowing-border");
            return false;
        }
        if(grade=="0"){
           $("#grade").addClass("glowing-border");
           
            $("#location").removeClass("glowing-border");
            $("#group").removeClass("glowing-border");
            $("#garden").removeClass("glowing-border");
            $("#invoice").removeClass("glowing-border");
            $("#saleno").removeClass("glowing-border");
            $("#rate").removeClass("glowing-border");
            $("#noofNormalBag").removeClass("glowing-border");
            $("#net").removeClass("glowing-border");
           
            return false;
        }
        if(invoice==""){
         $("#invoice").addClass("glowing-border");
         
            $("#location").removeClass("glowing-border");
            $("#group").removeClass("glowing-border");
            $("#garden").removeClass("glowing-border");
            $("#grade").removeClass("glowing-border");
            $("#saleno").removeClass("glowing-border");
            $("#rate").removeClass("glowing-border");
            $("#noofNormalBag").removeClass("glowing-border");
            $("#net").removeClass("glowing-border");
         
            return false;
        }
        if(saleno==""){
            $("#saleno").addClass("glowing-border");
          
          
            $("#location").removeClass("glowing-border");
            $("#group").removeClass("glowing-border");
            $("#garden").removeClass("glowing-border");
            $("#grade").removeClass("glowing-border");
            $("#invoice").removeClass("glowing-border");
            $("#rate").removeClass("glowing-border");
            $("#noofNormalBag").removeClass("glowing-border");
            $("#net").removeClass("glowing-border");
            return false;
        }
        if(rate==""){
            $("#rate").addClass("glowing-border");
          
            $("#saleno").removeClass("glowing-border");
            $("#location").removeClass("glowing-border");
            $("#group").removeClass("glowing-border");
            $("#garden").removeClass("glowing-border");
            $("#grade").removeClass("glowing-border");
            $("#invoice").removeClass("glowing-border");
            $("#rate").removeClass("glowing-border");
            $("#noofNormalBag").removeClass("glowing-border");
            $("#net").removeClass("glowing-border");
            return false;
        }
        if(noofNormalBag==""){
            $("#noofNormalBag").addClass("glowing-border");
          
            $("#saleno").removeClass("glowing-border");
            $("#location").removeClass("glowing-border");
            $("#group").removeClass("glowing-border");
            $("#garden").removeClass("glowing-border");
            $("#grade").removeClass("glowing-border");
            $("#invoice").removeClass("glowing-border");
            $("#rate").removeClass("glowing-border");
            $("#net").removeClass("glowing-border");
            return false;
        }
        if(net==""){
            $("#net").addClass("glowing-border");
          
          
            $("#saleno").removeClass("glowing-border");
            $("#location").removeClass("glowing-border");
            $("#group").removeClass("glowing-border");
            $("#garden").removeClass("glowing-border");
            $("#grade").removeClass("glowing-border");
            $("#invoice").removeClass("glowing-border");
            $("#rate").removeClass("glowing-border");
            $("#noofNormalBag").removeClass("glowing-border");
            $("#net").removeClass("glowing-border");
            return false;
        }
        else{
            return true;
        }
       
}


});
$(document).on('keyup', '.net', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });
 $(document).on('keyup', '.noofNormalBag', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });
 $(document).on('keyup', '.rate', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });
  $(document).on('keyup', '.noofbag', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        } 

    });

function deleterecord(id)
		{
                    var a = confirm("Do you want to Delete");
                    if(a==true){
			var basepath =  $("#basepath").val();
			$.ajax({
			type: "POST",
			url:  basepath+"openingbalance/delete",
			data: {id: id},
			success: function(data)
				{
				window.location.href = basepath+'openingbalance';
				}

     	});
    }
    else{
        return false;
    }
   
    
}