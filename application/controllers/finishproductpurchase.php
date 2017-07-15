<?php
/**
 * Purchase of finish product from Tea Samrat to Real project
 * private limited.
 * @date   05/03/2017
 * @author Abhik Ghosh
 */
class finishproductpurchase extends CI_Controller {
    //put your code here
    public function finishproductpurchase(){
        parent::__construct();
        $this->load->model('productmodel', '', TRUE);
        $this->load->model('packetmodel', '', TRUE);
        $this->load->model('finishproductpurchasemodel', '', TRUE);
        $this->load->model('customermastermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
    }
    
     public function index() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
               $result = $this->finishproductpurchasemodel->getFinishProdPurchaseList($session['company'],$session['yearid']);
               $page = 'finishproductpurchase/list_view';
               $header = '';
               createbody_method($result, $page, $header, $session, $headercontent);
        } else {
                redirect('login', 'refresh');
        }
     
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

            $headercontent['finalproduct'] = $this->finishproductpurchasemodel->getPacketProduct();
            $headercontent['vendor'] = $this->finishproductpurchasemodel->getVendorList($session['company']);
            $headercontent['cstRate'] = $this->finishproductpurchasemodel->getCurrentcstrate();
            $headercontent['vatpercentage'] = $this->finishproductpurchasemodel->getCurrentvatrate();
            
            $headercontent['lastSalebillNo'] = "";//$this->finishproductpurchasemodel->getlastSaleBillNo($session['company'],$session['yearid']);
            
        

            if ($salebillno != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['salebillno'] = $salebillno;
                $result['taxInvoiceMaster'] = $this->finishproductpurchasemodel->getFinishProdMasterData($salebillno);
				
				$result['taxInvoiceDetail'] = $this->finishproductpurchasemodel->getFinishProdDetailData($salebillno);
                $page = 'finishproductpurchase/taxinvoice_add';
            } else {
                $headercontent['mode'] = "Add";
                $page = 'finishproductpurchase/taxinvoice_add';
            }


            $header = '';
			$result='';

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

            $result['finalproduct'] = $this->finishproductpurchasemodel->getPacketProduct();
            $result['divnumber'] = $divNumber;
            $page = 'finishproductpurchase/taxinvoicedetail.php';
            $this->load->view($page, $result);
        } else {
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
			
	
                  
             $voucherMast['voucher_number'] =$searcharray["txtSaleBillNo"];         
             $voucherMast['voucher_date'] = date("Y-m-d", strtotime($searcharray['saleBillDate']));
             $voucherMast['narration'] = "Finish product purchase Invoice No ".$searcharray['txtSaleBillNo']." Date ".date("Y-m-d", strtotime($searcharray['saleBillDate']));         
             $voucherMast['cheque_number'] =NULL;         
             $voucherMast['cheque_date'] = NULL;         
             $voucherMast['transaction_type'] = 'PR';         
             $voucherMast['created_by'] = $session['user_id'];         
             $voucherMast['company_id'] = $session['company'];         
             $voucherMast['year_id'] =  $session['yearid']; 
             $voucherMast['serial_number'] = 1;
             
            
        
             $voucherMast['vouchertype'] ="PR";         
             $voucherMast['branchid'] = NULL;         
             $voucherMast['paid_to'] = NULL;         
                        
                        
           
            $insrt = $this->finishproductpurchasemodel->insertData($voucherMast, $searcharray ,$sale_srl_no);

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
        $creditDays = $this->finishproductpurchasemodel->getCreditDays($custId);
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
        $result = $this->finishproductpurchasemodel->checkExistingSalebillNumb($salebillno,$compny,$yearid);
         if($result==TRUE){
             echo "1";
         }
         else{
             echo "0";
         }
    }


    
    
    

	private function generate_serial_no($cid,$yid)
	{
		$sale_srl=$this->finishproductpurchasemodel->get_last_srl_no($cid,$yid);
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
    
        $voucherUpd = array();
        
      
        
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
            
            $voucherMastId = $searcharray['hdvoucherMastid'];
                
            $voucherUpd['voucher_date'] = date("Y-m-d", strtotime($searcharray['saleBillDate']));
          
            $insrt = $this->finishproductpurchasemodel->UpdateData($voucherMastId,$taxinvoiceId,$voucherUpd, $searcharray);
            
          

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
            $result['dtlview'] = $this->finishproductpurchasemodel->SaleBillDetailsPrint($masterId);
            $result['headerview'] = $this->finishproductpurchasemodel->SaleBillMasterPrint($masterId);
           
            
            
          
            
            $result['amountinword'] = strtoupper( $this->no_to_words($result['headerview']['GrandTotal']));
            $page = 'finishproductpurchase/SaleBillPrint';
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
                $result['dtlview'] = $this->finishproductpurchasemodel->SaleBillDetailsPrint($masterId);
                $result['headerview'] = $this->finishproductpurchasemodel->SaleBillMasterPrint($masterId);
                $result['amountinword'] = strtoupper( $this->no_to_words($result['headerview']['GrandTotal']));
                ini_set('memory_limit', '256M'); 
                 $page = 'finishproductpurchase/saleBillPdf';
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
        $saleRate=$this->finishproductpurchasemodel->get_final_product_rate_by_id($productPacketId);
      //  echo($saleRate);
        echo json_encode(
                array(
                    "sale_rate"=>$saleRate['sale_rate'],
                    "net_kgs" =>$saleRate['net_kgs']
                )
                );
    }
    
}
