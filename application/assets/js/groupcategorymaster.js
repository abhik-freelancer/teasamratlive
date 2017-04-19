
 function openADD()
 {
	 $('#adddiv').show('slow', function() {  });
	 $('.buttondiv').html('<div class="save" id="save" align="center">Save</div>');
	 $("#save").click(function(){
	 $("#spinner").show();
	  
		 
		 var basepath =  $("#basepath").val();
   		 var group = $("#group option:selected" ).val();
   		 var subgroup =  $("#subgroup option:selected" ).val();
		
  
   $.ajax({
       type: "POST",
       url:   basepath+"groupcategorymaster/add",
       data:  {group: group,subgroup: subgroup},
	   success: function(data)
       {
          	if(data == 'err')
			{
				$("#spinner").hide();
				$("#err").html("combination already exist");
			}
		 	else
			{
				window.location.href = basepath+'groupcategorymaster';
			}
       }

     });

     return false;  //stop the actual form post !important!

  });
 }

$(function(){
		   
   var basepath =  $("#basepath").val();
   
   $("#edit").click(function(){
							
	var selected = $("input[type='radio'][name='action']:checked");
	if (selected.length > 0) {
    	selectedVal = selected.val();
		
		$('#group option[value='+$('#groupid'+selectedVal).val()+']').attr('selected','selected');
		$('#subgroup option[value='+$('#subgroupid'+selectedVal).val()+']').attr('selected','selected');
		
		$('.buttondiv').html('<input type="hidden" id="id" name="id" value="'+selectedVal+'"/><div class="save" id="update" align="center">Update</div>');
		$('#adddiv').show('slow', function() {  });
		
			$("#update").click(function(){
												
			   var group = $("#group option:selected" ).val();
			   var subgroup =  $("#subgroup option:selected" ).val();
			   var id =  $("#id").val();
			   
				
				 $.ajax({
				   type: "POST",
				   url:   basepath+"groupcategorymaster/modify",
				   data:  {id: id,group: group,subgroup: subgroup},
				   
				 	success: function(data)
				   {
					  	
						if(data == 'err')
						{
							$("#err").html("combination already exist");
						}
						else
						{
							$('#group'+selectedVal).html( $("#group option:selected" ).text());
							$('#subgroup'+selectedVal).html( $("#subgroup option:selected" ).text());
							
							$('#groupid'+selectedVal).val($("#group option:selected" ).val());
							$('#subgroupid'+selectedVal).val( $("#subgroup option:selected" ).val());
												
							$('#adddiv').hide();
							$("#addform").trigger('reset');
						}
						
						//alert('successfully updated');
				   }
			
				 });
			
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
				   url:   basepath+"groupcategorymaster/delete",
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
		$( ".groupcategorymaster").addClass( " active " );
		$(".scmenu3").removeClass("collapse");

		
	
});
   
});
