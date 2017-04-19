
 function openADD()
 {	$("#addform").trigger('reset');
	 $('#adddiv').show('slow', function() {  });
	 $('.buttondiv').html('<div class="save" id="save" align="center">Save</div>');
	 $("#save").click(function(){
     $("#spinner").show();
	  
		 
		 var basepath =  $("#basepath").val();
   		 var accname = $("#name" ).val();
   		 var groupid =  $("#groupname option:selected" ).val();
		 var balance = $("#balance" ).val();
		 if ($('#special').is(":checked"))
		{
		  var special = $("#special" ).val();
		}else
		{
			 var special = "N";
		}
		
		
  
   $.ajax({
       type: "POST",
       url:   basepath+"accountmaster/add",
       data:  {accname: accname,groupid: groupid,balance: balance,special: special},
	   success: function(data)
       {
          	if(data == 'err')
			{
				$("#spinner").hide();
				$("#err").html("combination already exist");
			}
		 	else
			{
				window.location.href = basepath+'accountmaster';
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
		
		//$('#group option[value='+$('#accname'+selectedVal).val()+']').attr('selected','selected');
		$("#name").val($('#accname'+selectedVal).html());
		$('#groupname option[value='+$('#groupid'+selectedVal).val()+']').attr('selected','selected');
		$("#balance").val($('#openbal'+selectedVal).html());
		
		
		if( $('#specialval'+selectedVal).val() == 'Y')
		{
			$('#special').prop('checked', true);
		}
		$('.buttondiv').html('<input type="hidden" id="id" name="id" value="'+selectedVal+'"/><div class="save" id="update" align="center">Update</div>');
		$('#adddiv').show('slow', function() {  });
		
			$("#update").click(function(){
								
			   var name = $("#name" ).val();
			   var groupname =  $("#groupname option:selected" ).val();
			   var balance = $("#balance").val();
			   var id =  $("#id").val();
			   var accblnceid = $("#accblnceid"+selectedVal).val();
			   if ($('#special').is(":checked"))
				{
				  var special = $("#special" ).val();
				}else
				{
					 var special = "N";
				}
			   
				
				 $.ajax({
				   type: "POST",
				   url:   basepath+"accountmaster/modify",
				   data:  {id: id,accname: name,groupid: groupname,balance:balance,accblnceid:accblnceid,special:special},
				   
				 	success: function(data)
				   {
					  	
						if(data == 'err')
						{
							$("#err").html("combination already exist");
						}
						else
						{
							$('#groupname'+selectedVal).html( $("#groupname option:selected" ).text());
							$('#accname'+selectedVal).html( $("#name").val());
							$('#openbal'+selectedVal).html( $("#balance").val());
							$('#groupid'+selectedVal).val( $("#groupname option:selected" ).val());
							
												
							$('#adddiv').hide();
							$('#specialval'+selectedVal).attr('disabled', true);
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
		childid = $('#accblnceid'+selectedVal).val();
	
			 $.ajax({
				   type: "POST",
				   url:   basepath+"accountmaster/delete",
				   data:  {parentid: selectedVal,childid:childid},
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
			 $('#del').css('visibility', 'visible');
	});
	 
	 
	 $( document ).ready(function() {
	
		$( ".legal-menu"+$('#mastermenu').val() ).addClass( " collapse in " );
		$( ".accountmaster").addClass( " active " );
		$(".scmenu3").removeClass("collapse");
		//$( "#subchildacc").toggleClass( " fa fa-caret-up " );
		 
	//	$( "#16").class( " active " );
	
});
   
});
