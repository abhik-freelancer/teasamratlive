<?php
//we need to call PHP's session object to access it through CI
class gstrawteasale extends CI_Controller {

     function __construct() {
        parent::__construct();

        $this->load->model('grademastermodel', '', TRUE);
        $this->load->model('gardenmastermodel', '', TRUE);
        $this->load->model('bagtypemodel', '', TRUE);
        $this->load->model('locationmastermodel', '', TRUE);
        $this->load->model('rawteasalemodel','',TRUE);
        $this->load->model('customermastermodel','',TRUE);
        $this->load->model('companymodel', '', TRUE);
        $this->load->model('gsttaxinvoicemodel', '', TRUE);
        
    }
    
    
      public function index() {
        
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            
            $compny = $session['company'];
            $year = $session['yearid'];
            $result = $this->rawteasalemodel->getGSTRawTeasaleList($compny,$year);
            $page = 'raw_tea_sale/listgst';
            $header = '';
            $headercontent=NULL;
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
    
    
    
     public function addRawTeaSale() {

        $session = sessiondata_method();
        
        if ($this->session->userdata('logged_in')) {

             if ($this->uri->segment(4) === FALSE) {
                 $rawteasaleMastId = 0;
          } 
            else {
                $rawteasaleMastId = $this->uri->segment(4);
                
        }
       $headercontent['garden'] = $this->gardenmastermodel->gardenlist();
       $headercontent['customerlist'] = $this->customermastermodel->custoemrlist($session);
       
            
          
            
             if ($rawteasaleMastId != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['rawteasaleMastId']=$rawteasaleMastId;
                
                 $companyId = $session['company'];
                 $yearId = $session['yearid'];
                
                $result['cgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='CGST',$usedfor='O');
                $result['sgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='SGST',$usedfor='O');
                $result['igstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='IGST',$usedfor='O');
                
                
                $result['rawteasaleMastData'] = $this->rawteasalemodel->GSTRawTeaSalemasterData($rawteasaleMastId);
                $result['rawteasaleDtlData'] = $this->rawteasalemodel->GSTRawTeaSaleDtlData($rawteasaleMastId);
                
                $page = 'raw_tea_sale/gstadd_raw_tea_sale.php';
                
            } else {
                $headercontent['mode'] = "Add";
                $headercontent['rawteasaleMastId']="";
                $result = NULL;
                $page = 'raw_tea_sale/gstadd_raw_tea_sale.php';
            }
            
        
            $header = NULL;

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
    public function showInvoice(){
        $session = sessiondata_method();
        $company = $session["company"];
        $garden = $this->input->post('garden');
        $result['invoice']=$this->rawteasalemodel->getInvoice($garden,$company);
        $page='raw_tea_sale/invoicedropdown.php';
        $this->load->view($page,$result);
    }
    
     public function showLotNumber(){
        $session = sessiondata_method();
        $company = $session["company"];
        $garden  = $this->input->post('garden');
        $invoice = $this->input->post('invoice');
        $result['lot']=  $this->rawteasalemodel->getLotNumber($garden,$invoice,$company);
        $page='raw_tea_sale/lotdropdown.php';
        $this->load->view($page,$result);
    } 
    
     public function showGrade(){
        $session = sessiondata_method();
        $company = $session["company"];
        $garden  = $this->input->post('garden');
        $invoice = $this->input->post('invoice');
        $lot = $this->input->post('lot');
        $result['grade']=  $this->rawteasalemodel->getGradeNumber($garden,$invoice,$lot,$company);
        $page='raw_tea_sale/gradedropdown.php';
        $this->load->view($page,$result);
    }  
    
    
    /**
     * @access public
     * @name showTeaStock
     * @param void $name Description
     * @return void 
     */
    public function showStockIn()
    {
       $session = sessiondata_method();
       if ($this->session->userdata('logged_in')) {
           $garden  =  $this->input->post('gardenId');
           $invoice =  $this->input->post('invoiceNum');
           $lotNum  = $this->input->post('lotNum');
           $grade =  $this->input->post('grade');
           $divnumber = $this->input->post('divSerialNumber');
           $companyId = $session['company'];
           $yearId = $session['yearid'];
           
            $result['groupStock'] = $this->rawteasalemodel->getTeaStock($garden,$invoice,$lotNum,$grade);
            $result['divnumber'] = $divnumber;
            $result['cgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='CGST',$usedfor='O');
            $result['sgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='SGST',$usedfor='O');
            $result['igstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='IGST',$usedfor='O');
            
            if( $result['groupStock']){
                $page = 'raw_tea_sale/gstteaStockDtl';
                $this->load->view($page, $result);
            }else{
                echo "0";
            }
            
       }else{
            redirect('login', 'refresh');
       }
    }
    /**
     * @method getAmount
     */
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
    /**
     * @access public
     * @date 26-05-2016
     * @name purchaseExist
     * @param void $name Description
     * @return void 
     */
    public function purchaseExist()
    {
       $session = sessiondata_method();
       if ($this->session->userdata('logged_in')) {
           $garden  =  $this->input->post('gardenId');
           $invoice =  $this->input->post('invoiceNum');
           $lotNum  = $this->input->post('lotNum');
           $grade =  $this->input->post('grade');
           
            $purchaseId = $this->rawteasalemodel->getPurchaseExist($garden,$invoice,$lotNum,$grade);
            
            echo($purchaseId);
       }else{
            redirect('login', 'refresh');
       }
    }
    
    
    /*@method checkExistingRawTeaInvoiceNo
     *@date 17-06-2016
     * By Mithilesh 
     */
    
    public function checkExistingRawTeaInvoiceNo(){
        $session = sessiondata_method();
        $compny = $session['company'];
        $yearid = $session['yearid'];
        $invoiceNo = $this->input->post('invoice_no');
        
        $result = $this->rawteasalemodel->getExixtingInvoiceNo($invoiceNo,$compny,$yearid);
        if($result==TRUE){
             echo "1";
         }
         else{
             echo "0";
         }
        
        
    }
    
 
    
    
     /**
     * @method insertBlending
     * @description save blending data
     */
    public function insertRawteaSale(){
        $session = sessiondata_method();
        $formData = $this->input->post('formDatas');
        parse_str($formData, $searcharray);
        $rawteasale = array();
        $voucherMast = array();
        $voucherMast['voucher_number'] = NULL;         
        $voucherMast['voucher_date'] = date("Y-m-d", strtotime($searcharray['saleDt']));
        $voucherMast['narration'] = "Garden tea sale "." on Dated ".date("Y-m-d", strtotime($searcharray['saleDt']));         
        $voucherMast['cheque_number'] =NULL;         
        $voucherMast['cheque_date'] = NULL;         
        $voucherMast['transaction_type'] = 'RS';         
        $voucherMast['created_by'] = $session['user_id'];         
        $voucherMast['company_id'] = $session['company'];         
        $voucherMast['year_id'] =  $session['yearid']; 
        $voucherMast['serial_number'] = 1;
        $voucherMast['vouchertype'] =NULL;         
        $voucherMast['branchid'] = NULL;         
        $voucherMast['paid_to'] = NULL;         
        
        
        $insrt= $this->rawteasalemodel->GSTinsertData($voucherMast,$searcharray);
        if($insrt){
            echo '1';
        }else{
            echo '0';
        }
        exit(0);
    }
    
    public function updateRawTeaSale(){
          $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {

            $formData = $this->input->post('formDatas');
            parse_str($formData, $searcharray);

            $updVoucherMaster = array();

            $rawTeasalemasterId = $searcharray['txtrawTeaSaleMastId'];
            
           
            
            if ($rawTeasalemasterId != "") {
                    $voucherMasterId = $searcharray['txthdVoucherMastId'];
                     $updVoucherMaster['voucher_number'] = $searcharray['invoice_no'];
                     $updVoucherMaster['voucher_date'] = date("Y-m-d", strtotime($searcharray['saleDt']));
                     $updVoucherMaster['narration'] = "Sale against Invoice No " . $searcharray['invoice_no'] . " Date " . date("Y-m-d", strtotime($searcharray['saleDt']));
                     $updVoucherMaster['transaction_type'] = 'RS';
                
              
                     
                $update = $this->rawteasalemodel->GSTupdateRawTeaSale($voucherMasterId, $updVoucherMaster, $searcharray);
                if ($update) {
                    echo '1';
                } else {
                    echo '0';
                }
                exit(0);
            } else {
                
            }
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
    
    public function GetSerialNo(){
         $session = sessiondata_method();
          $cid=$session['company'];
          $yid=$session['yearid'];
		$srl_no=$this->rawteasalemodel->getRawsaleTeaSerialNo($cid,$yid);
		$srl=$srl_no+1;
            return $srl;
    }
    
    // will use later
  /*  private function get_raw_tea_sale_InvoiceNo($srl,$cid)
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
	}*/
    
    
    
    
  /*  public function printRawTeaSale(){
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {

                $masterId = 0;
            } else {
                $masterId = $this->uri->segment(4);
            }
            //$masterId=  $this->input->post('blendId');   
            $result['dtlview'] = $this->rawteasalemodel->RawteaSaleDtlData($masterId);
            $result['headerview'] = $this->rawteasalemodel->RawTeaSalematerData($masterId);
           
            $result['amountinword'] = strtoupper( $this->no_to_words($result['headerview']['GrandTotal']));
            $page = 'raw_tea_sale/RawteaSalePrint';
            $this->load->view($page, $result);
        } else {
            redirect('login', 'refresh');
        }
    }
*/
    
    
    public function getpdfRawTeaSale(){
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {

                $masterId = 0;
            } else {
                $masterId = $this->uri->segment(4);
            }
            
          $this->load->library('pdf');
         $pdf = $this->pdf->load();
         ini_set('memory_limit', '256M'); 
         
         
            $result['dtlview'] = $this->rawteasalemodel->RawteaSaleDtlDataGSTPdf($masterId);
            $result['headerview'] = $this->rawteasalemodel->RawTeaSaleMaterDataGST($masterId);
			
			/*
			echo "<pre>";
			print_r($result['dtlview']);
			echo "</pre>";
			*/
			
            $result['amountinword'] = strtoupper( $this->no_to_words($result['headerview']['GrandTotal']));
           
            $page = 'raw_tea_sale/rawteasale_pdf_GST.php';
            $html = $this->load->view($page, $result, TRUE);

            $pdf->WriteHTML($html);
            $output = 'rawteasale' . date('Y_m_d_H_i_s') . '_.pdf';
            $pdf->Output("$output", 'I');
            exit();
            
            
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
    public function printrawTeaSale(){
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {

                $masterId = 0;
            } else {
                $masterId = $this->uri->segment(4);
            }
            

         
         
            $result['dtlview'] = $this->rawteasalemodel->RawteaSaleDtlData($masterId);
            $result['headerview'] = $this->rawteasalemodel->RawTeaSalematerData($masterId);
            $result['amountinword'] = strtoupper( $this->no_to_words($result['headerview']['GrandTotal']));
           
            $page = 'raw_tea_sale/print_rawtea_sale.php';
            $html = $this->load->view($page, $result, TRUE);
            echo ($html);
            
            
        } else {
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
    
    
    
}

?>
