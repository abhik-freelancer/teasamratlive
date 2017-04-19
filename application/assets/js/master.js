 function checkDates(fromdate,todate)
 {
		var fit_start_time  = fromdate; //2013-09-5
		var fit_end_time    = todate; //2013-09-10
		
			var fit_start_timerr = fit_start_time.split("-");
			from = new Date(fit_start_timerr[2]+'/'+fit_start_timerr[1]+'/'+fit_start_timerr[0]);
			
			var fit_end_timerr = fit_end_time.split("-");
			to = new Date(fit_end_timerr[2]+'/'+fit_end_timerr[1]+'/'+fit_end_timerr[0]);
			
			if((fit_start_time != '') && (fit_end_time == ''))
			{
				$('#to').addClass('makeborderred');
			}
			else if((fit_end_time != '') && (fit_start_time == ''))
			{
				$('#from').addClass('makeborderred');
				
			}
			else
			{
				
					$('#from').removeClass('makeborderred');
					$('#to').removeClass('makeborderred');
				
			}
			if((fit_start_time != '') && (fit_end_time != ''))
			{
				
				if(to < from)
				{
				
					$('#from').addClass('makeborderred');
					
				}
				else
				{
					$('#from').removeClass('makeborderred');
					$('#to').removeClass('makeborderred');
				}
			}
			
			
			
	 
}
 