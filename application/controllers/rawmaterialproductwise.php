<?php
class rawmaterialproductwise extends CI_Controller {
    function __construct() {
    parent::__construct();
        
    $this->load->model('rawmaterialregistermodel', '', TRUE);
    $this->load->model('companymodel', '', TRUE);
	$this->load->model('rawmaterialmodel', '', TRUE);     
}
    
    public function index() 
	{

        if ($this->session->userdata('logged_in')) {
             $session = sessiondata_method();

            $headercontent['rawmaterial'] = $this->rawmaterialmodel->rawmaterialMasterList();
			$result = "";
            $page = 'rawmaterial_register/rawmaterial_productwise/header_view';
            $header = "";
            createbody_method($result,$page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
     public function getProductWiseRawMaterialRegister() {
		 
		  if ($this->session->userdata('logged_in'))
		  {
			$session = sessiondata_method();
			$companyId = $session['company'];
			$yearId = $session['yearid'];
			  
			$startdate = ($this->input->post('startdate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('startdate'))));
			$enddate = ($this->input->post('enddate')=="" ? NULL : date("Y-m-d",strtotime($this->input->post('enddate'))));
			$rawmaterialProdID = $this->input->post('rawmaterial');
			
			$value = array(
				'startDate'=>$startdate,
				'endDate'=>$enddate,
				'rawmaterialPrdID'=>$rawmaterialProdID,
				"companyID"=>$companyId,
				"yearID"=>$yearId
			);
			
			$forPeriod = "";
			if($startdate!="")
			{
				$forPeriod = 'For Period '.date('d-m-Y',strtotime($startdate)).' To '.date('d-m-Y',strtotime($enddate));
			}
			else
			{
				$forPeriod = '';
			}
			
			$result['rawmaterialProduct'] = $this->rawmaterialmodel->getUnitMasterData($rawmaterialProdID);
			$result['forPeriod'] = $forPeriod;
			$result['rawmaterialProductWisePDF'] = $this->rawmaterialregistermodel->getProductWiseRawMaterial($value);
			
			$result['company']=  $this->companymodel->getCompanyNameById($companyId);
			$result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
			
			
			
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			ini_set('memory_limit', '256M'); 
        
			$page = 'rawmaterial_register/rawmaterial_productwise/raw_materail_reg_productwise_pdf';
            $html = $this->load->view($page, $result, TRUE);
			//echo $html;
		
            $pdf->WriteHTML($html); 
            $output = 'rawmaterialProductWise' . date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdf->Output("$output", 'I');
            exit();
			
			
		  }
		  else
		  {
			 redirect('login', 'refresh');
		  }
       
		
    }
    
    
  /*  public function getRawMaterialRegistPrint(){
        
        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        
        $startDate = $this->input->post('startdate');
        $endDate = $this->input->post('enddate');
        $vendorId = $this->input->post('vendor');
        
         $value = array(
            'startDate'=>$startDate,
            'endDate'=>$endDate,
            'vendorId'=>$vendorId
        );
        
        $data['rawmaterialpurchase_register'] = $this->rawmaterialregistermodel->getRawMaterialRegisterList($value); 
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        ini_set('memory_limit', '256M'); 
        
        
        
        $pdf->WriteHTML($str); 
        $output = 'salebillregister' . date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdf->Output("$output", 'I');
        exit();
       
       
    }*/
   
    
}
?>