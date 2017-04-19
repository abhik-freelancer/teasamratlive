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
        $this->load->model('vendoradvanceadjstmodel','',TRUE);
       // $this->load->model('vendorAdvanceAdjstmodel','',TRUE);

        
    }
    public function index(){
         $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            $result = $this->vendoradvanceadjstmodel->getAdjustmentList($session['company'],$session['yearid']);
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
                $headercontent['mode'] = "Edit";
               // echo "AdjustmentId".$vendorAdvanceAdjustment;
                $result["vendoradjustment"] = $this->vendoradvanceadjstmodel->getVendorAdjMstById($vendorAdvanceAdjustment);
                $result["vendorAdjstDtl"]=  $this->vendoradvanceadjstmodel->getVendAdjstDtl($vendorAdvanceAdjustment);
                $result['advancevoucher'] = $this->vendoradvanceadjstmodel->getVendorAdvanceVoucher($result["vendoradjustment"]["vendorAccId"]);
                $result["remaining"] = $this->vendoradvanceadjstmodel->getAdvanceAmountByAdvanceId($result["vendoradjustment"]["advanceMasterId"]);
                $result["invoiceList"] = $this->vendoradvanceadjstmodel->getPurchaseInvoiceByVendor($result["vendoradjustment"]["vendorAccId"]); 
                $page = 'vendoradvanceadjust/addEdit';
            }
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
         }else{
             redirect('login', 'refresh');
         }
    }
    public function delete(){
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
             if ($this->uri->segment(4) === FALSE) {
                 $vendorAdvanceAdjustment = 0;
            } else {
                $vendorAdvanceAdjustment = $this->uri->segment(4);
            }
            if($vendorAdvanceAdjustment!=0){
                $rslt = $this->vendoradvanceadjstmodel->delete($vendorAdvanceAdjustment);
            }
            
                redirect('vendoradvanceadjustment', 'refresh');
            
                
            
            
         }  else {
              redirect('login', 'refresh');
         }
    }
    
    public function getAdvanceVoucher(){
        $vendorAccountId = $this->input->post('vendoraccId');
        $session = sessiondata_method();
        
        if ($this->session->userdata('logged_in')) {

            $result['advancevoucher'] = $this->vendoradvanceadjstmodel->getVendorAdvanceVoucher($vendorAccountId);
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

            $advanceAmount = $this->vendoradvanceadjstmodel->getAdvanceAmountByAdvanceId($advanceId);
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

            $result['invoices'] = $this->vendoradvanceadjstmodel->getPurchaseInvoiceByVendor($vendorAccountId);
            $page = 'vendoradvanceadjust/detail.php';
            $this->load->view($page, $result);
            
        } else {
            redirect('login', 'refresh');
        }
        
    }
    public function getUnpaidBillAmount(){
        
        $vendorBillMasterId = $this->input->post('vendorBillMasterId');
        $vendorAdjustmntId = $this->input->post('vendorAdjMastId');
        $session = sessiondata_method();
        $companyId = $session['company'];
       
        
         if ($this->session->userdata('logged_in')) {

            $unpaidAmount = $this->vendoradvanceadjstmodel->getVendorUnpaidBill($vendorBillMasterId,$companyId,$vendorAdjustmntId);
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

            $result = $this->vendoradvanceadjstmodel->getBillDateAndOthers($vendorBillMasterId);
            echo json_encode($result);
            exit();
            
            
        } else {
            redirect('login', 'refresh');
        }
        
    }
    public function  SaveAdjustment(){
        
        $masterData["AdjustmentId"]=  $this->input->post('adjustmentId');
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
        if($masterData["AdjustmentId"]!=0){
            $result = $this->vendoradvanceadjstmodel->updateVendorBillAdjustment($masterData,$billDetails);
        }else{
             $result = $this->vendoradvanceadjstmodel->insertVendorBillAdjustment($masterData,$billDetails);
        }
        if($result){
            echo(1);
        }  else {
            echo(0);
        }
    }
    
    /**
     * @getDetailsOfInvoice
     */
     public function getDetailsOfInvoice(){
        $session = sessiondata_method();
        $adjustmentId = $this->input->post('vendorpaymentId');

        if ($this->session->userdata('logged_in')) {
            
            $result['invoicedetails'] = $this->vendoradvanceadjstmodel->getDetail($adjustmentId);
            $page = 'vendorpayment/view_detai.php';
            $this->load->view($page, $result);
        }else{
              redirect('login', 'refresh');
        }
    }
    
    
    
    
}

