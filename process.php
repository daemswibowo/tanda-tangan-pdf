<?php 
use setasign\Fpdf;
use setasign\Fpdi;
require 'vendor/autoload.php';

$pdf = new Fpdi\Fpdi();

// buka file pdfnya
$pagecount = $pdf->setSourceFile("pdf.pdf");

// import dan patch gambar ttd ke halaman yang dipilih
foreach ($_POST['page'] as $key => $page) {
	$templateID = $pdf->importPage($page);
	$pdf->getTemplateSize($templateID);
	$pdf->addPage();
	if ($_POST['ttd'][$key]) {
		# tambah gambar
		$pdf->Image('download.png',$_POST['x'][$key],$_POST['y'][$key],70,30);
	}
	$pdf->useTemplate($templateID, -10, 20, 210);
}

$pdf->Output("modified_pdf.pdf", "F");
?>