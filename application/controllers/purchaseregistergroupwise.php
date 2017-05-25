<?php
    class purchaseregistergroupwise extends CI_Controller {
       function __construct() {
        parent::__construct();

       $this->load->model('purchaseinvoicemastermodel', '', TRUE);
	   $this->load->model('companymodel', '', TRUE);
	   $this->load->model('purchaseregistermodel', '', TRUE);
    }
    
    public function index() {

         $session =  sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            //$session = sessiondata_method();
           // $session_purchase = $this->session->userdata('purchase_invoice_list_detail');

			$headercontent['teagroup'] =$this->purchaseinvoicemastermodel->teagrouplist();
            $page = 'purchase_register/purchase_reg_groupwise/header_view';
            $header = "";
            $result = "";
            createbody_method($result,$page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
    public function getPurchaseRegisterPrintGroupWise(){
         $session = sessiondata_method();
         
         $companyId = $session['company'];
         $yearId = $session['yearid'];
         
        $startdate = ($this->input->post('startdate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('startdate'))));
        $enddate = ($this->input->post('enddate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('enddate'))));
		
		
        $group = $this->input->post('group');
		
        $this->load->library('pdf');
         $pdf = $this->pdf->load();
         ini_set('memory_limit', '256M'); 
    
       $value = array(
            'startDate'=>$startdate,
            'endDate'=>$enddate,
            'group'=>$group,
			'compID'=>$companyId,
			'yearID'=>$yearId
        );
		
		$result['group'] = $this->purchaseregistermodel->getTeaGroup($group);
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        $result['printDate']=date('d-m-Y');
       // $result['search_purchase_register'] = $this->purchaseinvoicemastermodel->getPurchaseRegister($value);
	   $result['search_purchase_register'] = $this->purchaseregistermodel->getPurchaseRegisterGroupWise($value);
     
	
		$page = 'purchase_register/purchase_reg_groupwise/purchase_reg_groupwise_pdf.php';
        $html = $this->load->view($page, $result, TRUE);
        $pdf->WriteHTML($html); 
        $output = 'purchaseregister' . date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdf->Output("$output", 'I');
        exit();
        

       
    }
    
}
?>