<?php

//we need to call PHP's session object to access it through CI
class GSTtaxinvoice extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('productmodel', '', TRUE);
        $this->load->model('packetmodel', '', TRUE);
        $this->load->model('gsttaxinvoicemodel', '', TRUE);
        $this->load->model('customermastermodel', '', TRUE);
	$this->load->model('companymodel', '', TRUE);
    }

    public function index() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {


            $result = $this->gsttaxinvoicemodel->getSaleBillList($session['company'],$session['yearid']);


            $page = 'GSTtaxinvoice/list_view';
            $header = '';
            $headercontent="";
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
      //  $this->addTaxInvoice();
    }

    /**
     * @method addTaxInvoice
     * @date 04/11/2015
     * */
    public function addTaxInvoice() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {

                $salebillno = 0;
            } else {
                $salebillno = $this->uri->segment(4);
            }
            //echo($salebillno);
            $companyId=$session['company'];
            $yearId=$session['yearid'];
            $headercontent['finalproduct'] = $this->gsttaxinvoicemodel->getPacketProduct();
            $headercontent['customer'] = $this->gsttaxinvoicemodel->getCustomerList();
            /*
            $headercontent['cstRate'] = $this->gsttaxinvoicemodel->getCurrentcstrate($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');
            $headercontent['vatpercentage'] = $this->gsttaxinvoicemodel->getCurrentvatrate($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');
            */
            /*$headercontent['cstRate'] = $this->gsttaxinvoicemodel->getCurrentcstrate();
            $headercontent['vatpercentage'] = $this->gsttaxinvoicemodel->getCurrentvatrate();*/
            
            //gst rate
            $headercontent['cgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='CGST',$usedfor='O');
            $headercontent['sgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='SGST',$usedfor='O');
            $headercontent['igstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='IGST',$usedfor='O');
            
            
            
            
            $headercontent['lastSalebillNo'] = $this->gsttaxinvoicemodel->getlastSaleBillNo($session['company'],$session['yearid']);
            
        

            if ($salebillno != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['salebillno'] = $salebillno;
                $result['taxInvoiceMaster'] = $this->gsttaxinvoicemodel->getSaleBillMasterData($salebillno);
                $result['taxInvoiceDetail'] = $this->gsttaxinvoicemodel->getSaleBillDetailData($salebillno);
                $page = 'GSTtaxinvoice/taxinvoice_add';
            } else {
                $headercontent['mode'] = "Add";
                $headercontent['salebillno']="";
                $page = 'GSTtaxinvoice/taxinvoice_add';
                $result['taxInvoiceMaster']=NULL;
                $result['taxInvoiceDetail']=NULL;
            }


            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }

    /**
     * @method createDetails
     * @param null $name Description
     * @return DetailshtmlPage
     */
    public function createDetails() {

        $session = sessiondata_method();
        $divNumber = $this->input->post('divSerialNumber');
        if ($this->session->userdata('logged_in')) {
            $companyId = $session['company'];
            $yearId = $session['yearid'];
            $result['finalproduct'] = $this->gsttaxinvoicemodel->getPacketProduct();
            $result['cgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='CGST',$usedfor='O');
            $result['sgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='SGST',$usedfor='O');
            $result['igstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='IGST',$usedfor='O');
            

            $result['divnumber'] = $divNumber;
            $page = 'GSTtaxinvoice/taxinvoicedetail.php';
            $this->load->view($page, $result);
        } else {
            redirect('login', 'refresh');
        }
    }
    public function getAmount(){
         if ($this->session->userdata('logged_in')) {
             $taxableamount = $this->input->post("taxableamount");
             $id = $this->input->post("gstId"); 
             $type= $this->input->post("type");
             
             $rate = $this->gsttaxinvoicemodel->getRate($id,$type);
             $gstAmount = (($taxableamount * $rate) /100);
             
             $response = array("amt"=>$gstAmount,"type"=>$type);
           
             
             header('Content-Type: application/json');
             echo json_encode($response);
             exit;
            
         }  else {
             redirect('login', 'refresh');
         }
    }

    public function saveData() {
        $modeOfOpeartion = $this->input->post('mode');
        $taxinvoiceId = $this->input->post('salebillid');
        $formData = $this->input->post('formDatas');

        parse_str($formData, $searcharray);

        if ($modeOfOpeartion == "Add" && $taxinvoiceId == "") {
            $this->insertData($searcharray);
        } else {
            $this->updateData($taxinvoiceId, $searcharray);
        }
    }

    /**
     * @method insertData
     * @param type $searcharray
     */
    public function insertData($searcharray) {
       // $saleBillMaster = array();
        $voucherMast = array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
			
	
                  
             $voucherMast['voucher_number'] =NULL;         
             $voucherMast['voucher_date'] = date("Y-m-d", strtotime($searcharray['saleBillDate']));
             $voucherMast['narration'] = "Sale against Invoice No ".$searcharray['txtSaleBillNo']." Date ".date("Y-m-d", strtotime($searcharray['saleBillDate']));         
             $voucherMast['cheque_number'] =NULL;         
             $voucherMast['cheque_date'] = NULL;         
             $voucherMast['transaction_type'] = 'SL';         
             $voucherMast['created_by'] = $session['user_id'];         
             $voucherMast['company_id'] = $session['company'];         
             $voucherMast['year_id'] =  $session['yearid']; 
             $voucherMast['serial_number'] = 1;
             $voucherMast['vouchertype'] =NULL;         
             $voucherMast['branchid'] = NULL;         
             $voucherMast['paid_to'] = NULL;         
                        
                        
           
            $insrt = $this->gsttaxinvoicemodel->insertData($voucherMast, $searcharray ,$sale_srl_no);

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
    
    
    /*@method getCreditDaysFromCustomer
     *@date 16-05-2016
     *@by Mithilesh
     */
    public function getCreditDaysFromCustomer(){
        $custId = $this->input->post('customerId');
        $creditDays = $this->gsttaxinvoicemodel->getCreditDays($custId);
       // return $creditDays;
         echo json_encode(
                array(
                    "credit_days"=>$creditDays['credit_days']
                    
                )
                );
    }
    
    /*@method checkExistingSaleBillNo
     *@date 17-05-2016
     *@by Mithilesh
     */
    public function checkExistingSaleBillNo(){
       $session = sessiondata_method();
       
       $compny = $session['company'];
       $yearid = $session['yearid'];
       
        $salebillno = $this->input->post('SaleBillNo');
        $result = $this->gsttaxinvoicemodel->checkExistingSalebillNumb($salebillno,$compny,$yearid);
         if($result==TRUE){
             echo "1";
         }
         else{
             echo "0";
         }
    }


    
    
    

	private function generate_serial_no($cid,$yid)
	{
		$sale_srl=$this->gsttaxinvoicemodel->get_last_srl_no($cid,$yid);
		$srl=$sale_srl['saleBilllastsrlno']+1;
        return $srl;
	}
	
	private function get_sale_Bill_no($srl,$cid)
	{
		$session = sessiondata_method();
		$bill_tag_obj=$this->companymodel->get_bill_tag($cid);
		$bill_tag=$bill_tag_obj->bill_tag;

		$srl_len=strlen($srl);
		$rem_len=5-$srl_len;

		for ($i=1; $i<=$rem_len; $i++)
		{
			$zero=$zero."0";
		}

		$srl_no_txt=$bill_tag."/".$zero.$srl."/".substr($session['startyear'],2,2)."-".substr($session['endyear'],2,2);
                return $srl_no_txt;
	}

    public function updateData($taxinvoiceId, $searcharray) {
     ///   $saleBillMaster = array();
        $voucherUpd = array();
        
      
        
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
            
            $voucherMastId = $searcharray['hdvoucherMastid'];
            $voucherUpd['voucher_date'] = date("Y-m-d", strtotime($searcharray['saleBillDate']));
            $insrt = $this->gsttaxinvoicemodel->UpdateData($voucherMastId,$taxinvoiceId,$voucherUpd, $searcharray);
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

    /**
     * @method printSaleBill
     * @return htmlPage
     * 
     */
    public function printSaleBill() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {

                $masterId = 0;
            } else {
                $masterId = $this->uri->segment(4);
            }
            //$masterId=  $this->input->post('blendId');   
            $result['dtlview'] = $this->gsttaxinvoicemodel->SaleBillDetailsPrint($masterId);
            $result['headerview'] = $this->gsttaxinvoicemodel->SaleBillMasterPrint($masterId);
           
            
            
          
            
            $result['amountinword'] = strtoupper( $this->no_to_words($result['headerview']['GrandTotal']));
            $page = 'GSTtaxinvoice/SaleBillPrint';
            $this->load->view($page, $result);
        } else {
            redirect('login', 'refresh');
        }
    }
    
       

    function print_item(){
        $session = sessiondata_method();
            if ($this->session->userdata('logged_in')) {
                if ($this->uri->segment(4) === FALSE) {

                $masterId = 0;
            } else {
                $masterId = $this->uri->segment(4);
            }
                // load library
                $this->load->library('pdf');
               // $pdf = new pdf();
                
                $pdf = $this->pdf->load();
               
                // retrieve data from model
                $result['dtlview'] = $this->gsttaxinvoicemodel->SaleBillDetailsPrint($masterId);
                $result['headerview'] = $this->gsttaxinvoicemodel->SaleBillMasterPrint($masterId);
                $result['amountinword'] = strtoupper( $this->no_to_words($result['headerview']['GrandTotal']));
                ini_set('memory_limit', '256M'); 
                 $page = 'GSTtaxinvoice/saleBillPdf';
                $html = $this->load->view($page, $result, true);
                // render the view into HTML
                $pdf->WriteHTML($html); 
                $output = 'saleBillPdf' . date('Y_m_d_H_i_s') . '_.pdf'; 
                $pdf->Output("$output", 'I');
                exit();
         }
         else {
            redirect('login', 'refresh');
        }
}

    
    
    public function no_to_words($no) {
        $words = array('0' => '', 
            '1' => 'one',
            '2' => 'two', 
            '3' => 'three', 
            '4' => 'four', 
            '5' => 'five', 
            '6' => 'six', 
            '7' => 'seven', 
            '8' => 'eight', 
            '9' => 'nine', 
            '10' => 'ten', 
            '11' => 'eleven',
            '12' => 'twelve', 
            '13' => 'thirteen', 
            '14' => 'fouteen', 
            '15' => 'fifteen', 
            '16' => 'sixteen', 
            '17' => 'seventeen', 
            '18' => 'eighteen', 
            '19' => 'nineteen', 
            '20' => 'twenty', 
            '30' => 'thirty', 
            '40' => 'fourty', 
            '50' => 'fifty', 
            '60' => 'sixty',
            '70' => 'seventy', 
            '80' => 'eighty', 
            '90' => 'ninty',
            '100' => 'hundred &', 
            '1000' => 'thousand', 
            '100000' => 'lakh', 
            '10000000' => 'crore');
        if ($no == 0)
            return ' ';
        else {
            $novalue = '';
            $highno = $no;
            $remainno = 0;
            $value = 100;
            $value1 = 1000;
            while ($no >= 100) {
                if (($value <= $no) && ($no < $value1)) {
                    $novalue = $words["$value"];
                    $highno = (int) ($no / $value);
                    $remainno = $no % $value;
                    break;
                }
                $value = $value1;
                $value1 = $value * 100;
            }
            if (array_key_exists("$highno", $words))
                return $words["$highno"] . " " . $novalue . " " . $this->no_to_words($remainno);
            else {
                $unit = $highno % 10;
                $ten = (int) ($highno / 10) * 10;
                return $words["$ten"] . " " . $words["$unit"] . " " . $novalue . " " . $this->no_to_words($remainno);
            }
        }
    }

    public function get_final_product_rate()
    {
        $productPacketId=$this->input->post('productId');
        $saleRate=$this->gsttaxinvoicemodel->get_final_product_rate_by_id($productPacketId);
      //  echo($saleRate);
        echo json_encode(
                array(
                    "sale_rate"=>$saleRate['sale_rate'],
                    "net_kgs" =>$saleRate['net_kgs']
                )
                );
    }
}

?>
