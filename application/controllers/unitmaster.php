<?php

//we need to call PHP's session object to access it through CI
class unitmaster extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('unitmastermodel', '', TRUE);
 }

    public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
           
            $result['unitlist']=$this->unitmastermodel->unitlisting();
            $headercontent='';
            $page = 'unitmaster/list_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
         /* echo  "<pre>";
            print_r( $result['unitlist']);
          echo  "</pre>";*/
            
        } else {
            redirect('login', 'refresh');
        }
    }

    
     public function addUnitMaster() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {
                    $unitmaster = 0;
            } else {
                $unitmaster = $this->uri->segment(4);
            }
           
             if ($unitmaster != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['unitId'] = $unitmaster;
                $result['unitmaster'] = $this->unitmastermodel->getUnitMasterData($unitmaster);
             /* echo "<pre>";
              print_r($result['unitmaster']);
              echo "<pre>";*/
                
              $page = 'unitmaster/headerview';
                
            } else {
                $headercontent['mode'] = "Add";
                $page = 'unitmaster/headerview';
            }


            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
      public function SaveData() {
        $modeOfOpeartion = $this->input->post('mode');
        $unitId= $this->input->post('unitId');
        $formData = $this->input->post('formDatas');

        parse_str($formData, $searcharray);
     /*echo "<pre>";
           print_r($searcharray);
        echo "</pre>";*/

   if ($modeOfOpeartion == "Add" && $unitId == "") {
            $this->insertData($searcharray);
        } else {
            $this->updateData($unitId, $searcharray);
        }
    }
    
    public function insertData($searcharray){
        $unitMaster = array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
             $unitMaster['unitName'] = $searcharray['unitmaster'];
               $unitMaster['isActive']='Y';
           
           $insrt = $this->unitmastermodel->InserMasterModel($unitMaster);

            if ($insrt) {
                echo 1;
            } else {
                echo 0;
            }
            exit(0);
        }
        
        else {
            redirect('login', 'refresh');
        }
    }
    
    
     public function updateData($unitId, $searcharray) {
        $updateUnitmaster = array();
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
            // $date = date('Y-m-d');
               $updateUnitmaster['unitid']=$unitId;
               $updateUnitmaster['unitName'] = $searcharray['unitmaster'];
               $updateUnitmaster['isActive']='Y';
         
            
            $insrt = $this->unitmastermodel->UpdateData($updateUnitmaster );

           if ($insrt) {
                echo '1';
            } else {
                echo '0';
            }
            
            exit(0);
            
        } else {
            redirect('login', 'refresh');
        }
    }
    

  
}