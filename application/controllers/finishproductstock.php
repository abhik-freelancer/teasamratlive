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
		$this->load->model('generalledgermodel', '', TRUE);
    }

    public function index() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
			
			$headercontent['startDt'] =  $this->generalledgermodel->getFiscalStartDt($session['yearid']);
			$page = 'finishproductstock/header_view';
            $header = "";
			$result = "";
			createbody_method($result,$page, $header, $session, $headercontent);
			
			/*
            $companyId = $session['company'];
            $yearId = $session['yearid'];
            $result['company'] = $this->companymodel->getCompanyNameById($companyId);
            $result["finishProdStock"] = $this->finishedproductmodel->getFinishProductStock($companyId, $yearId);
            $result["currentdate"] = date('d-m-Y');
           
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            ini_set('memory_limit', '256M');

           $page = 'finishproductstock/printPdf.php';
             $html = $this->load->view($page, $result, true);
           
            $pdf->WriteHTML($html);
            $output = 'stockPdf' . date('Y_m_d_H_i_s') . '_.pdf';
            $pdf->Output("$output", 'I');
            exit();
             */
			 
        } else {
            redirect('login', 'refresh');
        }
    }
	
	public function getFinishPrdStock()
	{
		if ($this->session->userdata('logged_in')) {
			 $session = sessiondata_method();
			$frm_dt = $this->input->post('startdate',TRUE);
			$to_date = $this->input->post('enddate',TRUE);
			
			$fdt = date("Y-m-d",strtotime($frm_dt));
			$tdt = date("Y-m-d",strtotime($to_date));
			
			$for_period = $frm_dt." To ".$to_date;
			
			$companyId = $session['company'];
            $yearId = $session['yearid'];
            $result['company'] = $this->companymodel->getCompanyNameById($companyId);
            $result["finishProdStock"] = $this->finishedproductmodel->getFinishProductStock($fdt,$tdt,$companyId, $yearId);
            $result["currentdate"] = date('d-m-Y');
            $result["for_period"] = $for_period;
          
           
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            ini_set('memory_limit', '256M');

           $page = 'finishproductstock/printPdf.php';
             $html = $this->load->view($page, $result, true);
           
            $pdf->WriteHTML($html);
            $output = 'stockPdf' . date('Y_m_d_H_i_s') . '_.pdf';
            $pdf->Output("$output", 'I');
            exit();
			
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

}
