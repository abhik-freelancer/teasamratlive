<?php 
//we need to call PHP's session object to access it through CI
class Cstmaster extends CI_Controller {

 function __construct()
 {
   parent::__construct();
    $this->load->model('cstmastermodel','',TRUE);
	
 }
	
 function index()
 {
   
  
     /*load session data*/	
	// $this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result = $this->cstmastermodel->cstlist();
	 $page = 'cst_master/list_view';
	 $header = 'cst_master/header_view';
	 
	/*load helper class to create view*/
	//$this->load->helper('createbody_helper');
	createbody_method($result,$page,$header,$session);
		
 	
 }
 
 	function add()
 	{
		
		$value['cst_rate'] = $this->input->post('rate');
		 $value['from_date'] = date("Y-m-d", strtotime($this->input->post('from')));
		 $value['to_date'] = date("Y-m-d", strtotime($this->input->post('to')));
		
		 if (isset($_POST))
		 {
			$id =  $this->cstmastermodel->add($value);
			echo $id;
      		
		 }
	 
	}
	
 	function modify()
 	{
		 $value['cst_rate'] = $this->input->post('rate');
		 $value['from_date'] =  date("Y-m-d", strtotime($this->input->post('from')));
		 $value['to_date'] = date("Y-m-d", strtotime($this->input->post('to')));
		 $value['id'] = $this->input->post('id');
		
		
		 if (isset($_POST))
		 {
			$this->cstmastermodel->modify($value);
			
      		
		 }
	 
	}
	
	function delete()
	{
		$value = $this->input->post('id');
		$status =  $this->cstmastermodel->delete($value);
		echo $status;
	}
}

?>