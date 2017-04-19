<?php

//we need to call PHP's session object to access it through CI
class blending extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('blendingmodel', '', TRUE);
        $this->load->model('warehousemastermodel', '', TRUE);
        $this->load->model('productmodel','',TRUE);
        $this->load->model('purchaseinvoicemastermodel','',TRUE);
    }

    public function index() {
        
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            $result = $this->blendingmodel->getBlendingList();
            $page = 'blending/list_view';
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

    public function addBlending() {

        $session = sessiondata_method();
        
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {

                $blendingId = 0;
            } else {
                $blendingId = $this->uri->segment(4);
            }
           // echo($blendingId);
            $headercontent['product'] = $this->productmodel->getProduct();
            $headercontent['teagroup'] = $this->purchaseinvoicemastermodel->teagrouplist();
            $headercontent['warehouse'] = $this->warehousemastermodel->warehouselist();
            
            
            if ($blendingId != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['blnid']=$blendingId;
                $headercontent['TotalPacket']=  $this->blendingmodel->getTotalBlendedPacket($blendingId);
                $headercontent['TotalBlendedKgs']=  $this->blendingmodel->getTotalBlendedKgs($blendingId);
                
                $result['blendingMaster'] = $this->blendingmodel->getBlendingMasterData($blendingId);
                $result['blendedStock'] = $this->blendingmodel->getStockWithBlend();
                $this->db->freeDBResource($this->db->conn_id); 
                $page = 'blending/edit_blending';
                
                
            } else {
                $headercontent['mode'] = "Add";
                $page = 'blending/add_blending';
            }

           
            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
    
    
    /**
     * @method showstock
     * @return view current stock
     * @date 08/09/2015
     */
    public function showstock(){
       
       
       $session = sessiondata_method();
       if ($this->session->userdata('logged_in')) {
        $result['groupStock'] = $this->blendingmodel->getStock();
        $page = 'blending/stockDtl';
        $this->load->view($page, $result);
       }else{
            redirect('login', 'refresh');
       }
       
    }

    /**
     * @method insertBlending
     * @description save blending data
     */
    public function insertBlending(){
        $session = sessiondata_method();
        $formData = $this->input->post('formDatas');
        parse_str($formData, $searcharray);
        $blendingMaster = array();
        
        $blendingMaster['blending_number'] = $searcharray['txtBlendingNo'];
        $blendingMaster['blending_ref'] =$searcharray['txtBlendingRef'];
        $blendingMaster['blending_date']=date("Y-m-d",  strtotime($searcharray['txtBlendingDt']));
        $blendingMaster['warehouseid'] = $searcharray['drpwarehouse'];
        $blendingMaster['productid'] = $searcharray['drpproduct'];
        $blendingMaster['companyid']= $session['company'];
        $blendingMaster['yearid']=$session['yearid'];
        
        $insrt= $this->blendingmodel->insertData($blendingMaster,$searcharray);
        if($insrt){
            echo '1';
        }else{
            echo '0';
        }
        exit(0);
        
        
    }
 /**
  * @method updateBlending
  * @description Update Blending
  */
    
     public function  updateBlending(){
         $session = sessiondata_method();
         
          if ($this->session->userdata('logged_in')) {
            
                $formData = $this->input->post('formDatas');
                parse_str($formData, $searcharray);
                $blendingMaster = array();
                $blendId = $searcharray['txtblendingId'];
                    if($blendId!="")
                    {
                        $blendingMaster['blending_number'] = $searcharray['txtBlendingNo'];
                        $blendingMaster['blending_ref'] =$searcharray['txtBlendingRef'];
                        $blendingMaster['blending_date']=date("Y-m-d",  strtotime($searcharray['txtBlendingDt']));
                        $blendingMaster['warehouseid'] = $searcharray['drpwarehouse'];
                        $blendingMaster['productid'] = $searcharray['drpproduct'];
                        $blendingMaster['companyid']= $session['company'];
                        $blendingMaster['yearid']=$session['yearid'];
                        $update=$this->blendingmodel->blendingUpdate($blendId,$blendingMaster,$searcharray);
                         if($update){
                                        echo '1';
                                    }else{
                                        echo '0';
                                    }
                                    exit(0);
                        
                    }else{
                        //to do
                    }      
              
              
        } else {
            redirect('login', 'refresh');
        }
    }
    /**
     * @method detailView
     * @param void  Description
     */
    public function detailView(){
        
         
       $session = sessiondata_method();
       if ($this->session->userdata('logged_in')) {
        $masterId=  $this->input->post('blendId');   
        $result['dtlview'] = $this->blendingmodel->getBlendDtlView($masterId);
        $page = 'blending/blendDtl';
        $this->load->view($page, $result);
       }else{
            redirect('login', 'refresh');
       }
        
    }
    
    /**
     * 
     */
    public function printBlendSheet(){
       $session = sessiondata_method();
       if ($this->session->userdata('logged_in')) {
           
            if ($this->uri->segment(4) === FALSE) {

                $masterId = 0;
            } else {
                $masterId = $this->uri->segment(4);
            }
                //$masterId=  $this->input->post('blendId');   
                $result['dtlview'] = $this->blendingmodel->blendSheetDtlPrint($masterId);
                $result['headerview']=$this->blendingmodel->blendSheetMstPrint($masterId);
                $result['printDate']=  date('d-m-Y');
                $page = 'blending/blendsheet';
               /* echo('<pre>');
                print_r($result);
                echo('</pre>');exit;*/
                $this->load->view($page, $result);
       }else{
            redirect('login', 'refresh');
       }
    }
    
    
    
    
    
    

}

?>
