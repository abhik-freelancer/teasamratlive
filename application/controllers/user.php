<?php 
//we need to call PHP's session object to access it through CI
class User extends CI_Controller {

 function __construct()
 {
   parent::__construct();
    $this->load->model('usermodel','',TRUE);
	
 }
	
 function index()
 {
   
   if($this->session->userdata('logged_in'))
   {
     /*load session data*/	
	// $this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result = $this->usermodel->userlist($session['role_id']);
	 $page = 'user/list_view';
	 $header = 'user/header_view';
	 
	/*load helper class to create view*/
	//$this->load->helper('createbody_helper');
	 createbody_method($result,$page,$header,$session);
		
 	}
	else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }

	
 function logout()
 {
   $this->session->unset_userdata('logged_in');
   session_destroy();
   redirect('home', 'refresh');
 }

}

?>