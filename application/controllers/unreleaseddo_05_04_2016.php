<?php 
//we need to call PHP's session object to access it through CI
class Unreleaseddo extends CI_Controller {

 public function __construct()
 {
   parent::__construct();
    $this->load->model('unreleaseddomodel','',TRUE);
 }
 public function index()
 {
        $session = sessiondata_method();
        $this->companyId = $session['company'];
        $this->yearId = $session['yearid'];
        $ispending = $this->input->post('chkpendingdo');

        if ($this->session->userdata('logged_in')) {

            if ($ispending == '') {
                $result['doList'] = $this->unreleaseddomodel->getDoLists('');
                $result['isPending'] = $ispending;
            } else {

                $result['doList'] = $this->unreleaseddomodel->getDoLists('Y');
                $result['isPending'] = 'Y';
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
   
   
   //echo($donumber);
   exit();
 
 }


}

?>
