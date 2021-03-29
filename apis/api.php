<?php
header("Content-Type: application/json;charset=utf-8");

require_once dirname(__FILE__) . '/../config/config.php';
require_once dirname(__FILE__) . '/../config/forms.php';
require_once dirname(__FILE__) . '/../config/email.php';
require_once dirname(__FILE__) . '/../lib/fpdf/fpdf-form.php';


class phpPDFQRAPI extends phpPDFQRConfig
{
	public static $phpPDFQRForms = [];
	public static $phpPDFQREmail = null;

	// Do not remove or phpPDFQRConfig construct will be executed twice
	public function __construct() {}

	public static function getForms()
	{
		$columns = [
			0 => 'checkbox_',
			1 => 'pdf_',
			2 => 'email_',
			3 => 'edit_',
			4 => 'id',
			5 => 'first_name',
			6 => 'last_name',
			7 => 'email',
			8 => 'birthdate',
			9 => 'sex',
			10 => 'passport',
			11 => 'villa',
			12 => 'reservation_number',
			13 => 'symptoms',
			14 => 'book_type',
			15 => 'book_family',
			16 => 'test_type',
			17 => 'test_date_taken',
			18 => 'test_date_result',
			19 => 'test_result',
			20 => 'test_reference',
			21 => 'test_sample',
			22 => 'test_method',
			23 => 'created_at',
			25 => 'updated_at'
		];

		$where = "";
		$order_col = isset($_REQUEST['order']) && isset($_REQUEST['order'][0]) && isset($_REQUEST['order'][0]['column']) ?
			'`' . $columns[$_REQUEST['order'][0]['column']] . '`':
			'`id`';
		$order_dir = isset($_REQUEST['order']) && isset($_REQUEST['order'][0]) && isset($_REQUEST['order'][0]['dir']) ?
			$_REQUEST['order'][0]['dir'] :
			'desc';
		$order_by = "ORDER BY {$order_col} {$order_dir}";
		$search_value = isset($_REQUEST['search']) && isset($_REQUEST['search']['value']) ?
			trim($_REQUEST['search']['value']) :
			'';
		$limit = 'LIMIT 0,25';
		if (isset($_REQUEST['start']) && isset($_REQUEST['length'])) {
			$limit = 'LIMIT ' . $_REQUEST['start'] . "," . $_REQUEST['length'];
		}

		if (!empty($search_value)) { 
			$where .= " WHERE (" .
				"`id` LIKE '" . $search_value . "%' " .
				"OR `first_name` LIKE '" . $search_value . "%' " .
				"OR `last_name` LIKE '" . $search_value . "%' " .
				"OR `email` LIKE '" . $search_value . "%' " .
				"OR `birthdate` LIKE '" . $search_value . "%' " .
				"OR `sex` LIKE '" . $search_value . "%' " .
				"OR `passport` LIKE '" . $search_value . "%' " .
				"OR `villa` LIKE '" . $search_value . "%' " .
				"OR `reservation_number` LIKE '" . $search_value . "%' " .
				"OR `symptoms` LIKE '" . $search_value . "%' " .
				"OR `book_type` LIKE '" . $search_value . "%' " .
				"OR `book_family` LIKE '" . $search_value . "%' " .
				"OR `test_type` LIKE '" . $search_value . "%' " .
				"OR `test_date_taken` LIKE '" . $search_value . "%' " .
				"OR `test_date_result` LIKE '" . $search_value . "%' " .
				"OR `test_result` LIKE '" . $search_value . "%' " .
				"OR `test_reference` LIKE '" . $search_value . "%' " .
				"OR `test_sample` LIKE '" . $search_value . "%' " .
				"OR `test_method` LIKE '" . $search_value . "%' " .
				"OR `created_at` LIKE '" . $search_value . "%' " .
				"OR `updated_at` LIKE '" . $search_value . "%' " .
				")";
		}
		
		$totalRecordsSql = "SELECT count(`id`) AS `total` FROM `covid_tests` {$where};";
		$totalRecordsQuery = mysqli_query(self::$con, $totalRecordsSql);
		$totalRecordsFetch = mysqli_fetch_array($totalRecordsQuery, MYSQLI_ASSOC);
		$totalRecords = isset($totalRecordsFetch["total"]) ? $totalRecordsFetch["total"] : 0;

		$resultsSql = "SELECT `id`, `first_name`, `last_name`, `email`, `birthdate`, `sex`, `passport`, `villa`, `reservation_number`, " .
			"`symptoms`, `book_type`, `book_family`, `test_type`, `test_date_taken`, `test_date_result`, `test_result`, `test_reference`, " .
			"`test_sample`, `test_method`, `created_at`, `updated_at` " .
			"FROM `covid_tests` {$where} " .
			"{$order_by} " .
			"{$limit}" .
			";";
		$resultsQuery = mysqli_query(self::$con, $resultsSql);
		$results = [];

		while ($row = mysqli_fetch_array($resultsQuery, MYSQLI_ASSOC)) {
			$disabbled = false;

			if (!$row['test_date_result'] || !$row['test_result']) {
				$disabbled = true;
			}

			$results[] = [
				'<input class="checkDataTable" type="checkbox" name="id[]" value="' . $row["id"] . '"' . ($disabbled ? ' disabled' : '') . '>',
				'<button type="button" class="btn btn-primary' . ($disabbled ? ' disabled' : '') . '" ' .
					'onclick="window.open(\'' . self::$rootURL . '/pdf-generate.php?itemId=' . $row['id'] . '\', \'_blank\');">' .
					'<i class="fas fa-download"></i> &nbsp; <i class="far fa-file-pdf"></i></button>',
				'<button type="button" data-id="' . $row['id'] . '" class="btn btn-primary sendEmail' . ($disabbled ? ' disabled' : '') . '">' .
					'&nbsp;<i class="fas fa-envelope-open-text"></i>&nbsp;</button>',
				'<button type="button" class="btn btn-primary" ' .
					'onclick="window.open(\'' . self::$rootURL . '/form-edit.php?id=' . $row['id'] . '\', \'_self\');">' .
					'&nbsp;<i class="fas fa-edit"></i>&nbsp;</button>',
				'RIH' . str_pad($row['id'], 7, "0", STR_PAD_LEFT),
				$row['first_name'],
				$row['last_name'],
				$row['email'],
				$row['birthdate'],
				$row['sex'] == 'male' ? 'Male' : 'Female',
				$row['passport'],
				$row['reservation_number'],
				$row['villa'],
				str_replace(";", "\n\r<br>", $row['symptoms']),
				$row['book_type'] == 'individual' ? 'Myself' : 'Group or family',
				$row['book_family'] == 'yes' ? 'Yes' : 'No',
				$row['test_type'] == 'antigen' ? 'COVID-19 Antigen Test' : 'COVID-19 RT-PCR Test',
				$row['test_date_taken'],
				$row['test_date_result'],
				$row['test_result'] == 'positive' ? '(+) Positivo / Positive' : '(-) Negativo / Negative',
				$row['test_reference'] == 'positive' ? '(+) Positivo / Positive' : '(-) Negativo / Negative',
				$row['test_sample'],
				$row['test_method'],
				$row['created_at'],
				$row['updated_at']
			];
		}

		$json_data = [
			"draw" => intval($_REQUEST['draw']),
			"recordsTotal" => intval($totalRecords),
			"recordsFiltered" => intval($totalRecords),
			"data" => $results
		];

		return json_encode($json_data);
	}

