<?php

//we need to call PHP's session object to access it through CI
class generalvoucher extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('generalvouchermodel', '', TRUE);
        // $this->load->model('unitmastermodel', '', TRUE);
        $this->load->model('branchmastermodel', '', TRUE);
        $this->load->model('subledgermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
    }

    public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();

            $cmpny = $session['company'];
            $year = $session['yearid'];

            $result['voucherlisting'] = $this->generalvouchermodel->getVoucherList($cmpny, $year);
            $headercontent = '';
            $page = 'general_voucher/list_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
            /* echo  "<pre>";
              print_r( $result['voucherlisting']);
              echo  "</pre>"; */
        } else {
            redirect('login', 'refresh');
        }
    }

    public function addGeneralVoucher() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {
                $voucherMaterId = 0;
            } else {
                $voucherMaterId = $this->uri->segment(4);
            }
            $company = $session['company'];



            $headercontent['branchlist'] = $this->branchmastermodel->getBranchlist();
            $headercontent['groupMastername'] = $this->generalvouchermodel->getAccountByGroupMaster($company);
            $transType = "GV";
            $headercontent['accounthead'] = $this->generalvouchermodel->getAccountName($transType);
            $headercontent['subledger'] = $this->subledgermodel->subledgerlisting($session['company']);
            if ($voucherMaterId != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['voucherMasterId'] = $voucherMaterId;
                $headercontent['Voucherno'] = $this->generalvouchermodel->getVoucherNumber($voucherMaterId);
                $result['generalVouchermaster'] = $this->generalvouchermodel->getGeneralVoucherMasterData($voucherMaterId, $company);

                $result['generalVoucherDtl'] = $this->generalvouchermodel->getGeneralVoucherDetailData($voucherMaterId);
                $result['totalDbtAmt'] = $this->generalvouchermodel->TotalDebitAmt($voucherMaterId);
                $result['totalCreditAmt'] = $this->generalvouchermodel->TotalCreditAmt($voucherMaterId);
                $page = 'general_voucher/header_view';
            } else {
                $headercontent['mode'] = "Add";
                $headercontent['Voucherno'] =""; //$this->getvouchernumber();
                $result="";
                $page = 'general_voucher/header_view';
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

        if ($this->session->userdata('logged_in')) {

            $divNumber = $this->input->post('divSerialNumber');
            $acctag = $this->input->post('acctag');
            $amount = $this->input->post('amount');
            $transType = "GV";


            $result['accounthead'] = $this->generalvouchermodel->getAccountName($transType);
            $result['subledger'] = $this->subledgermodel->subledgerlisting($session['company']);


            /*  echo "<pre>";
              print_r($result['accounthead']);
              echo "</pre>"; */

            $result['divnumber'] = $divNumber;
            $result['acctag'] = $acctag;
            $result['amount'] = $amount;
            $page = 'general_voucher/groupvoucherDtl.php';
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

    public function insertData($searcharray) {
        $insertVoucherMaster = array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {

            $insertVoucherMaster['voucher_number'] = NULL;
            $insertVoucherMaster['voucher_date'] = date("Y-m-d", strtotime($searcharray['voucherDate']));
            $insertVoucherMaster['narration'] = $searcharray['narration'];
            $insertVoucherMaster['cheque_number'] = $searcharray['chqNo'];
            $insertVoucherMaster['cheque_date'] = ($searcharray['chqDate'] == "" ? NULL : date("Y-m-d", strtotime($searcharray['chqDate'])));
            $insertVoucherMaster['transaction_type'] = 'GV';
            $insertVoucherMaster['created_by'] = $session['user_id'];
            $insertVoucherMaster['company_id'] = $session['company'];
            $insertVoucherMaster['year_id'] = $session['yearid'];
            $insertVoucherMaster['serial_number'] = 0;
            $insertVoucherMaster['vouchertype'] = $searcharray['paymentmode'];
            $insertVoucherMaster['branchid'] = $searcharray['branchid'];
            $insertVoucherMaster['paid_to'] = $searcharray['paidto'];

            $insrt = $this->generalvouchermodel->insertgeneralVoucherMaster($insertVoucherMaster, $searcharray);

            /*if ($insrt) {
                echo 1;
            } else {
                echo 0;
            }
            exit(0);*/
            /*return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($insrt));*/
             header('Content-Type: application/json');
             echo json_encode($insrt);
             exit();
        } else {
            redirect('login', 'refresh');
        }
    }

    public function updateData($voucherMastId, $searcharray) {
        $updateGeneralVoucher = array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
            $updateGeneralVoucher['id'] = $voucherMastId;
            $updateGeneralVoucher['voucher_number'] = $searcharray['voucherNo'];
            $updateGeneralVoucher['voucher_date'] = date("Y-m-d", strtotime($searcharray['voucherDate']));
            $updateGeneralVoucher['narration'] = $searcharray['narration'];
            $updateGeneralVoucher['cheque_number'] = $searcharray['chqNo'];
            $updateGeneralVoucher['cheque_date'] = ($searcharray['chqDate'] == "" ? NULL : date("Y-m-d", strtotime($searcharray['chqDate'])));
            $updateGeneralVoucher['transaction_type'] = 'GV';
            $updateGeneralVoucher['created_by'] = $session['user_id'];
            $updateGeneralVoucher['company_id'] = $session['company'];
            $updateGeneralVoucher['year_id'] = $session['yearid'];
            $updateGeneralVoucher['serial_number'] = $searcharray['serialNo'];
            //  $updateGeneralVoucher['vouchertype']=$searcharray['paymentmode'];
            $updateGeneralVoucher['branchid'] = $searcharray['branchid'];
            $updateGeneralVoucher['paid_to'] = $searcharray['paidto'];
            /*  echo "<pre>";
              print_r($updateGeneralVoucher);
              echo "</pre>"; */

            $insrt = $this->generalvouchermodel->UpdategeneralVouchr($updateGeneralVoucher, $searcharray);

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

    private function generate_serial_no() {
        $session = sessiondata_method();
        $cid = $session['company'];
        $yid = $session['yearid'];
        $voucher_srl_no = $this->generalvouchermodel->getLastSerialNo($cid, $yid);
        $srl = $voucher_srl_no['serialNo'] + 1;
        //echo "serial No is".$srl;
        return $srl;
    }

    /*public function getvouchernumber() {
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
    }*/

    // get group name for disable checq no and checq date
    public function getAccountGroup() {
        $session = sessiondata_method();
        $companyId = $session['company'];

        $accId = $this->input->post('accountId');
        $grpname = $this->generalvouchermodel->getGroupNameByAccId($accId, $companyId);
        if ($grpname == "Cash Balance") {
            echo 1;
        } else {
            echo 0;
        }
    }

    function print_item() {

        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        if ($this->session->userdata('logged_in')) {
            if ($this->uri->segment(4) === FALSE) {

                $masterId = 0;
            } else {
                $masterId = $this->uri->segment(4);
            }
            $result['company'] = $this->companymodel->getCompanyNameById($companyId);
            $result['companylocation'] = $this->companymodel->getCompanyAddressById($companyId);
            $result['generalMasterData'] = $this->generalvouchermodel->getJournalMasterDataPdf($masterId);
            $result['generaldetailData'] = $this->generalvouchermodel->getJournalDetailPdf($masterId);

            $result['voucherNo'] = $this->generalvouchermodel->getVoucherNumber($masterId);
            $result['printDate'] = date('d-m-Y');

            /*   echo "<pre>";
              print_r($result['journalVouchrData']);
              echo "<pre>"; */

            foreach ($result['generalMasterData'] as $rows) {
                /* echo "<pre>";
                  print_r($rows['voucherMasterId']);
                  echo "<pre>"; */
            }

            // load library
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            ini_set('memory_limit', '256M');
            $pdf = new mPDF('utf-8', array(203.2, 152.4));



            /* -------------Company details---------- */
            $str = '<html>'
                    . '<head>'
                    . '<title>General Voucher Pdf</title>'
                    . '</head>'
                    . '<body>';
            $str = $pdf->WriteHTML($str);
            $lncount = 1;

            $str = '<table width="100%">'
                    . '<tr width="100%"><td align="center">'
                    . '<span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">' . $result['company'] . '<br>' . $result['companylocation']
                    . '</span></td></tr>'
                    . '</table>';
            $pdf->WriteHTML($str);

            /* -------------Volucher No And Date---------- */
            $str = '<div style="margin-top:40px;">'
                    . '<table width="100%" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;"><tr>'
                    . '<td align="left">' . 'Voucher No : ' . $result['voucherNo'] . '</td>'
                    . '<td align="right">' . 'Voucher Date : ' . $rows['VoucherDate'] . '</td>'
                    . '</tr></table>'
                    . '</div>';
            $pdf->WriteHTML($str);
            // $str='<div style="border:1px solid red;">';
            // $pdf->WriteHTML($str);

            $str = '<div style="margin-top:1px;">'
                    . '<table width="100%" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">'
                    . '<tr>'
                    . '<td style="font-family:Verdana, Geneva, sans-serif; font-size:12px;font-weight:bold" align="left" width="11%">Paid To</td>'
                    . '<td align="left" width="2%">:</td>'
                    . '<td align="left">' . $rows['paid_to'] . '</td>'
                    . '<tr>'
                    . '</table></div>';
            $pdf->WriteHTML($str);


            /* ---Details table-------- */
            $str = '<div style="margin-top:30px;"><table width="100%" style="font-family:Verdana, Geneva, sans-serif; font-size:11px; ">'
                    . '<tr>'
                    . '<th style="background:#D8D8D8;padding:1%;"></th>'
                    . '<th align="left" style="background:#D8D8D8;padding:1%;">Particulars</th>'
                    . '<th style="background:#D8D8D8;padding:1%;">Amount</th>'
                    . '</tr>';
            $pdf->WriteHTML($str);
            foreach ($result['generaldetailData'] as $value) {

                if ($lncount > 8) {
                    $pagebreak = $this->generalVoucherHeader($rows['cheque_number'], $rows['ChqDate'], $rows['narration'], $result['company'], $result['companylocation']);
                    $lncount = 1;
                } else {
                    $pagebreak = '';
                }

                $dbCr = $value['drCr'];
                if ($dbCr == "Y") {
                    $debitCreditValue = "Debit";
                }
                if ($dbCr == "N") {
                    $debitCreditValue = "Credit";
                }

                $str = '<tr>'
                        . '<td>' . $debitCreditValue . '</td>'
                        . '<td>' . $value['account_name'] . '</td>'
                        . '<td align="right">' . $value['voucher_amount'] . '</td>'
                        . '</tr>' . $pagebreak;
                $pdf->WriteHTML($str);
                $pdf->setFooter("Page {PAGENO} of {nb}");
                $lncount = $lncount + 1;
            }

            $str = '</table></div>';
            $pdf->WriteHTML($str);





            /* ---- Checque No And Checque Date ------ */
            $str = '<div style="margin-top:20px; border:1px solid #323232;">'
                    . '<table width="50%" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">'
                    . '<tr>'
                    . '<td width="35%">Checque No</td>'
                    . '<td>:</td>'
                    . '<td width="70%" align="left">' . $rows['cheque_number'] . '</td>'
                    . '</tr>'
                    . '<tr>'
                    . '<td>Checque  Date</td>'
                    . '<td>:</td>'
                    . '<td>' . $rows['ChqDate'] . '</td>'
                    . '</tr>'
                    . '<tr>'
                    . '<td>Narration</td>'
                    . '<td>:</td>'
                    . '<td>' . $rows['narration'] . '</td>'
                    . '</tr>'
                    . '</table></div>';
            $pdf->WriteHTML($str);

            $str = $this->generalvoucherFooter();
            $pdf->WriteHTML($str);

            $pdf->setFooter("Page {PAGENO} of {nb}");
            $str = '</body>'
                    . '</html>';
            $pdf->WriteHTML($str);
            $output = 'generalVoucher' . date('Y_m_d_H_i_s') . '_.pdf';
            $pdf->Output("$output", 'I');
            exit();
        } else {
            redirect('login', 'refresh');
        }
    }

    public function generalVoucherHeader($chkNo, $chqdt, $narat, $cmpny, $loc) {
        $header = '</table></div>'
                . '<div style="margin-top:20px; border:1px solid #323232;">'
                . '<table width="50%" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">'
                . '<tr>'
                . '<td width="35%">Checque No</td>'
                . '<td>:</td>'
                . '<td width="70%" align="left">' . $chkNo . '</td>'
                . '</tr>'
                . '<tr>'
                . '<td>Checque  Date</td>'
                . '<td>:</td>'
                . '<td>' . $chqdt . '</td>'
                . '</tr>'
                . '<tr>'
                . '<td>Narration</td>'
                . '<td>:</td>'
                . '<td>' . $narat . '</td>'
                . '</tr>'
                . '</table></div>'
                . '<div style="margin-top:40px;">'
                . '<table width="100%" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">'
                . '<tr>'
                . '<td align="left">Payee\'s Signature</td>'
                . '<td align="right">Accountant</td>'
                . '</tr>'
                . '</table></div>'
                . '<pagebreak /><table width="100%">'
                . '<tr width="100%"><td align="center">'
                . '<span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">' . $cmpny . '<br>' . $loc
                . '</span></td></tr>'
                . '</table>'
                . '<div style="margin-top:30px;"><table width="100%" style="font-family:Verdana, Geneva, sans-serif; font-size:11px; ">'
                . '<tr>'
                . '<th style="background:#D8D8D8;padding:1%;"></th>'
                . '<th align="left" style="background:#D8D8D8;padding:1%;">Particulars</th>'
                . '<th style="background:#D8D8D8;padding:1%;">Amount</th>'
                . '</tr>';
        return $header;
    }

    public function generalvoucherFooter() {

        $footer = '<div style="margin-top:40px;">'
                . '<table width="100%" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">'
                . '<tr>'
                . '<td align="left">Payee\'s Signature</td>'
                . '<td align="right">Accountant</td>'
                . '</tr>'
                . '</table></div>';
        return $footer;
    }

    public function delete() {
        $voucherMastId = $this->input->post('id');


        $result = $this->generalvouchermodel->deleteGeneralVoucher($voucherMastId);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }

}

?>