<?php

//we need to call PHP's session object to access it through CI
class saletaxregister extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('saletaxregistermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
        
 }

    public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
            $result='';
            $headercontent='';
            $page = 'sale_tax_register/header_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        
           
        } else {
            redirect('login', 'refresh');
        }
    }

    public function showsaletaxRegister(){
        
        if ($this->session->userdata('logged_in')) {
              
         $fromdate = $this->input->post('fromdate');
         $todate = $this->input->post('todate');
         
         $frmDate = date("Y-m-d",strtotime($fromdate));
         $toDate = date("Y-m-d",strtotime($todate));
         $data['salestaxregister']= $this->saletaxregistermodel->getSaleTaxregisterData($frmDate,$toDate);
         $data['inputtaxregister'] = $this->saletaxregistermodel->getInputTaxregisterData($frmDate,$toDate);
         $page = 'sale_tax_register/list_view';
         $view = $this->load->view($page, $data, TRUE);
         echo($view);
         
          } else {
            redirect('login', 'refresh');
        }
    }
    
  public function printSaleTaxRegister(){
        
      $session =  sessiondata_method();
         if ($this->session->userdata('logged_in')) {
          
          $companyId = $session['company'];
             
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $frmDate = date("Y-m-d",strtotime($fromdate));
        $toDate = date("Y-m-d",strtotime($todate));
		
        $result['salestaxregister']= $this->saletaxregistermodel->getSaleTaxregisterData($frmDate,$toDate,$companyId);
        $result['inputtaxregister'] = $this->saletaxregistermodel->getInputTaxregisterData($frmDate,$toDate,$companyId);
		/*
		echo "<pre>";
			print_r($result['inputtaxregister']);
		echo "</pre>";
		*/
         
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        $result['fromDate'] = $fromdate;
        $result['toDate'] = $toDate;
        
         
         $page = 'sale_tax_register/salestax_register_print';
         $view = $this->load->view($page, $result, TRUE);
         echo ($view);  
         
          } else {
            redirect('login', 'refresh');
        }
            
    }

        
       
 
}
?>