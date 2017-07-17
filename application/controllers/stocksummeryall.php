<?php

//we need to call PHP's session object to access it through CI
class stocksummeryall extends CI_Controller {
    
     function __construct() {
        parent::__construct();
		$this->load->model('stocksummerymodelall', '', TRUE);
        $this->load->model('teagroupmastermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
    }
    
	public function index() {
        $session = sessiondata_method();
        $this->companyId = $session['company'];
        $this->yearId = $session['yearid'];
      
        //print_r($session);
		if ($this->session->userdata('logged_in')) {
		  $result['teagrouplist'] =  $this->teagroupmastermodel->teagrouplist();
				 
			$headercontent = '';
			$page = 'stocksummeryall/header_view';
			$header = '';
			/* load helper class to create view */
			createbody_method($result, $page, $header, $session, $headercontent);
			  }
		else {
			   redirect('login', 'refresh');   
			  }
	}
	
	
	   public function getStock(){
       $session = sessiondata_method(); 
       $companyId = $session['company'];
       $yearId = $session['yearid'];
      
       $groupId = $this->input->post('groupId');
       $fromPrice = $this->input->post('fromPrice');
       $toPrice = $this->input->post('toPrice');
       $toDate = date('Y-m-d',  strtotime($this->input->post('toDate')));
       
       $result['stock'] = $this->stocksummerymodelall->getStock($groupId,$fromPrice,$toPrice,$companyId,$toDate,$yearId);
       $this->load->view('stocksummeryall/list_view',$result);
    
   }
   
   
    public function getStockpdf(){
        
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
        $companyId = $session['company'];
        $yearId = $session['yearid'];
		$groupReport="";
       
       $groupId = $this->input->post('group_code');
       $fromPrice = $this->input->post('fromPrice');
       $toPrice = $this->input->post('toPrice');
       $toDate = date('Y-m-d',  strtotime($this->input->post('toDate')));
       
       
       $result['company']=  $this->companymodel->getCompanyNameById($companyId);
       $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
       $result['printDate']=date('d-m-Y');
       $result['upto']=$this->input->post('toDate');
       $result['stock']=$this->stocksummerymodelall->getStock($groupId,$fromPrice,$toPrice,$companyId,$toDate,$yearId);
       
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        ini_set('memory_limit', '256M'); 
             
        $page = 'stocksummeryall/pdf_list_view';
        $html = $this->load->view($page, $result, true);
                // render the view into HTML
        $pdf->WriteHTML($html); 
        $output = 'stockPdfAll' . date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdf->Output("$output", 'I');
        exit();
            
       }
        else {
           redirect('login', 'refresh');   
          }
      }
    
}
?>