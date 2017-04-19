<?php

//we need to call PHP's session object to access it through CI
class Stocksummery extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('stocksummerymodel', '', TRUE);
        $this->load->model('teagroupmastermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
        
    }

    public function index() {
        $session = sessiondata_method();
        $this->companyId = $session['company'];
        $this->yearId = $session['yearid'];
      
         if ($this->session->userdata('logged_in')) {
             $result['teagrouplist'] =  $this->teagroupmastermodel->teagrouplist();
          } else {
           redirect('login', 'refresh');   
          }

        $headercontent = '';
        $page = 'stocksummery/header_view';
        $header = '';
        /* load helper class to create view */
        createbody_method($result, $page, $header, $session, $headercontent);
    }

   public function getStock(){
      
       $groupId = $this->input->post('groupId');
       $result['stock'] = $this->stocksummerymodel->getStock($groupId);
       $this->load->view('stocksummery/list_view',$result);
   }
   
   
   public function getStockPrint(){
        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];
		$groupReport="";
       
       
       
       
       $groupId = $this->input->post('group_code');
       
       $result['company']=  $this->companymodel->getCompanyNameById($companyId);
       $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
       $result['dateRange'] =date('d-m-Y',  strtotime('01-04-2013')). " to ".date('d-m-Y');
       $result['printDate']=date('d-m-Y');
       $result['Groupwise']= $this->stocksummerymodel->getStockGroup($groupId);
       $this->db->freeDBResource($this->db->conn_id); 
       
       
       
       foreach ($result['Groupwise'] as  $value) {
           
          
           $groupReport[$value['group_code']]=$this->stocksummerymodel->getStock($value['teagroup_master_id']);
           $this->db->freeDBResource($this->db->conn_id); 
       }
       $result['stock']=$groupReport;
       /*echo('<pre>');
       print_r($result['stock']);
       echo('</pre>');
       exit;*/
       
       $this->load->view('stocksummery/stockreport',$result);
   }

}

?>
