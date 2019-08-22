<?php
include 'fpdf/fpdf.php';
class PDF extends FPDF{
    function Header()
    {
            //Logo
            $this->Image(base_url().'asset/imagenes/descarga.jpg', 40, 12, 40);
            //Arial bold 15
            $this->SetFont('Arial', 'B', 15);
            //Move to the right
            $this->Cell(70);
           $this->Cell(30, 10, "ESTE ES UN TEXTO DE ENCABEZADO", 0, 0, 'L');
           $this->Ln(6);
           $this->Cell(70);
           $this->Cell(30, 10, "SEGUNDA LÍNEA DEL TEXTO", 0, 1, 'L');
           $this->Ln(12);
   }
    
   //Page footer
   function Footer()
   {
           //Position at 1.5 cm from bottom
           $this->SetY(-15);
           //Arial italic 8
           $this->SetFont('Arial', 'I', 8);
           //Page number
           $this->Cell(0, 10, $this->PageNo(), 0, 0, 'C');
           $this->Cell(0, 0, 'Copyright '.utf8_decode('©').' 2015 ', 0, 1, 'R');
   }
}
?>