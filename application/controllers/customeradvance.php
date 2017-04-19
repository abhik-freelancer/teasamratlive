<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of customeradvance
 *
 * @author avbhik
 */
class customeradvance extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('customermastermodel', '', TRUE);
        $this->load->model('generalvouchermodel', '', TRUE);
        $this->load->model('customeradvancemodel','',TRUE);
    } 
    public function index(){
        //to do;
        $session = sessiondata_method();
        if($this->session->userdata('logged_in')){
            $result = $this->customeradvancemodel->getCustomerAdvanceList($session['company'],$session['yearid']);
            $page = 'customer_advance/list_view';
            $header = '';
            $headercontent="";
            createbody_method($result, $page, $header, $session, $headercontent);
            
        }else{
            redirect('login', 'refresh');
            
        }
        
        
    }
    
    public function addEdit(){
         $session = sessiondata_method();
        
         
         if ($this->session->userdata('logged_in')) {
            
             if ($this->uri->segment(4) === FALSE) {
                
                $customeradvance = 0;
            } else {
                $customeradvance = $this->uri->segment(4);
            }
        
        $headercontent['customerAccList'] = $this->customermastermodel->getCustomerAccountId($session['company']);   
        $headercontent['CashOrBank'] = $this->generalvouchermodel->getAccountByGroupMaster($session['company']);
        
        
        if($customeradvance==0){
            $headercontent['mode'] = "Add";
            $page = 'customer_advance/addeditcustomeradvance';
            $result="";
            
        }  else {
            $headercontent['mode'] = "Edit";
            $result['customeradvance']=  $this->customeradvancemodel->getCustomerAdvanceById($customeradvance);
            $page = 'customer_advance/addeditcustomeradvance';
           
        }
        
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
            
        } else {
            redirect('login', 'refresh');
        }
    }
    
    public function saveCustomerAdvance(){
        
        
        $modeOfOpeartion = $this->input->post('mode');
        $advanceId = $this->input->post('customeradvanceId');
        $formData = $this->input->post('formDatas');
        parse_str($formData,$searcharray);
        
        if($modeOfOpeartion=="Add" && $advanceId==""){
            $ret=$this->insertCustomerAdvance($searcharray);
            if($ret){
                echo(1);
                exit;
            }  else {
                echo(0);
                exit;
            }
        }else{
            $ret=  $this->updateCustomerAdvance($searcharray);
            if($ret){
                echo(1);
                exit;
            }  else {
                echo(0);
                exit;
            }
        }
    }
    
     public function updateCustomerAdvance($searcharray){
        $vendorMasterAdvance = array();
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
            
             $customerAdvance["advanceId"]=$searcharray["customeradvanceId"];
             $customerAdvance["dateofadvance"]=$searcharray["dateofadvance"];
             $customerAdvance["voucherid"] = $searcharray["voucherid"];
             $customerAdvance["advanceamount"] = $searcharray["paymentamount"];
             $customerAdvance["cashorbank"]=$searcharray["cashorbank"];
             $customerAdvance["cheqno"] = $searcharray["cheqno"];
             $customerAdvance["cheqdt"] = $searcharray["cheqdt"];
             $customerAdvance["customeraccountid"]=$searcharray["customeradvance"];
             $customerAdvance["narration"] = $searcharray["narration"];
             $customerAdvance["userId"]=$session["user_id"];
             $insrt=  $this->customeradvancemodel->updateCustomerAdvance($customerAdvance);
          
             
             
             if($insrt){
                 return TRUE;
             }else{
                 return FALSE;
             }
             
         }else{
              redirect('login', 'refresh');
         }
    }
    
    public function insertCustomerAdvance($searcharray){
        $customerAdvance = array();
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
            
             $customerAdvance["dateofadvance"]=$searcharray["dateofadvance"];
             $customerAdvance["voucherid"] = NULL;
             $customerAdvance["advanceamount"] = $searcharray["paymentamount"];
             $customerAdvance["cashorbank"]=$searcharray["cashorbank"];
             $customerAdvance["cheqno"] = $searcharray["cheqno"];
             $customerAdvance["cheqdt"] = $searcharray["cheqdt"];
             $customerAdvance["customeraccountid"]=$searcharray["customeradvance"];
             $customerAdvance["narration"] = $searcharray["narration"];
             $customerAdvance["voucherNumber"] =NULL; //$this->getvouchernumber();
             $customerAdvance["voucherSerial"] =NULL; //$this->generate_serial_no();
             $customerAdvance["lastSrNo"]=NULL;  //$this->getSerialNumber();
             $customerAdvance["companyid"] = $session['company'];
             $customerAdvance["yearid"] = $session["yearid"];
             $customerAdvance["userId"]=$session["user_id"];
            
             
             
             $insrt =  $this->customeradvancemodel->insertCustomerAdvance($customerAdvance);
          
             
             
             if($insrt){
                 return TRUE;
             }else{
                 return FALSE;
             }
             
         }else{
              redirect('login', 'refresh');
         }
        
    }
    
    public function getvouchernumber(){
        $session = sessiondata_method();
          $cid=$session['company'];
          $yid=$session['yearid'];
		$voucher_srl_no=$this->generalvouchermodel->getSerailvoucherNo($cid,$yid);
		$srl=  intval($voucher_srl_no)+1;
                $padding='00000';
                if($srl>=10 && $srl<100 ){
                    $padding='00000';
                }elseif ($srl>=100 && $srl<1000) {
                    $padding='000';
                }elseif ($srl>=1000 && $srl<10000) {
                    $padding='00';
                }elseif ($srl>=10000 && $srl<10000) {
                    $padding='0';
                }elseif ($srl>=100000 && $srl<1000000) {
                    $padding='';
                }
                $voucherNo=$padding.$srl."/".substr($session['startyear'],2,2)."-".substr($session['endyear'],2,2);
       
                //echo "serial No is".$srl;
        return $voucherNo;
      
        }
    public function getSerialNumber(){
        
        $session = sessiondata_method();
          $cid=$session['company'];
          $yid=$session['yearid'];
		$voucher_srl_no=$this->generalvouchermodel->getSerailvoucherNo($cid,$yid);
		$srl=$voucher_srl_no+1;
        return $srl;        
    }    
        
        private function generate_serial_no()
	{
        $session = sessiondata_method();
            $cid=$session['company'];
            $yid=$session['yearid'];
                  $voucher_srl_no=$this->generalvouchermodel->getLastSerialNo($cid,$yid);
                  $srl=$voucher_srl_no['serialNo']+1;
                  //echo "serial No is".$srl;
          return $srl;
	}
    
    
}
