<?php

//we need to call PHP's session object to access it through CI
class rawmaterial extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('rawmaterialmodel', '', TRUE);
         $this->load->model('unitmastermodel', '', TRUE);
 }

    public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
            $year=$session['yearid'];
             $company=$session['company'];
           $result['rawmateriallist']=$this->rawmaterialmodel->rawmaterialMasterList($company,$year);
           // $result="";
            $headercontent='';
            $page = 'raw_material/list_view';
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
    
     public function addRawMaterial() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {
                    $rawMaterialId = 0;
            } else {
                $rawMaterialId = $this->uri->segment(4);
            }
             $headercontent['unitlist'] = $this->unitmastermodel->unitlisting();
             $company = $session["company"];
             $year = $session["yearid"];
                     
                     /*
                      * $rawmaterial['yearid']=$session['yearid'];
             $rawmaterial['companyid']=$session['company'];
                      */
             if ($rawMaterialId != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['rawMaterialId'] = $rawMaterialId;
                $result['rawmaterial'] = $this->rawmaterialmodel->getRawmaterial($company,$year,$rawMaterialId);
           
                
              $page = 'raw_material/header_view';
                
            } else {
                $headercontent['mode'] = "Add";
                $page = 'raw_material/header_view';
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
        $rawmaterialId= $this->input->post('rawmaterialid');
        $formData = $this->input->post('formDatas');

        parse_str($formData, $searcharray);
    /* echo "<pre>";
           print_r($searcharray);
        echo "</pre>";*/
        

   if ($modeOfOpeartion == "Add" && $rawmaterialId == "") {
            $this->insertData($searcharray);
        } else {
            $this->updateData($rawmaterialId, $searcharray);
        }
    }
    
    /*@method insertData()
     *@param $searcharray
     *@date 18.02.2016
     *@author Mithilesh
     */
    
    public function insertData($searcharray){
        $rawmaterial = array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
             $rawmaterial['unitid'] = $searcharray['unitid'];
             $rawmaterial['purchase_rate']=$searcharray['rate'];
             $rawmaterial['product_description']=$searcharray['product_descript'];
             $rawmaterial['opening']=$searcharray['opening'];
             $rawmaterial['yearid']=$session['yearid'];
             $rawmaterial['companyid']=$session['company'];
           
           $insrt = $this->rawmaterialmodel->insertRawmaterialMaster($rawmaterial);

            if ($insrt) {
                echo "1";
            } else {
                echo "0";
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
    
     public function updateData($raWmaterialId, $searcharray) {
        
        $rawmaterialUpdate = array();
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
            
             $rawmaterialUpdate['id'] = $raWmaterialId;
             $rawmaterialUpdate['purchase_rate']=$searcharray['rate'];
             $rawmaterialUpdate['product_description']=$searcharray['product_descript'];
             $rawmaterialUpdate['unitid'] = $searcharray['unitid'];
             
             /*********Opening Data************/
             $rawmaterialOpening['opening']=$searcharray['opening'];
             $rawmaterialOpening['yearid']=$session['yearid'];
             $rawmaterialOpening['companyid']=$session['company'];
             $rawmaterialOpening["rawmaterialId"]=$raWmaterialId;
         
            $insrt = $this->rawmaterialmodel->UpdateRawmaterialMaster($rawmaterialUpdate,$rawmaterialOpening );

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