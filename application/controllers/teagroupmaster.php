<?php 
//we need to call PHP's session object to access it through CI
class Teagroupmaster extends CI_Controller {

 function __construct()
 {
   parent::__construct();
    $this->load->model('teagroupmastermodel','',TRUE);
	
 }
	
 function index()
 {
   
   
     /*load session data*/	
	 //$this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result = $this->teagroupmastermodel->teagrouplist();
	 $page = 'teagroup_master/list_view';
	 $header = 'teagroup_master/header_view';
	 
	/*load helper class to create view*/
	//$this->load->helper('createbody_helper');
	 createbody_method($result,$page,$header,$session);
		
 	
 }
 
 	function add()
 	{
		 $value['group_code'] = $this->input->post('code');
		 $value['group_description'] = $this->input->post('description');
	
		
		
		 if (isset($_POST))
		 {
			$id =  $this->teagroupmastermodel->add($value);
			echo $id;
      		
		 }
	 
	}
	
 	function modify()
 	{
		 $value['group_code'] = $this->input->post('code');
		 $value['group_description'] = $this->input->post('description');
		 $value['id'] = $this->input->post('id');
		
		
		 if (isset($_POST))
		 {
			$this->teagroupmastermodel->modify($value);
			
      		
		 }
	 
	}
	
	function delete()
	{
		$value = $this->input->post('id');
		$result = $this->teagroupmastermodel->delete($value);
		echo $result;
	}
}

?>