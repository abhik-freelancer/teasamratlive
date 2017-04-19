<?php 
//we need to call PHP's session object to access it through CI
class Vatmaster extends CI_Controller {

 function __construct()
 {
   parent::__construct();
    $this->load->model('vatmastermodel','',TRUE);
	
 }
	
 function index()
 {
   
  
     /*load session data*/	
	// $this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result = $this->vatmastermodel->vatlist();
	 $page = 'vat_master/list_view';
	 $header = 'vat_master/header_view';
	 
	/*load helper class to create view*/
	//$this->load->helper('createbody_helper');
	createbody_method($result,$page,$header,$session);
		
 	
 }
 
 	function add()
 	{
		 $value['vat_rate'] = $this->input->post('rate');
		 $value['from_date'] = date("Y-m-d", strtotime($this->input->post('from')));
		 $value['to_date'] = date("Y-m-d", strtotime($this->input->post('to')));
		 $value['is_active'] ='Y';
		
		 if (isset($_POST))
		 {
			$id =  $this->vatmastermodel->add($value);
			echo $id;
      		
		 }
	 
	}
	
 	function modify()
 	{
		 $value['vat_rate'] = $this->input->post('rate');
		 $value['from_date'] =  date("Y-m-d", strtotime($this->input->post('from')));
		 $value['to_date'] = date("Y-m-d", strtotime($this->input->post('to')));
                 $value['is_active'] ='Y';
		 $value['id'] = $this->input->post('id');
		
		
		 if (isset($_POST))
		 {
			$this->vatmastermodel->modify($value);
			
      		
		 }
	 
	}
	
	function delete()
	{
		$value = $this->input->post('id');
		$status = $this->vatmastermodel->delete($value);
		return $status;
	}
}

?>