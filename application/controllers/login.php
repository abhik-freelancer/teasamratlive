<?php
class Login extends CI_Controller {
   
   	function __construct()
	{
	   parent::__construct();
	}
	function index()
    {
        //$this->load->view('login_view');
		 	$this->load->helper(array('form'));
  			$this->load->view('login_view');
    }
}
 