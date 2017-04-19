<?php

//we need to call PHP's session object to access it through CI
class auctionarea extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('auctionareamodel', '', TRUE);
        
    }

    public function index() {

        $session = sessiondata_method();
        $result = $this->auctionareamodel->aucareaList();
       // $headercontent['warehouse'] = $this->warehousemastermodel->warehouselist();
        $headercontent='';
        $page = 'auctionarea_master/list_view';
        $header = 'auctionarea_master/header_view';
        

        createbody_method($result, $page, $header, $session, $headercontent);
    }

    function add() {
        $value['auctionarea'] = $this->input->post('auctionarea');
         if (isset($_POST)) {
            $id = $this->auctionareamodel->add($value);
            echo $id;
        }
    }

    function modify() {
        $value['auctionarea'] = $this->input->post('auctionArea');
         $value['id'] = $this->input->post('id');

        if (isset($_POST)) {
            $res = $this->auctionareamodel->modify($value);
            echo $res;
        }
    }

    function delete() {
        $value = $this->input->post('id');
        $result = $this->auctionareamodel->delete($value);
        echo $result;
    }

}

?>