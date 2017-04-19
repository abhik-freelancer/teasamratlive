<?php 
//we need to call PHP's session object to access it through CI
class Groupmaster extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('groupmastermodel','',TRUE);
   $this->load->model('groupcategorymastermodel','',TRUE);

	
 }
	
 function index()
 {
   
  
     /*load session data*/	
	// $this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result = $this->groupmastermodel->groupmasterlist();
	 $headercontent['categorylist'] = $this->groupcategorymastermodel->groupcategorylist();
	
	 
	 $page = 'group_master/list_view';
	 $header = 'group_master/header_view';
	 
	/*load helper class to create view*/
	//$this->load->helper('createbody_helper');
	 createbody_method($result,$page,$header,$session,$headercontent);
		
 	
 }
 
 	function add()
 	{
		 $value['group_name'] = $this->input->post('group');
		 $value['group_category_id'] = $this->input->post('category');
		 $value['is_special'] = $this->input->post('special');
		 
				
		 if (isset($_POST))
		 {
			$id =  $this->groupmastermodel->add($value);
			echo $id;
      		
		 }
	 
	}
	
 	function modify()
 	{
		 $value['group_name'] = $this->input->post('group');
		 $value['group_category_id'] = $this->input->post('category');
		 $value['is_special'] = $this->input->post('special');
		 
		 $value['id'] = $this->input->post('id');
		
		if (isset($_POST))
		 {
			$res = $this->groupmastermodel->modify($value);
			echo $res;
      		
		 }
	 
	}
	
	function delete()
	{
		$value = $this->input->post('id');
		$result = $this->groupmastermodel->delete($value);
		echo $result;
	}
}

?>