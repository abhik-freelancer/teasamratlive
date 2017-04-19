<?php

//we need to call PHP's session object to access it through CI
class journalvoucher extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('journalvouchermodel', '', TRUE);
        $this->load->model('generalvouchermodel', '', TRUE);
        $this->load->model('unitmastermodel', '', TRUE);
        $this->load->model('subledgermodel', '', TRUE);
 }

    public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
           
            $result['contraVouchrList']=$this->journalvouchermodel->getJournalVoucherList();
           
           
            $headercontent='';
            $page = 'journal_voucher/list_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
         /* echo  "<pre>";
            print_r( $result['voucherlisting']);
          echo  "</pre>";*/
           
        } else {
            redirect('login', 'refresh');
        }
    }

    
     public function addJournleVoucher() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {
                    $voucherMaterId = 0;
            } else {
                $voucherMaterId = $this->uri->segment(4);
            }
            
               $headercontent['unitlist'] = $this->unitmastermodel->unitlisting();
             //  $headercontent['groupMastername'] = $this->generalvouchermodel->getAccountByGroupMaster();
               $transType="JV";
               $headercontent['accounthead'] = $this->generalvouchermodel->getAccountName($transType);
               $headercontent['subledger'] = $this->subledgermodel->subledgerlisting();
              
              // $headercontent['Voucherno'] =10;
               /*echo "<pre>";
              print_r( $headercontent['groupMastername']);
              echo "<pre>";*/
               
                if ($voucherMaterId != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['voucherMasterId'] = $voucherMaterId;
                $headercontent['Voucherno']= $this->journalvouchermodel->getVoucherNumber($voucherMaterId);
                $result['journalVouchermaster'] = $this->journalvouchermodel->getcontraVoucherMasterData($voucherMaterId);
                $result['journalVoucherDtl'] = $this->journalvouchermodel->getContraVoucherDetailData($voucherMaterId);
                $result['totalDbtAmt'] = $this->journalvouchermodel->TotalDebitAmt($voucherMaterId);
                $result['totalCreditAmt'] = $this->journalvouchermodel->TotalCreditAmt($voucherMaterId);
                
               
             /*   echo "<pre>";
                    print_r($result['contraVoucherDtl']);
                echo "</pre>";*/
            
                 
             $page = 'journal_voucher/header_view';
                
            } else {
                $headercontent['mode'] = "Add";
                 $headercontent['Voucherno'] =$this->getvouchernumber();
                $page = 'journal_voucher/header_view';
            }


            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
     public function createDetails() {

        $session = sessiondata_method();
        $divNumber = $this->input->post('divSerialNumber');
        if ($this->session->userdata('logged_in')) {
            
            $transType="JV";
            $result['accounthead'] = $this->generalvouchermodel->getAccountName($transType);
            $result['subledger'] = $this->subledgermodel->subledgerlisting();
            
            
          /*  echo "<pre>";
                print_r($result['accounthead']);
            echo "</pre>";*/
            
            $result['divnumber'] = $divNumber;
            $page = 'contra_voucher/contraVoucherDtl.php';
            $this->load->view($page, $result);
        } else {
            redirect('login', 'refresh');
        }
    }
    
      public function saveData() {
        $modeOfOpeartion = $this->input->post('mode');
        $voucherMastId = $this->input->post('voucherMasterId');
        $formData = $this->input->post('formDatas');

        parse_str($formData, $searcharray);
        
     /*   echo "<pre>";
            print_r($searcharray);
        echo "</pre>";*/

        if ($modeOfOpeartion == "Add" && $voucherMastId == "") {
            $this->insertData($searcharray);
        } else {
            $this->updateData($voucherMastId, $searcharray);
        }
    }
    
     public function insertData($searcharray){
        $insertVoucherMaster = array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
              /*  echo "<pre>";
                    print_r($searcharray);
                echo "</pre>";*/
                
               // $insertVoucherMaster['voucher_number']=10;
                $insertVoucherMaster['voucher_number']=$this->getvouchernumber();
                $insertVoucherMaster['voucher_date']=date("Y-m-d", strtotime($searcharray['voucherDate']));
                $insertVoucherMaster['narration']=$searcharray['narration'];
                $insertVoucherMaster['cheque_number']=$searcharray['chqNo'];
                $insertVoucherMaster['cheque_date']=($searcharray['chqDate']=="" ? NULL : date("Y-m-d", strtotime($searcharray['chqDate'])));
                $insertVoucherMaster['transaction_type']='JV';
                $insertVoucherMaster['created_by']=$session['user_id'];
                $insertVoucherMaster['company_id']=$session['company'];
                $insertVoucherMaster['year_id']=$session['yearid'];
                $insertVoucherMaster['serial_number']=$this->generate_serial_no();
               // $insertVoucherMaster['serial_number']=1;
                $insertVoucherMaster['vouchertype']=NULL;
                $insertVoucherMaster['unitid']=$searcharray['unitid'];
                $insertVoucherMaster['paid_to']=NULL;
                
            $insrt = $this->journalvouchermodel->insertJournalVoucherMaster($insertVoucherMaster,$searcharray);

            if ($insrt) {
                echo 1;
            } else {
                echo 0;
            }
            exit(0);
        }
        
        else {
            redirect('login', 'refresh');
        }
    }
    
      public function updateData($voucherMastId, $searcharray) {
        $updateGeneralVoucher = array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
               $updateGeneralVoucher['id']=$voucherMastId;
               $updateGeneralVoucher['voucher_number']=$searcharray['voucherNo'];
                $updateGeneralVoucher['voucher_date']=date("Y-m-d", strtotime($searcharray['voucherDate']));
                $updateGeneralVoucher['narration']=$searcharray['narration'];
                $updateGeneralVoucher['cheque_number']=$searcharray['chqNo'];
                $updateGeneralVoucher['cheque_date']=($searcharray['chqDate']=="" ? NULL : date("Y-m-d", strtotime($searcharray['chqDate'])));
                $updateGeneralVoucher['transaction_type']='JV';
                $updateGeneralVoucher['created_by']=$session['user_id'];
                $updateGeneralVoucher['company_id']=$session['company'];
                $updateGeneralVoucher['year_id']=$session['yearid'];
                $updateGeneralVoucher['serial_number']=$searcharray['serialNo'];
                $updateGeneralVoucher['vouchertype']='';
                $updateGeneralVoucher['unitid']=$searcharray['unitid'];
                $updateGeneralVoucher['paid_to']='';
                      /*  echo "<pre>";
                        print_r($updateGeneralVoucher);
                        echo "</pre>";*/

            $insrt = $this->journalvouchermodel->UpdategeneralVouchr($updateGeneralVoucher, $searcharray);

            if ($insrt) {
                echo '1';
            } else {
                echo '0';
            }
            exit(0);
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
          private function generate_serial_no()
	{
      $session = sessiondata_method();
          $cid=$session['company'];
          $yid=$session['yearid'];
		$voucher_srl_no=$this->journalvouchermodel->getLastSerialNo($cid,$yid);
		$srl=$voucher_srl_no['serialNo']+1;
                //echo "serial No is".$srl;
        return $srl;
	}
        
     public function getvouchernumber(){
        $session = sessiondata_method();
          $cid=$session['company'];
          $yid=$session['yearid'];
		$voucher_srl_no=$this->generalvouchermodel->getSerailvoucherNo($cid,$yid);
		$srl=$voucher_srl_no+1;
                $voucherNo="0000".$srl."/".substr($session['startyear'],2,2)."-".substr($session['endyear'],2,2);
       
                //echo "serial No is".$srl;
        return $voucherNo;
      
        }
        
 public function delete()
	{
            $voucherMastId = $this->input->post('id');
           // $res= $this->openinginvoicemodel->getPurInvDtlId($id);
                
          
             $result = $this->journalvouchermodel->deleteContraVoucher($voucherMastId);
                if($result){
                    echo 1;
                }
                else{
                    echo 0;
                }
	}       
 
}
?>