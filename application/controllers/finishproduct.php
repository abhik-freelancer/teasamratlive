<?php

//we need to call PHP's session object to access it through CI
class finishproduct extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('finishedproductmodel',"",TRUE);
        $this->load->model('blendingmodel', '', TRUE);
        $this->load->model('warehousemastermodel', '', TRUE);
        $this->load->model('productmodel','',TRUE);
        
    }

    public function index() {
        
       $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            $company = $session['company'];
            $yearid = $session['yearid'];
            $result = $this->finishedproductmodel->getFinishedProductList($company,$yearid);
            
            $page = 'finishedproduct/list_view';
			$headercontent="";
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
     //$this->addfinishproduct();
    }
    /**
     * @method addPurchaseInvoice
     * @description : add and edit purchase
     */

    public function addfinishproduct() {

        $session = sessiondata_method();
        
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {

                $finishedProductId = 0;
            } else {
               $finishedProductId = $this->uri->segment(4);
            }
           // echo($blendingId);
            $headercontent['blendref'] = $this->finishedproductmodel->getBlendingList();
            $headercontent['warehouse'] = $this->warehousemastermodel->warehouselist();
           
            
            if ($finishedProductId != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['finishProductId']=$finishedProductId;
                $result['finishProductMaster'] = $this->finishedproductmodel->getFinishProductMaster($finishedProductId);   
                $result['finishProductDetails'] = $this->finishedproductmodel->getFinishProductPacketDetails($finishedProductId);   
                $page = 'finishedproduct/edit_finishproduct';
             } else {
                $headercontent['mode'] = "Add";
                $page = 'finishedproduct/add_finishedproduct';
				$result="";
            }

           
            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
    /**
     * @name showDetails
     * @date 13/10/2015
     * @description Create detail 
     */
    public function showDetails(){
        $blendingId = $this->input->post('blend');
        $blendMasterData =  $this->finishedproductmodel->getBlendedData($blendingId);
        $result['blendedId']= $blendingId;
        $result['mappedProduct'] = $blendMasterData->product;
        $result['blendedQty'] = $this->finishedproductmodel->getBlendedKgs($blendingId);
        $result['packetDtls'] = $this->finishedproductmodel->getPaketDetailForBlend($blendingId);
        $page='finishedproduct/finishproductcreation';
        $this->load->view($page,$result);
        
    }
    
    public function insertFinishedProduct(){
        
        $session = sessiondata_method();
        $formData = $this->input->post('formDatas');
        $consumeQty = $this->input->post('Qtyofconsume');
        parse_str($formData, $searcharray);
        $finishprodMaster = array();
        
        $BlendedData = $this->blendingmodel->getBlendingMasterData($searcharray['dropdownblendref']);
        
        
        $finishprodMaster['blended_id'] = $searcharray['dropdownblendref'];
        $finishprodMaster['packing_date']=date("Y-m-d",  strtotime($searcharray['txtPackingDt']));
        $finishprodMaster['warehouse_id'] = $searcharray['drpwarehouse'];
        $finishprodMaster['productid'] = $BlendedData['productId'];
        $finishprodMaster['blended_qty_kg'] = $BlendedData['blendedKgs'];//$searcharray['netblendkg'];
        $finishprodMaster['consumed_kgs'] = $consumeQty;
        $finishprodMaster['created_by']=$session['user_id'];
        $finishprodMaster['company_id']= $session['company'];
        $finishprodMaster['year_id']=$session['yearid'];
              
        $insrt= $this->finishedproductmodel->insertData($finishprodMaster,$searcharray);
        if($insrt){
            echo '1';
        }else{
            echo '0';
        }
        exit(0);
        
        
    }
    
  
    /**
     * @method detailView
     * @param void  Description
     */
    public function detailView(){
        
         
       $session = sessiondata_method();
       if ($this->session->userdata('logged_in')) {
        $masterId=  $this->input->post('finishprodid');   
        $result['dtlview'] = $this->finishedproductmodel->getFinishProductPacketDetails($masterId);
        $page = 'finishedproduct/finishprodDtl.php';
        $this->load->view($page, $result);
       }else{
            redirect('login', 'refresh');
       }
        
    }
    /**
     * 
     */
    public function updateFinishProduct(){
        
        $session = sessiondata_method();
        $formData = $this->input->post('formDatas');
        $consumeQty = $this->input->post('Qtyofconsume');
        parse_str($formData, $searcharray);
        $finishprodMaster = array();
        
        //$BlendedproductId = $this->blendingmodel->getBlendingMasterData($searcharray['dropdownblendref']);
        $finishprodMaster['id'] = $searcharray['finishproductId'];
        $finishprodMaster['blended_id'] = $searcharray['hdblendno'];
        $finishprodMaster['packing_date']=date("Y-m-d",  strtotime($searcharray['txtPackingDt']));
        $finishprodMaster['warehouse_id'] = $searcharray['drpwarehouse'];
        $finishprodMaster['productid'] = $searcharray['txtProductId'];
        $finishprodMaster['blended_qty_kg'] = $searcharray['blendQty'];
        $finishprodMaster['consumed_kgs'] = $consumeQty;
        $finishprodMaster['created_by']=$session['user_id'];
        $finishprodMaster['company_id']= $session['company'];
        $finishprodMaster['year_id']=$session['yearid'];
              
        $insrt= $this->finishedproductmodel->updateFinishProduct($finishprodMaster,$searcharray);
        if($insrt){
            echo '1';
        }else{
            echo '0';
        }
        exit(0);
        
    }
    

}

?>
