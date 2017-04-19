<?php

//we need to call PHP's session object to access it through CI
class Doproductrecv extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('doreceivedmodel', '', TRUE);
        $this->load->model('transportmastermodel', '', TRUE);
    }

    public function index() {
        $session = sessiondata_method();
        $this->companyId = $session['company'];
        $this->yearId = $session['yearid'];
        $selected_transporter = $this->input->post('drpTransporter');

        // $ispending = $this->input->post('chkpendingdo');

        if ($this->session->userdata('logged_in')) {

             $result['transporterlist'] = $this->transportmastermodel->transportlist();
            if ($selected_transporter == '') {
               
                $result['selected_transporter'] = (!$selected_transporter ? "0" : $selected_transporter);
                $result['doRcvTransList']='';
               
            } else {
                $result['doRcvTransList'] = $this->doreceivedmodel->getDoTransporter($selected_transporter);
                $result['selected_transporter'] = (!$selected_transporter ? "0" : $selected_transporter);

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
        
        $shortage = $this->input->post('ShortageKg');
        $challan = $this->input->post('Challan');
        $challanDt = $this->input->post('ChallanDate');
        $IsStock = $this->input->post('IsStk');
        
        $doTransRcvdId = $this->input->post('trnsDo');
        
       

        $data = array(
            'shortkgs' => $shortage,
            'chalanNumber'=>$challan,
            'chalanDate' => date('Y-m-d', strtotime($challanDt)),
            'in_Stock' =>$IsStock
        );

        $updateDo = $this->doreceivedmodel->UpdateDoReceivedGoods($doTransRcvdId, $data);


        //echo($donumber);
        exit();
    }

}

?>
