<?php

//we need to call PHP's session object to access it through CI
class gstservicepurchase extends CI_Controller {

    public function __construct() {
        parent::__construct();
          $this->load->model('rawmaterialpurchasemodel', '', TRUE);
          $this->load->model('vendormastermodel', '', TRUE);
          $this->load->model('gsttaxinvoicemodel', '', TRUE); //get gst
          $this->load->model('accountmastermodel', '', TRUE);
          $this->load->model('gstservicepurchasemodel','',TRUE);
     
    }
    /**
     * @method gstRawmaterialPurchase
     * @date 04/07/2017
     * @author Abhik Ghosh<amiabhik@gmail.com>
     */
    public function index() {
        
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {


                $cmpny=$session['company'];
                $year = $session['yearid'];
                
            $result =$this->rawmaterialpurchasemodel->GstServicePurchaseList($cmpny,$year);
            $page = 'gstservicepurchase/list';
            $header = '';
            $headercontent=NULL;
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
        
    }
    /**
     * @method gstAddRawMaterialpurchase
     * @date 04/07/2016 
     */
    public function gstServicePurchaseAdd() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {

                $rawmaterialMasterId = 0;
            } else {
                $rawmaterialMasterId = $this->uri->segment(4);
            }

            $companyId=$session['company'];
            $yearId=$session['yearid'];
            $headercontent['productlist'] = $this->rawmaterialpurchasemodel->getServiceList();
            $headercontent['vendor'] = $this->vendormastermodel->vendorlist($session);
            $headercontent['cgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='CGST',$usedfor='I');
            $headercontent['sgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='SGST',$usedfor='I');
            $headercontent['igstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='IGST',$usedfor='I');
            $headercontent['serviceaccount']=$this->accountmastermodel->accountlist($session);
            
         
            if ($rawmaterialMasterId != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['rowmaterialmasterid'] = $rawmaterialMasterId;
                $result['rawpurchaseMaster'] = $this->rawmaterialpurchasemodel->GSTgetRawMatpurchaseMastData($rawmaterialMasterId);
                $result['rawpurchaseDetail'] = $this->rawmaterialpurchasemodel->GSTgetRawMaterialDtldata($rawmaterialMasterId);
                $page = 'gstservicepurchase/addservice';
            } else {
                $headercontent['mode'] = "Add";
                $headercontent['rowmaterialmasterid']=NULL;
                $result=NULL;
                $page = 'gstservicepurchase/addservice';
            }


            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
     
    public function GSTsaveData() {
        $modeOfOpeartion = $this->input->post('mode');
        $rawmatPurchMastId = $this->input->post('rawmatpurchaseMastId');
        $formData = $this->input->post('formDatas');

        parse_str($formData, $searcharray);
        

        if ($modeOfOpeartion == "Add" && $rawmatPurchMastId == "") {
           $rslt= $this->GSTinsertData($searcharray);
        } else {
           $rslt= $this->GSTupdateData($rawmatPurchMastId, $searcharray);
        }
        if($rslt){
            echo (1);
        }else{
            echo(0);
        }
    }
    /**
     * @name  GSTinsertData
     * @param type $searcharray
     * @return type
     */
    public function GSTinsertData($searcharray) {
        $rawMaterialPurchase = array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
			
            $rawMaterialPurchase['invoice_no'] = $searcharray['invoiceno'];
            $rawMaterialPurchase['invoice_date'] = date("Y-m-d", strtotime($searcharray['invoicedate']));
            $rawMaterialPurchase['challan_no'] = $searcharray['challanno'];
            $rawMaterialPurchase['challan_date'] =($searcharray['challandate'])=="" ? NULL : date("Y-m-d", strtotime($searcharray['challandate']));
            $rawMaterialPurchase['order_no'] = $searcharray['orderno'];
            $rawMaterialPurchase['order_date'] = ($searcharray['orderdate'])=="" ? NULL : date("Y-m-d", strtotime($searcharray['orderdate']));
            $rawMaterialPurchase['excise_invoice_no'] = NULL;
            $rawMaterialPurchase['excise_invoice_date'] =NULL;
                                   
            $rawMaterialPurchase['vendor_id'] = $searcharray['vendor'];
            $rawMaterialPurchase['item_amount'] = $searcharray['txtTotalAmount'];
            $rawMaterialPurchase['excise_id'] = NULL;
            $rawMaterialPurchase['excise_amount'] = NULL;
            $rawMaterialPurchase['taxrateType'] = NULL;
             /*if ($searcharray['rateType'] == 'V') {
                $rawMaterialPurchase['taxrateTypeId'] = NULL;
            } else {
                $rawMaterialPurchase['taxrateTypeId'] = NULL;
            }*/
            $rawMaterialPurchase['voucher_id'] ='';
            $rawMaterialPurchase['taxamount'] = $searcharray['txtTaxAmount'];
            
           
            // <editor-fold defaultstate="collapsed" desc="GST area 05-07-2017">
                    
            $rawMaterialPurchase["GST_Discountamount"] =$searcharray["txtDiscountAmount"];
            $rawMaterialPurchase["GST_Taxableamount"] =$searcharray["txtTaxAmount"];
            $rawMaterialPurchase["GST_Totalgstincluded"] = $searcharray["txtTotalIncldTaxAmt"];
            $rawMaterialPurchase["totalCGST"] = $searcharray["txtTotalCGST"];
            $rawMaterialPurchase["totalSGST"] = $searcharray["txtTotalSGST"];
            $rawMaterialPurchase["totalIGST"] = $searcharray["txtTotalIGST"];
            $rawMaterialPurchase["IsGST"]='Y';
            $rawMaterialPurchase["IsService"]='Y';
            // </editor-fold>
            
          
            
            $rawMaterialPurchase['round_off'] = NULL;
            $rawMaterialPurchase['invoice_value'] = $searcharray['txtInvoiceValue'];
            $rawMaterialPurchase['companyid'] =  $session['company'];
            $rawMaterialPurchase['yearid'] = $session['yearid'];
            $rawMaterialPurchase['userid'] =  $session['user_id'];
           
            
       
            $insrt = $this->gstservicepurchasemodel->GSTinsertData($rawMaterialPurchase, $searcharray);

           return $insrt;
            
        } else {
            redirect('login', 'refresh');
        }
    }
     public function GSTupdateData($rowpurMastId, $searcharray) {
        $updRowmatPurchaseMast = array();
        $session = sessiondata_method();
        
       

        if ($this->session->userdata('logged_in')) {

           $updRowmatPurchaseMast['id'] = $rowpurMastId;
            $updRowmatPurchaseMast['invoice_no'] = $searcharray['invoiceno'];
            $updRowmatPurchaseMast['invoice_date'] = date("Y-m-d", strtotime($searcharray['invoicedate']));
            $updRowmatPurchaseMast['challan_no'] = $searcharray['challanno'];
            $updRowmatPurchaseMast['challan_date'] = ($searcharray['challandate'])=="" ? NULL : date("Y-m-d", strtotime($searcharray['challandate']));
            $updRowmatPurchaseMast['order_no'] = $searcharray['orderno'];
            $updRowmatPurchaseMast['order_date'] = ($searcharray['orderdate'])=="" ? NULL : date("Y-m-d", strtotime($searcharray['orderdate']));
            $updRowmatPurchaseMast['excise_invoice_no'] = NULL;
            $updRowmatPurchaseMast['excise_invoice_date'] =NULL;
            $updRowmatPurchaseMast['vendor_id'] = $searcharray['vendor'];
            $updRowmatPurchaseMast['item_amount'] = $searcharray['txtTotalAmount'];
            $updRowmatPurchaseMast['excise_id'] = NULL;
            $updRowmatPurchaseMast['excise_amount'] = NULL;
            $updRowmatPurchaseMast['taxrateType'] = NULL;
          
            $updRowmatPurchaseMast['taxamount'] = $searcharray['txtTaxAmount'];
            
            
            
                    
            $updRowmatPurchaseMast["GST_Discountamount"] =$searcharray["txtDiscountAmount"];
            $updRowmatPurchaseMast["GST_Taxableamount"] =$searcharray["txtTaxAmount"];
            $updRowmatPurchaseMast["GST_Totalgstincluded"] = $searcharray["txtTotalIncldTaxAmt"];
            $updRowmatPurchaseMast["totalCGST"] = $searcharray["txtTotalCGST"];
            $updRowmatPurchaseMast["totalSGST"] = $searcharray["txtTotalSGST"];
            $updRowmatPurchaseMast["totalIGST"] = $searcharray["txtTotalIGST"];
            $updRowmatPurchaseMast["IsGST"]='Y';
            $rawMaterialPurchase["IsService"]='Y';
            
            
            
            $updRowmatPurchaseMast['round_off'] = NULL;
            $updRowmatPurchaseMast['invoice_value'] = $searcharray['txtInvoiceValue'];
            $updRowmatPurchaseMast['companyid'] =  $session['company'];
            $updRowmatPurchaseMast['yearid'] = $session['yearid'];
            $updRowmatPurchaseMast['userid'] =  $session['user_id'];
           


            $insrt = $this->gstservicepurchasemodel->GSTUpdateData($updRowmatPurchaseMast, $searcharray);

            return $insrt;
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
    
    
    
    
    
     /**
     * @method createDetails
     * @param null $name Description
     * @return DetailshtmlPage
     * @date 04-07-2017
     */
    public function gstcreateDetails() {

        $session = sessiondata_method();
        $divNumber = $this->input->post('divSerialNumber');
        if ($this->session->userdata('logged_in')) {
            $companyId = $session['company'];
            $yearId = $session['yearid'];
            
            $result['productlist'] = $this->rawmaterialpurchasemodel->getServiceList();
            $result['cgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='CGST',$usedfor='I');
            $result['sgstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='SGST',$usedfor='I');
            $result['igstrate'] = $this->gsttaxinvoicemodel->getGSTrate($companyId,$yearId,$type='IGST',$usedfor='I');
            $result['serviceaccount']=$this->accountmastermodel->accountlist($session);
            
            $result['divnumber'] = $divNumber;
            $page = 'gstservicepurchase/gst_rawmaterialdetail.php';
            $this->load->view($page, $result);
        } else {
            redirect('login', 'refresh');
        }
    }
    /**
     * @name getAmount
     * @date 04/06/2017
     * @author Abhik<amiabhik@gmail.com>
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
     * @method addRawMaterialpurchase
     * @date 07/03/2016
     * By Mithilesh
     */
    public function addRawMaterialpurchase() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {

                $rawmaterialMasterId = 0;
            } else {
                $rawmaterialMasterId = $this->uri->segment(4);
            }
          //  echo($rawmaterialMasterId);
              $headercontent['exciselist'] = $this->rawmaterialpurchasemodel->getExciselist(); 
              $headercontent['productlist'] = $this->rawmaterialpurchasemodel->getProductList();
              $headercontent['vendor'] = $this->vendormastermodel->vendorlist($session);
              
          
           /*$headercontent['cstRate'] = $this->rawmaterialpurchasemodel->getCurrentcstrate($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');
            $headercontent['vatpercentage'] = $this->rawmaterialpurchasemodel->getCurrentvatrate($session['startyear'] . '-04-01', $session['endyear'] . '-03-31');*/
              
            $headercontent['cstRate'] = $this->rawmaterialpurchasemodel->getCurrentcstrate();
            $headercontent['vatpercentage'] = $this->rawmaterialpurchasemodel->getCurrentvatrate();
              
              
           // $headercontent="";

            if ($rawmaterialMasterId != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['rowmaterialmasterid'] = $rawmaterialMasterId;
                $result['rawpurchaseMaster'] = $this->rawmaterialpurchasemodel->getRawMatpurchaseMastData($rawmaterialMasterId);
                $result['rawpurchaseDetail'] = $this->rawmaterialpurchasemodel->getRawMaterialDtldata($rawmaterialMasterId);

                $page = 'raw_material_purchase/rawmaterial_purchase_add';
            } else {
                $headercontent['mode'] = "Add";
                $headercontent['rowmaterialmasterid']=NULL;
                $result=NULL;
                $page = 'raw_material_purchase/rawmaterial_purchase_add';
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
     * @date 07-03-2016
     */
    public function createDetails() {

        $session = sessiondata_method();
        $divNumber = $this->input->post('divSerialNumber');
        if ($this->session->userdata('logged_in')) {

            $result['productlist'] = $this->rawmaterialpurchasemodel->getProductList();
            $result['divnumber'] = $divNumber;
            $page = 'raw_material_purchase/rawmaterialdetail.php';
            $this->load->view($page, $result);
        } else {
            redirect('login', 'refresh');
        }
    }

   /**
     * @method SaveData
     * @param null
     * @date 07-03-2016
     */  
    
    public function saveData() {
        $modeOfOpeartion = $this->input->post('mode');
        $rawmatPurchMastId = $this->input->post('rawmatpurchaseMastId');
        $formData = $this->input->post('formDatas');

        parse_str($formData, $searcharray);
        /*echo "<pre>";
        print_r($searcharray);
        echo "<pre>";*/

        if ($modeOfOpeartion == "Add" && $rawmatPurchMastId == "") {
           $rslt= $this->insertData($searcharray);
        } else {
           $rslt= $this->updateData($rawmatPurchMastId, $searcharray);
        }
        if($rslt){
            echo (1);
        }else{
            echo(0);
        }
    }

     /**
     * @method SaveData
     * @param $searcharray
     * @date 07-03-2016
      
     */ 
     public function insertData($searcharray) {
        $rawMaterialPurchase = array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
			
            $rawMaterialPurchase['invoice_no'] = $searcharray['invoiceno'];
            $rawMaterialPurchase['invoice_date'] = date("Y-m-d", strtotime($searcharray['invoicedate']));
            $rawMaterialPurchase['challan_no'] = $searcharray['challanno'];
            $rawMaterialPurchase['challan_date'] =($searcharray['challandate'])=="" ? NULL : date("Y-m-d", strtotime($searcharray['challandate']));
            $rawMaterialPurchase['order_no'] = $searcharray['orderno'];
            $rawMaterialPurchase['order_date'] = ($searcharray['orderdate'])=="" ? NULL : date("Y-m-d", strtotime($searcharray['orderdate']));
            $rawMaterialPurchase['excise_invoice_no'] = $searcharray['exciseinvno'];
            $rawMaterialPurchase['excise_invoice_date'] =($searcharray['excisedate'])=="" ? NULL: date("Y-m-d", strtotime($searcharray['excisedate']));
                                   
            $rawMaterialPurchase['vendor_id'] = $searcharray['vendor'];
            $rawMaterialPurchase['item_amount'] = $searcharray['txtTotalAmount'];
            $rawMaterialPurchase['excise_id'] = $searcharray['excise'];
            $rawMaterialPurchase['excise_amount'] = $searcharray['exciseAmt'];
            $rawMaterialPurchase['taxrateType'] = $searcharray['rateType'];
             if ($searcharray['rateType'] == 'V') {
                $rawMaterialPurchase['taxrateTypeId'] = $searcharray['vat'];
            } else {
                $rawMaterialPurchase['taxrateTypeId'] = $searcharray['cst'];
            }
            $rawMaterialPurchase['voucher_id'] ='';
            $rawMaterialPurchase['taxamount'] = $searcharray['txtTaxAmount'];
            $rawMaterialPurchase['round_off'] = $searcharray['txtRoundOff'];
            $rawMaterialPurchase['invoice_value'] = $searcharray['txtInvoiceValue'];
            $rawMaterialPurchase['companyid'] =  $session['company'];
            $rawMaterialPurchase['yearid'] = $session['yearid'];
            $rawMaterialPurchase['userid'] =  $session['user_id'];
           
            
       
            $insrt = $this->rawmaterialpurchasemodel->insertData($rawMaterialPurchase, $searcharray);

           return $insrt;
            
        } else {
            redirect('login', 'refresh');
        }
    }
    
     /**
     * @method updateData
     * @param $rowpurMastId,$searcharray
     * @date 07-03-2016
     * 
     */
    
     public function updateData($rowpurMastId, $searcharray) {
        $updRowmatPurchaseMast = array();
        $session = sessiondata_method();
        
       

        if ($this->session->userdata('logged_in')) {

           $updRowmatPurchaseMast['id'] = $rowpurMastId;
            $updRowmatPurchaseMast['invoice_no'] = $searcharray['invoiceno'];
            $updRowmatPurchaseMast['invoice_date'] = date("Y-m-d", strtotime($searcharray['invoicedate']));
            $updRowmatPurchaseMast['challan_no'] = $searcharray['challanno'];
            $updRowmatPurchaseMast['challan_date'] = ($searcharray['challandate'])=="" ? NULL : date("Y-m-d", strtotime($searcharray['challandate']));
            $updRowmatPurchaseMast['order_no'] = $searcharray['orderno'];
            $updRowmatPurchaseMast['order_date'] = ($searcharray['orderdate'])=="" ? NULL : date("Y-m-d", strtotime($searcharray['orderdate']));
            $updRowmatPurchaseMast['excise_invoice_no'] = $searcharray['exciseinvno'];
            $updRowmatPurchaseMast['excise_invoice_date'] =($searcharray['excisedate'])=="" ? NULL: date("Y-m-d", strtotime($searcharray['excisedate']));
            $updRowmatPurchaseMast['vendor_id'] = $searcharray['vendor'];
            $updRowmatPurchaseMast['item_amount'] = $searcharray['txtTotalAmount'];
            $updRowmatPurchaseMast['excise_id'] = $searcharray['excise'];
            $updRowmatPurchaseMast['excise_amount'] = $searcharray['exciseAmt'];
            $updRowmatPurchaseMast['taxrateType'] = $searcharray['rateType'];
             if ($searcharray['rateType'] == 'V') {
                $updRowmatPurchaseMast['taxrateTypeId'] = $searcharray['vat'];
            } else {
                $updRowmatPurchaseMast['taxrateTypeId'] = $searcharray['cst'];
            }
           // $updRowmatPurchaseMast['voucher_id'] ='';
            $updRowmatPurchaseMast['taxamount'] = $searcharray['txtTaxAmount'];
            $updRowmatPurchaseMast['round_off'] = $searcharray['txtRoundOff'];
            $updRowmatPurchaseMast['invoice_value'] = $searcharray['txtInvoiceValue'];
            $updRowmatPurchaseMast['companyid'] =  $session['company'];
            $updRowmatPurchaseMast['yearid'] = $session['yearid'];
            $updRowmatPurchaseMast['userid'] =  $session['user_id'];
           


            $insrt = $this->rawmaterialpurchasemodel->UpdateData($updRowmatPurchaseMast, $searcharray);

            return $insrt;
        } else {
            redirect('login', 'refresh');
        }
    }
    
    /**
     * @method get_product_rate
     * @param 
     * @date 07-03-2016
     * @return $purchaseRate by id
     */
  
    public function get_product_rate()
    {
        $productId=$this->input->post('productId');
        $purchaseRate=$this->rawmaterialpurchasemodel->get_product_rate_by_id($productId);
        echo($purchaseRate);
    }
    
    
    /**
     * @method get_exciserate_rate
     * @param 
     * @date 07-03-2016
     * @return $exciseRate by id
     */
    public function get_exciserate_rate(){
        $exciseId=$this->input->post('exciseId');
        $exciseRate=$this->rawmaterialpurchasemodel->get_excise_rate_by_id($exciseId);
        echo($exciseRate);
    }
    
}

?>
