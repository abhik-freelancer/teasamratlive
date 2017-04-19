<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class vendoradvance extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendormastermodel', '', TRUE);
        $this->load->model('generalvouchermodel', '', TRUE);
        $this->load->model('vendoradvancemodel','',TRUE);
    }

    public function index() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            $result = $this->vendoradvancemodel->getVendorAdvanceList($session['company'],$session['yearid']);
            $page = 'vendoradvance/list_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
       
      //  $this->addTaxInvoice();
    }
    public function addEditAdvance(){
       
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            
             if ($this->uri->segment(4) === FALSE) {
                
                $vendorAdvanceId = 0;
            } else {
                $vendorAdvanceId = $this->uri->segment(4);
            }
        $headercontent['vendors'] = $this->vendormastermodel->getVendorList();   
        $headercontent['CashOrBank'] = $this->generalvouchermodel->getAccountByGroupMaster($session['company']);
        
        if($vendorAdvanceId==0){
            $headercontent['mode'] = "Add";
            $page = 'vendoradvance/addEditAdvance';
            $result="";
            
        }  else {
            $headercontent['mode'] = "Edit";
            $result['vendoradvancement']=  $this->vendoradvancemodel->getAdvanceById($vendorAdvanceId);
            $page = 'vendoradvance/addEditAdvance';
           
        }
        
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
            
        } else {
            redirect('login', 'refresh');
        }
    }
    
    public function SaveVendorAdvance(){
        $modeOfOpeartion = $this->input->post('mode');
        $advanceId = $this->input->post('vendoradvanceId');
        $formData = $this->input->post('formDatas');
        parse_str($formData,$searcharray);
        
        if($modeOfOpeartion=="Add" && $advanceId==""){
            $ret=$this->insertVendorAdvance($searcharray);
            if($ret){
                echo(1);
                exit;
            }  else {
                echo(0);
                exit;
            }
        }else{
            $ret=  $this->updateVendorAdvance($searcharray);
            if($ret){
                echo(1);
                exit;
            }  else {
                echo(0);
                exit;
            }
        }
        
        
    }
    
    public function updateVendorAdvance($searcharray){
        $vendorMasterAdvance = array();
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
            
             $vendorMasterAdvance["advanceId"]=$searcharray["vendoradvanceId"];
             $vendorMasterAdvance["advanceDate"]=$searcharray["dateofadvance"];
             $vendorMasterAdvance["voucherId"] = $searcharray["voucherid"];
             $vendorMasterAdvance["advanceAmount"] = $searcharray["paymentamount"];
             $vendorMasterAdvance["cashorbank"]=$searcharray["cashorbank"];
             $vendorMasterAdvance["cheqno"] = $searcharray["cheqno"];
             $vendorMasterAdvance["cheqdt"] = $searcharray["cheqdt"];
             $vendorMasterAdvance["vendoradvance"]=$searcharray["vendoradvance"];
             $vendorMasterAdvance["narration"] = $searcharray["narration"];
             $insrt=  $this->vendoradvancemodel->UpdateVendorAdvance($vendorMasterAdvance);
          
             
             
             if($insrt){
                 return TRUE;
             }else{
                 return FALSE;
             }
             
         }else{
              redirect('login', 'refresh');
         }
    }
    
    
    public function insertVendorAdvance($searcharray){
        $vendorMasterAdvance = array();
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
            
             $vendorMasterAdvance["advanceDate"]=$searcharray["dateofadvance"];
             $vendorMasterAdvance["voucherId"] = NULL;
             $vendorMasterAdvance["advanceAmount"] = $searcharray["paymentamount"];
             $vendorMasterAdvance["cashorbank"]=$searcharray["cashorbank"];
             $vendorMasterAdvance["cheqno"] = $searcharray["cheqno"];
             $vendorMasterAdvance["cheqdt"] = $searcharray["cheqdt"];
             $vendorMasterAdvance["vendoradvance"]=$searcharray["vendoradvance"];
             $vendorMasterAdvance["narration"] = $searcharray["narration"];
             $vendorMasterAdvance["voucherNumber"] =NULL; //$this->getvouchernumber();
             $vendorMasterAdvance["voucherSerial"] =0; //$this->generate_serial_no();
             $vendorMasterAdvance["lastSrNo"]= 0; //$this->getSerialNumber();
             $vendorMasterAdvance["companyId"] = $session['company'];
             $vendorMasterAdvance["yearId"] = $session["yearid"];
             $vendorMasterAdvance["userId"]=$session["user_id"];
             
             
             $insrt=  $this->vendoradvancemodel->insertVendorAdvance($vendorMasterAdvance);
          
             
             
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
