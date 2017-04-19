<?php

//we need to call PHP's session object to access it through CI
class creditorsoutstanding extends CI_Controller {
    
     function __construct() {
        parent::__construct();
        $this->load->model('creditorsoutstandingmodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
        }
        
         public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
            $company=$session['company'];
            $yearid=$session['yearid'];
          //  $result['accountList'] =  $this->debitoroutstandingmodel->getAccountList($company,$yearid);
            
          /*  echo "<pre>";
            print_r($result['accountList']);
            echo "</pre>"; */
            
            $headercontent='';
            $page = 'creditors_outstanding/header_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        
           
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
    public function pdfCreditorsOutstanding(){
         $session =  sessiondata_method();
         if ($this->session->userdata('logged_in')) {
          
          $companyId = $session['company'];
          $yearid = $session['yearid'];
    
          
         $this->load->library('pdf');
         $pdf = $this->pdf->load();
         ini_set('memory_limit', '256M'); 
          
          
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
       
        $frmDate = date("Y-m-d",strtotime($fromdate));
        $toDate = date("Y-m-d",strtotime($todate));
        
       
        
     
     
        
      
        $result['accounting_period']=$this->creditorsoutstandingmodel->getAccountingPeriod($yearid);
        $result['creditorsoutstanding']= $this->creditorsoutstandingmodel->getCreditorOutstandingList($yearid,$companyId,$frmDate,$toDate);
        $this->db->freeDBResource($this->db->conn_id); 
     
       
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        $result['fromDate'] = $fromdate;
        $result['toDate'] = $todate;
        
         
        
        
         
          $page = 'creditors_outstanding/creditors_outstanding_pdf.php';
          $html = $this->load->view($page, $result, TRUE);
                // render the view into HTML
                //$html="Hello";
          $pdf->WriteHTML($html); 
          $output = 'creditoroutstanding' . date('Y_m_d_H_i_s') . '_.pdf'; 
          $pdf->Output("$output", 'I');
                exit();
         
          } else {
            redirect('login', 'refresh');
        }
    }
 
}

?>