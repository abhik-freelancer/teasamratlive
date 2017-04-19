<?php

//we need to call PHP's session object to access it through CI
class locationmaster extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('locationmastermodel', '', TRUE);
        $this->load->model('warehousemastermodel', '', TRUE);
    }

    public function index() {

        $session = sessiondata_method();
        $result = $this->locationmastermodel->loactionmasterlist();
        $headercontent['warehouse'] = $this->warehousemastermodel->warehouselist();

        $page = 'location_master/list_view';
        $header = 'location_master/header_view';


        createbody_method($result, $page, $header, $session, $headercontent);
    }

    function add() {
        $value['location'] = $this->input->post('location');
        $value['warehouseid'] = $this->input->post('warehouseid');
        $value['is_active'] = 'Y';


        if (isset($_POST)) {
            $id = $this->locationmastermodel->add($value);
            echo $id;
        }
    }

    function modify() {
        $value['location'] = $this->input->post('location');
        $value['warehouseid'] = $this->input->post('warehouseid');
        $value['is_active'] = "Y";

        $value['id'] = $this->input->post('id');

        if (isset($_POST)) {
            $res = $this->locationmastermodel->modify($value);
            echo $res;
        }
    }

    function delete() {
        $value = $this->input->post('id');
        $result = $this->groupmastermodel->delete($value);
        echo $result;
    }

}

?>