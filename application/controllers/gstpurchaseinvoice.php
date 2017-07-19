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
            $companyId=$session['company'];
            $yearId=$session['yearid'];
            
            $headercontent['vendor'] = $this->vendormastermodel->vendorlist($session);
            $headercontent['transporterlist']=$this->transportmastermodel->transportlist();
            $headercontent['warehouse'] = $this->warehousemastermodel->warehouselist();
            $headercontent['grade'] = $this->grademastermodel->gradelist();
            $headercontent['garden'] = $this->gardenmastermodel->gardenlist();
            $headercontent['teagroup'] = $this->purchaseinvoicemastermodel->teagrouplist();
            $headercontent['location'] = $this->locationmastermodel->loactionmasterlist();
            $headercontent['auctionarea'] = $this->auctionareamodel->aucareaList();
            
          
           $headercontent['cgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='CGST',$usedfor='I');
           $headercontent['sgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='SGST',$usedfor='I');
           $headercontent['igstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='IGST',$usedfor='I');
            
            
          

            if ($purchaseInvoiceId != 0) {
                $headercontent['mode'] = "Edit";
                $result['purchaseMaster'] = $this->purchaseinvoicemastermodel->GSTPurchaseMasterData($purchaseInvoiceId);
                $result['purchaseDetails'] = $this->purchaseinvoicemastermodel->GSTPurchaseDetails($purchaseInvoiceId);
                /*$result['grandWeightValue']=$this->purchaseinvoicemastermodel->getGrandTotalWeight($purchaseInvoiceId);
                $result['grandBrokerageValue']=$this->purchaseinvoicemastermodel->getTotalBrokerageFromDetail($purchaseInvoiceId);
                $result['grandServiceTaxValue']=$this->purchaseinvoicemastermodel->getTotalServiceTaxFromDetail($purchaseInvoiceId);
                $result['totalNoOfBags']=$this->purchaseinvoicemastermodel->getTotalBagNo($purchaseInvoiceId);*/
                $auctionareaId = $this->purchaseinvoicemastermodel->getAuctionareaId($purchaseInvoiceId);
                if($auctionareaId!=0){
                    
                    $result['transCost'] = $this->purchaseinvoicemastermodel->getTransCost($auctionareaId);
                
                }
                $header = '';
		$page = 'purchase_invoice/gstmanage_purchase.php';
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
   
   public function updatePurchaseDetail() {
        $sampleBag = array();
        $data = array();
        $bagData = array();
        $voucherdata = array();
        $costOfTea = 0;

        $purchaseMasterId = $this->input->post('PurchaseMasterId');
        $voucherMasterId = $this->input->post('voucherMastId'); // added on 31.05.2016
        $vendorId = $this->input->post('vendorId'); // added on 31.05.2016
        $purchaseDetailId = $this->input->post('purchaseDetailId');
        $lotnumber = $this->input->post('lotnumber');
        $doNumber = $this->input->post('doNumber');
        $doDate = ($this->input->post('doDate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('doDate'))));
        $invoiceNumber = $this->input->post('invoice');
        $gross = $this->input->post('gross');
        $gpNumber = $this->input->post('GPnumber');
        $gpDate = ($this->input->post('gpDate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('gpDate'))));
        $price = $this->input->post('price');
        $group = $this->input->post('group');
        $location = $this->input->post('location');
        $garden = $this->input->post('garden');
        $grade = $this->input->post('grade');
        $wareHouse = $this->input->post('warehouse');

        $normalBagid = $this->input->post('normalBagId');
        $normalBag = $this->input->post('NormalBags');
        $nomalBagQty = $this->input->post('NormalBagQtys');
        $normalBagChest = $this->input->post('normalBagChest');
        $sampleBag = $this->input->post('sampleBags');
       
        $totalWeight = $this->input->post('totalWeight');
        $totalCost = $this->input->post('totalDtlCost');
        $teaCostPrKg = $this->input->post('teaCostPrKg');

        $costOfTea = ($totalWeight * $price);
        
        $voucherdata['voucherMastId'] = $voucherMasterId;
        $voucherdata['vendor_id'] = $vendorId;
        
        
        /****************************GST*******************************/
        $discount=  $this->input->post('discount');
        $taxable = $this->input->post('taxable');
        $cgstid = $this->input->post('cgstid');
        $cgstamt  = $this->input->post('cgstamt');
        $sgstid = $this->input->post('sgstid');
        $sgstamt = $this->input->post('sgstamt');
        $igstid = $this->input->post('igstid');
        $igstamt = $this->input->post('igstamt');
        $netamount = $this->input->post('netamount');
        /**************************************************************/

        $data['id'] = $purchaseDetailId;
        $data['purchase_master_id'] = $purchaseMasterId;
        $data['lot'] = $lotnumber;
        $data['doRealisationDate'] = $doDate;
        $data['do'] = $doNumber;
        $data['invoice_number'] = $invoiceNumber;
        $data['garden_id'] = $garden;
        $data['grade_id'] = $grade;
        $data['warehouse_id'] = $wareHouse;
        $data['location_id'] = $location;
        $data['gp_number'] = $gpNumber;
        $data['date'] = $gpDate;
        $data['package'] = null;
        $data['stamp'] = NULL;
        $data['gross'] = $gross;
        $data['brokerage'] = NULL;
        $data['tb_charges']=NULL;
        $data['total_weight'] = $totalWeight;
        $data['rate_type_value'] = NULL;
        $data['price'] = $price;
        $data['service_tax'] = NULL;
        $data['total_value'] = $totalCost;
        $data['chest_from'] = NULL;
        $data['chest_to'] = NULL;
        $data['value_cost'] = $costOfTea; //[bagsQty*price]
        $data['net'] = null;
        $data['rate_type'] = NULL;
        $data['rate_type_id'] = NULL;
        $data['service_tax_id'] = NULL;
        $data['teagroup_master_id'] = $group;
        $data['cost_of_tea'] = $teaCostPrKg;
        $data['transportation_cost'] = NULL;
        /*********************************GST**************************/
        $data['gst_teavalue']=$totalCost;
        $data['gst_discount']=$discount;
        $data['gst_taxable']=$taxable;
        $data['cgst_id']=$cgstid;
        $data['cgst_amt']=$cgstamt;
        $data['sgst_id']=$sgstid;
        $data['sgst_amt']=$sgstamt;
        $data['igst_id']=$igstid;
        $data['igst_amt']=$igstamt;
        $data['gst_netamount']=$netamount;
        /************************************************************/
        
        $bagData['sampleBag'] = $sampleBag; 

        $NormalbagData['purchasedtlid'] = $purchaseDetailId;
        $NormalbagData['bagtypeid'] = 1;
        $NormalbagData['no_of_bags'] = $normalBag;
        $NormalbagData['net'] = $nomalBagQty;
        $NormalbagData['chestSerial'] = $normalBagChest;
        $NormalbagData['actual_bags'] = $normalBag;
       



        $update = $this->purchaseinvoicemastermodel->GSTupdatePurchaseDetailData($data, $bagData, $NormalbagData,$voucherdata);

        if ($update == TRUE) {
            echo '1';
        } else {
            echo '0';
        }
    }
   
   /**
     * @method updatePurchaseMasterData
     * @param type $name Description
     * @return type Description
     * @description Update Master area Data.
     */
    public function updatePurchaseMasterData() {
        $data = array();

        $PurchaseMasterId = $this->input->post('PurMasterId');
        $voucherMastId = $this->input->post('voucherMastId');
        $purchaseType = $this->input->post('purchaseType');
        $auctionarea = $this->input->post('auctionarea');
        $purchaseInvoiceNumber = $this->input->post('purchaseInvoiceNumber');
        $invoiceDate = ($this->input->post('invoiceDate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('invoiceDate'))));
        $saleNo = $this->input->post('saleNo');
        $saleDate = ($this->input->post('saleDate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('saleDate'))));
        $promptDate = ($this->input->post('promptDate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('promptDate'))));
        $vendor = $this->input->post('vendor');
        $cnNo = $this->input->post('cnNo');
        $transporterid = $this->input->post('transporterid');
        $challanno = $this->input->post('challanno');
        $challanDt = ($this->input->post('challanDt') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('challanDt'))));
        $HSN = $this->input->post('HSN');
     

        $data['id'] = $PurchaseMasterId;
        $data['purchase_invoice_number'] = $purchaseInvoiceNumber;
        $data['purchase_invoice_date'] = $invoiceDate;
        $data['auctionareaid'] = $auctionarea;
        $data['vendor_id'] = $vendor;
        $data['cn_no'] = $cnNo;
        $data['challan_no']=$challanno;
        $data['challan_date']=$challanDt;
        $data['transporter_id'] = $transporterid;
        $data['voucher_master_id'] = $voucherMastId; 
        $data['sale_number'] = $saleNo;
        $data['sale_date'] = $saleDate;
        $data['promt_date'] = $promptDate;
        $data['from_where'] = $purchaseType;
        $data['GST_HSN']=$HSN;

        $vouchrMastUpd=array();
        $vouchrMastUpd['id']=$voucherMastId;
        $vouchrMastUpd['voucher_number']=$purchaseInvoiceNumber;
        $vouchrMastUpd['voucher_date']=$invoiceDate;
        
        


        //$purchaseMasterSave = $this->purchaseinvoicemastermodel->updatePurchaseMaster($data);
        $purchaseMasterSave = $this->purchaseinvoicemastermodel->updatePurchaseMaster($vouchrMastUpd,$data);
        if ($purchaseMasterSave) {
            echo('1');
        } else {
            echo('0');
        }
    }
    
    
       /**
    * @method updateOtherandRoundOff
    * @return int Description
    */ 
public function updateOtherandRoundOff(){
    
    
    $masterId = $this->input->post('PurMasterId');
    $voucherMastid = $this->input->post('voucherMastId'); // By Mithilesh on 31.05.2016
    $vendorId = $this->input->post('vendor');
    
    $roundOff=  $this->input->post('roundoff');
    $totalCost =  $this->input->post('totCost');
    
 
    
    $update=array();
    
    $update['round_off']=($roundOff==""?0:$roundOff);
    $update['total']=($totalCost==""?0:$totalCost);
   
   
    
    $otherChargesUpdate = $this->purchaseinvoicemastermodel->updateOtherCharges($masterId,$update,$voucherMastid,$vendorId);
    if($otherChargesUpdate){
        echo('1');
    }else{
        echo('0');
    }
}
    
}