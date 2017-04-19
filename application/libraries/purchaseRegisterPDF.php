<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require('fpdf.php');

class purchaseRegisterPDF extends FPDF {

    // Extend FPDF using this class
    // More at fpdf.org -> Tutorials
    private $company;
    private $footerText;
    public function __construct($companyName,$footerText) {
        // Call parent constructor
        parent::__construct('P', 'mm', 'A4');
        $this->fontpath ='font/';
        $this->company = $companyName;
        $this->footerText = $footerText;
        
      
       // $this->Header();
        //$this->Footer();
    }

    public function Header() {
        // Logo
        // $this->Image('logo.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 12);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 10, $this->company, 1, 0, 'C');
        // Line break
        $this->Ln(20);
    }

// Page footer
    public function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        
       /*  $this->Cell(0,10,'-----------------');
         $this->Ln(3);
         $this->Cell(0,10,$this->footerText);
         $this->Ln(3);
         $this->Cell(0,10,'-----------------');
         $this->Ln(3); */
        
        
        
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
    
    
    
    
    function LoadData($file)
        {
            // Read file lines
            $lines = file($file);
            $data = array();
            foreach($lines as $line)
                $data[] = explode(';',trim($line));
            return $data;
        }

// Simple table
function BasicTable($header, $data)
    {
        // Header
        foreach($header as $col)
            $this->Cell(40,7,$col,1);
        $this->Ln();
        // Data
        foreach($data as $row)
        {
            foreach($row as $col)
                $this->Cell(40,6,$col,1);
            $this->Ln();
        }
    }

}

?>
