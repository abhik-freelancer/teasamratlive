<?php 
//we need to call PHP's session object to access it through CI
class Groupcategorymaster extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('groupcategorymastermodel','',TRUE);
   $this->load->model('groupnamemastermodel','',TRUE);
   $this->load->model('subgroupnamemastermodel','',TRUE);
	
 }
	
 function index()
 {
   
     /*load session data*/	
	// $this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result = $this->groupcategorymastermodel->groupcategorylist();
	 $headercontent['group'] = $this->groupnamemastermodel->groupnamelist();
	 $headercontent['subgroup'] = $this->subgroupnamemastermodel->subgroupnamelist();
	 
	 $page = 'groupcategory_master/list_view';
	 $header = 'groupcategory_master/header_view';
	 
	/*load helper class to create view*/
	//$this->load->helper('createbody_helper');
	 createbody_method($result,$page,$header,$session,$headercontent);
	
 }
 
 	function add()
 	{
		 $value['group_name_id'] = $this->input->post('group');
		 $value['sub_group_name_id'] = $this->input->post('subgroup');
				
		 if (isset($_POST))
		 {
			$id =  $this->groupcategorymastermodel->add($value);
			echo $id;
      		
		 }
	 
	}
	
 	function modify()
 	{
		 $value['group_name_id'] = $this->input->post('group');
		 $value['sub_group_name_id'] = $this->input->post('subgroup');
		 $value['id'] = $this->input->post('id');
		
		if (isset($_POST))
		 {
			$res = $this->groupcategorymastermodel->modify($value);
			echo $res;
      		
		 }
	 
	}
	
	function delete()
	{
		$value = $this->input->post('id');
		
		$result = $this->groupcategorymastermodel->delete($value);
		echo $result;
	}
}

?>