<?php
class customerpayment extends CI_Controller {
     public function __construct() {
        parent::__construct();
        $this->load->model('customermastermodel', '', TRUE);
        $this->load->model('generalvouchermodel', '', TRUE);
        $this->load->model('customeradvancemodel', '', TRUE);
        $this->load->model('customeradvanceadjstmentmodel', '', TRUE);
        $this->load->model('customerpaymentmodel', '', TRUE);
    }
    
    public function index(){
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            $result = $this->customerpaymentmodel->getCustomerPaymentList($session['company'],$session['yearid']);
            //$result="";
            $page = 'customer_payment/list_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
    public function addCustomerPayment() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {
                $customerpaymentId = 0;
            } else {
                $customerpaymentId = $this->uri->segment(4);
            }
            $headercontent['customerAccList'] = $this->customermastermodel->getCustomerAccountId($session['company']);  
            $headercontent['CashOrBank'] = $this->generalvouchermodel->getAccountByGroupMaster($session['company']);

            if ($customerpaymentId == 0) {
                $headercontent['mode'] = "Add";
                $page = 'customer_payment/addEdit';
                $result = "";
            } else {
                $headercontent['mode'] = "Edit";
                $page = 'customer_payment/addEdit';
                $result["customerpayment"] = $this->customerpaymentmodel->getCustomerPaymentMasterDataById($customerpaymentId);
                $result["customerPaymentDtl"] = $this->customerpaymentmodel->getCustomerPaymentDetails($customerpaymentId);
                $result['invoices'] = $this->customeradvanceadjstmentmodel->getSaleInvoiceByCustomer($result["customerpayment"]["customeraccountid"]);
                
            
                
                
            }
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
      public function getSaleBillList() {
        $customerAccountId = $this->input->post('customerAccountId');
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {

            $result['invoices'] = $this->customeradvanceadjstmentmodel->getSaleInvoiceByCustomer($customerAccountId);
            $page = 'customer_advance_adjustment/detail.php';
            $this->load->view($page, $result);
        } else {
            redirect('login', 'refresh');
        }
    }
    
     public function getUnpaidtBillAmount(){
        
        $customerBillMasterId = $this->input->post('customerBillMasterId');
        $customerPaymentId = $this->input->post('customerPaymentid');
        
        $session = sessiondata_method();
        $companyId = $session['company'];
       
        
         if ($this->session->userdata('logged_in')) {

            $unpaidAmount = $this->customerpaymentmodel->getcustomerUnpaidBill($customerBillMasterId,$companyId,$customerPaymentId);
            echo json_encode(array('unpaidAmt'=>$unpaidAmount));
            exit();
            
            
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
    
    
   public function saveCustomerPayment() {
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
            $masterData["customerPaymentId"] = $this->input->post("customerPaymentId");
            $masterData["voucherId"]=  $this->input->post("voucherId");
            $masterData["dateofpayment"] = $this->input->post("paymentDate");
            $masterData["debitAccountId"] = $this->input->post("debitAccountId");
            $masterData["chequeNo"] = $this->input->post("chequeNo");
            $masterData["chequeDate"] = $this->input->post("chequeDate");
            $masterData["customerId"] = $this->input->post("customerId");
            $masterData["totalPayment"] = $this->input->post("totalPayment");
            $masterData["narration"]= $this->input->post("narration");
			$masterData["customerchqbank"]=$this->input->post("customerbank");
			$masterData["customerchqbankbranch"] = $this->input->post("customerbankbranch");
            
            if($masterData["customerPaymentId"]==0){
            $masterData["voucherNumber"] = NULL;//$this->getvouchernumber();
            $masterData["voucherSerial"] =0; //$this->generate_serial_no();
            $masterData["lastSrNo"] =0;// $this->getSerialNumber();
             }
            
            $masterData["companyId"] = $session['company'];
            $masterData["yearId"] = $session["yearid"];
            $masterData["userId"]=$session["user_id"];
            
            
           /* echo "<pre>";
            print_r($masterData);
            echo "</pre>";
            exit;*/

            $details = $this->input->post('details');
                     
            $billDetails;
           
            foreach ($details as $value) {
               
                foreach ($value as $data) {

                    $billDetails[] = array(
                        'customerBillMasterId' => $data['customerBillMasterId'],
                        'paidAmount' => $data['paidAmount']
                    );

                    
                }
            }

           if ($masterData["customerPaymentId"] == 0) {
               $result =  $this->customerpaymentmodel->insertData($masterData, $billDetails);
               $this->output->set_content_type('application/json')
                            ->set_output(json_encode($result));
              
            } else {
               $result =  $this->customerpaymentmodel->UpdateData($masterData, $billDetails);
               $this->output->set_content_type('application/json')
                            ->set_output(json_encode($result));
            }
        } else {

            redirect('login', 'refresh');
        }
    }
    
    public function getvouchernumber() {
        $session = sessiondata_method();
        $cid = $session['company'];
        $yid = $session['yearid'];
        $voucher_srl_no = $this->generalvouchermodel->getSerailvoucherNo($cid, $yid);
        $srl = intval($voucher_srl_no) + 1;
        $padding = '00000';
        if ($srl >= 10 && $srl < 100) {
            $padding = '00000';
        } elseif ($srl >= 100 && $srl < 1000) {
            $padding = '000';
        } elseif ($srl >= 1000 && $srl < 10000) {
            $padding = '00';
        } elseif ($srl >= 10000 && $srl < 10000) {
            $padding = '0';
        } elseif ($srl >= 100000 && $srl < 1000000) {
            $padding = '';
        }
        $voucherNo = $padding . $srl . "/" . substr($session['startyear'], 2, 2) . "-" . substr($session['endyear'], 2, 2);

        //echo "serial No is".$srl;
        return $voucherNo;
    }
    
     public function getSerialNumber() {

        $session = sessiondata_method();
        $cid = $session['company'];
        $yid = $session['yearid'];
        $voucher_srl_no = $this->generalvouchermodel->getSerailvoucherNo($cid, $yid);
        $srl = $voucher_srl_no + 1;
        return $srl;
    }
    
        private function generate_serial_no() {
        $session = sessiondata_method();
        $cid = $session['company'];
        $yid = $session['yearid'];
        $voucher_srl_no = $this->generalvouchermodel->getLastSerialNo($cid, $yid);
        $srl = $voucher_srl_no['serialNo'] + 1;
        //echo "serial No is".$srl;
        return $srl;
    }
    
     public function getDetailsOfInvoice(){
        $session = sessiondata_method();
        $paymentId = $this->input->post('customerPaymentId');

        if ($this->session->userdata('logged_in')) {
            
            $result['invoicedetails'] = $this->customerpaymentmodel->getDetail($paymentId);
            $page = 'customer_advance_adjustment/view_detail.php';
            $this->load->view($page, $result);
        }else{
              redirect('login', 'refresh');
        }
    }
}

?>