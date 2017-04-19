<?php

//we need to call PHP's session object to access it through CI
class excisemaster extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('excisemastermodel', '', TRUE);
        //$this->load->model('unitmastermodel', '', TRUE);
 }

   public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
           
           $result['excisemasterlist']=$this->excisemastermodel->exciseMasterList();
           // $result="";
            
            $headercontent='';
            $page = 'excise_master/list_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
     
            
        } else {
            redirect('login', 'refresh');
        }
    }

    /*@method addUnitMaster(Add/Edit)
     *@date 18.02.2016
     *@author Mithilesh
     */
    
     public function addExcisemaster() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {
                    $excisemasterid = 0;
            } else {
                $excisemasterid = $this->uri->segment(4);
            }
          
           
             if ($excisemasterid != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['excisemasterId'] = $excisemasterid;
                $result['exciseMaster'] = $this->excisemastermodel->getExciseMasterdata($excisemasterid);
            /*  echo "<pre>";
              print_r($result['rawmaterial']);
              echo "<pre>";*/
                
              $page = 'excise_master/header_view';
                
            } else {
                $headercontent['mode'] = "Add";
                $page = 'excise_master/header_view';
            }


            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
    /*@method SaveData()--for Add and Edit
     *@date 18.02.2016
     *@author Mithilesh
     */
      public function SaveData() {
        $modeOfOpeartion = $this->input->post('mode');
        $excisemasterId= $this->input->post('excisemasterid');
        $formData = $this->input->post('formDatas');

        parse_str($formData, $searcharray);
    /* echo "<pre>";
           print_r($searcharray);
        echo "</pre>";*/
        

      if ($modeOfOpeartion == "Add" && $excisemasterId == "") {
            $this->insertData($searcharray);
        } else {
            $this->updateData($excisemasterId, $searcharray);
        }
    }
    
    /*@method insertData()
     *@param $searcharray
     *@date 18.02.2016
     *@author Mithilesh
     */
    
    public function insertData($searcharray){
        $exciseMaster = array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
             $exciseMaster['description'] = $searcharray['description'];
             $exciseMaster['rate']=$searcharray['rate'];
             
           $insrt = $this->excisemastermodel->insertExcisemaster($exciseMaster);

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
    
    /*@method updateData()
     *@param $unitId,$searcharray
     *@date 18.02.2016
     *@author Mithilesh
     */
    
     public function updateData($exciseid, $searcharray) {
         
          /*echo "<pre>";
           print_r($searcharray);
          echo "</pre>";*/
        
        $exciseMasterUpd = array();
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
            
             $exciseMasterUpd['id'] = $exciseid;
             $exciseMasterUpd['description'] = $searcharray['description'];
             $exciseMasterUpd['rate']=$searcharray['rate'];
         
            $insrt=$this->excisemastermodel->updateExciseMaster($exciseMasterUpd);

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
?>