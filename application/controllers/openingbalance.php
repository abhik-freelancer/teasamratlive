<?php

//we need to call PHP's session object to access it through CI
class openingbalance extends CI_Controller {

    function __construct() {
        parent::__construct();


        $this->load->model('auctionareamodel', '', TRUE);
        $this->load->model('vendormastermodel', '', TRUE);
        $this->load->model('warehousemastermodel', '', TRUE);
        $this->load->model('grademastermodel', '', TRUE);
        $this->load->model('gardenmastermodel', '', TRUE);
        $this->load->model('purchaseinvoicemastermodel', '', TRUE);
        $this->load->model('locationmastermodel', '', TRUE);
        $this->load->model('bagtypemodel', '', TRUE);
        $this->load->model('openinginvoicemodel', '', TRUE);
    }

    public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
            
            $cmpnyId = $session['company'];
            $yearId = $session['yearid'];

            $result['openingInvlist']=$this->openinginvoicemodel->getOpeningInvoiceBalanceList($cmpnyId,$yearId);
          
            $headercontent='';
            $page = 'opening_balance_invoice/list_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }

 public function addOpeningInvoiceBlnc() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {
                    $prMastId = 0;
            } else {
                $prMastId = $this->uri->segment(4);
            }
            $headercontent['grade'] =   $this->grademastermodel->gradelist();
            $headercontent['garden'] =  $this->gardenmastermodel->gardenlist();
            $headercontent['teagroup']= $this->purchaseinvoicemastermodel->teagrouplist();
            $headercontent['location'] = $this->locationmastermodel->loactionmasterlist();
            $headercontent['bagType'] = $this->openinginvoicemodel->bagList();
            
             if ($prMastId != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent['prMastId'] = $prMastId;
                $result['openingInvMstr'] = $this->openinginvoicemodel->getOpeningMasterDetail($prMastId);
                $result['openingBagDtl'] = $this->openinginvoicemodel->getBagOpeningInvoice($prMastId);
                
               // echo "<pre>";
               // print_r($result['openingBagDtl']);
             //  echo "</pre>";
                
                $page = 'opening_balance_invoice/header_view';
                
            } else {
                $headercontent['mode'] = "Add";
                $page = 'opening_balance_invoice/header_view';
            }


            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
   
     
    public function createDetails(){
        $session = sessiondata_method();
        $divNumber = $this->input->post('divSerialNumber');
        if ($this->session->userdata('logged_in')) {
           $result['bagType'] =$this->openinginvoicemodel->bagList();
           $result['divnumber'] = $divNumber;
           $page = 'opening_balance_invoice/opening_invoice_detail';
           $this->load->view($page, $result);
           
         }else {
            redirect('login', 'refresh');
        }
    }
  
      public function saveData() {
        $modeOfOpeartion = $this->input->post('mode');
        $prMastId= $this->input->post('prMastId');
        $formData = $this->input->post('formDatas');

        parse_str($formData, $searcharray);
     echo "<pre>";
           print_r($searcharray);
        echo "</pre>";

      if ($modeOfOpeartion == "Add" && $prMastId == "") {
            $this->insertData($searcharray);
        } else {
            $this->updateData($prMastId, $searcharray);
        }
    }
    
