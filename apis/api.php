<?php
header("Content-Type: application/json;charset=utf-8");

require_once dirname(__FILE__) . '/../config/config.php';
require_once dirname(__FILE__) . '/../config/forms.php';
require_once dirname(__FILE__) . '/../lib/fpdf/fpdf-form.php';


class phpPDFQRAPI extends phpPDFQRConfig
{
	public static $phpPDFQRForms = [];

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
			13 => 'departuredate',
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
			24 => 'updated_at'
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
				"OR `departuredate` LIKE '" . $search_value . "%' " .
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

		$resultsSql = "SELECT `covid_tests`.`id`, `covid_tests`.`first_name`, `covid_tests`.`last_name`, `covid_tests`.`email`, " .
			"`covid_tests`.`birthdate`, `covid_tests`.`sex`, `covid_tests`.`passport`, `covid_tests`.`villa`, " .
			"`covid_tests`.`reservation_number`, `covid_tests`.`departuredate`, `covid_tests`.`book_type`, " .
			"`covid_tests`.`book_family`, `covid_tests`.`test_type`, `covid_tests`.`test_date_taken`, `covid_tests`.`test_date_result`, " .
			"`covid_tests`.`test_result`, `covid_tests`.`test_reference`, `covid_tests`.`test_sample`, `covid_tests`.`test_method`, " .
			"`covid_tests`.`created_at`, `covid_tests`.`updated_at` " .
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
				'<button type="button" class="btn btn-primary" ' .
					'onclick="window.open(\'' . self::$rootURL . '/pdf-generate.php?itemId=' . $row['id'] . '\', \'_blank\');">' .
					'<i class="fas fa-download"></i> &nbsp; <i class="far fa-file-pdf"></i></button>',
				'<button type="button" class="btn btn-primary' . ($disabbled ? ' disabled' : '') . '" ' .
					'onclick="window.open(\'' . self::$rootURL . '/pdf-generate.php?itemId=' . $row['id'] . '\', \'_blank\');">' .
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
				$row['villa'],
				$row['reservation_number'],
				$row['departuredate'],
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
		if ($_SERVER["REQUEST_METHOD"] != "POST") {
			$phpPDFQRForms::Log("Error", "Invalid request by " . $_SESSION['labsal_user']);
			$phpPDFQRForms::flashSet("Error", "Petición inválida al servidor.", "danger");
			header("location: " . $phpPDFQRForms::$rootURL . "/");
			die();
		}

		$collectionNames = [];

		foreach ($itemsId AS $id) {
			$formData = self::$phpPDFQRForms::showForm($id);

			if (!$formData['test_date_result'] || !$formData['test_result']) return;

			$pdf = new formPDF($formData);
			$collectionNames[] = dirname(__FILE__) . '/../pdf/' . $pdf->pdfFilename;
			$pdf->Output(dirname(__FILE__) . '/../pdf/' . $pdf->pdfFilename, 'F');
			unset($pdf);
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
		$dataSent = $phpPDFQRAPI::getForms(); break;
	case 'bulkPDF':
		$phpPDFQRAPI::$phpPDFQRForms = $phpPDFQRForms;
		$dataSent = $phpPDFQRAPI::bulkPDF($itemsId); break;
}

echo json_decode(json_encode($dataSent, JSON_UNESCAPED_SLASHES));