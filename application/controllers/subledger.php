<?php

//we need to call PHP's session object to access it through CI
class subledger extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('subledgermodel', '', TRUE);
 }

    public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
            
            $compny = $session['company'];
           
            $result['subledgerlist']=$this->subledgermodel->subledgerlisting($compny);
            $headercontent='';
            $page = 'subledger/list_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
         /* echo  "<pre>";
            print_r( $result['unitlist']);
          echo  "</pre>";*/
            
        } else {
            redirect('login', 'refresh');
        }
    }

    /*@method: addSubledger()--Add/Edit
     *@param: 
     *@date: 18.02.2016
     *@author: Mithilesh
     */
    
     public function addSubledger() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {
                    $subledgerId = 0;
            } else {
                $subledgerId = $this->uri->segment(4);
            }
           
             if ($subledgerId != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['subLedgerId'] = $subledgerId;
                $result['subledgerdata'] = $this->subledgermodel->getLedgerData($subledgerId);
             /* echo "<pre>";
              print_r($result['unitmaster']);
              echo "<pre>";*/
                
               // echo "<pre>";
               // print_r($result['openingBagDtl']);
             //  echo "</pre>";
                
                $page = 'subledger/header_view';
                
            } else {
                $headercontent['mode'] = "Add";
                $page = 'subledger/header_view';
            }


            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
    /*@method: SaveData()--for Add/Edit
     *@param: 
     *@date: 18.02.2016
     *@author: Mithilesh
     */
    
      public function SaveData() {
        $modeOfOpeartion = $this->input->post('mode');
        $subledgerId= $this->input->post('subLedgerid');
        $formData = $this->input->post('formDatas');

        parse_str($formData, $searcharray);
     /*echo "<pre>";
           print_r($searcharray);
        echo "</pre>";*/

   if ($modeOfOpeartion == "Add" && $subledgerId == "") {
            $this->insertData($searcharray);
        } else {
            $this->updateData($subledgerId, $searcharray);
        }
    }
    
     /*@method: insertData()
     *@param: $searcharray
     *@date: 18.02.2016
     *@author: Mithilesh
     */
    public function insertData($searcharray){
        $SubLedgerAdd = array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
             $SubLedgerAdd['subledger'] = $searcharray['subLedger'];
               $SubLedgerAdd['isActive']='Y';
                 $SubLedgerAdd['company_id'] = $session['company'];
           
           $insrt = $this->subledgermodel->insertSubledger($SubLedgerAdd);

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
    /*@method: updateData()
     *@param: $subledgerId,$searcharray
     *@date: 18.02.2016
     *@author: Mithilesh
     */
    
     public function updateData($subledgerId, $searcharray) {
        $updateSubledger = array();
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
            // $date = date('Y-m-d');
               $updateSubledger['subledgerid']=$subledgerId;
               $updateSubledger['subledger'] = $searcharray['subLedger'];
               $updateSubledger['isActive']='Y';
         
            
            $insrt = $this->subledgermodel->UpdateSubledger($updateSubledger );

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