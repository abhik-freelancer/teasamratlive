<?php

//we need to call PHP's session object to access it through CI
class invoicestatus extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('blendingmodel', '', TRUE);
        $this->load->model('warehousemastermodel', '', TRUE);
        $this->load->model('productmodel','',TRUE);
        $this->load->model('purchaseinvoicemastermodel','',TRUE);
        $this->load->model('gardenmastermodel',"",TRUE);
        $this->load->model('invoicestatusmodel',"",TRUE);
    }

    public function index() {
        
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            $result = '';
            $page = 'invoice_status/header_view';
            $header = '';
            $headercontent['garden'] = $this->gardenmastermodel->gardenlist();
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }

    public function showInvoice(){
        $garden = $this->input->post('garden');
        $result['invoice']=$this->invoicestatusmodel->getInvoice($garden);
        $page='invoice_status/invoicedropdown.php';
        $this->load->view($page,$result);
    }

    public function showLotNumber(){
        $garden  = $this->input->post('garden');
        $invoice = $this->input->post('invoice');
        $result['lot']=  $this->invoicestatusmodel->getLotNumber($garden,$invoice);
        $page='invoice_status/lotdropdown.php';
        $this->load->view($page,$result);
    }
    
    public function showGrade(){
        $garden  = $this->input->post('garden');
        $invoice = $this->input->post('invoice');
        $lot = $this->input->post('lot');
        $result['grade']=  $this->invoicestatusmodel->getGradeNumber($garden,$invoice,$lot);
        $page='invoice_status/gradedropdown.php';
        $this->load->view($page,$result);
    }
    
  public function showTeaStock()
    {
       $session = sessiondata_method();
       if ($this->session->userdata('logged_in')) {
           $garden  =  $this->input->post('gardenId');
           $invoice =  $this->input->post('invoiceNum');
           $lotNum  = $this->input->post('lotNum');
           $grade =  $this->input->post('grade');
           
           $purchaseInvoiceDetailId = $this->invoicestatusmodel->getPurchaseInvoiceId($garden,$invoice,$lotNum,$grade);
           
           $result['mastData'] = $this->invoicestatusmodel->getMasterData($purchaseInvoiceDetailId);
           $result['groupStock'] = $this->invoicestatusmodel->getTeaStock($purchaseInvoiceDetailId);
            
           
           if($result['groupStock']){
            $page = 'invoice_status/dtlStatus.php';
            $this->load->view($page, $result);
           }
           else{
               echo "0";
           }
            
       }else{
            redirect('login', 'refresh');
       }
    }
    
   public function detailView(){
       $session = sessiondata_method();
       if ($this->session->userdata('logged_in')) {
        $bagDtlId=  $this->input->post('bagDtlId');   
       // $blndDtlId=  $this->input->post('bl_DtlId');   
        $result['blendDetail'] = $this->invoicestatusmodel->getBlendedDetail($bagDtlId);
        
       /* echo "<pre>";
            print_r($result['blendDetail']);
        echo "</pre>";*/
        
        
        $page = 'invoice_status/blendDtlview.php';
       
        $this->load->view($page, $result);
       }else{
            redirect('login', 'refresh');
       }
   }
   
   
    public function StockOutDtlView(){
       $session = sessiondata_method();
       if ($this->session->userdata('logged_in')) {
        $bagDtlId=  $this->input->post('bagDtlId');   
       // $blndDtlId=  $this->input->post('bl_DtlId');   
        $result['stockDtlView'] = $this->invoicestatusmodel->getStockOutBagDetail($bagDtlId);
        
       /* echo "<pre>";
            print_r($result['blendDetail']);
        echo "</pre>";*/
        
        
        $page = 'invoice_status/stockOutDtlView.php';
       
        $this->load->view($page, $result);
       }else{
            redirect('login', 'refresh');
       }
   }
   
    public function RawTeaSaleDtlView(){
       $session = sessiondata_method();
       if ($this->session->userdata('logged_in')) {
        $bagDtlId=  $this->input->post('bagDtlId');   
     
        $result['saleDtlView'] = $this->invoicestatusmodel->getSaleOutbagDtl($bagDtlId);
      
        $page = 'invoice_status/saleOutDtlView.php';
       
        $this->load->view($page, $result);
       }else{
            redirect('login', 'refresh');
       }
   }
    

   

}


?>