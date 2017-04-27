<?php
    class purchaseregnew extends CI_Controller {
       function __construct() {
        parent::__construct();

       
        $this->load->model('vendormastermodel', '', TRUE);
        $this->load->model('purchaseregistermodel', '', TRUE);
		$this->load->model('generalledgermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
    }
    
     public function index() {

        
        if ($this->session->userdata('logged_in')) {
			 $session =  sessiondata_method();
			$headercontent['vendor'] = $this->vendormastermodel->vendorlist($session);
			$headercontent['startDt'] =  $this->generalledgermodel->getFiscalStartDt($session['yearid']);
			$page = 'purchase_register/purchase_register_new/header_view';
            $header = "";
			$result = "";
			createbody_method($result,$page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
	
	
	public function getPurchaseRegister()
	{
		if($this->session->userdata('logged_in'))
		{
			$session = sessiondata_method();
			
			$compnyID = $session['company']; 
			$yearID = $session['yearid']; 
			
			$fromDate = $this->input->post('startdate');
			$toDate = $this->input->post('enddate');
			$vendor = $this->input->post('vendor');
			
			$fDate = date('Y-m-d',strtotime($fromDate));
			$toDt = date('Y-m-d',strtotime($toDate));
			
			
		
			$result['company']=  $this->companymodel->getCompanyNameById($compnyID);
			$result['companylocation']=  $this->companymodel->getCompanyAddressById($compnyID);
			
			$result['forperiod'] = $fromDate." To ".$toDate;
			$result['vendor_name'] =  $this->purchaseregistermodel->getVendorNameByID($vendor);
		
			$result['purchaseRegister'] = $this->purchaseregistermodel->getPurchaseRegister($fDate,$toDt,$vendor,$compnyID,$yearID);
			$result['getPurchaseRegSumData'] = $this->purchaseregistermodel->getPurchaseRegSumData();
			/*
			echo "<pre>";
			print_r($result['getPurchaseRegSumData']);
			echo "</pre>";*/
			
			
			$page = "purchase_register/purchase_register_new/purchase_register_all_pdf";
			$this->load->view($page,$result);
			
			
			
			
		}
		else
		{
			
		}
	}
    

    
}
?>