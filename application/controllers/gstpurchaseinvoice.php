<?php
class gstpurchaseinvoice extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
            
        ini_set('max_input_vars', 5000);
        ini_set('post_max_size', '500M');

        $this->load->model('auctionareamodel', '', TRUE);
        $this->load->model('vendormastermodel', '', TRUE);
        $this->load->model('transportmastermodel', '', TRUE);
        $this->load->model('warehousemastermodel', '', TRUE);
        $this->load->model('grademastermodel', '', TRUE);
        $this->load->model('gardenmastermodel', '', TRUE);
        $this->load->model('purchaseinvoicemastermodel', '', TRUE);
        $this->load->model('locationmastermodel', '', TRUE);
        $this->load->model('bagtypemodel', '', TRUE);
        $this->load->model('gsttaxinvoicemodel','',TRUE);
    }
    /**
     * index
     */
    
    public function index(){
          if ($this->session->userdata('logged_in')) {
              $session = sessiondata_method();
              $companyId = $session['company'];
              $yearId=$session["yearid"];
              $result = $this->purchaseinvoicemastermodel->purchaseInvoiceList($companyId,$yearId);
              $page = 'purchase_invoice/gstlist_view';
              $header = '';
              $headercontent="";
              createbody_method($result, $page, $header, $session, $headercontent);
              
          }  else {
              redirect('login', 'refresh');
              
          }
    }

     /**
     * @name addPurchaseInvoice
     * @param void 
     * @author Abhik<amiabhik@gmail.com>
     * @date 15/07/2017
     */
    
    public function addPurchaseInvoice() {

        $session = sessiondata_method();
       
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {

                $purchaseInvoiceId = 0;
            } else {
                $purchaseInvoiceId = $this->uri->segment(4);
            }
            $headercontent['vendor'] = $this->vendormastermodel->vendorlist($session);
            $headercontent['transporterlist']=$this->transportmastermodel->transportlist();
            $headercontent['warehouse'] = $this->warehousemastermodel->warehouselist();
            $headercontent['grade'] = $this->grademastermodel->gradelist();
            $headercontent['garden'] = $this->gardenmastermodel->gardenlist();
            $headercontent['teagroup'] = $this->purchaseinvoicemastermodel->teagrouplist();
            $headercontent['location'] = $this->locationmastermodel->loactionmasterlist();
            $headercontent['auctionarea'] = $this->auctionareamodel->aucareaList();
            
          
            $headercontent['serviceTax'] = $this->purchaseinvoicemastermodel->getCurrentservicetax();
            $headercontent['vatpercentage'] = $this->purchaseinvoicemastermodel->getCurrentvatrate();
            $headercontent['cstRate'] = $this->purchaseinvoicemastermodel->getCurrentcstrate();
            
            
          

            if ($purchaseInvoiceId != 0) {
                $headercontent['mode'] = "Edit";
                $result['purchaseMaster'] = $this->purchaseinvoicemastermodel->getGSTPurchaseMasterData($purchaseInvoiceId);
                $result['purchaseDetails'] = $this->purchaseinvoicemastermodel->getPurchaseDetails($purchaseInvoiceId);
                $result['grandWeightValue']=$this->purchaseinvoicemastermodel->getGrandTotalWeight($purchaseInvoiceId);
                $result['grandBrokerageValue']=$this->purchaseinvoicemastermodel->getTotalBrokerageFromDetail($purchaseInvoiceId);
                $result['grandServiceTaxValue']=$this->purchaseinvoicemastermodel->getTotalServiceTaxFromDetail($purchaseInvoiceId);
                $result['totalNoOfBags']=$this->purchaseinvoicemastermodel->getTotalBagNo($purchaseInvoiceId);
                $auctionareaId = $this->purchaseinvoicemastermodel->getAuctionareaId($purchaseInvoiceId);
                if($auctionareaId!=0){
                    
                    $result['transCost'] = $this->purchaseinvoicemastermodel->getTransCost($auctionareaId);
                
                }
		$page = 'purchase_invoice/manage_purchase.php';
            } else {
                $headercontent['mode'] = "Add";
                $result['purchaseMaster'] =NULL;
                $result['purchaseDetails'] =NULL;
                $result['grandWeightValue']=NULL;
                $result['grandBrokerageValue']=NULL;
                $result['grandServiceTaxValue']=NULL;
                $result['totalNoOfBags']=NULL;
                $auctionareaId = "";
                $page = 'purchase_invoice/gstadd_purchase.php';
            }
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
     public function createDetails(){
        
        $session = sessiondata_method();
        $divNumber = $this->input->post('divNumber');
        $typeOfPurchase =  $this->input->post('purType');
        $transCost =  $this->input->post('transcost');
        
         if ($this->session->userdata('logged_in')) {
            $companyId=$session['company'];
            $yearId=$session['yearid'];
             
             
           $result['warehouse'] = $this->warehousemastermodel->warehouselist();
           $result['grade'] = $this->grademastermodel->gradelist();
           $result['garden'] = $this->gardenmastermodel->gardenlist();
           $result['teagroup'] = $this->purchaseinvoicemastermodel->teagrouplist();
           $result['location'] = $this->locationmastermodel->loactionmasterlist();
           
           $result['cgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='CGST',$usedfor='I');
           $result['sgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='SGST',$usedfor='I');
           $result['igstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='IGST',$usedfor='I');
           
           
           
           
           $result['divnumber']=$divNumber;
           $result['purchaseType']=$typeOfPurchase;
           $result['transcost'] = $transCost;
           
           
           $page = 'purchase_invoice/gstpurchaseDtlAdd.php';
           
            $this->load->view($page, $result);
           
         }else {
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
    
    
    /**
 * @method insertNewPurchaseInvoice
 * @param formData $name Description
 * @return boolean Description
 */
    
    public function insertNewPurchaseInvoice(){
        
        ini_set('max_input_vars', 5000);
        ini_set('post_max_size', '500M');
        
       
         if ($this->session->userdata('logged_in')) {
        $session = sessiondata_method();
        $formData = $this->input->post('formDatas');
        parse_str($formData, $searcharray);
        
        
        /*Voucher master*/
        $lastserial = $this->purchaseinvoicemastermodel->getserialnumber($session['company'], $session['yearid']);
        
        $voucherMaster = array();
        $voucherMaster['voucher_number']=$searcharray['taxinvoice'];
        $voucherMaster['voucher_date']=date('Y-m-d',  strtotime($searcharray['taxinvoicedate']));
        $voucherMaster['narration']='Purchase against invoice No '.$searcharray['taxinvoice'].' Date'.date('Y-m-d',  strtotime($searcharray['taxinvoicedate']));
        $voucherMaster['cheque_number']=NULL;
        $voucherMaster['cheque_date']=NULL;
        $voucherMaster['transaction_type']='PR';
        $voucherMaster['created_by']=$session['user_id'];
        $voucherMaster['company_id']=$session['company'];
        $voucherMaster['year_id']=$session['yearid'];
         if (count($lastserial) > 0) {
            $voucherMaster['serial_number'] = ($lastserial[0]->serial_number) + 1;
        } else {
            $voucherMaster['serial_number'] = 1;
        }
        
        $voucherMaster['vouchertype']='PR';
        $voucherMaster['branchid']=0;
        $voucherMaster['paid_to']=NULL;
        $totalDetails =count($searcharray['txtLot']);
        
         if($totalDetails>0){
             $STATUS=$this->purchaseinvoicemastermodel->GSTPurchaseDataInsert($voucherMaster,$searcharray);
         }else{
             $STATUS=FALSE;
         }
        
        if($STATUS){
            echo 1;
        }else{
            echo 0;
        }
        } else {
            redirect('login', 'refresh');
        }
        
       
        
        
    }
    
}