
 function openADD()
 {

	 $('#adddiv').show('slow', function() {  });
	 $('.buttondiv').html('<div class="save" id="save" align="center">Save</div>');
	 $("#save").click(function(){
	     $("#spinner").show();
		 var basepath =  $("#basepath").val();
   		 var rate = $("#rate").val();
   		 var from =  $("#from").val();
		 var to =  $("#to").val();
				 
			if($(".datepicker").hasClass("makeborderred"))
			{
				
			}
			else
			{
 			   $.ajax({
			   type: "POST",
			   url:   basepath+"vatmaster/add",
			   data:  {rate: rate,from: from,to:to},
			   success: function(data)
			   {
					
				
					window.location.href = basepath+'vatmaster';
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
		$('#rate').val($('#rate'+selectedVal).html());
		$('#from').val($('#from'+selectedVal).html());
		$('#to').val($('#to'+selectedVal).html());
		$('.buttondiv').html('<input type="hidden" id="id" name="id" value="'+selectedVal+'"/><div class="save" id="update" align="center">Update</div>');
		$('#adddiv').show('slow', function() {  });
		
			
			if($(".datepicker").hasClass("makeborderred"))
			{
				
			}
			else
			{
			
			$("#update").click(function(){
			var rate = $("#rate").val();
			   var from =  $("#from").val();
			   var id =  $("#id").val();
			    var to =  $("#to").val();
				
				 $.ajax({
				   type: "POST",
				   url:   basepath+"vatmaster/modify",
				   data:  {id: id,rate: rate,from: from,to:to},
				   
				 	success: function(data)
				   {
					  	$('#rate'+selectedVal).html(rate);
						$('#from'+selectedVal).html(from);
						$('#to'+selectedVal).html(to);
						
						$('#adddiv').hide();
						$("#addform").trigger('reset');
						//alert('successfully updated');
				   }
			
				 });
			
				 return false;  //stop the actual form post !important!
			
			  });
			}
		}
	});
   
   
   
      $("#del").click(function(){
		var selected = $("input[type='radio'][name='action']:checked");
		if (selected.length > 0) {
    	selectedVal = selected.val();
			 $.ajax({
				   type: "POST",
				   url:   basepath+"vatmaster/delete",
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
		$( ".vatmaster").addClass( " active " );
		$(".scmenu3").removeClass("collapse");


	
	});	
	 
	 var session_strt_date = $('#startyear').val();
	 var session_end_date = $('#endyear').val();
	 
	 $('.datepicker').datepicker({
	 	dateFormat: 'dd-mm-yy', 
		minDate: '01-04-'+session_strt_date,
		maxDate: '31-03-'+session_end_date 
		});
	 
	 $(".datepicker").change(function(){
  		checkDates($("#from").val(),$("#to").val());
	});
   
});


	
	