    public function insertData($searcharray){
        $openingPurInvInsert = array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
            $date = date('Y-m-d');
                $openingPurInvInsert['purchase_invoice_number']= $this->getPurInvNumber();
                $openingPurInvInsert['purchase_invoice_date']=$this->getStartDate();
                $openingPurInvInsert['auctionareaid']=0;
                $openingPurInvInsert['vendor_id']=57;
                $openingPurInvInsert['voucher_master_id']=57;
                $openingPurInvInsert['sale_number']=$searcharray['saleno'];
                $openingPurInvInsert['sale_date']=$date;
                $openingPurInvInsert['promt_date']=$date;
                
               $openingPurInvInsert['rate'] = $searcharray['rate'];
               $openingPurInvInsert['bagtype'] = $searcharray['bagtype'];
               $openingPurInvInsert['no_of_NormalBags'] = $searcharray['noofNormalBag'];
              // $openingPurInvInsert['net'] =$searcharray['net'];
               $openingPurInvInsert['net'] = $searcharray['net'];
               $openingPurInvInsert['txtnoofSamplebag'] = $searcharray['txtnoofbag'];
                $openingPurInvInsert['txtSampleDtlNet'] = $searcharray['txtDetailNet'];
                
                $totalNormalKg= $searcharray['noofNormalBag']* $searcharray['net'];
                $totalSamplekg = $this->totalRate($searcharray);
                $openingPurInvInsert['total_weight']=$totalNormalKg+$totalSamplekg;
                $openingPurInvInsert['tea_value']= $searcharray['rate']*( $totalNormalKg+$totalSamplekg);
               // $peningPurInvInsert['tea_value']= 3200;
                
                $openingPurInvInsert['brokerage']=0;
                $openingPurInvInsert['service_tax']=0;
                $openingPurInvInsert['total_cst']=0;
                $openingPurInvInsert['total_vat']=0;
                $openingPurInvInsert['chestage_allowance']=0;
                $openingPurInvInsert['stamp']=0;
                $openingPurInvInsert['other_charges']=0;
                $openingPurInvInsert['round_off']=0;
                $openingPurInvInsert['total']=$searcharray['rate']*( $totalNormalKg+$totalSamplekg);
               // $peningPurInvInsert['total']=3200;
                $openingPurInvInsert['company_id']=$session['company'];
                $openingPurInvInsert['year_id']=$session['yearid'];
                $openingPurInvInsert['from_where']='OP';
                
               //$openingPurInvInsert['purchase_master_id']=$searcharray[''];
                $openingPurInvInsert['lot']=$searcharray['lot'];
                $openingPurInvInsert['doRealisationDate']='';
                $openingPurInvInsert['do']='';
                $openingPurInvInsert['invoice_number']= $searcharray['invoice'];
                $openingPurInvInsert['garden_id']=$searcharray['garden'];
                $openingPurInvInsert['grade_id']=$searcharray['grade'];
                $openingPurInvInsert['location_id']=$searcharray['location'];
                $openingPurInvInsert['warehouse_id']=7;
                $openingPurInvInsert['gp_number']='';
                $openingPurInvInsert['date']=$date;
                $openingPurInvInsert['package']='';
                //$openingPurInvInsert['stamp']=$searcharray[''];
                $openingPurInvInsert['gross']=0;
                //$openingPurInvInsert['brokerage']=$searcharray[''];
                //$openingPurInvInsert['total_weight']=$searcharray[''];
                $openingPurInvInsert['rate_type_value']=0;
               // $openingPurInvInsert['price']=$searcharray[''];
                $openingPurInvInsert['service_tax']=0;
                //$openingPurInvInsert['total_value']=$searcharray[''];
                $openingPurInvInsert['chest_from']=0;
                $openingPurInvInsert['chest_to']=0;
                $openingPurInvInsert['value_cost']=0;
                //$openingPurInvInsert['net']=0;
                $openingPurInvInsert['rate_type']='V';
                $openingPurInvInsert['rate_type_id']=7;
                $openingPurInvInsert['service_tax_id']=13;
                $openingPurInvInsert['teagroup_master_id']=$searcharray['group'];
               // $openingPurInvInsert['cost_of_tea']=$searcharray['costoftea'];
                
              
         
            echo "<pre>";
                    print_r($openingPurInvInsert);
                echo "</pre>";
          $insrt = $this->openinginvoicemodel->insertOpeningInvoice($openingPurInvInsert,$searcharray);

            if ($insrt){
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
    public function getPurInvNumber(){
        $session = sessiondata_method();
        $type_of_purchase='OP';
        $random_num = rand(1,10000);
        $date=date('Y-m-d');
        
        $pur_inv_mastr = $type_of_purchase."/".$random_num."/".substr($date,8,2).substr($date,5,2).substr($date,0,4)."/".substr($session['startyear'],2,2)."-".substr($session['endyear'],2,2);
        return $pur_inv_mastr;
        
    }
    
    
     public function getStartDate() {
  
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
             
          
           $year = $session['yearid'];
           $start_year = $this->openinginvoicemodel->getStartDate($year);
           $startDate = $start_year['start_date'];
           return  $startDate;
             
         }
         else {
            redirect('login', 'refresh');
        }
    }
    
    
    public function updateData($prMastId, $searcharray) {
        $openingBlncInvoice = array();
        $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
            // $date = date('Y-m-d');
             
             $openingBlncInvoice['id'] = $prMastId;
             $openingBlncInvoice['prchase_invoice_dtlid'] = $searcharray['pInvDtlId'];
             $openingBlncInvoice['teagroup_master_id'] = $searcharray['group'];
             $openingBlncInvoice['location_id'] = $searcharray['location'];
             $openingBlncInvoice['garden_id'] = $searcharray['garden'];
             $openingBlncInvoice['grade_id'] = $searcharray['grade'];
             $openingBlncInvoice['invoice_number'] = $searcharray['invoice'];
             $openingBlncInvoice['lot'] = $searcharray['lot'];
             $openingBlncInvoice['sale_number'] = $searcharray['saleno'];
             $openingBlncInvoice['rate'] = $searcharray['rate'];
             $openingBlncInvoice['no_of_NormalBags'] = $searcharray['noofNormalBag'];
             $openingBlncInvoice['net'] = $searcharray['net'];
             $openingBlncInvoice['bagtype'] = $searcharray['bagtype'];
             $openingBlncInvoice['txtnoofSamplebag'] = $searcharray['txtnoofbag'];
             $openingBlncInvoice['txtSampleDtlNet'] = $searcharray['txtDetailNet'];
          
             $totalNormalKg= $searcharray['noofNormalBag']* $searcharray['net'];
            
            $totalSamplekg = $this->totalRate($searcharray);
            $openingBlncInvoice['total_weight']=$totalNormalKg+$totalSamplekg;
            $openingBlncInvoice['tea_value']= $searcharray['rate']*( $totalNormalKg+$totalSamplekg);
             
           
         /* echo "<pre>";
                print_r($openingBlncInvoice);
             echo "</pre>";*/
            
       
          
             
            $insrt = $this->openinginvoicemodel->UpdateData($openingBlncInvoice, $searcharray);

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
    
  
    public function totalRate($searcharray){
       $total=0;
        $numberOfSampleBag = count($searcharray['txtnoofbag']);
        for($i=0;$i<$numberOfSampleBag;$i++)
        {
          // $no_of_bag =$searcharray['txtnoofbag'][$i];
         //  $net= $searcharray['txtDetailNet'][$i];
           
           $total=$total+($searcharray['txtnoofbag'][$i]*$searcharray['txtDetailNet'][$i]);
          // echo $total_rate=$total_rate+$total;
       }
       
       return $total;
     }
    
      public function delete()
	{
            $pmasterId = $this->input->post('id');
           // $res= $this->openinginvoicemodel->getPurInvDtlId($id);
                
          
             $result = $this->openinginvoicemodel->deleteData($pmasterId);
                if($result){
                    echo 1;
                }
                else{
                    echo 0;
                }
	}
  
}