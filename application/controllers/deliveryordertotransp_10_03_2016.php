<?php 
//we need to call PHP's session object to access it through CI
class deliveryordertotransp extends CI_Controller {

    private $companyId;
    private $yearId;
    
 public function __construct()
 {
   parent::__construct();
   $this->load->model('dototransportermodel','',TRUE);
   $this->load->model('transportmastermodel','',TRUE);
 }
	
public function index()
 {
   	 $session = sessiondata_method();
         $this->companyId = $session['company'];
         $this->yearId = $session['yearid'];
         $is_sent = $this->input->post('chksent');
      
           if($this->session->userdata('logged_in'))
           {
               if($is_sent=='Y'){
                $result['doList'] = $this->dototransportermodel->getDoTransLists('');
                $result['transporter'] = $this->transportmastermodel->transportlist();
                $result['isSentToTrans']=$is_sent;
               }else{
               
                
                $result['doList'] = $this->dototransportermodel->getDoTransLists('Y');
                $result['transporter'] = $this->transportmastermodel->transportlist();
                $result['isSentToTrans']='';
               }
                       
           }else{
                redirect('login', 'refresh');
           }
        
          
	 $headercontent='';
	 $page = 'do_transporter/header_view';
	 $header = '';
	 
	/*load helper class to create view*/
	
	createbody_method($result,$page,$header,$session,$headercontent);
       
		
 	
 }
 /**
  * @method updateDoTransporter
  *  
  */
 public function updateDoTransporter(){
   
     $session = sessiondata_method();
     $typeOfOperation = $this->input->post('typeof');
     $doTransId = $this->input->post('doTranID');
     $doNumber = $this->input->post('donumber');
     $doDate = $this->input->post('doDate');
     $PurMstID= $this->input->post('purInvMst');
     $purDtlId = $this->input->post('purchaseDetailsId');
     $transporterId = $this->input->post('transporter');
     $transportationDate = $this->input->post('transporterdate');
     $isSent = $this->input->post('isSentTrans');
     $purchaseType = $this->input->post('purchaseType');
     $companyID= $session['company'];
     $yearId = $session['yearid'];
     
     $data = array(
                    'do'=>($doNumber==""?NULL:trim($doNumber)),
                    'transporterId'=>($transporterId=="0"?NULL:$transporterId),
                    'transportationdt' =>($transportationDate==""?NULL:date("Y-m-d",strtotime($transportationDate))),
                    'purchase_inv_dtlid'=>($purDtlId==""?NULL:$purDtlId),
                    'purchase_inv_mst_id'=>($PurMstID=""?null:$PurMstID),
                    'is_sent'=>$isSent,
                    'typeofpurchase'=>$purchaseType,
                    'yearid'=>$yearId,
                    'companyid'=>$companyID
                    
     );
     
             
     
     if($typeOfOperation=='U'){
         $this->dototransportermodel->updateDoTrans($doTransId,$data);
     }else{
         $this->dototransportermodel->insertDoTrans($data);
     }
     
     exit();
    
 }
         
	
	
}

?>
