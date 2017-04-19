
 function openADD()
 {

	 $('#adddiv').show('slow', function() {  });
	 $('.buttondiv').html('<div class="save" id="save" align="center">Save</div>');
	 $("#save").click(function(){
							 
	  
		 var basepath =  $("#basepath").val();
   		 var name =  $("#name").val();
		 var area =  $("#area").val();
		 var phone =  $("#phone").val();
		 var pin = $("#pin").val();
                 var err = 0;
		
		if($("#name").val() == '')
  		{
			err = 1;
			$( "#name" ).addClass( "glowing-border" );
		}
                if($("#phone").val() == '')
  		{
			err = 1;
			$( "#phone" ).addClass( "glowing-border" );
		}
                if($("#pin").val()==''){
                                err = 1;
                                $("#pin").addClass("glowing-border");
                            }
                
		
		if(err == 0)
		{	$("#spinner").show();
		   $.ajax({
			   type: "POST",
			   url:   basepath+"transportmaster/add",
			   data:  {name: name,area:area,phone:phone,pin:pin},
			   success: function(data)
			   {
					
					window.location.href = basepath+'transportmaster';
			   }
		
			 });
		}
		

     return false;  //stop the actual form post !important!

  });
 }

$(function(){
		   
   var basepath =  $("#basepath").val();
   
   $("#edit").click(function(){
	var selected = $("input[type='radio'][name='action']:checked");
	if (selected.length > 0) {
    	selectedVal = selected.val();
		$('#pin').val($('#pin'+selectedVal).html());
		$('#name').val($('#name'+selectedVal).html());
		$('#area').val($('#area'+selectedVal).html());
		$('#phone').val($('#phone'+selectedVal).html());
		$('.buttondiv').html('<input type="hidden" id="id" name="id" value="'+selectedVal+'"/><div class="save" id="update" align="center">Update</div>');
		$('#adddiv').show('slow', function() {  });
		
			$("#update").click(function(){
												
			   var pin = $("#pin").val();
			   var name =  $("#name").val();
			   var id =  $("#id").val();
			   var area =  $("#area").val();
			   var phone =  $("#phone").val();
                           
			   var err = 0;
				
				
				if($("#name").val() == '')
				{
					err = 1;
					$( "#name" ).addClass( "glowing-border" );
				}
				if($("#phone").val() == '')
				{
					err = 1;
					$( "#phone" ).addClass( "glowing-border" );
				}
                                if($("#pin").val() == '')
				{
					err = 1;
					$( "#pin" ).addClass( "glowing-border" );
				}
                                
                                
				if(err == 0)
				{
				 $.ajax({
				   type: "POST",
				   url:   basepath+"transportmaster/modify",
				   data:  {id: id,name: name,area:area,phone:phone,pin:pin},
				   
                                   success: function(data)
				   {
					  	$('#name'+selectedVal).html(name);
						$('#pin'+selectedVal).html(pin);
						$('#area'+selectedVal).html(area);
						$('#phone'+selectedVal).html(phone);
						$('#adddiv').hide();
						$("#addform").trigger('reset');
						//alert('successfully updated');
				   }
			
				 });
				}
			
				 return false;  //stop the actual form post !important!
			
			  });
		}
	});
   
   
   
      $("#del").click(function(){
		var selected = $("input[type='radio'][name='action']:checked");
		if (selected.length > 0) {
    	selectedVal = selected.val();
			 $.ajax({
				   type: "POST",
				   url:   basepath+"transportmaster/delete",
				   data:  {id: selectedVal},
				   success: function(data)
				   {
					  //	 $('#row'+selectedVal).remove();
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
			 $('#del').css('visibility', 'visible');
	});
	 
	 
	 $( document ).ready(function() {
	
		$( ".legal-menu"+$('#mastermenu').val() ).addClass( " collapse in " );
		$( ".transportmaster").addClass( " active " );
	
});
   
});
