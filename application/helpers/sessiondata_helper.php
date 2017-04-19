<?php 

if ( ! function_exists('sessiondata_method'))
{
    function sessiondata_method()
    {
      
	  $CI =& get_instance();
	  
	 	 if($CI->session->userdata('logged_in'))
   	 	{
		  $session_data = $CI->session->userdata('logged_in');
		  $data['login_id'] = $session_data['login_id'];
		  $data['role_id'] = $session_data['role_id'];
		  $data['username'] = $session_data['username'];
		  $data['user_id'] = $session_data['id'];
		  
		   $session_data_details = $CI->session->userdata('logged_in_details');
		   $data['company'] =  $session_data_details['company'];
		   $data['yearid'] =  $session_data_details['finanacial_year'];
		   $data['companyname'] =  $session_data_details['companyname'];
		   $data['startyear'] =  $session_data_details['startyear'];
		   $data['endyear'] =  $session_data_details['endyear'];
		   return $data;
		 }	
		 else
		 {
			  redirect('login', 'refresh');
		 }
    }   
}