<?php

class Logindetail extends CI_Controller {
   
   	function __construct()
	{
	   parent::__construct();
	   $this->load->model('financialyearmodel','',TRUE);
	   $this->load->model('companymodel','',TRUE);
	}
	function index()
    {
      
	   //$this->load->view('login_view');
	   if($this->input->post('globalcompany') && $this->input->post('globalyear'))
	   {
	  	 $company = $this->input->post('globalcompany');
	  	 $year = $this->input->post('globalyear');
		 $company_name = $this->input->post('text_content_company');
	  	 $year_name = explode('-',($this->input->post('text_content_year')));
		
		 $start_year = trim($year_name[0]);
		 $end_year = trim($year_name[1]);
		
		
		  $sess_array = array(
				'company' => $company,
         		'finanacial_year' => $year,
				'companyname' => $company_name,
				'startyear' => $start_year,
				'endyear' => $end_year
				);
		 
		 $this->session->set_userdata('logged_in_details', $sess_array);
		 redirect('home', 'refresh');
	   
	   }
	   else
	   {
		 $resultco = $this->companymodel->companylist();
		 $resultyear = $this->financialyearmodel->financialyearlist();
		 
		 $data['company'] = $resultco;
		 $data['year'] = $resultyear;
		 $this->load->helper(array('form'));
  	 	 $this->load->view('logindetail_view',$data);
	   }
    }
}
 