<?php 
//we need to call PHP's session object to access it through CI
class productpacketrate extends CI_Controller {

    private $companyId;
    private $yearId;
    
 public function __construct()
 {
   parent::__construct();
   $this->load->model('productpacketratemodel','',TRUE);
   $this->load->model('taxinvoicemodel','',TRUE);
 }
	
public function index()
 {
   	 $session = sessiondata_method();
         $this->companyId = $session['company'];
         $this->yearId = $session['yearid'];
         $is_sent = $this->input->post('chksent');
       
	
         if($this->session->userdata('logged_in'))
           {
             
                $result = $this->taxinvoicemodel->getPacketProduct();
             
           }else{
                redirect('login', 'refresh');
           }
        
          
	 $headercontent='';
	 $page = 'product_packet/header_view';
	 $header = '';
	 
	/*load helper class to create view*/
	
	createbody_method($result,$page,$header,$session,$headercontent);
       
		
 	
 }
 /**
  * @method updateDoTransporter
  *  
  */
 public function updateSaleRate(){
   
     $session = sessiondata_method();
     $productPacketId = $this->input->post('productpacketid');
     $saleRate = $this->input->post('saleRate');
     $saleNet = $this->input->post('salenet');
     
     $data = array(
                    'Sale_rate'=>($saleRate==""?0:$saleRate),
                     'net_kgs'=>($saleNet==""?0:$saleNet),
     );
     $result=$this->productpacketratemodel->UpdateData($productPacketId,$data);          
     if($result==TRUE)
     {
         echo("1");
     }
     else
     {
         echo("0");
     }
     exit();
    
 }
         
	
	
}

?>
