<?php

//we need to call PHP's session object to access it through CI
class stocktransferout extends CI_Controller {

     function __construct() {
        parent::__construct();

        $this->load->model('vendormastermodel', '', TRUE);
        $this->load->model('warehousemastermodel', '', TRUE);
        $this->load->model('grademastermodel', '', TRUE);
        $this->load->model('gardenmastermodel', '', TRUE);
        $this->load->model('purchaseinvoicemastermodel', '', TRUE);
        $this->load->model('stocktransferoutmodel', '', TRUE);
        $this->load->model('bagtypemodel', '', TRUE);
        $this->load->model('locationmastermodel', '', TRUE);
    }

  public function index() {
        
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            $result = $this->stocktransferoutmodel->getStockOutList();
            $page = 'stocktransfer_out/list_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    /**
     * @method addStockTransferOut
     * @description : add and edit stockout
     */

    public function addStockTransferOut() {

        $session = sessiondata_method();
        
        if ($this->session->userdata('logged_in')) {

             if ($this->uri->segment(4) === FALSE) {
                 $stockoutMastrid = 0;
          } 
            else {
                $stockoutMastrid = $this->uri->segment(4);
                
        }
        $headercontent['garden'] = $this->gardenmastermodel->gardenlist();
        $headercontent['vendor'] = $this->vendormastermodel->vendorlist();
          
            
             if ($stockoutMastrid != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['stockoutMastId']=$stockoutMastrid;
                $result['stockOutMaster'] = $this->stocktransferoutmodel->getStockOutMasterData($stockoutMastrid);
                $result['stockOutDtl'] = $this->stocktransferoutmodel->getStockOutDtlData($stockoutMastrid);
                
             
                $page = 'stocktransfer_out/edit_stock_out.php';
                
            } else {
                $headercontent['mode'] = "Add";
                $result['purchaseMaster'] = "";
                $page = 'stocktransfer_out/add_stock_out.php';
            }
            
        
            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
     public function showInvoice(){
        $garden = $this->input->post('garden');
        $result['invoice']=$this->stocktransferoutmodel->getInvoice($garden);
        $page='stocktransfer_out/invoicedropdown.php';
        $this->load->view($page,$result);
    }
    
   public function showLotNumber(){
        $garden  = $this->input->post('garden');
        $invoice = $this->input->post('invoice');
        $result['lot']=  $this->stocktransferoutmodel->getLotNumber($garden,$invoice);
        $page='stocktransfer_out/lotdropdown.php';
        $this->load->view($page,$result);
    }   
    
  public function showGrade(){
        $garden  = $this->input->post('garden');
        $invoice = $this->input->post('invoice');
        $lot = $this->input->post('lot');
        $result['grade']=  $this->stocktransferoutmodel->getGradeNumber($garden,$invoice,$lot);
        $page='stocktransfer_out/gradedropdown.php';
        $this->load->view($page,$result);
    }   
    
    /**
     * @access public
     * @date 26-05-2016
     * @name purchaseExist
     * @param void $name Description
     * @return void 
     */
    public function purchaseExist()
    {
       $session = sessiondata_method();
       if ($this->session->userdata('logged_in')) {
           $garden  =  $this->input->post('gardenId');
           $invoice =  $this->input->post('invoiceNum');
           $lotNum  = $this->input->post('lotNum');
           $grade =  $this->input->post('grade');
           
            $purchaseId = $this->stocktransferoutmodel->getPurchaseExist($garden,$invoice,$lotNum,$grade);
            
            echo($purchaseId);
       }else{
            redirect('login', 'refresh');
       }
    }
    
     /**
     * @access public
     * @author Abhik
     * @name showTeaStock
     * @param void $name Description
     * @return void 
     */
    public function showStockIn()
    {
       $session = sessiondata_method();
       if ($this->session->userdata('logged_in')) {
           $garden  =  $this->input->post('gardenId');
           $invoice =  $this->input->post('invoiceNum');
           $lotNum  = $this->input->post('lotNum');
           $grade =  $this->input->post('grade');
           $divnumber = $this->input->post('divSerialNumber');
           
            $result['groupStock'] = $this->stocktransferoutmodel->getTeaStock($garden,$invoice,$lotNum,$grade);
            $result['divnumber'] = $divnumber;
            if( $result['groupStock']){
                $page = 'stocktransfer_out/teaStockDtl';
                $this->load->view($page, $result);
            }else{
                echo "0";
            }
            
       }else{
            redirect('login', 'refresh');
       }
    }
    
    /**
     * @method insertBlending
     * @description save blending data
     */
    public function insertStockOut(){
        $session = sessiondata_method();
        $formData = $this->input->post('formDatas');
        parse_str($formData, $searcharray);
        $stockoutMaster = array();
       
      //  exit;
        $stockoutMaster['refrence_number'] =$searcharray['refrence_no'];
        $stockoutMaster['transfer_date']=date("Y-m-d",  strtotime($searcharray['transferDt']));
        $stockoutMaster['vendor_id'] = $searcharray['vendor'];
        $stockoutMaster['cn_no'] = $searcharray['cnNo'];
        $stockoutMaster['stock_outBags'] = $searcharray['txtTotalstockOutBag'];
        $stockoutMaster['stock_outPrice'] = $searcharray['txtTotalStockPrice'];
        $stockoutMaster['stock_outKgs'] = $searcharray['txtTotalstockOutKgs'];
        $stockoutMaster['company_id']= $session['company'];
        $stockoutMaster['year_id']=$session['yearid'];

        
        $insrt= $this->stocktransferoutmodel->insertData($stockoutMaster,$searcharray);
        if($insrt){
            echo '1';
        }else{
            echo '0';
        }
        exit(0);
    }
    
    /**
  * @method updateStockTransferOut
  * @description Update Blending
  */
    
     public function  updateStockTransferOut(){
         $session = sessiondata_method();
         
          if ($this->session->userdata('logged_in')) {
            
                $formData = $this->input->post('formDatas');
                parse_str($formData, $searcharray);
                
                $stockOutMastr = array();
                $stockOutMid = $searcharray['txtstockoutMastId'];
                    if($stockOutMid!="")
                    {
                        $stockOutMastr['refrence_number'] = $searcharray['refrence_no'];
                        $stockOutMastr['transfer_date'] = date("Y-m-d",  strtotime($searcharray['transferDt']));
                        $stockOutMastr['vendor_id'] = $searcharray['vendor'];
                        $stockOutMastr['cn_no'] = $searcharray['cnNo'];
                        $stockOutMastr['stock_outBags'] = $searcharray['txtTotalstockOutBag'];
                        $stockOutMastr['stock_outPrice'] = $searcharray['txtTotalStockPrice'];
                        $stockOutMastr['stock_outKgs'] = $searcharray['txtTotalstockOutKgs'];
                        $stockOutMastr['company_id']= $session['company'];
                        $stockOutMastr['year_id']=$session['yearid'];
              
                        
                        $update=$this->stocktransferoutmodel->stocktransferOutUpd($stockOutMid,$stockOutMastr,$searcharray);
                         if($update){
                                        echo '1';
                                    }else{
                                        echo '0';
                                    }
                                    exit(0);
                        
                    }else{
                        
                    }      
              
              
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
    public function delete()
	{
            $stockOutMastId = $this->input->post('id');
           // $res= $this->openinginvoicemodel->getPurInvDtlId($id);
                
          
             $result = $this->stocktransferoutmodel->deleteData($stockOutMastId);
                if($result){
                    echo 1;
                }
                else{
                    echo 0;
                }
	}
    

}

?>
