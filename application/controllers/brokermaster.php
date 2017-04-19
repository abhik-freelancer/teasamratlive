<?php 
//we need to call PHP's session object to access it through CI
class Brokermaster extends CI_Controller {

 function __construct()
 {
   parent::__construct();
    $this->load->model('brokermastermodel','',TRUE);
	
 }
	
 function index()
 {
   
   
     /*load session data*/	
	// $this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result = $this->brokermastermodel->brokerlist();
	 $page = 'broker_master/list_view';
	 $header = 'broker_master/header_view';
	 
	/*load helper class to create view*/
	//$this->load->helper('createbody_helper');
	 createbody_method($result,$page,$header,$session);
		
 	
 }
 
 	function add()
 	{
		 $value['code'] = $this->input->post('code');
		 $value['name'] = $this->input->post('name');
		 $value['address'] = $this->input->post('address');
		
		
		 if (isset($_POST))
		 {
			$id =  $this->brokermastermodel->add($value);
			echo $id;
      		
		 }
	 
	}
	
 	function modify()
 	{
		 $value['code'] = $this->input->post('code');
		 $value['name'] = $this->input->post('name');
		 $value['address'] = $this->input->post('address');
		 $value['id'] = $this->input->post('id');
		
		
		 if (isset($_POST))
		 {
			$this->brokermastermodel->modify($value);
			
      		
		 }
		// echo $value['id'];
	 
	}
	
	function delete()
	{
		$value = $this->input->post('id');
		$result = $this->brokermastermodel->delete($value);
		echo $result;
	}
}

?>