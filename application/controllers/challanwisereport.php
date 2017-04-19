<?php

//we need to call PHP's session object to access it through CI
class challanwisereport extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('challanwisereportmodel', '', TRUE);
        $this->load->model('transportmastermodel', '', TRUE);
        $this->load->model('locationmastermodel', '', TRUE);
        $this->load->model('companymodel','',TRUE);
    }

    public function index() {
        $session = sessiondata_method();
        
         if ($this->session->userdata('logged_in')) {

             $result['transporterlist'] = $this->transportmastermodel->transportlist();
           
        } else {
            redirect('login', 'refresh');
        }
        $headercontent = '';
        $page = 'challanwise_incoming_report/header_view';
        $header = '';
        /* load helper class to create view */
        createbody_method($result, $page, $header, $session, $headercontent);
    }
    
    
    public function getchallanno(){
       $session = sessiondata_method();
       $compny = $session['company'];
       $yearid = $session['yearid'];
       $transporterId = $this->input->post('transporterid');
       $result['challanno']=$this->challanwisereportmodel->getChallanNo($transporterId,$compny,$yearid);
       $page='challanwise_incoming_report/challan_dropdown.php';
       $this->load->view($page,$result);
   }
    
    public function listchallanwisereport(){
        
        $transporterId = $this->input->post('transporterid');
        $challanno = $this->input->post('chalanno');
        $session = sessiondata_method();
        $company = $session['company'];
        $yearid = $session['yearid'];
         
        $data['challanwisereport'] = $this->challanwisereportmodel->getChallanWiseReport($transporterId,$challanno,$company,$yearid);
        $page = 'challanwise_incoming_report/list_view';
        $view = $this->load->view($page, $data , TRUE );
        echo($view);
    
    }
   
    
    /*@method getchallanwisereportPdf()
     * 
     */
    
    public function getchallanwisereportPdf(){
    
        $session= sessiondata_method();
        
    if ($this->session->userdata('logged_in')) { 
        
         $companyId = $session['company'];
         $yearId = $session['yearid'];
        
         $transporterId = $this->input->post('transporterid');
        $challanno = $this->input->post('challanno');
         
         $this->load->library('pdf');
         $pdf = $this->pdf->load();
         ini_set('memory_limit', '256M'); 
        
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        
          $result['printDate']=date('d-m-Y');
       
        $result['challanno']=$challanno;
        $result['transporterName']= $this->challanwisereportmodel->getTransporterName($transporterId);
        $result['challanwisereport_pdf'] = $this->challanwisereportmodel->getChallanWiseReport($transporterId,$challanno,$companyId,$yearId);
        
        $page = 'challanwise_incoming_report/challanwise_report_pdf.php';
        $html = $this->load->view($page, $result, TRUE);
            
        $pdf->WriteHTML($html);
        $output = 'challanwisereport' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output("$output", 'I');
        exit();
        
        } else {
            redirect('login', 'refresh');
        }

        
        
        
    }
    
  
    
}