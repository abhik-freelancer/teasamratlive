

  var basepath =  $("#basepath").val();
 function deletedetail(id)
 {
	  $.ajax({
				   type: "POST",
				   url:   basepath+"vendormaster/deletedetail",
				   data:  {iddata: id},
				   success: function()
				   {
					   $('#row'+id).remove();
						
				   }
			
				 });
 }
$(function(){
		   
 var basepath =  $("#basepath").val();
   
   
    $("#save").click(function() {
        var err = 0;

        if ($("#name").val() == '')
        {
            err = 1;
            $("#name").addClass("glowing-border");
        }
        

        if ($("#state").val() == 0)
        {
            err = 1;
            $("#stateerr").addClass("glowing-border");
        }
        if ($("#nameExistflag").val() == "Y") {
            err = 1;
            $("#name").addClass("glowing-border");
        }
        if (err == 0)
        {
            $("#spinner").show();
            $("#addvendormaster").submit();
        }

    });
        
        $("#name").blur(function(){
           //duplicate checking
            var vendorName =$("#name").val();
                 $.ajax({
                                type: "POST",
                                url: basepath + "vendormaster/nameExist",
                                data: {vName: vendorName},
                                success: function(data)
                                {
                                    if (data == 1)
                                    {
                                        
                                        $( "#nameExistflag" ).val("Y");
                                        
                                    }else{
                                         $( "#nameExistflag" ).val("");
                                    }
                                   
                                }

                            });
                
                //duplicate checking
        });
        
   
   $("#editdetail").click(function(){
							 
    $("#spinner").show();
	$("#editvendormaster").submit();
 
 });
   
   var session_strt_date = $('#startyear').val();
	 var session_end_date = $('#endyear').val();
	 var mindate = '01-04-'+session_strt_date;
	 var maxDate = '31-03-'+session_end_date ;
   
   $('.datepicker').datepicker({
	 	dateFormat: 'dd-mm-yy', 
		minDate: mindate,
		maxDate: maxDate
		});
   
    $("#adddetail").click(function(){
		
		$('#mybody').append('<tr><td>'+$("#bnumber").val()+'<input type="hidden" id="bnumber" name="listbnumber[]" value="'+$("#bnumber").val()+'"/></td><td>'+$("#bdate").val()+'<input type="hidden" id="bdate" name="listbdate[]" value="'+$("#bdate").val()+'"/></td><td>'+$("#ddate").val()+'<input type="hidden" id="ddate" name="listddate[]" value="'+$("#ddate").val()+'"/></td><td>'+$("#bamount").val()+'<input type="hidden" id="bamount" name="listbamount[]" value="'+$("#bamount").val()+'"/></td><td>'+$("#damount").val()+'<input type="hidden" id="damount" name="listdamount[]" value="'+$("#damount").val()+'"/></td></tr>');
		
		 $('#addsection').find('input').val('');
   
   });
	
     $("#del").click(function(){
		var selected = $("input[type='radio'][name='action']:checked");
		if (selected.length > 0) {
    	selectedVal = selected.val();
		aom = $('#aom'+selectedVal).val();
		am = $('#am'+selectedVal).val();
	
			 $.ajax({
				   type: "POST",
				   url:   basepath+"vendormaster/delete",
				   data:  {id: selectedVal,aom:aom,am:am},
				   success: function(data)
				   {
					  	if(data == 0)
				   		{
							alert("Cannot delete this record: Already exist in another table");
						}
						else
						{
							$('#row'+selectedVal).remove();
						}
						
				   }
			
				 });
			
				 return false;  //stop the actual form post !important!
			
			 
		}
	});
	  
	  
	$(".mini").click(function(){
				
			
			 $('#edit').css('visibility', 'visible');
			 $(".editmaster").attr("href", basepath+'vendormaster/editpage/vendor/'+this.id);
			 
			 $('#del').css('visibility', 'visible');
			 $('#opendiv').css('visibility', 'visible');
			 
			 $("#selid").val(this.id);
			 
			  $.ajax({
				   type: "POST",
				   url:   basepath+"vendormaster/dispalyEditDetails",
				   data:  {id: this.id},
				   success: function(data)
				   {
					  	 $('#mybody').html(data);
						
				   }
			
				 });
			 
	});
	 
	 
	 $( document ).ready(function() {
	
		$( ".legal-menu"+$('#mastermenu').val() ).addClass( " collapse in " );
		$( ".vendormaster ").addClass( " active " );
	
	});
	 
	 $(".detailopenmaster").click(function(){
										   
	 $("#example2").dialog({
				resizable: true,
				height:200,
				width:800,
				modal: true,
				buttons: {
				"Close": function() {
					$(this ).dialog( "close" );
						
						
					}
					
				  }
				});
	 
	 $("#example2").css("width",'800');
	});
   
//auto complete
 $( "#name" ).autocomplete({
      source: basepath+"vendormaster/getVendorList",
      minLength: 1,
      delay: 10,
      open: function(event, ui) {
            $(this).autocomplete("widget").css({
                "width": 380,
                
            });
        },
      select: function( event, ui ) {
        /*log( ui.item ?
          "Selected: " + ui.item.value + " aka " + ui.item.id :
          "Nothing selected, input was " + this.value );*/
      }
    });

});

  /**$(function() {
    function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }
 
    $( "#birds" ).autocomplete({
      source: "search.php",
      minLength: 2,
      select: function( event, ui ) {
        log( ui.item ?
          "Selected: " + ui.item.value + " aka " + ui.item.id :
          "Nothing selected, input was " + this.value );
      }
    });
  });*/