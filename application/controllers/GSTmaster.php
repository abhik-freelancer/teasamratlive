<?php

//we need to call PHP's session object to access it through CI
class GSTmaster extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('gstmastermodel', '', TRUE);
        $this->load->model('accountmastermodel', '', TRUE);
       
    }

    public function index() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            $result = $this->gstmastermodel->getGstList($session['company'],$session['yearid']);
            $page = 'gstmaster/list_view';
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
                $result["gstdata"]= $this->gstmastermodel->getGSTById($gstId);
                $page = 'gstmaster/addGST';
            } else {
                $headercontent['mode'] = "Add";
                $headercontent['gstId']="";
                $page = 'gstmaster/addGST';
                $result=NULL;
            }


            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
    public function  saveGSTData(){
        $gstId = $this->input->post("gstId");
        $gstDesc = $this->input->post("gstDesc");
        $gstType = $this->input->post("gsttype");
        $gstRate = $this->input->post("gstrate");
        $mappedAccountId = $this->input->post("account");
        $gstUsedFor =  $this->input->post("gstFor");
        $session = sessiondata_method();
        $response=array();
        
        if ($this->session->userdata('logged_in')) {
            $companyId=$session['company'];
            $yearId=$session['yearid'];
            $data_insert=array();
            if($gstId==0){
                $data_insert= array(
                    "gstDescription"=>$gstDesc,"gstType"=>$gstType,"rate"=>$gstRate,
                    "accountId"=>$mappedAccountId,"usedfor"=>$gstUsedFor,"companyid"=>$companyId,"yearId"=>$yearId
                );
                $rslt = $this->gstmastermodel->GSTinsert($data_insert);
                if($rslt==1){
                    
                    $response=array('status'=>1, 'msg'=> "");
                   
                }  else {
                   $response=array('status'=>0, 'msg'=> "");
                }
                
             
                
            }  else {
                 $data_insert= array(
                    "gstDescription"=>$gstDesc,"gstType"=>$gstType,"rate"=>$gstRate,
                    "accountId"=>$mappedAccountId,"usedfor"=>$gstUsedFor
                );
                $rslt = $this->gstmastermodel->GSTupdate($gstId,$data_insert);
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
