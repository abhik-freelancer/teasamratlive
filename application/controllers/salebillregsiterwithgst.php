<?php
    class salebillregisterwithgst extends CI_Controller {
       function __construct() {
        parent::__construct();
        
        $this->load->model('salebillregistermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
        $this->load->model('customermastermodel','',TRUE);
		$this->load->model('taxinvoicemodel','',TRUE);
       
    }
    
     public function index() {

        if ($this->session->userdata('logged_in')) {
           
            $session = sessiondata_method();
            $headercontent['customer'] = $this->salebillregistermodel->getCustomerList($session);
			$headercontent['product'] = $this->taxinvoicemodel->getPacketProduct();
			
            $page = 'salebillregister_with_gst/header_view';
            $header = "";
			$result="";
            createbody_method($result,$page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
      
}
?>