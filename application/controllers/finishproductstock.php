<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of finishproductstock
 *
 * @author pc1
 */
class finishproductstock extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("finishedproductmodel", '', TRUE);
        $this->load->model("companymodel", '', TRUE);
    }

    public function index() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            $companyId = $session['company'];
            $yearId = $session['yearid'];
            $result['company'] = $this->companymodel->getCompanyNameById($companyId);
            $result["finishProdStock"] = $this->finishedproductmodel->getFinishProductStock($companyId, $yearId);
            $result["currentdate"] = date('d-m-Y');
            /* echo("<pre>");
              print_r($result);
              echo("</pre>"); */
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            ini_set('memory_limit', '256M');

           $page = 'finishproductstock/printPdf.php';
             $html = $this->load->view($page, $result, true);
            // render the view into HTML
            $pdf->WriteHTML($html);
            $output = 'stockPdf' . date('Y_m_d_H_i_s') . '_.pdf';
            $pdf->Output("$output", 'I');
            exit();
             //$this->load->view($page, $result);
        } else {
            redirect('login', 'refresh');
        }
    }

}