	public static function bulkPDF($itemsId)
	{
		$collectionNames = [
			'data' => [],
			'filename' => '',
			'message' => 'Paquete Generado con Éxito.',
			'response' => true
		];

		if ($_SERVER["REQUEST_METHOD"] != "POST") {
			self::Log("Error", "Invalid request by " . $_SESSION['labsal_user']);
			self::flashSet("Error", "Petición inválida al servidor.", "danger");

			$collectionNames['message'] = 'Metodo no soportado.';
			$collectionNames['response'] = false;

			return $collectionNames;
		}

		$zip = new ZipArchive;
		$zipPath = dirname(__FILE__) . '/../zip/' . hash("sha256", $_SESSION['labsal_user']) . '/';
		$zipName = 'zogen_admin_pdf_package.zip';

		if (!file_exists($zipPath)) {
			mkdir($zipPath, 0775, true);
		}

		if ($zip->open($zipPath . $zipName,  ZipArchive::CREATE)) {
			foreach ($itemsId AS $id) {
				$formData = self::$phpPDFQRForms::showForm($id);

				if (!$formData['test_date_result'] || !$formData['test_result']) return;

				$pdf = new formPDF($formData);
				$collectionNames['data'][] = dirname(__FILE__) . '/../pdf/' . $pdf->pdfFilename;
				$zip->addFile(dirname(__FILE__) . '/../pdf/' . $pdf->pdfFilename, $pdf->pdfFilename);
				$pdf->Output(dirname(__FILE__) . '/../pdf/' . $pdf->pdfFilename, 'F');
				unset($pdf);
			}

			$zip->close();
		} else {
			self::Log("Error", "Unable to generate ZIP archive of PDF by " . $_SESSION['labsal_user']);

			$collectionNames['message'] = 'No fue posible generar el paquete.';
			$collectionNames['response'] = false;
		}

		$collectionNames['filename'] = self::$rootURL . '/zip/' . hash("sha256", $_SESSION['labsal_user']) . '/' . $zipName . '?_labsal=true&_stamp=' . time();

		return $collectionNames;
	}

