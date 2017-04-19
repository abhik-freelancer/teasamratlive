<?php

//we need to call PHP's session object to access it through CI
class voucherlist extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('voucherlistmodel', '', TRUE);
        
 }

    public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
           
            
           /* $cmpny = $session['company'];
            $year = $session['yearid'];
            
            $fromdate ="";
            $todate="";
            $purchasetype="";
            
            $vdata = array();
          
            
            
             $fromdate = $this->input->post('fromdate');
             $todate = $this->input->post('todate');
             $purchasetype = $this->input->post('purchasetype');
               
             $vdata['from_date']= date("Y-m-d",strtotime($fromdate));
             $vdata['to_date']= date("Y-m-d",strtotime($todate));
             $vdata['ptype']=$purchasetype;
             
             
           
         //   $result['voucherlist']=$this->voucherlistmodel->getVoucherList($vdata);*/
           // $result='';
            $result='';
           
           
            $headercontent='';
            $page = 'voucher_list/header_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        
           
        } else {
            redirect('login', 'refresh');
        }
    }

    public function showvoucherList(){
         $fromdate = $this->input->post('fromdate');
           $todate = $this->input->post('todate');
             $purchasetype = $this->input->post('purchasetype');
             
             $vdata['from_date']= date("Y-m-d",strtotime($fromdate));
             $vdata['to_date']= date("Y-m-d",strtotime($todate));
             $vdata['ptype']=$purchasetype;
             
              $data['voucherlist']=$this->voucherlistmodel->getVoucherList($vdata);
               $page = 'voucher_list/list_view';
               $view = $this->load->view($page, $data, TRUE);
               echo($view);
        
    }

        
       
 
}
?>