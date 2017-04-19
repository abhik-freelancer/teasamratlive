
 function openADD()
 {

	 $('#adddiv').show('slow', function() {  });
	 $('.buttondiv').html('<div class="save" id="save" align="center">Save</div>');
	 $("#save").click(function(){
							   
							 
	    
		 var basepath =  $("#basepath").val();
   		 var code = $("#code").val();
   		 var description =  $("#description").val();
	
		
  if($("#code").val() != '')
  {
	
	  $("#spinner").show();
	 $.ajax({
		   type: "POST",
		   url:   basepath+"teagroupmaster/add",
		   data:  {code: code,description: description},
		   success: function(data)
		   {
				
				window.location.href = basepath+'teagroupmaster';
		   }
	
		 });
  	}
	else
	{
		$( "#code" ).addClass( "glowing-border" );
		
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
		$('#code').val($('#code'+selectedVal).html());
		$('#description').val($('#description'+selectedVal).html());
		
		$('.buttondiv').html('<input type="hidden" id="id" name="id" value="'+selectedVal+'"/><div class="save" id="update" align="center">Update</div>');
		$('#adddiv').show('slow', function() {  });
		
			$("#update").click(function(){
												
			   var code = $("#code").val();
   		 	   var description =  $("#description").val();
			   var id =  $("#id").val();
			    
				if($("#code").val() != '')
  				{
				 $.ajax({
				   type: "POST",
				   url:   basepath+"teagroupmaster/modify",
				   data:  {id: id,code: code,description: description},
				   
				 	success: function(data)
				   {
					  	$('#name'+selectedVal).html(name);
						$('#description'+selectedVal).html(description);
					
						$('#adddiv').hide();
						$("#addform").trigger('reset');
					}
			
				 });
				}
				else
				{
					$( "#code" ).addClass( "glowing-border" );
					
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
				   url:   basepath+"teagroupmaster/delete",
				   data:  {id: selectedVal},
				   success: function(data)
				   {
					  	// $('#row'+selectedVal).remove();
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
		$( ".teagroupmaster").addClass( " active " );
	
});
   
});
