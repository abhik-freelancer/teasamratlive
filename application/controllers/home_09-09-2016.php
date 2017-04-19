<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Home extends CI_Controller {

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
	 
	/*get the detail of the page body*/
	 $result = null;
	 $page = 'welcome_view';
	 $header = '';
	 
	/*load helper class to create view*/
	//$this->load->helper('createbody_helper');
	 createbody_method($result,$page,$header,$session);
		
 	
 }

	
 function logout()
 {
   $this->session->unset_userdata('logged_in');
   $this->session->unset_userdata('logged_in_details');
   $this->session->unset_userdata('purchase_invoice_list_detail');
   $this->session->unset_userdata('sellertobuyer_list_detail');
   $this->session->unset_userdata('unreleaseddo_list_invoice');
   $this->session->unset_userdata('private_sell_list_detail');
   
   session_destroy();
   redirect('login', 'refresh');
 }

}

?>