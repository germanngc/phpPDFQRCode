<?php
require dirname(__FILE__) . '/fpdf.php';
require dirname(__FILE__) . '/../phpqrcode/qrlib.php';

class formPDF extends FPDF
{
	public $pdfFilename = '';
	private $currentY = 0.4;

	public function __construct($formData)
	{
		parent::__construct('P', 'in', 'Letter');

		$this->AddPage();
		$this->AddFont('OpenSans-Light', '', 'OpenSans-Light.php');
		$this->AddFont('OpenSans-Light', 'I', 'OpenSans-LightItalic.php');
		$this->AddFont('OpenSans-Regular', '', 'OpenSans-Regular.php');
		$this->AddFont('OpenSans-Regular', 'B', 'OpenSans-SemiBold.php');
		$this->Ln();

		$this->formInformation($formData);
		$this->formQRS($formData['id']);
		$this->formDisclaimer();
	}

	function Header()
	{
		// Logo Zogen (Arriba Derecha)
		$this->Image(dirname(__FILE__) . '/../../media/zogen-logo.png', 7, 0.4, 1);

		// Logo Laboratorio Zalasar (Centrado)
		$this->Image(dirname(__FILE__) . '/../../media/laboratorio-salazar-logo.png', 3, 0.4, 2.4);

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

	function formInformation($formData)
	{
		$tmpBD = new DateTime($formData["birthdate"]);
		$tmpNow = new DateTime();
		$birthDay = $tmpBD->diff($tmpNow)->y;

		$this->SetFont('OpenSans-Light', '', 11);
		$this->Cell(1.35, 0.25, utf8_decode('Paciente / Patient: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 10);
		$this->Cell(3.50, 0.25, utf8_decode($formData["first_name"] . ' ' . $formData["last_name"]), 0, 0);

		$this->SetFont('OpenSans-Light', '', 11);
		$this->Cell(0.85, 0.25, utf8_decode('Sexo / Sex: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 10);
		$this->Cell(2.00, 0.25, utf8_decode($formData["sex"] == 'male' ? 'Masculino / Male' : 'Femenino / Female'), 0, 1);

		$this->SetFont('OpenSans-Light', '', 11);
		$this->Cell(1.30, 0.25, utf8_decode('Expediente / File: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 10);
		$this->Cell(3.55, 0.25, utf8_decode('RIH' . str_pad($formData['id'], 7, "0", STR_PAD_LEFT)), 0, 0);

		$this->SetFont('OpenSans-Light', '', 11);
		$this->Cell(0.85, 0.25, utf8_decode('Edad / Age: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 10);
		$this->Cell(2.00, 0.25, utf8_decode($birthDay), 0, 1);

		$this->SetFont('OpenSans-Light', '', 11);
		$this->Cell(2.45, 0.25, utf8_decode('No. Pasaporte / Passport Number: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 10);
		$this->Cell(2.40, 0.25, utf8_decode($formData["passport"]), 0, 0);

		$this->SetFont('OpenSans-Light', '', 11);
		$this->Cell(1.00, 0.25, utf8_decode('Fecha / Date: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 10);
		$this->Cell(1.85, 0.25, utf8_decode($formData["test_date_result"]), 0, 1);

		$this->SetFont('OpenSans-Light', '', 11);
		$this->Cell(1.55, 0.25, utf8_decode('Doctor / Physician: '), 0, 1);
		$this->SetFont('OpenSans-Regular', 'B', 10);
		$this->Cell(4.85, 0.25, utf8_decode('A quien corresponda / To whom it may concern,'), 0, 1);

		$this->Ln();

		$this->SetFont('OpenSans-Light', '', 10);
		$this->Cell('2.50', 0.30, utf8_decode('Examen / Test'), 'B', 0, 'C');
		$this->Cell('0.09', 0.30, utf8_decode(''), 0, 0);
		$this->Cell('2.50', 0.30, utf8_decode('Resultado / Result'), 'B', 0, 'C');
		$this->Cell('0.09', 0.30, utf8_decode(''), 0, 0);
		$this->Cell('2.50', 0.30, utf8_decode('Valor de Referencia / Reference Value'), 'B', 1, 'C');
		$this->SetFont('OpenSans-Regular', 'B', 10);
		$this->Cell('2.50', 0.30, utf8_decode($formData["test_type"] == 'antigen' ? 'Antígeno / Antigen' : 'RT-PCR'), 0, 0, 'C');
		$this->Cell('0.09', 0.30, utf8_decode(''), 0, 0);
		$this->Cell('2.50', 0.30, utf8_decode($formData["test_result"] == 'positive' ? '(+) Positivo / Positive' : '(-) Negativo / Negative'), 0, 0, 'C');
		$this->Cell('0.09', 0.30, utf8_decode(''), 0, 0);
		$this->Cell('2.50', 0.30, utf8_decode($formData["test_reference"] == 'positive' ? '(+) Positivo / Positive' : '(-) Negativo / Negative'), 0, 1, 'C');

		$this->Ln();

		$this->SetFont('OpenSans-Light', '', 12);
		$this->Cell(1.50, 0.30, utf8_decode('Muestra / Sample: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 11);
		$this->Cell(6.60, 0.30, utf8_decode($formData["test_sample"]), 0, 1);

		$this->SetFont('OpenSans-Light', '', 12);
		$this->Cell(1.50, 0.30, utf8_decode('Método / Method: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 11);
		$this->Cell(6.60, 0.30, utf8_decode($formData["test_method"]), 0, 1);
	}

	function formQRS($id)
	{
		$this->currentY = $currentY = $this->GetY();

		$qrTest = 'qr-test-' . time();
		$qrURL = 'qr-url-' . time();
		$qrPDF = 'qr-pdf-' . time();

		$this->pdfFilename = $pdfFilename = hash("sha256", $id) . '.pdf';

		QRcode::png(
			'https://www.gob.mx/cms/uploads/attachment/file/604645/SARS-CoV-2_Rapid_Antigen_Test__Productos_Roche__S.A._de_C.V._.pdf',
			dirname(__FILE__) . '/../../media/' . $qrTest . '.png'
		);
		QRcode::png(
			'https://laboratoriosalazar.com.mx',
			dirname(__FILE__) . '/../../media/' . $qrURL . '.png'
		);
		QRcode::png(
			'https://laboratoriosalazar.com.mx/zogen_admin/pdf/' . $pdfFilename . '?_labsal=true&_sourceScan=QR&_cache=' . $qrPDF,
			dirname(__FILE__) . '/../../media/' . $qrPDF . '.png'
		);

		// Logo Zogen (Arriba Derecha)
		$this->Image(dirname(__FILE__) . '/../../media/' . $qrTest . '.png', 0.40, $currentY, 1.37);
		$this->SetXY(0.40, $currentY + 1.37 - 0.15);
		$this->SetFont('OpenSans-Light', 'I', 7);
		$this->Cell(6.60, 0.30, utf8_decode('SARS-CoV-2 Rapid Antigen Test'), 0, 1);

		$this->Image(dirname(__FILE__) . '/../../media/' . $qrURL . '.png', 3.57, $currentY, 1.37);
		$this->SetXY(3.57, $currentY + 1.37 - 0.15);
		$this->SetFont('OpenSans-Light', 'I', 7);
		$this->Cell(6.60, 0.30, utf8_decode('Sitio Web / Web Site'), 0, 1);

		$this->Image(dirname(__FILE__) . '/../../media/' . $qrPDF . '.png', 6.73, $currentY, 1.37);
		$this->SetXY(6.73, $currentY + 1.37 - 0.15);
		$this->SetFont('OpenSans-Light', 'I', 7);
		$this->Cell(6.60, 0.30, utf8_decode('Resultados / Results'), 0, 1);

		if (file_exists(dirname(__FILE__) . '/../../media/' . $qrTest . '.png')) {
			unlink(dirname(__FILE__) . '/../../media/' . $qrTest . '.png');
		}

		if (file_exists(dirname(__FILE__) . '/../../media/' . $qrURL . '.png')) {
			unlink(dirname(__FILE__) . '/../../media/' . $qrURL . '.png');
		}

		if (file_exists(dirname(__FILE__) . '/../../media/' . $qrPDF . '.png')) {
			unlink(dirname(__FILE__) . '/../../media/' . $qrPDF . '.png');
		}

		$this->SetY($currentY + 1.37 + 0.15);
	}

	function formDisclaimer()
	{
		$this->SetFont('OpenSans-Light', 'I', 8);
		$this->MultiCell(0, 0.20, utf8_decode('* Los resultados de pruebas de Antígeno no deben ser utilizados como la única base para diagnosticar o excluir una infección por SARS-CoV-2. Se debe valorar en conjunto con otras pruebas clínicas y la sintomatología del paciente. / Antigen test results should not be used as the sole basis to diagnose or exclude a SARS-CoV-2 infection. It should be assessed in conjunction with other clinical tests and the patient\'s symptoms.'));
		$this->MultiCell(0, 0.20, utf8_decode('* Los resultados positivos sugieren una infección reciente. / Positive results suggest a recent infection.'));
		$this->MultiCell(0, 0.20, utf8_decode('* Los resultados negativos no descartan una infección por SARS-CoV-2 particularmente en aquellas personas que hayan estado en contacto con el virus. Se debe considerar una prueba de seguimiento. / Negative results do not rule out SARS-CoV-2 infection, particularly in those who have been in contact with the virus. A follow up test should be considered.'));

		$this->Ln();
		$this->Ln();
		$this->Ln();
		$this->Ln();

		$this->currentY = $currentY = $this->GetY();

		$this->Image(dirname(__FILE__) . '/../../media/signature.png', 3.57, $currentY - 1.00, 1.37);
		$this->SetFont('OpenSans-Light', 'I', 11);
		$this->Cell(0, 0.30, utf8_decode('Q.F.B. Clara Barocio Salazar'), 0, 1, 'C');

		$this->SetFont('OpenSans-Light', '', 10);
		$this->MultiCell(0, 0.30, utf8_decode('La consulta en línea y/o la impresión de este documento no sustituye al original / Online consultation and/or printing of this document does not replace the original'));
	}

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
