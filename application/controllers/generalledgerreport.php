<?php

//we need to call PHP's session object to access it through CI
class generalledgerreport extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('generalledgermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
        
 }

    public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
            $company=$session['company'];
            $yearid=$session['yearid'];
            $result['accountList'] =  $this->generalledgermodel->getAccountList($company,$yearid);
            
          /*  echo "<pre>";
            print_r($result['accountList']);
            echo "</pre>"; */
            
            $headercontent='';
            $page = 'general_ledger_report/header_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        
           
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
    public function pdfGeneralLedger(){
        
         $session =  sessiondata_method();
         if ($this->session->userdata('logged_in')) {
          
          $companyId = $session['company'];
          $yearid = $session['yearid'];
    
          
         $this->load->library('pdf');
         $pdf = $this->pdf->load();
         ini_set('memory_limit', '256M'); 
          
          
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $accId = $this->input->post('account');
        $frmDate = date("Y-m-d",strtotime($fromdate));
        $toDate = date("Y-m-d",strtotime($todate));
        
        $fiscalStartDt = $this->generalledgermodel->getFiscalStartDt($yearid);
        
     
     
        
        $result['accountname']=  $this->generalledgermodel->getAccountnameById($accId);
        $result['accounting_period']=$this->generalledgermodel->getAccountingPeriod($yearid);
        $result['generalledger']= $this->generalledgermodel->getGeneralLedgerReport($companyId,$yearid,$accId,$frmDate,$toDate,$fiscalStartDt);
        $this->db->freeDBResource($this->db->conn_id); 
        
       /* echo "<pre>";
        print_r($result['accounting_period']);
        echo "</pre>";
        exit;*/
       
       
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        $result['fromDate'] = $fromdate;
        $result['toDate'] = $todate;
        
         
        
        
         
          $page = 'general_ledger_report/general_ledger_pdf.php';
          $html = $this->load->view($page, $result, TRUE);
                // render the view into HTML
                //$html="Hello";
          $pdf->WriteHTML($html); 
          $output = 'generalledger' . date('Y_m_d_H_i_s') . '_.pdf'; 
          $pdf->Output("$output", 'I');
                exit();
         
          } else {
            redirect('login', 'refresh');
        }
     
        
    }
    
}
?>