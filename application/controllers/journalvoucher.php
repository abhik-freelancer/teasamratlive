<?php

//we need to call PHP's session object to access it through CI
class journalvoucher extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('journalvouchermodel', '', TRUE);
        $this->load->model('generalvouchermodel', '', TRUE);
        $this->load->model('branchmastermodel', '', TRUE);
        $this->load->model('subledgermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
 }

    public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
            
            $cmpny = $session['company'];
            $year = $session['yearid'];
           
            $result['journalVouchrList']=$this->journalvouchermodel->getJournalVoucherList($cmpny,$year);
           
           
            $headercontent='';
            $page = 'journal_voucher/list_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        
           
        } else {
            redirect('login', 'refresh');
        }
    }

    
     public function addJournleVoucher(){
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {
                    $voucherMaterId = 0;
            } else {
                $voucherMaterId = $this->uri->segment(4);
            }
            
             
               $headercontent['branchlist'] = $this->branchmastermodel->getBranchlist();
           
               $transType="JV";
               $headercontent['accounthead'] = $this->generalvouchermodel->getAccountName($transType);
               $headercontent['subledger'] = $this->subledgermodel->subledgerlisting($session['company']);
              
            
               
                if ($voucherMaterId != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['voucherMasterId'] = $voucherMaterId;
                $headercontent['Voucherno']= $this->journalvouchermodel->getVoucherNumber($voucherMaterId);
                $result['journalVouchermaster'] = $this->journalvouchermodel->getjournalVoucherMasterData($voucherMaterId);
                $result['journalVoucherDtl'] = $this->journalvouchermodel->getJournalVoucherDetailData($voucherMaterId);
                $result['totalDbtAmt'] = $this->journalvouchermodel->TotalDebitAmt($voucherMaterId);
                $result['totalCreditAmt'] = $this->journalvouchermodel->TotalCreditAmt($voucherMaterId);
               
             $page = 'journal_voucher/header_view';
                
            } else {
                $headercontent['mode'] = "Add";
                 $headercontent['Voucherno'] ="";//$this->getvouchernumber();
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
            $result['subledger'] = $this->subledgermodel->subledgerlisting($session['company']);
            
                  
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
            
                $insertVoucherMaster['voucher_number']=NULL;//$this->getvouchernumber();
                $insertVoucherMaster['voucher_date']=date("Y-m-d", strtotime($searcharray['voucherDate']));
                $insertVoucherMaster['narration']=$searcharray['narration'];
                $insertVoucherMaster['cheque_number']=$searcharray['chqNo'];
                $insertVoucherMaster['cheque_date']=($searcharray['chqDate']=="" ? NULL : date("Y-m-d", strtotime($searcharray['chqDate'])));
                $insertVoucherMaster['transaction_type']='JV';
                $insertVoucherMaster['created_by']=$session['user_id'];
                $insertVoucherMaster['company_id']=$session['company'];
                $insertVoucherMaster['year_id']=$session['yearid'];
                $insertVoucherMaster['serial_number']=0;//$this->generate_serial_no();
               // $insertVoucherMaster['serial_number']=1;
                $insertVoucherMaster['vouchertype']=NULL;
                $insertVoucherMaster['branchid']=$searcharray['branchid'];
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
        $updateJournalVoucher = array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
               $updateJournalVoucher['id']=$voucherMastId;
               $updateJournalVoucher['voucher_number']=$searcharray['voucherNo'];
                $updateJournalVoucher['voucher_date']=date("Y-m-d", strtotime($searcharray['voucherDate']));
                $updateJournalVoucher['narration']=$searcharray['narration'];
                $updateJournalVoucher['cheque_number']=$searcharray['chqNo'];
                $updateJournalVoucher['cheque_date']=($searcharray['chqDate']=="" ? NULL : date("Y-m-d", strtotime($searcharray['chqDate'])));
                $updateJournalVoucher['transaction_type']='JV';
                $updateJournalVoucher['created_by']=$session['user_id'];
                $updateJournalVoucher['company_id']=$session['company'];
                $updateJournalVoucher['year_id']=$session['yearid'];
                $updateJournalVoucher['serial_number']=$searcharray['serialNo'];
                $updateJournalVoucher['vouchertype']='';
                $updateJournalVoucher['branchid']=$searcharray['branchid'];
                $updateJournalVoucher['paid_to']='';
          
            $insrt = $this->journalvouchermodel->UpdatejournalVouchr($updateJournalVoucher, $searcharray);

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
        
     function print_item(){
       
        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];
            if ($this->session->userdata('logged_in')) {
                if ($this->uri->segment(4) === FALSE) {

                $masterId = 0;
            } else {
                $masterId = $this->uri->segment(4);
            }
                $result['company']=  $this->companymodel->getCompanyNameById($companyId);
                $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
               
                $result['journalMasterData']=$this->journalvouchermodel->getJournalMasterDataPdf($masterId);
                $result['JournaldetailData']=$this->journalvouchermodel->getJournalDetailPdf($masterId);
                
                $result['voucherNo']= $this->journalvouchermodel->getVoucherNumber($masterId);
                $result['printDate']=date('d-m-Y');
                
                  /*   echo "<pre>";
                print_r($result['journalVouchrData']);
                echo "<pre>";*/
                
                foreach($result['journalMasterData'] as $rows){
                  /* echo "<pre>";
                    print_r($rows['voucherMasterId']);
                    echo "<pre>";*/
                } 
               
                // load library
                $this->load->library('pdf');
                $pdf = $this->pdf->load();
                ini_set('memory_limit', '256M'); 
              //  $pdf = new mPDF('utf-8', array(203.2,152.4));
                $pdf = new mPDF('utf-8', array(203.2,152.4));
               
                
                /* -------------Company details---------- */
               
                $str='<html>'
                     .'<head>'
                        .'<title>Journal Voucher Pdf</title>'
                      .'</head>'
                       .'<body>';
                $str= $pdf->WriteHTML($str); 
                 $lncount=1;
                $str='<table width="100%">'
               .'<tr width="100%"><td align="center">'
               .'<span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">'.$result['company'].'<br>'. $result['companylocation']
               .'</span></td></tr>'
               .'</table>';
                $pdf->WriteHTML($str); 
                
                 /* -------------Volucher No And Date---------- */
                $str='<div style="margin-top:40px;">'
                        .'<table width="100%" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;"><tr>'
                        . '<td align="left">'.'Voucher No : '.$result['voucherNo'].'</td>'
                        .'<td align="right">'.'Voucher Date : '.$rows['VoucherDate'].'</td>'
                        .'</tr></table>'
                        . '</div>';
                $pdf->WriteHTML($str); 
               // $str='<div style="border:1px solid red;">';
               // $pdf->WriteHTML($str);
                
               /* $str='<div style="margin-top:5px;">'
                       .'<table width="100%" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">'
                        .'<tr>'
                        .'<td>Paid To</td>'
                        .'<td></td>'
                        .'<tr>'
                     .'</table></div>';
                $pdf->WriteHTML($str); */
                
                
                /* ---Details table--------*/
                $str='<div style="margin-top:30px;"><table width="100%" style="font-family:Verdana, Geneva, sans-serif; font-size:11px; ">'
                     .'<tr>'
                      .'<th style="background:#D8D8D8;padding:1%;"></th>'
                      .'<th align="left" style="background:#D8D8D8;padding:1%;">Particulars</th>'
                      .'<th style="background:#D8D8D8;padding:1%;">Amount</th>'
                     .'</tr>';
                    $pdf->WriteHTML($str); 
                       foreach($result['JournaldetailData'] as $value){
                           
                           if($lncount>8){
                               $pagebreak=$this->journalVoucherHeader($rows['cheque_number'],$rows['ChqDate'],$rows['narration'],$result['company'],$result['companylocation']);
                               $lncount=1;
                        }else{
                            $pagebreak='';
                        }
                       
                           $dbCr=$value['drCr'];
                           if($dbCr=="Y"){
                               $debitCreditValue = "Debit";
                           }
                           if($dbCr=="N"){
                               $debitCreditValue = "Credit";
                           }
                           
                         $str='<tr>'
                                 .'<td>'.$debitCreditValue.'</td>'
                                 .'<td>'.$value['account_name'].'</td>'
                                 .'<td align="right">'.$value['voucher_amount'].'</td>'
                              .'</tr>'.$pagebreak;  
                          $pdf->WriteHTML($str); 
                           $pdf->setFooter("Page {PAGENO} of {nb}");
                          $lncount=$lncount+1;  
                          
                          
                       }
                        
                     $str='</table></div>'; 
                 $pdf->WriteHTML($str); 
                 
                 
                
                
                
            
                       
                       /*---- Checque No And Checque Date ------*/
                 $str='<div style="margin-top:20px; border:1px solid #323232;">'
                        .'<table width="50%" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">'
                         .'<tr>'
                         .'<td width="35%">Checque No</td>'
                         .'<td>:</td>'
                         .'<td width="70%" align="left">'.$rows['cheque_number'].'</td>'
                         .'</tr>'
                         .'<tr>'
                         .'<td>Checque  Date</td>'
                         .'<td>:</td>'
                         .'<td>'.$rows['ChqDate'].'</td>'
                         .'</tr>'
                         .'<tr>'
                         .'<td>Narration</td>'
                         .'<td>:</td>'
                         .'<td>'.$rows['narration'].'</td>'
                         .'</tr>'
                        .'</table></div>';
                 $pdf->WriteHTML($str);
                 
                 $str=$this->journalvoucherFooter();
                 $pdf->WriteHTML($str);

                $pdf->setFooter("Page {PAGENO} of {nb}");
                $str='</body>'
                      .'</html>';
                  $pdf->WriteHTML($str);
                $output = 'journalVoucher' . date('Y_m_d_H_i_s') . '_.pdf'; 
                $pdf->Output("$output", 'I');
                exit();
         }
         else {
            redirect('login', 'refresh');
        }
} 
     
public function journalVoucherHeader($chkNo,$chqdt,$narat,$cmpny,$loc){
    $header='</table></div>'
            .'<div style="margin-top:20px; border:1px solid #323232;">'
                        .'<table width="50%" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">'
                         .'<tr>'
                         .'<td width="35%">Checque No</td>'
                         .'<td>:</td>'
                         .'<td width="70%" align="left">'.$chkNo.'</td>'
                         .'</tr>'
                         .'<tr>'
                         .'<td>Checque  Date</td>'
                         .'<td>:</td>'
                         .'<td>'.$chqdt.'</td>'
                         .'</tr>'
                         .'<tr>'
                         .'<td>Narration</td>'
                         .'<td>:</td>'
                         .'<td>'.$narat.'</td>'
                         .'</tr>'
                        .'</table></div>'
            .'<div style="margin-top:40px;">'
                         .'<table width="100%" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">'
                         .'<tr>'
                         .'<td align="left">Payee\'s Signature</td>'
                         .'<td align="right">Accountant</td>'
                         .'</tr>'
                         .'</table></div>'
            . '<pagebreak /><table width="100%">'
               .'<tr width="100%"><td align="center">'
               .'<span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">'.$cmpny.'<br>'. $loc
               .'</span></td></tr>'
               .'</table>'
               .'<div style="margin-top:30px;"><table width="100%" style="font-family:Verdana, Geneva, sans-serif; font-size:11px; ">'
                     .'<tr>'
                      .'<th style="background:#D8D8D8;padding:1%;"></th>'
                      .'<th align="left" style="background:#D8D8D8;padding:1%;">Particulars</th>'
                      .'<th style="background:#D8D8D8;padding:1%;">Amount</th>'
                     .'</tr>';
    return $header;
}
   
public function journalvoucherFooter(){
    
    $footer = '<div style="margin-top:40px;">'
                         .'<table width="100%" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">'
                         .'<tr>'
                         .'<td align="left">Payee\'s Signature</td>'
                         .'<td align="right">Accountant</td>'
                         .'</tr>'
                         .'</table></div>';
    return $footer;
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