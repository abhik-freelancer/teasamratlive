<?php
class accountclosingtransfer extends CI_Controller {
     public function __construct() {
        parent::__construct();
        $this->load->model('closingtransfermodel', '', TRUE);
       
    }
    
    public function index(){
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            $result = $this->closingtransfermodel->getCurrentYear($session['yearid']);
            //$result="";
            $page = 'closingaccount/year';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    public function transferclosing(){
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            $fromyearid = $this->input->post("fromYearId");
            $toyearid= $this->input->post("toYearId");
            
            $fromdate = $session['startyear'] . '-04-01';
            $todate = $session['endyear'] . '-03-31';
            $fiscalsatrtdate = $session['startyear'] . '-04-01';
            $company=$session['company'];
            $response["result"]= $this->closingtransfermodel->transferclosingbalance($company,$fromyearid,$toyearid,$fromdate,$todate,$fiscalsatrtdate);
            $page = 'closingaccount/closingdtl';
            $this->load->view($page, $response);

            //echo($response);
        }else{
            redirect('login', 'refresh');
        }
        
    }
    
    
}

?>