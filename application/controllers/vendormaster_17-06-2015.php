<?php 
//we need to call PHP's session object to access it through CI
class Vendormaster extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('vendormastermodel','',TRUE);
   $this->load->helper('createbody_helper');
   $this->load->helper('sessiondata_helper');

	
 }
	
 function index()
 {
   
  
     /*load session data*/	
	 $session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result['master'] = $this->vendormastermodel->vendorlist($session);
	 foreach($result['master'] as $val)
	 {
	 	$arr[] = $this->vendormastermodel->vendorEditdata($val->vid);
		
	 }
	// $headercontent['groupmastername'] = $this->groupmastermodel->groupmasterlist();
	
	  $result[$val->vid] = $arr;
	 $page = 'vendor_master/list_view';
	 $header = 'vendor_master/header_view';
	 
	/*load helper class to create view*/
	//$this->load->helper('createbody_helper');
	 createbody_method($result,$page,$header,$session);
		
 	
 }
 
 	function add()
 	{
		 
	 	 $session = sessiondata_method();
		 
		
		 $value['vendor_name'] = $this->input->post('name');
		 $value['address'] = $this->input->post('address');
		 $value['tin_number'] = $this->input->post('tin');
		 $value['cst_number'] = $this->input->post('cst');
		 $value['pan_number'] = $this->input->post('pan');
		 $value['service_tax_number'] = $this->input->post('servicetax');
		 $value['GST_Number'] = $this->input->post('gst');
		 $value['pin_number'] = $this->input->post('pin');
		  if($this->input->post('state') > 0)
		 {
		 	$value['state_id'] = $this->input->post('state');
		 }
		
		 $value['opening_balance'] = $this->input->post('obal');
		 $value['company_id'] = $session['company'];
		 $value['financialyear_id'] = $session['yearid'];
						

		 if (isset($_POST))
		 {
			$id =  $this->vendormastermodel->add($value);
			//echo $id;
			
			/* $value1arr = $this->input->post('listbnumber');
			 $value2arr = $this->input->post('listbdate');
			 $value3arr = $this->input->post('listddate');
			 $value4arr = $this->input->post('listbamount');
			 $value5arr = $this->input->post('listdamount');
			 if(count($value1arr) > 0)
			 {
				 for($i = 0; $i<count($value1arr); $i++)
				 {
					 $valued['vendor_id'] = $id ;
					 $valued['bill_number'] = $value1arr[$i];
					 $valued['bill_date'] =  date("Y-m-d", strtotime($value2arr[$i]));
					 $valued['due_date'] =  date("Y-m-d", strtotime($value3arr[$i]));
					 $valued['bill_amount'] =  $value4arr[$i];
					 $valued['due_amount'] =  $value5arr[$i];
					 
					 $idd =  $this->vendormastermodel->adddetail($valued);
					 
				 }
				 
			  }*/
      		
		 }
		
	redirect('vendormaster', 'refresh');
	}
	
	function addpage()
	{
		//$this->load->helper('sessiondata_helper');
	 	$session = sessiondata_method();
		$result = $this->vendormastermodel->getStates();
		$page = 'vendor_master/add_view';
	 	$header = '';
		$headercontent ='';
	 
	/*load helper class to create view*/
	 //$this->load->helper('createbody_helper');
	 createbody_method($result,$page,$header,$session,$headercontent);
	}
	
	
	function editpage()
	{
		 $vendor_id = $this->uri->segment(4, 0);
		//$this->load->helper('sessiondata_helper');
	 	$session = sessiondata_method();
		
		$result['states'] = $this->vendormastermodel->getStates();
		$result['data'] = $this->vendormastermodel->vendorEditdata($vendor_id);
		
			
		$page = 'vendor_master/edit_view';
		$header = '';
		$headercontent ='';
	
	/*load helper class to create view*/
	
	 createbody_method($result,$page,$header,$session,$headercontent);
	}
	
 
 	function modify()
 	{
		
	 	 $session = sessiondata_method();
		 
		 $value['id'] = $this->uri->segment(4, 0);
		 $value['vendor_name'] = $this->input->post('name');
		 $value['address'] = $this->input->post('address');
		 $value['tin_number'] = $this->input->post('tin');
		 $value['cst_number'] = $this->input->post('cst');
		 $value['pan_number'] = $this->input->post('pan');
		 $value['service_tax_number'] = $this->input->post('servicetax');
		 $value['GST_Number'] = $this->input->post('gst');
		 $value['pin_number'] = $this->input->post('pin');
		 if($this->input->post('state') > 0)
		 {
		 	$value['state_id'] = $this->input->post('state');
		 }
		  else
		 {
			 $value['state_id'] = '';
		 }
		 $value['account_master_id'] = $this->input->post('accmasterid');
		 $value['opening_balance'] = $this->input->post('obal');
		 $value['company_id'] = $session['company'];
		 $value['financialyear_id'] = $session['yearid'];
		 $value['accopenmaster'] = $this->input->post('accopenmaster');
		 
		 
		 //$value['id'] = $this->input->post('id');
		// $value['aob'] = $this->input->post('openbal');
		
		if (isset($_POST))
		 {
			$res = $this->vendormastermodel->modify($value);
			/*$delres = $this->vendormastermodel->deleteDetail($value['id']);
			
			 $value1arr = $this->input->post('listbnumber');
			 $value2arr = $this->input->post('listbdate');
			 $value3arr = $this->input->post('listddate');
			 $value4arr = $this->input->post('listbamount');
			 $value5arr = $this->input->post('listdamount');
			
			 if(count($value1arr) > 0)
			 {
				 for($i = 0; $i<count($value1arr); $i++)
				 {
					 $valued['vendor_id'] = $value['id'] ;
					 $valued['bill_number'] = $value1arr[$i];
					 $valued['bill_date'] =  date("Y-m-d", strtotime($value2arr[$i]));
					 $valued['due_date'] =  date("Y-m-d", strtotime($value3arr[$i]));
					 $valued['bill_amount'] =  $value4arr[$i];
					 $valued['due_amount'] =  $value5arr[$i];
					 
					 $idd =  $this->vendormastermodel->adddetail($valued);
				}
				 
			  }*/
		//	echo $res;
      		
		 }
		redirect('vendormaster');
	}
	
	function delete()
	{
		$value['id'] = $this->input->post('id');
		$value['aom'] = $this->input->post('aom');
		$value['am'] = $this->input->post('am');
		
		$response = $this->vendormastermodel->delete($value);
		echo json_encode($response);
		exit;
		//echo $response;
	}
	
	/*function deletedetail()
	{
		$value = $this->input->post('iddata');
		$this->vendormastermodel->vendoropeningbalance($value);
	}
	*/
	function dispalyEditDetails()
	{
		$data = $this->vendormastermodel->getVendorBalanceDetail($this->input->post('id'));
		$row= '';
		
		if($data != '')
		{
			foreach($data as $value)
			{
				$row .= '<tr><td>'.$value->purchase_invoice_number.'</td><td>'.$value->purchase_invoice_date.'</td><td>'.$value->bill_amount.'</td><td>'.number_format($value->due_amount, 2, '.', '').'</td></tr>';	
			}
		}
		else
		{
			$row ='<td style="text-align:center" colspan="4">No record found</td>';	
		}
		
			echo $row;
	}
}

?>