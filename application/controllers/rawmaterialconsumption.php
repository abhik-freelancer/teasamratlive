<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of customeradvance
 *
 * @author avbhik
 */
class rawmaterialconsumption extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('productpacketratemodel', '', TRUE);
        $this->load->model('rawmaterialmodel', '', TRUE);       
        $this->load->model('productrawmaterialconsumptionmodel', '', TRUE);

        
    } 
    public function index(){
         $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
                $headercontent['productList'] = $this->productpacketratemodel->getProductList();   
                $headercontent['rawmaterial'] = $this->rawmaterialmodel->rawmaterialMasterList();
            
               // $headercontent['mode'] = "Add";
                $page = 'rawmaterialconsumption/addrawmaterial';
                $result="";
                $header = '';
                createbody_method($result, $page, $header, $session, $headercontent);
             
         }else{
              redirect('login', 'refresh');
         }
        
    }
    
    public function addEdit(){
         $session = sessiondata_method();
        
         
         if ($this->session->userdata('logged_in')) {
            
             if ($this->uri->segment(4) === FALSE) {
                
                $rawmaterialconsumptionid = 0;
            } else {
                $rawmaterialconsumptionid = $this->uri->segment(4);
            }
        
        $headercontent['productList'] = $this->productpacketratemodel->getProductList();   
        $headercontent['rawmaterial'] = $this->rawmaterialmodel->rawmaterialMasterList();
        
        
        if($rawmaterialconsumptionid==0){
            $headercontent['mode'] = "Add";
            $page = 'rawmaterialconsumption/addrawmaterial';
            $result="";
            
        }  else {
            $headercontent['mode'] = "Edit";
            $result['customeradvance']=  $this->customeradvancemodel->getCustomerAdvanceById($customeradvance);
           // echo('<pre>');print_r( $result['customeradvance']);echo('</pre>');
            $page = 'rawmaterialconsumption/addrawmaterial';
           
        }
        
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
            
        } else {
            redirect('login', 'refresh');
        }
    }
    /**
     * #getRawmaterialData
     * #date 26-12-2016
     * #getting raw material data
     */
    
    public function getRawmaterialData(){
        $ramaterialId = $this->input->post("rawmaterialid");
        $result = $this->rawmaterialmodel->getRawmaterialdetailbyId($ramaterialId);
        
        $output = array('Unit' => $result['Unit'],'unitid'=>$username['unitid']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }
    
    
    /*
     * @method saveRawmaterialconsumption
     * @date 27/12/2016
     * @Author ABhik
     */
    
    
    public function saveRawmaterialconsumption(){
      $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
            $masterData["product_packetId"] = $this->input->post("productid");
            $details = $this->input->post('rawmaterialDetails');
                     
            $rawmaterialdtls;
           
            foreach ($details as $value) {
               
                foreach ($value as $data) {

                    $rawmaterialdtls[] = array(
                        
                        'rawmaterialid' => $data['rawmaterialId'],
                        'quantity_required' => $data['Quantity']
                    );

                    
                }
            }

          
               $result =  $this->productrawmaterialconsumptionmodel->insertData($masterData, $rawmaterialdtls);
               if($result){
                   $msg = array("success"=>1);
               }else{
                   $msg = array("success"=>0);
               }
               $this->output->set_content_type('application/json')
                            ->set_output(json_encode($msg));
              
            
        } else {

            redirect('login', 'refresh');
        }
    }
    
     public function getProductRawmetirial(){
        $productPacketId = $this->input->post("productPacketId");
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
             $resultarray=  $this->productrawmaterialconsumptionmodel->getRawmaterialConsumption($productPacketId);
             $this->output->set_content_type('application/json')
                            ->set_output(json_encode($resultarray));
            
         }else{
              redirect('login', 'refresh');
         }
    }
    
   
}
