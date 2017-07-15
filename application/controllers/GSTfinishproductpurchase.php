<?php

//we need to call PHP's session object to access it through CI
class GSTfinishproductpurchase extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('productmodel', '', TRUE);
        $this->load->model('packetmodel', '', TRUE);
        $this->load->model('finishproductpurchasemodel', '', TRUE);
        $this->load->model('gstfinishproductpurchasemodel', '', TRUE);
        $this->load->model('gsttaxinvoicemodel', '', TRUE);
        $this->load->model('customermastermodel', '', TRUE);
		$this->load->model('companymodel', '', TRUE);
		$this->load->model('transportmastermodel', '', TRUE);
    }

    public function index() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
			
			$result = $this->gstfinishproductpurchasemodel->getFinishProdPurchaseList($session['company'],$session['yearid']);
			$page = 'GSTfinishproduct_purchase/list_view';
            $header = '';
            $headercontent="";
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
            $companyId=$session['company'];
            $yearId=$session['yearid'];
            $headercontent['finalproduct'] = $this->gsttaxinvoicemodel->getPacketProduct();
             $headercontent['vendor'] = $this->finishproductpurchasemodel->getVendorList($session['company']);
           
            
            //gst rate
            $headercontent['cgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='CGST',$usedfor='I');
            $headercontent['sgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='SGST',$usedfor='I');
            $headercontent['igstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='IGST',$usedfor='I');
            
            $headercontent['lastSalebillNo'] = $this->gsttaxinvoicemodel->getlastSaleBillNo($session['company'],$session['yearid']);
			
			$headercontent['transporterlist'] = $this->transportmastermodel->transportlist();
            
			

            if ($salebillno != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['salebillno'] = $salebillno;
                $result['taxInvoiceMaster'] = $this->gstfinishproductpurchasemodel->getFinishProdMasterData($salebillno);
                $result['taxInvoiceDetail'] = $this->gstfinishproductpurchasemodel->getFinishProdDetailData($salebillno);
                $page = 'GSTfinishproduct_purchase/taxinvoice_add';
            } else {
                $headercontent['mode'] = "Add";
                $headercontent['salebillno']="";
                $page ='GSTfinishproduct_purchase/taxinvoice_add';
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
            $result['cgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='CGST',$usedfor='I');
            $result['sgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='SGST',$usedfor='I');
            $result['igstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='IGST',$usedfor='I');
            

            $result['divnumber'] = $divNumber;
            $page = 'GSTfinishproduct_purchase/taxinvoicedetail.php';
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
        $finishproductprchaseID = $this->input->post('salebillid');
        $formData = $this->input->post('formDatas');

        parse_str($formData, $searcharray);

        if ($modeOfOpeartion == "Add" && $finishproductprchaseID == "") {
            $this->insertData($searcharray);
        } else {
            $this->updateData($finishproductprchaseID, $searcharray);
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
             $voucherMast['narration'] = "Purchase against Invoice No ".$searcharray['txtSaleBillNo']." Date ".date("Y-m-d", strtotime($searcharray['saleBillDate']));         
             $voucherMast['cheque_number'] =NULL;         
             $voucherMast['cheque_date'] = NULL;         
             $voucherMast['transaction_type'] = 'PR';         
             $voucherMast['created_by'] = $session['user_id'];         
             $voucherMast['company_id'] = $session['company'];         
             $voucherMast['year_id'] =  $session['yearid']; 
             $voucherMast['serial_number'] = 1;
             $voucherMast['vouchertype'] ='PR';         
             $voucherMast['branchid'] = NULL;         
             $voucherMast['paid_to'] = NULL;         
                        
                        
           $sale_srl_no = "";
            $insrt = $this->gstfinishproductpurchasemodel->insertData($voucherMast, $searcharray ,$sale_srl_no);

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
    
  
    public function updateData($taxinvoiceId, $searcharray) {
     ///   $saleBillMaster = array();
        $voucherUpd = array();
        
      
        
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
            
            $voucherMastId = $searcharray['hdvoucherMastid'];
            $voucherUpd['voucher_date'] = date("Y-m-d", strtotime($searcharray['saleBillDate']));
            $insrt = $this->gstfinishproductpurchasemodel->UpdateData($voucherMastId,$taxinvoiceId,$voucherUpd, $searcharray);
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
