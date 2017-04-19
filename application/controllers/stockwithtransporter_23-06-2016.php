<?php

//we need to call PHP's session object to access it through CI
class Stockwithtransporter extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('doreceivedmodel', '', TRUE);
        $this->load->model('transportmastermodel', '', TRUE);
        $this->load->model('locationmastermodel', '', TRUE);
        $this->load->model('companymodel','',TRUE);
    }

    public function index() {
        $session = sessiondata_method();
        $this->companyId = $session['company'];
        $this->yearId = $session['yearid'];
        $selected_transporter = $this->input->post('drpTransporter');

        // $ispending = $this->input->post('chkpendingdo');

        if ($this->session->userdata('logged_in')) {

             $result['transporterlist'] = $this->transportmastermodel->transportlist();
            if ($selected_transporter == '') {
               
                $result['selected_transporter'] = (!$selected_transporter ? "0" : $selected_transporter);
                $result['doRcvTransList']='';
               
            } else {
                $result['doRcvTransList'] = $this->doreceivedmodel->getDoTransporter($selected_transporter);
                $result['selected_transporter'] = (!$selected_transporter ? "0" : $selected_transporter);
                $result['location']=  $this->locationmastermodel->loactionmasterlist();

            }
        } else {
            redirect('login', 'refresh');
        }


        $headercontent = '';
        $page = 'stock_with_transporter/header_view';
        $header = '';
        /* load helper class to create view */
        createbody_method($result, $page, $header, $session, $headercontent);
    }
    
    public function liststockwithtransporter(){
        
        $transporterId = $this->input->post('transporterid');
      
       // $company = $session['company'];
      //  $year = $session['yearid'];
       /* $value = array(
            
            'transporterid'=> $transporter,
      
        );*/
        
        $data['stock_with_transporter'] = $this->doreceivedmodel->getStockwithtransporter($transporterId);
        
     
        $page = 'stock_with_transporter/list_view';
        $view = $this->load->view($page, $data , TRUE );
        echo($view);
    
    }
    
    public function getStockWithTransPrint(){
        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        $data['company']=  $this->companymodel->getCompanyNameById($companyId);
        $data['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        
        $data['dateRange'] =date('d-m-Y',  strtotime('01-04-2013')). " to ".date('d-m-Y');
        $data['printDate']=date('d-m-Y');
       
        $transporteridrep = $this->input->post('transporterid');
        $data['transporterName']=  $this->doreceivedmodel->getTransporterName($transporteridrep);
        
        $data['stock_with_transporter_report'] = $this->doreceivedmodel->getStockwithtransporter($transporteridrep);
        // print_r($data['transporterName']);
        $page = 'stock_with_transporter/stk_with_transporter_report';
        $view = $this->load->view($page,$data, TRUE );
        echo($view);
    }
    
}