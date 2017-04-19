
 function openADD()
 {

	 $('#gardenadddiv').show('slow', function() {  });
	  $('.buttondiv').html('<div class="save" id="savegarden" align="center">Save</div>');
	  $("#savegarden").click(function(){
									  
		  $("#spinner").show();
		 var basepath =  $("#basepath").val();
   		 var  gardenname = $("#gardenname").val();
   		 var gardenaddress =  $("#gardenaddress").val();
  
   $.ajax({
       type: "POST",
       url:   basepath+"gardenmaster/add",
       data:  {gardenname: gardenname,gardenaddress: gardenaddress.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '<br />')},
	 

       success: function(data)
       {
          	
			/*var t = $('#example').DataTable();
		  	 t.row.add( [
			'<input type="checkbox" class="mini" id="'+data+'"/>',
            gardenname,
            gardenaddress.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '<br />'),
			
          
        ] ).draw();
		    $('#gardenadddiv').hide();
			$("#addgarden").trigger('reset');
			alert('successfully added');*/
			window.location.href = basepath+'gardenmaster';
       }

     });

     return false;  //stop the actual form post !important!

  });
 }

$(function(){
		   
   var basepath =  $("#basepath").val();
   
   
   
   $("#gardenedit").click(function(){
	var selected = $("input[type='radio'][name='gardenid']:checked");
	if (selected.length > 0) {
    	selectedVal = selected.val();
		$('#gardenname').val($('#name'+selectedVal).html());
		$('#gardenaddress').val($('#add'+selectedVal).html().replace(/<br\s*[\/]?>/gi, "\n"));
		$('.buttondiv').html('<input type="hidden" id="gardenid" name="gardenid" value="'+selectedVal+'"/><div class="save" id="updategarden" align="center">Update</div>');
		$('#gardenadddiv').show('slow', function() {  });
		
			$("#updategarden").click(function(){
												
			   var  gardenname = $("#gardenname").val();
			   var gardenaddress =  $("#gardenaddress").val();
			   var gardenid =  $("#gardenid").val();
				 $.ajax({
				   type: "POST",
				   url:   basepath+"gardenmaster/modify",
				   data:  {id: gardenid,gardenname: gardenname,gardenaddress: gardenaddress.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '<br />')},
				 
			
				   success: function(data)
				   {
					  	$('#name'+selectedVal).html(gardenname);
						$('#add'+selectedVal).html($("#gardenaddress").val().replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '<br />'));
						$('#gardenadddiv').hide();
						$("#addgarden").trigger('reset');
						//alert('successfully updated');
				   }
			
				 });
			
				 return false;  //stop the actual form post !important!
			
			  });
		}
	});
   
   
   
      $("#gardendel").click(function(){
	var selected = $("input[type='radio'][name='gardenid']:checked");
	if (selected.length > 0) {
    	selectedVal = selected.val();
		//$('#gardenname').val($('#name'+selectedVal).html());
		//$('#gardenaddress').val($('#add'+selectedVal).html().replace(/<br\s*[\/]?>/gi, "\n"));
		//$('.buttondiv').html('<input type="hidden" id="gardenid" name="gardenid" value="'+selectedVal+'"/><div class="save" id="updategarden" align="center">Update</div>');
		//$('#gardenadddiv').show('slow', function() {  });
		
			
				 $.ajax({
				   type: "POST",
				   url:   basepath+"gardenmaster/delete",
				   data:  {id: selectedVal},
				   success: function(data)
				   {
					  	 //$('#row'+selectedVal).remove();
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
				
			 
			 $('#gardenedit').css('visibility', 'visible');
			 $('#gardendel').css('visibility', 'visible');
	});
   
});
$( document ).ready(function() {
	
		$( ".legal-menu"+$('#mastermenu').val() ).addClass( " collapse in " );
		$( ".gardenmaster").addClass( " active " );
	
});