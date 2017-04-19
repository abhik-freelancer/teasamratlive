<?php 
//we need to call PHP's session object to access it through CI
class Unreleaseddo extends CI_Controller {

 public function __construct()
 {
   parent::__construct();
    $this->load->model('unreleaseddomodel','',TRUE);
 }
 
/* function _remap($param) {
    // echo($param);
     
   
     
     switch($params)
	        {
	            case 'index':
	                 $this->index();
	                break;
	            case 'updateDo':
	                $this->updateDo();
	                break;
	            default:
	                $this->index('Y');
	                break;

	        }
     
     
       
  }*/
  
 
 public function index()
 {      
        
       /* $this->companyId = $session['company'];
        $this->yearId = $session['yearid'];*/
        
        
    if ($this->session->userdata('logged_in')) {
         $session = sessiondata_method();
         $cmpyid = $session['company'];
         $yearid= $session['yearid'];
           
       if ($this->uri->segment(4) === FALSE) {
           
             $ispending = 'Y';
             
            }
            else {
                $ispending = $this->uri->segment(4);
                }
        
      
        
    
      
     
      if($ispending=='N'){
           $ispending = '';
        }
            
            
    /*if($param=='Y'){
             $ispending = 'Y';
        }
       if($param=='N'){
           $ispending = '';
       }*/
           
            if ($ispending=='') {
                $result['doList'] = $this->unreleaseddomodel->getDoLists('',$cmpyid,$yearid);
                $result['status'] = '';
            } else {
                
                $result['doList'] = $this->unreleaseddomodel->getDoLists($ispending,$cmpyid,$yearid);
                $result['status'] = $ispending;
            }
        } else {
            redirect('login', 'refresh');
        }

        $headercontent = '';
        $page = 'unreleaseddo_master/header_view';
        $header = '';
        /* load helper class to create view */
        createbody_method($result, $page, $header, $session, $headercontent);
    }
 /**
  * @method updateDo
  * @description Update do and doDate
  */
    public function updateDo(){
        
    $donumber =  $this->input->post('donumber');
    $doDate = $this->input->post('doDate');
    $PurchaseDtId = $this->input->post('purchaseDetailsId');
   
    $data = array(
              
               'do'=> $donumber,
               'doRealisationDate'=> date('Y-m-d',strtotime($doDate))
              );
 
    $updateDo = $this->unreleaseddomodel->UpdatePurDetailsDo($PurchaseDtId,$data);
    exit();
 
 }


}

?>
