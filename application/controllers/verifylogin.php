<?php 
 
class VerifyLogin extends CI_Controller {
 
function __construct()
{
   parent::__construct();
   $this->load->model('loginmodel','',TRUE);
}
 
function index()
{
   //This method will have the credentials validation
   
   $this->load->library('form_validation');
 
   $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
 
   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.  User redirected to login page
     $this->load->view('login_view');
   }
   else
   {
     //Go to private area
	redirect('logindetail', 'refresh');
   //  redirect('home', 'refresh');
   }
 
}
 
function check_database($password)
{
   //Field validation succeeded.  Validate against database
  
   $username = $this->input->post('username');
 
   //query the database
   $result = $this->loginmodel->login($username, $password);
 
   if($result)
   {
	  $sess_array = array();
     foreach($result as $row)
     {
       $sess_array = array(
         'id' => $row->id,
         'login_id' => $row->login_id,
		 'role_id'=> $row->role_id,
		 'username'=> $row->First_Name .' '. $row->Last_Name
       );
       $this->session->set_userdata('logged_in', $sess_array);
     }
     return TRUE;
   }
   else
   {
     $this->form_validation->set_message('check_database', 'Invalid username or password');
     return false;
   }
}
}
?>
