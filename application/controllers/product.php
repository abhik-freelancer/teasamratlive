<?php

//we need to call PHP's session object to access it through CI
class product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('productmodel', '', TRUE);
        $this->load->model('packetmodel', '', TRUE);
    }

    public function index() {

        $session = sessiondata_method();
        $result = $this->productmodel->productlist();
        $headercontent['packet'] = $this->packetmodel->packetlist();

        $page = 'product_master/list_view';
        $header = 'product_master/header_view';


        createbody_method($result, $page, $header, $session, $headercontent);
    }
   /* public function IsProductExist(){
        $product = $this->input->post('product');
        $productExist = $this->productmodel->IsProductExist($product);
        echo($productExist);
    }*/

    public function add() {
        $value['product'] = $this->input->post('product');
        $value['productdesc'] = $this->input->post('productdesc');
        $value['is_active'] = 'Y';
        $value['insertiondate']= date('Y-m-d H:i:s');
        $packets = $this->input->post('packets');


        if (isset($_POST)) {
            try{
                        $id = $this->productmodel->add($value,$packets);
                        if($id){
                            echo '1';
                        }  else {
                            echo '0';
            }
            }catch (Exception $e){
                echo '2';
            }
        }
    }

    public function modify() {
        $value['product'] = $this->input->post('product');
        $value['productdesc'] = $this->input->post('productdesc');
        $value['is_active'] = 'Y';
        $value['insertiondate']= date('Y-m-d H:i:s');

        $value['id'] = $this->input->post('productid');
        $packets = $this->input->post('packets');

        if (isset($_POST)) {
            try{
            $res = $this->productmodel->modify($value,$packets);
            if($res){
                echo('1');
            }else{
                echo('0');
            }
            }  catch (Exception $e){echo'2';}
        }
    }

    public function delete() {
        $value = $this->input->post('id');
        $result = $this->productmodel->delete($value);
        echo $result;
    }

}

?>