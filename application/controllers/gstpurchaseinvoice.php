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
     * 
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
    
}