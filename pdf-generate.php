<?php
require dirname(__FILE__) . '/lib/fpdf/fpdf.php';
require dirname(__FILE__) . '/lib/phpqrcode/qrlib.php';

require_once dirname(__FILE__) . '/config/config.php';
require_once dirname(__FILE__) . '/config/forms.php';

$itemId = isset($_GET["itemId"]) ? (int) $_GET["itemId"] : null;
$itemId = is_int($itemId) && $itemId > 0 ? $itemId : null;

if (!$itemId) {
	$phpPDFQRForms::Log("Error", "No id was provided by " . $_SESSION['labsal_user']);
	$phpPDFQRForms::flashSet("Error", "No se proporcionó ningun identificador.", "danger");
	header("location: " . $phpPDFQRForms::$rootURL . "/");
	die();
}

$pdfData = $phpPDFQRForms::showForm($itemId);

// Data:
//   Ancho del Doc: 8.5 Pulgadas
//   Alto del Doc: 11 Pulgadas
// Notar las posicoones representadas en numeros son en pulgadas
class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		// Logo Zogen (Arriba Derecha)
		$this->Image('media/zogen-logo.png', 7, 0.4, 1);

		// Logo Laboratorio Zalasar (Centrado)
		$this->Image('media/laboratorio-salazar-logo.png', 3, 0.4, 2.4);

		// Arial bold 15
		$this->SetFont('Helvetica', 'B', 10);

		// Alineamos la posicion de las axis
		$this->setXY(0.4, 1.4);

		// Título
		$this->Cell(0, 0.2, utf8_decode('Q.F.B. Clara Barocio Salazar'), 0, 0, 'C');
		$this->Ln();
		$this->Cell(0, 0.2, utf8_decode('D.G.P. 1524713'), 0, 0, 'C');
		$this->Ln();
		$this->SetLineWidth(0.02);
		$this->SetDrawColor(150, 150, 150);
		$this->Cell(0, 0.1, '', 'B', 1);
		$this->Cell(0, 0.1, '', 'B', 1);
		$this->SetDrawColor(0, 0, 0);

		// Salto de línea
		$this->Ln();
	}

	// Pie de página
	function Footer()
	{
		// Posición: a 1,5 cm del final
		$this->SetY(-1.1);

		// Arial italic 8
		$this->SetFont('Helvetica', 'I', 8);

		// Número de página
		$this->SetLineWidth(0.02);
		$this->SetDrawColor(150, 150, 150);
		$this->Cell(0, 0.1, '', 'B', 1);
		$this->Cell(0, 0.1, '', 'B', 1);
		$this->Cell(0, 0.1, '', 0, 1);
		$this->Cell(0, 0.2, utf8_decode('AV. Miguel Hidalgo# 704(Ruta 5) SN.92, MZA. 88 LT. 25, Cancún Q.ROO, C.P 77516, TEL. 888-91-10'), 0, 1, 'C');
		$this->Cell(0, 0.2, utf8_decode('analisisclinicos@laboratoriosalazar.com.mx / www.laboratoriosalazar.com.mx'), 0, 1, 'C');
		// $this->Cell(0, 0.2, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 1, 'C');
	}
}

