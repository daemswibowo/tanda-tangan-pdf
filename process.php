<?php 
use setasign\Fpdf;
use setasign\Fpdi;
require 'vendor/autoload.php';
$x = $_POST['x'];
$y = $_POST['y'];
$pdf = new Fpdi\Fpdi();

//Set the source PDF file
$pagecount = $pdf->setSourceFile("pdf.pdf");
$halaman = 1;
if (isset($_POST['page'])) {
	$halaman = $_POST['page'];
}
//Import the first page of the file
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
//Use this page as template
// use the imported page and place it at point 20,30 with a width of 170 mm

#Print Hello World at the bottom of the page

//Select Arial italic 8
// $pdf->Image('download.png',45,220,15,10);

$pdf->Output("modified_pdf.pdf", "F");
?>