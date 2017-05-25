<?php
    class salebillregister extends CI_Controller {
       function __construct() {
        parent::__construct();
        
        $this->load->model('salebillregistermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
        $this->load->model('customermastermodel','',TRUE);
		$this->load->model('taxinvoicemodel','',TRUE);
       
    }
    
     public function index() {

        if ($this->session->userdata('logged_in')) {
           
            $session = sessiondata_method();
            $headercontent['customer'] = $this->salebillregistermodel->getCustomerList($session);
			$headercontent['product'] = $this->taxinvoicemodel->getPacketProduct();
			
            $page = 'salebill_register/header_view';
            $header = "";
			$result="";
            createbody_method($result,$page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
    
      public function getSalebillRegister() {
          
         $session = sessiondata_method();
         $company = $session['company'];
		 $yearId = $session['yearid'];
         
        if ($this->session->userdata('logged_in')) {
       $startdate = date('Y-m-d',  strtotime($this->input->post('startdate')));
        $enddate = date('Y-m-d',  strtotime($this->input->post('enddate')));
        $customer =  $this->input->post('customer');
		$product = $this->input->post("product");
        
        $value = array(
            'startDate'=>$startdate,
            'endDate'=>$enddate,
            'customerId'=>$customer,
			'product'=>$product
        );
		
		$fdate = date('Y-m-d',strtotime($startdate));
		$tdate = date('Y-m-d',strtotime($enddate));
		$cid = $customer;
        
      //  $data['get_salebill_register'] = $this->salebillregistermodel->getSaleBillRegisterList($value,$company);
	  $data['get_salebill_register'] = $this->salebillregistermodel->getSaleBillRegisterData($fdate,$tdate,$cid,$company,$yearId);
	  $this->db->freeDBResource($this->db->conn_id); 
	/*
	echo "<pre>";
		print_r($data['get_salebill_register']);
		echo "</pre>";
	exit;*/
        $page = 'salebill_register/list_view';
        $view = $this->load->view($page, $data , TRUE );
        echo($view);
         } else {
            redirect('login', 'refresh');
        }
    }
    
    public function getsaleBillRegisterPdf(){
        $session = sessiondata_method();
        
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        
        $startDate = $this->input->post('startdate');
        $endDate = $this->input->post('enddate');
        $customerId = $this->input->post('customer');
		$product = $this->input->post("product");
        
        $value = array(
            'startDate'=>$startDate,
            'endDate'=>$endDate,
            'customerId'=>$customerId,
			'product'=>$product
        );
		
		$fdate = date('Y-m-d',strtotime($startDate));
		$tdate = date('Y-m-d',strtotime($endDate));
		$cid = $customerId;
        $result['company'] = $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']= $this->companymodel->getCompanyAddressById($companyId);
        $result['printDate'] = date('d-m-Y');
		$result['resultSalebill'] = $this->salebillregistermodel->getSaleBillRegisterData($fdate,$tdate,$cid,$companyId,$yearId);
		$this->db->freeDBResource($this->db->conn_id); 
	
		$this->load->library('pdf');
        $pdf = $this->pdf->load();
        ini_set('memory_limit', '256M'); 
        
          $page = 'salebill_register/salebill_register_pdf.php';
                
          $html = $this->load->view($page, $result, TRUE);
                $pdf->WriteHTML($html); 
                $output = 'salebill' . date('Y_m_d_H_i_s') . '_.pdf'; 
                $pdf->Output("$output", 'I');
                exit();
        
    }
    
 
    
    public function getsaleBillRegisterPrint(){
        
        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        
        $startDate = $this->input->post('startdate');
        $endDate = $this->input->post('enddate');
        $customerId = $this->input->post('customer');
        
        $value = array(
            'startDate'=>$startDate,
            'endDate'=>$endDate,
            'customerId'=>$customerId
        );
        
        $data['resultSalebill'] = $this->salebillregistermodel->getSaleBillRegisterList($value);
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        
            
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        ini_set('memory_limit', '256M'); 
       // $pdf = new mPDF('utf-8', array(203.2,152.4));
         
       
        $str='<html>'
              .'<head>'
              .'<title>SaleBill Register Pdf</title>'
              .'</head>'
              .'<body>';
                $str= $pdf->WriteHTML($str);  
                 $lncount=1;
           
                
                 /*--------------Company Detail-----------------------*/
       $str='<table width="100%">'
               .'<tr width="100%"><td align="center">'
               .'<span style="font-family:Verdana, Geneva, sans-serif; font-size:10px; font-weight:bold;">'.$result['company'].'<br>'. $result['companylocation']
               .'</span></td></tr>'
               .'</table>';
                $pdf->WriteHTML($str); 
               $lncount=$lncount+1;
                
                /*  Table Heading----------*/
        $str='<div style="margin-top:5%;"><table width="100%" cellspacing="4" cellpadding="2" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">'
              .'<tr>' 
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Customer</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">SaleBill No</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Salebill Dt</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Due Date</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Salebill Deatil</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Total Amt.</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Tax Amt.</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Discount Amt.</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Grand Total</td>'
              .'</tr>';
         $pdf->WriteHTML($str); 
       $lncount=$lncount+1;
       
         
         /* ------sale bill register data--------*/
         
            foreach($data['resultSalebill'] as $value){
               
                 $taxType=$value['taxrateType'];
                    if($taxType=='V'){
                    $taxAmountmt = "VAT: ".$value['taxamount'];
                    }
                    if($taxType=='C'){
                     $taxAmountmt = "CST:".$value['taxamount'];
                    }
                
                if($lncount>10){
                $pagebreak = $this->getheaderView($result['company'],$result['companylocation']);
                  $lncount=1;
                } 
                else{
                    $pagebreak='';
                }
            
                $str = '<tr style="background:#F7F7F7;text-align:center;">'
                       .'<td style="font-size:10px;">'.$value['customer_name']."Line Count".$lncount.'</td>' 
                       .'<td style="font-size:10px;">'.$value['salebillno'].'</td>' 
                       .'<td style="font-size:10px;">'.$value['SaleBlDt'].'</td>' 
                       .'<td style="font-size:10px;">'.$value['DueDt'].'</td>' 
                       .'<td>'
                       .'<table width="100%" cellspacing="4" cellpadding="2" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">'
                       .'<tr>'
                       .'<th width="40%">Product</th>'
                       .'<th>PackBox</th>'
                       .'<th>Net</th>'
                       .'<th>Rate</th>'
                       .'</tr>';
                
                 
                 $pdf->WriteHTML($str); 
                  $lncount=$lncount+1;
                 if($lncount>10){
                 $pagebreak = $this->getheaderView($result['company'],$result['companylocation']);
                  $lncount=1;
                } 
                else{
                    $pagebreak='';
                }
                 
                foreach ($value['salebilldetail'] as $detail){
                    
                   
                    
                    
                    $str = '<tr style="background:#E6E6E6;">'
                            .'<td width="40%">'.$detail['finalProduct'].'</td>'
                            .'<td>'.$detail['packingbox']."Line Count".$lncount.'</td>'
                            .'<td>'.$detail['packingnet'].'</td>'
                            .'<td>'.$detail['rate'].'</td>'
                            .'</tr>'; 
                    $pdf->WriteHTML($str);    
                    $lncount=$lncount+1;
                    if($lncount>10){
                $pagebreak = $this->getheaderView($result['company'],$result['companylocation']);
                  $lncount=1;
                } 
                else{
                    $pagebreak='';
                }
                }
                 $str= '</table></td>';
                 $pdf->WriteHTML($str);    
                
                    $str= '<td>'.$value['totalamount'].'</td>'
                       .'<td>'.$taxAmountmt.'</td>' 
                       .'<td>'.$value['discountAmount'].'</td>' 
                       .'<td>'.$value['grandtotal'].'</td>' 
                       .'</tr>'.$pagebreak;
                    
              $pdf->WriteHTML($str); 
              $lncount=$lncount+1;
             /* if($lncount>10){
                $pagebreak = $this->getheaderView($result['company'],$result['companylocation']);
                  $lncount=1;
                } 
                else{
                    $pagebreak='';
                }*/
              $pdf->setFooter("Page {PAGENO} of {nb}");
            
                
            }
         
        
        
        
       $str='</table></div>';  
       $pdf->WriteHTML($str); 
           
       $str = '</body></html>';
       $pdf->WriteHTML($str); 
      
        $output = 'salebillregister' . date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdf->Output("$output", 'I');
        exit();
        
        
        
    }
    
    
    
    
    
    
    
  public function getheaderView($com,$loc){
        $header ='</table></div><pagebreak /><table width="100%">'
               .'<tr width="100%"><td align="center">'
               .'<span style="font-family:Verdana, Geneva, sans-serif; font-size:10px; font-weight:bold;">'.$com.'<br>'.$loc
               .'</span></td></tr>'
               .'</table><div style="margin-top:5%;"><table width="100%" cellspacing="4" cellpadding="2" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">'
              .'<tr>' 
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Customer</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">SaleBill No</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Salebill Dt</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Due Date</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Salebill Deatil</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Tax Amt.</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Discount Amt.</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Total Amt.</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Grand Total</td>'
              .'</tr>';
        return $header;
                
        
    }
   
    
}
?>