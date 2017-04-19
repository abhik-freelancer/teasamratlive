<?php
    class purchaseregister extends CI_Controller {
       function __construct() {
        parent::__construct();

        $this->load->model('auctionareamodel', '', TRUE);
        $this->load->model('vendormastermodel', '', TRUE);
        $this->load->model('warehousemastermodel', '', TRUE);
        $this->load->model('grademastermodel', '', TRUE);
        $this->load->model('gardenmastermodel', '', TRUE);
        $this->load->model('purchaseinvoicemastermodel', '', TRUE);
        $this->load->model('locationmastermodel', '', TRUE);
        $this->load->model('bagtypemodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
    }
    
     public function index() {

         $session =  sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            //$session = sessiondata_method();
           // $session_purchase = $this->session->userdata('purchase_invoice_list_detail');

           

            $headercontent['vendor'] = $this->vendormastermodel->vendorlist($session);
           // echo("<pre>"); print_r($headercontent['vendor']);echo("</pre>");
            $headercontent['auctionarea'] = $this->auctionareamodel->aucareaList();
            $headercontent['auctionarea'] = $this->auctionareamodel->aucareaList();
            $headercontent['salenumber'] =$this->purchaseinvoicemastermodel->getsaleNumberlist();
            $page = 'purchase_register/header_view';
            $header = "";
            createbody_method($result,$page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
     public function getlistpurchaseregister() {
        //$session = sessiondata_method();
         
        $startdate = date('Y-m-d',  strtotime($this->input->post('startdate')));
        $enddate = date('Y-m-d',  strtotime($this->input->post('enddate')));
        $vendor = $this->input->post('vendor');
        $saleno = $this->input->post('saleno');
        $purchasetype = $this->input->post('purchasetype');
        $purchasearea = $this->input->post('purchasearea');
       // $company = $session['company'];
      //  $year = $session['yearid'];
        $value = array(
            'startDate'=>$startdate,
            'endDate'=>$enddate,
            'vendorId'=>$vendor,
            'saleNumber'=>$saleno,
            'purType'=>$purchasetype,
            'area'=>$purchasearea
        );
        
        $data['search_purchase_register'] = $this->purchaseinvoicemastermodel->getPurchaseRegister($value);
        
      // $result['purchaseregister'] = $this->purchaseinvoicemastermodel->getPurchaseRegister();
        $page = 'purchase_register/list_view';
        $view = $this->load->view($page, $data , TRUE );
        echo($view);
    }
    
    
    public function getPurchaseRegisterPrint(){
         $session = sessiondata_method();
         
         $companyId = $session['company'];
         $yearId = $session['yearid'];
         
        $startdate = date('Y-m-d',  strtotime($this->input->post('startdate')));
        $enddate = date('Y-m-d',  strtotime($this->input->post('enddate')));
        $vendor = $this->input->post('vendor');
        $saleno = $this->input->post('saleno');
        $purchasetype = $this->input->post('purchasetype');
        $purchasearea = $this->input->post('purchasearea');
        
         $this->load->library('pdf');
         $pdf = $this->pdf->load();
         ini_set('memory_limit', '256M'); 
     
       $value = array(
            'startDate'=>$startdate,
            'endDate'=>$enddate,
            'vendorId'=>$vendor,
            'saleNumber'=>$saleno,
            'purType'=>$purchasetype,
            'area'=>$purchasearea
        );
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        $result['printDate']=date('d-m-Y');
        $result['search_purchase_register'] = $this->purchaseinvoicemastermodel->getPurchaseRegister($value);
        

               
                $page = 'purchase_register/purchaseregister_pdf.php';
                $html = $this->load->view($page, $result, TRUE);
                // render the view into HTML
                //$html="Hello";
                $pdf->WriteHTML($html); 
                $output = 'purchaseregister' . date('Y_m_d_H_i_s') . '_.pdf'; 
                $pdf->Output("$output", 'I');
                exit();
        
      
       
    }
    
}
?>