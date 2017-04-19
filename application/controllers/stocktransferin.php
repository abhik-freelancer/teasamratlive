<?php

//we need to call PHP's session object to access it through CI
class stocktransferin extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('transportmastermodel', '', TRUE);
        $this->load->model('vendormastermodel', '', TRUE);
        $this->load->model('warehousemastermodel', '', TRUE);
        $this->load->model('grademastermodel', '', TRUE);
        $this->load->model('gardenmastermodel', '', TRUE);
        $this->load->model('purchaseinvoicemastermodel', '', TRUE);
        $this->load->model('stocktransferinmodel', '', TRUE);
        $this->load->model('bagtypemodel', '', TRUE);
        $this->load->model('locationmastermodel', '', TRUE);
    }

    public function index() {

       if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
            
            $cmpnyId = $session['company'];
            $yearId = $session['yearid'];
            $result['stockTransferIn']=$this->stocktransferinmodel->getStocktransfreInList($cmpnyId,$yearId);
            $headercontent='';
            $page = 'stock_transfer_IN/list_view';
            $header = '';
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
        } 
        else {
                $purchaseInvoiceId = $this->uri->segment(4);
                
        }
            $headercontent['transporterlist']=$this->transportmastermodel->transportlist();
            $headercontent['vendor'] = $this->vendormastermodel->vendorlist($session);
            $headercontent['warehouse'] = $this->warehousemastermodel->warehouselist();
            $headercontent['grade'] = $this->grademastermodel->gradelist();
            $headercontent['garden'] = $this->gardenmastermodel->gardenlist();
            $headercontent['teagroup'] = $this->stocktransferinmodel->teagrouplist();
            $headercontent['location'] = $this->locationmastermodel->loactionmasterlist();
           
            if ($purchaseInvoiceId != 0) {
                $headercontent['mode'] = "Edit";
                $result['purchaseMaster'] = $this->stocktransferinmodel->getPurchaseMasterData($purchaseInvoiceId);
                $result['purchaseDetails'] = $this->stocktransferinmodel->getPurchaseDetails($purchaseInvoiceId);
                $result['grandWeightValue']=$this->stocktransferinmodel->getGrandTotalWeight($purchaseInvoiceId);
               
                $page = 'stock_transfer_IN/stocktransferin_manage.php';
                
            } else {
                $headercontent['mode'] = "Add";
                $result['purchaseMaster'] = "";
                $page = 'stock_transfer_IN/add_stock_in.php';
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
               
            }
        

            $headercontent['warehouse'] = $this->warehousemastermodel->warehouselist();
            $headercontent['grade'] = $this->grademastermodel->gradelist();
            $headercontent['garden'] = $this->gardenmastermodel->gardenlist();
            $headercontent['teagroup'] = $this->stocktransferinmodel->teagrouplist();
            $headercontent['location'] = $this->locationmastermodel->loactionmasterlist();
            $headercontent['pmstId'] = $pMasterId;
        
            $result = "";
            $page = 'stock_transfer_IN/add_stocktransferin_detail.php';
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
        $costOfTea = 0;

        $purchaseMasterId = $this->input->post('PurchaseMasterId');
        $purchaseDetailId = $this->input->post('purchaseDetailId');
        $lotnumber = $this->input->post('lotnumber');
        $doNumber = $this->input->post('doNumber');
        $doDate = ($this->input->post('doDate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('doDate'))));
        $invoiceNumber = $this->input->post('invoice');
        $gross = $this->input->post('gross');
        $price = $this->input->post('price');
        $transportationCost = $this->input->post('transPortCost');
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

        $data['id'] = $purchaseDetailId;
        $data['purchase_master_id'] = $purchaseMasterId;
        $data['lot'] = $lotnumber;
        $data['doRealisationDate'] = $doDate;
        $data['do'] = $doNumber;
        $data['invoice_number'] = $invoiceNumber;
        $data['garden_id'] = $garden;
        $data['grade_id'] = $grade;
        $data['location_id'] = $location;
        $data['warehouse_id'] = $wareHouse;
        $data['package'] = null;
        $data['gross'] = $gross;
        $data['total_weight'] = $totalWeight;
        $data['price'] = $price;
        $data['total_value'] = $totalCost;
        $data['chest_from'] = NULL;
        $data['chest_to'] = NULL;
        $data['value_cost'] = $costOfTea; //[bagsQty*price]
        $data['net'] = null;
        $data['teagroup_master_id'] = $group;
        $data['cost_of_tea'] = $teaCostPrKg;
        $data['transportation_cost'] = $transportationCost;
       

        $bagData['sampleBag'] = $sampleBag; //array
        // $NormalbagData['normalBagId']=$normalBagid;

        $NormalbagData['purchasedtlid'] = $purchaseDetailId;
        $NormalbagData['bagtypeid'] = 1;
        $NormalbagData['no_of_bags'] = $normalBag;
        $NormalbagData['net'] = $nomalBagQty;
        $NormalbagData['chestSerial'] = $normalBagChest;
        $NormalbagData['actual_bags'] = $normalBag;
       



        $update = $this->stocktransferinmodel->updatePurchaseDetailData($data, $bagData, $NormalbagData);

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
        $do_to_trans = array();

        $PurchaseMasterId = $this->input->post('PurMasterId');
        $purchaseType = $this->input->post('purchaseType');
        $refrenceNo = $this->input->post('refrenceNo');
        $receiptDt = ($this->input->post('receiptDate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('receiptDate'))));
        $transferDt = ($this->input->post('transferDt') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('transferDt'))));
        $vendor = $this->input->post('vendor');
        $cnNo = $this->input->post('cnNo');
        $challanNo = $this->input->post('challanNo');
        $transporterId = $this->input->post('transporterid');
        
        
        $do_to_trans['transporterId'] = $transporterId;
        $do_to_trans['chalanNumber'] = $challanNo;
        $do_to_trans['chalanDate'] = $receiptDt;
        
  
        $data['id'] = $PurchaseMasterId;
        $data['purchase_invoice_number'] = $refrenceNo;
        $data['purchase_invoice_date'] = $receiptDt;
        $data['transfer_date'] = $transferDt;
        $data['transporter_id'] = $transporterId;
        $data['challan_no'] = $challanNo;
        $data['vendor_id'] = $vendor;
        $data['cn_no'] = $cnNo;
        $data['voucher_master_id'] = NULL; //need to do
        $data['from_where'] = $purchaseType;

        $purchaseMasterSave = $this->stocktransferinmodel->updatePurchaseMaster($data,$do_to_trans);
        if ($purchaseMasterSave) {
            echo('1');
        } else {
            echo('0');
        }
    }

    /**
     * @method  addNewPurchaseDetails
     * @param type $name Description 
     * @return boolean Description 
     * @date 13/05/2015
     */
    public function addNewPurchaseDetails() {
        $sampleBag = array();
        $data = array();
        $bagData = array();
        $costOfTea = 0;

        $purchaseMasterId = $this->input->post('PurchaseMasterId');
        

        $lotnumber = $this->input->post('lotnumber');
        $doNumber = $this->input->post('doNumber');
        $doDate = ($this->input->post('doDate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('doDate'))));
        $invoiceNumber = $this->input->post('invoice');
     
        $gross = $this->input->post('gross');
        $garden = $this->input->post('garden');
        $grade = $this->input->post('grade');
        $group = $this->input->post('group');
        $location = $this->input->post('location');
        $price = $this->input->post('price');
        $transportCost = $this->input->post('transportationCost');
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

        $dototrans = $this->getMasterDataForDoTransporter($purchaseMasterId);
        
        
        $data['purchase_master_id'] = $purchaseMasterId;
        $data['lot'] = $lotnumber;
        $data['doRealisationDate'] = $doDate;
        $data['do'] = $doNumber;
        $data['invoice_number'] = $invoiceNumber;
        $data['garden_id'] = $garden;
        $data['grade_id'] = $grade;
        $data['location_id'] = $location;
        $data['warehouse_id'] = $wareHouse;
        $data['package'] = null;
        $data['gross'] = $gross;
        $data['total_weight'] = $totalWeight;
     
        $data['price'] = $price;
        $data['total_value'] = $totalCost;
        $data['chest_from'] = NULL;
        $data['chest_to'] = NULL;
        $data['value_cost'] = $costOfTea; //[bagsQty*price]
        $data['net'] = null;
        $data['teagroup_master_id'] = $group;
        $data['cost_of_tea'] = $teaCostPrKg;
        $data['transportation_cost'] = $transportCost;

        /**sampleBag***/
        $bagData['sampleBag'] = $sampleBag; //array
       
        /***Nomal Bag Adding***/
        $NormalbagData['bagtypeid'] = 1;
        $NormalbagData['no_of_bags'] = $normalBag;
        $NormalbagData['net'] = $nomalBagQty;
        $NormalbagData['chestSerial'] = $normalBagChest;
        $NormalbagData['actual_bags'] = $normalBag;
      

       


        $update = $this->stocktransferinmodel->insertNewPurchaseDetail($data, $bagData, $NormalbagData ,$dototrans);

        if ($update == TRUE) {
            echo '1';
        } else {
            echo '0';
        }
    }
    
    
    /*@paramgrtmasterDatafordotoTransp
     *@date 09-06-2016
     * Mithilesh
     */
    
       public function getMasterDataForDoTransporter($pMastid){
           $result['do_to_trans'] = $this->stocktransferinmodel->getdotoTransportFromMast($pMastid); 
           return $result['do_to_trans'];
       }
    
    /**
     * @method createDetails
     * @param null $name Description
     * @return DetailshtmlPage
     */
    public function createDetails(){
        
        $session = sessiondata_method();
        $divNumber = $this->input->post('divNumber');
    
        
         if ($this->session->userdata('logged_in')) {
           
           $result['warehouse'] = $this->warehousemastermodel->warehouselist();
           $result['grade'] = $this->grademastermodel->gradelist();
           $result['garden'] = $this->gardenmastermodel->gardenlist();
           $result['teagroup'] = $this->stocktransferinmodel->teagrouplist();
           $result['location'] = $this->locationmastermodel->loactionmasterlist();
           $result['divnumber']=$divNumber;
         
           $page = 'stock_transfer_IN/stockInDtlAdd.php';
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
   public function checkExistingRefrenceNo(){
        $session = sessiondata_method();
        
         $cmpnyId = $session['company'];
         $yearId = $session['yearid'];
       // $data="0";
        $refrenceNo = $this->input->post('refrenceNo');
         $result = $this->stocktransferinmodel->checkExistingRefrence($refrenceNo,$cmpnyId,$yearId);
        
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
        
        $session = sessiondata_method();
        $formData = $this->input->post('formDatas');
        parse_str($formData, $searcharray);
       
     
        $pMaster=array();
        $pMaster['purchase_invoice_number']=$searcharray['refrence_no'];
        $pMaster['purchase_invoice_date']=date('Y-m-d',  strtotime($searcharray['receiptDt']));
        $pMaster['transfer_date']=date('Y-m-d',  strtotime($searcharray['transferDt']));
        $pMaster['auctionareaid']=0;
        $pMaster['vendor_id']=$searcharray['vendor'];
        $pMaster['voucher_master_id']=57;
        $pMaster['sale_number']=null;
        $pMaster['sale_date']=null;
        $pMaster['promt_date']=null;
        $pMaster['cn_no']=$searcharray['cnNo'];
        $pMaster['challan_no']=$searcharray['challanNo'];
        $pMaster['transporter_id']=$searcharray['transporterid'];
        $pMaster['tea_value']=$searcharray['txtTeaValue'];
        $pMaster['brokerage']=0;
        $pMaster['service_tax']=0;
        $pMaster['total_cst']=0;
        $pMaster['total_vat']=0;
        $pMaster['stamp']=null;
        $pMaster['other_charges']=0;
        $pMaster['round_off'] = 0;
        $pMaster['total']=$searcharray['txtTotalPurchase'];
        $pMaster['company_id']=$session['company'];
        $pMaster['year_id']=$session['yearid'];
        $pMaster['from_where']=$searcharray['purchasetype'];
        
        $totalDetails =count($searcharray['txtLot']);
        
         if($totalDetails>0){
            $STATUS=$this->stocktransferinmodel->insertNewPurchaseData($pMaster,$searcharray);
         }else{
             $STATUS=FALSE;
         }
        
        if($STATUS){
            echo 1;
        }else{
            echo 0;
        }
        
        
    }
  
}

?>
