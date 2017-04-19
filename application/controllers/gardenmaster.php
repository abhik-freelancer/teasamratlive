<?php 
//we need to call PHP's session object to access it through CI
class Gardenmaster extends CI_Controller {

 function __construct()
 {
   parent::__construct();
    $this->load->model('gardenmastermodel','',TRUE);
	
 }
	
 function index()
 {
   
    /*load session data*/	
	// $this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result = $this->gardenmastermodel->gardenlist();
	 $page = 'garden_master/list_view';
	 $header = 'garden_master/header_view';
	 
	/*load helper class to create view*/
	//$this->load->helper('createbody_helper');
	 createbody_method($result,$page,$header,$session);
	
 }
 
 	function add()
 	{
		 $value['garden_name'] = $this->input->post('gardenname');
		 $value['address'] = $this->input->post('gardenaddress');
		
		
		 if (isset($_POST))
		 {
			 $id =  $this->gardenmastermodel->add($value);
			echo $id;
      		
		 }
	 
	}
	
 	function modify()
 	{
		 $value['garden_name'] = $this->input->post('gardenname');
		 $value['address'] = $this->input->post('gardenaddress');
		 $value['id'] = $this->input->post('id');
		
		
		 if (isset($_POST))
		 {
			$this->gardenmastermodel->modify($value);
			
      		
		 }
	 
	}
	
	function delete()
	{
		$value = $this->input->post('id');
		$result = $this->gardenmastermodel->delete($value);
		echo $result;
	}
}

?>