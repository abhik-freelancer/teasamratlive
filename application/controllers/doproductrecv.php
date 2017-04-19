<?php

//we need to call PHP's session object to access it through CI
class Doproductrecv extends CI_Controller {

    function __construct() {
		ini_set('memory_limit', '256M');
        parent::__construct();
        $this->load->model('doreceivedmodel', '', TRUE);
        $this->load->model('transportmastermodel', '', TRUE);
        $this->load->model('locationmastermodel', '', TRUE);
    }

    public function index() {
        $session = sessiondata_method();
        $this->companyId = $session['company'];
        $this->yearId = $session['yearid'];
        $company = $session['company'];
        $yearid = $session['yearid'];
        
        $selected_transporter = $this->input->post('drpTransporter');

        // $ispending = $this->input->post('chkpendingdo');

        if ($this->session->userdata('logged_in')) {

             $result['transporterlist'] = $this->transportmastermodel->transportlist();
            if ($selected_transporter == '') {
               
                $result['selected_transporter'] = (!$selected_transporter ? "0" : $selected_transporter);
                $result['doRcvTransList']='';
               
            } else {
                $result['doRcvTransList'] = $this->doreceivedmodel->getDoTransporter($selected_transporter,$company,$yearid);
                $result['selected_transporter'] = (!$selected_transporter ? "0" : $selected_transporter);
                $result['location']=  $this->locationmastermodel->loactionmasterlist();

            }
        } else {
            redirect('login', 'refresh');
        }


        $headercontent = '';
        $page = 'do_receive/header_view';
        $header = '';
        /* load helper class to create view */
        createbody_method($result, $page, $header, $session, $headercontent);
    }

    /**
     * @method updateDo
     * @description Update do and doDate
     */
    public function updateDoReceived() {
        
       
        if($this->input->post('IsStk')=='Y'){
        //$shortage = $this->input->post('ShortageKg');
        $challan = $this->input->post('Challan');
        $challanDt = $this->input->post('ChallanDate');
        $IsStock = $this->input->post('IsStk');
        $location = $this->input->post('location');
        }else{
          //  $shortage = 0;
            $location= NULL;
            $challan = NULL;
            $challanDt = "";
            $IsStock='N';
        }
        
        $doTransRcvdId = $this->input->post('trnsDo');
        $purchaseDtlId = $this->input->post('purDtlId');
		$data = array(
					//'shortkgs' => $shortage,
					'chalanNumber'=>$challan,
					'chalanDate' => ($challanDt==""?NULL: date('Y-m-d', strtotime($challanDt))),
					'locationId'=>$location,
					'in_Stock' =>$IsStock
				);
	   
	   
	   
		if($IsStock=='N'){
		$exist=$this->checkShortExist($purchaseDtlId);
		   if($exist!=1){	
				$updateDo = $this->doreceivedmodel->UpdateDoReceivedGoods($doTransRcvdId, $data);
			}else{
				 $updateDo=2;
			}
			
		}else{
			   $updateDo = $this->doreceivedmodel->UpdateDoReceivedGoods($doTransRcvdId, $data);	
		}

        echo($updateDo);
        exit();
    }
	public function checkShortExist($pDtlId){
		
		$shortexist = $this->doreceivedmodel->getShortageExist($pDtlId);
		return $shortexist;
		
	}

}

?>
