<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class vendorpayment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendormastermodel', '', TRUE);
        $this->load->model('generalvouchermodel', '', TRUE);
        $this->load->model('vendoradvancemodel', '', TRUE);
        $this->load->model('vendorAdvanceAdjstmodel', '', TRUE);
        $this->load->model('vendorpaymentmodel', '', TRUE);
    }

    public function index() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            $result = $this->vendorpaymentmodel->getVendorPaymentList($session['company'],$session['yearid']);
            $page = 'vendorpayment/list_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }

    public function addVendorPayment() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {
                $vendorpaymentId = 0;
            } else {
                $vendorpaymentId = $this->uri->segment(4);
            }
            $headercontent['vendors'] = $this->vendormastermodel->getVendorList();
            $headercontent['CashOrBank'] = $this->generalvouchermodel->getAccountByGroupMaster();

            if ($vendorpaymentId == 0) {
                $headercontent['mode'] = "Add";
                $page = 'vendorpayment/addEdit';
                $result = "";
            } else {
                
            }
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }

    public function getPurchaseBillList() {
        $vendorAccountId = $this->input->post('vendoraccId');
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {

            $result['invoices'] = $this->vendorAdvanceAdjstmodel->getPurchaseInvoiceByVendor($vendorAccountId);
            $page = 'vendoradvanceadjust/detail.php';
            $this->load->view($page, $result);
        } else {
            redirect('login', 'refresh');
        }
    }

    public function saveVendorPayment() {
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
            $masterData["vendorPaymentId"] = $this->input->post("vendorPaymentId");
            $masterData["dateofpayment"] = $this->input->post("paymentDate");
            $masterData["creditAccountId"] = $this->input->post("creditAccountId");
            $masterData["chequeNo"] = $this->input->post("chequeNo");
            $masterData["chequeDate"] = $this->input->post("chequeDate");
            $masterData["vendorId"] = $this->input->post("vendorId");
            $masterData["totalPayment"] = $this->input->post("totalPayment");
            $masterData["narration"]= $this->input->post("narration");
            $masterData["voucherNumber"] = $this->getvouchernumber();
            $masterData["voucherSerial"] = $this->generate_serial_no();
            $masterData["lastSrNo"] = $this->getSerialNumber();
            $masterData["companyId"] = $session['company'];
            $masterData["yearId"] = $session["yearid"];
            $masterData["userId"]=$session["user_id"];

            $details = $this->input->post('details');
                     
            $billDetails;
           
            foreach ($details as $value) {
               
                foreach ($value as $data) {

                    $billDetails[] = array(
                        'vendorBillMasterId' => $data['vendorBillMasterId'],
                        'paidAmount' => $data['paidAmount']
                    );

                    
                }
            }



            
            if ($masterData["vendorPaymentId"] == 0) {
               $result =  $this->vendorpaymentmodel->insertData($masterData, $billDetails);
               $this->output->set_content_type('application/json')
                            ->set_output(json_encode($result));
              
            } else {
                //update
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
        $paymentId = $this->input->post('vendorpaymentId');

        if ($this->session->userdata('logged_in')) {
            
            $result['invoicedetails'] = $this->vendorpaymentmodel->getDetail($paymentId);
            $page = 'vendorpayment/view_detai.php';
            $this->load->view($page, $result);
        }else{
              redirect('login', 'refresh');
        }
    }

}
