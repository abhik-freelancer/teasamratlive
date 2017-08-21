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
	/**
         * gstPurchaseRegister
         */
    public function gstPurchaseRegister(){
        
           if ($this->session->userdata('logged_in')) {
		$session =  sessiondata_method();
		$headercontent=NULL;
		$page = 'purchase_register/purchase_register_new/headergst';
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
    
public function getGSTPurchaseRegister()
	{
		if($this->session->userdata('logged_in'))
		{
			$session = sessiondata_method();
			
			$compnyID = $session['company']; 
			$yearID = $session['yearid']; 
			
			$fromDate = $this->input->post('fromdate');
			$toDate = $this->input->post('todate');
			
			
			$fDate = date('Y-m-d',strtotime($fromDate));
			$toDt = date('Y-m-d',strtotime($toDate));
		
			$result['company']=  $this->companymodel->getCompanyNameById($compnyID);
			$result['companylocation']=  $this->companymodel->getCompanyAddressById($compnyID);
			
			$result['forperiod'] = $fromDate." To ".$toDate;
                        $result['purchaseRegister']=$this->purchaseregistermodel->generateGstPurchaseRegister($compnyID,$yearID,$fDate,$toDt);
                      /*  echo("<pre>");
                        print_r($result['purchaseRegister']);
			echo("</pre>");*/
                        
                        $this->db->freeDBResource($this->db->conn_id); 
	
                        $this->load->library('pdf');
                        $pdf = $this->pdf->load();
                        ini_set('memory_limit', '256M'); 
                        
                        
			
			$page = "purchase_register/purchase_register_new/purchase_register_all_pdf_gst";
			$html = $this->load->view($page, $result, TRUE);
                        $pdf->WriteHTML($html); 
                        $output = 'Purchase' . date('Y_m_d_H_i_s') . '_.pdf'; 
                        $pdf->Output("$output", 'I');
                        exit();
			
			
			
			
		}
		else
		{
			
		}
	}
    
}
?>