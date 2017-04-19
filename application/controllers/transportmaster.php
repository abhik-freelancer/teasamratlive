<?php 
//we need to call PHP's session object to access it through CI
class Transportmaster extends CI_Controller {

 function __construct()
 {
   parent::__construct();
    $this->load->model('transportmastermodel','',TRUE);
	
 }
	
 function index()
 {
   
   
     /*load session data*/	
	 //$this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result = $this->transportmastermodel->transportlist();
	 $page = 'transport_master/list_view';
	 $header = 'transport_master/header_view';
	 
	/*load helper class to create view*/
	//$this->load->helper('createbody_helper');
	 createbody_method($result,$page,$header,$session);
		
 	
 }
 
 	function add()
 	{
		
		 $value['name'] = $this->input->post('name');
		 $value['address'] = $this->input->post('area');
		 $value['phone'] = $this->input->post('phone');
                 $value['pin'] = $this->input->post('pin');
		
		
		 if (isset($_POST))
		 {
			$id =  $this->transportmastermodel->add($value);
			echo $id;
      		
		 }
	 
	}
	
 	function modify()
 	{
		 $value['pin'] = $this->input->post('pin');
		 $value['name'] = $this->input->post('name');
		 $value['address'] = $this->input->post('area');
		 $value['phone'] = $this->input->post('phone');
		 $value['id'] = $this->input->post('id');
		
		
		 if (isset($_POST))
		 {
			$this->transportmastermodel->modify($value);
			
      		
		 }
	 
	}
	
	function delete()
	{
		$value = $this->input->post('id');
		$result = $this->transportmastermodel->delete($value);
		echo $result;
	}
}

?>