	public static function bulkEmail($itemsId)
	{
		$collectionNames = [
			'data_err' => [],
			'data_success' => [],
			'message' => 'Correos Evniados con Éxito.',
			'response' => true
		];

		if ($_SERVER["REQUEST_METHOD"] != "POST") {
			self::Log("Error", "Invalid request by " . $_SESSION['labsal_user']);
			self::flashSet("Error", "Petición inválida al servidor.", "danger");

			$collectionNames['message'] = 'Metodo no soportado.';
			$collectionNames['response'] = false;

			return $collectionNames;
		}

		$subject = "Laboratorio Salazar - Your SARS-CoV-2 (COVID-19) test is ready";

		foreach ($itemsId AS $id) {
			$formData = self::$phpPDFQRForms::showForm($id);
			$pdfFileName = hash("sha256", $formData['id'] . '.pdf');

			if (!file_exists(dirname(__FILE__) . '/../pdf/' . $pdfFileName)) {
				$pdf = new formPDF($formData);
				$pdf->Output(dirname(__FILE__) . '/../pdf/' . $pdfFileName, 'F');
				unset($pdf);
			}

			$bodyHTML = file_get_contents(dirname(__FILE__) . '/../views/_mail_template.php');
			$bodyHTML = $bodyHTML !== false ? $bodyHTML : '__HEADER_IMG__ __HEADER_TITLE__ __BODY__';
			$bodyHTML = utf8_decode($bodyHTML);
			$bodyHTML = str_replace('__HEADER_IMG__', self::$rootURL . '/media/laboratorio-salazar-logo.png', $bodyHTML);
			$bodyHTML = str_replace('__HEADER_TITLE__', 'Your SARS-CoV-2 (COVID-19) test is ready', $bodyHTML);
			$bodyHTML = str_replace(
				'__BODY__',
				"<h2 style='margin: 0 0 .5rem 0;'>Hi " . $formData["first_name"] . " " . $formData["last_name"] . ",</h2>" .
				"<p>Your SARS-CoV-2 (COVID-19) test is ready, you can download from the link below:</p>" .
				"<p><a href='" . self::$rootURL . "/pdf/" . hash("sha256", $formData['id']) . ".pdf' style='display: inline-block; font-weight: 400; line-height: 1.5; color: #212529; text-align: center; text-decoration: none; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; user-select: none; background-color: transparent; border: 1px solid transparent; padding: .375rem .75rem; font-size: 1rem; border-radius: .25rem; transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out; background-color: #09a9f4 !important; border-color: #09a9f4 !important; color: #f8f9fa !important;'>Download results</a></p>" .
				"<p>If you have troubles click on the linke above, you can copy the below url and paste directly to your browser.</p>" .
				"<p style='border-top:1px solid #888888; color:#888888; padding:0.5rem 0;'><code style='word-break: break-all;'>" . str_replace('://', ':<span>//', self::$rootURL) . "/pdf/" . hash("sha256", $formData['id']) . ".pdf</span></p>",
				$bodyHTML
			);

			$newEmail = new phpPDFQREmail();

			if ($newEmail->sendEmail($formData["email"], $subject, $bodyHTML)) {
				$collectionNames['data_success'][] = $formData["email"];
			} else {
				$collectionNames['data_err'][] = $formData["email"];
			}

			unset($newEmail);
		}

		if (sizeof($collectionNames['data_err'])) {
			$collectionNames['message'] = 'Ocurrio un error al enviar los siguientes correos: ' . implode(", ", $collectionNames['data_err']);
		}

		return $collectionNames;
	}
}

$phpPDFQRAPI = new phpPDFQRAPI();

$action = isset($_REQUEST["action"]) ? $_REQUEST["action"] : false;
$itemsId = isset($_REQUEST["itemsId"]) ? $_REQUEST["itemsId"] : [];
$itemsId = is_array($itemsId) ? $itemsId : [];
$dataSent = '{}';

switch ($action) {
	case 'getForms':
		$dataSent = json_decode(json_encode($phpPDFQRAPI::getForms(), JSON_UNESCAPED_UNICODE), true);
		break;
	case 'bulkPDF':
		$phpPDFQRAPI::$phpPDFQRForms = $phpPDFQRForms;
		$dataSent = json_encode($phpPDFQRAPI::bulkPDF($itemsId), JSON_UNESCAPED_UNICODE); break;
	case 'bulkEmail':
		$phpPDFQRAPI::$phpPDFQRForms = $phpPDFQRForms;
		$phpPDFQRAPI::$phpPDFQREmail = $phpPDFQREmail;
		$dataSent = json_encode($phpPDFQRAPI::bulkEmail($itemsId), JSON_UNESCAPED_UNICODE); break;
}

echo $dataSent;
die();
