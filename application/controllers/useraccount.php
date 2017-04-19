<?php

class Useraccount extends CI_Controller {
   
   	function __construct()
	{
	   parent::__construct();
	   $this->load->model('usermodel','',TRUE);
	  
	}
	function index()
    {
		  /*load session data*/	
		// $this->load->helper('sessiondata_helper');
		 $session = sessiondata_method();
		 $resultyear = $this->usermodel->editcurrentuser($session['user_id']);
		 
		 
		// $this->load->helper('createbody_helper');
	     createbody_method($result,$page,$header,$session,$headercontent);
		 
		/* $data['company'] = $resultco;
		 $data['year'] = $resultyear;
		 $this->load->helper(array('form'));
  	 	 $this->load->view('logindetail_view',$data);*/
	   
    }
}
 