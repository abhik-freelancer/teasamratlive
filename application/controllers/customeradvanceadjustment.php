<?php

class customeradvanceadjustment extends CI_Controller {
 public function __construct() {
        parent::__construct();
        $this->load->model('customermastermodel', '', TRUE);
        $this->load->model('generalvouchermodel', '', TRUE);
        $this->load->model('customeradvancemodel', '', TRUE);
        $this->load->model('customeradvanceadjstmentmodel', '', TRUE);
        
    }
     public function index(){
         $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            $result = $this->customeradvanceadjstmentmodel->getAdjustmentList($session['company'],$session['yearid']);
           // $result ="";
            $page = 'customer_advance_adjustment/list_view';
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
                 $customerAdvanceAdjustment = 0;
            } else {
                $customerAdvanceAdjustment = $this->uri->segment(4);
            }
            $headercontent['customerAccList'] = $this->customermastermodel->getCustomerAccountId($session['company']);  
            
            if($customerAdvanceAdjustment==0){
                 $headercontent['mode'] = "Add";
                 $page = 'customer_advance_adjustment/addEdit';
                 $result="";
            }  else {
                 $page = 'customer_advance_adjustment/addEdit';
                 $result["customeradjustment"] = $this->customeradvanceadjstmentmodel->getCustomerAdjMstById($customerAdvanceAdjustment);
                 $result["customerAdjstDtl"]=  $this->customeradvanceadjstmentmodel->getCustAdjstDtl($customerAdvanceAdjustment);
                 $result['advancevoucher'] = $this->customeradvanceadjstmentmodel->getCustomerAdvanceVoucher($result["customeradjustment"]["customerAccId"]);
                 $result["remaining"] = $this->customeradvanceadjstmentmodel->getAdvanceAmountByAdvanceId($result["customeradjustment"]["advanceMasterId"]);
                 $result["invoiceList"] = $this->customeradvanceadjstmentmodel->getSaleInvoiceByCustomer($result["customeradjustment"]["customerAccId"]);
                
               
                
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
                 $customerAdvanceAdjustment = 0;
            } else {
                $customerAdvanceAdjustment = $this->uri->segment(4);
            }
            if($customerAdvanceAdjustment!=0){
                $rslt = $this->customeradvanceadjstmentmodel->delete($customerAdvanceAdjustment);
            }
            
                redirect('customeradvanceadjustment', 'refresh');
            
                
            
            
         }  else {
              redirect('login', 'refresh');
         }
    }
    
     public function getAdvanceVoucher(){
        $customerAccId = $this->input->post('customerAccId');
        $session = sessiondata_method();
        
        if ($this->session->userdata('logged_in')) {

            $result['advancevoucher'] = $this->customeradvanceadjstmentmodel->getCustomerAdvanceVoucher($customerAccId);
            $page = 'customer_advance_adjustment/advancevoucherlist.php';
            $this->load->view($page, $result);
        } else {
            redirect('login', 'refresh');
        }
    }
    
     public function  addCustomerBill(){
        $customerAccId = $this->input->post('customerAccId');
        $session = sessiondata_method();
        
         if ($this->session->userdata('logged_in')) {

            $result['invoices'] = $this->customeradvanceadjstmentmodel->getSaleInvoiceByCustomer($customerAccId);
            $page = 'customer_advance_adjustment/detail.php';
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

            $advanceAmount = $this->customeradvanceadjstmentmodel->getAdvanceAmountByAdvanceId($advanceId);
            echo json_encode(array('advamount'=>$advanceAmount));
            exit();
            
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
    public function getUnpaidtBillAmount(){
        $customerAdjustmentId = $this->input->post('customerAdjustmentId');
        $customerBillMasterId = $this->input->post('customerBillMasterId');
        $session = sessiondata_method();
        $companyId = $session['company'];
       
        if ($this->session->userdata('logged_in')) {

            $unpaidAmount = $this->customeradvanceadjstmentmodel->getCustomerUnpaidBill($customerBillMasterId,$companyId,$customerAdjustmentId);
            echo json_encode(array('unpaidAmt'=>$unpaidAmount));
            exit();
            
            
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
     public function getBillDateAndOthers(){
        
        $customerBillMasterId=  $this->input->post('customerBillMasterId');
        
        $session = sessiondata_method();
        $companyId = $session['company'];
       if ($this->session->userdata('logged_in')) {
            $result = $this->customeradvanceadjstmentmodel->getBillDateAndOthers($customerBillMasterId);
            echo json_encode($result);
            exit();
            
            
        } else {
            redirect('login', 'refresh');
        }
        
    }
    
    
     public function  SaveAdjustment(){
         
        $masterData["AdjustmentId"]=  $this->input->post('adjustmentId');
        $masterData["adjustmentrefno"] = $this->input->post('refno');
        $masterData["dateofadjustment"] = date("Y-m-d", strtotime($this->input->post('dateofadjstment')));
        $masterData["customeraccid"]=$this->input->post('customerAccountId');
        $masterData["advanceid"]= $this->input->post('advanceVoucherId');
        $masterData["totalamountadjusted"] = $this->input->post('totalAdjustment');
        
        $details = $this->input->post('details');
        $billDetails;
        $i=0;
        foreach ($details as  $value) {
           foreach ($value as $data) {
                 
               $billDetails[]=array(
                                    'customerBillMasterId'=>$data['customerBillMasterId'],
                                    'adjustedAmount'   => $data['adjustedAmount']
                   );
               
               //echo($value[$i]['adjustedAmount']);
                $i=i+1;
            }
        }
        //print_r($billDetails);
        
        
        if($masterData["AdjustmentId"]!=0){
            $result = $this->customeradvanceadjstmentmodel->updateCustomerBillAdjustment($masterData,$billDetails);
        }else{
             $result = $this->customeradvanceadjstmentmodel->insertCustomerBillAdjustment($masterData,$billDetails);
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
        $adjustmentId = $this->input->post('custpaymentId');

        if ($this->session->userdata('logged_in')) {
            
            $result['invoicedetails'] = $this->customeradvanceadjstmentmodel->getDetail($adjustmentId);
            
            
            $page = 'customer_advance_adjustment/view_detail.php';
            $this->load->view($page, $result);
        }else{
              redirect('login', 'refresh');
        }
    }
    
    
    
    
}
?>