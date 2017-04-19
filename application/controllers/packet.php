<?php

//we need to call PHP's session object to access it through CI
class packet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('packetmodel', '', TRUE);
        
    }

    public function index() {

        $session = sessiondata_method();
        $result = $this->packetmodel->packetlist();
       // $headercontent['warehouse'] = $this->warehousemastermodel->warehouselist();
         $headercontent='';
        $page = 'packet_master/list_view';
        $header = 'packet_master/header_view';
        

        createbody_method($result, $page, $header, $session, $headercontent);
    }

    function add() {
        $value['packet'] = $this->input->post('packet');
        $value['PacketQty'] = $this->input->post('packetQty');
        $value['qtyinBag'] = $this->input->post('QtyinBag');
       


        if (isset($_POST)) {
            $id = $this->packetmodel->add($value);
            echo $id;
        }
    }

    function modify() {
        $value['packet'] = $this->input->post('packet');
        $value['PacketQty'] = $this->input->post('packQty');
        $value['qtyinBag'] = $this->input->post('QtyinBag');
       

        $value['id'] = $this->input->post('id');

        if (isset($_POST)) {
            $res = $this->packetmodel->modify($value);
            echo $res;
        }
    }

    function delete() {
        $value = $this->input->post('id');
        $result = $this->packetmodel->delete($value);
        echo $result;
    }

}

?>