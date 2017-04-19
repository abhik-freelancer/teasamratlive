<?php

//we need to call PHP's session object to access it through CI
class Stocksummery extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('stocksummerymodel', '', TRUE);
        $this->load->model('teagroupmastermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
        
    }

    public function index() {
        $session = sessiondata_method();
        $this->companyId = $session['company'];
        $this->yearId = $session['yearid'];
      
         if ($this->session->userdata('logged_in')) {
             $result['teagrouplist'] =  $this->teagroupmastermodel->teagrouplist();
          } else {
           redirect('login', 'refresh');   
          }

        $headercontent = '';
        $page = 'stocksummery/header_view';
        $header = '';
        /* load helper class to create view */
        createbody_method($result, $page, $header, $session, $headercontent);
    }

    public function getTempStockTable(){
        $result['stock'] = $this->stocksummerymodel->getTempStockTable();
        
      echo('<pre>');
      print_r($result['stock']);
      echo('</pre>');
        
    }
    
    
    
   public function getStock(){
      
       $groupId = $this->input->post('groupId');
       $fromPrice = $this->input->post('fromPrice');
       $toPrice = $this->input->post('toPrice');
       $result['stock'] = $this->stocksummerymodel->getStock($groupId,$fromPrice,$toPrice);
       $this->load->view('stocksummery/list_view',$result);
       
       
             /*   $data['stock']=$this->stocksummerymodel->getStock($groupId,$fromPrice,$toPrice);
               $page = 'stocksummery/list_view';
               $view = $this->load->view($page, $data, TRUE);
               echo($view);*/
   }
   
    public function getStockPrint(){
        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];
		$groupReport="";
       
       
       
       
       $groupId = $this->input->post('group_code');
       $fromPrice = $this->input->post('fromPrice');
       $toPrice = $this->input->post('toPrice');
       
       $result['company']=  $this->companymodel->getCompanyNameById($companyId);
       $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
       //$result['dateRange'] =date('d-m-Y',  strtotime('01-04-2013')). " to ".date('d-m-Y');
       $result['printDate']=date('d-m-Y');
       $result['Groupwise']= $this->stocksummerymodel->getStockGroup($groupId,$fromPrice,$toPrice);
       $this->db->freeDBResource($this->db->conn_id); 
       
       
       
       foreach ($result['Groupwise'] as  $value) {
           
          
           $groupReport[$value['group_code']]=$this->stocksummerymodel->getStock($value['teagroup_master_id'],$fromPrice,$toPrice);
           $this->db->freeDBResource($this->db->conn_id); 
       }
       $result['stock']=$groupReport;
       /*echo('<pre>');
       print_r($result['stock']);
       echo('</pre>');
       exit;*/
       
       $this->load->view('stocksummery/stockreport',$result);
   }

   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
  /* public function getStockPrint(){
        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];
		$groupReport="";
       
       
       
       
       $groupId = $this->input->post('group_code');
       
       $result['company']=  $this->companymodel->getCompanyNameById($companyId);
       $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
       //$result['dateRange'] =date('d-m-Y',  strtotime('01-04-2013')). " to ".date('d-m-Y');
       $result['printDate']=date('d-m-Y');
       $result['Groupwise']= $this->stocksummerymodel->getStockGroup($groupId);
       $this->db->freeDBResource($this->db->conn_id); 
       
          $this->load->library('pdf');
            $pdf = $this->pdf->load();
             ini_set('memory_limit', '256M'); 
       
       foreach ($result['Groupwise'] as  $value) {
           
          
           $groupReport[$value['group_code']]=$this->stocksummerymodel->getStock($value['teagroup_master_id']);
           $this->db->freeDBResource($this->db->conn_id); 
       }
       $result['stock']=$groupReport;
       $lnCnt=1;
       $grpCount=1;
       $grpQty=0;
       $grpAmount=0;

       $sumQty=0;
       $sumAmount=0;
       
      // $pageBrk='<pagebreak>';
       $str='<table width="100%">'
               .'<tr><td align="left">'
                .'<span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">'.$result['company'].'<br>'. $result['companylocation']
                  .'</span></td>'
                    .'<td align=right><span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">'
                      .'Print Date '.$result['printDate']
                         .'</span></td>'
                .'</tr>'
                 .'<tr>'
                 .'<td colspan="2"><span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:500;">'
                  .'Closing stock summery as on '.$result['printDate']
                    .'</span></td>'
                .'</tr>'
            .'</table>';
        $pdf->WriteHTML($str);
        $lnCnt=$lnCnt+1;                 
        $str='<table width="100%" style="font-family:Verdana, Geneva, sans-serif;font-size:9px;">'
               . '<tr style="background:#EEE;">'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Location</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Garden</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Invoice</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Grade</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Lot</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Sale No</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Stock in Bags</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Net(Kgs.)</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Stock(in kgs)</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Cost Of Tea</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Amount(in Rs.)</th>'
               . '</tr>';
       $pdf->WriteHTML($str);
        $lnCnt=$lnCnt+1;                        
    foreach ( $result['stock'] as $key => $value) {   
        

       if($grpCount>1)
        {
            $str='<tr><td colspan="11"><hr></td></tr>';
            $pdf->WriteHTML($str);
            $lnCnt=$lnCnt+1;  

         if($lnCnt>60){
            $pageBrk=$this->generatePageBreak($result['company'],$result['companylocation'],$result['printDate']);
             $lnCnt=1;
        }else{
            $pageBrk='';
        }
            
            $str='<tr><td>Group Total</td><td colspan="8" align="right">'.number_format($grpQty,2).'</td><td colspan="2" align="right">'.number_format($grpAmount,2).'</td></tr>';
            $pdf->WriteHTML($str);
            $lnCnt=$lnCnt+1;  

         if($lnCnt>60){
            $pageBrk=$this->generatePageBreak($result['company'],$result['companylocation'],$result['printDate']);
             $lnCnt=1;
        }else{
            $pageBrk='';
        }
            
            
            $str='<tr><td colspan="11"><hr></td></tr>';
            $pdf->WriteHTML($str);
            $lnCnt=$lnCnt+1;  
  
         if($lnCnt>60){
            $pageBrk=$this->generatePageBreak($result['company'],$result['companylocation'],$result['printDate']);
            $lnCnt=1;
        }else{
            $pageBrk='';
        }
            
            
            $grpCount=1;
            $grpQty=0;
            $grpAmount=0;

            
        }    
        $str='<tr><td colspan="11">Tea Group : '.$key.'</td></tr>';  
        $pdf->WriteHTML($str);
        $lnCnt=$lnCnt+1;                        
//
         if($lnCnt>60){
            $pageBrk=$this->generatePageBreak($result['company'],$result['companylocation'],$result['printDate']);
            $lnCnt=1;
        }else{
            $pageBrk='';
        }

//        
    foreach($value as $rows)
    {
         if($lnCnt>60){
            $pageBrk=$this->generatePageBreak($result['company'],$result['companylocation'],$result['printDate']);
            $lnCnt=1;
        }else{
            $pageBrk='';
        }
       
        $str='<tr> <td>'.$rows['Location'].'---'.$lnCnt.'</td>'
                            .'<td>'.$rows['Garden'].'</td>'
                            .'<td>'.$rows['Invoice'].'</td>'
                            .'<td>'.$rows['Grade'].'</td>'
                            .'<td>'.$rows['lot'].'</td>'
                            .'<td>'.$rows['SaleNo'].'</td>'
                            .'<td align="right">'.number_format($rows['Numberofbags']).'</td>'
                            .'<td align="right">'.number_format($rows['NetKg'], 2).'</td>'
                            .'<td align="right">'.number_format($rows['NetBags'], 2).'</td>'
                            .'<td align="right">'.number_format($rows['costOfTea'], 2).'</td>'
                            .'<td align="right">'.number_format($rows['amount'], 2).'</td></tr>'.$pageBrk;
       
                          
                            $pdf->WriteHTML($str);
                             $lnCnt=$lnCnt+1;  
//                             
/*         if($lnCnt>60){
            $pageBrk=$this->generatePageBreak($result['company'],$result['companylocation'],$result['printDate']);
            $lnCnt=1;
        }else{
            $pageBrk='';
        }
//            
                             $grpCount=$grpCount+1;
                             
                             $grpQty=$grpQty+$rows['NetBags'];
                             $grpAmount=$grpAmount+$rows['amount'];

                             $sumQty=$sumQty+$rows['NetBags'];
                             $sumAmount=$sumAmount+$rows['amount'];
                             
                             /*if($lnCnt>30)
                             {
                                // $footerLine='--------------------------------------';
                                // $pdf->WriteHTML($footerLine);
                                // $str='<pagebreak>';
                                 //$pdf->AddPage();
                                 //$pdf->WriteHTML($str);
                                 $lnCnt=1;
                             }
                            
    } 
             }

            $str='<tr><td colspan="11"><hr></td></tr>';
            $pdf->WriteHTML($str);
            $lnCnt=$lnCnt+1;  
         if($lnCnt>60){
            $pageBrk=$this->generatePageBreak($result['company'],$result['companylocation'],$result['printDate']);
            $lnCnt=1;
        }else{
            $pageBrk='';
        }

            $str='<tr><td>Grand Total</td><td colspan="8" align="right">'.number_format($sumQty,2).'</td><td colspan="2" align="right">'.number_format($sumAmount,2).'</td></tr>';
            $pdf->WriteHTML($str);
            $lnCnt=$lnCnt+1;  

         if($lnCnt>60){
            $pageBrk=$this->generatePageBreak($result['company'],$result['companylocation'],$result['printDate']);
            $lnCnt=1;
        }else{
            $pageBrk='';
        }
            
            $str='<tr><td colspan="11"><hr></td></tr>';
            $pdf->WriteHTML($str);
            $lnCnt=$lnCnt+1;  
         if($lnCnt>60){
            $pageBrk=$this->generatePageBreak($result['company'],$result['companylocation'],$result['printDate']);
            $lnCnt=1;
        }else{
            $pageBrk='';
        }
             
             $str='</table>';
             $pdf->WriteHTML($str);
               $output = 'stocksummery' . date('Y_m_d_H_i_s') . '_.pdf'; 
                     $pdf->Output("$output", 'I');
    
    */
   
  
    
       
       
              
     
               
                          //$this->load->view('stocksummery/stockreport',$result);
   }
   /*
 public function getPdfheaderView(){
       $html=$this->load->view('stocksummery/header.php');
       echo $html;
   }*/
   
   


  /* public function getPdfStockReport(){
       
       $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];
		$groupReport="";
                
       $groupId = $this->input->post('groupId');
       
       $result['company']=  $this->companymodel->getCompanyNameById($companyId);
       $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
       //$result['dateRange'] =date('d-m-Y',  strtotime('01-04-2013')). " to ".date('d-m-Y');
       $result['printDate']=date('d-m-Y');
       $result['Groupwise']= $this->stocksummerymodel->getStockGroup($groupId);
       $this->db->freeDBResource($this->db->conn_id); 
       
       
       
       foreach ($result['Groupwise'] as  $value) {
           
          
           $groupReport[$value['group_code']]=$this->stocksummerymodel->getStock($value['teagroup_master_id']);
           $this->db->freeDBResource($this->db->conn_id); 
       }
       $result['stock']=$groupReport;
       
      
        // load library
                $this->load->library('pdf');
               // $pdf = new pdf();
                
                $pdf = $this->pdf->load();
                 ini_set('memory_limit', '256M'); 
                 $page='stocksummery/pdfStockreport.php';
                $html = $this->load->view($page, $result, true);
                // render the view into HTML
                $pdf->WriteHTML($html); 
                $output = 'stocksummery' . date('Y_m_d_H_i_s') . '_.pdf'; 
                $pdf->Output("$output", 'I');
                exit();
      /* echo('<pre>');
       print_r($result['stock']);
       echo('</pre>');
       exit;*/
   /*    
      // $this->load->view($page,$result);
   }*/
/*
public function generatePageBreak($com,$loc,$prnDt)
{
    $pb='</table><pagebreak />'
                    
                    
                    .'<table width="100%">'
               .'<tr><td align="left">'
                .'<span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">'.$com.'<br>'. $loc
                  .'</span></td>'
                    .'<td align=right><span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">'
                      .'Print Date '.$prnDt
                         .'</span></td>'
                .'</tr>'
                 .'<tr>'
                 .'<td colspan="2"><span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:500;">'
                  .'Closing stock summery as on '.$prnDt
                    .'</span></td>'
                .'</tr>'
            .'</table>'
                    
                    
                    . '<table width="100%" style="font-family:Verdana, Geneva, sans-serif; font-size:9px;">'
                    . '<tr style="background:#EEE;">'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Location</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Garden</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Invoice</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Grade</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Lot</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Sale No</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Stock in Bags</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Net(Kgs.)</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Stock(in kgs)</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Cost Of Tea</th>'
               . '<th style="padding:5px;font-family:Verdana, Geneva, sans-serif;font-size:11px;">Amount(in Rs.)</th>'
               . '</tr>';

       return $pb;
}

   
        }*/
   
   

?>