// Creación del objeto de la clase heredada
// Data:
//   Ancho del Doc: 8.5 Pulgadas
//   Alto del Doc: 11 Pulgadas
// Notar las posicoones representadas en numeros son en pulgadas
$pdf = new PDF('P', 'in', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->AddFont('OpenSans-Light', '', 'OpenSans-Light.php');
$pdf->AddFont('OpenSans-Light', 'I', 'OpenSans-LightItalic.php');
$pdf->AddFont('OpenSans-Regular', '', 'OpenSans-Regular.php');
$pdf->AddFont('OpenSans-Regular', 'B', 'OpenSans-SemiBold.php');
$pdf->Ln();
$pdf->SetFont('OpenSans-Light', '', 11);
$pdf->Cell(1.35, 0.25, utf8_decode('Paciente // Patient: '), 0, 0);
$pdf->SetFont('OpenSans-Regular', 'B', 10);
$pdf->Cell(3.50, 0.25, utf8_decode($pdfData["first_name"] . ' ' . $pdfData["last_name"]), 0, 0);

$pdf->SetFont('OpenSans-Light', '', 11);
$pdf->Cell(0.85, 0.25, utf8_decode('Sexo // Sex: '), 0, 0);
$pdf->SetFont('OpenSans-Regular', 'B', 10);
$pdf->Cell(2.00, 0.25, utf8_decode($pdfData["sex"] == 'male' ? 'Masculino // Male' : 'Femenino // Female'), 0, 1);

$pdf->SetFont('OpenSans-Light', '', 11);
$pdf->Cell(1.30, 0.25, utf8_decode('Expediente // File: '), 0, 0);
$pdf->SetFont('OpenSans-Regular', 'B', 10);
$pdf->Cell(3.55, 0.25, utf8_decode($pdfData["expedient"]), 0, 0);

$pdf->SetFont('OpenSans-Light', '', 11);
$pdf->Cell(0.85, 0.25, utf8_decode('Edad // Age: '), 0, 0);
$pdf->SetFont('OpenSans-Regular', 'B', 10);
$tmpBD = new DateTime($pdfData["birthdate"]);
$tmpNow = new DateTime();
$tmpIntVal = $tmpBD->diff($tmpNow);
$pdf->Cell(2.00, 0.25, utf8_decode($tmpIntVal->y), 0, 1);

$pdf->SetFont('OpenSans-Light', '', 11);
$pdf->Cell(2.45, 0.25, utf8_decode('No. Pasaporte // Passport Number: '), 0, 0);
$pdf->SetFont('OpenSans-Regular', 'B', 10);
$pdf->Cell(2.40, 0.25, utf8_decode($pdfData["passport"]), 0, 0);

$pdf->SetFont('OpenSans-Light', '', 11);
$pdf->Cell(1.00, 0.25, utf8_decode('Fecha // Date: '), 0, 0);
$pdf->SetFont('OpenSans-Regular', 'B', 10);
$pdf->Cell(1.85, 0.25, utf8_decode($pdfData["test_date_result"]), 0, 1);

$pdf->SetFont('OpenSans-Light', '', 11);
$pdf->Cell(1.55, 0.25, utf8_decode('Doctor // Physician: '), 0, 1);
$pdf->SetFont('OpenSans-Regular', 'B', 10);
$pdf->Cell(4.85, 0.25, utf8_decode('A quien corresponda // To whom it may concern,'), 0, 1);

$pdf->Ln();

$pdf->SetFont('OpenSans-Light', '', 10);
$pdf->Cell('2.50', 0.30, utf8_decode('Examen // Test'), 'B', 0, 'C');
$pdf->Cell('0.09', 0.30, utf8_decode(''), 0, 0);
$pdf->Cell('2.50', 0.30, utf8_decode('Resultado // Result'), 'B', 0, 'C');
$pdf->Cell('0.09', 0.30, utf8_decode(''), 0, 0);
$pdf->Cell('2.50', 0.30, utf8_decode('Valor de Referencia // Reference Value'), 'B', 1, 'C');
$pdf->SetFont('OpenSans-Regular', 'B', 10);
$pdf->Cell('2.50', 0.30, utf8_decode($pdfData["test_type"] == 'antigen' ? 'Antígeno // Antigen' : 'PCR'), 0, 0, 'C');
$pdf->Cell('0.09', 0.30, utf8_decode(''), 0, 0);
$pdf->Cell('2.50', 0.30, utf8_decode($pdfData["test_result"]), 0, 0, 'C');
$pdf->Cell('0.09', 0.30, utf8_decode(''), 0, 0);
$pdf->Cell('2.50', 0.30, utf8_decode($pdfData["test_reference"]), 0, 1, 'C');

$pdf->Ln();

$pdf->SetFont('OpenSans-Light', '', 12);
$pdf->Cell(1.50, 0.30, utf8_decode('Muestra // Sample: '), 0, 0);
$pdf->SetFont('OpenSans-Regular', 'B', 11);
$pdf->Cell(6.60, 0.30, utf8_decode($pdfData["test_sample"]), 0, 1);

$pdf->SetFont('OpenSans-Light', '', 12);
$pdf->Cell(1.50, 0.30, utf8_decode('Método // Method: '), 0, 0);
$pdf->SetFont('OpenSans-Regular', 'B', 11);
$pdf->Cell(6.60, 0.30, utf8_decode($pdfData["test_method"]), 0, 1);

$currentY = $pdf->GetY();

// QR Test
$qrTest = 'qr-test-' . time();
$qrURL = 'qr-url-' . time();
$qrPDF = 'qr-pdf-' . time();

$pdfFilename = hash("sha256", $pdfData["id"]) . '.pdf';

QRcode::png('https://www.gob.mx/cms/uploads/attachment/file/604645/SARS-CoV-2_Rapid_Antigen_Test__Productos_Roche__S.A._de_C.V._.pdf', 'media/' . $qrTest . '.png');
QRcode::png('https://laboratoriosalazar.com.mx', 'media/' . $qrURL . '.png');
QRcode::png('https://laboratoriosalazar.com.mx/zonge_admin/pdf/' . $pdfFilename . '?source=QR&ref=' . $qrPDF, 'media/' . $qrPDF . '.png');


// Logo Zogen (Arriba Derecha)
$pdf->Image('media/' . $qrTest . '.png', 0.40, $currentY, 1.37);
$pdf->SetXY(0.40, $currentY + 1.37 - 0.15);
$pdf->SetFont('OpenSans-Light', 'I', 7);
$pdf->Cell(6.60, 0.30, utf8_decode('SARS-CoV-2 Rapid Antigen Test'), 0, 1);

$pdf->Image('media/' . $qrURL . '.png', 3.57, $currentY, 1.37);
$pdf->SetXY(3.57, $currentY + 1.37 - 0.15);
$pdf->SetFont('OpenSans-Light', 'I', 7);
$pdf->Cell(6.60, 0.30, utf8_decode('Sitio Web // Web Site'), 0, 1);

$pdf->Image('media/' . $qrPDF . '.png', 6.73, $currentY, 1.37);
$pdf->SetXY(6.73, $currentY + 1.37 - 0.15);
$pdf->SetFont('OpenSans-Light', 'I', 7);
$pdf->Cell(6.60, 0.30, utf8_decode('Resultados // Results'), 0, 1);

if (file_exists('media/' . $qrTest . '.png')) {
	unlink('media/' . $qrTest . '.png');
}

if (file_exists('media/' . $qrURL . '.png')) {
	unlink('media/' . $qrURL . '.png');
}

if (file_exists('media/' . $qrPDF . '.png')) {
	unlink('media/' . $qrPDF . '.png');
}

// $pdf->SetY($currentY);
$pdf->SetY($currentY + 1.37 + 0.15);

$pdf->SetFont('OpenSans-Light', 'I', 8);
$pdf->MultiCell(0, 0.20, utf8_decode('* Los resultados de pruebas de Antígeno no deben ser utilizados como la única base para diagnosticar o excluir una infección por SARS-CoV-2. Se debe valorar en conjunto con otras pruebas clínicas y la sintomatología del paciente. // Antigen test results should not be used as the sole basis to diagnose or exclude a SARS-CoV-2 infection. It should be assessed in conjunction with other clinical tests and the patient\'s symptoms.'));
$pdf->MultiCell(0, 0.20, utf8_decode('* Los resultados positivos sugieren una infección reciente. // Positive results suggest a recent infection.'));
$pdf->MultiCell(0, 0.20, utf8_decode('* Los resultados negativos no descartan una infección por SARS-CoV-2 particularmente en aquellas personas que hayan estado en contacto con el virus. Se debe considerar una prueba de seguimiento. // Negative results do not rule out SARS-CoV-2 infection, particularly in those who have been in contact with the virus. A follow up test should be considered.'));

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$currentY = $pdf->GetY();

$pdf->Image('media/signature.png', 3.57, $currentY - 1.00, 1.37);
$pdf->SetFont('OpenSans-Light', 'I', 11);
$pdf->Cell(0, 0.30, utf8_decode('Q.F.B. Clara Barocio Salazar'), 0, 1, 'C');

// $pdf->setXY(0.40, $currentY + 1.37 + 1.37 + 0.15);
$pdf->SetFont('OpenSans-Light', '', 10);
$pdf->MultiCell(0, 0.30, utf8_decode('La consulta en línea y/o la impresión de este documento no sustituye al original // Online consultation and / or printing of this document does not replace the original'));

$pdf->Output(dirname(__FILE__) . '/pdf/' . $pdfFilename, 'F');

header("location: " . $phpPDFQRForms::$rootURL . "/pdf/" . $pdfFilename);
die();
