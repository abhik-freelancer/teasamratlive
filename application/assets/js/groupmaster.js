
 function openADD()
 {	
  	  $("#addform").trigger('reset');
	 $('#adddiv').show('slow', function() {  });
	 $('.buttondiv').html('<div class="save" id="save" align="center">Save</div>');
	 $("#save").click(function(){
	 $("#spinner").show();
	  
		 
		 var basepath =  $("#basepath").val();
   		 var group = $("#name" ).val();
   		 var category =  $("#category option:selected" ).val();
		 if ($('#special').is(":checked"))
		{
		  var special = $("#special" ).val();
		}else
		{
			 var special = "N";
		}
		
  
   $.ajax({
       type: "POST",
       url:   basepath+"groupmaster/add",
       data:  {group: group,category: category,special: special},
	   success: function(data)
       {
          	if(data == 'err')
			{
				$("#spinner").hide();
				$("#err").html("combination already exist");
			}
		 	else
			{
				window.location.href = basepath+'groupmaster';
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
		$("#name").val($('#groupmastername'+selectedVal).html());
		$('#category option[value='+$('#category'+selectedVal).val()+']').attr('selected','selected');
		if( $('#specialval'+selectedVal).val() == 'Y')
		{
			$('#special').prop('checked', true);
		}
		$('.buttondiv').html('<input type="hidden" id="id" name="id" value="'+selectedVal+'"/><div class="save" id="update" align="center">Update</div>');
		$('#adddiv').show('slow', function() {  });
		
			$("#update").click(function(){
								
			   var group = $("#name" ).val();
			   var category =  $("#category option:selected" ).val();
			   var id =  $("#id").val();
			   if ($('#special').is(":checked"))
				{
				  var special = $("#special" ).val();
				}else
				{
					 var special = "N";
				}
			   
				
				 $.ajax({
				   type: "POST",
				   url:   basepath+"groupmaster/modify",
				   data:  {id: id,group: group,category: category,special:special},
				   
				 	success: function(data)
				   {
					  	
						if(data == 'err')
						{
							$("#err").html("combination already exist");
						}
						else
						{
							$('#groupmastername'+selectedVal).html($("#name" ).val());
							//$('#categoryname'+selectedVal).html( $("#category option:selected" ).text());
							$('#categoryname'+selectedVal).html( (($("#category option:selected" ).text()).split('-'))[0]);
							$('#subcategoryname'+selectedVal).html( (($("#category option:selected" ).text()).split('-'))[1]);
							$('#category'+selectedVal).val($("#category option:selected" ).val());
												
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
				   url:   basepath+"groupmaster/delete",
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
				
			
			 $('#edit').css('visibility', 'visible');
			 $('#del').css('visibility', 'visible');
	});
	 
	 
	 $( document ).ready(function() {
	
		$( ".legal-menu"+$('#mastermenu').val() ).addClass( " collapse in " );
		$( ".groupmaster").addClass( " active " );
		$(".scmenu3").removeClass("collapse");


	
});
   
});
