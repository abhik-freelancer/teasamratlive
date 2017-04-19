<?php

//we need to call PHP's session object to access it through CI
class companymaster extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('companymodel', '', TRUE);
    }

    public function index() {
        
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {


            $result = $this->companymodel->companylist();


            $page = 'company_master/list_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
       
    }

    /**
     * @method addTaxInvoice
     * @date 04/11/2015
     * */
    public function addcompany() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {

                $companyId = 0;
            } else {
                $companyId = $this->uri->segment(4);
            }
            //echo($salebillno);
            
            $result['states'] = $this->companymodel->getStates();
            
            if ($companyId != 0) {
                $headercontent['mode'] = "Edit";
                $result['company_data'] = $this->companymodel->getCompanyById($companyId);
                $page = 'company_master/addcompany';
            } else {
                $headercontent['mode'] = "Add";
                $page = 'company_master/addcompany';
            } 


            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    

    /**
     * @method insertData
     * @param type $searcharray
     */
    public function insertData($searcharray) {
        $saleBillMaster = array();
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {

            $saleBillMaster['salebillno'] = $searcharray['txtSaleBillNo'];
            $saleBillMaster['salebilldate'] = date("Y-m-d", strtotime($searcharray['saleBillDate']));
            $saleBillMaster['customerId'] = $searcharray['customer'];
            $saleBillMaster['taxinvoiceno'] = $searcharray['txtTaxInvoiceNo'];
            $saleBillMaster['taxinvoicedate'] = date("Y-m-d", strtotime($searcharray['taxInvoiceDate']));
            $saleBillMaster['duedate'] = date("Y-m-d", strtotime($searcharray['txtDueDate']));
            $saleBillMaster['taxrateType'] = $searcharray['rateType'];

            if ($searcharray['rateType'] == 'V') {
                $saleBillMaster['taxrateTypeId'] = $searcharray['vat'];
            } else {
                $saleBillMaster['taxrateTypeId'] = $searcharray['cst'];
            }


            $saleBillMaster['taxamount'] = $searcharray['txtTaxAmount'];
            $saleBillMaster['discountRate'] = $searcharray['txtDiscountPercentage'];
            $saleBillMaster['discountAmount'] = $searcharray['txtDiscountAmount'];
            $saleBillMaster['totalpacket'] = $searcharray['txtTotalPacket'];
            $saleBillMaster['totalquantity'] = $searcharray['txtTotalQty'];
            $saleBillMaster['totalamount'] = $searcharray['txtTotalAmount'];
            $saleBillMaster['roundoff'] = $searcharray['txtRoundOff'];
            $saleBillMaster['grandtotal'] = $searcharray['txtGrandTotal'];
            $saleBillMaster['yearid'] = $session['yearid'];
            $saleBillMaster['companyid'] = $session['company'];
            $saleBillMaster['creationdate'] = date("Y-m-d");
            $saleBillMaster['userid'] = $session['user_id'];

            $insrt = $this->taxinvoicemodel->insertData($saleBillMaster, $searcharray);

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

    public function updateData() {
        
        $insert=TRUE;
        $CompanyMaster = array();
        $session = sessiondata_method();
        

        if ($this->session->userdata('logged_in')) {
            if($this->input->post('company_hiden_id')==''){

                $CompanyMaster['company_name'] = $this->input->post('name');
                $CompanyMaster['location'] = $this->input->post('address');
                $CompanyMaster['vat_number'] = $this->input->post('txtVatNo');
                $CompanyMaster['cst_number'] = $this->input->post('taxCstNo');
                $CompanyMaster['gst_number'] = $this->input->post('txtGstNo');
                $CompanyMaster['state_id'] = $this->input->post('state');
                $CompanyMaster['pan_number'] = $this->input->post('txtPanNo');
                $CompanyMaster['pin_number'] = $this->input->post('txtPinNo');
                $CompanyMaster['bill_tag'] = $this->input->post('txtBillTag');            

              $insert =  $this->companymodel->insertData($CompanyMaster);           

            }
            else{

                $CompanyMaster['company_name'] = $this->input->post('name');
                $CompanyMaster['location'] = $this->input->post('address');
                $CompanyMaster['vat_number'] = $this->input->post('txtVatNo');
                $CompanyMaster['cst_number'] = $this->input->post('taxCstNo');
                $CompanyMaster['gst_number'] = $this->input->post('txtGstNo');
                $CompanyMaster['state_id'] = $this->input->post('state');
                $CompanyMaster['pan_number'] = $this->input->post('txtPanNo');
                $CompanyMaster['pin_number'] = $this->input->post('txtPinNo');
                $CompanyMaster['bill_tag'] = $this->input->post('txtBillTag');            

              $insert =  $this->companymodel->UpdateData($CompanyMaster, $this->input->post('company_hiden_id')); 

            }
           // print_r($CompanyMaster);

            if ($insert) {
                redirect('companymaster', 'refresh');
            } else {
                echo '0';
            }
           // exit(0);
        } else {
            redirect('login', 'refresh');
        }
    }
   

}

?>
