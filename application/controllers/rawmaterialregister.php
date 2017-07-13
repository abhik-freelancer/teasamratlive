<?php
    class rawmaterialregister extends CI_Controller {
       function __construct() {
        parent::__construct();
        
        $this->load->model('rawmaterialregistermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
        $this->load->model('vendormastermodel', '', TRUE);
       
       
    }
    
     public function index() {

        if ($this->session->userdata('logged_in')) {
             $session = sessiondata_method();

            $headercontent['vendor'] = $this->vendormastermodel->vendorlist($session);
      
            $page = 'rawmaterial_register/header_view';
            $header = "";
			$result="";
            createbody_method($result,$page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
     public function getRawMaterialRegister() {
		if ($this->session->userdata('logged_in')){
			$session = sessiondata_method();
			$companyId = $session['company'];
			$yearId = $session['yearid'];
			$startdate = date('Y-m-d',  strtotime($this->input->post('startdate')));
			$enddate = date('Y-m-d',  strtotime($this->input->post('enddate')));
			$vendor =  $this->input->post('vendor');
			
			$value = array(
				'startDate'=>$startdate,
				'endDate'=>$enddate,
				'vendorId'=>$vendor
			);
			
			$data['rawmaterialpurchase_register'] = $this->rawmaterialregistermodel->getRawMaterialRegisterList($value,$companyId,$yearId);
		   
			$page = 'rawmaterial_register/list_view';
			$view = $this->load->view($page, $data , TRUE );
			echo($view);
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