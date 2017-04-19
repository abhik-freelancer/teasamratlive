<?php

//we need to call PHP's session object to access it through CI
class branchmaster extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('branchmastermodel', '', TRUE);
        //$this->load->model('unitmastermodel', '', TRUE);
 }

   public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
           
           $result['branchlist']=$this->branchmastermodel->getBranchlist();
            //$result="";
            
            $headercontent='';
            $page = 'branch_master/list_view';
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
    
     public function addBranch(){
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {
                    $branchmasterid = 0;
            } else {
                $branchmasterid = $this->uri->segment(4);
            }
          
           
             if ($branchmasterid != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['branchmastId'] = $branchmasterid;
                $result['branchMaster'] = $this->branchmastermodel->getBranchMasterdata($branchmasterid);
            
                
              $page = 'branch_master/header_view';
                
            } else {
                $headercontent['mode'] = "Add";
                $page = 'branch_master/header_view';
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
        $branchmasterId= $this->input->post('branchmasterid');
        $formData = $this->input->post('formDatas');

        parse_str($formData, $searcharray);
      /*   echo "<pre>";
           print_r($searcharray);
        echo "</pre>";*/
        

     if ($modeOfOpeartion == "Add" &&  $branchmasterId == "") {
            $this->insertData($searcharray);
        } else {
            $this->updateData($branchmasterId, $searcharray);
        }
    }
    
    /*@method insertData()
     *@param $searcharray
     *@date 18.02.2016
     *@author Mithilesh
     */
    
    public function insertData($searcharray){
        $branchMaster = array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
             $branchMaster['branch'] = $searcharray['branchname'];
             $branchMaster['branch_address']=$searcharray['address'];
             
           $insrt = $this->branchmastermodel->insertBranch($branchMaster);

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
    
     public function updateData($branchmasterId,$searcharray) {
        
        /* echo "<pre>";
         print_r($searcharray);
         echo "<pre>";*/
         
         
        $branchUpd = array();
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
            
             $branchUpd['id'] = $branchmasterId;
             $branchUpd['branch'] = $searcharray['branchname'];
             $branchUpd['branch_address']=$searcharray['address'];
         
            $insrt=$this->branchmastermodel->updateBranch($branchUpd);

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