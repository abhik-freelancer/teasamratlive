<?php 
//we need to call PHP's session object to access it through CI
class Servicetaxmaster extends CI_Controller {

 function __construct()
 {
   parent::__construct();
    $this->load->model('servicetaxmastermodel','',TRUE);
	
 }
	
 public function index()
 {
   
   
     /*load session data*/	
	$session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result = $this->servicetaxmastermodel->servicetaxlist();
	 $page = 'servicetax_master/list_view';
	 $header = 'servicetax_master/header_view';
	/*load helper class to create view*/
	createbody_method($result,$page,$header,$session);
 	
 }
 
public function add()
{
		 $value['tax_rate'] = $this->input->post('rate');
		 $value['from_date'] = date("Y-m-d", strtotime($this->input->post('from')));
		 $value['to_date'] = date("Y-m-d", strtotime($this->input->post('to')));
		
		 if (isset($_POST))
		 {
			$id =  $this->servicetaxmastermodel->add($value);
                        if($id){
                            echo 1;
                            exit;
                        }else{
                            echo 0;
                            exit;
                        }
                        
                        
      		
		 }
	 
}
	
 public function modify()
 	{
		 $value['tax_rate'] = $this->input->post('rate');
		 $value['from_date'] =  date("Y-m-d", strtotime($this->input->post('from')));
		 $value['to_date'] = date("Y-m-d", strtotime($this->input->post('to')));
		 $value['id'] = $this->input->post('id');
		
		
		 if (isset($_POST))
		 {
			$this->servicetaxmastermodel->modify($value);
			
      		
		 }
	 
	}
	
public function delete()
	{
		$value = $this->input->post('id');
		$result = $this->servicetaxmastermodel->delete($value);
		echo $result;
	}
}

?>