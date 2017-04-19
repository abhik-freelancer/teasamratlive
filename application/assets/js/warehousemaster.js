
 function openADD()
 {

	 $('#adddiv').show('slow', function() {  });
	 $('.buttondiv').html('<div class="save" id="save" align="center">Save</div>');
	 $("#save").click(function(){
	     $("#spinner").show();
		 var basepath =  $("#basepath").val();
   		 var code = $("#code").val();
   		 var name =  $("#name").val();
		 var area =  $("#area").val();
  
   $.ajax({
       type: "POST",
       url:   basepath+"warehousemaster/add",
       data:  {code: code,name: name,area:area},
	   success: function(data)
       {
          	
			/*var t = $('#example').DataTable();
		  	 t.row.add( [
			'<input type="radio" name="action" class="mini" id="radio'+data+'" value="'+data+'"/>',
             code,
             name,
			 area
		  ] ).draw();
		    $('#adddiv').hide();
			$("#addform").trigger('reset');
			alert('successfully added');*/
			window.location.href = basepath+'warehousemaster';
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
		$('#code').val($('#code'+selectedVal).html());
		$('#name').val($('#name'+selectedVal).html());
		$('#area').val($('#area'+selectedVal).html());
		$('.buttondiv').html('<input type="hidden" id="id" name="id" value="'+selectedVal+'"/><div class="save" id="update" align="center">Update</div>');
		$('#adddiv').show('slow', function() {  });
		
			$("#update").click(function(){
												
			   var code = $("#code").val();
			   var name =  $("#name").val();
			   var id =  $("#id").val();
			    var area =  $("#area").val();
				
				 $.ajax({
				   type: "POST",
				   url:   basepath+"warehousemaster/modify",
				   data:  {id: id,code: code,name: name,area:area},
				   
				 	success: function(data)
				   {
					  	$('#name'+selectedVal).html(name);
						$('#code'+selectedVal).html(code);
						$('#area'+selectedVal).html(area);
						
						$('#adddiv').hide();
						$("#addform").trigger('reset');
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
				   url:   basepath+"warehousemaster/delete",
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
		$( ".warehousemaster").addClass( " active " );
	
});
   
});
