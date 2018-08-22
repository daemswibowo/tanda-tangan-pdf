<?php 
use setasign\Fpdf;
use setasign\Fpdi;
require 'vendor/autoload.php';

$x = 0;
$y = 0;
if (!empty($_POST['x']) || !empty($_POST['y'])) {
	$x = $_POST['x'];
	$y = $_POST['y'];
}

$pdf = new Fpdi\Fpdi();

// buka file pdfnya
$pagecount = $pdf->setSourceFile("pdf.pdf");

// menentukan halaman berapa yang ingin diedit
$halaman = 1;
if (!empty($_POST['page'])) {
	#jika parameter page maka set $halaman sesuai dengan parameter yang dikirim
	$halaman = $_POST['page'];
}

// import dan patch gambar ttd ke halaman yang dipilih
for ($pageNo=1; $pageNo<=$pagecount; $pageNo++) {
	$templateID = $pdf->importPage($pageNo);
	$pdf->getTemplateSize($templateID);
	$pdf->addPage();
	if ($pageNo==$halaman) {
		# tambah gambar
		$pdf->Image('download.png',$x,$y,70,30);
	}
	$pdf->useTemplate($templateID, -10, 20, 210);
}

$pdf->Output("modified_pdf.pdf", "F");
?>