
$(function(){
		   
		    
		
   var basepath =  $("#basepath").val();
   
   $(".mini").click(function(){
				
			
			 $('#edit').css('visibility', 'visible');
			 $('#del').css('visibility', 'visible');
	});
	 
	 
	
	 
	 var session_strt_date = $('#startyear').val();
	 var session_end_date = $('#endyear').val();
	 var mindate = '01-04-'+session_strt_date;
	 var maxDate = '31-03-'+session_end_date ;
	 
	 var currentDate = new Date();

	 
	 $('.datepicker').datepicker({
	 	dateFormat: 'dd-mm-yy', 
		minDate: mindate,
		maxDate: maxDate
		});
	 
	 $("#startdate").val(mindate);
	 $("#enddate").val(maxDate);
	 
	 $("#saledate").change(function(){
									
		var saledate = $("#saledate").val().split("-");
		var sale = saledate[1]+'/'+saledate[0]+'/'+saledate[2];
		dtNextWeek = new Date(sale);
		dtNextWeek.setDate( dtNextWeek.getDate()+14 );
		var month = dtNextWeek.getMonth()+parseFloat(1);
		if(month < 9)
		{
			month = '0'+month;
		}
		
		var promtdate = dtNextWeek.getDate()+'-'+month+'-'+dtNextWeek.getFullYear(); 
		$('#promtdate').val(promtdate);
	});
	 
	 
	 	
		
		$("#gotodetail").click(function(){
			$("#detailpurchaseinvoice").dialog({
				resizable: false,
				height:600,
				width:1000,
				modal: true,
				buttons: {
				"Confirm": function() {
					
					$("#example2").find('td.dataTables_empty').parent().remove();
					$("#countdetail").val(parseFloat($("#countdetail").val()) + parseFloat(1));
					
					
					var createspan = '';
					var createspanhidden = ''; 
					$("input[name='packtno[]']").each(function() {
   						createspan = createspan + ($(this).val() + '<br/>');
						createspanhidden = createspanhidden + ($(this).val() + '*');
						
					})
					
					var samplenet = '';
					var samplenethidden = '';
					$("input[name='packtvalue[]']").each(function() {
   						samplenet = samplenet + ($(this).val() + '</br>');	
						samplenethidden = samplenethidden + ($(this).val() + '*');	
					})
					
					
					var sample = "";
					if(createspan != '')
					
					
					{
					var sample = "<table><tr><td>"+createspan+"<input type='hidden' name='detailsamplename[]' value='"+createspanhidden+"'/></td><td>=></td><td>"+samplenet+"<input type='hidden' name='detailsamplenet[]' value='"+samplenethidden+"'/></td></tr></table>";
					}
						
					
						var err = 0; 
						if(($('#lot').val()) == '' )
						{
							err = 1 ;
							$( "#lot" ).addClass( "glowing-border" );
						}
						if(($('#invoice').val()) == '' )
						{
							err = 1 ;
							$( "#invoice" ).addClass( "glowing-border" );
						}
						/*if(($('#gpno').val()) == '' )
						{
							err = 1 ;
							$( "#gpno" ).addClass( "glowing-border" );
						}
						if(($('#date').val()) == '' )
						{
							err = 1 ;
							$( "#date" ).addClass( "glowing-border" );
						}*/
						if(($('#net').val()) == '' )
						{
							err = 1 ;
							$( "#net" ).addClass( "glowing-border" );
						}
						if(($('#price').val()) == '' )
						{
							err = 1 ;
							$( "#price" ).addClass( "glowing-border" );
						}
						if(($('#garden').val()) == 0 )
						{
							err = 1 ;
							$( "#gardenerr" ).addClass( "glowing-border" );
						}
						if(($('#warehouse').val()) == 0 )
						{
							err = 1 ;
							$( "#wareerr" ).addClass( "glowing-border" );
						}
						if(($('#grade').val()) == 0 )
						{
							err = 1 ;
							$( "#gradeerr" ).addClass( "glowing-border" );
						}
						/*if(($('#chfrom').val()) == '' )
						{
							err = 1 ;
							$( "#chfrom" ).addClass( "glowing-border" );
						}
						
						if(($('#chto').val()) == '' )
						{
							err = 1 ;
							$( "#chto" ).addClass( "glowing-border" );
						}*/
						if(($('#package').val()) == '' )
						{
							err = 1 ;
							$( "#package" ).addClass( "glowing-border" );
						}
						
						if(($('#gross').val()) == '' )
						{
							err = 1 ;
							$( "#gross" ).addClass( "glowing-border" );
						}
						
						
						if(($('#chfrom').val()) > ($('#chto').val()))
						{
						   err = 1 ;
						   $( "#chto" ).addClass( "glowing-border" );
						   $('#chto').val('');

						}
						
						if(err == 0)
						{
						$("#example2").append(
							"<tr id='detailtr"+$("#countdetail").val()+"'  style='border-bottom:1pt solid black;'>"+
							"<td>"+$('#lot').val()+"<input type='hidden' name='detaillot[]' value='"+$('#lot').val()+"'/><br/>"+$('#do').val()+"<input type='hidden' name='detaildo[]' value='"+$('#do').val()+"' /><input type='hidden' name='detailtableid[]' value='0'/></td>"+
							"<td>"+$('#invoice').val()+"<input type='hidden' name='detailinvoice[]' value='"+$('#invoice').val()+"' /></td>"+
							"<td>"+ $("#garden option:selected" ).text()+"<input type='hidden'  name='detailgardenid[]' value='"+ $("#garden option:selected" ).val()+"'/><br/>"+ $("#warehouse option:selected" ).text()+"<input type='hidden'  name='detailwarehouseid[]' value='"+ $("#warehouse option:selected" ).val()+"'/><br/>"+ $("#teagroup option:selected" ).text()+"<input type='hidden'  name='detailteagroupid[]' value='"+ $("#teagroup option:selected" ).val()+"'/></td>"+
							"<td><span name='grade[]'>"+ $("#grade option:selected" ).text()+"</span><br/><span name='ch[]'>"+$('#chfrom').val()+" - "+$('#chto').val()+"</span><input type='hidden'  name='detailgradeid[]' value='"+ $("#grade option:selected" ).val()+"'/><input type='hidden'  name='detailchfrom[]' value='"+ $("#chfrom" ).val()+"'/><input type='hidden'  name='detailchto[]' value='"+ $("#chto" ).val()+"'/></td>"+
							"<td>"+$('#gpno').val()+"<input type='hidden' name='detailgpno[]' value='"+$('#gpno').val()+"' /><br/>"+$('#date').val()+"<input type='hidden' name='detaildate[]' value='"+$('#date').val()+"'/></td>"+
							"<td>"+$('#package').val()+"<input type='hidden' name='detailpackage[]' value='"+$('#package').val()+"'/><br/>"+$('#stamp').val()+"<input type='hidden' name='detailstamp[]' value='"+$('#stamp').val()+"'/><br/>"+$('#net').val()+"<input type='hidden' name='detailnet[]' value='"+$('#net').val()+"'/></td>"+
							"<td>"+sample+"</td>"+
							"<td>"+$('#gross').val()+"<input type='hidden' name='detailgross[]' value='"+$('#gross').val()+"'/><br/>"+$('#brok').val()+"<input type='hidden' class='listbrok' name='detaillistbrokerage[]' value='"+$('#brok').val()+"'/></td>"+
							"<td>"+(calculateTotalWeight()).toFixed(2)+"<input type='hidden' name='detaillisttweight[]' value='"+calculateTotalWeight()+"'/><br/>"+getOption()+" => "+$('#taxrate').val()+"<input type='hidden' name='detailvat[]' value='"+$('#taxrate').val()+"'/><input type='hidden' name='rate_type[]' value='"+$('input[name=type]:checked').val()+"'/><input type='hidden' class='fieldvatrate' name='fieldvatrate[]' id='fieldvatrate"+$("#countdetail").val()+"' value=''/><input type='hidden'  id='fieldcstrate"+$("#countdetail").val()+"' class='fieldcstrate' name='fieldcstrate[]' value=''/><input type='hidden' name='rate_type_id[]' value='"+$("#optionrate option:selected" ).val()+"'/></td>"+
							"<td>"+$('#price').val()+"<input type='hidden' name='detailprice[]' value='"+$('#price').val()+"'/><br/>"+$('#stax').val()+"<input type='hidden' name='detailstax[]' value='"+$('#stax').val()+"'/><input type='hidden' name='stax_id[]' value='"+$("#optionstax option:selected" ).val()+"'/></td>"+
							"<td>"+(calculateValue()).toFixed(2)+"<input type='hidden' value='"+calculateValue()+"' name='detailvalue[]'/><br/> "+(calculatetotal()).toFixed(2)+"<input type='hidden' value='"+calculatetotal()+"' name='detaillisttotal[]'/></td>"+
							"<td><img src='"+basepath+"/application/assets/images/delete.png' height='20' width='20' onclick='deleterow(\"detailtr\","+$("#countdetail").val()+")'/></td>"+
							"</tr>");
	
							calculateratetypetotal($("#countdetail").val());
							calculateTeavalue();
							calculateTotalBrokerage();
							calculateTotalServiceTax();
							calculateTotalVatrate();
							calculateTotalCstrate();
							claculeteTotalPurchaseInvoice();
                                                        calculateTotalStamp();
							//$("#popupwindow input:text").val("");
							//$("#popupwindow select").val(0);
							//$("#addsamplehere").html('');
							makealltextblank();
						
							$(this ).dialog( "close" );
						}
						
					},
					Cancel: function() {
						$( this ).dialog( "close" );
						//$("#popupwindow input:text").val("");
						//$("#popupwindow select").val(0);
						//$("#addsamplehere").html('');
						makealltextblank();
						
					}
				  }
				});
		});
		
		
		
		$("#addsample").click(function(){
			$.ajax({ 
				    			type: "get", 
                                url: basepath+'privatesell/callSamplepage',
                                cache: false, 
                                dataType: 'html',
								success: function(mdata){
									$("#addsamplehere").append(mdata);
									var count = '';
									if($("#samplecount").val() == '')
									{
										count = 0;
									}
									else
									{
									    count = parseFloat($("#samplecount").val()) ;
									}
									var finalc = parseFloat(count) + parseFloat(1);
									$("#samplecount").val(finalc);
									$( "#sampletr" ).attr( "id", "sampletr"+finalc);
									$( "#sampleimg" ).attr( "id", "sampleimg"+finalc);
									$( "#sampleimg"+finalc).attr( "onclick", "deletesample("+finalc+")" );
									
								}
					});
		});
		
		
	 $("#savedpage").click(function(){
		if(($("#calculatevatinput").val() > 0)  && ($("#calculatecstinput").val() > 0))
		{	
			alert("Please check in detail section. VAT and CST cann't persist in a same bill"); 
		}
		else
		{
			var error = 0;
			if(($('#taxinvoice').val()) == '' )
			{
				error = 1 ;
				$( "#taxinvoice" ).addClass( "glowing-border" );
			}
			if(($('#taxinvoicedate').val()) == '' )
			{
				error = 1 ;
				$( "#taxinvoicedate" ).addClass( "glowing-border" );
			}
			if(($('#vendor').val()) == 0 )
			{
				error = 1 ;
				$( "#vendorerr" ).addClass( "glowing-border" );
			}
			if(error == 0)
			{
				$("#spinner").show();
				$( "#addinvoice" ).submit();
			}
		}
	});
	 
	 
	  $("#chestallow").blur(function(){
			claculeteTotalPurchaseInvoice();
    	
		});
	  
	  $("#stampcharge").blur(function(){
			claculeteTotalPurchaseInvoice();
    	});


		/*$( ".call" ).change(function() {
			calculateTotalVatrate();
			claculeteTotalPurchaseInvoice();
		
	});*/
		
		
		 $("#showinvoice").click(function(){
    		
			var vendor = $("#vendor option:selected" ).val();
			var startdate = $('#startdate').val();
			var enddate = $('#enddate').val();
			
	    $("#spinner").show();
			$.ajax({
			   type: "POST",
			   url:   basepath+"privatesell/getlistpurchaseinvoice",
			   data:  {vendor: vendor,startdate: startdate,enddate: enddate},
			   success: function(data)
			   {
					
						$("#spinner").hide();
						window.location.href = basepath+'privatesell/showlist';
					
			   }
		
			});
			
		});
		 
		 
		  $(".opendetail").click(function(){
				var id = $(this).attr('id');
				
			   $.ajax({
			   type: "POST",
			   url:   basepath+"privatesell/getlistingindetail",
			   data:  {id: id},
			    success: function(data)
			   {				
						$rowhead = '<table border="0" width="100%" id="popuptable"><thead bgcolor="#CFDBC5" style="font-family:\'Times New Roman\', Times, serif"><td>LOT/<br/>DO</th><td>Invoice Number</td><td>Garden/<br/>Warehouse</td><td>Grade/<br/>Chest</td><td>GP No/Date</td><td>Package<br/>Stamp/<br/>Net</td><td>Sample</td><td>Gross/<br/>Brokerage</td><td>Total Wt./<br/>Vat</td><td>Price/<br/>Service tax</td><td>Value</td><td>Total</td></thead>'+data+'</table>';
						
						$("#popupdiv").html($rowhead);
						
						$("#popupdiv").dialog({
							resizable: false,
							height:300,
							width:1000,
							modal: true,
							buttons: {
							"CLOSE": function() {
								$( this ).dialog( "close" );
								}
						  }
						});
			   }
		
			});
		 });
		
		
		$( ".showtooltip" ).tooltip({
		show: null,
		position: {
		effect: "slideDown"
		},
		
		});
		
		$('input:radio[name="type"]').change(function(){
		//$("#ratedropdowntr").show();			
		
		
						$.ajax({
					   type: "POST",
					   data:  {startdate: mindate,enddate: maxDate,type: $('input[name=type]:checked').val()},
					   url:   basepath+"privatesell/getTaxlist",
					   success: function(data)
					   {
						 $("#currentvatrate").html(data);
						 
					   }
				
					});
						 if($(this).val() == 'V')
						 {
							 $("#selectionlable").html("VAT Rate");
						 }
						 else
						 {
							  $("#selectionlable").html("CST Rate");
						 }
				
			});
		
		$('.optionrate').change(function(){
				//calculateTotalVatrate();
				calculateCurrentVatratetotal();
				
		});
		
		
		$('#brok').change(function(){
			calculateCurrentVatratetotal();
		});
		
		$('#price').change(function(){
			calculateCurrentVatratetotal();
		});
		
		
		$('#package').change(function(){
			calculateCurrentVatratetotal();
		});
		
		$('#net').change(function(){
			calculateCurrentVatratetotal();
		});
		
		
		
		
		$('#optionstax').change(function(){
				var staxrate = $("#optionstax :selected").text();
				var brokerage = $("#brok").val();
				var result = brokerage * (staxrate/100);
				if(staxrate > 0)
				{
					$("#stax").val(result.toFixed(2));
				}
				
				
		});
		
	
});
	 var basepath =  $("#basepath").val();
	function calculateCurrentVatratetotal()
	{
				var vatrate = $("#optionrate :selected").text();
				var value = calculateValue();
				var brokerage = $("#brok").val();
				if(brokerage != '')
				{
					var btotal = parseFloat(brokerage) + parseFloat(value);
				}
				else
				{
					var btotal =  parseFloat(value);
				}
				
				var result =  btotal * (vatrate/100);
				
				
				if(vatrate > 0)
				{
					$("#taxrate").val(result.toFixed(2));
				}
	}

	function getOption()
	{
		var selected = $('input[name=type]:checked').val();
				
			if(selected == 'V')
			{
				return "VAT";
			}
			else
			{
				return "CST";	
			}
		
		
	}
	
	function deleterow(rowname,rowid)
	{
		$("#"+rowname+rowid).remove();
		
		calculateTeavalue();
		calculateTotalBrokerage();
		calculateTotalServiceTax();
		calculateTotalVatrate();
		calculateTotalCstrate();
		claculeteTotalPurchaseInvoice();
	}
	
	function deleterowdb(rowname,rowid)
	{
		$.ajax({
				type: "POST",
				data:  {detailid: rowid},
				url:   basepath+"privatesell/deleteInvoicedetail",
				success: function(data)
				{
					deleterow(rowname,rowid);
				}
				
			});
		
	}
	
	function calculateTotalWeight()
	{
		
		var countsample = 0;
		var weight = 0;
		var net = 0;	
		var value = 0;
		var samplednet = 0;
		var package = 0;
		
		if($("#samplecount").val() != '')
		{
			var countsample = $("#samplecount").val();
		}
		else
		{
			var countsample = 0;	
		}
		if($("#package").val() != '')
		{
			var package = $("#package").val();
		}
		else
		{
			var package = 0;	
		}
		if($("#net").val() != '')
		{
			var net = $("#net").val();
		}
		else
		{
			var net = 0;	
		}
	
		
		if(countsample>0)
		{
			var packged = ((package - countsample) * net);
			
			$('input[name^="packtvalue"]').each(function() {
				if( $(this).val() != '')
				{
					value = $(this).val();
				}
				else
				{
					value = 0;	
				}
   				 samplednet = parseFloat(samplednet) + parseFloat(value);
			});
			weight =  parseFloat(packged) +  parseFloat(samplednet);
		}
		else
		{
			weight = package * net;
		}
		
		return weight;
	}
	
	function calculateValue()
	{
		var price = 0;
		if($("#price").val() != '')
		{
			price = $("#price").val();
		}
		
		return (calculateTotalWeight() * price);
	}
	
	function calculatetotal()
	{
		var value = calculateValue();
		var brokerage = 0;
		var vat= 0;
		var servicetax = 0;
		
		if($("#brok").val() != '')
		{
			brokerage = $("#brok").val();
		}
		
		if($("#taxrate").val() != '')
		{
			vat = $("#taxrate").val();
		}
		if($("#stax").val() != '')
		{
			servicetax = $("#stax").val();
		}
		var total = parseFloat(value)+parseFloat(brokerage)+parseFloat(vat)+parseFloat(servicetax);
		return (total);
		
	}
	
	
	function calculateTeavalue()
	{
		var value = 0;	
		var totalnet = 0;
		$('input[name^="detailvalue"]').each(function() {
				if( $(this).val() != '')
				{
					value = $(this).val();
				}
				else
				{
					value = 0;	
				}
   				 totalnet = parseFloat(totalnet) + parseFloat(value);
			});
		
		$('#teavalue').html(totalnet);
		$('#teavalueinput').val(totalnet);
		
	}
	
	function calculateTotalBrokerage()
	{
		var value = 0;
		var totalbrok = 0;
		
		$('.listbrok').each(function() {
				if( $(this).val() != '')
				{	
					value = $(this).val();
				}
				else
				{
					value = 0;	
				}
				
   				totalbrok = parseFloat(totalbrok) + parseFloat(value);
			});
		
		$('#totalbrokerage').html(totalbrok);
		$('#brokerageinput').val(totalbrok);
		
	}
	
	/*function calculateTotalServiceTax()
	{
		var value = 0;
		var totallistbrok = 0;
		
		$('.listbrok').each(function() {
				if( $(this).val() != '')
				{
					value = $(this).val();
				}
				else
				{
					value = 0;	
				}
   				 totallistbrok = parseFloat(totallistbrok) + parseFloat(value);
			});
		var totalstax = $('#stax').val();
		
		$('#servicetax').html(totalstax * totallistbrok);
		$('#servicetaxinput').val(totalstax * totallistbrok);
		
	}*/
	
	function calculateTotalServiceTax()
	{
		var value = 0;
		var totalstax = 0;
		
		$('input[name^="detailstax"]').each(function() {
				if( $(this).val() != '')
				{
					value = $(this).val();
				}
				else
				{
					value = 0;	
				}
				
   				 totalstax = parseFloat(totalstax) + parseFloat(value);
			});
			
		$('#servicetax').html(totalstax.toFixed(2));
		$('#servicetaxinput').val(totalstax.toFixed(2));
		
	}
	
	/*function calculateTotalVatrate()
	{
		//var type = $('input[name=type]:checked').val();
		//if (type == 'V')
		//{
			var allowance = 0;
			var teavalue = 0;
			var totalbrokerage = 0;
			
			if($('#teavalue').html() != '')
			{
				teavalue = $('#teavalue').html();
			}
			if($('#totalbrokerage').html() != '')
			{
				totalbrokerage = $('#totalbrokerage').html();
			}
			if($('#chestallow').val() != '')
			{
				allowance = $('#chestallow').val();
			}
			//var vat = $('#vatrate').val();
			var vat = $('#taxrate').val();
			
			var value = (parseFloat(teavalue) +  parseFloat(totalbrokerage) + parseFloat(allowance)) * vat;
			
			$('#calculatevat').html(value);
			$('#calculatevatinput').val(value);
		}
		else
		{
			$('#calculatevat').html(0);
			$('#calculatevatinput').val(0);
		}
		
	}*/
	function calculateratetypetotal(id)
	{
		var selected = $('input[name=type]:checked').val();
		if( $("#taxrate").val() != '')
				{
					value = $("#taxrate").val();
				}
				else
				{
					value = 0;	
				}
		if(selected == 'V')
		{
			$('#fieldvatrate'+id).val(value);
		}
		else
		{
			$('#fieldcstrate'+id).val(value);
		}
	}
	function calculateTotalVatrate()
	{
		var totalvalue = 0;
		$('input[name^="fieldvatrate"]').each(function() {
				if( $(this).val() != '')
				{
					value = $(this).val();
				}
				else
				{
					value = 0;	
				}
				
   				 totalvalue = parseFloat(totalvalue) + parseFloat(value);
			});
		
		$('#calculatevat').html(totalvalue.toFixed(2));
		$('#calculatevatinput').val(totalvalue.toFixed(2));
	}
	
	function calculateTotalCstrate()
	{
		var totalvalue = 0;
		$('input[name^="fieldcstrate"]').each(function() {
				if( $(this).val() != '')
				{
					value = $(this).val();
				}
				else
				{
					value = 0;	
				}
   				 totalvalue = parseFloat(totalvalue) + parseFloat(value);
			});
		$('#calculatecst').html(totalvalue.toFixed(2));
		$('#calculatecstinput').val(totalvalue.toFixed(2));
	}
	function claculeteTotalPurchaseInvoice()
	{
		var teavalue = 0;
		var brokerage = 0;
		var servicetax = 0;
		var chestallow = 0;
		var calculatevat = 0;
		var stampcharge = 0;
		
		if($('#teavalue').html() != '')
		{
			teavalue = $('#teavalue').html();
		}
		if($('#totalbrokerage').html() != '')
		{
			brokerage = $('#totalbrokerage').html();
		}
		if($('#servicetax').html() != '')
		{
			servicetax = $('#servicetax').html();
		}
		if($('#chestallow').val() != '')
		{
			chestallow = $('#chestallow').val();
		}
		if($('#calculatevat').html() != '')
		{
			calculatevat = $('#calculatevat').html();
		}
		if($('#stampcharge').val() != '')
		{
			stampcharge = $('#stampcharge').val();
		}
	
		var totalcalculation = parseFloat(teavalue) + parseFloat(brokerage)   + parseFloat(servicetax)  + parseFloat(chestallow)  + parseFloat(calculatevat) + parseFloat(stampcharge);
		
		$('#total').html(totalcalculation.toFixed(2));
		$('#totalinput').val(totalcalculation.toFixed(2));
		
		
	}
	
	function deletesample(rowid)
	{
		$("#sampletr"+rowid).remove();
		
		var count = '';
			if($("#samplecount").val() == '')
			{
				count = 0;
			}
			else
			{
					count = parseFloat($("#samplecount").val()) ;
			}
			var finalc = parseFloat(count) - parseFloat(1);
			$("#samplecount").val(finalc);
	}
	
	function checkDecimal(value)
	{
			var regex = new RegExp(/^\+?[0-9(),.-]+$/);
			if(value.match(regex))
			{
				return true;
			}
			return false;
	}
	
	function checkNumeric(obj)
	{
		
		var regex = new RegExp(/^[0-9]+$/);
		
			if(obj.value.match(regex))
			{
				return true;
			}
			obj.value = "";
			return false;
		
	}
         //abhik
        function calculateTotalStamp(){
            var totalvalue = 0;
		$('input[name^="detailstamp"]').each(function() {
				if( $(this).val() != '')
				{
					value = $(this).val();
				}
				else
				{
					value = 0;	
				}
   				 totalvalue = parseFloat(totalvalue) + parseFloat(value);
			});
                        
                        
		
		$('#stampcharge').val(totalvalue.toFixed(2));
            
        }
	
	
	function makealltextblank()
	{
		$('#lot').val('');
		$('#do').val('');
		$('#invoice').val('');
		$('#garden').val('');
		$('#warehouse').val('');
		$('#grade').val('');
		$('#package').val('');
		$('#stamp').val('');
		$('#net').val('');
		$('#gross').val('');
		$('#brok').val('');
		$('#chfrom').val('');
		$('#chto').val('');
		$('#gpno').val('');
		$('#date').val('');
		$('#vat').val('');
		$('#stax').val('');
		$('#taxrate').val('');
		$('#price').val('');
		$('#addsamplehere').html('');
		$("input[name=type][value='V']").prop("checked",true);
		$("#addsamplehere").html('');
		$('#garden').val('0'); 
		$('#grade').val('0'); 
		$('#teagroup').val('0');
		$('#warehouse').val('0');
		$('#optionrate').val('0');
		$('#optionstax').val('0');
	}
	function editrow(rowname,rowid)
	{
		
		$('#lot').val($('#lot'+rowid).html());
		$('#do').val($('#do'+rowid).html());
		$('#teagroup').val($('#detailteagroupid'+rowid).val());
		$('#invoice').val($('#invoice'+rowid).html());
		$('#garden').val($('#detailgardenid'+rowid).val());
		$('#warehouse').val($('#detailwarehouseid'+rowid).val());
		$('#grade').val($('#detailgradeid'+rowid).val());
		$('#package').val($('#package'+rowid).html());
		$('#stamp').val($('#stamp'+rowid).html());
		$('#net').val($('#net'+rowid).html());
		$('#gross').val($('#gross'+rowid).html());
		$('#brok').val($('#brokerage'+rowid).html());
		$('#chfrom').val($('#detailchfrom'+rowid).val());
		$('#chto').val($('#detailchto'+rowid).val());
		$('#gpno').val($('#gpnumber'+rowid).html());
		$('#date').val($('#gpdate'+rowid).html());
		$('#vat').val($('#vat'+rowid).html());
		$('#price').val($('#price'+rowid).html());
		$('#stax').val($('#stax'+rowid).html());
		if($('#ratetype'+rowid).val() == 'V')
		{
			$("input[name=type][value='C']").removeAttr("checked",false);
			$("input[name=type][value='V']").prop("checked",true);
			$('#selectionlable').html("VAT Rate");
			$('#currentvatrate').show();
			$('#currentcstrate').hide();
		}
		else
		{	
			$("input[name=type][value='V']").removeAttr("checked",false);
			$("input[name=type][value='C']").prop("checked",true);
			$('#selectionlable').html("CST Rate");
			$('#currentcstrate').show();
			$('#currentvatrate').hide();
		}
		var option = $('#ratetypeid'+rowid).val();
		$("#optionrate [value='"+option+"']").attr("selected","selected");
		$('#taxrate').val($('#ratetypevalue'+rowid).val());
		
		var staxop = $('.servicetaxid').val();
		$("#optionstax [value='"+staxop+"']").attr("selected","selected");
				
		var sample = $('#sample'+rowid).html();
		var samplenet = $('#samplenet'+rowid).html();
		
		if(sample != '')
		{
			var samplearr = sample.split('<br>'); 
			var samplenetarr = samplenet.split('<br>'); 
		
			var row = '';
			var tr = '';
			
			 for (i = 0; i < samplearr.length; i++) {
				
				row = '<table><tr id="sampletr'+rowid+'"><td><input type="text" name="packtno[]" id="packtno" value="'+samplearr[i]+'"/></td><td>&nbsp;</td><td><input type="text" name="packtvalue[]" id="packtvalue" class="packtvaluenet" value="'+samplenetarr[i]+'" onblur="calculateCurrentVatratetotal()"/><img src="http://localhost:8080/tea_samrat/application/assets/images/delete.png" id="sampleimg'+rowid+'" height="15" width="15" onclick="deletesample('+rowid+')"></td></tr></table>';
				$("#samplecount").val(samplearr.length);
				$('#addsamplehere').html(($('#addsamplehere').html())+row);
			}
		}
		
		
					$("#detailpurchaseinvoice").dialog({
				resizable: false,
				height:600,
				width:1000,
				modal: true,
				buttons: {
				"Confirm": function() {
					
					$("#example2").find('td.dataTables_empty').parent().remove();
					$("#countdetail").val(parseFloat($("#countdetail").val()) + parseFloat(1));
					
					var createspan = '';
					var createspanhidden = ''; 
					$("input[name='packtno[]']").each(function() {
   						createspan = createspan + ($(this).val() + '<br/>');
						createspanhidden = createspanhidden + ($(this).val() + '*');
						
					})
					
					var samplenet = '';
					var samplenethidden = '';
					$("input[name='packtvalue[]']").each(function() {
   						samplenet = samplenet + ($(this).val() + '</br>');	
						samplenethidden = samplenethidden + ($(this).val() + '*');	
					})
					
					
					var sample = "";
					if(createspan != '')
					{
					var sample = "<table><tr><td>"+createspan+"<input type='hidden' name='detailsamplename[]' value='"+createspanhidden+"'/></td><td>=></td><td>"+samplenet+"<input type='hidden' name='detailsamplenet[]' value='"+samplenethidden+"'/></td></tr></table>";
					}
						
					
						var err = 0; 
						if(($('#lot').val()) == '' )
						{
							err = 1 ;
							$( "#lot" ).addClass( "glowing-border" );
						}
						if(($('#invoice').val()) == '' )
						{
							err = 1 ;
							$( "#invoice" ).addClass( "glowing-border" );
						}
						/*if(($('#gpno').val()) == '' )
						{
							err = 1 ;
							$( "#gpno" ).addClass( "glowing-border" );
						}
						if(($('#date').val()) == '' )
						{
							err = 1 ;
							$( "#date" ).addClass( "glowing-border" );
						}*/
						if(($('#net').val()) == '' )
						{
							err = 1 ;
							$( "#net" ).addClass( "glowing-border" );
						}
						if(($('#price').val()) == '' )
						{
							err = 1 ;
							$( "#price" ).addClass( "glowing-border" );
						}
						if(($('#garden').val()) == 0 )
						{
							err = 1 ;
							$( "#gardenerr" ).addClass( "glowing-border" );
						}
						if(($('#warehouse').val()) == 0 )
						{
							err = 1 ;
							$( "#wareerr" ).addClass( "glowing-border" );
						}
						if(($('#grade').val()) == 0 )
						{
							err = 1 ;
							$( "#gradeerr" ).addClass( "glowing-border" );
						}
						/*if(($('#chfrom').val()) == '' )
						{
							err = 1 ;
							$( "#chfrom" ).addClass( "glowing-border" );
						}
						
						if(($('#chto').val()) == '' )
						{
							err = 1 ;
							$( "#chto" ).addClass( "glowing-border" );
						}*/
						if(($('#package').val()) == '' )
						{
							err = 1 ;
							$( "#package" ).addClass( "glowing-border" );
						}
						
						if(($('#gross').val()) == '' )
						{
							err = 1 ;
							$( "#gross" ).addClass( "glowing-border" );
						}
						
						if($('#chfrom').val() > $('#chto').val())
						{
							err = 1 ;
							$('#chto').val('');
							$( "#chto" ).addClass( "glowing-border" );

						}
						
					
						if(err == 0)
						{
						$("#detailtr"+rowid).html(
							
							"<td>"+$('#lot').val()+"<input type='hidden' name='detailtableid[]' value='"+$('#detailtableid'+rowid).val()+"' /><input type='hidden' name='detaillot[]' value='"+$('#lot').val()+"'/><br/>"+$('#do').val()+"<input type='hidden' name='detaildo[]' value='"+$('#do').val()+"' /></td>"+
							"<td>"+$('#invoice').val()+"<input type='hidden' name='detailinvoice[]' value='"+$('#invoice').val()+"' /></td>"+
							"<td>"+ $("#garden option:selected" ).text()+"<input type='hidden'  name='detailgardenid[]' value='"+ $("#garden option:selected" ).val()+"'/><br/>"+ $("#warehouse option:selected" ).text()+"<input type='hidden'  name='detailwarehouseid[]' value='"+ $("#warehouse option:selected" ).val()+"'/><br/>"+ $("#teagroup option:selected" ).text()+"<input type='hidden'  name='detailteagroupid[]' value='"+ $("#teagroup option:selected" ).val()+"'/></td></td>"+
							"<td><span name='grade[]'>"+ $("#grade option:selected" ).text()+"</span><br/><span name='ch[]'>"+$('#chfrom').val()+" - "+$('#chto').val()+"</span><input type='hidden'  name='detailgradeid[]' value='"+ $("#grade option:selected" ).val()+"'/><input type='hidden'  name='detailchfrom[]' value='"+ $("#chfrom" ).val()+"'/><input type='hidden'  name='detailchto[]' value='"+ $("#chto" ).val()+"'/></td>"+
							"<td>"+$('#gpno').val()+"<input type='hidden' name='detailgpno[]' value='"+$('#gpno').val()+"' /><br/>"+$('#date').val()+"<input type='hidden' name='detaildate[]' value='"+$('#date').val()+"'/></td>"+
							"<td>"+$('#package').val()+"<input type='hidden' name='detailpackage[]' value='"+$('#package').val()+"'/><br/>"+$('#stamp').val()+"<input type='hidden' name='detailstamp[]' value='"+$('#stamp').val()+"'/><br/>"+$('#net').val()+"<input type='hidden' name='detailnet[]' value='"+$('#net').val()+"'/></td>"+
							"<td>"+sample+"</td>"+
							"<td>"+$('#gross').val()+"<input type='hidden' name='detailgross[]' value='"+$('#gross').val()+"'/><br/>"+$('#brok').val()+"<input type='hidden' class='listbrok' name='detaillistbrokerage[]' value='"+$('#brok').val()+"'/></td>"+
							"<td>"+calculateTotalWeight()+"<input type='hidden' name='detaillisttweight[]' value='"+calculateTotalWeight()+"'/><br/>"+getOption()+" => "+$('#taxrate').val()+"<input type='hidden' name='detailvat[]' value='"+$('#taxrate').val()+"'/><input type='hidden' name='rate_type[]' value='"+$('input[name=type]:checked').val()+"'/><input type='hidden' class='fieldvatrate' name='fieldvatrate[]' id='fieldvatrate"+rowid+"' value=''/><input type='hidden' class='fieldcstrate' id='fieldcstrate"+rowid+"' name='fieldcstrate[]' value=''/><input type='hidden' name='rate_type_id[]' value='"+$("#optionrate option:selected" ).val()+"'/></td>"+
							"<td>"+$('#price').val()+"<input type='hidden' name='detailprice[]' value='"+$('#price').val()+"'/><br/>"+$('#stax').val()+"<input type='hidden' name='detailstax[]' value='"+$('#stax').val()+"'/><input type='hidden' name='stax_id[]' value='"+$("#optionstax option:selected" ).val()+"'/></td>"+
							"<td>"+calculateValue()+"<input type='hidden' value='"+calculateValue()+"' name='detailvalue[]'/><br/> "+calculatetotal()+"<input type='hidden' value='"+calculatetotal()+"' name='detaillisttotal[]'/></td>"+
							"<td><img src='http://teasamrat.com/application/assets/images/delete.png' height='20' width='20' onclick='deleterow(\"detailtr\","+$("#countdetail").val()+")'/><img width='20' height='20' onclick='editrow(\"detailtr\","+$("#countdetail").val()+")' src='http://teasamrat.com/application/assets/images/edit.jpg'/></td>");
	
							calculateratetypetotal(rowid);
							calculateTeavalue();
							calculateTotalBrokerage();
							calculateTotalServiceTax();
							calculateTotalVatrate();
							claculeteTotalPurchaseInvoice();
                                                        calculateTotalStamp();
							//$("#popupwindow input:text").val("");
							//$("#popupwindow select").val(0);
							//$("#addsamplehere").html('');
							makealltextblank();
						
							$(this ).dialog( "close" );
						}
						
					},
					Cancel: function() {
						$( this ).dialog( "close" );
						$("#popupwindow input:text").val("");
						$("#popupwindow select").val(0);
						$("#addsamplehere").html('');
					}
				  }
				});
		
	}
	
	
	
	function deleteSalertobuyer(masterid)
	{
		var basepath =  $("#basepath").val();
		
		$.ajax({
				type: "POST",
				data:  {masterid: masterid},
				url:   basepath+"privatesell/deleteRecord",
				success: function(data)
				{
					$("#row"+masterid).remove();
				}
				
			});
		
	}