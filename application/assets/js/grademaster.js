
 function openADD()
 {

	 $('#gradediv').show('slow', function() {  });
	  $('.buttondiv').html('<div class="save" id="savegrade" align="center">Save</div>');
	  $("#savegrade").click(function(){
		   $("#spinner").show();
		 var basepath =  $("#basepath").val();
   		 var  grade = $("#grade").val();
   		
  
   $.ajax({
       type: "POST",
       url:   basepath+"grademaster/add",
       data:  {grade: grade},
	 

       success: function(data)
       {
          	
		/*	var t = $('#example').DataTable();
		  	 t.row.add( [
			'<input type="radio" class="mini" name="gradeid" id="chk'+data+'" value="'+data+'"/>',
            grade,
           
			
          
        ] ).draw();
		    $('#gradediv').hide();
			$("#addgrade").trigger('reset');
			alert('successfully added');*/
			window.location.href = basepath+'grademaster';
       }

     });

     return false;  //stop the actual form post !important!

  });
 }

$(function(){
		   
   var basepath =  $("#basepath").val();
   
   
   
   $("#gradeedit").click(function(){
	var selected = $("input[type='radio'][name='gradeid']:checked");
	if (selected.length > 0) {
    	selectedVal = selected.val();
		$('#grade').val($('#name'+selectedVal).html());
		//$('#gardenaddress').val($('#add'+selectedVal).html().replace(/<br\s*[\/]?>/gi, "\n"));
		$('.buttondiv').html('<input type="hidden" id="gradeid" name="gradeid" value="'+selectedVal+'"/><div class="save" id="updategrade" align="center">Update</div>');
		$('#gradediv').show('slow', function() {  });
		
			$("#updategrade").click(function(){
												
			   var  grade = $("#grade").val();
			 //  var gardenaddress =  $("#gardenaddress").val();
			   var gradeid =  $("#gradeid").val();
				 $.ajax({
				   type: "POST",
				   url:   basepath+"grademaster/modify",
				   data:  {id: gradeid,grade: grade},
				 
			
				   success: function(data)
				   {
					  	$('#name'+selectedVal).html(grade);
						$('#gradediv').hide();
						$("#addgrade").trigger('reset');
						//alert('successfully updated');
				   }
			
				 });
			
				 return false;  //stop the actual form post !important!
			
			  });
		}
	});
   
   
   
      $("#gradedel").click(function(){
	var selected = $("input[type='radio'][name='gradeid']:checked");
	if (selected.length > 0) {
    	selectedVal = selected.val();
		 $.ajax({
				   type: "POST",
				   url:   basepath+"grademaster/delete",
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
				
			 
			 $('#gradeedit').css('visibility', 'visible');
			 $('#gradedel').css('visibility', 'visible');
	});
   
});

$( document ).ready(function() {
	
		$( ".legal-menu"+$('#mastermenu').val() ).addClass( " collapse in " );
		$( ".grademaster").addClass( " active " );
	
});