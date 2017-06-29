<?php

//we need to call PHP's session object to access it through CI
class Othercharges extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('otherchargesmodel', '', TRUE);
        $this->load->model('accountmastermodel', '', TRUE);
       
    }

    public function index() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            $result = $this->otherchargesmodel->getGstList($session['company'],$session['yearid']);
            $page = 'othercharges/list_view';
            $header = '';
            $headercontent="";
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
      
    }

    
    public function addGST() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {

                $gstId = 0;
            } else {
                $gstId = $this->uri->segment(4);
            }
            //echo($salebillno);
            $companyId=$session['company'];
            $yearId=$session['yearid'];
            $headercontent['account'] = $this->accountmastermodel->accountlist($session);
            
            if ($gstId != 0) {
                $headercontent['mode'] = "Edit";
                $result["gstdata"]= $this->otherchargesmodel->getGSTById($gstId);
                $page = 'othercharges/addGST';
            } else {
                $headercontent['mode'] = "Add";
                $headercontent['gstId']="";
                $page = 'othercharges/addGST';
                $result=NULL;
            }


            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
    public function  saveData(){
        $Id = $this->input->post("Id");
        $Desc = $this->input->post("desc");
        $code = $this->input->post("code");
        $mappedAccountId = $this->input->post("account");
       
        $session = sessiondata_method();
        $response=array();
        
        if ($this->session->userdata('logged_in')) {
            $companyId=$session['company'];
            $yearId=$session['yearid'];
            $data_insert=array();
            if($Id==0){
                
                if($rslt==1){
                    
                    $response=array('status'=>1, 'msg'=> "");
                   
                }  else {
                   $response=array('status'=>0, 'msg'=> "");
                }
                
             
                
            }  else {
                 $data_insert= array(
                    "description"=>$Desc,"code"=>$code,
                    "accountid"=>$mappedAccountId
                );
                $rslt = $this->otherchargesmodel->GSTupdate($Id,$data_insert);
                if($rslt==1){
                    
                    $response=array('status'=>1, 'msg'=> "");
                   
                }  else {
                   $response=array('status'=>0, 'msg'=> "");
                }
                 
            }
             header('Content-Type: application/json');
             echo(json_encode($response)) ;
             exit();
            
        }else{
            $response=array('status'=>3, 'msg'=> "");
            header('Content-Type: application/json');
            echo(json_encode($response)) ;
            exit();
        }
    }

   
}

?>
