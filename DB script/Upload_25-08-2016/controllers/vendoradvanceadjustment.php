<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class vendoradvanceadjustment extends CI_Controller {
    
     public function __construct() {
        parent::__construct();
        $this->load->model('vendormastermodel', '', TRUE);
        $this->load->model('generalvouchermodel', '', TRUE);
        $this->load->model('vendoradvancemodel','',TRUE);
        $this->load->model('vendorAdvanceAdjstmodel','',TRUE);

        
    }
    public function index(){
         $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            $result = $this->vendorAdvanceAdjstmodel->getAdjustmentList($session['company'],$session['yearid']);
            $page = 'vendoradvanceadjust/list_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    public function addEditAdjustment(){
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
             
             if ($this->uri->segment(4) === FALSE) {
                 $vendorAdvanceAdjustment = 0;
            } else {
                $vendorAdvanceAdjustment = $this->uri->segment(4);
            }
             $headercontent['vendors'] = $this->vendormastermodel->getVendorList();   
            
            if($vendorAdvanceAdjustment==0){
                 $headercontent['mode'] = "Add";
                 $page = 'vendoradvanceadjust/addEdit';
                 $result="";
            }  else {
                
            }
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
         }else{
             redirect('login', 'refresh');
         }
    }
    public function getAdvanceVoucher(){
        $vendorAccountId = $this->input->post('vendoraccId');
        $session = sessiondata_method();
        
        if ($this->session->userdata('logged_in')) {

            $result['advancevoucher'] = $this->vendorAdvanceAdjstmodel->getVendorAdvanceVoucher($vendorAccountId);
            $page = 'vendoradvanceadjust/advancevoucherlist.php';
            $this->load->view($page, $result);
        } else {
            redirect('login', 'refresh');
        }
    }
    public function getAdvanceAmountById(){
        $advanceId = $this->input->post('advanceId');
        $session = sessiondata_method();
        $advanceAmount=0;
        if ($this->session->userdata('logged_in')) {

            $advanceAmount = $this->vendorAdvanceAdjstmodel->getAdvanceAmountByAdvanceId($advanceId);
            echo json_encode(array('advamount'=>$advanceAmount));
            exit();
            
        } else {
            redirect('login', 'refresh');
        }
        
    }
    public function  addPurchaseBill(){
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
    public function getUnpaidBillAmount(){
        
        $vendorBillMasterId = $this->input->post('vendorBillMasterId');
        $session = sessiondata_method();
        $companyId = $session['company'];
       
        
         if ($this->session->userdata('logged_in')) {

            $unpaidAmount = $this->vendorAdvanceAdjstmodel->getVendorUnpaidBill($vendorBillMasterId,$companyId);
            echo json_encode(array('unpaidAmt'=>$unpaidAmount));
            exit();
            
            
        } else {
            redirect('login', 'refresh');
        }
    }
    
    public function getBillDateAndOthers(){
        
        $vendorBillMasterId=  $this->input->post('vendorBillMasterId');
        
        $session = sessiondata_method();
        $companyId = $session['company'];
       
        
         if ($this->session->userdata('logged_in')) {

            $result = $this->vendorAdvanceAdjstmodel->getBillDateAndOthers($vendorBillMasterId);
            echo json_encode($result);
            exit();
            
            
        } else {
            redirect('login', 'refresh');
        }
        
    }
    public function  SaveAdjustment(){
        
        $masterData["AdjustmentRefNo"] = $this->input->post('refno');
        $masterData["DateOfAdjustment"] = date("Y-m-d", strtotime($this->input->post('dateofadjstment')));
        $masterData["vendorAccId"]=$this->input->post('vendorAccountId');
        $masterData["advanceMasterId"]= $this->input->post('advanceVoucherId');
        $masterData["TotalAmountAdjusted"] = $this->input->post('totalAdjustment');
        
        $details = $this->input->post('details');
        $billDetails;
        $i=0;
        foreach ($details as  $value) {
           foreach ($value as $data) {
                 
               $billDetails[]=array(
                                    'vendorBillMasterId'=>$data['vendorBillMasterId'],
                                    'adjustedAmount'   => $data['adjustedAmount']
                   );
               
               //echo($value[$i]['adjustedAmount']);
                $i=i+1;
            }
        }
        //print_r($billDetails);
        
        $result = $this->vendorAdvanceAdjstmodel->insertVendorBillAdjustment($masterData,$billDetails);
        if($result){
            echo(1);
        }  else {
            echo(0);
        }
    }
}

