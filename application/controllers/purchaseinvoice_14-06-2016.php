<?php

//we need to call PHP's session object to access it through CI
class purchaseinvoice extends CI_Controller {

    function __construct() {
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
    }

    public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
            $session_purchase = $this->session->userdata('purchase_invoice_list_detail');

            if ($session_purchase['vendor'] == '') {
                $session_vendor = 0;
                $session_invoice['vendor'] = 0;
                $session_invoice['startdate'] = $session['startyear'] . '-04-01';
                $session_invoice['enddate'] = $session['endyear'] . '-03-31';
                $session_invoice['prcom'] = $session['company'];
                $session_invoice['pryear'] = $session['yearid'];
               $result = $this->purchaseinvoicemastermodel->getPurchaselistingdata($session_invoice);
            } else {
                $session_vendor = $session_purchase['vendor'];
               $result = $this->purchaseinvoicemastermodel->getPurchaselistingdata($session_purchase);
            }

            $headercontent['vendor'] = $this->purchaseinvoicemastermodel->getVendorlist($session_vendor);
            $page = 'purchase_invoice/list_view';
            $header = 'purchase_invoice/header_view';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    /**
     * @method addPurchaseInvoice
     * @description : add and edit purchase
     */

    public function addPurchaseInvoice() {

        $session = sessiondata_method();
        //echo($this->uri->segment(4)); exit;
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
            $headercontent['serviceTax'] = $this->purchaseinvoicemastermodel->getCurrentservicetax($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');
            $headercontent['vatpercentage'] = $this->purchaseinvoicemastermodel->getCurrentvatrate($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');
            $headercontent['cstRate'] = $this->purchaseinvoicemastermodel->getCurrentcstrate($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');


            if ($purchaseInvoiceId != 0) {
                $headercontent['mode'] = "Edit";
                $result['purchaseMaster'] = $this->purchaseinvoicemastermodel->getPurchaseMasterData($purchaseInvoiceId);
                $result['purchaseDetails'] = $this->purchaseinvoicemastermodel->getPurchaseDetails($purchaseInvoiceId);
                $result['grandWeightValue']=$this->purchaseinvoicemastermodel->getGrandTotalWeight($purchaseInvoiceId);
                $result['grandBrokerageValue']=$this->purchaseinvoicemastermodel->getTotalBrokerageFromDetail($purchaseInvoiceId);
                $result['grandServiceTaxValue']=$this->purchaseinvoicemastermodel->getTotalServiceTaxFromDetail($purchaseInvoiceId);
                $result['totalNoOfBags']=$this->purchaseinvoicemastermodel->getTotalBagNo($purchaseInvoiceId);
             
                
                $page = 'purchase_invoice/manage_purchase.php';
            } else {
                $headercontent['mode'] = "Add";
                $result['purchaseMaster'] = "";
                $page = 'purchase_invoice/add_purchase.php';
            }

           
            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }

    /**
     * @method addPurchaseDetails
     * @param type $name Description
     * @description adding new purchase details to existing purchase master
     */
    public function addPurchaseDetails() {

        $session = sessiondata_method();
        //echo($this->uri->segment(4)); exit;
        $pMasterId = "";
        if ($this->session->userdata('logged_in')) {
            if ($this->uri->segment(4) === FALSE) {
                $pMasterId = 0;
            } else {
                $pMasterId = $this->uri->segment(4);
                $transcost = $this->uri->segment(6);
            }
        

            $headercontent['warehouse'] = $this->warehousemastermodel->warehouselist();
            $headercontent['grade'] = $this->grademastermodel->gradelist();
            $headercontent['garden'] = $this->gardenmastermodel->gardenlist();
            $headercontent['teagroup'] = $this->purchaseinvoicemastermodel->teagrouplist();
            $headercontent['location'] = $this->locationmastermodel->loactionmasterlist();
            $headercontent['serviceTax'] = $this->purchaseinvoicemastermodel->getCurrentservicetax($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');
            $headercontent['vatpercentage'] = $this->purchaseinvoicemastermodel->getCurrentvatrate($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');
            $headercontent['cstRate'] = $this->purchaseinvoicemastermodel->getCurrentcstrate($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');
            $headercontent['pmstId'] = $pMasterId;
            $headercontent['transcost'] = $transcost;
            $headercontent['purchasetype'] = $this->purchaseinvoicemastermodel->getPurchaseType($pMasterId);
            $headercontent['vocherdata'] = $this->purchaseinvoicemastermodel->getVoucherData($pMasterId);
          


            $result = "";
            $page = 'purchase_invoice/add_purchase_details.php';
            $header = '';


            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }

    /**
     * @method updatePurchaseDetail
     * @param type $name post value of PurchaseDetailsForEdit
     */
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
        $stamp = $this->input->post('stamp');
        $gross = $this->input->post('gross');
        $brokerage = $this->input->post('brokerage');
        $gpNumber = $this->input->post('GPnumber');
        $gpDate = ($this->input->post('gpDate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('gpDate'))));
        $price = $this->input->post('price');
        $transPortCost = $this->input->post('transPortCost');
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
        $rateType = $this->input->post('rateType');
        $rateTypeAmt = $this->input->post('rateTypeAmount');
        $rateTypeId = $this->input->post('rateTypeId');
        $serviceTaxId = $this->input->post('servicetaxId');
        $serviceTaxAmount = $this->input->post('serviceTaxAmount');
        $totalWeight = $this->input->post('totalWeight');
        $totalCost = $this->input->post('totalDtlCost');
        $teaCostPrKg = $this->input->post('teaCostPrKg');

        $costOfTea = ($totalWeight * $price);
        
        $voucherdata['voucherMastId'] = $voucherMasterId;
        $voucherdata['vendor_id'] = $vendorId;
        

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
        $data['stamp'] = $stamp;
        $data['gross'] = $gross;
        $data['brokerage'] = $brokerage;
        $data['total_weight'] = $totalWeight;
        $data['rate_type_value'] = $rateTypeAmt;
        $data['price'] = $price;
        $data['service_tax'] = $serviceTaxAmount;
        $data['total_value'] = $totalCost;
        $data['chest_from'] = NULL;
        $data['chest_to'] = NULL;
        $data['value_cost'] = $costOfTea; //[bagsQty*price]
        $data['net'] = null;
        $data['rate_type'] = $rateType;
        $data['rate_type_id'] = $rateTypeId;
        $data['service_tax_id'] = $serviceTaxId;
        $data['teagroup_master_id'] = $group;
        $data['cost_of_tea'] = $teaCostPrKg;
        $data['transportation_cost'] = $transPortCost;

        $bagData['sampleBag'] = $sampleBag; //array
        // $NormalbagData['normalBagId']=$normalBagid;

        $NormalbagData['purchasedtlid'] = $purchaseDetailId;
        $NormalbagData['bagtypeid'] = 1;
        $NormalbagData['no_of_bags'] = $normalBag;
        $NormalbagData['net'] = $nomalBagQty;
        $NormalbagData['chestSerial'] = $normalBagChest;
        $NormalbagData['actual_bags'] = $normalBag;
       



        $update = $this->purchaseinvoicemastermodel->updatePurchaseDetailData($data, $bagData, $NormalbagData,$voucherdata);

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
     

        $data['id'] = $PurchaseMasterId;
        $data['purchase_invoice_number'] = $purchaseInvoiceNumber;
        $data['purchase_invoice_date'] = $invoiceDate;
        $data['auctionareaid'] = $auctionarea;
        $data['vendor_id'] = $vendor;
        $data['cn_no'] = $cnNo;
        $data['transporter_id'] = $transporterid;
        $data['voucher_master_id'] = $voucherMastId; 
        $data['sale_number'] = $saleNo;
        $data['sale_date'] = $saleDate;
        $data['promt_date'] = $promptDate;
        $data['from_where'] = $purchaseType;

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
    $otherCharges = $this->input->post('othercharge');
    $roundOff=  $this->input->post('roundoff');
    $totalCost =  $this->input->post('totCost');
    
  //  echo ('totalCost :'.$totalCost);
    
    $update=array();
    $update['other_charges']=($otherCharges==""?0:$otherCharges);
    $update['round_off']=($roundOff==""?0:$roundOff);
    $update['total']=($totalCost==""?0:$totalCost);
   
    /*echo('<pre>');
    print_r($update);
    echo('</pre>');*/
    
    $otherChargesUpdate = $this->purchaseinvoicemastermodel->updateOtherCharges($masterId,$update,$voucherMastid,$vendorId);
    if($otherChargesUpdate){
        echo('1');
    }else{
        echo('0');
    }
}
    /**
     * @method  addNewPurchaseDetails
     * @param type $name Description 
     * @return boolean Description 
     * @date 27/08/2015
     */
    public function addNewPurchaseDetails() {
        $sampleBag = array();
        $data = array();
        $bagData = array();
        $voucherdata=array();
        $costOfTea = 0;

        $purchaseMasterId = $this->input->post('PurchaseMasterId');
        $purchaseType = $this->input->post('PurchaseType');
        
        $vMastid = $this->input->post('VouchrMastId'); // added on 31.05.2016
        $vendor_id = $this->input->post('vendor_id'); // added on 31.05.2016
        
        $lotnumber = $this->input->post('lotnumber');
        $doNumber = $this->input->post('doNumber');
        $doDate = ($this->input->post('doDate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('doDate'))));
        $invoiceNumber = $this->input->post('invoice');
        $stamp = $this->input->post('stamp');
        $gross = $this->input->post('gross');
        $brokerage = $this->input->post('brokerage');
        $gpNumber = $this->input->post('GPnumber');
        $gpDate = ($this->input->post('gpDate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('gpDate'))));
        $price = $this->input->post('price');
        $transCost = $this->input->post('transCost');
        $group = $this->input->post('group');
        $location = $this->input->post('locationId');
        $garden = $this->input->post('garden');
        $grade = $this->input->post('grade');
        $wareHouse = $this->input->post('warehouse');

        $normalBagid = $this->input->post('normalBagId');
        $normalBag = $this->input->post('NormalBags');
        $nomalBagQty = $this->input->post('NormalBagQtys');
        $normalBagChest = $this->input->post('normalBagChest');
        $sampleBag = $this->input->post('sampleBags');
        $rateType = $this->input->post('rateType');
        $rateTypeAmt = $this->input->post('rateTypeAmount');
        $rateTypeId = $this->input->post('rateTypeId');
        $serviceTaxId = $this->input->post('servicetaxId');
        $serviceTaxAmount = $this->input->post('serviceTaxAmount');
        $totalWeight = $this->input->post('totalWeight');
        $totalCost = $this->input->post('totalDtlCost');
        $teaCostPrKg = $this->input->post('teaCostPrKg');

        $costOfTea = ($totalWeight * $price);
        
        
        $vdata['voucherMastId'] = $vMastid;
        $vdata['vendor_id'] = $vendor_id;
    
        
            $purchType = $purchaseType;
        $data['purchase_master_id'] = $purchaseMasterId;
        //$data['purchType']= $purchaseType;
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
        $data['stamp'] = $stamp;
        $data['gross'] = $gross;
        $data['brokerage'] = $brokerage;
        $data['total_weight'] = $totalWeight;
        $data['rate_type_value'] = $rateTypeAmt;
        $data['price'] = $price;
        $data['service_tax'] = $serviceTaxAmount;
        $data['total_value'] = $totalCost;
        $data['chest_from'] = NULL;
        $data['chest_to'] = NULL;
        $data['value_cost'] = $costOfTea; //[bagsQty*price]
        $data['net'] = null;
        $data['rate_type'] = $rateType;
        $data['rate_type_id'] = $rateTypeId;
        $data['service_tax_id'] = $serviceTaxId;
        $data['teagroup_master_id'] = $group;
        $data['cost_of_tea'] = $teaCostPrKg;
        $data['transportation_cost'] = $transCost;

        /**sampleBag***/
        $bagData['sampleBag'] = $sampleBag; //array
       
        /***Nomal Bag Adding***/
        $NormalbagData['bagtypeid'] = 1;
        $NormalbagData['no_of_bags'] = $normalBag;
        $NormalbagData['net'] = $nomalBagQty;
        $NormalbagData['chestSerial'] = $normalBagChest;
        $NormalbagData['actual_bags'] = $normalBag;
      
        /*echo "<pre>";
        print_r($data);
        echo "</pre>";
       exit;*/


        $update = $this->purchaseinvoicemastermodel->insertNewPurchaseDetail($data,$purchType, $bagData, $NormalbagData,$vdata);

        if ($update == TRUE) {
            echo '1';
        } else {
            echo '0';
        }
    }
    
    /**
     * @method createDetails
     * @param null $name Description
     * @return DetailshtmlPage
     */
    public function createDetails(){
        
        $session = sessiondata_method();
        $divNumber = $this->input->post('divNumber');
        $typeOfPurchase =  $this->input->post('purType');
        $transCost =  $this->input->post('transcost');
        
         if ($this->session->userdata('logged_in')) {
           
           $result['warehouse'] = $this->warehousemastermodel->warehouselist();
           $result['grade'] = $this->grademastermodel->gradelist();
           $result['garden'] = $this->gardenmastermodel->gardenlist();
           $result['teagroup'] = $this->purchaseinvoicemastermodel->teagrouplist();
           $result['location'] = $this->locationmastermodel->loactionmasterlist();
           $result['serviceTax'] = $this->purchaseinvoicemastermodel->getCurrentservicetax($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');
           $result['vatpercentage'] = $this->purchaseinvoicemastermodel->getCurrentvatrate($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');
           $result['cstRate'] = $this->purchaseinvoicemastermodel->getCurrentcstrate($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');
           $result['divnumber']=$divNumber;
           $result['purchaseType']=$typeOfPurchase;
           $result['transcost'] = $transCost;
           
           
           $page = 'purchase_invoice/purchaseDtlAdd.php';
           
            $this->load->view($page, $result);
           
         }else {
            redirect('login', 'refresh');
        }
             
             
         

        
    }
    /**
 * @method checkExistPurchaseInvoice
 * @param 
 * @return boolean Description
 * @date 12-01-2016 
 */
   public function checkExistPurchaseInvoice(){
       // $data="0";
        $purchaseInvoice = $this->input->post('purchaseInvoiceNo');
         $result = $this->purchaseinvoicemastermodel->checkExistingInvoice($purchaseInvoice);
         if($result==TRUE){
             echo "1";
         }
         else{
             echo "0";
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
        
       
       
        
       
       /* $pMaster=array();
        $pMaster['purchase_invoice_number']=$searcharray['taxinvoice'];
        $pMaster['purchase_invoice_date']=date('Y-m-d',  strtotime($searcharray['taxinvoicedate']));
        $pMaster['transfer_date']= NULL;
        $pMaster['auctionareaid']=$searcharray['auctionArea'];
        $pMaster['vendor_id']=$searcharray['vendor'];
        $pMaster['voucher_master_id']=57;
        $pMaster['sale_number']=$searcharray['salenumber'];
        $pMaster['sale_date']=date('Y-m-d',  strtotime($searcharray['saledate']));
        $pMaster['promt_date']=date('Y-m-d',  strtotime($searcharray['promtdate']));
        $pMaster['cn_no']=$searcharray['cnNo'];
        $pMaster['transporter_id']=$searcharray['transporterid'];
        $pMaster['tea_value']=$searcharray['txtTeaValue'];
        $pMaster['brokerage']=$searcharray['txtBrokerageTotal'];
        $pMaster['service_tax']=$searcharray['txtServiceTax'];
        $pMaster['total_cst']=$searcharray['txtCstTotal'];
        $pMaster['total_vat']=$searcharray['txtVatTotal'];
        $pMaster['stamp']=$searcharray['txtStampTotal'];
        $pMaster['other_charges']=$searcharray['txtOtherCharges'];
        $pMaster['round_off'] = $searcharray['txtRoundOff'];
        $pMaster['total']=$searcharray['txtTotalPurchase'];
        $pMaster['company_id']=$session['company'];
        $pMaster['year_id']=$session['yearid'];
        $pMaster['from_where']=$searcharray['purchasetype'];
        */
        
        
        
        $totalDetails =count($searcharray['txtLot']);
        
         if($totalDetails>0){
            //$STATUS=$this->purchaseinvoicemastermodel->insertNewPurchaseData($pMaster,$searcharray);
            $STATUS=$this->purchaseinvoicemastermodel->insertNewPurchaseData($voucherMaster,$searcharray);
         }else{
             $STATUS=FALSE;
         }
        
        if($STATUS){
            echo 1;
        }else{
            echo 0;
        }
        
        
    }
    
    
    
    /***** old code** */

    function callSamplepage() {

        $result['bagtype'] = $this->bagtypemodel->bagList();

        $page = 'purchase_invoice/sample_view';
        $this->load->view($page, $result);
    }

    public function savedata() {

        $session = sessiondata_method();

        $value['purchase_invoice_number'] = $this->input->post('taxinvoice');
        $value['sale_number'] = $this->input->post('salenumber');
        $value['purchase_invoice_date'] = date("Y-m-d", strtotime($this->input->post('taxinvoicedate')));
        if ($this->input->post('saledate') != '') {
            $value['sale_date'] = date("Y-m-d", strtotime($this->input->post('saledate')));
        } else {
            $value['sale_date'] = null;
        }
        if ($this->input->post('vendor') > 0) {
            $value['vendor_id'] = $this->input->post('vendor');
        }
        if ($this->input->post('promtdate') != '') {
            $value['promt_date'] = date("Y-m-d", strtotime($this->input->post('promtdate')));
        } else {
            $value['promt_date'] = NULL;
        }
        $value['auctionareaid'] = $this->input->post('auctionArea');
        $value['tea_value'] = $this->input->post('teavalueinput');
        $value['brokerage'] = $this->input->post('brokerageinput');
        $value['service_tax'] = $this->input->post('servicetaxinput');
        $value['total_vat'] = $this->input->post('calculatevatinput');
        $value['total_cst'] = $this->input->post('calculatecstinput');
        $value['chestage_allowance'] = $this->input->post('chestallow');
        $value['stamp'] = $this->input->post('stampcharge');
        $value['total'] = $this->input->post('totalinput');
        $value['company_id'] = $session['company'];
        $value['year_id'] = $session['yearid'];
        $value['from_where'] = $this->input->post('purchasetype');
        $status = $this->purchaseinvoicemastermodel->saveInvoicemaster($value);
        $lotarr = ($this->input->post('detaillot'));
        $count = (count($lotarr));
        $doarr = ($this->input->post('detaildo'));
        $doDatearr = ($this->input->post('detaildodate'));
        $invoicearr = ($this->input->post('detailinvoice'));
        $warehouseidarr = ($this->input->post('detailwarehouseid'));
        $gardenidarr = ($this->input->post('detailgardenid'));
        $gradeidarr = ($this->input->post('detailgradeid'));
        $gpnoidarr = ($this->input->post('detailgpno'));
        $dtarr = $this->input->post('detaildate');
        $stamparr = ($this->input->post('detailstamp'));
        $grossarr = ($this->input->post('detailgross'));
        $brokarr = ($this->input->post('detaillistbrokerage'));
        $vatarr = ($this->input->post('detailvat'));
        $pricearr = ($this->input->post('detailprice'));
        $staxarr = ($this->input->post('detailstax'));
        $valuearr = ($this->input->post('detailvalue'));
        $listtotalarr = ($this->input->post('detaillisttotal'));
        $listtotalweightarr = ($this->input->post('detaillisttweight'));
        $ratetypearr = ($this->input->post('rate_type'));
        $ratetypevaluearr = ($this->input->post('detailvat'));
        $ratetypeidarr = ($this->input->post('rate_type_id'));
        $servicetaxidarr = ($this->input->post('stax_id'));
        $detailteagroupidarr = ($this->input->post('detailteagroupid'));
        $detailLocationidArr = ($this->input->post('detaillocationid'));


        for ($i = 0; $i < $count; $i++) {
            $value_detail['purchase_master_id'] = $status;
            $value_detail['lot'] = $lotarr[$i];
            $value_detail['do'] = $doarr[$i];
            if ($doDatearr[$i] != '') {
                $value_detail['doRealisationDate'] = date("Y-m-d", strtotime($doDatearr[$i]));
            } else {
                $value_detail['doRealisationDate'] = NULL;
            }
//abhik
            $value_detail['invoice_number'] = $invoicearr[$i];
            if ($gardenidarr[$i] > 0) {
                $value_detail['garden_id'] = $gardenidarr[$i];
            }
            if ($gradeidarr[$i] > 0) {
                $value_detail['grade_id'] = $gradeidarr[$i];
            }
            if ($warehouseidarr[$i] > 0) {
                $value_detail['warehouse_id'] = $warehouseidarr[$i];
            }
            $value_detail['gp_number'] = $gpnoidarr[$i];
            if ($dtarr[$i] != '') {
                $value_detail['date'] = date("Y-m-d", strtotime($dtarr[$i]));
            } else {
                $value_detail['date'] = NULL;
            }
            //$value_detail['package'] = $packagearr[$i];
            $value_detail['stamp'] = $stamparr[$i];
            $value_detail['gross'] = $grossarr[$i];
            $value_detail['brokerage'] = $brokarr[$i];
            $value_detail['total_weight'] = $listtotalweightarr[$i];
            //$value_detail['vat']= $vatarr[$i];
            $value_detail['price'] = $pricearr[$i];
            $value_detail['service_tax'] = $staxarr[$i];
            $value_detail['value_cost'] = $valuearr[$i];
            $value_detail['total_value'] = $listtotalarr[$i];
            /* $value_detail['chest_from'] = $chfromarr[$i];
              $value_detail['chest_to'] = $chtoarr[$i];
              $value_detail['net'] = $netarr[$i]; */
            $value_detail['rate_type'] = $ratetypearr[$i];
            $value_detail['rate_type_value'] = $ratetypevaluearr[$i];
            $value_detail['rate_type_id'] = $ratetypeidarr[$i];
            $value_detail['service_tax_id'] = $servicetaxidarr[$i];
            $value_detail['teagroup_master_id'] = $detailteagroupidarr[$i];
            // $value_detail['location_id']=$detaillocationid[$i]


            $status2 = $this->purchaseinvoicemastermodel->saveInvoicedetail($value_detail);


            $value_item['grade_id'] = $gradeidarr[$i];
            $value_item['garden_id'] = $gardenidarr[$i];
            $value_item['invoice_number'] = $invoicearr[$i];
            //$value_item['package'] = $packagearr[$i];
            //$value_item['net'] = $netarr[$i];
            $value_item['gross'] = $grossarr[$i];
            $value_item['bill_id'] = $status;
            $value_item['from_where'] = $this->input->post('purchasetype');
            $statusitem = $this->purchaseinvoicemastermodel->saveItemamster($value_item);

            /*             * stockupdate for SB 26/05/2015** */
            if ($this->input->post('purchasetype') == 'SB') {
                $value_stock['purchase_inv_mst_id'] = $status;
                $value_stock['purchase_inv_dtlid'] = $status2;
                $value_stock['locationId'] = $detailLocationidArr[$i];
                $value_stock['in_Stock'] = "Y";
                $value_stock['typeofpurchase'] = "SB";
                $value_stock['companyid'] = $session['company'];
                $value_stock['yearid'] = $session['yearid'];
                $statusStock = $this->purchaseinvoicemastermodel->saveStockForSB($value_stock);
            }
            /*             * stockupdate for SB** */

            /* Bagdetails insertion */
            $samplenamearr = $this->input->post('detailsamplename');
            $samplenetarr = $this->input->post('detailsamplenet');
            $bagtypeIdsArray = $this->input->post('bagtypeIds');
            $chestvaluesArray = $this->input->post('chestvalues');


            $arrsample = explode(',', $samplenamearr[$i]);
            $arrsamplenet = explode(',', $samplenetarr[$i]);
            $bagIds = explode(',', $bagtypeIdsArray[$i]);
            $chestvalues = explode('~', $chestvaluesArray[$i]);

            $sample = 0;

            foreach ($arrsample as $number) {

                $samplevalue['purchasedtlid'] = $status2;
                $samplevalue['bagtypeid'] = $bagIds[$sample];
                $samplevalue['no_of_bags'] = $number;
                $samplevalue['net'] = $arrsamplenet[$sample];
                $samplevalue['chestSerial'] = $chestvalues[$sample];
                $samplevalue['actual_bags'] = $number; //change will be made from shortage module.


                if ($number != '') {
                    $status3 = $this->purchaseinvoicemastermodel->saveInvoiceBagDetails($samplevalue);
                }$sample++;
            }
        }
        /** bag detals insertion* */
        $lastinsertdata = $this->purchaseinvoicemastermodel->lastvoucherid();

        if (count($lastinsertdata) > 0) {
            $lastid = $lastinsertdata[0]->id;
            $lastyear = $lastinsertdata[0]->year;
        } else {
            $lastyear = 0;
        }
        $currentyear = date("Y");


        if ($lastyear == $currentyear) {
            if ($lastid != '') {
                $currentid = ($lastid) + 1;
            } else {
                $currentid = 1;
            }

            if ($currentid <= 9) {
                $currentid = '0000' . $currentid;
            } elseif ($currentid <= 99) {
                $currentid = '000' . $currentid;
            } elseif ($currentid <= 999) {
                $currentid = '00' . $currentid;
            } elseif ($currentid <= 9999) {
                $currentid = '0' . $currentid;
            } else {
                $currentid = $currentid;
            }
        } else {
            $currentid = '0001';
        }
        // $this->load->helper('sessiondata_helper');



        $year = $session['startyear'] . '-' . $session['endyear'];

        $valuevoucher['voucher_number'] = "PR/" . $currentid . $year;
        $valuevoucher['voucher_date'] = date("Y-m-d", strtotime($this->input->post('taxinvoicedate')));
        $valuevoucher['narration'] = "Purchase Invoice Number " . $this->input->post('taxinvoice') . $this->input->post('taxinvoice') . $valuevoucher['voucher_date'];

        $lastserial = $this->purchaseinvoicemastermodel->getserialnumber($session['company'], $session['yearid']);
        if (count($lastserial) > 0) {
            $valuevoucher['serial_number'] = ($lastserial[0]->serial_number) + 1;
        } else {
            $valuevoucher['serial_number'] = 1;
        }
        $valuevoucher['transaction_type'] = "PR";
        $valuevoucher['company_id'] = $session['company'];
        $valuevoucher['created_by'] = $session['user_id'];
        $valuevoucher['year_id'] = $session['yearid'];
        $status4 = $this->purchaseinvoicemastermodel->insertVoucher($valuevoucher);

        if ($value_detail['rate_type'] == 'V') {
            $amount1 = ($value['tea_value'] + $value['brokerage'] + $value['service_tax'] + $value['stamp']) - $value['chestage_allowance'];
            $valuevoucherdetail1['voucher_master_id'] = $status4;
            $valuevoucherdetail1['account_master_id'] = 6;
            $valuevoucherdetail1['voucher_amount'] = $amount1;
            $valuevoucherdetail1['is_debit'] = "Y";
            $status5 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail1);

            $amount2 = $value['total_vat'];
            $valuevoucherdetail2['voucher_master_id'] = $status4;
            $valuevoucherdetail2['account_master_id'] = 5;
            $valuevoucherdetail2['voucher_amount'] = $amount2;
            $valuevoucherdetail2['is_debit'] = "Y";
            $status6 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail2);

            $amount3 = $value['total'];
            $vendorAcc = $this->purchaseinvoicemastermodel->getVendorAccount($value['vendor_id']);
            $valuevoucherdetail3['voucher_master_id'] = $status4;
            $valuevoucherdetail3['account_master_id'] = $vendorAcc[0]->id;
            $valuevoucherdetail3['voucher_amount'] = $amount3;
            $valuevoucherdetail3['is_debit'] = "N";
            $status7 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail3);
        }
        if ($value_detail['rate_type'] == 'C') {
            $amount1 = ($value['tea_value'] + $value['brokerage'] + $value['service_tax'] + $value['stamp'] + $value['total_cst']) - $value['chestage_allowance'];
            $valuevoucherdetail1['voucher_master_id'] = $status4;
            $valuevoucherdetail1['account_master_id'] = 6;
            $valuevoucherdetail1['voucher_amount'] = $amount1;
            $valuevoucherdetail1['is_debit'] = "Y";
            $status5 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail1);

            $amount3 = $value['total'];
            $vendorAcc = $this->purchaseinvoicemastermodel->getVendorAccount($value['vendor_id']);
            $valuevoucherdetail3['voucher_master_id'] = $status4;
            $valuevoucherdetail3['account_master_id'] = $vendorAcc[0]->id;
            $valuevoucherdetail3['voucher_amount'] = $amount3;
            $valuevoucherdetail3['is_debit'] = "N";
            $status7 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail3);
        }

        $bill['bill_id'] = $status;
        $bill['bill_amount'] = $value['total'];
        $bill['company_id'] = $session['company'];
        $bill['year_id'] = $session['yearid'];
        $bill['voucher_id'] = $status4;
        $bill['due_amount'] = $value['total'];
        $bill['from_where'] = "PR";
        $status8 = $this->purchaseinvoicemastermodel->insertVendorBill($bill);
        $status9 = $this->purchaseinvoicemastermodel->updateVoucherid($status4, $status);



        //header('Location: '.base_url().'purchaseinvoice/showlistpurchaseinvoice');

        $session = sessiondata_method();
        $sess_array = array(
            'vendor' => $value['vendor_id'],
            'startdate' => $session['startyear'] . '-04-01',
            'enddate' => $session['endyear'] . '-03-31',
            'pryear' => $session['yearid'],
            'prcom' => $session['company']
        );

        $this->session->set_userdata('purchase_invoice_list_detail', $sess_array);
        redirect('purchaseinvoice', 'refresh');
    }

    public function getlistpurchaseinvoice() {
        $session = sessiondata_method();

        $vendor = $this->input->post('vendor');
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        $company = $session['company'];
        $year = $session['yearid'];


        $sess_array = array(
            'vendor' => $vendor,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'pryear' => $year,
            'prcom' => $company
        );

        $this->session->set_userdata('purchase_invoice_list_detail', $sess_array);


        exit;
    }

    /**
     * @method edit
     * @desc for edit purchase invoice.
     */
    public function edit() {
        $uriarr = ($this->uri->ruri_to_assoc(3));

        $session = sessiondata_method();
        $headercontent['vendor'] = $this->vendormastermodel->vendorlist($session);
        $headercontent['warehouse'] = $this->warehousemastermodel->warehouselist();
        $headercontent['grade'] = $this->grademastermodel->gradelist();
        $headercontent['garden'] = $this->gardenmastermodel->gardenlist();
        $headercontent['teagroup'] = $this->purchaseinvoicemastermodel->teagrouplist();
        $headercontent['location'] = $this->locationmastermodel->loactionmasterlist();
        $headercontent['auctionarea'] = $this->auctionareamodel->aucareaList();
        $result1 = $this->purchaseinvoicemastermodel->getCurrentservicetax($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');
        $result2 = $this->purchaseinvoicemastermodel->getCurrentvatrate($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');
        $result3 = $this->purchaseinvoicemastermodel->getCurrentcstrate($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');
        $result['servicetax'] = $result1;
        $result['vatrate'] = $result2;
        $result['cstrate'] = $result3;
        $result['invoiceid'] = $uriarr['invoice'];
        $result['saveddata'] = $this->purchaseinvoicemastermodel->editdata($uriarr['invoice']);


        $page = 'purchase_invoice/edit_view';
        $header = '';
        createbody_method($result, $page, $header, $session, $headercontent);
    }

    public function getlistingindetail() {
        $session = sessiondata_method();

        $invoiceid = $this->input->post('id');
        $result = $this->purchaseinvoicemastermodel->getPurchaselistingdetaildata($invoiceid, $session['yearid'], $session['company']);

        $row = '';

        foreach ($result as $record) {
            $do = '';
            if ($record->do != '') {
                $do = $record->do;
            }
            $stamp = '';
            if ($record->stamp != '') {
                $stamp = $record->stamp;
            }
            $brokerage = '';
            if ($record->brokerage != '') {
                $brokerage = $record->brokerage;
            }
            $gpnumber = '';
            if ($record->gp_number != '') {
                $gpnumber = $record->gp_number;
            }
            $date = '';
            if ($record->date != '') {
                $date = $record->date;
            }
            $vat = '';
            $type = '';
            if ($record->rate_type != '') {
                if ($record->rate_type == 'V')
                    $type = 'VAT';
                else
                    $type = 'CST';
            }

            if ($record->rate_type_value != '') {

                $vat = $type . ' => ' . $record->rate_type_value;
            }
            $stax = '';
            if ($record->service_tax != '') {
                $stax = $record->service_tax;
            }

            $row .= '<tr>' .
                    '<td>'
                    . $record->lot . '<br/>' . $do .
                    '</td>' .
                    '<td>' .
                    $record->invoice_number .
                    '</td>' .
                    '<td>' .
                    $record->garden_name . '<br/>' . $record->name .
                    '</td>' .
                    '<td>'
                    . $record->grade . '<br/>' .
                    '</td>' .
                    '<td>' . $gpnumber . '<br/>' . date("d-m-Y", strtotime($date))
                    . '<input type="hidden"  name="date[]" value="' . $date . '"/>' .
                    '</td>' .
                    '<td>'
                    . $record->BagTypes . '<br/>' . $record->NumbersOfBags . '</br>' . $record->BgKgs .
                    '</td>' .
                    '<td>'
                    . $record->gross . '<br/>' . $brokerage .
                    '</td>' .
                    '<td>'
                    . $record->total_weight . '<br/>' . $vat .
                    '</td>' .
                    '<td>'
                    . $record->price . '<br/>' . $stax .
                    '</td>' .
                    '<td>'
                    . $record->value_cost .
                    '</td>' .
                    '<td>' . $record->total_value . '</td></tr>';
        }
        echo $row;
    }

    function update() {

        $uriarr = ($this->uri->ruri_to_assoc(3));
        $session = sessiondata_method();
        $value['id'] = $uriarr['invoice'];
        $value['purchase_invoice_number'] = $this->input->post('taxinvoice');
        $value['sale_number'] = $this->input->post('salenumber');
        $value['purchase_invoice_date'] = date("Y-m-d", strtotime($this->input->post('taxinvoicedate')));
        $value['sale_date'] = date("Y-m-d", strtotime($this->input->post('saledate')));
        if ($this->input->post('vendor') > 0) {
            $value['vendor_id'] = $this->input->post('vendor');
        }
        $value['promt_date'] = date("Y-m-d", strtotime($this->input->post('promtdate')));
        $value['tea_value'] = $this->input->post('teavalueinput');
        $value['brokerage'] = $this->input->post('brokerageinput');
        $value['service_tax'] = $this->input->post('servicetaxinput');
        //$value['type'] =  $this->input->post('type');
        //$value['rate_type_value'] = $this->input->post('optionrate');
        $value['total_cst'] = $this->input->post('calculatecstinput');
        $value['total_vat'] = $this->input->post('calculatevatinput');
        $value['chestage_allowance'] = $this->input->post('chestallow');
        $value['stamp'] = $this->input->post('stampcharge');
        $value['total'] = $this->input->post('totalinput');
        $value['company_id'] = $session['company'];
        $value['year_id'] = $session['yearid'];
        $value['from_where'] = $this->input->post('purchasetype');
        $status = $this->purchaseinvoicemastermodel->updateInvoicemaster($value);

        $this->purchaseinvoicemastermodel->deleteInvoicemaster($uriarr['invoice']);

        // $count = $this->input->post('countdetail');
        $detailtableidarr = ($this->input->post('detailtableid'));

        $lotarr = ($this->input->post('detaillot'));
        $count = (count($lotarr));
        $doarr = ($this->input->post('detaildo'));
        $doDatearr = ($this->input->post('detaildodate'));
        $invoicearr = ($this->input->post('detailinvoice'));
        $warehouseidarr = ($this->input->post('detailwarehouseid'));
        $gardenidarr = ($this->input->post('detailgardenid'));
        $gradeidarr = ($this->input->post('detailgradeid'));
        $gpnoidarr = ($this->input->post('detailgpno'));
        $dtarr = $this->input->post('detaildate');
        $chfromarr = ($this->input->post('detailchfrom'));
        $stamparr = ($this->input->post('detailstamp'));
        $grossarr = ($this->input->post('detailgross'));
        $brokarr = ($this->input->post('detaillistbrokerage'));
        $vatarr = ($this->input->post('detailvat'));
        $pricearr = ($this->input->post('detailprice'));
        $staxarr = ($this->input->post('detailstax'));
        $valuearr = ($this->input->post('detailvalue'));
        $listtotalarr = ($this->input->post('detaillisttotal'));
        $listtotalweightarr = ($this->input->post('detaillisttweight'));
        $ratetypearr = ($this->input->post('rate_type'));
        $ratetypevaluearr = ($this->input->post('detailvat'));
        $ratetypeidarr = ($this->input->post('rate_type_id'));
        $servicetaxidarr = ($this->input->post('stax_id'));
        $detailteagroupidarr = ($this->input->post('detailteagroupid'));
        $detailLocationidArr = ($this->input->post('detailLocationid'));
        $detailTransporterSentStatus = ($this->input->post('detailsDoSentStatus'));


        for ($i = 0; $i < $count; $i++) {


            $value_detail['purchase_master_id'] = $uriarr['invoice'];
            $value_detail['lot'] = $lotarr[$i];
            $value_detail['do'] = $doarr[$i];
            if ($doDatearr[$i] != '') {
                $value_detail['doRealisationDate'] = date('Y-m-d', strtotime($doDatearr[$i]));
            } else {
                $value_detail['doRealisationDate'] = NULL;
            }
            $value_detail['invoice_number'] = $invoicearr[$i];
            if ($gardenidarr[$i] > 0) {
                $value_detail['garden_id'] = $gardenidarr[$i];
            }
            if ($gradeidarr[$i] > 0) {
                $value_detail['grade_id'] = $gradeidarr[$i];
            }
            if ($warehouseidarr[$i] > 0) {
                $value_detail['warehouse_id'] = $warehouseidarr[$i];
            }
            $value_detail['gp_number'] = $gpnoidarr[$i];
            if ($dtarr[$i] != '') {
                $value_detail['date'] = date("Y-m-d", strtotime($dtarr[$i]));
            } else {
                $value_detail['date'] = NULL;
            }
            //$value_detail['package'] = $packagearr[$i];
            $value_detail['stamp'] = $stamparr[$i];
            $value_detail['gross'] = $grossarr[$i];
            $value_detail['brokerage'] = $brokarr[$i];
            $value_detail['total_weight'] = $listtotalweightarr[$i];
            $value_detail['price'] = $pricearr[$i];
            $value_detail['service_tax'] = $staxarr[$i];
            $value_detail['value_cost'] = $valuearr[$i];
            $value_detail['total_value'] = $listtotalarr[$i];
            $value_detail['rate_type'] = $ratetypearr[$i];
            $value_detail['rate_type_value'] = $ratetypevaluearr[$i];
            $value_detail['rate_type_id'] = $ratetypeidarr[$i];
            $value_detail['service_tax_id'] = $servicetaxidarr[$i];
            $value_detail['teagroup_master_id'] = $detailteagroupidarr[$i];


            $newdetails_flag_bagdetails = 0;
            if ($detailtableidarr[$i] == 0) {
                $status2 = $this->purchaseinvoicemastermodel->saveInvoicedetail($value_detail);
                if ($this->input->post('purchasetype') == 'SB') {
                    $value_stock['purchase_inv_mst_id'] = $status;
                    $value_stock['purchase_inv_dtlid'] = $status2;
                    $value_stock['locationId'] = $detailLocationidArr[$i];
                    $value_stock['in_Stock'] = "Y";
                    $value_stock['typeofpurchase'] = "SB";
                    $value_stock['companyid'] = $session['company'];
                    $value_stock['yearid'] = $session['yearid'];
                    $this->purchaseinvoicemastermodel->saveStockForSB($value_stock);
                }

                $newdetails_flag_bagdetails = 1;
            } else {
                $status2 = $detailtableidarr[$i];
                if ($this->input->post('purchasetype') == 'SB') {
                    $value_stock['purchase_inv_mst_id'] = $status;
                    $value_stock['locationId'] = $detailLocationidArr[$i];
                    $value_stock['in_Stock'] = "Y";
                    $value_stock['typeofpurchase'] = "SB";
                    $value_stock['companyid'] = $session['company'];
                    $value_stock['yearid'] = $session['yearid'];
                    $this->purchaseinvoicemastermodel->updateStockForSB($status2, $value_stock);
                }
                $this->purchaseinvoicemastermodel->updateInvoicedetail($value_detail, $detailtableidarr[$i]);
                //$delete_insertion_flag=$this->purchaseinvoicemastermodel->deleteBagDetails($detailtableidarr[$i],$detailTransporterSentStatus[$i]);
            }

            $value_item['grade_id'] = $gradeidarr[$i];
            $value_item['garden_id'] = $gardenidarr[$i];
            $value_item['invoice_number'] = $invoicearr[$i];
            //$value_item['package'] = $packagearr[$i];
            //$value_item['net'] = $netarr[$i];
            $value_item['gross'] = $grossarr[$i];
            $value_item['bill_id'] = $status;
            $value_item['from_where'] = $this->input->post('purchasetype');
            $statusitem = $this->purchaseinvoicemastermodel->saveItemamster($value_item);

            if ($newdetails_flag_bagdetails == 0) {
                $samplenamearr = $this->input->post('detailsamplename_' . $detailtableidarr[$i]);
                $samplenetarr = $this->input->post('detailsamplenet_' . $detailtableidarr[$i]);
                $bagtypeIdsArray = $this->input->post('bagtypeIds_' . $detailtableidarr[$i]);
                $chestvaluesArray = $this->input->post('chestvalues_' . $detailtableidarr[$i]);
                $bagDetailId = $this->input->post('bagdtlid_' . $uriarr['invoice']);
            } else {
                $samplenamearr = $this->input->post('detailsamplename');
                $samplenetarr = $this->input->post('detailsamplenet');
                $bagtypeIdsArray = $this->input->post('bagtypeIds');
                $chestvaluesArray = $this->input->post('chestvalues');
                $bagDetailId = $this->input->post('bagdtlid');
            }
            //echo('detailsamplename_'.$detailtableidarr[$i].'[]');
            //echo($samplenamearr);exit;
            //$detailID = $status2;
            if ($newdetails_flag_bagdetails == 0) {
                if ($samplenamearr[$i] != '') {
                    $arrsample = explode('*', $samplenamearr[$i]);
                    $arrsamplenet = explode('*', $samplenetarr[$i]);
                    $arrbagIds = explode('*', $bagtypeIdsArray[$i]);
                    $arrchestvalues = explode('*', $chestvaluesArray[$i]);
                    $arrbagDetailsId = explode(',', $bagDetailId);

                    $sample = 0;


                    foreach ($arrsample as $number) {
                        $samplevalue['purchasedtlid'] = $status2;
                        $samplevalue['no_of_bags'] = $number;
                        $samplevalue['net'] = $arrsamplenet[$sample];
                        $samplevalue['bagtypeid'] = $arrbagIds[$sample];
                        $samplevalue['chestSerial'] = $arrchestvalues[$sample];
                        $samplevalue['id'] = $arrbagDetailsId[$sample];
                        $samplevalue['actual_bags'] = $number;

                        if ($number != '') {
                            if ($arrbagDetailsId[$sample] != 0) {

                                if ($detailTransporterSentStatus[$i] != 'Y') {
                                    $status = $this->purchaseinvoicemastermodel->updateBagDetails($arrbagDetailsId[$sample], $samplevalue);
                                }
                            } else {
                                if ($detailTransporterSentStatus[$i] != 'Y') {
                                    $status3 = $this->purchaseinvoicemastermodel->saveInvoiceBagDetails($samplevalue);
                                }
                            }
                        }$sample++;
                    }
                }
            } else {
                if ($samplenamearr[$i] != '') {
                    $arrsample = explode(',', $samplenamearr[$i]);
                    $arrsamplenet = explode(',', $samplenetarr[$i]);
                    $arrbagIds = explode(',', $bagtypeIdsArray[$i]);
                    $arrchestvalues = explode('~', $chestvaluesArray[$i]);


                    $sample = 0;


                    foreach ($arrsample as $number) {
                        $samplevalue['purchasedtlid'] = $status2;
                        $samplevalue['no_of_bags'] = $number;
                        $samplevalue['net'] = $arrsamplenet[$sample];
                        $samplevalue['bagtypeid'] = $arrbagIds[$sample];
                        $samplevalue['chestSerial'] = $arrchestvalues[$sample];

                        $samplevalue['actual_bags'] = $number;

                        if ($number != '') {
                            //if($arrbagDetailsId[$sample]!=0){
                            // }else{

                            $status3 = $this->purchaseinvoicemastermodel->saveInvoiceBagDetails($samplevalue);


                            //}
                        }$sample++;
                    }
                }
            }//else[]
        }
        $status4 = $this->purchaseinvoicemastermodel->updatedateVoucherMaster($value['purchase_invoice_date'], $this->input->post('voucherid'));
        $del = $this->purchaseinvoicemastermodel->deleteVoucherdetail($this->input->post('voucherid'));

        if ($value_detail['rate_type'] == 'V') {
            $amount1 = ($value['tea_value'] + $value['brokerage'] + $value['service_tax'] + $value['stamp']) - $value['chestage_allowance'];
            $valuevoucherdetail1['voucher_master_id'] = $this->input->post('voucherid');
            $valuevoucherdetail1['account_master_id'] = 6;
            $valuevoucherdetail1['voucher_amount'] = $amount1;
            $valuevoucherdetail1['is_debit'] = "Y";
            $status5 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail1);

            $amount2 = $value['total_vat'];
            $valuevoucherdetail2['voucher_master_id'] = $this->input->post('voucherid');
            $valuevoucherdetail2['account_master_id'] = 5;
            $valuevoucherdetail2['voucher_amount'] = $amount2;
            $valuevoucherdetail2['is_debit'] = "Y";
            $status6 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail2);

            $amount3 = $value['total'];
            $vendorAcc = $this->purchaseinvoicemastermodel->getVendorAccount($value['vendor_id']);
            $valuevoucherdetail3['voucher_master_id'] = $this->input->post('voucherid');
            $valuevoucherdetail3['account_master_id'] = $vendorAcc[0]->id;
            $valuevoucherdetail3['voucher_amount'] = $amount3;
            $valuevoucherdetail3['is_debit'] = "N";
            $status7 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail3);
        }
        if ($value_detail['rate_type'] == 'C') {
            $amount1 = ($value['tea_value'] + $value['brokerage'] + $value['service_tax'] + $value['stamp'] + $value['total_cst']) - $value['chestage_allowance'];
            $valuevoucherdetail1['voucher_master_id'] = $this->input->post('voucherid');
            $valuevoucherdetail1['account_master_id'] = 6;
            $valuevoucherdetail1['voucher_amount'] = $amount1;
            $valuevoucherdetail1['is_debit'] = "Y";
            $status5 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail1);

            $amount3 = $value['total'];
            $vendorAcc = $this->purchaseinvoicemastermodel->getVendorAccount($value['vendor_id']);
            $valuevoucherdetail3['voucher_master_id'] = $this->input->post('voucherid');
            $valuevoucherdetail3['account_master_id'] = $vendorAcc[0]->id;
            $valuevoucherdetail3['voucher_amount'] = $amount3;
            $valuevoucherdetail3['is_debit'] = "N";
            $status7 = $this->purchaseinvoicemastermodel->insertVoucherDetail($valuevoucherdetail3);
        }
        $status8 = $this->purchaseinvoicemastermodel->updatedateBillMaster($this->input->post('voucherid'), $value['total']);

        header('Location: ' . base_url() . 'purchaseinvoice');
    }

    function getTaxlist() {
        $startdate = date("Y-m-d", strtotime($this->input->post('startdate')));
        $enddate = date("Y-m-d", strtotime($this->input->post('enddate')));
        $ratetype = $this->input->post('type');
        $row = '<select id="optionrate" name="optionrate"  class="optionrate" onchange="calculateCurrentVatratetotal()"><option value="0">Select</option>';

        if ($ratetype == 'V') {
            $result = $this->purchaseinvoicemastermodel->getCurrentvatrate($startdate, $enddate);
            if (count($result) > 0) {
                foreach ($result as $value) {
                    $row .= '<option value="' . $value->id . '">' . $value->vat_rate . '</option>';
                }
            }$row .= '</select>';
        }
        if ($ratetype == 'C') {
            $result = $this->purchaseinvoicemastermodel->getCurrentcstrate($startdate, $enddate);
            if (count($result) > 0) {
                foreach ($result as $value) {
                    $row .= '<option value="' . $value->id . '">' . $value->cst_rate . '</option>';
                }
            }$row .= '</select>';
        }

        echo ($row);
        exit;
    }

    function deleteInvoicedetail() {
        $result = $this->purchaseinvoicemastermodel->deleteInvoicedetail($this->input->post('detailid'));
    }

    function deleteRecord() {
        $parentId = $this->input->post('masterid');
        $result = $this->purchaseinvoicemastermodel->deleteRecord($parentId);
    }
    
 
    
    /*Mithilesh on 23.04.2016
     * getting getTransportationCost 
     */
    function getTransportationCost(){
        
        $auctionAreaId = $this->input->post('auctionareaId');
        $transCost =  $this->purchaseinvoicemastermodel->getTransCost($auctionAreaId);
        
      echo json_encode(
                array(
                    "trans_cost"=>$transCost['trans_cost']
                  
                )
                );
       
        
    }
    
    
    
    

}

?>
