<?php
require dirname(__FILE__) . '/fpdf.php';
require dirname(__FILE__) . '/../phpqrcode/qrlib.php';

class formPDF extends FPDF
{
	public $pdfFilename = '';
	private $currentX = 0.4;
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
		$this->formQRS($formData['id'], $formData['test_type']);
		$this->formDisclaimer($formData['test_type']);
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
		$this->Ln();
		$currentX = $this->GetX();
		$currentY = $this->GetY();
		$this->SetDrawColor(150, 150, 150);
		$this->SetFillColor(150, 150, 150);
		$this->Rect($currentX, $currentY, 7.70, 0.01);
		$this->Rect($currentX, $currentY + 0.04, 7.70, 0.01);
	}

	function formInformation($formData)
	{
		$tmpBD = new DateTime($formData["birthdate"]);
		$tmpNow = new DateTime();
		$birthDay = $tmpBD->diff($tmpNow)->y;

		$this->SetFont('OpenSans-Light', '', 10);
		$this->Cell(1.20, 0.20, utf8_decode('Paciente / Patient: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 9);
		$this->Cell(3.65, 0.20, utf8_decode($formData["first_name"] . ' ' . $formData["last_name"]), 0, 0);

		$this->SetFont('OpenSans-Light', '', 10);
		$this->Cell(0.70, 0.20, utf8_decode('Sexo / Sex: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 9);
		$this->Cell(2.15, 0.20, utf8_decode($formData["sex"] == 'male' ? 'Masculino / Male' : 'Femenino / Female'), 0, 1);

		$this->SetFont('OpenSans-Light', '', 10);
		$this->Cell(1.15, 0.20, utf8_decode('Expediente / File: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 9);
		$this->Cell(3.70, 0.20, utf8_decode('RIH' . str_pad($formData['id'], 7, "0", STR_PAD_LEFT)), 0, 0);

		$this->SetFont('OpenSans-Light', '', 10);
		$this->Cell(0.75, 0.20, utf8_decode('Edad / Age: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 9);
		$this->Cell(2.10, 0.20, utf8_decode($birthDay), 0, 1);

		$this->SetFont('OpenSans-Light', '', 10);
		$this->Cell(3.20, 0.20, utf8_decode('Fecha de Nacimiento / Date of Birth (mm/dd/yyyy): '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 9);
		$this->Cell(1.65, 0.20, utf8_decode(date('m/d/Y', strtotime($formData["birthdate"]))), 0, 0);

		$this->SetFont('OpenSans-Light', '', 10);
		$this->Cell(0.75, 0.20, utf8_decode(''), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 9);
		$this->Cell(2.10, 0.20, utf8_decode(''), 0, 1);

		$this->SetFont('OpenSans-Light', '', 10);
		$this->Cell(2.20, 0.20, utf8_decode('No. Pasaporte / Passport Number: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 9);
		$this->Cell(2.65, 0.20, utf8_decode($formData["passport"]), 0, 0);

		$this->SetFont('OpenSans-Light', '', 10);
		$this->Cell(0.85, 0.20, utf8_decode('Fecha / Date: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 9);
		$this->Cell(1.70, 0.20, utf8_decode($formData["test_date_result"]), 0, 1);

		$this->SetFont('OpenSans-Light', '', 10);
		$this->Cell(1.20, 0.20, utf8_decode('Doctor / Physician: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 9);
		$this->Cell(6.50, 0.20, utf8_decode('A quien corresponda / To whom it may concern.'), 0, 1);

		$this->Ln();

		$this->SetFont('OpenSans-Light', '', 10);
		$this->Cell('2.50', 0.30, utf8_decode('Examen / Test'), 'B', 0, 'C');
		$this->Cell('0.09', 0.30, utf8_decode(''), 0, 0);
		$this->Cell('2.50', 0.30, utf8_decode('Resultado / Result'), 'B', 0, 'C');
		$this->Cell('0.09', 0.30, utf8_decode(''), 0, 0);
		$this->Cell('2.50', 0.30, utf8_decode('Valor de Referencia / Reference Value'), 'B', 1, 'C');
		$this->SetFont('OpenSans-Regular', 'B', 9);
		$this->Cell('2.50', 0.30, utf8_decode($formData["test_type"] == 'antigen' ? 'Antígeno / Antigen' : 'SARS-CoV-2-PCR'), 0, 0, 'C');
		$this->Cell('0.09', 0.30, utf8_decode(''), 0, 0);

		if (utf8_decode($formData["test_type"]) == 'antigen') {
			$this->Cell('2.50', 0.30, utf8_decode($formData["test_result"] == 'positive' ? '(+) Positivo / Positive' : '(-) Negativo / Negative'), 0, 0, 'C');
			$this->Cell('0.09', 0.30, utf8_decode(''), 0, 0);
			$this->Cell('2.50', 0.30, utf8_decode($formData["test_reference"] == 'positive' ? '(+) Positivo / Positive' : '(-) Negativo / Negative'), 0, 1, 'C');
		} else {
			$this->Cell('2.50', 0.30, utf8_decode('-'), 0, 0, 'C');
			$this->Cell('0.09', 0.30, utf8_decode(''), 0, 0);
			$this->Cell('2.50', 0.30, utf8_decode('-'), 0, 1, 'C');
		}

		if (utf8_decode($formData["test_type"]) != 'antigen') {
			$this->SetFont('OpenSans-Regular', 'B', 9);
			$this->Cell('2.50', 0.20, utf8_decode('Observaciones / Observations:'), 0, 0, 'R');
			$this->SetFont('OpenSans-Regular', '', 9);
			$this->Cell('0.09', 0.20, utf8_decode(''), 0, 0);
			$this->Cell('2.50', 0.10, utf8_decode(''), 0, 0, 'C');
			$this->Cell('0.09', 0.20, utf8_decode(''), 0, 0);
			$this->Cell('2.50', 0.20, utf8_decode(''), 0, 1, 'C');

			$pcr_observations_arr = explode(';', $formData['pcr_observations'] ? $formData['pcr_observations'] : '');
			$pcr_observations_sample_arr = explode(';', $formData['pcr_observations_sample'] ? $formData['pcr_observations_sample'] : '');

			$this->SetFont('OpenSans-Regular', 'B', 9);
			$this->Cell('2.50', 0.20, utf8_decode('* Gen E:'), 0, 0, 'R');
			$this->SetFont('OpenSans-Regular', '', 9);
			$this->Cell('0.09', 0.20, utf8_decode(''), 0, 0);
			$this->Cell('2.50', 0.10, utf8_decode(in_array('gen_e', $pcr_observations_arr) ? '(+) Detectado / Detected' : '(-) No Detectado / Not Detected'), 0, 0, 'C');
			$this->Cell('0.09', 0.20, utf8_decode(''), 0, 0);
			$this->Cell('2.50', 0.20, utf8_decode(in_array('gen_e', $pcr_observations_sample_arr) ? '(+) Detectado / Detected' : '(-) No Detectado / Not Detected'), 0, 1, 'C');

			$this->SetFont('OpenSans-Regular', 'B', 9);
			$this->Cell('2.50', 0.20, utf8_decode('* Gen N:'), 0, 0, 'R');
			$this->SetFont('OpenSans-Regular', '', 9);
			$this->Cell('0.09', 0.20, utf8_decode(''), 0, 0);
			$this->Cell('2.50', 0.10, utf8_decode(in_array('gen_n', $pcr_observations_arr) ? '(+) Detectado / Detected' : '(-) No Detectado / Not Detected'), 0, 0, 'C');
			$this->Cell('0.09', 0.20, utf8_decode(''), 0, 0);
			$this->Cell('2.50', 0.20, utf8_decode(in_array('gen_n', $pcr_observations_sample_arr) ? '(+) Detectado / Detected' : '(-) No Detectado / Not Detected'), 0, 1, 'C');

			$this->SetFont('OpenSans-Regular', 'B', 9);
			$this->Cell('2.50', 0.20, utf8_decode('* RNAaseP:'), 0, 0, 'R');
			$this->SetFont('OpenSans-Regular', '', 9);
			$this->Cell('0.09', 0.20, utf8_decode(''), 0, 0);
			$this->Cell('2.50', 0.10, utf8_decode(in_array('rnaasep', $pcr_observations_arr) ? '(+) Detectado / Detected' : '(-) No Detectado / Not Detected'), 0, 0, 'C');
			$this->Cell('0.09', 0.20, utf8_decode(''), 0, 0);
			$this->Cell('2.50', 0.20, utf8_decode(in_array('rnaasep', $pcr_observations_sample_arr) ? '(+) Detectado / Detected' : '(-) No Detectado / Not Detected'), 0, 1, 'C');

			$this->Ln();

			$this->SetFont('OpenSans-Light', '', 10);
			$this->Cell(2.00, 0.30, utf8_decode('Interpretación / Interpretation: '), 0, 0);
			$this->SetFont('OpenSans-Regular', 'B', 9);
			$this->Cell(6.10, 0.30, utf8_decode($formData["pcr_interpretation"] == 'positive' ? '(+) Positivo / Positive' : '(-) Negativo / Negative'), 0, 1);
		} else {
			$this->Ln();
		}
		

		$this->SetFont('OpenSans-Light', '', 10);
		$this->Cell(1.20, 0.30, utf8_decode('Muestra / Sample: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 9);
		$this->Cell(6.90, 0.30, utf8_decode($formData["test_sample"]), 0, 1);

		$this->SetFont('OpenSans-Light', '', 10);
		$this->Cell(1.20, 0.30, utf8_decode('Método / Method: '), 0, 0);
		$this->SetFont('OpenSans-Regular', 'B', 9);
		$this->Cell(6.90, 0.30, utf8_decode($formData["test_method"]), 0, 1);
	}

	function formQRS($id, $test_type)
	{
		$this->SetXY(0.40, 6.0);
		$this->currentY = $currentY = $this->GetY();

		$qrTest = 'qr-test-' . time();
		$qrURL = 'qr-url-' . time();
		$qrPDF = 'qr-pdf-' . time();

		$this->pdfFilename = $pdfFilename = 'RIH' . str_pad($id, 7, "0", STR_PAD_LEFT) . '_' . hash("sha256", $id) . '.pdf';

		if ($test_type == 'antigen') {
			QRcode::png(
				'https://www.gob.mx/cms/uploads/attachment/file/604645/SARS-CoV-2_Rapid_Antigen_Test__Productos_Roche__S.A._de_C.V._.pdf',
				dirname(__FILE__) . '/../../media/' . $qrTest . '.png'
			);
		} else {
			QRcode::png(
				'https://www.gob.mx/cms/uploads/attachment/file/590301/FLU-COVID_RT-PCR_KIT__MCD__Servicios_Integrales_de_Diagn_sticos__S.A._de_C.V._.pdf',
				dirname(__FILE__) . '/../../media/' . $qrTest . '.png'
			);
		}
		
		QRcode::png(
			'https://laboratoriosalazar.com.mx',
			dirname(__FILE__) . '/../../media/' . $qrURL . '.png'
		);
		QRcode::png(
			'https://laboratoriosalazar.com.mx/zogen_admin/pdf/' . $pdfFilename . '?_labsal=true&_sourceScan=QR&_stamp=' . $qrPDF,
			dirname(__FILE__) . '/../../media/' . $qrPDF . '.png'
		);

		// Logo Zogen (Arriba Derecha)
		$this->Image(dirname(__FILE__) . '/../../media/' . $qrTest . '.png', 0.40, $currentY, 1.37);
		$this->SetXY(0.40, $currentY + 1.37 - 0.15);
		$this->SetFont('OpenSans-Light', 'I', 7);
		$this->Cell(6.60, 0.30, utf8_decode($test_type == 'antigen' ? 'SARS-CoV-2 Rapid Antigen Test' : 'FLU-COVID RT-PCR KIT'), 0, 1);
		$this->SetXY(0.40, $currentY + 1.47 - 0.15);
		$this->Cell(6.60, 0.30, utf8_decode($test_type == 'antigen' ? '(Productos Roche, S.A. De C.V.)' : '(MCD, Servicios Integrales De Diagnósticos, S.A. De C.V.)'), 0, 1);

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

		$this->SetY($currentY + 1.37 + 0.20);
	}

	function formDisclaimer($test_type)
	{
		$this->currentX = $currentX = $this->GetX();
		$this->currentY = $currentY = $this->GetY();

		$this->SetFont('OpenSans-Light', 'I', 8);

		if (utf8_decode($test_type) == 'antigen') {
			$this->SetX($currentX + 2.00);
			$this->MultiCell(5.66, 0.16, utf8_decode('* Los resultados de pruebas de Antígeno no deben ser utilizados como la única base para diagnosticar o excluir una infección por SARS-CoV-2. Se debe valorar en conjunto con otras pruebas clínicas y la sintomatología del paciente. / Antigen test results should not be used as the sole basis to diagnose or exclude a SARS-CoV-2 infection. It should be assessed in conjunction with other clinical tests and the patient\'s symptoms.'));
			$this->SetX($currentX + 2.00);
			$this->MultiCell(5.66, 0.16, utf8_decode('* Los resultados positivos sugieren una infección reciente. / Positive results suggest a recent infection.'));
			$this->SetX($currentX + 2.00);
			$this->MultiCell(5.66, 0.16, utf8_decode('* Los resultados negativos no descartan una infección por SARS-CoV-2 particularmente en aquellas personas que hayan estado en contacto con el virus. Se debe considerar una prueba de seguimiento. / Negative results do not rule out SARS-CoV-2 infection, particularly in those who have been in contact with the virus. A follow up test should be considered.'));
			$this->Cell(0, 0.15, '', 0, 1);
		} else {
			$this->SetX($currentX + 2.00);
			$this->MultiCell(5.66, 0.16, utf8_decode('* Método RT-PCR cuantitativo en tiempo real (qPCR TR) / Quantitative real-time RT-PCR method (qPCR TR).'));
			$this->SetX($currentX + 2.00);
			$this->MultiCell(5.66, 0.16, utf8_decode('* Principio del método RT-PCR es la identificación de la presencia de SARS-CoV2 a través de retrotranscripción y posterior monitoreo de la amplificación en tiempo real de las secuencias conservada de los genes E y N del virus COV2. La prueba incluye la amplificación de un control interno (RNase P de Humanos) / Principle of the RT-PCR method is the identification of the presence of SARS-CoV2 through reverse transcription and subsequent monitoring of the real-time amplification of the conserved sequences of the E and N genes of the COV2 virus. The test includes the amplification of an internal control (Human RNase P).'));
			$this->SetX($currentX + 2.00);
			$this->MultiCell(5.66, 0.16, utf8_decode('* La Organización Mundial de la Salud (OMS) recomendó que se considerara como caso positivo cuando se detecta la presencia de un solo gen del SARS-CoV-2. / The World Health Organization (WHO) recommended that it be considered a positive case when the presence of a single SARS-CoV-2 gene is detected.'));
			$this->SetX($currentX + 2.00);
			$this->MultiCell(5.66, 0.16, utf8_decode('* El estuche de la prueba SARS-CoV2 está validado por el InDRE Oficio DGE DSAT07184-2020 / The SARS-CoV2 test kit is validated by the InDRE Official document DGE DSAT07184-2020.'));
		}

		$this->Image(dirname(__FILE__) . '/../../media/signature.png', 0.40, $currentY + 0.30, 1.37);
		$this->SetY($currentY + 1.30);
		$this->SetFont('OpenSans-Light', 'I', 10);
		$this->Cell(0, 0.30, utf8_decode('Q.F.B. Clara Barocio Salazar'), 0, 1);

		$this->SetY($currentY + 2.10);
		$this->SetFont('OpenSans-Light', '', 9);
		$this->MultiCell(0, 0.15, utf8_decode('La consulta en línea y/o la impresión de este documento no sustituye al original / Online consultation and/or printing of this document does not replace the original'));
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
