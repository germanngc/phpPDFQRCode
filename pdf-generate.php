<?php
require_once dirname(__FILE__) . '/config/config.php';
require_once dirname(__FILE__) . '/config/forms.php';
require_once dirname(__FILE__) . '/lib/fpdf/fpdf-form.php';

$itemId = isset($_GET["itemId"]) ? (int) $_GET["itemId"] : null;
$itemId = is_int($itemId) && $itemId > 0 ? $itemId : null;

if (!$itemId) {
	$phpPDFQRForms::Log("Error", "No id was provided by " . $_SESSION['labsal_user']);
	$phpPDFQRForms::flashSet("Error", "No se proporcionó ningun identificador.", "danger");
	header("location: " . $phpPDFQRForms::$rootURL . "/");
	die();
}

$formData = $phpPDFQRForms::showForm($itemId);
$pdf = new formPDF($formData);
$pdf->Output(dirname(__FILE__) . '/pdf/' . $pdf->pdfFilename, 'F');

header("location: " . $phpPDFQRForms::$rootURL . "/pdf/" . $pdf->pdfFilename);
die();
