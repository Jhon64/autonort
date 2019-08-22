<?php
$this->load->library('pdf');
$pdf=new PDF();
$pdf->SetFont('Arial', '', 14);
 $pdf->AddPage();

 $pdf->Output();
?>