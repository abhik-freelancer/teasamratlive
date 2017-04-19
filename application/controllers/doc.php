<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class doc extends CI_Controller {
    
  function __construct()
  {
     parent::__construct();
    $this->load->library('pdf'); 
    $this->pdf->fontpath = 'font/'; 
  }
  public function index()
  {
  
      
     //$pdf = new Pdf('P','mm','A4');
    $this->pdf->AddPage();
    $this->pdf->SetFont('courier','B',16);
    $this->pdf->Cell(40,10,'Hello World!');
    $this->pdf->Output();
  }
    
 
  
}
?>