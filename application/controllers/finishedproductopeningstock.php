<?php

//we need to call PHP's session object to access it through CI
class finishedproductopeningstock extends CI_Controller {

    function __construct() {
        parent::__construct();
      $this->load->model('finishproductopeningstockmodel', '', TRUE);
 }

    public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
           $cmpy = $session['company'];
           $year = $session['yearid'];
            
           $result['finishprdOPstock']=$this->finishproductopeningstockmodel->getFinishedPrdOPStockList($cmpy,$year);
           // $result="";
            $headercontent='';
            $page = 'finished_pdct_op_stock/list_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
     
            
        } else {
            redirect('login', 'refresh');
        }
    }

    
     public function addFinishedPrdctOPStock() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {
                    $FinishprdctOPstckId = 0;
            } else {
                $FinishprdctOPstckId = $this->uri->segment(4);
            }
             $headercontent['productpacket'] = $this->finishproductopeningstockmodel->ProductPacketList();
           
             if ($FinishprdctOPstckId != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['finishedPrdOPstockId'] = $FinishprdctOPstckId;
                $result['finishedPrdOpStockData'] = $this->finishproductopeningstockmodel->getFinishdPrdOPstockData($FinishprdctOPstckId);
           
                
              $page = 'finished_pdct_op_stock/header_view';
                
            } else {
                $headercontent['mode'] = "Add";
                $page = 'finished_pdct_op_stock/header_view';
            }


            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
    /*@method SaveData()--for Add and Edit
     *@date 04.02.2016
     *@author Mithilesh
     */
      public function SaveData() {
        $modeOfOpeartion = $this->input->post('mode');
        $finishPrdOpStockId= $this->input->post('finishedPrdctOPStockId');
        $formData = $this->input->post('formDatas');

        parse_str($formData, $searcharray);
        echo "<pre>";
           print_r($searcharray);
        echo "</pre>";
        

   if ($modeOfOpeartion == "Add" && $finishPrdOpStockId == "") {
            $this->insertData($searcharray);
        } else {
            $this->updateData($finishPrdOpStockId, $searcharray);
        }
    }
    
    
     public function insertData($searcharray){
        $finishprdOpstock= array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
            $finishprdOpstock['finished_product_id']=$searcharray['product_packet'];
            $finishprdOpstock['opening_balance']=$searcharray['opening_blnc'];
            $finishprdOpstock['company_id']=$session['company'];
            $finishprdOpstock['year_id']=$session['yearid'];
            
           $insrt = $this->finishproductopeningstockmodel->insrtFinishOpStock($finishprdOpstock);
           
        /*if($insrt){
              echo 1;
             } else {
                 echo 0;
             }
             exit(0);*/
         }
        
        else {
            redirect('login', 'refresh');
        }
    }
 
    public function updateData($finishPrdOpStockId, $searcharray) {
                
        $finishPrdOpStockUpd = array();
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
            
             $finishPrdOpStockUpd['id'] = $finishPrdOpStockId;
              $finishPrdOpStockUpd['finished_product_id']=$searcharray['product_packet'];
              $finishPrdOpStockUpd['opening_balance']=$searcharray['opening_blnc'];
              $finishPrdOpStockUpd['company_id']=$session['company'];
              $finishPrdOpStockUpd['year_id']=$session['yearid'];
         
         
            $insrt = $this->finishproductopeningstockmodel->UpdateFinishedPrdOPStock($finishPrdOpStockUpd );
       /* if($insrt) {
                echo '1';
            } else {
                echo '0';
            }
            
            exit(0);*/
            
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
    
    public function checkFinishedPrdExist(){
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
         $value=array();
        $finishedprdct = $this->input->post('finishedPrd');
       
        $value['finished_product_id']=$finishedprdct;
        $value['company_id']=$session['company'];
        $value['year_id']=$session['yearid'];
                
         $result = $this->finishproductopeningstockmodel->checkExistingFinishedPrd($value);
         if($result==TRUE){
             echo "1";
         }
         else{
             echo "0";
         }
         } else {
            redirect('login', 'refresh');
        }
    }
    
 

  
}
?>